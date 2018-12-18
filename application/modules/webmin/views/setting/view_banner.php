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
                  <th>Nama Banner</th>
                  <th>URL</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $no=1; ?>
                <?php foreach ($data->result() as $d): ?>
                  <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $d->banner_name ?></td>
                    <td><?php echo $d->banner_url ?></td>
                    <td><?php echo checkStatus($d->banner_status) ?></td>
                    <td>
                      <a class="btn btn-success btn-xs" onclick="formedit('<?php echo $d->banner_id ?>');">Edit</a> 
                      <a href="<?php echo webmin_url('setting/banner/remove/'.$d->banner_id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to delete : <?php echo $d->banner_name ?>? ');">Remove</a>
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
      <form class="form-horizontal" id="form" action="<?php echo webmin_url('setting/banner?action=save') ?>" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Form Banner</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label col-sm-3">Nama Banner</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="post[banner_name]" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">URL</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="post[banner_url]" placeholder="with http://">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Image</label>
            <div class="col-sm-5">
              <div id="image"><img src="" style="max-width:200px;" class="img-responsive"></div>
              <input type="file" class="form-control" name="image" onchange="showimage(this);">
              (1440px x 700px)
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Status</label>
            <div class="col-sm-9">
              <select class="form-control" name="post[banner_status]" required>
                <option value="">-- select --</option>
                <option value="1">Aktif</option>
                <option value="0">Nonaktif</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $this->load->view('themes/back/view_footer_script'); ?>
<script type="text/javascript">
  function showimage(val) {
    readURL(val, '#image img');
  }
  function formadd() {
    var act = "<?php echo site_url($url) ?>?action=save";
    $("#modal-add #form").attr('action',  act);
  }
  function formedit(id) {
    var act = "<?php echo site_url($url) ?>?action=save";
    $("#modal-add #form").attr('action',  act + '&id=' + id);
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
          if(i == "banner_file"){
            $("#image img").attr('src', '<?php echo base_url() ?>public/img/banner/' + v);
          } else{
            $("#form .form-control[name='post[" + i + "]']").val(v);
          }
        })
      }
    })
    $("#modal-add").modal('toggle');
    return false;
  }

</script>
<?php $this->load->view('themes/back/view_footer'); ?>
