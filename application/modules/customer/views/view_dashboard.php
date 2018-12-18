<?php $this->load->view('themes/front/view_header', ['title' => 'Customer Dashboard']) ?>
  <br>
  <div class="container">
    <div class="row">
      <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <img src="<?php echo base_url() ?>public/img/petani.png" class="img-thumbnail">
            <p class="typography-body-2 mt-2 text-success text-center"><?php echo $me->customer_name ?></p>
            <a href="<?php echo site_url('customer/account') ?>" class="btn btn-block btn-primary">Ubah Profil</a> 
            <a href="<?php echo site_url('store/cart/payment') ?>" class="btn btn-block btn-warning">Pembayaran</a>
            <a href="<?php echo site_url('customer/order') ?>" class="btn btn-block btn-info">Pemesanan</a>
          </div>
        </div>
      </div>
      <div class="col-sm-9">

      </div>
    </div>
  </div>
  <br>
<?php $this->load->view('themes/front/view_footer_script') ?>
<?php $this->load->view('themes/front/view_footer') ?>
