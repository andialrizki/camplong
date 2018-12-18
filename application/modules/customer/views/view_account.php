<?php $this->load->view('themes/front/view_header', ['title' => 'Akun Anda']) ?>
  <br>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-success text-center">Akun Anda</h5>
            <hr>
            <?php echo showAlert($alert) ?>
            <form action="<?php echo site_url('customer/account/submit') ?>" method="post" autocomplete="off">
              <div class="form-group">
                <label>Nama Anda</label>
                <input type="text" class="form-control" placeholder="ketik disini" name="post[customer_name]" autocomplete="off" value="<?php echo $data->customer_name ?>" required>
              </div>
              <div class="form-group">
                <label>Alamat Email</label>
                <input type="email" class="form-control" placeholder="ketik disini" name="post[customer_email]" autocomplete="off" value="<?php echo $data->customer_email ?>" required>
              </div>
              <div class="form-group">
                <label>Nomor Handphone</label>
                <input type="text" class="form-control" placeholder="ketik disini" name="post[customer_nohp]" autocomplete="off" value="<?php echo $data->customer_nohp ?>" required>
              </div>
              <label class="text-info">Anda perlu menentukan alamat Anda untuk keperluan estimasi ongkos kirim</label>
              <div class="form-group">
                <label>Provinsi</label>
                <select class="form-control" name="post[customer_province_id]" id="province" onchange="changeProv(this.value)" required>
                  <option value="">-- Pilih --</option>
                  <?php foreach ($prov as $d): ?>
                    <option value="<?php echo $d->province_id ?>" <?php @$data->customer_province_id==$d->province_id and print('selected') ?>><?php echo $d->province ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <label>Kota/Kabupaten</label>
                <select class="form-control" id="city" name="post[customer_city_id]" onchange="changeCity(this.value)" required>
                  <option value="">-- Pilih --</option>
                </select>
              </div>
              <div class="form-group">
                <label>Kecamatan</label>
                <select class="form-control" id="subdistrict" name="post[customer_subdistrict_id]" required>
                  <option value="">-- Pilih --</option>
                </select>
              </div>
              <div class="form-group">
                <label>Alamat</label>
                <textarea class="form-control" name="post[customer_address]" required><?php echo $data->customer_address ?></textarea>
                <small class="font-italic text-info">Nama jalan, RT RW Dusun, Desa/Kelurahan</small>
              </div>
              <button type="submit" class="btn btn-success btn-block">SIMPAN PERUBAHAN</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
<?php $this->load->view('themes/front/view_footer_script') ?>
<script type="text/javascript">
  var customer_city_id = "<?php echo @$data->customer_city_id ?>";
  var customer_subdistrict_id = "<?php echo @$data->customer_subdistrict_id ?>";
  var onload_prov = true;
  var onload_sub = true;
  function changeProv(id){
    $.ajax({
      url: "<?php echo site_url('customer/account/get_city') ?>",
      type: "GET",
      dataType: "json",
      data: {prov: id},
      beforeSend: function() {
        $("#city, #subdistrict").prop('disabled', true);
      },
      success: function(res) {
        $("#city, #subdistrict").prop('disabled', false);
        $("#city").html('<option value="">-- Pilih --</option>');
        $("#subdistrict").html('<option value="">-- Pilih --</option>');
        $.each(res, function (i, v) {
          $("#city").append('<option value="'+v.city_id+'">'+v.city_name +' ' + v.city_type.replace('Kabupaten', 'Kab.') + '</option>');

        });
        if ( (customer_city_id != "" || customer_city_id != "null") && onload_prov) {
          $("#city").val(customer_city_id);
          changeCity(customer_city_id);
          onload_prov = false;
        }
      }
    })
  }
  function changeCity(id){
    $.ajax({
      url: "<?php echo site_url('customer/account/get_subdistrict') ?>",
      type: "GET",
      dataType: "json",
      data: {city: id},
      beforeSend: function() {
        $("#subdistrict").prop('disabled', true);
      },
      success: function(res) {
        $("#subdistrict").prop('disabled', false);
        $("#subdistrict").html('<option value="">-- Pilih --</option>');
        $.each(res, function (i, v) {
          $("#subdistrict").append('<option value="'+v.subdistrict_id+'">'+v.subdistrict_name+'</option>');

        });
        if ( (customer_subdistrict_id != "" || customer_subdistrict_id != "null") && onload_sub) {
          $("#subdistrict").val(customer_subdistrict_id);
          onload_sub = false;
        }
      }
    })
  }
  $(document).ready(function() {
    var prov = $("#province option:selected").val();
    if (prov != "") {
      changeProv(prov);
    }
  });
</script>
<?php $this->load->view('themes/front/view_footer') ?>
