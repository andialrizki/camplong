<?php $this->load->view('themes/front/view_header', ['title' => 'Gambar Produk']) ?>
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-sm-5">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-success text-center">Gambar Produk</h5>
            <hr>
            <?php echo showAlert($alert) ?>
            <p>Tambahkan gambar agar produk Anda lebih menarik minat calon pembeli</p>
            <div class="text-center" id="image">
              <img src="<?php echo base_url('public/seller/product/'.$data->product_picture) ?>" class="img-thumbnail" style="max-width: 320px">
              <br>
              Gambar saat ini
            </div>
            <form action="<?php echo site_url('seller/product/action/picture?id='.$data->product_id.'&first='.$first) ?>" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label>Pilih Gambar <small class="font-italic text-muted">(max 2MB)</small></label>
                <input type="file" class="form-control" name="file" onchange="showImage(this)" required>
              </div>
              <button type="submit" class="btn btn-primary btn-block">SIMPAN PERUBAHAN</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-success">Ringkasan Produk</h5>
            <table class="table">
              <tr>
                <th>Produk</th>
                <td><?php echo $data->product_title ?></td>
              </tr>
              <tr>
                <th>Kategori</th>
                <td><?php echo $data->category_title ?></td>
              </tr>
              <tr>
                <th>Harga</th>
                <td>Rp<?php echo number_format($data->product_price) ?></td>
              </tr>
              <tr>
                <th>Berat</th>
                <td><?php echo $data->product_weight ?> <small class="font-italic text-muted">gram</small></td>
              </tr>
              <tr>
                <th>Ketersediaan</th>
                <td><?php echo $data->product_stock.' <small class="font-italic text-muted">'.$data->product_stock_type.'</small>' ?></td>
              </tr>
              <tr>
                <th>Status</th>
                <td><?php echo productStatus($data->product_status) ?></td>
              </tr>
              <tr>
                <th>Deskripsi</th>
                <td><?php echo $data->product_description ?></td>
              </tr>
            </table>
            <a href="<?php echo site_url('seller/dashboard') ?>" class="btn btn-primary btn-block">KEMBALI KE DASHBOARD</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
<?php $this->load->view('themes/front/view_footer_script') ?>
<script type="text/javascript">
  function showImage(val) {
    readURL(val, '#image img');
  }
</script>
<?php $this->load->view('themes/front/view_footer') ?>
