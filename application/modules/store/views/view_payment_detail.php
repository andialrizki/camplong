<?php $this->load->view('themes/front/view_header', ['title' => 'Pembayaran Produk']) ?>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('private/plugins/datepicker/datepicker3.css') ?>">
  <br>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card mb-2">
          <div class="card-body">
            <h5 class="card-title text-success">Pembayaran Produk</h5>
            <hr>
            <?php echo showAlert($alert) ?>
            <div class="text-center">
              <p>
                Lakukan pembayaran sebesar :
              </p>
              <h2 style="font-size:40px">
                <span class="bg-success text-white p-1">Rp. <?php echo number_format($data->transaction_total_pay) ?></span>
              </h2>
              <strong class="text-red">TEPAT</strong> hingga <strong class="text-red">3 digit terakhir.</strong><br>
              <p>
                Perbedaan nilai transfer akan menghambat proses verifikasi.<br><br>
                <strong class="text-red">Anda WAJIB harus melakukan konfirmasi pembayaran</strong><br>
                Pembayaran dapat dilakukan ke salah satu rekening berikut:
              </p>
              <br><br>
              <div class="row justify-content-center">
                <?php foreach ($bank as $d): ?>
                  <div class="col-sm-3">
                    <img src="<?php echo base_url('public/img/logo-bank/'.$d->bank_logo) ?>"><br>
                    <p><?php echo $d->bank_name ?>, <br>
                    <span class="font-size-18"><?php echo $d->bank_account_number ?></span> 
                    <br>a.n. <?php echo $d->bank_account_name ?></p>
                  </div>                  
                <?php endforeach ?>
              </div>
              <br>
              <br>
              <h4 class="text-left">Ringkasan Produk yang Dipesan</h4>
              <br>
              <p class="text-left"><strong>Penjual : </strong> <?php echo $data->seller_name ?></p>
              <div class="table-responsive">
                <table class="table">
                  <tr class="bg-success text-white">
                    <th colspan="2">Produk</th>
                    <th class="text-center">Qty</th>
                    <th>Berat Satuan</th>
                    <th>Harga</th>
                  </tr>
                  <?php $t_price=0; $t_qty=0; $t_weight=0; ?>
                  <?php foreach ($prod as $d): ?>
                    <tr>
                      <td style="width: 100px">
                        <img src="<?php echo base_url('public/seller/product/resize-'.$d->product_picture) ?>" style="max-width: 80px" alt="<?php echo $d->product_title ?>">
                      </td>
                      <td class="align-middle text-left">
                        <a href="<?php echo site_url('store/product/detail/'.$d->product_url) ?>"><?php echo $d->product_title ?></a>
                      </td>
                      <td class="text-center"><?php echo $d->transprod_qty ?>
                      </td>
                      <td><?php echo gramToKg($d->transprod_weight) ?></td>
                      <td>Rp<?php echo number_format($d->transprod_price) ?></td>
                    </tr>
                    <?php 
                      $t_price+=($d->transprod_price*$d->transprod_qty );
                      $t_qty+=$d->transprod_qty;
                      $t_weight+=$d->transprod_weight;
                    ?>
                  <?php endforeach ?>
                  <tr>
                    <td colspan="2" class="text-right">Sub-total</td>
                    <td class="text-center"><?php echo $t_qty ?></td>
                    <td><?php echo gramToKg($t_weight) ?></td>
                    <td>Rp<?php echo number_format($t_price) ?></td>
                  </tr>
                  <tr>
                    <td colspan="4" class="text-right align-middle">Pilih Jasa Pengiriman</td>
                    <td>
                      <?php echo strtoupper($data->transaction_courier).' '.$data->transaction_courier_service ?>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="4" class="text-right">Ongkos Kirim</td>
                    <td>Rp<?php echo number_format($data->transaction_courier_cost) ?> </td>
                  </tr>
                  <tr>
                    <td colspan="4" class="text-right">Total</td>
                    <td>Rp<?php echo number_format($t_price+$data->transaction_courier_cost) ?></td>
                  </tr>
                </table>
              </div>
              <div class="text-center">
                <?php if($conf->num_rows() == 0): ?>
                  <strong>Sudah melakukan pembayaran?</strong><br>
                  <button class="btn btn-warning text-white" data-toggle="modal" data-target="#modal-konfirmasi" type="button">
                    <i class="fa fa-check"></i> Konfirmasi Pembayaran
                  </button>
                <?php else: ?>
                  <strong class="text-success">Anda sudah melakukan konfirmasi pembayaran</strong><br>
                  <button class="btn btn-warning text-white" data-toggle="modal" data-target="#modal-konfirmasi" type="button">
                    <i class="fa fa-search"></i> LIHAT
                  </button>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
  <div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pembayaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <?php $dt = $conf->row() ?>
          
          <form action="<?php echo site_url('store/cart/payment/'.$data->transaction_code.'?action=confirm') ?>" method="post" enctype="multipart/form-data">
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Rekening Tujuan</label>
              <div class="col-sm-7">
                <select class="form-control" name="dt[transconf_bank_id]" required>
                  <option value="">-- Pilih --</option>
                  <?php foreach ($bank as $d): ?>
                    <option value="<?php echo $d->bank_id ?>" <?php echo (@$dt->transconf_bank_id==$d->bank_id?'selected':'') ?>><?php echo $d->bank_name ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
            <hr>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Bank Pengirim</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" name="dt[transconf_bank_sender]" placeholder="(contoh: BNI)" value="<?php echo @$dt->transconf_bank_sender ?>" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">No. Rekening Pengirim</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="dt[transconf_bank_sender_number]" value="<?php echo @$dt->transconf_bank_sender_number ?>" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Nama Pengirim</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="dt[transconf_bank_sender_name]" value="<?php echo @$dt->transconf_bank_sender_name ?>" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Nominal Transfer</label>
              <div class="col-sm-7">
                <input type="number" min="10000" max="2000000" class="form-control" name="dt[transconf_value]" placeholder="(contoh: 15000)" value="<?php echo @$dt->transconf_value ?>" required>
                <p>Yang harus dibayar: <strong class="text-red">Rp. <?php echo number_format($data->transaction_total_pay) ?></strong></p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Tanggal Transfer</label>
              <div class="col-sm-5">
                <input type="text" class="form-control datepicker" name="dt[transconf_date]" value="2018-10-29" value="<?php echo @$dt->transconf_date ?>" required>
                <small class="text-muted">tahun-bulan-hari</small>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Bukti Transfer</label>
              <div class="col-sm-6">
                <input type="file" class="form-control" name="file">
                <br>
                <small>ini untuk membantu kami mengidentifikasi. file jpg/jpeg/png/gif maksimal 500KB</small>
                <?php if(!empty($dt->transconf_file)): ?>
                  <br>
                  <a href="<?php echo base_url('public/customer/buktitransfer/'.$dt->transconf_file) ?>" target="_blank">
                    <i class="fa fa-search"></i> lihat bukti transfer
                  </a>
              <?php endif; ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-8 offset-sm-4">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
              </div>
            </div>
          </form> 
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('themes/front/view_footer_script') ?>
<script type="text/javascript" src="<?php echo base_url('private/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<script type="text/javascript">
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose:true
  });
</script>
<?php $this->load->view('themes/front/view_footer') ?>
