<?php 
class M_admin extends CI_Model{
/* 
    public function data()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                return $this->db->query("
                    SELECT * FROM table
                ")->result_object();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
        
    public function data_store()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                $data= [
                    'name'=>$this->post['name']
                ];
                return $this->db->insert('table',$data);
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_edit()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                return $this->db->query("
                    SELECT * FROM table WHERE id='{$this->id}'
                ")->row();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_update()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                $data= [
                    'name'=>$this->post['name'],
                ];
                $where= [
                    'id'=>$this->post['id'],
                ];
                return $this->db->update('table',$data,$where);
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
    
    public function data_delete()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                $where= [
                    'id'=>$this->post['id'],
                ];
                return $this->db->delete('table',$where);
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
*/	
    public function beranda_guru()
    {
        return $this->db->get('guru')->num_rows();
    }
    public function beranda_siswa()
    {
        return $this->db->get('siswa')->num_rows();
    }
    public function beranda_kelas()
    {
        return $this->db->get('kelas')->num_rows();
    }
    public function beranda_pelajaran()
    {
        return $this->db->get('pelajaran')->num_rows();
    }
    public function cek_user()
    {
        return $this->db->query("SELECT * FROM users WHERE username='{$this->username}' ")->num_rows();
    }
    public function user_store()
    {
        return $this->db->insert('users',[
            'username'=>$this->post['username'],
            'password'=> md5($this->post['password']),
            'level'=> $this->post['level'],
            'blok'=> 'N',
        ]);
    }
    public function user_update()
    {
        return $this->db->update('users',[
            'password'=> md5($this->post['password']),
        ],['username'=>$this->post['username'] ]);
    }

    public function guru_jk()
    {
        $query = " SHOW COLUMNS FROM `guru` LIKE 'jk' ";
        $row = $this->db->query(" {$query} ")->row()->Type;
        $regex = "/'(.*?)'/";
        preg_match_all( $regex , $row, $enum_array );
        $enum_fields = $enum_array[1];
        return( $enum_fields );
    }

    public function guru_agama()
    {
        $query = " SHOW COLUMNS FROM `guru` LIKE 'agama' ";
        $row = $this->db->query(" {$query} ")->row()->Type;
        $regex = "/'(.*?)'/";
        preg_match_all( $regex , $row, $enum_array );
        $enum_fields = $enum_array[1];
        return( $enum_fields );
    }

    public function siswa_jk()
    {
        $query = " SHOW COLUMNS FROM `siswa` LIKE 'jk' ";
        $row = $this->db->query(" {$query} ")->row()->Type;
        $regex = "/'(.*?)'/";
        preg_match_all( $regex , $row, $enum_array );
        $enum_fields = $enum_array[1];
        return( $enum_fields );
    }

    public function siswa_agama()
    {
        $query = " SHOW COLUMNS FROM `siswa` LIKE 'agama' ";
        $row = $this->db->query(" {$query} ")->row()->Type;
        $regex = "/'(.*?)'/";
        preg_match_all( $regex , $row, $enum_array );
        $enum_fields = $enum_array[1];
        return( $enum_fields );
    }
    
    public function soal_jawaban()
    {
        $query = " SHOW COLUMNS FROM `soal` LIKE 'jawaban' ";
        $row = $this->db->query(" {$query} ")->row()->Type;
        $regex = "/'(.*?)'/";
        preg_match_all( $regex , $row, $enum_array );
        $enum_fields = $enum_array[1];
        return( $enum_fields );
    }

