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
              <li class="breadcrumb-item"><a href="<?php echo base_url('guru') ?>">Beranda</a></li>
              <!-- <li class="breadcrumb-item active">Dashboard</li> -->
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-12 col-12">
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h5><i class="icon fa fa-check"></i> Info!</h5>
              Selamat Datang Di halaman Admin Guru.
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
                <h3> <?php echo $grup_soal_count ?> </h3>

                <p>Informasi Grup Soal</p>
              </div>
              <!-- <div class="icon">
                <i class="ion ion-android-clipboard"></i>
              </div> -->
              <a href="<?php echo base_url('guru/data-grup-soal')?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3> <?php echo $soal_count ?> </sup></h3>

                <p>Informasi Soal</p>
              </div>
              <!-- <div class="icon">
                <i class="ion ion-android-checkbox-outline"></i>
              </div> -->
              <a href="<?php echo base_url('guru/data-soal') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
        <!-- Main row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->