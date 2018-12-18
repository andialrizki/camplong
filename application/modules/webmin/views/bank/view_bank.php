<?php $this->load->view('themes/back/view_header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Bank
      <small>Rekening</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo webmin_url() ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li>Bank</li>
      <li class="active">Rekening</li>
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
            <h3 class="box-title">Daftar Rekening</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-add" onclick="formadd()"><i class="fa fa-plus"></i> Tambah</button>
            </div>
          </div>
          <div class="box-body border-radius-none">
            <?php echo showAlert($alert) ?>
            <table class="table table-bordered datatable">
              <thead>
                <tr>
                  <th style="width:80px">No</th>
                  <th>Nama Bank</th>
                  <th>Nama Pemilik</th>
                  <th>No. Rekening</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $no=1; ?>
                <?php foreach ($data as $d): ?>
                  <tr>
                    <td><?php echo $no ?></td>
                    <td>
                      <?php echo $d->bank_name ?><br>
                      <strong>Cabang: </strong>
                      <?php echo (empty($d->bank_branch)?'-':$d->bank_branch) ?>
                    </td>
                    <td><?php echo $d->bank_account_name ?></td>
                    <td><?php echo $d->bank_account_number ?></td>
                    <td>
                      <a class="btn btn-success btn-xs" onclick="return formedit('<?php echo $d->bank_id ?>')">Edit</a> 
                      <a href="<?php echo webmin_url('bank/action/remove?=id='.$d->bank_id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to delete this? ');">Remove</a>
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
<div class="modal fade" id="modal-add">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" id="form" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Form Bank</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label col-sm-3">Nama BANK</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="post[bank_name]" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Cabang</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="post[bank_branch]">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Nama Pemilik Rekening</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="post[bank_account_name]" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Nomor Rekening</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="post[bank_account_number]" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Batal</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $this->load->view('themes/back/view_footer_script'); ?>
<script type="text/javascript">
  function formadd() {
    var act = "<?php echo site_url($url) ?>/action/add";
    $("#modal-add #form").attr('action',  act);
  }
  function formedit(id) {
    var act = "<?php echo site_url($url) ?>/action/edit";
    $("#modal-add #form").attr('action',  act + '?id=' + id);
    $.ajax({
      url: "<?php echo site_url($url) ?>/get_row",
      type: "GET",
      data: {id: id},
      dataType: "json",
      beforeSend: function() {
        // body...
      },
      success: function(res) {
        $.each(res, function(i ,v) {
          $("#form .form-control[name='post[" + i + "]']").val(v);
        })
      }
    })
    $("#modal-add").modal('toggle');
    return false;
  }

</script>
<?php $this->load->view('themes/back/view_footer'); ?>