    public function data_admin()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                return $this->db->query("
                    SELECT *,
                        IF(admin.username='{$this->session->userdata('username')}',FALSE,TRUE) AS del
                    FROM admin
                        LEFT JOIN users
                            ON admin.username=users.username
                ")->result_object();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
    
    public function data_admin_store()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                if ( $this->user_store() ) {
                    $admin_store= $this->db->insert('admin', [
                        'username' => $this->post['username'],
                        'nama' => $this->post['nama'],
                        'alamat' => $this->post['alamat'],
                        'no_telp' => $this->post['telp'],
                        'email' => $this->post['email'],
                    ]);

                    if ( $admin_store )
                        return TRUE;
                    else
                        return FALSE;
                    
                } else {
                    return FALSE;
                }
                
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_admin_edit()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                return $this->db->query("
                    SELECT *
                    FROM admin
                        LEFT JOIN users
                            ON admin.username=users.username
                    WHERE admin.username='{$this->username}'
                ")->row();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
    
    public function data_admin_update()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                if ( ! empty($this->post['password']) ) {
                    $this->user_update();
                } 
                
                $data= [
                    'nama'=>$this->post['nama'],
                    'alamat'=>$this->post['alamat'],
                    'no_telp'=>$this->post['telp'],
                    'email'=>$this->post['email'],
                ];
                $where= [
                    'username'=>$this->post['username'],
                ];
                return $this->db->update('admin',$data,$where);
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
    
    public function data_admin_delete()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                return $this->db->query("
                    DELETE users , admin
                    FROM users
                        INNER JOIN admin  
                    WHERE users.username= admin.username AND users.username = '{$this->username}'
                ");
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_guru()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                return $this->db->query("
                    SELECT *,
                        IF(guru.jk='L','Laki-Laki','Perempuan') AS gender
                    FROM guru
                        LEFT JOIN users
                            ON guru.username=users.username
                ")->result_object();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
    
    public function data_guru_store()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
            # code...
            if ( $this->user_store() ) {
                $admin_store= $this->db->insert('guru', [
                    'nip' => $this->post['nip'],
                    'username' => $this->post['username'],
                    'nama' => $this->post['nama'],
                    'alamat' => $this->post['alamat'],
                    'tempat_lahir' => $this->post['tempat_lahir'],
                    'tgl_lahir' => $this->post['tgl_lahir'],
                    'agama' => $this->post['agama'],
                    'no_telp' => $this->post['telp'],
                    'email' => $this->post['email'],
                    'gambar' => $this->post['gambar'],
                    'jk' => $this->post['jk'],
                ]);

                if ( $admin_store )
                    return TRUE;
                else
                    return FALSE;
                
            } else {
                return FALSE;
            }
            break;
            
            default:
            # code...
            return NULL;
            break;
        }
    }

    public function data_guru_edit()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                return $this->db->query("
                    SELECT *
                    FROM guru
                        LEFT JOIN users
                            ON guru.username=users.username
                    WHERE guru.username='{$this->username}'
                ")->row();
                break;

            case 'guru':
                # code...
                return $this->db->query("
                    SELECT *
                    FROM guru
                        LEFT JOIN users
                            ON guru.username=users.username
                    WHERE guru.username='{$this->username}'
                ")->row();
                break;

            case 'guru_kep_lab':
                # code...
                return $this->db->query("
                    SELECT *
                    FROM guru
                        LEFT JOIN users
                            ON guru.username=users.username
                    WHERE guru.username='{$this->username}'
                ")->row();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
    
    public function data_guru_update()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                if ( ! empty($this->post['password']) ) {
                    $this->user_update();
                } 
                
                $data= [
                    'nama'=>$this->post['nama'],
                    'alamat'=>$this->post['alamat'],
                    'tempat_lahir'=>$this->post['tempat_lahir'],
                    'tgl_lahir'=>$this->post['tgl_lahir'],
                    'agama'=>$this->post['agama'],
                    'no_telp'=>$this->post['telp'],
                    'email'=>$this->post['email'],
                    'jk'=>$this->post['jk'],
                ];
                
                if ( ! empty($this->post['gambar']) ) {
                    $data['gambar']= $this->post['gambar'];
                }

                $where= [
                    'username'=>$this->post['username'],
                ];
                return $this->db->update('guru',$data,$where);
                break;
            case 'guru':
                # code...
                if ( ! empty($this->post['password']) ) {
                    $this->user_update();
                } 
                
                $data= [
                    'nama'=>$this->post['nama'],
                    'alamat'=>$this->post['alamat'],
                    'tempat_lahir'=>$this->post['tempat_lahir'],
                    'tgl_lahir'=>$this->post['tgl_lahir'],
                    'agama'=>$this->post['agama'],
                    'no_telp'=>$this->post['telp'],
                    'email'=>$this->post['email'],
                    'jk'=>$this->post['jk'],
                ];
                
                if ( ! empty($this->post['gambar']) ) {
                    $data['gambar']= $this->post['gambar'];
                }

                $where= [
                    'username'=>$this->post['username'],
                ];
                return $this->db->update('guru',$data,$where);
                break;
                
            case 'guru_kep_lab':
                # code...
                if ( ! empty($this->post['password']) ) {
                    $this->user_update();
                } 
                
                $data= [
                    'nama'=>$this->post['nama'],
                    'alamat'=>$this->post['alamat'],
                    'tempat_lahir'=>$this->post['tempat_lahir'],
                    'tgl_lahir'=>$this->post['tgl_lahir'],
                    'agama'=>$this->post['agama'],
                    'no_telp'=>$this->post['telp'],
                    'email'=>$this->post['email'],
                    'jk'=>$this->post['jk'],
                ];
                
                if ( ! empty($this->post['gambar']) ) {
                    $data['gambar']= $this->post['gambar'];
                }

                $where= [
                    'username'=>$this->post['username'],
                ];
                return $this->db->update('guru',$data,$where);
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
    
    public function data_guru_delete()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                return $this->db->query("
                    DELETE users , guru
                    FROM users
                        INNER JOIN guru  
                    WHERE users.username= guru.username AND users.username = '{$this->username}'
                ");
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_siswa()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                // return $this->db->query("
                //     SELECT *,
                //         IF(siswa.jk='L','Laki-Laki','Perempuan') AS gender
                //     FROM siswa
                //         LEFT JOIN users
                //             ON siswa.username=users.username
                // ")->result_object();
                return $this->db->query("
                    SELECT *,
                    IF(siswa.jk='L','Laki-Laki','Perempuan') AS gender,
                    IFNULL((SELECT kelas.nama_kelas FROM pbm,pelajaran,kelas WHERE pbm.id_pelajaran=pelajaran.id_pelajaran AND kelas.id_kelas=pelajaran.id_kelas AND pbm.nis=siswa.nis ORDER BY kelas.id_kelas DESC LIMIT 1),'-') AS nama_kelas_mod
                    FROM siswa
                    LEFT JOIN users
                    ON siswa.username=users.username
                ")->result_object();
                // return $this->db->query("
                //     SELECT *,
                //     IF(siswa.jk='L','Laki-Laki','Perempuan') AS gender,
                //     IFNULL((SELECT kelas.nama_kelas FROM pbm,pelajaran,kelas WHERE pbm.id_pelajaran=pelajaran.id_pelajaran AND kelas.id_kelas=pelajaran.id_kelas AND pbm.nis=siswa.nis ORDER BY kelas.id_kelas DESC LIMIT 1),'-') AS kelas
                //     FROM siswa
                //     LEFT JOIN users
                //     ON siswa.username=users.username
                // ")->result_object();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
    
    public function data_siswa_store()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
            # code...
            if ( $this->user_store() ) {
                $admin_store= $this->db->insert('siswa', [
                    'nis' => $this->post['nis'],
                    'username' => $this->post['username'],
                    'nama' => $this->post['nama'],
                    'alamat' => $this->post['alamat'],
                    'tempat_lahir' => $this->post['tempat_lahir'],
                    'tgl_lahir' => $this->post['tgl_lahir'],
                    'agama' => $this->post['agama'],
                    'no_telp' => $this->post['telp'],
                    'email' => $this->post['email'],
                    'gambar' => $this->post['gambar'],
                    'jk' => $this->post['jk'],
                ]);

                if ( $admin_store )
                    return TRUE;
                else
                    return FALSE;
                
            } else {
                return FALSE;
            }
            break;
            
            default:
            # code...
            return NULL;
            break;
        }
    }

    public function data_siswa_edit()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                return $this->db->query("
                    SELECT *
                    FROM siswa
                        LEFT JOIN users
                            ON siswa.username=users.username
                    WHERE siswa.username='{$this->username}'
                ")->row();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
    
    public function data_siswa_update()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                if ( ! empty($this->post['password']) ) {
                    $this->user_update();
                } 
                
                $data= [
                    'nama'=>$this->post['nama'],
                    'alamat'=>$this->post['alamat'],
                    'tempat_lahir'=>$this->post['tempat_lahir'],
                    'tgl_lahir'=>$this->post['tgl_lahir'],
                    'agama'=>$this->post['agama'],
                    'no_telp'=>$this->post['telp'],
                    'email'=>$this->post['email'],
                    'jk'=>$this->post['jk'],
                ];
                
                if ( ! empty($this->post['gambar']) ) {
                    $data['gambar']= $this->post['gambar'];
                }

                $where= [
                    'username'=>$this->post['username'],
                ];
                return $this->db->update('siswa',$data,$where);
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
    
    public function data_siswa_delete()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                return $this->db->query("
                    DELETE users , siswa
                    FROM users
                        INNER JOIN siswa  
                    WHERE users.username= siswa.username AND users.username = '{$this->username}'
                ");
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_kelas()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                return $this->db->query("
                    SELECT * FROM kelas
                ")->result_object();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
        
    public function data_kelas_store()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                $data= [
                    'nama_kelas'=>$this->post['nama_kelas'],
                    'blok'=>'N',
                ];
                return $this->db->insert('kelas',$data);
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_kelas_edit()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                return $this->db->query("
                    SELECT * FROM kelas WHERE id_kelas='{$this->id_kelas}'
                ")->row();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_kelas_update()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                $data= [
                    'nama_kelas'=>$this->post['nama_kelas'],
                ];
                $where= [
                    'id_kelas'=>$this->post['id_kelas'],
                ];
                return $this->db->update('kelas',$data,$where);
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
    
    public function data_kelas_delete()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                $where= [
                    'id_kelas'=>$this->id_kelas,
                ];
                return $this->db->delete('kelas',$where);
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_pelajaran()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                return $this->db->query("
                    SELECT *,
                        pelajaran.blok AS pelajaran_blok
                    FROM pelajaran
                        LEFT JOIN kelas
                            ON pelajaran.id_kelas=kelas.id_kelas
                ")->result_object();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
        
    public function data_pelajaran_store()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                $data= [
                    'id_kelas'=>$this->post['id_kelas'],
                    'nama_pelajaran'=>$this->post['nama_pelajaran'],
                    'blok'=>'N',
                ];
                return $this->db->insert('pelajaran',$data);
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_pelajaran_edit()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                return $this->db->query("
                    SELECT * FROM pelajaran WHERE id_pelajaran='{$this->id_pelajaran}'
                ")->row();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_pelajaran_update()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                $data= [
                    'nama_pelajaran'=>$this->post['nama_pelajaran'],
                    'id_kelas'=>$this->post['id_kelas'],
                ];
                $where= [
                    'id_pelajaran'=>$this->post['id_pelajaran'],
                ];
                return $this->db->update('pelajaran',$data,$where);
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
    
    public function data_pelajaran_delete()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                $where= [
                    'id_pelajaran'=>$this->id_pelajaran,
                ];
                return $this->db->delete('pelajaran',$where);
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_pbm()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                return $this->db->query("
                    SELECT
                        pbm.tahun_ajaran,
                        siswa.nis,
                        siswa.nama AS nama_siswa,
                        kelas.nama_kelas,
                        pelajaran.nama_pelajaran,
                        guru.nama AS nama_guru
                    FROM pbm
                        LEFT JOIN siswa
                            ON pbm.nis = siswa.nis
                        LEFT JOIN pelajaran
                            ON pbm.id_pelajaran = pelajaran.id_pelajaran
                        LEFT JOIN guru
                            ON pbm.nip = guru.nip
                        LEFT JOIN kelas
                            ON pelajaran.id_kelas = kelas.id_kelas
                ")->result_object();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_pbm_cek_nis()
	{
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                return $this->db->query("SELECT * FROM siswa WHERE nis='{$this->post["nis"]}' ");
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
    
    public function data_pbm_pelajaran()
	{
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                return $this->db->query("
                    SELECT id_pelajaran, nama_pelajaran,nama_kelas 
                        FROM   pelajaran
                            LEFT JOIN kelas
                                ON pelajaran.id_kelas=kelas.id_kelas
                        WHERE id_pelajaran
                            NOT IN (SELECT id_pelajaran FROM pbm WHERE nis='{$this->nis}')
                ")->result_object();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
	}
        
    public function data_pbm_store()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                return $this->db->insert('pbm', [
                    'tahun_ajaran'  => $this->post['tahun_ajaran'],
                    'id_pelajaran'  => $this->post['id_pelajaran'],
                    'nip'           => $this->post['nip'],
                    'nis'           => $this->post['nis'],
                ] );
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_pbm_edit()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                return $this->db->query("
                    SELECT * FROM table WHERE id='{$this->id}'
                ")->row();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_pbm_update()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                $data= [
                    'name'=>$this->post['name'],
                ];
                $where= [
                    'id'=>$this->post['id'],
                ];
                return $this->db->update('table',$data,$where);
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
    
    public function data_pbm_delete()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                $where= [
                    'id'=>$this->post['id'],
                ];
                return $this->db->delete('table',$where);
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_grup_soal()
    {
        switch ($this->session->userdata('level')) {
            case 'guru':
                # code...
                return $this->db->query("
                    SELECT *,
                        ( (SELECT COUNT(id_soal) FROM soal WHERE soal.id_grup_soal=grup_soal.id_grup_soal) ) AS jumlah_soal
                    FROM grup_soal
                        LEFT JOIN pbm
                            ON grup_soal.id_pelajaran=pbm.id_pelajaran
                        LEFT JOIN pelajaran
                            ON pbm.id_pelajaran=pelajaran.id_pelajaran
                        LEFT JOIN kelas
                            ON pelajaran.id_kelas=kelas.id_kelas
                    WHERE pbm.nip='{$this->session->userdata('username')}'
                        
                ")->result_object();
                break;

            case 'guru_kep_lab':
                # code...
                return $this->db->query("
                    SELECT *,
                        ( (SELECT COUNT(id_soal) FROM soal WHERE soal.id_grup_soal=grup_soal.id_grup_soal) ) AS jumlah_soal
                    FROM grup_soal
                        LEFT JOIN pbm
                            ON grup_soal.id_pelajaran=pbm.id_pelajaran
                        LEFT JOIN pelajaran
                            ON pbm.id_pelajaran=pelajaran.id_pelajaran
                        LEFT JOIN kelas
                            ON pelajaran.id_kelas=kelas.id_kelas
                    WHERE pbm.nip='{$this->session->userdata('username')}'
                        
                ")->result_object();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_ujian_grup_soal()
    {
        switch ($this->session->userdata('level')) {
            case 'guru_kep_lab':
                # code...
                return $this->db->query("
                    SELECT *,
                        ( (SELECT COUNT(id_soal) FROM soal WHERE soal.id_grup_soal=grup_soal.id_grup_soal) ) AS jumlah_soal
                    FROM grup_soal
                        LEFT JOIN pbm
                            ON grup_soal.id_pelajaran=pbm.id_pelajaran
                        LEFT JOIN pelajaran
                            ON pbm.id_pelajaran=pelajaran.id_pelajaran
                        LEFT JOIN kelas
                            ON pelajaran.id_kelas=kelas.id_kelas
                        
                ")->result_object();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_grup_soal_pelajaran()
    {
        switch ($this->session->userdata('level')) {
            case 'guru':
                # code...
                return $this->db->query("
                SELECT *
                FROM pbm
                    LEFT JOIN pelajaran
                        ON pbm.id_pelajaran=pelajaran.id_pelajaran
                    LEFT JOIN kelas
                        ON pelajaran.id_kelas=kelas.id_kelas
                WHERE pbm.nip='{$this->session->userdata('username')}'
                ")->result_object();
                break;

            case 'guru_kep_lab':
                # code...
                return $this->db->query("
                SELECT *
                FROM pbm
                    LEFT JOIN pelajaran
                        ON pbm.id_pelajaran=pelajaran.id_pelajaran
                    LEFT JOIN kelas
                        ON pelajaran.id_kelas=kelas.id_kelas
                WHERE pbm.nip='{$this->session->userdata('username')}'
                ")->result_object();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
        
    public function data_grup_soal_store()
    {
        switch ($this->session->userdata('level')) {
            case 'guru':
                # code...
                $data= [
                    'nama_grup_soal'=>$this->post['nama_grup_soal'],
                    'id_pelajaran'=>$this->post['id_pelajaran'],
                ];
                return $this->db->insert('grup_soal',$data);
                break;

            case 'guru_kep_lab':
                # code...
                $data= [
                    'nama_grup_soal'=>$this->post['nama_grup_soal'],
                    'id_pelajaran'=>$this->post['id_pelajaran'],
                ];
                return $this->db->insert('grup_soal',$data);
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_grup_soal_edit()
    {
        switch ($this->session->userdata('level')) {
            case 'guru':
                # code...
                return $this->db->query("
                    SELECT * FROM table WHERE id='{$this->id}'
                ")->row();
                break;

            case 'guru_kep_lab':
                # code...
                return $this->db->query("
                    SELECT * FROM table WHERE id='{$this->id}'
                ")->row();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_grup_soal_update()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                $data= [
                    'name'=>$this->post['name'],
                ];
                $where= [
                    'id'=>$this->post['id'],
                ];
                return $this->db->update('table',$data,$where);
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
    
    public function data_grup_soal_delete()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                $where= [
                    'id'=>$this->post['id'],
                ];
                return $this->db->delete('table',$where);
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_soal()
    {
        switch ($this->session->userdata('level')) {
            case 'guru':
                # code...
                return $this->db->query("
                    SELECT *
                    FROM soal
                        LEFT JOIN grup_soal
                            ON soal.id_grup_soal=grup_soal.id_grup_soal
                        LEFT JOIN pbm
                            ON grup_soal.id_pelajaran=pbm.id_pelajaran
                        LEFT JOIN pelajaran
                            ON pbm.id_pelajaran=pelajaran.id_pelajaran
                        LEFT JOIN kelas
                            ON pelajaran.id_kelas=kelas.id_kelas
                    WHERE pbm.nip='{$this->session->userdata('username')}'
                        
                ")->result_object();
                break;

            case 'guru_kep_lab':
                # code...
                return $this->db->query("
                    SELECT *
                    FROM soal
                        LEFT JOIN grup_soal
                            ON soal.id_grup_soal=grup_soal.id_grup_soal
                        LEFT JOIN pbm
                            ON grup_soal.id_pelajaran=pbm.id_pelajaran
                        LEFT JOIN pelajaran
                            ON pbm.id_pelajaran=pelajaran.id_pelajaran
                        LEFT JOIN kelas
                            ON pelajaran.id_kelas=kelas.id_kelas
                    WHERE pbm.nip='{$this->session->userdata('username')}'
                        
                ")->result_object();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_soal_grup_soal()
    {
        switch ($this->session->userdata('level')) {
            case 'guru':
                # code...
                return $this->db->query("
                SELECT *
                FROM grup_soal
                    LEFT JOIN pbm
                        ON grup_soal.id_pelajaran=pbm.id_pelajaran
                    LEFT JOIN pelajaran
                        ON pbm.id_pelajaran=pelajaran.id_pelajaran
                    LEFT JOIN kelas
                        ON pelajaran.id_kelas=kelas.id_kelas
                WHERE pbm.nip='{$this->session->userdata('username')}'
                ")->result_object();
                break;

            case 'guru_kep_lab':
                # code...
                return $this->db->query("
                SELECT *
                FROM grup_soal
                    LEFT JOIN pbm
                        ON grup_soal.id_pelajaran=pbm.id_pelajaran
                    LEFT JOIN pelajaran
                        ON pbm.id_pelajaran=pelajaran.id_pelajaran
                    LEFT JOIN kelas
                        ON pelajaran.id_kelas=kelas.id_kelas
                WHERE pbm.nip='{$this->session->userdata('username')}'
                ")->result_object();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
        
    public function data_soal_store()
    {
        switch ($this->session->userdata('level')) {
            case 'guru':
                # code...
                $data= [
                    'soal'=>$this->post['soal'],
                    'a'=>$this->post['a'],
                    'b'=>$this->post['b'],
                    'c'=>$this->post['c'],
                    'd'=>$this->post['d'],
                    'id_grup_soal'=>$this->post['id_grup_soal'],
                    'jawaban'=>$this->post['jawaban'],
                ];
                return $this->db->insert('soal',$data);
                break;

            case 'guru_kep_lab':
                # code...
                $data= [
                    'soal'=>$this->post['soal'],
                    'a'=>$this->post['a'],
                    'b'=>$this->post['b'],
                    'c'=>$this->post['c'],
                    'd'=>$this->post['d'],
                    'id_grup_soal'=>$this->post['id_grup_soal'],
                    'jawaban'=>$this->post['jawaban'],
                ];
                return $this->db->insert('soal',$data);
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_soal_edit()
    {
        switch ($this->session->userdata('level')) {
            case 'guru':
                # code...
                return $this->db->query("
                    SELECT * FROM soal WHERE id_soal='{$this->id_soal}'
                ")->row();
                break;

            case 'guru_kep_lab':
                # code...
                return $this->db->query("
                    SELECT * FROM soal WHERE id_soal='{$this->id_soal}'
                ")->row();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    public function data_soal_update()
    {
        switch ($this->session->userdata('level')) {
            case 'guru':
                # code...
                $data= [
                    'soal'=>$this->post['soal'],
                    'a'=>$this->post['a'],
                    'b'=>$this->post['b'],
                    'c'=>$this->post['c'],
                    'd'=>$this->post['d'],
                    'id_grup_soal'=>$this->post['id_grup_soal'],
                    'jawaban'=>$this->post['jawaban'],
                ];
                $where= [
                    'id_soal'=>$this->post['id_soal'],
                ];
                return $this->db->update('soal',$data,$where);
                break;

            case 'guru_kep_lab':
                # code...
                $data= [
                    'soal'=>$this->post['soal'],
                    'a'=>$this->post['a'],
                    'b'=>$this->post['b'],
                    'c'=>$this->post['c'],
                    'd'=>$this->post['d'],
                    'id_grup_soal'=>$this->post['id_grup_soal'],
                    'jawaban'=>$this->post['jawaban'],
                ];
                $where= [
                    'id_soal'=>$this->post['id_soal'],
                ];
                return $this->db->update('soal',$data,$where);
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
    
    public function data_soal_delete()
    {
        switch ($this->session->userdata('level')) {
            case 'admin':
                # code...
                $where= [
                    'id'=>$this->post['id'],
                ];
                return $this->db->delete('table',$where);
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }
    
    public function metode_sql()
    {
        switch ($this->session->userdata('level')) {
            case 'guru_kep_lab':
                # code...
                return $this->db->query("SELECT * FROM soal WHERE id_grup_soal='{$this->id_grup_soal}' ORDER BY RAND($this->seed)")->result_object();
                break;
            
            default:
                # code...
                return NULL;
                break;
        }
    }

    /* ==================== start mendapatkan data peleajaran guru dari data pbm ==================== */
    public function get_pelajaran_guru_by_pbm(){
        return $this->db->query("SELECT * FROM pbm LEFT JOIN guru ON guru.nip=pbm.nip LEFT JOIN pelajaran ON pelajaran.id_pelajaran=pbm.id_pelajaran LEFT JOIN kelas ON kelas.id_kelas=pelajaran.id_kelas WHERE 1 GROUP BY pbm.nip,pbm.tahun_ajaran,pbm.id_pelajaran,kelas.id_kelas ORDER BY pbm.tahun_ajaran ASC")->result_object();
    }
    /* ==================== end mendapatkan data peleajaran guru dari data pbm ==================== */
    
    /* ==================== start mendapatkan data peleajaran siswa dari data pbm ==================== */
    public function get_pelajaran_siswa_by_pbm(){
        return $this->db->query("SELECT * FROM pbm LEFT JOIN siswa ON siswa.nis=pbm.nis LEFT JOIN pelajaran ON pelajaran.id_pelajaran=pbm.id_pelajaran LEFT JOIN kelas ON kelas.id_kelas=pelajaran.id_kelas WHERE 1 GROUP BY pbm.nis,pbm.tahun_ajaran,pbm.id_pelajaran,kelas.id_kelas ORDER BY pbm.tahun_ajaran ASC")->result_object();
    }
    /* ==================== end mendapatkan data peleajaran siswa dari data pbm ==================== */
    
    /* ==================== start mendapatkan data siswa dari berdasarka kelas dari data pbm ==================== */
    public function search_siswa_by_kelas($id_kelas){
        return $this->db->query("SELECT * FROM pbm LEFT JOIN siswa ON siswa.nis=pbm.nis LEFT JOIN pelajaran ON pelajaran.id_pelajaran=pbm.id_pelajaran LEFT JOIN kelas ON kelas.id_kelas=pelajaran.id_kelas WHERE 1 AND kelas.id_kelas='{$id_kelas}' GROUP BY pbm.nis")->result_object();
    }
    /* ==================== end mendapatkan data siswa dari berdasarka kelas dari data pbm ==================== */



}