<?php $this->load->view('themes/back/view_header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Permintaan Pencairan Saldo
      <small>Penjual</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo webmin_url() ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li>Permintaan Pencairan</li>
      <li class="active">Penjual</li>
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
            <h3 class="box-title">Daftar Permintaan Pencairan Saldo Penjual</h3>
          </div>
          <div class="box-body border-radius-none">
            <?php echo showAlert($alert) ?>
            <form class="form-horizontal" action="<?php echo site_url('webmin/seller/reqfund') ?>" method="get">
              <div class="form-group">
                <label class="control-label col-sm-1">Filter</label>
                <div class="col-sm-5">
                  <select class="form-control" name="filter">
                    <option value="">Semua</option>
                    <?php foreach ($filter as $key => $value): ?>
                      <option value="<?php echo $key ?>" <?php echo ($key==$filter_selected?'selected':'') ?>><?php echo $value ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-sm-1">
                  <button type="submit" class="btn btn-primary">Proses</button>
                </div>
              </div>
            </form>
            <table class="table table-bordered datatable">
              <thead>
                <tr>
                  <th style="width:80px">No</th>
                  <th>Penjual</th>
                  <th>Rekening</th>
                  <th>Waktu Permintaan</th>
                  <th>Jumlah</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $no=1; ?>
                <?php foreach ($data as $d): ?>
                  <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $d->seller_name ?></td>
                    <td>
                      <?php echo $d->bank_name ?><br>
                      No. Rekening: <strong><?php echo $d->bank_account_number ?></strong><br>
                      Atas Nama: <strong><?php echo $d->bank_account_name ?></strong><br>
                      Cabang: <strong><?php echo (empty($d->bank_branch)?'-':$d->bank_branch) ?></strong>
                    </td>
                    <td><?php echo $d->reqfund_datetime ?></td>
                    <td><?php echo number_format($d->reqfund_value) ?></td>
                    <td><?php echo statusPencairan($d->reqfund_status) ?></td>
                    <td>
                      <?php if($d->reqfund_status == 1){ ?>
                        <a href="<?php echo site_url('webmin/seller/reqfund/reject/'.$d->reqfund_id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin ingin menolak ini? jumlah akan dikembalikan ke saldo');">Tolak</a> 
                        <a href="<?php echo site_url('webmin/seller/reqfund/accept/'.$d->reqfund_id) ?>" class="btn btn-success btn-xs" onclick="return confirm('Apakah Anda yakin ingin memproses ini?');">Proses</a>
                      <?php } else if($d->reqfund_status == 2) { ?>
                        <a href="<?php echo site_url('webmin/seller/reqfund/finish/'.$d->reqfund_id) ?>" class="btn btn-success btn-xs" onclick="return confirm('Apakah Anda yakin ingin memproses ini?');">Konfirmasi Selesai</a>
                      <?php } else { echo '-'; } ?>
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
<?php $this->load->view('themes/back/view_footer_script'); ?>
<?php $this->load->view('themes/back/view_footer'); ?>
