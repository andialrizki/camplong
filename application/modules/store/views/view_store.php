<?php $this->load->view('themes/front/view_header', ['title' => 'Pasar']) ?>
  <br>
  <div class="container">
    <div class="row">
      <?php foreach ($data as $d): ?>
        <div class="col-sm-3 mb-4 d-flex align-items-stretch">
          <div class="card card-product">
            <a href="<?php echo site_url('store/product/detail/'.$d->product_url) ?>">
              <img class="card-img-top" src="<?php echo base_url('public/seller/product/resize-'.$d->product_picture) ?>" alt="<?php echo $d->product_title ?>">
            </a>
            <div class="card-body d-flex flex-column">
              <div class="card-text" style="margin:0!important">
                <a href="<?php echo site_url('store/product/detail/'.$d->product_url) ?>" class="text-success"><?php echo $d->product_title ?></a>
                <br>
                <strong class="card-text">Rp<?php echo number_format($d->product_price) ?></strong>
                <br>
                <small class="font-italic"><?php echo $d->seller_name ?></small>
                <br>
                <small class="font-italic">
                  <?php for ($i=1; $i <= floor($d->rating); $i++):?>
                    <i class="fa fa-star" style="color: orange"></i> 
                  <?php endfor; ?>
                </small>
              </div>
              <div class="text-center mt-auto">
                <a href="<?php echo site_url('store/product/detail/'.$d->product_url) ?>" class="btn btn-primary btn-sm">DETAIL</a> 
              </div>
            </div>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
  <br>
<?php $this->load->view('themes/front/view_footer_script') ?>
<?php $this->load->view('themes/front/view_footer') ?>
