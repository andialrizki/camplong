<?php $this->load->view('themes/back/view_header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Kategori
      <small>Produk</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo webmin_url() ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li>Produk</li>
      <li class="active">Kategori</li>
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
            <h3 class="box-title">Daftar Kategori</h3>
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
                  <th>Nama Kategori</th>
                  <th>URL</th>
                  <th>Deskripsi</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $no=1; ?>
                <?php foreach ($data as $d): ?>
                  <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $d->category_title ?></td>
                    <td><?php echo $d->category_url ?></td>
                    <td><?php echo $d->category_description ?></td>
                    <td>
                      <a class="btn btn-success btn-xs" onclick="return formedit('<?php echo $d->category_id ?>')">Edit</a> 
                      <a href="<?php echo webmin_url('product/category/action/remove?id='.$d->category_id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to delete : <?php echo $d->category_title ?>? ');">Remove</a>
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
          <h4 class="modal-title">Form Kategori</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label col-sm-3">Judul</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="post[category_title]" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Deskripsi</label>
            <div class="col-sm-9">
              <textarea class="form-control" name="post[category_description]" required></textarea>
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
