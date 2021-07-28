<?php 
class M_kep_lab extends CI_Model{
    public $post= null;

    public function edit_profil()
    {
        return $this->db->query("
            SELECT *
            FROM guru
                LEFT JOIN users
                    ON guru.username=users.username
            WHERE guru.username='{$this->username}'
        ")->row();
    }
    public function update_profil()
    {
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
    }
    /* end profiil */
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

    /* start grup soal */
    public function grup_soal()
    {
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
    }
    public function store_grup_soal()
    {
        $data= [
            'nama_grup_soal'=>$this->post['nama_grup_soal'],
            'id_pelajaran'=>$this->post['id_pelajaran'],
        ];
        return $this->db->insert('grup_soal',$data);
    }

    public function edit_grup_soal()
    {
        return $this->db->query("
            SELECT * FROM table WHERE id='{$this->id}'
        ")->row();
    }
/* end grup soal */

/* start ujian grup soal */
    public function ujian_grup_soal()
    {
        if( ! empty($this->post['id_grup_soal']) ){
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
                WHERE grup_soal.id_grup_soal='{$this->post["id_grup_soal"]}'
            ")->result_object();

        } else {
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
            WHERE 1=1
                GROUP BY grup_soal.id_grup_soal
                    
            ")->result_object();

        }
    }
    public function store_ujian_grup_soal()
    {
        $data= [
            'metode_acak'=> json_encode($this->post),
        ];
        return $this->db->update('grup_soal',$data,['id_grup_soal'=>$this->post['id_grup_soal'] ]);
    }
/* end ujian grup soal */

    public function data_grup_soal_pelajaran()
    {
        return $this->db->query("
        SELECT *
        FROM pbm
            LEFT JOIN pelajaran
                ON pbm.id_pelajaran=pelajaran.id_pelajaran
            LEFT JOIN kelas
                ON pelajaran.id_kelas=kelas.id_kelas
        WHERE pbm.nip='{$this->session->userdata('username')}'
        ")->result_object();
    }
        
    

    
    
    /* start soal */
    public function soal()
    {
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
    }
    public function soal_grup_soal()
    {
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
    }
    public function store_soal()
    {
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
    }
    public function edit_soal()
    {
        return $this->db->query("
            SELECT * FROM soal WHERE id_soal='{$this->id_soal}'
        ")->row();
    }
    public function update_soal()
    {
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
    }
    public function delete_soal()
    {
        $where= [
            'id_soal'=> $this->id_soal,
        ];
        return $this->db->delete('soal',$where);
    }
    /* end grup soal */
    
    
    public function metode_sql()
    {
        $this->db->trans_start();
        $this->db->query("SET @id=0");
        $result= $this->db->query("
            SELECT *,@id:=@id+1 AS id_mod FROM soal WHERE id_grup_soal='{$this->post["id_grup_soal"]}' ORDER BY RAND({$this->post["seed"]})
            LIMIT {$this->post["limit"]}
        ");
        $this->db->trans_complete();
        return $result->result_object();
    }

    /* mendapatkan soal */
    public function get_soal()
    {
        $this->db->trans_start();
        $this->db->query("SET @id=0");
        $result= $this->db->query("
            SELECT *,@id:=@id+1 AS id_mod FROM soal WHERE id_grup_soal='{$this->post["id_grup_soal"]}'
            ORDER BY id_soal ASC
        ");
        $this->db->trans_complete();
        return $result->result_object();

    }
    /* end mendapatkan soal */

    /* ==================== start get pelajaran by username ==================== */
    public function get_pelajaran_by_username()
    {
        return $this->db->query("SELECT * FROM pbm LEFT JOIN guru ON guru.nip=pbm.nip LEFT JOIN pelajaran ON pelajaran.id_pelajaran=pbm.id_pelajaran LEFT JOIN kelas ON kelas.id_kelas=pelajaran.id_kelas WHERE 1 AND guru.username='".$this->session->userdata('username')."' GROUP BY pelajaran.id_pelajaran,kelas.id_kelas ")->result_object();
    }
    /* ==================== end get pelajaran by username ==================== */
}