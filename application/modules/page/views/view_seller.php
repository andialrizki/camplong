<?php $this->load->view('themes/front/view_header', ['title' => 'Beranda']) ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/vendor/leaflet/leaflet.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/vendor/leaflet/leaflet-routing-machine.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/vendor/leaflet/Control.Geocoder.css">

<div id="mapx" style="height: 600px"></div>
<?php $this->load->view('themes/front/view_footer_script') ?>
<script type="text/javascript" src="<?php echo base_url() ?>public/vendor/leaflet/leaflet-src.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/vendor/leaflet/leaflet-routing-machine.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/vendor/leaflet/Control.Geocoder.js"></script>
<script type="text/javascript">
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


  
  // placeholders for the L.marker and L.circle representing user's current position and accuracy    
  var current_position, current_accuracy;

  function onLocationFound(e) {
    // if position defined, then remove the existing position marker and accuracy circle from the map
    if (current_position) {
        peta.removeLayer(current_position);
        peta.removeLayer(current_accuracy);
    }

    var radius = e.accuracy / 2;

    current_position = L.marker(e.latlng).addTo(peta)
      .bindPopup("You are within " + radius + " meters from this point").openPopup();

    current_accuracy = L.circle(e.latlng, radius).addTo(peta);
    seller_marker(e.latlng);
  }
  function routing(from, to) {
    L.Routing.control({
        waypoints: [
            L.latLng(from.lat, from.lng),
            L.latLng(to.lat, to.lng)
        ],
        // routeWhileDragging: true,
        geocoder: L.Control.Geocoder.nominatim()
    }).addTo(peta);
  }
  function seller_marker(me_loc) {
    <?php foreach ($selloc as $d): ?>
      L.marker([<?php echo $d->selloc_lat ?>, <?php echo $d->selloc_lng ?>])
        .addTo(peta)
        .bindPopup("<?php echo $d->seller_name ?><br><?php echo $d->seller_address ?>")
        .on('click', function(e) {
          console.log(e.latlng);
          routing(me_loc, e.latlng);
        });
    <?php endforeach ?>
  }

  function onLocationError(e) {
    alert(e.message);
  }

  peta.on('locationfound', onLocationFound);
  peta.on('locationerror', onLocationError);

  // wrap map.locate in a function    
  function locate() {
    peta.locate({setView: true, maxZoom: 16});
  }

  // call locate every 3 seconds... forever
  setTimeout(locate, 2000);
  
  
</script>
<?php $this->load->view('themes/front/view_footer') ?>
