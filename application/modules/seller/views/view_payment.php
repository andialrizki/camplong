<?php $this->load->view('themes/front/view_header', ['title' => 'Pembayaran']) ?>
<br>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-success text-center">Pembayaran</h5>
          <div class="alert alert-warning" role="alert">
            PENTING:<br> 
            Cermatlah dalam mengisi data rekening bank. Kami tidak bertanggung jawab apabila terjadi hal yang tidak diinginkan akibat kesalahan dalam pengisian data rekening bank yang meliputi nomor rekening, nama pemilik rekening dan nama bank.
          </div>
          <?php echo showAlert($alert) ?>
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Pencairan Saldo</a>
              <a class="nav-item nav-link" id="nav-riwayat-tab" data-toggle="tab" href="#nav-riwayat" role="tab" aria-controls="nav-riwayat" aria-selected="false">Riwayat Pencairan 
                <?php if($count_req > 0): ?>
                  <sup class="bg-danger" style="padding: 5px;color: #fff">1</sup>
                <?php endif; ?>
              </a>
              <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Rekening Bank</a>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
              <br>
              <p>Saldo Anda: <strong>Rp. <?php echo number_format($me->seller_balance) ?></strong></p>
              <?php if($me->seller_balance >= 50000): ?>
                <p>Silakan isi formulir dibawah ini untuk melakukan pencairan dana ke rekening Anda.</p>
                <hr>
                <form action="<?php echo site_url('seller/payment/request_fund') ?>" method="post">
                  <div class="form-group">
                    <label>Rekening Tujuan</label>
                    <select class="form-control" name="post[reqfund_bank_id]" required>
                      <option value="">-- Pilih --</option>
                      <?php foreach ($bank as $d): ?>
                        <option value="<?php echo $d->bank_id ?>"><?php echo $d->bank_name.' : a/n. '.$d->bank_account_name ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Jumlah Pencairan</label>
                    <input type="text" name="post[reqfund_value]" class="form-control" max="<?php echo $me->seller_balance ?>" required>
                    <small>Maksimal jumlah pencairan adalah <strong>Rp. <?php echo number_format($me->seller_balance) ?></strong></small>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-primary" type="submit">Proses Pencairan</button>
                  </div>
                </form>
              <?php else: ?>
                <p>Minimal untuk pencairan saldo adalah Rp. 50.000</p>
              <?php endif; ?>
            </div>
            <div class="tab-pane fade" id="nav-riwayat" role="tabpanel" aria-labelledby="nav-riwayat-tab">
              <br>
              <p>Riwayat Pencairan Saldo</p>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Rekening Tujuan</th>
                    <th>Jumlah Pencairan</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no=1; ?>
                  <?php foreach ($history as $d): ?>
                    <tr>
                      <td><?php echo $no ?></td>
                      <td>
                        <?php echo $d->bank_name ?><br>
                        No. Rekening: <b><?php echo $d->bank_account_number ?></b><br>
                        a/n: <b><?php echo $d->bank_account_name ?></b>
                      </td>
                      <td><?php echo number_format($d->reqfund_value) ?></td>
                      <td><?php echo statusPencairan($d->reqfund_status) ?></td>
                    </tr>
                    <?php $no++ ?>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
              <br>
              <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#mdl-rekening" onclick="addBank();"><i class="fa fa-plus"></i> Tambah Rekening</button>
              <hr>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Bank</th>
                    <th>Nama Pemilik</th>
                    <th>No. Rekening</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no=1; ?>
                  <?php foreach ($bank as $d): ?>
                    <tr>
                      <td><?php echo $no ?></td>
                      <td><?php echo $d->bank_name ?></td>
                      <td><?php echo $d->bank_account_name ?></td>
                      <td><?php echo $d->bank_account_number ?></td>
                      <td>
                        <button class="btn btn-info btn-xs" type="button" onclick="return formEdit('<?php echo $d->bank_id ?>')"><i class="fa fa-edit"></i></button> 
                        <a href="<?php echo site_url('seller/payment/del_bank/'.$d->bank_id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus ini?');"><i class="fa fa-trash"></i></a>
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
    </div>
  </div>
</div>
<br>
<div class="modal fade" id="mdl-rekening" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Rekening Bank</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo site_url('seller/payment/add_bank') ?>" method="post" id="form">
          <div class="form-group">
            <label>Nama Bank</label>
            <input type="text" name="post[bank_name]" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Nama Pemilik Rekening</label>
            <input type="text" name="post[bank_account_name]" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Nomor Rekening</label>
            <input type="text" name="post[bank_account_number]" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Cabang Bank</label>
            <input type="text" name="post[bank_branch]" class="form-control">
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('themes/front/view_footer_script') ?>
<script type="text/javascript">
  let act_def = $("#mdl-rekening #form").attr('action');
  function formEdit(id) {
    $("#mdl-rekening #form").attr('action', '<?php echo site_url('seller/payment/edit_bank') ?>/'+id);
    $.ajax({
      url: "<?php echo site_url('seller/payment/get_bank') ?>",
      data:{id:id},
      type:"GET",
      dataType:"json",
      beforeSend: function () {
        // body...
      }, success: function(res) {
        $.each(res, function(i,v) {
          $("#mdl-rekening .form-control[name='post[" + i + "]']").val(v);
        });
        $("#mdl-rekening").modal('toggle');
      }
    })
  }
  function addBank() {
    $("#mdl-rekening #form").attr('action', act_def);
    $("#mdl-rekening .form-control").val('');
  }
</script>
<?php $this->load->view('themes/front/view_footer') ?>
