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
            <form action="<?php echo site_url('seller/account/submit') ?>" method="post" autocomplete="off">
              <div class="form-group">
                <label>Nama Anda</label>
                <input type="text" class="form-control" placeholder="ketik disini" name="post[seller_name]" autocomplete="off" value="<?php echo $data->seller_name ?>" required>
              </div>
              <div class="form-group">
                <label>Alamat Email</label>
                <input type="email" class="form-control" placeholder="ketik disini" name="post[seller_email]" autocomplete="off" value="<?php echo $data->seller_email ?>" required>
              </div>
              <div class="form-group">
                <label>Nomor Handphone</label>
                <input type="text" class="form-control" placeholder="ketik disini" name="post[seller_nohp]" autocomplete="off" value="<?php echo $data->seller_nohp ?>" required>
              </div>
              <label class="text-info">Anda perlu menentukan alamat Anda untuk keperluan estimasi ongkos kirim</label>
              <div class="form-group">
                <label>Provinsi</label>
                <select class="form-control" name="post[seller_province_id]" id="province" onchange="changeProv(this.value)" required>
                  <option value="">-- Pilih --</option>
                  <?php foreach ($prov as $d): ?>
                    <option value="<?php echo $d->province_id ?>" <?php @$data->seller_province_id==$d->province_id and print('selected') ?>><?php echo $d->province ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <label>Kota/Kabupaten</label>
                <select class="form-control" id="city" name="post[seller_city_id]" onchange="changeCity(this.value)" required>
                  <option value="">-- Pilih --</option>
                </select>
              </div>
              <div class="form-group">
                <label>Kecamatan</label>
                <select class="form-control" id="subdistrict" name="post[seller_subdistrict_id]" required>
                  <option value="">-- Pilih --</option>
                </select>
              </div>
              <div class="form-group">
                <label>Alamat</label>
                <textarea class="form-control" name="post[seller_address]" required><?php echo $data->seller_address ?></textarea>
                <small class="font-italic text-info">Nama jalan, RT RW Dusun, Desa/Kelurahan</small>
              </div>
              <div class="form-group">
                <label>Lokasi dari peta</label>
                <div id="map" style="height: 400px;"></div>
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
  var seller_city_id = "<?php echo @$data->seller_city_id ?>";
  var seller_subdistrict_id = "<?php echo @$data->seller_subdistrict_id ?>";
  var onload_prov = true;
  var onload_sub = true;
  function changeProv(id){
    $.ajax({
      url: "<?php echo site_url('seller/account/get_city') ?>",
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
        if ( (seller_city_id != "" || seller_city_id != "null") && onload_prov) {
          $("#city").val(seller_city_id);
          changeCity(seller_city_id);
          onload_prov = false;
        }
      }
    })
  }
  function changeCity(id){
    $.ajax({
      url: "<?php echo site_url('seller/account/get_subdistrict') ?>",
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
        if ( (seller_subdistrict_id != "" || seller_subdistrict_id != "null") && onload_sub) {
          $("#subdistrict").val(seller_subdistrict_id);
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
<script>
  // Note: This example requires that you consent to location sharing when
  // prompted by your browser. If you see the error "The Geolocation service
  // failed.", it means you probably did not give permission for the browser to
  // locate you.
  var map, infoWindow;
  function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: -34.397, lng: 150.644},
      zoom: 20
    });
    infoWindow = new google.maps.InfoWindow;

    // Try HTML5 geolocation.
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };

        infoWindow.setPosition(pos);
        infoWindow.setContent('Location found.');
        infoWindow.open(map);
        map.setCenter(pos);
      }, function() {
        handleLocationError(true, infoWindow, map.getCenter());
      });
    } else {
      // Browser doesn't support Geolocation
      handleLocationError(false, infoWindow, map.getCenter());
    }
  }

  function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
                          'Error: The Geolocation service failed.' :
                          'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
  }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $gmaps ?>&callback=initMap">
</script>
<?php $this->load->view('themes/front/view_footer') ?>
