<?php $this->load->view('themes/back/view_header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Transaksi
      <small>Rekap</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo webmin_url() ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li>Transaksi</li>
      <li class="active">Rekap</li>
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
            <h3 class="box-title">Daftar Pesanan</h3>
          </div>
          <div class="box-body border-radius-none">
            <?php echo showAlert($alert) ?>
            <form class="form-horizontal" action="<?php echo site_url('webmin/transaction/recap/xls') ?>" method="get">
              <div class="form-group">
                <label class="control-label col-sm-1">Filter</label>
                <div class="col-sm-5">
                  <select class="form-control" name="filter" onchange="changeFilter(this.value);">
                    <?php foreach ($filter as $key => $value): ?>
                      <option value="<?php echo $key ?>" <?php echo ($key==$filter_selected?'selected':'') ?>><?php echo $value ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-sm-1">
                  <button type="submit" class="btn btn-success"><i class="fa fa-download"></i> Unduh Rekap</button>
                </div>
              </div>
            </form>
            <table class="table table-bordered datatable">
              <thead>
                <tr>
                  <th style="width:80px">No</th>
                  <th>No. Transaksi</th>
                  <th>Waktu</th>
                  <th>Pembeli</th>
                  <th>Penjual</th>
                  <th>Nilai Transaksi</th>
                  <th>Keterangan</th>
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
                    <td><?php echo $d->transaction_datetime ?></td>
                    <td><?php echo $d->customer_name ?></td>
                    <td><?php echo $d->seller_name ?></td>
                    <td>
                      <?php echo number_format($d->transaction_product_value) ?>
                    </td>
                    <td><?php echo transactionStatus($d->transaction_status) ?></td>
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
<?php $this->load->view('themes/back/view_footer_script'); ?>
<script type="text/javascript">
  function changeFilter(id) {
    window.location.href = "<?php echo site_url('webmin/transaction/recap?filter=') ?>" + id;
  }
</script>
<?php $this->load->view('themes/back/view_footer'); ?>
