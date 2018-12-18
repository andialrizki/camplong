<?php $this->load->view('themes/front/view_header', ['title' => 'Produk']) ?>
  <br>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <?php if($data->num_rows() > 0): ?>
              <?php $d = $data->row(); ?>
              <div class="row">
                <div class="col-sm-4">
                  <img class="img-thumbnail" src="<?php echo base_url('public/seller/product/'.$d->product_picture) ?>" alt="<?php echo $d->product_title ?>">
                </div>
                <div class="col-sm-8">
                  <h5 class="card-title text-success"><?php echo $d->product_title ?></h5>
                  <h3 class="card-title text-dark">Rp<?php echo number_format($d->product_price) ?></h3>
                  <table class="table">
                    <tr>
                      <th style="width: 120px">Penjual</th>
                      <td>
                        <a href="<?php echo site_url('store/seller/'.$d->seller_id) ?>"><?php echo $d->seller_name ?></a> <br><small class="font-italic text-muted">klik nama penjual untuk melihat produk lainnya</small>
                      </td>
                    </tr>
                    <tr>
                      <th>Kategori</th>
                      <td><a href="<?php echo site_url('store/category/'.$d->category_url) ?>"><?php echo $d->category_title ?></a></td>
                    </tr>
                    <tr>
                      <th>Berat</th>
                      <td><?php echo $d->product_weight ?> <small class="font-italic text-muted">gram</small></td>
                    </tr>
                    <tr>
                      <th>Deskripsi</th>
                      <td><?php echo $d->product_description ?></td>
                    </tr>
                  </table>
                  <?php if(!isSellerLogin()): ?>
                    <form class="form-inline">
                      <div class="form-group mb-2 mr-1">
                        <label class="text-dark">Qty</label>
                      </div>
                      <div class="form-group mx-sm-3 mb-2 mr-1">
                        <label for="inputPassword2" class="sr-only">masukkan qty</label>
                        <input type="number" min="1" class="form-control" id="qty" placeholder="(cth: 1)" value="1">
                      </div>
                      <div class="mb-2">
                        <button type="button" onclick="addToCart(this)" class="btn btn-success">BELI SEKARANG</button>
                      </div>
                    </form>
                    <!-- <button class="btn btn-success btn-block" type="button" onclick="addToCart()" data-toggle="modal" data-target="#mdl-cart" data-backdrop="static">BELI SEKARANG</button> -->
                  <?php endif; ?>
                </div>
              </div>
            <?php else: ?>
              <?php echo showAlert(['status'=>'error', 'message'=>'Produk tidak ditemukan']) ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
  <!-- Modal -->
  <div class="modal fade" id="mdl-cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Keranjang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Produk sudah dimasukkan ke <strong>Keranjang Anda</strong>.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Lanjutkan Belanja</button>
          <a href="<?php echo site_url('store/cart') ?>" class="btn btn-primary">Lihat Keranjang</a>
        </div>
      </div>
    </div>
  </div>
<?php $this->load->view('themes/front/view_footer_script') ?>
<script type="text/javascript">
  function addToCart(btn) {
    var qty = $("#qty").val();
    $.ajax({
      url: "<?php echo site_url('store/cart/add_to_cart') ?>",
      data: {prod: "<?php echo $d->product_url ?>", qty: qty},
      dataType: "json",
      type: "GET",
      beforeSend: function() {
        btn.innerHTML = '<i class="fa fa-refresh fa-spin"></i>';
        btn.disabled = true;
      }, 
      success: function(res) {
        btn.innerHTML = 'BELI SEKARANG';
        btn.disabled = false;
        if (res.status == "success") {
          $("#mdl-cart").modal({
            backdrop:"static",
            show:true
          })
        }
      }
    })
  }
</script>
<?php $this->load->view('themes/front/view_footer') ?>
