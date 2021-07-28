  <footer class="main-footer">
    <strong>Ujian Online &copy; <?php echo date('Y') ?> SMP N 1 Sedayu 
		
    <!-- <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.0-alpha
    </div> -->
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url()?>/themes/adminlte/code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url()?>/themes/adminlte/adminlte.io/themes/dev/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo base_url()?>/themes/adminlte/cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?php echo base_url()?>/themes/adminlte/adminlte.io/themes/dev/adminlte/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url()?>/themes/adminlte/adminlte.io/themes/dev/adminlte/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo base_url()?>/themes/adminlte/adminlte.io/themes/dev/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url()?>/themes/adminlte/adminlte.io/themes/dev/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url()?>/themes/adminlte/adminlte.io/themes/dev/adminlte/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url()?>/themes/adminlte/cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="<?php echo base_url()?>/themes/adminlte/adminlte.io/themes/dev/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url()?>/themes/adminlte/adminlte.io/themes/dev/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url()?>/themes/adminlte/adminlte.io/themes/dev/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url()?>/themes/adminlte/adminlte.io/themes/dev/adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url()?>/themes/adminlte/adminlte.io/themes/dev/adminlte/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>/themes/adminlte/adminlte.io/themes/dev/adminlte/dist/js/adminlte.js"></script>
<script>
window.setTimeout("waktu()",1000); 
function waktu() { 
  var tanggal = new Date(); 
  setTimeout("waktu()",1000); 
  document.getElementById("jam").innerHTML = tanggal.getHours(); 
  document.getElementById("menit").innerHTML = ': '+tanggal.getMinutes();
  document.getElementById("detik").innerHTML = ': '+tanggal.getSeconds();

  document.getElementById("tglSekarang").innerHTML = getTanggalIndoSekarang();
}

function getTanggalIndoSekarang()
{
  var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

  var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];

  var date = new Date();

  var day = date.getDate();

  var month = date.getMonth();

  var thisDay = date.getDay(),

      thisDay = myDays[thisDay];

  var yy = date.getYear();

  var year = (yy < 1000) ? yy + 1900 : yy;

  return (thisDay + ', ' + day + ' ' + months[month] + ' ' + year);

}

function countDownUjian()
{
  // Set the date we're counting down to
  var d= waktuUjian( $('td#countDownUjian').attr('data-tanggal') ,parseInt($('td#countDownUjian').attr('data-waktu')) );
  var countDownDate = new Date(`${d.dates} ${d.end}`).getTime();
  // var countDownDate = new Date("2019-07-14 15:37:25").getTime();

  // Update the count down every 1 second
  var x = setInterval(function() {

    // Get today's date and time
    var now = new Date().getTime();
      
    // Find the distance between now and the count down date
    var distance = countDownDate - now;
      
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
      
    // Output the result in an element with id="demo"
    // document.getElementById("countDownUjian").innerHTML = days + "d " + hours + "h "
    // + minutes + "m " + seconds + "s ";
    document.getElementById("countDownUjian").innerHTML = hours + " Jam "
    + minutes + " Menit " + seconds + " Detik ";
    // If the count down is over, write some text 
    if (distance < 0) { 
      clearInterval(x);
      $.get('<?php echo base_url() ?>siswa/proses-ujian/?timeout=true', function(data){
        $('#myModal .modal-title').html('Proses Ujian');
        $('#myModal .modal-body').html(data);
        document.getElementById("countDownUjian").innerHTML = "Waktu Sudah Habis";
        $('#myModal').modal('show');
      } ,'html');
    }
  }, 1000);
}
  <?php
    if ( $this->uri->segment(2)!='data-ujian' ) {
      ?>
        /* cek proses ujian */
        $.get('<?php echo base_url() ?>siswa/cek-proses-ujian',function(data){
          if ( data==1 ) 
            window.location.replace('<?php echo base_url() ?>siswa/data-ujian')
        })
      <?php
    }
  ?>
</script>
</body>

</html>
