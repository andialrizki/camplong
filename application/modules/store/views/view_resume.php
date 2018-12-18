<?php $this->load->view('themes/front/view_header', ['title' => 'Keranjang']) ?>
  <br>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-success">Keranjang Anda</h5>
            <hr>
            <?php if(!isCustomerLogin()): ?>
              <?php echo showAlert(['status'=>'info', 'message'=>'Untuk melanjutkan ke tahap pembayaran, Anda harus masuk sebagai akun <b>Pembeli</b> terlebih dahulu']) ?> 
              <p>Apakah Anda sudah memiliki Akun? jika iya <a href="<?php echo site_url('customer/signin?source=cart') ?>">Masuk disini</a>.</p>
              <p>Jika belum, <a href="<?php echo site_url('customer/register?source=cart') ?>">Mendaftar disini</a>.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
<?php $this->load->view('themes/front/view_footer_script') ?>
<?php $this->load->view('themes/front/view_footer') ?>
