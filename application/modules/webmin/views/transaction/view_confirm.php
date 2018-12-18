<?php $this->load->view('themes/back/view_header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Transaksi
      <small>Konfirmasi Pembayaran</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo webmin_url() ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li>Transaksi</li>
      <li class="active">Konfirmasi Pembayaran</li>
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
            <h3 class="box-title">Daftar Konfirmasi Pembayaran</h3>
          </div>
          <div class="box-body border-radius-none">
            <?php echo showAlert($alert) ?>
            <table class="table table-bordered datatable">
              <thead>
                <tr>
                  <th style="width:80px">No</th>
                  <th>No. Transaksi</th>
                  <th>Nama Pengirim</th>
                  <th>No. Rekening</th>
                  <th>Bank Tujuan</th>
                  <th>Status</th>
                  <th>Jumlah</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $no=1; ?>
                <?php foreach ($data as $d): ?>
                  <tr>
                    <td><?php echo $no ?></td>
                    <td>
                      <a href="<?php echo site_url('webmin/transaction/detail/index/'.$d->transaction_code) ?>"><?php echo $d->transaction_code ?></a>
                    </td>
                    <td><?php echo $d->transconf_bank_sender_name ?></td>
                    <td>
                      <?php echo $d->transconf_bank_sender ?><br>
                      <?php echo $d->transconf_bank_sender_number ?></td>
                    <td><?php echo $d->bank_name ?></td>
                    <td><?php echo confirmStatus($d->transconf_status) ?></td>
                    <td>Rp<?php echo number_format($d->transconf_value) ?></td>
                    <td style="line-height: 25px">
                      <a href="<?php echo base_url('public/customer/buktitransfer/'.$d->transconf_file) ?>" target="_blank" class="btn btn-success btn-xs"><i class="fa fa-file-image-o"></i> Bukti Transfer</a><br>
                      <a href="<?php echo site_url('webmin/transaction/confirm/accept/'.$d->transconf_id) ?>" class="btn btn-info btn-xs" onclick="return confirm('Apakah Anda yakin menyetujui pembayaran ini? Jika YA, pemesanan akan diteruskan ke penjual')"><i class="fa fa-check"></i> Setuju</a><br> 
                      <a href="javascript:void(0)" onclick="rejectForm('<?php echo $d->transaction_id ?>', '<?php echo $d->transconf_id ?>', '<?php echo $d->transaction_code ?>');" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Tolak</a> 
                    </td>
                  </tr>
                  <?php $no++ ?>
                <?php endforeach ?>
              </tbody>
            </table>
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
