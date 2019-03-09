<?php $this->load->view('themes/back/view_header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Transaksi
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo webmin_url() ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Transaksi</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="fa fa-shopping-cart"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Pemesanan</span>
            <span class="info-box-number"><?php echo $order ?></span>
            <a href="<?php echo site_url('webmin/transaction/order') ?>" class="btn btn-xs btn-info"><i class="fa fa-arrow-circle-right"></i> Selengkapnya</a>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-yellow"><i class="fa fa-edit"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Konfirmasi Pembayaran</span>
            <span class="info-box-number"><?php echo $confirm ?></span>
            <a href="<?php echo site_url('webmin/transaction/confirm') ?>" class="btn btn-xs btn-warning"><i class="fa fa-arrow-circle-right"></i> Selengkapnya</a>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-blue"><i class="fa fa-retweet"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Diproses Penjual</span>
            <span class="info-box-number"><?php echo $process ?></span>
            <a href="<?php echo site_url('webmin/transaction/sellerprocess') ?>" class="btn btn-xs btn-primary"><i class="fa fa-arrow-circle-right"></i> Selengkapnya</a>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->

      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-yellow"><i class="fa fa-truck"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Pengiriman</span>
            <span class="info-box-number"><?php echo $shipping ?></span>
            <a href="<?php echo site_url('webmin/transaction/shipping') ?>" class="btn btn-xs btn-warning"><i class="fa fa-arrow-circle-right"></i> Selengkapnya</a>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-red"><i class="fa fa-info"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Gagal</span>
            <span class="info-box-number"><?php echo $falied ?></span>
            <a href="<?php echo site_url('webmin/transaction/failed') ?>" class="btn btn-xs btn-danger"><i class="fa fa-arrow-circle-right"></i> Selengkapnya</a>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <!-- <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-teal"><i class="fa fa-user-times"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Komplain Pembeli</span>
            <span class="info-box-number"><?php echo $complaint ?></span>
            <a href="<?php echo site_url('webmin/transaction/complaint') ?>" class="btn btn-xs btn-info"><i class="fa fa-arrow-circle-right"></i> Selengkapnya</a>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-maroon"><i class="fa fa-usd"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Pengembalian Saldo</span>
            <span class="info-box-number"><?php echo $refund ?></span>
            <a href="<?php echo site_url('webmin/transaction/refund') ?>" class="btn btn-xs btn-danger"><i class="fa fa-arrow-circle-right"></i> Selengkapnya</a>
          </div>
        </div>
      </div> -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Selesai</span>
            <span class="info-box-number"><?php echo $finish ?></span>
            <a href="<?php echo site_url('webmin/transaction/finish') ?>" class="btn btn-xs btn-success"><i class="fa fa-arrow-circle-right"></i> Selengkapnya</a>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->

      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="fa fa-list"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Rekap Transaksi</span>
            <span class="info-box-number"><?php echo $all ?></span>
            <a href="<?php echo site_url('webmin/transaction/recap') ?>" class="btn btn-xs btn-info"><i class="fa fa-arrow-circle-right"></i> Selengkapnya</a>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
</div>
<?php $this->load->view('themes/back/view_footer_script'); ?>
<?php $this->load->view('themes/back/view_footer'); ?>
