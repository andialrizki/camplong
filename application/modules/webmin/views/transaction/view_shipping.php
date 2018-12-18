<?php $this->load->view('themes/back/view_header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Transaksi
      <small>Dikirim</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo webmin_url() ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li>Transaksi</li>
      <li class="active">Dikirim</li>
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
            <h3 class="box-title">Daftar Dikirim</h3>
          </div>
          <div class="box-body border-radius-none">
            <?php echo showAlert($alert) ?>
            <table class="table table-bordered datatable">
              <thead>
                <tr>
                  <th style="width:80px">No</th>
                  <th>No. Transaksi</th>
                  <th>Penjual</th>
                  <th>Nilai Transaksi</th>
                  <th>Status</th>
                  <th>Jasa Pengiriman</th>
                  <th>No. Resi</th>
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
                    <td><?php echo $d->seller_name ?></td>
                    <td>
                      <?php echo number_format($d->transaction_product_value) ?>
                    </td>
                    <td><?php echo transactionStatus($d->transaction_status) ?></td>
                    <td><?php echo strtoupper($d->transaction_courier).' '.$d->transaction_courier_service ?></td>
                    <td><?php echo $d->transaction_courier_receipt ?></td>
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
<?php $this->load->view('themes/back/view_footer'); ?>
