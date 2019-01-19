<?php $this->load->view('themes/front/view_header', ['title' => 'Detail Pesanan']) ?>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/css/rating.css">
  <br>
  <div class="container">
    <?php if($data->num_rows() > 0): ?>
      <?php $d = $data->row() ?>
      <div class="row justify-content-center">
        <div class="col-sm-10 mb-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title text-success">Pemesanan</h5>
              <hr>
              <?php echo showAlert($alert) ?>
              <table class="table table-bordered">
                <tr>
                  <th>Penjual</th>
                  <td><a href=""><?php echo $d->seller_name ?></a></td>
                </tr>
                <tr>
                  <th>No. Transaksi</th>
                  <td><?php echo $d->transaction_code ?></td>
                </tr>
                <tr>
                  <th>Status Transaksi</th>
                  <td><?php echo transactionStatus($d->transaction_status) ?></td>
                </tr>
                <tr>
                  <th>Status Pembayaran</th>
                  <td>
                    <?php $sp = $this->db->get_where('transaction_confirm', ['transconf_transaction_id'=>$d->transaction_id])->row() ?>
                    <?php echo confirmStatus($sp->transconf_status) ?>
                  </td>
                </tr>
                <tr>
                  <th>Alamat Pengiriman</th>
                  <td>
                    <b>Nama Penerima: </b> <?php echo $d->transaction_receiver_name ?><br>
                    <?php $sdc = $this->db->get_where('subdistrict', ['subdistrict_id'=>$d->transaction_receiver_subdistrict_id])->row(); ?>
                    <?php echo $d->transaction_receiver_address ?>, 
                    <?php echo @$sdc->subdistrict_name.', '.@$sdc->subdistrict_city_type.' '.@$sdc->subdistrict_city.'<br>'.@$sdc->subdistrict_province; ?>
                    <br>
                    Kodepos: <?php echo $d->transaction_receiver_postcode ?><br>
                    Telepon: <?php echo $d->transaction_receiver_nohp ?>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-sm-10 mb-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title text-success">Ringkasan Pesanan</h5>
              <?php $prd = $this->db
                ->join('product', 'product_id = transprod_product_id')
                ->get_where('transaction_product', ['transprod_transaction_id'=>$d->transaction_id])->result() ?>
              <div class="table-responsive">
                <table class="table">
                  <tr class="bg-primary text-white">
                    <th colspan="2">Produk</th>
                    <th class="text-center">Qty</th>
                    <th>Berat Satuan</th>
                    <th>Harga</th>
                  </tr>
                  <?php $t_price=0; $t_qty=0; $t_weight=0; ?>
                  <?php foreach ($prd as $dt): ?>
                    <tr>
                      <td style="width: 100px">
                        <img src="<?php echo base_url('public/seller/product/resize-'.$dt->product_picture) ?>" 
                        style="max-width: 80px">
                      </td>
                      <td class="align-middle text-left">
                        <?php echo $dt->product_title ?>
                      </td>
                      <td class="text-center"><?php echo $dt->transprod_qty ?>
                      </td>
                      <?php $weight = $dt->transprod_weight*$dt->transprod_qty ?>
                      <td><?php echo gramToKg($dt->transprod_weight) ?></td>
                      <td>Rp<?php echo number_format($dt->transprod_price) ?></td>
                    </tr>
                    <?php 
                      $t_price+=($dt->transprod_price*$dt->transprod_qty );
                      $t_qty+=$dt->transprod_qty;
                      $t_weight+=$weight;
                    ?>
                  <?php endforeach ?>
                  <tr>
                    <td colspan="2" class="text-right">Sub-total</td>
                    <td class="text-center"><?php echo $t_qty ?></td>
                    <td><?php echo gramToKg($t_weight) ?></td>
                    <td>Rp<?php echo number_format($t_price) ?></td>
                  </tr>
                  <tr>
                    <td colspan="4" class="text-right align-middle">Jasa Pengiriman</td>
                    <td>
                      <?php echo strtoupper($d->transaction_courier) ?> <?php echo $d->transaction_courier_service ?>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="4" class="text-right">Ongkos Kirim</td>
                    <td>Rp<?php echo number_format($d->transaction_courier_cost) ?></td>
                  </tr>
                  <tr>
                    <td colspan="4" class="text-right">Total</td>
                    <td>Rp<?php echo number_format($d->transaction_total_pay) ?></td>
                  </tr>
                  <tr>
                    <td colspan="4" class="text-right">Resi Pengriman</td>
                    <td>
                      <?php 
                        echo (!empty($d->transaction_courier_receipt) ? 
                          '<a href="'.site_url('customer/order/tracking/'.$d->transaction_code).'">'.$d->transaction_courier_receipt.'</a>':'-') 
                      ?>
                    </td>
                  </tr>
                </table>
              </div>
              <?php if($d->transaction_status == 4): ?>
                <hr>
                <div class="text-center">
                  <!-- <a href="" class="btn btn-default">Komplain</a> &nbsp;  -->
                  <a href="<?php echo site_url('customer/order/received/'.$d->transaction_code) ?>" class="btn btn-primary" onclick="return confirm('Apakah Anda yakin sudah menerima barang dan tidak ada masalah? Jika YA, dana akan diteruskan ke penjual dan status pesanan akan berubah menjadi SELESAI')">Terima Barang</a>
                </div>
              <?php endif; ?>
              <?php if($d->transaction_status == 5): ?>
                <hr>
                <div class="text-center">
                  <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#mdl-rating">Beri Nilai</button>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    <?php else: ?>
      <p>Transaksi tidak ditemukan</p>
    <?php endif; ?>
  </div>
  <br>
  <?php if($d->transaction_status == 5): ?>
    <?php $rtg = 0; ?>
    <?php $cekrtg = $this->db->get_where('seller_rating', ['rating_transaction_id'=>$d->transaction_id]); ?>
    <?php if($cekrtg->num_rows() > 0 ){
      $rtg = $cekrtg->row()->rating;
    } ?>
  <div class="modal fade" id="mdl-rating" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Beri Nilai</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?php echo site_url('customer/order/rating/'.$code) ?>" method="post">
            <section class='rating-widget mt-3'>
              <!-- Rating Stars Box -->
              <div class='rating-stars text-center'>
                <ul id='stars'>
                  <?php for($i=1; $i<=5; $i++): ?>
                    <li class='star <?php echo ($i <= $rtg ? 'selected':'') ?>' data-value='<?php echo $i ?>'>
                      <i class='fa fa-star fa-fw'></i>
                    </li>
                  <?php endfor; ?>
                </ul>
              </div>            
            </section>
            <div class="text-center">
              <input type="hidden" name="value" id="value">
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>
<?php $this->load->view('themes/front/view_footer_script') ?>
<script type="text/javascript" src="<?php echo base_url() ?>public/js/rating.js"></script>
<script type="text/javascript">
  $('.star').click(function () {
    let v = $(this).attr('data-value');
    $("#value").val(v);
  })
</script>
<?php $this->load->view('themes/front/view_footer') ?>
