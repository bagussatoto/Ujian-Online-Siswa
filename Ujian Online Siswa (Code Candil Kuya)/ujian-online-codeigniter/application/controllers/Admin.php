<?php 
class Admin extends MY_Controller{
	function __construct(){
        parent::__construct();
		
		if($this->session->userdata('status') != "login" || $this->session->userdata('level') != "admin"){
			redirect(base_url('auth'));
		}
		
        $this->load->model('m_admin');
        
		$msg= null;
		$html= null;
		$json= null;
    }

    public function index()
    {
        $this->content['count_guru']= $this->m_admin->beranda_guru();
        $this->content['count_siswa']= $this->m_admin->beranda_siswa();
        $this->content['count_kelas']= $this->m_admin->beranda_kelas();
        $this->content['count_pelajaran']= $this->m_admin->beranda_pelajaran();
        $this->view= 'admin/index';
        $this->render_pages();
    }

    // start users controller
    public function data_admin()
    {
        $this->content['rows']= $this->m_admin->data_admin();
        $this->view= 'admin/data_admin';
        $this->render_pages();
    }

    public function form_data_admin()
    {
        $this->html= '
        <form action="'.base_url().'admin/data-admin-store" role="form" id="addNew" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Admin</label>
                <input name="nama" type="text" class="form-control" placeholder="*) Masukan Nama" required="">
            </div>
            <div class="form-group">
                <label>No Telp</label>
                <input name="telp" type="telp" class="form-control" placeholder="*) 08123456789" required="">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input name="email" type="text" class="form-control" placeholder="*) email@gmail.com" required="">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input name="username" type="text" class="form-control" placeholder="*) Masukan Username" required="">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input name="password" type="password" class="form-control" placeholder="**********" required="">
            </div>
            <button type="submit" class="btn btn-primary">Publish</button>
        </form>
        ';
        echo $this->html;
    }

    public function data_admin_store()
    {
        $this->m_admin->username= $this->input->post('username');
        if ( $this->m_admin->cek_user() > 0 ) {
            $this->msg= [
                'stats'=> 0,
                'msg'=> 'Maaf Username Sudah Digunakan',
            ];
        } else {
            $this->m_admin->post= $this->input->post();
            $this->m_admin->post['level']= 'admin';
            if ( $this->m_admin->data_admin_store() ) {
                $this->msg= [
                    'stats'=> 1,
                    'msg'=> 'Data Berhasil Ditambahkan',
                ];
            } else {
                $this->msg= [
                    'stats'=> 0,
                    'msg'=> 'Data Gagal Ditambahkan',
                ];
            }
            
        }
        echo json_encode($this->msg);
    }

