<?php $this->load->view('themes/front/view_header', ['title' => 'Pembayaran Produk']) ?>
  <br>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card mb-2">
          <div class="card-body">
            <h5 class="card-title text-success">Daftar Transaksi</h5>
            <hr>
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
            <a href="<?php echo site_url('store/cart/payment/'.$d->transaction_code) ?>" class="list-group-item list-group-item-action flex-column align-items-start">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">Penjual: <?php echo $d->seller_name ?></h5>
                <small><?php echo transactionStatus($d->transaction_status) ?></small>
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
<?php $this->load->view('themes/front/view_footer') ?>
