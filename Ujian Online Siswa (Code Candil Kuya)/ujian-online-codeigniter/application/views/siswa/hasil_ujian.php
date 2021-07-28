  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Informasi Hasil Ujian</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('siswa') ?>">Beranda</a></li>
              <li class="breadcrumb-item active">Informasi Hasil Ujian</li>
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
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                  <table class="table example1 table-bordered table-striped" style="width:100%">
                      <thead>
                          <tr>
                            <th>Judul Ujian</th>
                            <th>Nama Pelajaran </th>
                            <th>Tanggal&nbspdan&nbspWaktu&nbspUjian</th>
                            <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php
                          // print_r($_SESSION);
                          foreach ($rows as $key => $value) {
                            if ( $value->counts > 0 ) {
                              $metode = json_decode($value->metode_acak);
                              echo "
                                <tr>
                                  <td>{$value->nama_grup_soal}</td>
                                  <td>{$value->nama_pelajaran}</td>
                                  <td class='tanggal-waktu-ujian' data-tanggal='{$metode->bdaytime}' data-waktu='{$metode->bminutes}'></td>
                                  <td>
                                    <a class='btn btn-block btn-outline-primary detail' href='".base_url('siswa/detail-hasil-ujian/' .$value->id_grup_soal)."'>Lihat Hasil Ujian</a>
                                  </td>
                                </tr>
  
                              ";
                            }
                          }
                        ?>
                      </tbody>
                  </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
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
  $.each($('td.tanggal-waktu-ujian'),function(i,item){
    var d       = waktuUjian($(item).attr('data-tanggal'), parseInt($(item).attr('data-waktu')));
    $(item).html(`<b class="badge badge-info">${d.dates_indo} Jam:&nbsp${d.start} s/d ${d.end} (`+$(item).attr('data-waktu')+` Menit )</b>`);
  })
});
$(document).on('click', '.form-add-new', function(e){
  e.preventDefault();
  $.get($(this).attr('href'), function(data){
    $('#myModal .modal-title').html('Tambah Data Informasi Template');
    $('#myModal .modal-body').html(data);
    $('#myModal').modal('show');
  },'html');
});
$('.detail').on('click', function(e){
  e.preventDefault(); 
  $.get( $(this).attr('href'), function(data){
    $('#myModal .modal-title').html('Detail Hasil Ujian');
    $('#myModal .modal-body').html(data);
    $('#myModal').modal('show');
  } ,'html');
});
function waktuUjian(dateString="2019-07-15T07:00",bminutes=30)
  {
    /* var dateString = '2019-07-15T07:00'
    var bminutes = 30
    return {
      "dates" : "2019-07-15",
      "interval" : 30,
      "start" : "07:00",
      "end" : "07:30",
    } */
    var dateTimeParts = dateString.split('T'),
      timeParts = dateTimeParts[1].split(':'),
      dateParts = dateTimeParts[0].split('-'),
      date;
    var times;
    var timePartsMinutesTotal= parseInt(timeParts[1])+bminutes;
    if ( timePartsMinutesTotal >= 60 ) {
      var timeParts0= parseInt(timeParts[0]) +Math.floor(timePartsMinutesTotal/60);
        timeParts0= (timeParts0 > 23 
          ? ( timeParts0==24
            ? '00'
            : ( (timeParts0%24 < 10)
              ? '0'+(timeParts0%24).toString()
              : (timeParts0%24).toString()
            )
          )
          : (timeParts0 < 10
            ? '0'+timeParts0.toString()
            : timeParts0.toString()
          )
        );
      var timeParts1= timePartsMinutesTotal%60;
        timeParts1= (timeParts1 < 10
          ? '0'+timeParts1.toString()
          : timeParts1.toString()
        );
      times = timeParts0+':'+timeParts1;
    } else {
      var timeParts1= timePartsMinutesTotal;
        timeParts1= (timeParts1 < 10
          ? '0'+timeParts1.toString()
          : timeParts1.toString()
        );
      times = timeParts[0]+':'+timeParts1;
    }

    /* membuat tanggal indonesia */
    var d = new Date(dateTimeParts[0]);
    var weekday = new Array(7);
    weekday[0] = "Minggu";
    weekday[1] = "Senin";
    weekday[2] = "Selasa";
    weekday[3] = "Rabu";
    weekday[4] = "Kamis";
    weekday[5] = "Jumat";
    weekday[6] = "Sabtu";

    var hari = weekday[d.getDay()];

    var month = new Array();
    month[0] = "Januari";
    month[1] = "Februari";
    month[2] = "Maret";
    month[3] = "April";
    month[4] = "Mei";
    month[5] = "Juni";
    month[6] = "Juli";
    month[7] = "Agustus";
    month[8] = "September";
    month[9] = "Oktober";
    month[10] = "November";
    month[11] = "Desember";

    var bulan = month[d.getMonth()];

    return {
      "dates" : dateTimeParts[0],
      "dates_indo" : `Hari ${hari}, ${dateParts[2]} ${bulan} ${dateParts[0]}`,
      "interval" : bminutes,
      "start" : dateTimeParts[1], 
      "end" : times
    };
  }
</script>