    public function form_data_admin_edit()
    {
        $this->m_admin->username= $this->uri->segment(3);
        $row= $this->m_admin->data_admin_edit();
        $this->html= '
        <form action="'.base_url().'admin/data-admin-update" role="form" id="edit" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Admin</label>
                <input value="'.$row->nama.'" name="nama" type="text" class="form-control" placeholder="*) Masukan Nama" required="">
            </div>
            <div class="form-group">
                <label>No Telp</label>
                <input value="'.$row->no_telp.'" name="telp" type="telp" class="form-control" placeholder="*) 08123456789" required="">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input value="'.$row->email.'" name="email" type="text" class="form-control" placeholder="*) email@gmail.com" required="">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" rows="3" required>'.$row->alamat.'</textarea>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input readonly value="'.$row->username.'" name="username" type="text" class="form-control" placeholder="*) Masukan Username" required="">
            </div>
            <div class="form-group">
                <label>Password <small>*) Jika tidak diisi password masih sama seperti sebelumnya</small></label>
                <input name="password" type="password" class="form-control" placeholder="**********" >
            </div>
            <button type="submit" class="btn btn-primary">Publish</button>
        </form>
        ';
        echo $this->html;
    }

    public function data_admin_update()
    {
        $this->m_admin->post= $this->input->post();
        if ( $this->m_admin->data_admin_update() ) {
            $this->msg= [
                'stats'=> 1,
                'msg'=> 'Data Berhasil Diubah',
            ];
        } else {
            $this->msg= [
                'stats'=> 0,
                'msg'=> 'Data Gagal Diubah',
            ];
        }
        echo json_encode($this->msg);
    }

    public function data_admin_delete()
    {
        $this->m_admin->username= $this->uri->segment(3);
        if ( $this->m_admin->data_admin_delete() ) {
            $this->msg= [
                'stats'=> 1,
                'msg'=> 'Data Berhasil Dihapus',
            ];
        } else {
            $this->msg= [
                'stats'=> 0,
                'msg'=> 'Data Gagal Dihapus',
            ];
        }
        echo json_encode($this->msg);
    }
        
    public function data_guru()
    {
        $this->content['rows']= $this->m_admin->data_guru();
        $this->content['rows_pbm']= $this->m_admin->get_pelajaran_guru_by_pbm();

        $this->view= 'admin/data_guru';
        $this->render_pages();
    }

    public function form_data_guru()
    {
        $jk= "";
        foreach ($this->m_admin->guru_jk() as $key => $value) {
            $jk .= '
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="jk" value="'.$value.'" required>'.($value=='L' ? 'Laki-Laki' : 'Perempuan' ).'
                    </label>
                </div>
            ';
        }

        $agama= "";
        foreach ($this->m_admin->guru_agama() as $key => $value) {
            $agama .= '
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="agama" value="'.$value.'" required>'.$value.'
                    </label>
                </div>
            ';
        }

        $this->html= '
        <form action="'.base_url().'admin/data-guru-store" role="form" id="addNew" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>NIP</label>
                <input name="nip" type="text" class="form-control" placeholder="*) Masukan NIP" required="">
            </div>
            <div class="form-group">
                <label>Nama Guru</label>
                <input name="nama" type="text" class="form-control" placeholder="*) Masukan Nama" required="">
            </div>
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <div class="form-group">
                    '.$jk.'
                </div>
            </div>
            <div class="form-group">
                <label>Agama</label>
                <div class="form-group">
                    '.$agama.'
                </div>
            </div>
            <div class="form-group">
                <label>Tempat Lahir</label>
                <input name="tempat_lahir" type="text" class="form-control" placeholder="*) Masukan Tempat Lahir" required="">
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input name="tgl_lahir" type="date" class="form-control" placeholder="" required="">
            </div>
            <div class="form-group">
                <label>No Telp</label>
                <input name="telp" type="telp" class="form-control" placeholder="*) 08123456789" required="">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input name="email" type="text" class="form-control" placeholder="*) email@gmail.com" required="">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input name="username" type="text" class="form-control" placeholder="*) Masukan Username" required="">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input name="password" type="password" class="form-control" placeholder="**********" required="">
            </div>
            <div class="form-group">
                <label>Upload Foto <small class="badge badge-info">*) type: JPG atau PNG</small></label>
                <input name="fupload" type="file" class="form-control"  required="">
            </div>
            <button type="submit" class="btn btn-primary">Publish</button>
        </form>
        ';
        echo $this->html;
    }

    public function data_guru_store()
    {
        $this->m_admin->username= $this->input->post('username');
        if ( $this->m_admin->cek_user() > 0 ) {
            $this->msg= [
                'stats'=> 0,
                'msg'=> 'Maaf Username Sudah Digunakan',
            ];
        } else {
            $config['upload_path']          = 'src/guru/';
            $config['allowed_types']        = 'jpg|png';
            // $config['max_size']             = 1000000;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('fupload'))
            {
                $this->msg= [
                    'stats'=>0,
                    'msg'=> $this->upload->display_errors(),
                ];
            }
            else
            {
                $this->m_admin->post= $this->input->post();
                $this->m_admin->post['level']= 'guru';
                $this->m_admin->post['gambar']= $this->upload->data()['file_name'];
                if ( $this->m_admin->data_guru_store() ) {
                    $this->msg= [
                        'stats'=>1,
                        'msg'=> 'Data Berhasil Disimpan',
                    ];
                    
                } else {
                    $this->msg= [
                        'stats'=>0,
                        'msg'=> 'Maaf Data Gagal Disimpan',
                    ];
                }
                
            }
            
        }
        echo json_encode($this->msg);
    }

    public function form_data_guru_edit()
    {
        $this->m_admin->username= $this->uri->segment(3);
        $row= $this->m_admin->data_guru_edit();
        $jk= "";
        foreach ($this->m_admin->guru_jk() as $key => $value) {
            $jk .= '
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input '.($value==$row->jk? 'checked' : null).' type="radio" class="form-check-input" name="jk" value="'.$value.'" required>'.($value=='L' ? 'Laki-Laki' : 'Perempuan' ).'
                    </label>
                </div>
            ';
        }

        $agama= "";
        foreach ($this->m_admin->guru_agama() as $key => $value) {
            $agama .= '
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input '.($value==$row->agama? 'checked' : null).' type="radio" class="form-check-input" name="agama" value="'.$value.'" required>'.$value.'
                    </label>
                </div>
            ';
        }

        $this->html= '
        <form action="'.base_url().'admin/data-guru-update" role="form" id="edit" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>NIP</label>
                <input readonly value="'.$row->nip.'" name="nip" type="text" class="form-control" placeholder="*) Masukan NIP" required="">
            </div>
            <div class="form-group">
                <label>Nama Guru</label>
                <input value="'.$row->nama.'" name="nama" type="text" class="form-control" placeholder="*) Masukan Nama" required="">
            </div>
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <div class="form-group">
                    '.$jk.'
                </div>
            </div>
            <div class="form-group">
                <label>Agama</label>
                <div class="form-group">
                    '.$agama.'
                </div>
            </div>
            <div class="form-group">
                <label>Tempat Lahir</label>
                <input value="'.$row->tempat_lahir.'" name="tempat_lahir" type="text" class="form-control" placeholder="*) Masukan Tempat Lahir" required="">
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input value="'.$row->tgl_lahir.'" name="tgl_lahir" type="date" class="form-control" placeholder="" required="">
            </div>
            <div class="form-group">
                <label>No Telp</label>
                <input value="'.$row->no_telp.'" name="telp" type="telp" class="form-control" placeholder="*) 08123456789" required="">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input value="'.$row->email.'" name="email" type="text" class="form-control" placeholder="*) email@gmail.com" required="">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" rows="3" required>'.$row->alamat.'</textarea>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input readonly value="'.$row->username.'" name="username" type="text" class="form-control" placeholder="*) Masukan Username" required="">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input name="password" type="password" class="form-control" placeholder="**********">
            </div>
            <div class="form-group">
                <label>Foto</label>
                <img class="d-block img-thumbnail" src="'.base_url('src/guru/'.$row->gambar).'">
            </div>
            <div class="form-group">
                <label>Ganti Foto <small class="badge badge-info">*) type: JPG atau PNG</small></label>
                <input name="fupload" type="file" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Publish</button>
        </form>
        ';
        echo $this->html;
    }

    public function data_guru_update()
    {
        $this->m_admin->post= $this->input->post();
        if ( empty($_FILES['fupload']['tmp_name']) ) {
            # code...without upload file
            if ( $this->m_admin->data_guru_update() ) {
                $this->msg= [
                    'stats'=>1,
                    'msg'=> 'Data Berhasil Disimpan'
                ];
            } else {
                $this->msg= [
                    'stats'=>1,
                    'msg'=> 'Data Gagal Disimpan'
                ];
            }
        } else {
            # code...with upload file
            $this->m_admin->username= $this->input->post('username');
            $row= $this->m_admin->data_guru_edit();
            $config['upload_path']          = 'src/guru/';
            $config['allowed_types']        = 'jpg|png';
            if ( file_exists($config['upload_path'].$row->gambar) ) {
                unlink($config['upload_path'].$row->gambar);
            }
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('fupload'))
            {
                $this->msg= [
                    'stats'=>0,
                    'msg'=> $this->upload->display_errors(),
                ];
            }
            else
            {
                $this->m_admin->post['gambar']= $this->upload->data()['file_name'];
                if ( $this->m_admin->data_guru_update() ) {
                    $this->msg= [
                        'stats'=>1,
                        'msg'=> 'Data Berhasil Disimpan',
                    ];
                    
                } else {
                    $this->msg= [
                        'stats'=>0,
                        'msg'=> 'Maaf Data Gagal Disimpan',
                    ];
                }
                
            }
        }
        echo json_encode($this->msg);
    }

    public function data_guru_delete()
    {
        $this->m_admin->username= $this->uri->segment(3);
        $row= $this->m_admin->data_guru_edit();
        $config['upload_path']          = 'src/guru/';
        if ( file_exists($config['upload_path'].$row->gambar) ) {
            unlink($config['upload_path'].$row->gambar);
        }
        if ( $this->m_admin->data_guru_delete() ) {
            $this->msg= [
                'stats'=>1,
                'msg'=> 'Data Berhasil Dihapus',
            ];
        } else {
            $this->msg= [
                'stats'=>0,
                'msg'=> 'Data Gagal Dihapus',
            ];
        }
        echo json_encode($this->msg);
    }
        
    public function data_siswa()
    {
        $this->content['rows']= $this->m_admin->data_siswa();
        $this->content['rows_pbm']= $this->m_admin->get_pelajaran_siswa_by_pbm();
        $this->view= 'admin/data_siswa';
        $this->render_pages();
    }

    public function form_data_siswa()
    {
        $jk= "";
        foreach ($this->m_admin->siswa_jk() as $key => $value) {
            $jk .= '
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="jk" value="'.$value.'" required>'.($value=='L' ? 'Laki-Laki' : 'Perempuan' ).'
                    </label>
                </div>
            ';
        }

        $agama= "";
        foreach ($this->m_admin->siswa_agama() as $key => $value) {
            $agama .= '
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="agama" value="'.$value.'" required>'.$value.'
                    </label>
                </div>
            ';
        }

        $this->html= '
        <form action="'.base_url().'admin/data-siswa-store" role="form" id="addNew" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>NIS</label>
                <input name="nis" type="text" class="form-control" placeholder="*) Masukan NIS" required="">
            </div>
            <div class="form-group">
                <label>Nama Siswa</label>
                <input name="nama" type="text" class="form-control" placeholder="*) Masukan Nama" required="">
            </div>
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <div class="form-group">
                    '.$jk.'
                </div>
            </div>
            <div class="form-group">
                <label>Agama</label>
                <div class="form-group">
                    '.$agama.'
                </div>
            </div>
            <div class="form-group">
                <label>Tempat Lahir</label>
                <input name="tempat_lahir" type="text" class="form-control" placeholder="*) Masukan Tempat Lahir" required="">
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input name="tgl_lahir" type="date" class="form-control" placeholder="" required="">
            </div>
            <div class="form-group">
                <label>No Telp</label>
                <input name="telp" type="telp" class="form-control" placeholder="*) 08123456789" required="">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input name="email" type="text" class="form-control" placeholder="*) email@gmail.com" required="">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input name="username" type="text" class="form-control" placeholder="*) Masukan Username" required="">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input name="password" type="password" class="form-control" placeholder="**********" required="">
            </div>
            <div class="form-group">
                <label>Upload Foto <small class="badge badge-info">*) type: JPG atau PNG</small></label>
                <input name="fupload" type="file" class="form-control"  required="">
            </div>
            <button type="submit" class="btn btn-primary">Publish</button>
        </form>
        ';
        echo $this->html;
    }

    public function data_siswa_store()
    {
        $this->m_admin->username= $this->input->post('username');
        if ( $this->m_admin->cek_user() > 0 ) {
            $this->msg= [
                'stats'=> 0,
                'msg'=> 'Maaf Username Sudah Digunakan',
            ];
        } else {
            $config['upload_path']          = 'src/siswa/';
            $config['allowed_types']        = 'jpg|png';
            // $config['max_size']             = 1000000;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('fupload'))
            {
                $this->msg= [
                    'stats'=>0,
                    'msg'=> $this->upload->display_errors(),
                ];
            }
            else
            {
                $this->m_admin->post= $this->input->post();
                $this->m_admin->post['level']= 'siswa';
                $this->m_admin->post['gambar']= $this->upload->data()['file_name'];
                if ( $this->m_admin->data_siswa_store() ) {
                    $this->msg= [
                        'stats'=>1,
                        'msg'=> 'Data Berhasil Disimpan',
                    ];
                    
                } else {
                    $this->msg= [
                        'stats'=>0,
                        'msg'=> 'Maaf Data Gagal Disimpan',
                    ];
                }
                
            }
            
        }
        echo json_encode($this->msg);
    }

    public function form_data_siswa_edit()
    {
        $this->m_admin->username= $this->uri->segment(3);
        $row= $this->m_admin->data_siswa_edit();
        $jk= "";
        foreach ($this->m_admin->siswa_jk() as $key => $value) {
            $jk .= '
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input '.($value==$row->jk? 'checked' : null).' type="radio" class="form-check-input" name="jk" value="'.$value.'" required>'.($value=='L' ? 'Laki-Laki' : 'Perempuan' ).'
                    </label>
                </div>
            ';
        }

        $agama= "";
        foreach ($this->m_admin->siswa_agama() as $key => $value) {
            $agama .= '
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input '.($value==$row->agama? 'checked' : null).' type="radio" class="form-check-input" name="agama" value="'.$value.'" required>'.$value.'
                    </label>
                </div>
            ';
        }

        $this->html= '
        <form action="'.base_url().'admin/data-siswa-update" role="form" id="edit" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>NIS</label>
                <input readonly value="'.$row->nis.'" name="nis" type="text" class="form-control" placeholder="*) Masukan NIS" required="">
            </div>
            <div class="form-group">
                <label>Nama Siswa</label>
                <input value="'.$row->nama.'" name="nama" type="text" class="form-control" placeholder="*) Masukan Nama" required="">
            </div>
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <div class="form-group">
                    '.$jk.'
                </div>
            </div>
            <div class="form-group">
                <label>Agama</label>
                <div class="form-group">
                    '.$agama.'
                </div>
            </div>
            <div class="form-group">
                <label>Tempat Lahir</label>
                <input value="'.$row->tempat_lahir.'" name="tempat_lahir" type="text" class="form-control" placeholder="*) Masukan Tempat Lahir" required="">
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input value="'.$row->tgl_lahir.'" name="tgl_lahir" type="date" class="form-control" placeholder="" required="">
            </div>
            <div class="form-group">
                <label>No Telp</label>
                <input value="'.$row->no_telp.'" name="telp" type="telp" class="form-control" placeholder="*) 08123456789" required="">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input value="'.$row->email.'" name="email" type="text" class="form-control" placeholder="*) email@gmail.com" required="">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" rows="3" required>'.$row->alamat.'</textarea>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input readonly value="'.$row->username.'" name="username" type="text" class="form-control" placeholder="*) Masukan Username" required="">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input name="password" type="password" class="form-control" placeholder="**********">
            </div>
            <div class="form-group">
                <label>Foto</label>
                <img class="d-block img-thumbnail" src="'.base_url('src/siswa/'.$row->gambar).'">
            </div>
            <div class="form-group">
                <label>Ganti Foto <small class="badge badge-info">*) type: JPG atau PNG</small></label>
                <input name="fupload" type="file" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Publish</button>
        </form>
        ';
        echo $this->html;
    }

    public function data_siswa_update()
    {
        $this->m_admin->post= $this->input->post();
        if ( empty($_FILES['fupload']['tmp_name']) ) {
            # code...without upload file
            if ( $this->m_admin->data_siswa_update() ) {
                $this->msg= [
                    'stats'=>1,
                    'msg'=> 'Data Berhasil Disimpan'
                ];
            } else {
                $this->msg= [
                    'stats'=>1,
                    'msg'=> 'Data Gagal Disimpan'
                ];
            }
        } else {
            # code...with upload file
            $this->m_admin->username= $this->input->post('username');
            $row= $this->m_admin->data_siswa_edit();
            $config['upload_path']          = 'src/siswa/';
            $config['allowed_types']        = 'jpg|png';
            if ( file_exists($config['upload_path'].$row->gambar) ) {
                unlink($config['upload_path'].$row->gambar);
            }
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('fupload'))
            {
                $this->msg= [
                    'stats'=>0,
                    'msg'=> $this->upload->display_errors(),
                ];
            }
            else
            {
                $this->m_admin->post['gambar']= $this->upload->data()['file_name'];
                if ( $this->m_admin->data_siswa_update() ) {
                    $this->msg= [
                        'stats'=>1,
                        'msg'=> 'Data Berhasil Disimpan',
                    ];
                    
                } else {
                    $this->msg= [
                        'stats'=>0,
                        'msg'=> 'Maaf Data Gagal Disimpan',
                    ];
                }
                
            }
        }
        echo json_encode($this->msg);
    }

    public function data_siswa_delete()
    {
        $this->m_admin->username= $this->uri->segment(3);
        $row= $this->m_admin->data_siswa_edit();
        $config['upload_path']          = 'src/siswa/';
        if ( file_exists($config['upload_path'].$row->gambar) ) {
            unlink($config['upload_path'].$row->gambar);
        }
        if ( $this->m_admin->data_siswa_delete() ) {
            $this->msg= [
                'stats'=>1,
                'msg'=> 'Data Berhasil Dihapus',
            ];
        } else {
            $this->msg= [
                'stats'=>0,
                'msg'=> 'Data Gagal Dihapus',
            ];
        }
        echo json_encode($this->msg);
    }

    public function data_profil()
    {
        $this->m_admin->username= $this->session->userdata('username');
        $this->content['row']= $this->m_admin->data_admin_edit();
        $this->view= 'admin/profil';
        $this->render_pages();
    }
    // end users controller

    // start akademik controller
    public function data_kelas()
    {
        $this->content['rows']= $this->m_admin->data_kelas();
        $this->view= 'admin/data_kelas';
        $this->render_pages();
    }
    public function form_data_kelas()
    {
        $this->html= '
        <form action="'.base_url().'admin/data-kelas-store" role="form" id="addNew" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Kelas</label>
                <input name="nama_kelas" type="text" class="form-control" placeholder="*) Masukan Nama Kelas" required="">
            </div>
            <button type="submit" class="btn btn-primary">Publish</button>
        </form>
        ';
        echo $this->html;
    }
    public function data_kelas_store()
    {
        $this->m_admin->post= $this->input->post();
        if ( $this->m_admin->data_kelas_store() ) {
            $this->msg= [
                'stats'=>1,
                'msg'=>'Data Berhasil Ditambahkan',
            ];
        } else {
            $this->msg= [
                'stats'=>1,
                'msg'=>'Data Berhasil Ditambahkan',
            ];
        }
        echo json_encode($this->msg);
    }
    public function form_data_kelas_edit()
    {
        $this->m_admin->id_kelas= $this->uri->segment(3);
        $row= $this->m_admin->data_kelas_edit();
        $this->html= '
        <form action="'.base_url().'admin/data-kelas-update" role="form" id="edit" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Kelas</label>
                <input value="'.$row->nama_kelas.'" name="nama_kelas" type="text" class="form-control" placeholder="*) Masukan Nama Kelas" required="">
            </div>
            <input value="'.$row->id_kelas.'" type="hidden" name="id_kelas">
            <button type="submit" class="btn btn-primary">Publish</button>
        </form>
        ';
        echo $this->html;
    }
    public function data_kelas_update()
    {
        $this->m_admin->post= $this->input->post();
        if ( $this->m_admin->data_kelas_update() ) {
            $this->msg= [
                'stats'=>1,
                'msg'=>'Data Berhasil Diubah',
            ];
        } else {
            $this->msg= [
                'stats'=>0,
                'msg'=>'Data Gagal Diubah',
            ];
        }
        echo json_encode($this->msg);
    }
    public function data_kelas_delete()
    {
        $this->m_admin->id_kelas= $this->uri->segment(3);
        if ( $this->m_admin->data_kelas_delete() ) {
            $this->msg= [
                'stats'=>1,
                'msg'=>'Data Berhasil Dihapus',
            ];
        } else {
            $this->msg= [
                'stats'=>0,
                'msg'=>'Data Gagal Dihapus',
            ];
        }
        echo json_encode($this->msg);
    }
    public function search_siswa()
    {
        $this->html= "";
        $tbody= "";
        $no=1;
        foreach ($this->m_admin->search_siswa_by_kelas($this->uri->segment(3)) as $key => $value) {
            $tbody .= "
                <tr>
                    <td>{$no}</td>
                    <td>{$value->nis}</td>
                    <td>{$value->nama}</td>
                </tr>
            ";
            $no++;
        }
        $this->html .='
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>NIS</th>
                  <th>Nama</th>
                </tr>
                </thead>
                <tbody>
                    '.$tbody.'
                </tbody>
            </table>
        ';
        print_r($this->html);
        
    }
    public function data_pelajaran()
    {
        $this->content['rows']= $this->m_admin->data_pelajaran();
        $this->view= 'admin/data_pelajaran';
        $this->render_pages();
    }
    public function form_data_pelajaran()
    {
        $this->html= '
        <form action="'.base_url().'admin/data-pelajaran-store" role="form" id="addNew" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Pelajaran</label>
                <input name="nama_pelajaran" type="text" class="form-control" placeholder="*) Masukan Nama Pelajaran" required="">
            </div>
            <div class="form-group">
                <label>Kelas</label>
                <select name="id_kelas" class="form-control" required="">
                    <option value="" selected disabled> -- Pilih Kelas -- </option>
        ';
                    foreach ($this->m_admin->data_kelas() as $key => $value) {
                        $this->html .= '
                        <option value="'.$value->id_kelas.'">'.$value->nama_kelas.'</option>
                        ';
                    }
        $this->html .= '
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Publish</button>
        </form>
        ';
        echo $this->html;
    }
    public function data_pelajaran_store()
    {
        $this->m_admin->post= $this->input->post();
        if ( $this->m_admin->data_pelajaran_store() ) {
            $this->msg= [
                'stats'=>1,
                'msg'=>'Data Berhasil Ditambahkan',
            ];
        } else {
            $this->msg= [
                'stats'=>1,
                'msg'=>'Data Berhasil Ditambahkan',
            ];
        }
        echo json_encode($this->msg);
    }
    public function form_data_pelajaran_edit()
    {
        $this->m_admin->id_pelajaran= $this->uri->segment(3);
        $row= $this->m_admin->data_pelajaran_edit();
        $this->html= '
        <form action="'.base_url().'admin/data-pelajaran-update" role="form" id="edit" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Pelajaran</label>
                <input value="'.$row->nama_pelajaran.'" name="nama_pelajaran" type="text" class="form-control" placeholder="*) Masukan Nama Pelajaran" required="">
            </div>
            <div class="form-group">
                <label>Kelas</label>
                <select name="id_kelas" class="form-control" required="">
                    <option value="" disabled> -- Pilih Kelas -- </option>
        ';
                    foreach ($this->m_admin->data_kelas() as $key => $value) {
                        $this->html .= '
                        <option '.($value->id_kelas==$row->id_kelas? 'selected' : null ).' value="'.$value->id_kelas.'">'.$value->nama_kelas.'</option>
                        ';
                    }
        $this->html .= '
                </select>
            </div>
            <input value="'.$row->id_pelajaran.'" type="hidden" name="id_pelajaran">
            <button type="submit" class="btn btn-primary">Publish</button>
        </form>
        ';
        echo $this->html;
    }
    public function data_pelajaran_update()
    {
        $this->m_admin->post= $this->input->post();
        if ( $this->m_admin->data_pelajaran_update() ) {
            $this->msg= [
                'stats'=>1,
                'msg'=>'Data Berhasil Diubah',
            ];
        } else {
            $this->msg= [
                'stats'=>0,
                'msg'=>'Data Gagal Diubah',
            ];
        }
        echo json_encode($this->msg);
    }
    public function data_pelajaran_delete()
    {
        $this->m_admin->id_pelajaran= $this->uri->segment(3);
        if ( $this->m_admin->data_pelajaran_delete() ) {
            $this->msg= [
                'stats'=>1,
                'msg'=>'Data Berhasil Dihapus',
            ];
        } else {
            $this->msg= [
                'stats'=>0,
                'msg'=>'Data Gagal Dihapus',
            ];
        }
        echo json_encode($this->msg);
    }
    public function data_pbm()
    {
        $this->content['rows']= $this->m_admin->data_pbm();
        $this->view= 'admin/data_pbm';
        $this->render_pages();
    }
    public function form_data_pbm()
    {
        $this->html= '
        <form action="'.base_url().'admin/data-pbm-store" role="form" id="addNew" method="post" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="inputPelajaran">Tahun Ajaran</label>
                    <input name="tahun_ajaran" type="text" class="form-control" placeholder="*) Masukan Tahun Ajaran" required="">
                </div>
                <div class="form-group">
                    <label for="inputPelajaran">NIS <small id="alertInputNis"></small></label>
                    <input name="nis" type="text" class="form-control" id="inputNis" placeholder="*) Masukan Nomor Induk Siswa" required="">
                </div>
                <div class="form-group">
                    <label for="inputPelajaran">Pelajaran</label>
                    <select id="inputPelajaran" name="id_pelajaran" class="form-control" required="">
                        <option value="" selected disabled> -- Pilih Pelajaran -- </option>
        ';
                        foreach ($this->m_admin->data_pelajaran() as $key => $value) {
                            $this->html .= '
                                <option value="'.$value->id_pelajaran.'">('.$value->nama_kelas.') '.$value->nama_pelajaran.'</option>
                            ';
                        }
        $this->html .= '
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputPelajaran">Guru</label>
                    <select name="nip" class="form-control" required="">
                        <option value="" selected disabled> -- Pilih Guru -- </option>
        ';
                        foreach ($this->m_admin->data_guru() as $key => $value) {
                            $this->html .= '
                                <option value="'.$value->nip.'">'.$value->nama.'</option>
                            ';
                        }
        $this->html .= '
                    </select>
                </div>
            </div>
            <!-- /.card-body -->
        ';
        $this->html.= '
            
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Publish</button>
            </div>
        </form>
        ';
        echo $this->html; 
    }

    public function data_pbm_cek_nis(){
        $this->m_admin->post= [];
        $this->m_admin->post['nis']= $this->input->get('nis');
        if ( $this->m_admin->data_pbm_cek_nis()->num_rows() > 0 ) {
            # code...
            $this->msg= [
                'stats'=>1,
                'msg'=> 'Siswa dengan NIS '.$this->input->get('nis').' berhasil ditemukan',
                'nis'=> $this->m_admin->data_pbm_cek_nis()->row()->nis,
            ];
        } else {
            # code...
            $this->msg= [
                'stats'=>0,
                'msg'=> 'Siswa dengan NIS '.$this->input->get('nis').' tidak ditemukan'
            ];
        }
        echo json_encode($this->msg );
    }
    
    public function data_pbm_pelajaran(){
        $this->m_admin->nis= $this->input->get('nis');
        $this->html= '<option value="" selected disabled> -- Pilih Pelajaran -- </option>';
        foreach ($this->m_admin->data_pbm_pelajaran() as $key => $value) {
            # code...
            $this->html.= '<option value="'.$value->id_pelajaran.'" > ('.$value->nama_kelas.') '.$value->nama_pelajaran.'</option>';
        }
        echo $this->html;
	}
    
    public function data_pbm_store()
    {
        $this->m_admin->post= $this->input->post();
        if ( $this->m_admin->data_pbm_cek_nis()->num_rows() > 0 ) {
            $this->m_admin->post['nis']= $this->m_admin->data_pbm_cek_nis()->row()->nis;
            if ( $this->m_admin->data_pbm_store() ) {
                # code...
                $this->msg=[
                    'stats'=>1,
                    'msg'=> 'Data Berhasil Disimpan',
                ];
            } else {
                # code...
                $this->msg=[
                    'stats'=>0,
                    'msg'=> 'Data Gagal Disimpan',
                ];
            }
            
        } else {
            $this->msg=[
                'stats'=>0,
                'msg'=> 'Maaf Siswa dengan Nis '.$this->input->post('nis').' belum terdaftar',
            ];
            # code...
        }
        echo json_encode($this->msg);
        // echo json_encode($this->m_admin->post);
    }
    // end akademik controller
}