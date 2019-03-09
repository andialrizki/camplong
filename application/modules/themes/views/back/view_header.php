<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Adminstator | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo private_url() ?>bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo private_url() ?>plugins/datatables/dataTables.bootstrap.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo public_url() ?>css/font-awesome.min.css">
    <!-- Ionicons -->
   <!--  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo private_url() ?>dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo private_url() ?>dist/css/skins/_all-skins.min.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?php echo private_url() ?>plugins/datepicker/datepicker3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?php echo private_url() ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A</b>DM</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Admin</b>strator</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- <img src="<?php echo private_url() ?>dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                  <span class="hidden-xs">Alexander Pierce</span> -->
                  <i class="fa fa-user"></i> Menu
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <!-- <img src="<?php echo private_url() ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"> -->
                    <i class="fa fa-user"></i>
                    <p>
                      Adminstator
                      <small><?php echo date('D, d F Y') ?></small>
                    </p>
                  </li>
                  <!-- <li class="user-body">
                    <div class="col-xs-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </li> -->
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?php echo webmin_url('auth/logout') ?>" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <!-- <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li> -->
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>

            <?php $url = $this->uri->segment(2) ?>
            <?php $url2 = $this->uri->segment(3) ?>
            <li class="<?php echo ($url == 'dashboard' ? 'active' : '') ?>">
              <a href="<?php echo webmin_url('dashboard') ?>">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
            <li class="treeview <?php echo ($url == 'product' ? 'active' : '') ?>">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Produk</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo webmin_url('product/category') ?>"><i class="fa fa-circle-o"></i> Atur Kategori</a></li>
                <li><a href="<?php echo webmin_url('product/show') ?>"><i class="fa fa-circle-o"></i> Tampilkan Produk</a></li>
              </ul>
            </li>
            <li class="<?php echo ($url == 'transaction' ? 'active' : '') ?>">
              <a href="<?php echo webmin_url('transaction/overview') ?>">
                <i class="fa fa-building-o"></i> <span>Transaksi</span>
              </a>
            </li>
            <li class="<?php echo ($url == 'bank' ? 'active' : '') ?>">
              <a href="<?php echo webmin_url('bank') ?>">
                <i class="fa fa-file-code-o"></i> <span>Akun Bank</span>
              </a>
            </li>
            <li class="<?php echo ($url2 == 'banner' ? 'active' : '') ?>">
              <a href="<?php echo webmin_url('setting/banner') ?>">
                <i class="fa fa-image"></i> <span>Banner</span>
              </a>
            </li>
            <li class="treeview <?php echo ($url == 'user' ? 'active' : '') ?>">
              <a href="#">
                <i class="fa fa-user"></i>
                <span>Pengguna</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo webmin_url('user/seller') ?>"><i class="fa fa-circle-o"></i> Penjual</a></li>
                <li><a href="<?php echo webmin_url('user/customer') ?>"><i class="fa fa-circle-o"></i> Pembeli</a></li>
              </ul>
            </li>
            <li class="treeview <?php echo ($url2 == 'reqfund' ? 'active' : '') ?>">
              <a href="#">
                <i class="fa fa-user"></i>
                <span>Pencairan Saldo</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo webmin_url('seller/reqfund') ?>"><i class="fa fa-circle-o"></i> Penjual</a></li>
                <li><a href="<?php echo webmin_url('customer/reqfund') ?>"><i class="fa fa-circle-o"></i> Pembeli</a></li>
              </ul>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>