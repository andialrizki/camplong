<?php $this->load->view('themes/front/view_header', ['title' => 'Beranda']) ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/vendor/leaflet/leaflet.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/vendor/leaflet/leaflet-routing-machine.css">
<div id="mapx" style="height: 600px"></div>
<?php $this->load->view('themes/front/view_footer_script') ?>
<script type="text/javascript" src="<?php echo base_url() ?>public/vendor/leaflet/leaflet-src.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/vendor/leaflet/leaflet-routing-machine.min.js"></script>
<script type="text/javascript">
  (function() {
    setTimeout(function() {peta.invalidateSize();}, 500);

      //Jika posisi penjual belum ada, maka posisi peta akan daerah camplong
      let posisi = [-7.213306382670463,113.32054138183595];
      let st_zoom = 14;
            //Inisialisasi tampilan peta
      let peta = L.map('mapx').setView(posisi, st_zoom);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 22,
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        id: 'mapbox.streets'
      }).addTo(peta);
      <?php foreach ($selloc as $d): ?>
        L.marker([<?php echo $d->selloc_lat ?>, <?php echo $d->selloc_lng ?>]).addTo(peta).bindPopup("<?php echo $d->seller_name ?><br><?php echo $d->seller_address ?>");
      <?php endforeach ?>
  })();
</script>
<?php $this->load->view('themes/front/view_footer') ?>
