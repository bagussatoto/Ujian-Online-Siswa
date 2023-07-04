<?php 
class Guru_kep_lab extends MY_Controller{
	function __construct(){
        parent::__construct();
		
		if($this->session->userdata('status') != "login" && $this->session->userdata('level') != "guru_kep_lab"){
			redirect(base_url('auth'));
		}
		
        $this->load->model('m_kep_lab');
        
		$msg= null;
		$html= null;
		$json= null;
    }

    public function index()
    {
        $this->content['grup_soal_count']= count($this->m_kep_lab->grup_soal());
        $this->content['soal_count']= count($this->m_kep_lab->soal());
        $this->view= 'guru_kep_lab/index';
        $this->render_pages();
    }

/* start profil */
    public function profil()
    {
        $this->m_kep_lab->username= $this->session->userdata('username');
        // print_r($this->)
        $this->content['row']   = $this->m_kep_lab->edit_profil ();
        $this->content['jk']    = $this->m_kep_lab->guru_jk();
        $this->content['agama'] = $this->m_kep_lab->guru_agama();
        $this->content['pelajaran'] = $this->m_kep_lab->get_pelajaran_by_username();
        
        $this->view= 'guru_kep_lab/profil';
        $this->render_pages();
    }
    public function edit_profil()
    {
        $this->m_kep_lab->username= $this->session->userdata('username');
        $row= $this->m_kep_lab->edit_profil();
        $jk= "";
        foreach ($this->m_kep_lab->guru_jk() as $key => $value) {
            $jk .= '
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input '.($value==$row->jk? 'checked' : null).' type="radio" class="form-check-input" name="jk" value="'.$value.'" required>'.($value=='L' ? 'Laki-Laki' : 'Perempuan' ).'
                    </label>
                </div>
            ';
        }

        $agama= "";
        foreach ($this->m_kep_lab->guru_agama() as $key => $value) {
            $agama .= '
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input '.($value==$row->agama? 'checked' : null).' type="radio" class="form-check-input" name="agama" value="'.$value.'" required>'.$value.'
                    </label>
                </div>
            ';
        }

        $this->html= '
        <form action="'.base_url().'guru-kep-lab/update-profil" role="form" id="edit" method="post" enctype="multipart/form-data">
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
    public function update_profil()
    {
        $this->m_kep_lab->post= $this->input->post();
        if ( empty($_FILES['fupload']['tmp_name']) ) {
            # code...without upload file
            if ( $this->m_kep_lab->update_profil() ) {
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
            $this->m_kep_lab->username= $this->input->post('username');
            $row= $this->m_kep_lab->edit_profil();
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
                $this->m_kep_lab->post['gambar']= $this->upload->data()['file_name'];
                if ( $this->m_kep_lab->update_profil() ) {
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
 /* end profil */

    public function grup_soal()
    {
        
        $this->view= 'guru_kep_lab/data_grup_soal';
        $this->content['rows']= $this->m_kep_lab->grup_soal();
        $this->render_pages();
    }
    public function add_grup_soal()
    {
        $pelajaran= "";
        foreach ($this->m_kep_lab->data_grup_soal_pelajaran() as $key => $value) {
            $pelajaran .= '<option value="'.$value->id_pelajaran.'">('.$value->nama_kelas.') '.$value->nama_pelajaran.'</option>';
        }

        $this->html= '
        <form action="'.base_url().'guru-kep-lab/store-grup-soal" role="form" id="addNew" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Grup Soal</label>
                <input name="nama_grup_soal" type="text" class="form-control" placeholder="*) Masukan Nama Grup Soal" required="">
            </div>
            <div class="form-group">
                <label>Pelajaran</label>
                <select name="id_pelajaran" class="form-control" required>
                    <option value="" selected disabled> -- Pilih Pelajaran -- </option>
                    '.$pelajaran.'
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Publish</button>
        </form>
        ';
        echo $this->html;
    }
    public function store_grup_soal()
    {
        $this->m_kep_lab->post= $this->input->post();
        if ( $this->m_kep_lab->store_grup_soal() ) {
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
/* end grup soal */

/* start ujian grup soal */
    public function ujian_grup_soal()
    {
        $this->view= 'guru_kep_lab/data_ujian_grup_soal';
        $this->content['rows']= $this->m_kep_lab->ujian_grup_soal();
        $this->render_pages();
    }
    public function add_ujian_grup_soal()
    {
        $metode= "";
        $_metode=['LCG','SQL RANDOM'];
        foreach ($_metode as $key => $value) {
            $metode .= '
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input metode" name="metode" value="'.$value.'" required>'.$value.'
                    </label>
                </div>
            ';
        }
        $grup_soal= "";
        foreach ($this->m_kep_lab->ujian_grup_soal() as $key => $value) {
            if( $value->jumlah_soal > 40)
                $grup_soal .= '<option tot="'.$value->jumlah_soal.'" value="'.$value->id_grup_soal.'"> '.$value->nama_grup_soal.' ('.$value->nama_kelas.') '.$value->nama_pelajaran.'</option>';
        }
    
        $this->html= '
        <form action="'.base_url().'guru-kep-lab/store-ujian-grup-soal" role="form" id="addNew" method="post" enctype="multipart/form-data">
            <input type="hidden" name="total_soal" id="total_soal">    
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Jumlah Soal Tiap Siswa</label>
                        <input min="1" id="jumlah" type="number" name="jumlah_soal" class="form-control" placeholder="Masukan Jumlah Soal Tiap Siswa Ex: 40" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Jumlah Siswa</label>
                        <input min="1" id="jumlah_siswa" type="number" name="jumlah_siswa" class="form-control" placeholder="Masukan Jumlah Siswa Yang Akan Diuji Ex: 40" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Pilih Grup Soal</label>
                        <select name="id_grup_soal" id="id_grup_soal" class="form-control" required>
                            <option value="" selected disabled> -- Pilih Grup Soal -- </option>
                            '.$grup_soal.'
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Pilih Metode Acak</label>
                            <div class="form-group">
                            '.$metode.'
                        </div>
                    </div>
                </div>
            </div>
            <div id="formula"></div>
            <hr>
            <button id="tesMetode" type="button" class="btn btn-block btn-outline-primary btn-flat">Coba Acak</button>
            <hr>
            <div id="tryMetode"></div>
            </hr>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Tanggal Dan Waktu Mulai Ujian</label>
                        <input type="datetime-local" name="bdaytime" class="form-control bdaytime" required="">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Waktu Lama Ujian(menit)</label>
                        <input value="0" min="10" type="number" name="bminutes" class="form-control bminutes" required="" placeholder="ex: 30">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="alert alert-info info-ujian text-center" style="display: none">
                        
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Publish</button>
        </form>
        ';
        echo $this->html;
    }
    public function store_ujian_grup_soal()
    {
        $this->m_kep_lab->post= $this->input->post();
        if ( $this->m_kep_lab->store_ujian_grup_soal() ) {
            $this->msg= [
                'stats'=>1,
                'msg'=>'Informasi jadwal ujian berhasil dibuat',
            ];
        } else {
            $this->msg= [
                'stats'=>0,
                'msg'=>'Informasi jadwal ujian gagal dibuat',
            ];
        }
        echo json_encode($this->msg);
        
    }
/* end ujian grup soal */


    public function data_ujian_grup_soal_update()
    {
        switch ( $this->session->userdata('level') ) {
            case 'admin':
                # code...
                echo "admin";
                break;
            
            case 'guru':
                # code...
                echo "guru";
                break;
            
            case 'siswa':
                # code...
                echo "siswa";
                break;
            
            
            default:
                # code...
                break;
        }
    }

    public function data_ujian_grup_soal_delete()
    {
        switch ( $this->session->userdata('level') ) {
            case 'admin':
                # code...
                echo "admin";
                break;
            
            case 'guru':
                # code...
                echo "guru";
                break;
            
            case 'siswa':
                # code...
                echo "siswa";
                break;
            
            
            default:
                # code...
                break;
        }
    }

/* start soal */
    public function soal()
    {
        $this->content['rows']= $this->m_kep_lab->soal();
        $this->view= 'guru/data_soal';
        $this->render_pages();
    }
    public function add_data_soal()
    {
        $grup_soal= "";
        foreach ($this->m_kep_lab->soal_grup_soal() as $key => $value) {
            $grup_soal .= '<option value="'.$value->id_grup_soal.'">'.$value->nama_grup_soal.' ('.$value->nama_kelas.') '.$value->nama_pelajaran.'</option>';
        }
    
        // $jawaban= 
        $jawaban= "";
        foreach ($this->m_kep_lab->soal_jawaban() as $key => $value) {
            $jawaban .= '
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="jawaban" value="'.$value.'" required>'.$value.'
                    </label>
                </div>
            ';
        }
    
        $this->html= '
        <form action="'.base_url().'guru-kep-lab/store-soal" role="form" id="addNew" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Soal</label>
                <textarea name="soal" class="form-control" rows="5" required="" placeholder="*) Masukan Soal"></textarea>
            </div>
            <div class="form-group">
                <label>Pilihan A</label>
                <textarea name="a" class="form-control" rows="5" required="" placeholder="*) Masukan Pilihan A"></textarea>
            </div>
            <div class="form-group">
                <label>Pilihan B</label>
                <textarea name="b" class="form-control" rows="5" required="" placeholder="*) Masukan Pilihan B"></textarea>
            </div>
            <div class="form-group">
                <label>Pilihan C</label>
                <textarea name="c" class="form-control" rows="5" required="" placeholder="*) Masukan Pilihan C"></textarea>
            </div>
            <div class="form-group">
                <label>Pilihan D</label>
                <textarea name="d" class="form-control" rows="5" required="" placeholder="*) Masukan Pilihan D"></textarea>
            </div>
            <div class="form-group">
                <label>Pilih Grup Soal</label>
                <select name="id_grup_soal" class="form-control" required>
                    <option value="" selected disabled> -- Pilih Grup Soal -- </option>
                    '.$grup_soal.'
                </select>
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label>Jawaban Benar</label>
                    <div class="form-group">
                        '.$jawaban.'
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Publish</button>
        </form>
        ';
        echo $this->html;
    }
    public function store_soal()
    {
        $this->m_kep_lab->post= $this->input->post();
        if ( $this->m_kep_lab->store_soal() ) {
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
/* end soal */    
    
/* ==================== start Controller Menu Ujian ==================== */
    public function bilangan_prima($limit)
    {
        $this->result=[];
        for ($i=1; $i <= $limit ; $i++) {     // for 1, adalah bilangan yang akan di cek
        
            $t = 0;  
        
                for ($j=1; $j <= $i ; $j++) {  // for 2, bilangan pembagi 
        
                    if ($i % $j == 0) { 
                        $t++;
                    }
                
                }
        
            if ($t == 2) {   // syarat atau kondisi bilangan prima
                $this->result[]=$i;
            }
        }
        return $this->result;
    }
    public function pilihan_bilangan_prima()
    {
        $prima= "";
        foreach ( $this->bilangan_prima($this->input->get('jumlah_soal') ) as $value) {
            $prima .= '<option value="'.$value.'" >'.$value.'</option>';
        }
        $this->html= '
            <div class="form-group">
                <label>Pilih Bilangan Prima</label>
                <select id="bilPrima" name="bil_prima" class="form-control" required>
                    <option value="" selected disabled> -- Pilih Bilangan Prima -- </option>
                    '.$prima.'
                </select>
            </div>
        ';
        echo $this->html;
    }
    public function get_hasil_pengujian($jumlah_siswa,$jumlah_soal,$xn)
    {
        $this->html='';
        $th='<td>No</td>';# header table
        for ($i=1; $i < ($jumlah_siswa +1) ; $i++) { 
            $th .= '<td>Siswa '.$i.'</td>';
        }
        
        $tr_array= [];
        for ($j=1; $j < ($jumlah_soal +1) ; $j++) {
            for ($i=1; $i < ($jumlah_siswa +1)  ; $i++) { 
                $tr_array[$j][$i]=0;
            }
        }
        
        $siswa_array= [];
        foreach ($xn as $key => $value) {
            $sub=[];
            $key_mod=1;
            foreach ($xn as $key_sub => $value_sub) {
                // $sub[$key_sub]= ( $value_sub[$key]==0 )? 50 : $value_sub[$key] ;
                $sub[$key_mod]= $value_sub ;
                $key_mod++;
            }
            $siswa_array[$key]= [
                'siswa'=>$key,
                'soal'=>$sub,
            ];
        }
        
        # ganti data tr_array dengan siswa array
        /* foreach ($siswa_array as $key => $value) {
            foreach ($value['soal'] as $key_sub => $value_sub) {
                
                if ( $value_sub[$value['siswa']]==0 ) {
                    # if index soal sama dengan 0
                    $tr_array[50][$value['siswa']]= +1;
                } else {
                    # code...
                    $tr_array[$value_sub[$value['siswa']]+1 ][$value['siswa']]= +1;
                }
                
            }
        } */
        // for ($i=1; $i < $this->get->input('jumlah_soal')+1 ; $i++) { 
        //     # code...
        // }
        foreach ($xn as $key => $value) { #loop 1-total soal
            foreach ($value as $key_sub => $value_sub) { # loop 1-jumlah siswa
                // $no_soal= ($value_sub==0? 50 : $value_sub );
                $no_soal= ($value_sub==0? $this->input->get('total_soal') : $value_sub );
                $tr_array[$no_soal][$key_sub] ++;
            }
        }
        // echo '<pre>';
        // print_r($th);
        // print_r($tr_array);
        // print_r($siswa_array);
        // print_r($jumlah_siswa);
        // print_r($xn);
        // echo '<pre>';
        // die();

        # generate tr body table
        $tr='';
        foreach ($tr_array as $key => $value) {
            $tr .= '
                <tr>
                    <td>Soal '.$key.'</td>
            ';
            foreach ($value as $key_sub => $value_sub) {
                $tr .= '<td>' .$value_sub .'</td>';
            }
            $tr .= '</tr>';
        }
        
        
        return $this->html .= '
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        '.$th.'
                    </tr>
                </thead>
                <tbody>
                    '.$tr.'
                </tbody>
            </table>
        </div>
        ';
    }
    /* mendapatkan soal berdasarkan grup soal */
    public function get_soal($id_grup_soal)
    {
        $this->m_kep_lab->post['id_grup_soal']= $id_grup_soal;
        // $no=1;
        $this->html='';
        foreach ($this->m_kep_lab->get_soal() as $key => $value) {
            $this->html .= "
                <tr>
                    <td>{$value->id_mod}</td>
                    <td>{$value->soal}</td>
                </tr>
            ";
            // $no++;
        }
        return $this->html;
        // echo "<table>$this->html</table>";
        // echo '<pre>';
        // print_r($this->m_kep_lab->get_soal());
        // echo '</pre>';
    }
    /* end mendapatkan soal berdasarkan grup soal */

    public function try_metode_acak()
    {
        if( $this->input->get('metode')=='LCG' ){
            
            $lcg= [];
            $xn= [];
            $tr= '';

            /* generate th */
            $th= '';
            for ($s=1; $s < ($this->input->get('jumlah_siswa')+1) ; $s++) {
                $th.= "<th>Siswa $s</th>";
            }

            $_lcg= [
                'b'=> $this->input->get('bil_prima'),
                'm'=> $this->input->get('total_soal')
            ];

            $this->benchmark->mark('code_start'); # mulai waktu pengacakan metode LCG
            for ($i=1; $i < ($this->input->get('jumlah_soal')+1) ; $i++) {
                $tr.= '<tr>';
                $tr.= "<td>$i</td>"; 
                for ($j=1; $j < ($this->input->get('jumlah_siswa')+1) ; $j++) {
                    if ( $i==1 ) {
                        $lcg[$i][$j]= ( (1* $j )+ $_lcg['b'] ) % $_lcg['m'];
                        $xn[$i][$j]= $lcg[$i][$j];
                        $tr.= "<td>X".($i)."=( (1*{$j})+ {$_lcg['b']}) mod {$_lcg['m']}= {$lcg[$i][$j]} </td>";
                    }
                    else {
                        $lcg[$i][$j]= ( (1* $xn[($i-1)][$j] )+ $_lcg['b'] ) % $_lcg['m'];
                        $xn[$i][$j]= $lcg[$i][$j];
                        $tr.= "<td>X ($i) =( (1*{$xn[($i-1)][$j]})+ {$_lcg['b']}) mod {$_lcg['m']}= {$lcg[$i][$j]} </td>";
                    }
                }

                $tr.= '<tr>';
            }
            // echo "<pre>";
            // print_r($xn);
            // echo "</pre>";
            $this->benchmark->mark('code_end'); # selesai waktu pengacakan metode LCG
            
            $_get_hasil_pengujian= [
                'jumlah_siswa'=> ($this->input->get('jumlah_siswa')),
                'jumlah_soal'=> ($this->input->get('total_soal')),
                'xn'=> $xn
            ];
            // echo '<pre>';
            // print_r( $this->get_hasil_pengujian($_get_hasil_pengujian['jumlah_siswa'] ,$_get_hasil_pengujian['jumlah_soal'] ,$_get_hasil_pengujian['xn']) );
            // echo '</pre>';
            // die();
            $this->html= '
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home">Percobaan Metode</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu1">Hasil Pengujian</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu2">Waktu Pengacakan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu3">Soal</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <br>
                    <div class="tab-pane container active" id="home">
                        <div class="table-responsive">
                            <span class="alert alert-info"><strong>Info!</strong> Jika Xn=0 maka soal yang digunakan adalah soal no '.$this->input->get('total_soal').'</span>
                            </br>
                            <br>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th rowspan="1">Pengacakan Ke</th>
                                        '.$th.'
                                    </tr>
                                </thead>
                                <tbody>
                                    '.$tr.'
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane container fade" id="menu1">
                        '.($this->get_hasil_pengujian($_get_hasil_pengujian['jumlah_siswa'] ,$_get_hasil_pengujian['jumlah_soal'] ,$_get_hasil_pengujian['xn']) ).'
                    </div>
                    <div class="tab-pane container fade" id="menu2">
                        Waktu Pengacakan = Script Pengacakan Selesai - Script Pengacakan Dimulai <br>
                        Script Pengacakan Dimulai : '.( $this->benchmark->marker['code_start'] ).'<br>
                        Script Pengacakan Selesai :'.( $this->benchmark->marker['code_end'] ).'
                        <button type="button" class="btn btn-block btn-outline-info disabled">'.$this->benchmark->elapsed_time('code_start','code_end') .' Detik</button>
                    </div>
                    <div class="tab-pane container fade" id="menu3">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th rowspan="1">No</th>
                                        <th rowspan="1">Soal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    '.$this->get_soal( $this->input->get('id_grup_soal') ).'
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            ';
            
        } else {
            /* generate th */
            $th= '';
            for ($s=1; $s < ($this->input->get('jumlah_siswa')+1) ; $s++) {
                $th.= "<th>Siswa $s</th>";
            }
            $this->benchmark->mark('code_start'); # mulai waktu pengacakan metode SQL Random
            $tr= '';
            $sql=[];
            $xn=[];
            $this->m_kep_lab->post["id_grup_soal"]= $this->input->get('id_grup_soal');
            $this->m_kep_lab->post["limit"]= $this->input->get('jumlah_soal');
            for ($js=1; $js < ($this->input->get('jumlah_siswa')+1) ; $js++) { 
                $this->m_kep_lab->post["seed"]= $js;
                $no=1;
                foreach ($this->m_kep_lab->metode_sql() as $key => $value) {
                    $sql[$no][$js]= [
                        'seed'=> $js,
                        'result'=> $value->id_mod
                    ];
                    $xn[$no][$js]= $value->id_mod;
                    $no++;
                }
            }
            // echo '<pre>';
            // print_r($sql);
            // echo '</pre>';
            for ($i=1; $i < ($this->input->get('jumlah_soal')+1) ; $i++) {
                $tr.= '<tr>';
                $tr.= "<td>$i</td>"; 
                for ($j=1; $j < ($this->input->get('jumlah_siswa')+1) ; $j++) {
                    $tr .= "<td>RAND({$j})={$sql[$i][$j]["result"]}</td>";
                }

                $tr.= '<tr>';
            }
            $this->benchmark->mark('code_end'); # selesai waktu pengacakan metode SQL Random
            // echo "<pre>";
            // print_r($this->benchmark);
            // echo "</pre>";
            $this->html= '
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home">Percobaan Metode</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu1">Hasil Pengujian</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu2">Waktu Pengacakan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu3">Soal</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <br>
                <div class="tab-pane container active" id="home">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th rowspan="1">Pengacakan Ke</th>
                                    '.$th.'
                                </tr>
                            </thead>
                            <tbody>
                                '.$tr.'
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane container fade" id="menu1">
                    '.$this->get_hasil_pengujian( ($this->input->get('jumlah_siswa')), ($this->input->get('total_soal') ), $xn).'
                </div>
                <div class="tab-pane container fade" id="menu2">
                    Waktu Pengacakan = Script Pengacakan Selesai - Script Pengacakan Dimulai <br>
                    Script Pengacakan Dimulai : '.( $this->benchmark->marker['code_start'] ).'<br>
                    Script Pengacakan Selesai :'.( $this->benchmark->marker['code_end'] ).'
                    <button type="button" class="btn btn-block btn-outline-info disabled">'.$this->benchmark->elapsed_time('code_start','code_end') .' Detik</button>
                    <hr>
                </div>
                <div class="tab-pane container fade" id="menu3">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th rowspan="1">No</th>
                                    <th rowspan="1">Soal</th>
                                </tr>
                            </thead>
                            <tbody>
                                '.$this->get_soal( $this->input->get('id_grup_soal') ).'
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            ';
            
        }
        echo $this->html;
        // echo $this->benchmark->elapsed_time('code_start','code_end') .' Detik';
        // echo "<pre>";
        // print_r($this->benchmark);
        // echo "</pre>";
    }
/* ==================== end Controller Menu Ujian ==================== */
}