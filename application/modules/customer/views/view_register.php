<?php $this->load->view('themes/front/view_header', ['title' => 'Daftar']) ?>
  <br>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-success text-center">Daftar Akun Pembeli</h5>
            <hr>
            <?php echo showAlert($alert) ?>
            <p>Apakah Anda sudah memiliki Akun? <a href="<?php echo site_url('customer/signin?source='.$source) ?>">Masuk disini</a></p>
            <form action="<?php echo site_url('customer/register/submit?source='.$source) ?>" method="post" autocomplete="off">
              <div class="form-group">
                <label>Nama Anda</label>
                <input type="text" class="form-control" placeholder="ketik disini" name="post[customer_name]" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label>Alamat Email</label>
                <input type="email" class="form-control" placeholder="ketik disini" name="post[customer_email]" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label>Nomor Handphone</label>
                <input type="text" class="form-control" placeholder="ketik disini" name="post[customer_nohp]" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label>Kata Sandi</label>
                <input type="password" class="form-control" placeholder="ketik disini" name="post[customer_password]" autocomplete="new-password" required>
              </div>
              <div class="form-group">
                <label>Ulangi Kata Sandi</label>
                <input type="password" class="form-control" placeholder="ketik disini" name="repassword" autocomplete="new-password" required>
              </div>
              <button type="submit" class="btn btn-success btn-block">DAFTAR</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
<?php $this->load->view('themes/front/view_footer_script') ?>
<script type="text/javascript">
  function sendFdata(){
    var fdata = <?php echo $fdata ?>;
    if (fdata != null) {
      $.each(fdata, function(i, v) {
        $(".form-control[name='post[" + i + "]']").val(v);
      })
    }
  }
  sendFdata();
</script>
<?php $this->load->view('themes/front/view_footer') ?>
