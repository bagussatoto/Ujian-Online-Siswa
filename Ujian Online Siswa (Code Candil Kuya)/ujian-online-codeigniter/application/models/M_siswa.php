<?php
class M_siswa extends CI_Model
{
    public $post= null;
    
/* ==================== Start Data Ujian ==================== */
    public function data_ujian()
    {
        return $this->db->query("
            SELECT *,
                (SELECT COUNT(*) AS counts FROM hasil_ujian WHERE hasil_ujian.nis=pbm.nis AND hasil_ujian.id_grup_soal=grup_soal.id_grup_soal) AS counts 
            FROM pbm
                INNER JOIN pelajaran
                    ON pbm.id_pelajaran=pelajaran.id_pelajaran
                INNER JOIN grup_soal
                    ON pbm.id_pelajaran=grup_soal.id_pelajaran
            WHERE 1=1
                AND pbm.nis='".$this->session->userdata('username')."'
                AND grup_soal.metode_acak!=''
        ")->result_object();
    }
    public function data_soal_lcg()
    {
        return $this->db->query("
            SELECT * FROM soal WHERE id_grup_soal='{$this->post["id_grup_soal"]}' ORDER BY id_grup_soal ASC
        ")->result_object();
    }
    public function data_soal_sql()
    {
        return $this->db->query("
            SELECT * FROM soal WHERE id_grup_soal='{$this->post["id_grup_soal"]}' ORDER BY RAND('{$this->post["random_parameter"]}') LIMIT {$this->post["jumlah_soal"]}
        ")->result_object();
    }
    public function data_grup_soal()
    {
        return $this->db->query("
            SELECT * FROM grup_soal WHERE id_grup_soal='{$this->post["id_grup_soal"]}'
        ")->row();
    }
    public function data_siswa_satu_kelas($id_pelajaran)
    {
        return $this->db->query("
            SELECT nis FROM pbm WHERE id_pelajaran='{$id_pelajaran}' ORDER BY nis ASC
        ")->result_object();
    }
    public function store_data_hasil_ujian()
    {
        return $this->db->insert('hasil_ujian',$this->post['data_hasil_ujian']);
    }
    public function store_data_jawaban()
    {
        return $this->db->insert_batch('jawaban',$this->post['data_jawaban']);
    }
/* ==================== End Data Ujian ==================== */

/* ==================== Start Hasil Ujian ==================== */
    public function data_soal_hasil_ujian()
    {
        return $this->db->query("
            SELECT jawaban.keterangan,
                soal.soal
            FROM jawaban
                INNER JOIN soal
                    ON jawaban.soal_id=soal.id_soal
            WHERE 1=1
                AND soal.id_grup_soal='{$this->post['id_grup_soal']}'
                AND jawaban.nis='".$this->session->userdata('username')."'
        ")->result_object();
    }
/* ==================== End Hasil Ujian ==================== */

/* ==================== Start Profil ==================== */
    public function data_siswa_edit()
    {
        return $this->db->query("
            SELECT *
            FROM siswa
                LEFT JOIN users
                    ON siswa.username=users.username
            WHERE siswa.username='{$this->username}'
        ")->row();
    }
    public function data_kelas_siswa()
    {
        return $this->db->query("
        SELECT * FROM pbm,pelajaran,kelas WHERE pbm.id_pelajaran=pelajaran.id_pelajaran AND kelas.id_kelas=pelajaran.id_kelas AND nis='{$this->username}' GROUP BY kelas.id_kelas
        ")->row();
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
    public function data_siswa_update()
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
        return $this->db->update('siswa',$data,$where);
    }

    # update user
    public function user_update()
    {
        return $this->db->update('users',[
            'password'=> md5($this->post['password']),
        ],['username'=>$this->post['username'] ]);
    }
/* ==================== End Profil ==================== */
}
