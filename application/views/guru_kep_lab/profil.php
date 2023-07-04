  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Informasi Profil</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url() ?>guru-kep-lab">Beranda</a></li>
              <li class="breadcrumb-item active">Informasi Profil</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- <div class="card-header"> -->
              <!-- <h3 class="card-title">Daftar Informasi Kelas</h3> -->
            <!-- </div> -->
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered">
                <tbody>
                  <tr>
                    <td colspan="2"><a href="<?php echo base_url('guru-kep-lab/edit-profil/'.$row->username) ?>" class="btn btn-primary edit">Edit</a></td>
                  </tr>
                  <tr>
                    <td><label>NIP</label></td>
                    <td><?php echo $row->nip ?></td>
                  </tr>
                  <tr>
                    <td><label>Nama Guru</label></td>
                    <td><?php echo $row->nama ?></td>
                  </tr>
                  <tr>
                    <td><label>Pelajaran</label></td>
                    <td>
                    <?php
                      if ( count($pelajaran) > 0 ) {
                        echo '<ol>';
                        foreach ($pelajaran as $key => $value) {
                          echo "<li>{$value->nama_pelajaran} ({$value->nama_kelas})</li>";
                        }
                        echo '</ol>';
                      } else {
                        echo 'Maaf Anda Belum Terdaftar PBM Silahkan Menghubungi Bagian Operasional';
                      }
                    ?>
                    </td>
                  </tr>
                  <tr>
                    <td><label>Tahun Ajaran</label></td>
                    <td>
                    <?php
                      if ( count($pelajaran) > 0 ) {
                        print_r($pelajaran[0]->tahun_ajaran);
                      } else {
                        echo 'Maaf Anda Belum Terdaftar PBM Silahkan Menghubungi Bagian Operasional';
                      }
                    ?>
                    </td>
                  </tr>
                  <tr>
                    <td><label>Jenis Kelamin</label></td>
                    <td><?php echo ($row->jk=='L' ? 'Laki-Laki' : 'Perempuan' ) ?></td>
                  </tr>
                  <tr>
                    <td><label>Agama</label></td>
                    <td><?php echo $row->agama ?></td>
                  </tr>
                  <tr>
                    <td><label>Tempat Lahir</label></td>
                    <td><?php echo $row->tempat_lahir ?></td>
                  </tr>
                  <tr>
                    <td><label>Tanggal Lahir</label></td>
                    <td><?php echo date("m-d-Y", strtotime($row->tgl_lahir)) ?></td>
                  </tr>
                  <tr>
                    <td><label>No Telp</label></td>
                    <td><?php echo $row->no_telp ?></td>
                  </tr>
                  <tr>
                    <td><label>Email</label></td>
                    <td><?php echo $row->email ?></td>
                  </tr>
                  <tr>
                    <td><label>Alamat</label></td>
                    <td><?php echo $row->alamat ?></td>
                  </tr>
                  <tr>
                    <td><label>Username</label></td>
                    <td><?php echo $row->username ?></td>
                  </tr>
                  <tr>
                    <td><label>Foto</label></td>
                    <td><?php echo ($row->gambar=='NULL'? 'Belum Ada Foto' : '<img class="d-block img-thumbnail" src="'.base_url('src/guru/'.$row->gambar).'">') ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          Modal body..
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
  <!-- /.modal -->

<script>
  $('.edit').on('click', function(e){
    e.preventDefault(); 
    $.get( $(this).attr('href'), function(data){
      $('#myModal .modal-title').html('Edit Informasi Profil');
      $('#myModal .modal-body').html(data);
      $('#myModal').modal('show');
    } ,'html');
  });

  $(document).on('submit','form#edit',function(e){
    e.preventDefault();    
    var formData = new FormData(this);
    $.ajax({
        url: $(this).attr("action"),
        type: 'POST',
        data: formData,
        success: function (data) {
          // console.log(data)
            alert( (data.stats=='1') ? data.msg : data.msg )
            location.reload()
        },
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json'
    });
  });
</script>