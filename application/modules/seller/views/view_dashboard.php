<?php $this->load->view('themes/front/view_header', ['title' => 'Seller Dashboard']) ?>
  <br>
  <div class="container">
    <div class="row">
      <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <img src="<?php echo base_url() ?>public/img/petani.png" class="img-thumbnail">
            <p class="typography-body-2 mt-2 text-success text-center"><?php echo $me->seller_name ?></p>
            <p class="typography-body-2 text-muted text-center">Rp<?php echo number_format($me->seller_balance) ?></p>
            <a href="<?php echo site_url('seller/account') ?>" class="btn btn-block btn-primary">Ubah Profil</a> 
            <a href="<?php echo site_url('seller/payment') ?>" class="btn btn-block btn-warning">Pembayaran</a>
          </div>
        </div>
      </div>
      <div class="col-sm-9">
        <?php if($order_num > 0): ?>
          <div class="container">
            <div class="row">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-body">
                    <a href="<?php echo site_url('seller/order') ?>">Anda memiliki <?php echo $order_num ?> pesanan produk</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
        <div class="container mt-3">
          <div class="float-left"><h4>Daftar Produk Anda</h4></div>
          <div class="float-right">
            <a href="<?php echo site_url('seller/product/add') ?>" class="btn btn-primary">Tambah Produk</a>
          </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="container">
          <div class="row">
            <?php foreach ($data as $d): ?>
              <div class="col-sm-4 mb-4 d-flex align-items-stretch">
                <div class="card card-product">
                  <a href="<?php echo site_url('seller/product/edit/'.$d->product_id) ?>">
                    <img class="card-img-top" src="<?php echo base_url('public/seller/product/resize-'.$d->product_picture) ?>" alt="<?php echo $d->product_title ?>">
                  </a>
                  <div class="card-body d-flex flex-column">
                    <div class="card-text" style="margin:0!important">
                      <a href="<?php echo site_url('seller/product/edit/'.$d->product_id) ?>" class="text-success"><?php echo $d->product_title ?></a>
                      <br>
                      <strong class="card-text">Rp<?php echo number_format($d->product_price) ?></strong>
                      <br>
                      <small class="font-italic"><?php echo productStatus($d->product_status) ?></small>
                    </div>
                    <div class="text-center mt-auto">
                      <a href="<?php echo site_url('seller/product/picture/'.$d->product_id) ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" data-title="Ubah Gambar">&nbsp;<i class="fa fa-image"></i>&nbsp;</a> 
                      <a href="<?php echo site_url('seller/product/edit/'.$d->product_id) ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-title="Ubah Keterangan">&nbsp;<i class="fa fa-pencil"></i>&nbsp;</a>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
<?php $this->load->view('themes/front/view_footer_script') ?>
<?php $this->load->view('themes/front/view_footer') ?>
