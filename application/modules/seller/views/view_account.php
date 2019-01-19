<?php $this->load->view('themes/front/view_header', ['title' => 'Akun Anda']) ?>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/vendor/leaflet/leaflet.css">
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
                <div id="mapx" style="height: 320px"></div>
                <input type="hidden" name="loc[selloc_lat]" id="lat" value="<?php echo @$loc->selloc_lat ?>"/>
                <input type="hidden" name="loc[selloc_lng]" id="lng"  value="<?php echo @$loc->selloc_lng ?>"/>
                <input type="hidden" name="loc[selloc_zoom]" id="zoom"  value="<?php echo @$loc->selloc_zoom ?>"/>
                <input type="hidden" name="loc[selloc_map_type]" id="map_type"  value="<?php echo @$loc->selloc_map_type ?>"/>

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
<script type="text/javascript" src="<?php echo base_url() ?>public/vendor/leaflet/leaflet-src.js"></script>
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
<script type="text/javascript">
  (function() {
    setTimeout(function() {peta.invalidateSize();}, 500);
      //ambil data dari form jika ada
      let lat = document.getElementById('lat').value;
      let lng = document.getElementById('lng').value;
      let zoom = document.getElementById('zoom').value;
      let type = document.getElementById('map_type').value;
      if(lat == "")
        lat = -7.213306382670463;
      if(lng == "")
        lng = 113.32054138183595;
      if(zoom == "")
        zoom = 18;
      if (type == "")
        type = "HYBRID";

      //Jika posisi penjual belum ada, maka posisi peta akan daerah camplong
      let posisi = [lat,lng];
      let st_zoom = zoom;
            //Inisialisasi tampilan peta
      let peta = L.map('mapx').setView(posisi, st_zoom);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        id: 'mapbox.streets'
      }).addTo(peta);
      let pin = L.marker(posisi, {draggable: true}).addTo(peta);
      pin.on('dragend', function(e){
        document.getElementById('lat').value = e.target._latlng.lat;
        document.getElementById('lng').value = e.target._latlng.lng;
        document.getElementById('map_type').value = "HYBRID"
        document.getElementById('zoom').value = peta.getZoom();
      })
      peta.on('zoomstart zoomend', function(e){
        document.getElementById('zoom').value = peta.getZoom();
      })
  })();

</script>
<?php $this->load->view('themes/front/view_footer') ?>
