<?php
class MY_Controller extends CI_Controller{
	function __construct(){
		parent::__construct();
    }
    function render_pages()
    {
        $this->load->view('header');
        $nav=[
            'admin' => 'admin/nav',
            'guru' => 'guru/nav',
            'guru_kep_lab' => 'guru_kep_lab/nav',
            'siswa' => 'siswa/nav',
        ];
        $this->load->view($nav[ $this->session->userdata('level') ]);
        $this->load->view($this->view, (empty($this->content)? [] : $this->content ) );
        $this->load->view('footer');
    }
}