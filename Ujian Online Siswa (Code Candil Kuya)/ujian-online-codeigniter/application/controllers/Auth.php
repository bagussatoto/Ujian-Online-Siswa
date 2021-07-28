<?php
class Auth extends CI_Controller{
 
    function __construct(){
        parent::__construct();		
        $this->load->model('m_auth');

    }

    function index(){
        $this->load->view('login');
    }

    function process(){
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));
        
        $where_users = array(
            'username' => $username,
            'password' => $password
        );
        
        $cek_users  = $this->m_auth->check_auth("users",$where_users)->num_rows();
        // print_r($cek_users);
        // die();
        
        if ( $cek_users > 0 ) {
            # code...
            $row  = $this->m_auth->check_auth("users",$where_users)->row();
            $data_session = array(
                'username'  => $username,
                'password'  => $password,
                'level'     => $row->level,
                'status'     => 'login',
            );
            
            $this->session->set_userdata($data_session);
            $url=[
                'admin' => 'admin',
                'guru' => 'guru',
                'guru_kep_lab' => 'guru-kep-lab',
                'siswa' => 'siswa',
            ];
            redirect(base_url( $url[$this->session->userdata('level')] ));
        }
        
        else{
            
            $this->session->set_flashdata('msg', 'Maaf! Username atau Password anda salah!');
            redirect(base_url('auth'));
        }
    }

    function logout(){
        $this->session->sess_destroy();
        redirect(base_url('auth'));
    }
}