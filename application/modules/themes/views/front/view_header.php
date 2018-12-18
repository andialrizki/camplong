<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo base_url() ?>favicon.ico">

    <title>Camplong - Jambu Camplong Khas <?php echo (!empty($title) ? '- '.$title : '') ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url() ?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>public/bootstrap/css/material.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url() ?>public/bootstrap/css/carousel.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>public/bootstrap/css/custom.css" rel="stylesheet">
  </head>
  <body>

    <header>
      <nav class="navbar navbar-expand-md fixed-top navbar-light bg-light navbar-shadow">
        <div class="container justify-content-md-center">
          <a class="navbar-brand" href="<?php echo site_url() ?>">Camplong</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url() ?>">Beranda</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('store') ?>">Pasar</a>
              </li>
            </ul>
            <ul class="navbar-nav ml-auto">
              <?php if(!isSellerLogin()): ?>
                <li class="nav-item">
                  <?php $cart = count($this->cart->contents()) ?>
                  <a class="nav-link" href="<?php echo site_url('store/cart') ?>"><i class="fa fa-shopping-cart"></i> Keranjang 
                    <?php if($cart > 0): ?>
                      <sup class="badge badge-pill badge-danger" style="font-size: smaller!important;"><?php echo $cart ?></sup>
                    <?php endif; ?>
                  </a>
                </li>
              <?php endif; ?>
              <?php if(isSellerLogin()): ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo site_url('seller/dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-gears"></i> Akun</a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo site_url('seller/account') ?>">Edit Profil</a>
                    <a class="dropdown-item" href="<?php echo site_url('seller/order') ?>">Pemesanan</a>
                    <a class="dropdown-item" href="<?php echo site_url('seller/payment') ?>">Pembayaran</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo site_url('seller/signin/out') ?>">Keluar</a>
                  </div>
                </li>
              <?php elseif (isCustomerLogin()): ?>
                <?php $cust = getCustomerSession() ?>
                <?php $cekPay = $this->db->select('transaction_status')->get_where('transaction', ['transaction_customer_id'=>$cust->id, 'transaction_status'=>1])->num_rows(); ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo site_url('customer/dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-gears"></i> Akun
                    <?php if($cekPay > 0): ?>
                      <sup class="badge badge-pill badge-danger" style="font-size: smaller!important;"><?php echo $cekPay ?></sup>
                    <?php endif; ?>
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo site_url('customer/account') ?>">Edit Profil</a>
                    <a class="dropdown-item" href="<?php echo site_url('customer/order') ?>">Pemesanan</a>
                    <a class="dropdown-item" href="<?php echo site_url('store/cart/payment') ?>">
                      Pembayaran 
                      <?php if($cekPay > 0): ?>
                        <sup class="badge badge-pill badge-danger" style="font-size: smaller!important;"><?php echo $cekPay ?></sup>
                      <?php endif; ?>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo site_url('customer/signin/out') ?>">Keluar</a>
                    
                  </div>
                </li>
              <?php else: ?>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-gears"></i> Akun</a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#mdl-register">Daftar</a>
                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#mdl-signin">Masuk</a>
                  </div>
                </li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <main role="main" class="mt-2">