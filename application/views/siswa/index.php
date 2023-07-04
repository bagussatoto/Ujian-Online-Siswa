<?php
$belum_ujian    = 0;
$selesai_ujian  = 0;
foreach ($rows as $key => $value) {
  if ( $value->counts > 0 )
    $selesai_ujian ++;
  else
    $belum_ujian ++;
}
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Beranda</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('siswa') ?>">Beranda</a></li>
              <!-- <li class="breadcrumb-item active">Dashboard</li> -->
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>/themes/adminlte/adminlte.io/themes/dev/adminlte/plugins/datatables/dataTables.bootstrap4.css">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-12 col-12">
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h5><i class="icon fa fa-check"></i> Info!</h5>
              Selamat Datang Di halaman Siswa.
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3> <?php echo $belum_ujian ?> </h3>

                <p>Ujian Belum Dikerjakan</p>
              </div>
              <div class="icon">
                <i class="ion ion-android-clipboard"></i>
              </div>
              <a href="<?php echo base_url('siswa/data-ujian')?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3> <?php echo $selesai_ujian ?> </sup></h3>

                <p>Ujian Diselesaikan</p>
              </div>
              <div class="icon">
                <i class="ion ion-android-checkbox-outline"></i>
              </div>
              <a href="<?php echo base_url('siswa/data-hasil-ujian') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6 d-none">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>&nbsp</h3>

                <p>Kelas</p>
              </div>
              <div class="icon">
                <i class=""></i>
              </div>
              <a href="<?php echo base_url('admin/data-kelas') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6 d-none">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>&nbsp</h3>

                <p>Pelajaran</p>
              </div>
              <div class="icon">
                <i class=""></i>
              </div>
              <a href="<?php echo base_url('admin/data-pelajaran') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
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
  $("table.example1").DataTable();
});
$(document).on('click', '.form-add-new', function(e){
  e.preventDefault();
  $.get($(this).attr('href'), function(data){
    $('#myModal .modal-title').html('Tambah Data Informasi Template');
    $('#myModal .modal-body').html(data);
    $('#myModal').modal('show');
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
$('.edit').on('click', function(e){
  e.preventDefault(); 
  $.get( $(this).attr('href'), function(data){
    $('#myModal .modal-title').html('Edit Informasi Template');
    $('#myModal .modal-body').html(data);
    $('#myModal').modal('show');
  } ,'html');
});

$('.delete').on('click', function(e){
  e.preventDefault(); 
  $.get( $(this).attr('href'), function(data){
    alert( (data.stats=='1') ? data.msg : data.msg )
    location.reload()
  } ,'json');
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