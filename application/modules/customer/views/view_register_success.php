<?php $this->load->view('themes/front/view_header', ['title' => 'Daftar']) ?>
  <br>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-success text-center">Daftar Akun Pembeli</h5>
            <hr>
            <?php echo showAlert(['status'=>'success', 'message'=>'Terimakasih karena telah melakukan pendaftaran sebagai pembeli, selanjutnya Anda harus login (masuk) dengan email atau nomor handphone dan kata sandi yang Anda buat tadi.']) ?>
            <a href="<?php echo site_url('customer/signin') ?>" class="btn btn-primary btn-block">
              KE HALAMAN MASUK
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
<?php $this->load->view('themes/front/view_footer_script') ?>
<?php $this->load->view('themes/front/view_footer') ?>
