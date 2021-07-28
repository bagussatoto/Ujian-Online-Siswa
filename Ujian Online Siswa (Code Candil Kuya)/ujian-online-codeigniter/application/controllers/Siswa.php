<?php 
class Siswa extends MY_Controller{
	function __construct(){
        parent::__construct();
		
		if($this->session->userdata('status') != "login" && $this->session->userdata('level') != "siswa"){
			redirect(base_url('auth'));
        }

		
        $this->load->model('m_siswa');
        
		$msg= null;
		$html= null;
        $json= null;
    }

/* ==================== Start Beranda ==================== */
    public function index()
    {
        $this->content['rows']= $this->m_siswa->data_ujian();
        $this->view= 'siswa/index';
        $this->render_pages();
    }
/* ==================== End Beranda ==================== */

/* ==================== Start Profil ==================== */
    public function data_profil()
    {
        $this->m_siswa->username= $this->session->userdata('username');

        $this->content['row']   = $this->m_siswa->data_siswa_edit();
        $this->content['jk']    = $this->m_siswa->siswa_jk();
        $this->content['agama'] = $this->m_siswa->siswa_agama();
        $this->content['kelas'] = $this->m_siswa->data_kelas_siswa();
        $this->view= 'siswa/profil';
        $this->render_pages();

        # for debug data
        /* echo '<pre>';
        print_r($this->content);
        echo '</pre>'; */
    }
    public function form_data_siswa_edit()
    {
        $this->m_siswa->username= $this->session->userdata('username');
        $row= $this->m_siswa->data_siswa_edit();
        $jk= "";
        foreach ($this->m_siswa->siswa_jk() as $key => $value) {
            $jk .= '
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input '.($value==$row->jk? 'checked' : null).' type="radio" class="form-check-input" name="jk" value="'.$value.'" required>'.($value=='L' ? 'Laki-Laki' : 'Perempuan' ).'
                    </label>
                </div>
            ';
        }

        $agama= "";
        foreach ($this->m_siswa->siswa_agama() as $key => $value) {
            $agama .= '
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input '.($value==$row->agama? 'checked' : null).' type="radio" class="form-check-input" name="agama" value="'.$value.'" required>'.$value.'
                    </label>
                </div>
            ';
        }

        $this->html= '
        <form action="'.base_url().'siswa/data-siswa-update" role="form" id="edit" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>NIS</label>
                <input readonly value="'.$row->nis.'" name="nip" type="text" class="form-control" placeholder="*) Masukan NIS" required="">
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
        $this->m_siswa->post= $this->input->post();
        if ( empty($_FILES['fupload']['tmp_name']) ) {
            # code...without upload file
            if ( $this->m_siswa->data_siswa_update() ) {
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
            $this->m_siswa->username= $this->input->post('username');
            $row= $this->m_siswa->data_siswa_edit();
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
                $this->m_siswa->post['gambar']= $this->upload->data()['file_name'];
                if ( $this->m_siswa->data_siswa_update() ) {
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
/* ==================== End Profil ==================== */

/* ==================== Start Ujian ==================== */
    public function data_ujian()
    {
        $this->content['rows']= $this->m_siswa->data_ujian();
        $this->view= 'siswa/ujian';
        $this->render_pages();
    }
    public function proses_ujian()
    {
        if ( $this->session->has_userdata('proses-ujian') ) {
            # get last_soal
            $index_soal= $this->session->userdata('proses-ujian')['last_soal'];
            if ( ($index_soal < count( $this->session->userdata('proses-ujian')['soal']) && !empty($this->input->post('jawaban')) ) ) {
                # update soal->jawaban $this->session->userdata('proses-ujian')['soal'][$index_soal]['jawaban']
                $_SESSION['proses-ujian']['soal'][$index_soal]->jawaban= $this->input->post('jawaban');
    
                # update $this->session->userdata('proses-ujian')['last_soal']
                $_SESSION['proses-ujian']['last_soal']= $index_soal +1;
            } else {
                // $this->session->unset_userdata('proses-ujian');
            }
            

        } else {
            $this->m_siswa->post['id_grup_soal']= $this->uri->segment(3);
            $rows= $this->metode_acak();
            $data_session = array(
                'id_grup_soal'  => $this->uri->segment(3),
                'metode'  => $rows['metode'],
                'start_ujian' => 'waktu start',
                'end_ujian' => 'waktu berakhir',
                'last_soal'=>0,
                'soal'=> $rows['results'],
            );
            $this->session->set_userdata('proses-ujian',$data_session);
        }
        
        $this->html= '
        <div class="card">
            <div class="card-header">
                <div class="table-responsive-lg">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Jumlah Soal</th>
                                <th>Waktu Pengerjaan</th>
                                <th>Waktu Tersisa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>'.count( $this->session->userdata('proses-ujian')['soal'] ).'</td>
                                <td>'.$this->session->userdata('proses-ujian')['metode']->bminutes.' Menit</td>
                                <td id="countDownUjian" data-tanggal="'.$this->session->userdata('proses-ujian')['metode']->bdaytime.'" data-waktu="'.$this->session->userdata('proses-ujian')['metode']->bminutes.'"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-body">                
                ';
                if ( ($this->session->userdata('proses-ujian')['last_soal'] < count( $this->session->userdata('proses-ujian')['soal']) && empty($this->input->get('timeout') ) ) ) {
                    $soal= $this->session->userdata('proses-ujian')['soal'][ $this->session->userdata('proses-ujian')['last_soal'] ];
                    $this->html .= '
                    <div class="card">
                        <form method="post" class="next-soal" action="'.base_url('siswa/proses-ujian').'">
                            <div class="card-header"> <label>Soal No '.($this->session->userdata('proses-ujian')['last_soal'] +1).'</label></div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="pertanyaan">Pertanyaan:</label>
                                    <div class="callout callout-success">
                                        <p>'.$soal->soal.'</p>
                                    </div>
                                </div>
                                <label for="pilihJawaban">Pilih Jawaban:</label>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td style="width:3rem">A .</td>
                                            <td style="width:1rem">
                                                <input type="radio" class="form-check-input" name="jawaban" value="A" required="">
                                            </td>
                                            <td>'.$soal->a.'</td>
                                        </tr>
                                        <tr>
                                            <td>B .</td>
                                            <td>
                                                <input type="radio" class="form-check-input" name="jawaban" value="B" required="">
                                            </td>
                                            <td>'.$soal->b.'</td>
                                        </tr>
                                        <tr>
                                            <td>C .</td>
                                            <td>
                                                <input type="radio" class="form-check-input" name="jawaban" value="C" required="">
                                            </td>
                                            <td>'.$soal->c.'</td>
                                        </tr>
                                        <tr>
                                            <td>D .</td>
                                            <td>
                                                <input type="radio" class="form-check-input" name="jawaban" value="D" required="">
                                            </td>
                                            <td>'.$soal->d.'</td>
                                        </tr>
                                    </tbody>
                                </table>                        
                            </div> 
                            <div class="card-footer">
                                <button type="submit" class="btn btn-block btn-outline-primary">Klik Disini Untuk Melihat Soal Selanjutnya</button>
                            </div>
                        </form>
                    </div>
                    ';
                } else {
                    /* create data for insert batch */
                    $this->m_siswa->post['data_jawaban']= [];
                    $benar= 0;
                    foreach ($this->session->userdata('proses-ujian')['soal'] as $key => $value) {
                        $keterangan= ($value->jawaban==''
                            ? 'Tidak Terjawab' 
                            : ($value->jawaban==$value->kunci
                                ? 'Benar'
                                : 'Salah'
                            )
                        );
                        $benar += ($keterangan=='Benar' ? 1 : 0);
                        $this->m_siswa->post['data_jawaban'][]= [
                            'soal_id'=>$value->id_soal,
                            'nis'=>$this->session->userdata('username'),
                            'jawaban_soal'=> ($value->jawaban != '' ? $value->jawaban : '-' ),
                            'keterangan'=>$keterangan 
                        ];
                    }

                    $this->m_siswa->post['data_hasil_ujian']= [
                        'nis'=>$this->session->userdata('username'),
                        'id_grup_soal'=>$this->session->userdata('proses-ujian')['id_grup_soal'],
                        'nilai'=> ($benar/$this->session->userdata('proses-ujian')['metode']->jumlah_soal)*100,
                    ];

                    $this->m_siswa->store_data_jawaban();
                    $this->m_siswa->store_data_hasil_ujian();
                    $this->session->unset_userdata('proses-ujian');
                    $this->html .= '
                    <div class="callout callout-info text-center">
                        <h5>Ujian Selesai</h5>
                        <p>*Terima Kasih*</p>
                    </div>
                    ';
                }
                $this->html .= '
            </div>
        </div>
        ';
        echo $this->html;
        // $this->m_siswa->post['id_grup_soal']= $this->uri->segment(3);
        
        
        // echo '<pre>';
        // print_r( $_SESSION['proses-ujian'] );
        // print_r( $this->m_siswa );
        // echo '</pre>';
        // echo '<pre>';
        // print_r($_SESSION['proses-ujian']['soal'][$index_soal]['jawaban']);
        // print_r($this->input->post());
        // print_r($this->session->userdata('proses-ujian'));
        // print_r($this->session->userdata('proses-ujian')['soal'][ $this->session->userdata('proses-ujian')['last_soal'] ]);
        // print_r($this->session->has_userdata('proses-ujian'));
        // echo '</pre>';
    }
    protected function metode_acak()
    {
        $data = [];
        // $this->m_siswa->post['id_grup_soal']= $this->session->userdata('proses-ujian')['id_grup_soal'];
        $row_grup_soal= $this->m_siswa->data_grup_soal();
        $data['metode']= json_decode($row_grup_soal->metode_acak);
        // $data['metode']= $this->m_siswa->data_grup_soal();
        if ( $data['metode']->metode == 'LCG' ) {
            /* get no urut dalam kelas berdasarkan nis*/
            $_no= null;
            foreach ($this->m_siswa->data_siswa_satu_kelas($row_grup_soal->id_pelajaran) as $key => $value) {
                if ( $value->nis==$this->session->userdata('username') )
                    $_no= $key+1;
            }

            /* get data soal */
            $row_soal= [];
            foreach ($this->m_siswa->data_soal_lcg() as $key => $value) {
                $value->kunci= $value->jawaban;
                $value->jawaban= '';
                $row_soal[$key+1]= $value;
            }

            /* generate soal dengan LCG */
            $soal=[];
            $xn=0;
            for ($i=0; $i < $data['metode']->jumlah_soal ; $i++) { 
                if ( $i==0 ) {
                    # code...
                    $xn= ( (1 *$_no) +$data['metode']->bil_prima ) % $data['metode']->total_soal;
                    $soal[]= $row_soal[($xn==0? $data['metode']->total_soal : $xn )];
                } else {
                    $xn= ( (1 *$xn) +$data['metode']->bil_prima )  % $data['metode']->total_soal;
                    $soal[]= $row_soal[($xn==0? $data['metode']->total_soal : $xn )];

                }
                
            }
            $data['results'] = $soal;

        } else { # metode SQL Random
            /* get no urut dalam kelas berdasarkan nis*/
            $_no= null;
            foreach ($this->m_siswa->data_siswa_satu_kelas($row_grup_soal->id_pelajaran) as $key => $value) {
                if ( $value->nis==$this->session->userdata('username') )
                    $_no= $key+1;
            }
            $this->m_siswa->post['random_parameter']= $_no;
            $this->m_siswa->post['jumlah_soal']= $data['metode']->jumlah_soal;

            /* get data soal */
            $row_soal= [];
            foreach ($this->m_siswa->data_soal_sql() as $key => $value) {
                $value->kunci= $value->jawaban;
                $value->jawaban= '';
                // $row_soal[$key+1]= $value;
                $row_soal[$key]= $value;
            }
            $data['results'] = $row_soal;
        }
        return $data;
    }
    public function cek_proses_ujian()
    {
        echo $this->session->has_userdata('proses-ujian')? 1 : 0;
    }
/* ==================== End Ujian ==================== */

/* ==================== Start Hasil Ujian ==================== */
    public function data_hasil_ujian()
    {
        $this->content['rows']= $this->m_siswa->data_ujian();
        $this->view= 'siswa/hasil_ujian';
        $this->render_pages();
    }
    public function detail_hasil_ujian()
    {
        $this->m_siswa->post['id_grup_soal']= $this->uri->segment(3);
        $jawaban        = $this->m_siswa->data_soal_hasil_ujian();
        $jumlah_soal    = count($jawaban);
        $jawaban_benar  = 0;
        $jawaban_salah  = 0;
        $tidak_terjawab = 0;
        $no             = 1;
        $tbody          = '';
        foreach ($jawaban as $key => $value) {
            switch ($value->keterangan) {
                case 'Benar':
                    $jawaban_benar ++;
                    break;
                case 'Salah':
                    $jawaban_salah ++;
                    break;
                case 'Tidak Terjawab':
                    $tidak_terjawab ++;
                    break;
                
                default:
                    # code...
                    break;
            }
            $tbody .= "
                <tr>
                    <td>{$no}</td>
                    <td>{$value->soal}</td>
                    <td>{$value->keterangan}</td>
                </tr>
            ";
            $no++;
        }
        echo '<pre>';
        // print_r($jawaban_salah);
        echo '</pre>';
        $this->html= '
        <div class="card">
            <div class="card-body">
                <div class="table-responsive-lg">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Jumlah Soal</th>
                                <th>Jawaban Benar</th>
                                <th>Jawaban Salah</th>
                                <th>Tidak Terjawab</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>'.$jumlah_soal.'</td>
                                <td>'.$jawaban_benar.'</td>
                                <td>'.$jawaban_salah.'</td>
                                <td>'.$tidak_terjawab.'</td>
                                <td>'.( ($jawaban_benar/$jumlah_soal)*100 ).'</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="table-responsive-lg">
            <h5>Detail Koreksi Jawaban</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Soal</th>
                        <th>Koreksi</th>
                    </tr>
                </thead>
                <tbody>
                    '.$tbody.'
                </tbody>
            </table>
        </div>
        ';
        echo $this->html;
    }
/* ==================== End Hasil Ujian ==================== */
}