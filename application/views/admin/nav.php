<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
    </ul>
    <table>
      <tr style="border-bottom: 1px solid #ddd;">
        <td id="tglSekarang" colspan="4"></td>
      </tr>
      <tr>
        <td>Jam </td>
        <td id="jam"></td>
        <td id="menit"></td>
        <td id="detik"></td>
      </tr>
    </table>

    <!-- Right navbar links -->
    <div class="navbar-nav ml-auto">
      <a href="<?php echo base_url() ?>admin/data-profil" class="btn btn-default mr-2">Profil</a>
      <a href="<?php echo base_url('auth/logout'); ?>" class="btn btn-default">Logout</a>
      
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
        <i class="fa fa-th-large"></i>
      </a>
    
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url('admin') ?>" class="brand-link">
      <img src="<?php echo base_url()?>/themes/adminlte/adminlte.io/themes/dev/adminlte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Ujian Online</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item ">
            <a href="<?php echo base_url('admin') ?>" class="nav-link <?php echo empty($this->uri->segment(2)) ? 'active' : null ; ?>">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>
                Beranda
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview <?php echo ($this->uri->segment(2) == 'data-admin' || $this->uri->segment(2) == 'data-guru' || $this->uri->segment(2) == 'data-siswa' || $this->uri->segment(2) == 'data-profil') ? 'menu-open' : null ; ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-user"></i>
              <p>
                Users
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url() ?>admin/data-admin" class="nav-link <?php echo ($this->uri->segment(2) == 'data-admin') ? 'active' : null ; ?>">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Admin</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url() ?>admin/data-guru" class="nav-link <?php echo ($this->uri->segment(2) == 'data-guru') ? 'active' : null ; ?>">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Guru</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url() ?>admin/data-siswa" class="nav-link <?php echo ($this->uri->segment(2) == 'data-siswa') ? 'active' : null ; ?>">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Siswa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url() ?>admin/data-profil" class="nav-link <?php echo ($this->uri->segment(2) == 'data-profil') ? 'active' : null ; ?>">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Profil</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview <?php echo ($this->uri->segment(2) == 'data-kelas' || $this->uri->segment(2) == 'data-pelajaran' || $this->uri->segment(2) == 'data-pbm') ? 'menu-open' : null ; ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-graduation-cap"></i>
              <p>
                Akademik
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item" >
                <a href="<?php echo base_url() ?>admin/data-kelas" class="nav-link <?php echo ($this->uri->segment(2) == 'data-kelas') ? 'active' : null ; ?>">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Kelas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/data-pelajaran')?>" class="nav-link <?php echo ($this->uri->segment(2) == 'data-pelajaran') ? 'active' : null ; ?>">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Pelajaran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/data-pbm')?>" class="nav-link <?php echo ($this->uri->segment(2) == 'data-pbm') ? 'active' : null ; ?>">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>PBM</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>