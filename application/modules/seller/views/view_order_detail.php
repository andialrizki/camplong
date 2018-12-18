<?php $this->load->view('themes/front/view_header', ['title' => 'Detail Pesanan']) ?>
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
                  <th>Pembeli</th>
                  <td><a href=""><?php echo $d->customer_name ?></a></td>
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
                </table>
              </div>
              <hr>
              <?php if($d->transaction_status == 3 || $d->transaction_status == 4): ?>
                <h4>Masukkan Nomor Resi Pengiriman Disini</h4>
                <form action="<?php echo site_url('seller/order/updateresi/'.$d->transaction_code) ?>" method="post">
                  <div class="form-group">
                    <label class="control-label">Nomor Resi</label>
                    <input type="text" name="resi" class="form-control" style="max-width: 400px" value="<?php echo @$d->transaction_courier_receipt ?>">
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-info btn0-sm">
                      <i class="fa fa-check"></i> Simpan
                    </button>
                  </div>
                </form>
              <?php elseif($d->transaction_status == 2): ?>
                <div class="float-left">
                  <a href="<?php echo site_url('seller/order/reject/'.$d->transaction_code) ?>" class="btn btn-warning text-white" onclick="return confirm('Apakah Anda yakin ingin menolak pesanan ini?');">
                    <i class="fa fa-times"></i> Tolak Pesanan 
                  </a> 
                </div>
                <div class="float-right">
                  <a href="<?php echo site_url('seller/order/accept/'.$d->transaction_code) ?>" class="btn btn-success text-white" onclick="return confirm('Apakah Anda yakin ingin menerima pesanan ini?');">
                    <i class="fa fa-check"></i> Terima Pesanan
                  </a>
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
<?php $this->load->view('themes/front/view_footer_script') ?>
<?php $this->load->view('themes/front/view_footer') ?>
