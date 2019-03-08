<?php $this->load->view('themes/front/view_header', ['title' => 'Pemesanan Produk']) ?>
  <br>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card mb-2">
          <div class="card-body">
            <h5 class="card-title text-success">Daftar Pesanan</h5>
            <hr>
          </div>
        </div>
        <div class="card mb-2">
          <div class="card-body">
            <form action="<?php echo site_url('seller/order/recap') ?>" method="get">
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Filter Berdasarkan :</label>
                <div class="col-sm-3">
                  <select class="form-control" onchange="changeFilter(this.value);" name="filter">
                    <option value="all" <?php echo ($filter == "all"?'selected':'') ?>>Semua</option>
                    <option value="not-confirm" <?php echo ($filter == "not-confirm"?'selected':'') ?>>Belum Dikonfirmasi</option>
                    <option value="shipping" <?php echo ($filter == "shipping"?'selected':'') ?>>Dikirim</option>
                    <option value="finish" <?php echo ($filter == "finish"?'selected':'') ?>>Selesai</option>
                  </select>
                </div>
                <div class="col-sm-3">
                  <button class="btn btn-success" type="submit"><i class="fa fa-download"></i> Unduh Rekap</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="list-group">
          <?php foreach ($data as $d): ?>
            <?php 
              $prod = $this->db
                ->select('product_title')
                ->join('product', 'product_id = transprod_product_id')
                ->get_where('transaction_product', ['transprod_transaction_id'=>$d->transaction_id])
                ->result();
              $dt_prod = [];
              foreach ($prod as $p) {
                $dt_prod[] = $p->product_title;
              }
            ?>
            <a href="<?php echo site_url('seller/order/detail/'.$d->transaction_code) ?>" class="list-group-item list-group-item-action flex-column align-items-start">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">Pembeli: <?php echo $d->customer_name ?></h5>
                <small><?php echo transactionStatus($d->transaction_status) ?>
                <br>
                Pembayaran: <?php echo confirmStatus($d->transconf_status) ?></small>
              </div>
              <p class="mb-1 text-muted"><small>
                <?php echo implode(', ', $dt_prod) ?>
              </small>
              </p>
            </a>
          <?php endforeach ?>
        </div>
      </div>
    </div>
  </div>
  <br>
<?php $this->load->view('themes/front/view_footer_script') ?>
<script type="text/javascript">
  function changeFilter(val) {
    window.location = "<?php echo site_url('seller/order?filter=') ?>" + val;
  }
</script>
<?php $this->load->view('themes/front/view_footer') ?>
