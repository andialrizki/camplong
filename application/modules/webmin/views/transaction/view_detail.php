<?php $this->load->view('themes/back/view_header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Transaksi
      <small>Detail</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo webmin_url() ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li>Transaksi</li>
      <li class="active">Detail</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <!-- solid sales graph -->
        <div class="box box-primary">
          <div class="box-header">
            <i class="fa fa-circle-o"></i>
            <h3 class="box-title">No. Transaksi: <?php echo $code ?></h3>
          </div>
          <div class="box-body border-radius-none">
            <?php echo showAlert($alert) ?>
            <?php foreach ($data as $d): ?>
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
                  <th>Penjual</th>
                  <td><a href=""><?php echo $d->seller_name ?></a></td>
                </tr>
                <tr>
                  <th>Alamat Penjual</th>
                  <td>
                    <?php echo $d->seller_address ?>,
                    <?php 
                      $sd = $this->db->get_where('subdistrict', ['subdistrict_id'=>$d->seller_subdistrict_id])->row();
                      echo @$sd->subdistrict_name.', '.@$sd->subdistrict_city_type.' '.@$sd->subdistrict_city.'<br>'.@$sd->subdistrict_province;
                    ?>
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
              <hr>
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
            <?php endforeach ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<div class="modal fade" id="modal-reject">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" id="form" action="<?php echo site_url('webmin/transaction/confirm/reject') ?>" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Form Penolakan Konfirmasi</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label col-sm-3">No. Transaksi</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="no_trx" name="code" readonly>
              <input type="hidden" class="form-control" id="conf_id" name="conf_id">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Alasan</label>
            <div class="col-sm-9">
              <textarea class="form-control" name="note" maxlength="300" required></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Batal</button>
          <button type="submit" class="btn btn-danger"><i class="fa fa-check"></i> Tolak Konfirmasi Pembayaran</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $this->load->view('themes/back/view_footer_script'); ?>
<script type="text/javascript">
  function rejectForm(id, conf_id, code) {
    $("#no_trx").val(code);
    $("#conf_id").val(conf_id);
    $("#modal-reject").modal('toggle');
  }
</script>
<?php $this->load->view('themes/back/view_footer'); ?>
