  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url()?>/themes/adminlte/adminlte.io/themes/dev/adminlte/plugins/datatables/dataTables.bootstrap4.css">


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Informasi PBM</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url() ?>admin">Beranda</a></li>
              <li class="breadcrumb-item active">Informasi PBM</li>
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
            <div class="card-header">
              <!-- <h3 class="card-title">Daftar Informasi Kelas</h3> -->
              <a href="<?php echo base_url() ?>admin/form-data-pbm" class="btn btn-default float-right form-add-new"><i class="fa fa-plus"></i> Add New</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Tahun Ajaran</th>
                  <th>NIS</th>
                  <th>Nama Siswa</th>
                  <th>Kelas</th>
                  <th>Pelajaran</th>
                  <th>Nama Guru</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  foreach ($rows as $key => $value) {
                    echo "
                      <tr>
                        <td>{$value->tahun_ajaran}</td>
                        <td>{$value->nis}</td>
                        <td>{$value->nama_siswa}</td>
                        <td>{$value->nama_kelas}</td>
                        <td>{$value->nama_pelajaran}</td>
                        <td>{$value->nama_guru}</td>
                      </tr>
                    ";
                  }
                ?>
                
                </tbody>
                <!-- <tfoot>
                <tr>
                  <th>Nama Materi</th>
                  <th>Tanggal Upload</th>
                  <th>Tipe File</th>
                  <th>Action</th>
                </tr>
                </tfoot> -->
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

<!-- DataTables -->
<script src="<?php echo base_url()?>/themes/adminlte/adminlte.io/themes/dev/adminlte/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url()?>/themes/adminlte/adminlte.io/themes/dev/adminlte/plugins/datatables/dataTables.bootstrap4.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
  });
  $(document).on('click', '.form-add-new', function(e){
    e.preventDefault();
    $.get($(this).attr('href'), function(data){
      $('#myModal .modal-title').html('Tambah Data Informasi PBM');
      $('#myModal .modal-body').html(data);
      $('#myModal').modal('show');

      $('#inputNis').on('keyup',function(){
        $.get('<?php echo base_url() ?>admin/data-pbm-cek-nis',{"nis":$(this).val()},function(data){
            $('#alertInputNis').html(')'+data.msg);
            if ( data.stats == '1' ) {
                $.get('<?php echo base_url() ?>admin/data-pbm-pelajaran',{ "nis" : data.nis },function(_data){
                    $('#inputPelajaran').html(_data);
                    console.log(_data);
                },'html');
            }else{
                $('#inputPelajaran').html('<option value="">'+data.msg+'</option>');
            }
            console.log(data);
        },'json');
      });
    },'html');
  });
  $(document).on('submit', 'form#addNew', function(e) {
    e.preventDefault();    
    var formData = new FormData(this);
    $.ajax({
        url: $(this).attr("action"),
        type: 'POST',
        data: formData,
        success: function (data) {
          if ( data.stats==1 ) {
            alert( data.msg )
            location.reload()
          } else {
            alert( data.msg );
          }
          // console.log(data);
        },
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json'
    });
  });
</script>