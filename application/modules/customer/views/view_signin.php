<?php $this->load->view('themes/front/view_header', ['title' => 'Masuk']) ?>
  <br>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-success text-center">Masuk Akun Pembeli</h5>
            <hr>
            <?php echo showAlert($alert) ?>
            <p>Apakah Anda belum memiliki Akun? <a href="<?php echo site_url('customer/register') ?>">Daftar disini</a></p>
            <form action="<?php echo site_url('customer/signin/submit?source='.$source) ?>" method="post" autocomplete="off">
              <div class="form-group">
                <label>Alamat Email atau Nomor Handphone</label>
                <input type="text" class="form-control" placeholder="ketik disini" name="ids" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label>Kata Sandi</label>
                <input type="password" class="form-control" placeholder="ketik disini" name="password" autocomplete="new-password" required>
              </div>
              <button type="submit" class="btn btn-success btn-block">MASUK</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
<?php $this->load->view('themes/front/view_footer_script') ?>
<?php $this->load->view('themes/front/view_footer') ?>
