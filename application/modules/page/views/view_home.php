<?php $this->load->view('themes/front/view_header', ['title' => 'Beranda']) ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/vendor/leaflet/leaflet.css">
<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <?php for($i=0; $i<$bn->num_rows(); $i++): ?>
      <li data-target="#myCarousel" data-slide-to="<?php echo $i ?>" <?php echo ($i == 0?'class="active"':'') ?>></li>
    <?php endfor; ?>
  </ol>
  <div class="carousel-inner">
    <?php $nob=0; ?>
    <?php foreach ($bn->result() as $d): ?>
      <div class="carousel-item <?php echo ($nob==0?'active':'') ?>">
        <img class="first-slide" src="<?php echo base_url('public/img/banner/'.$d->banner_file) ?>" style="opacity: 0.5" alt="<?php echo $d->banner_name ?>">
        <!-- <div class="container">
          <div class="carousel-caption text-left">
            <h1>Example headline.</h1>
            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            <p><a class="btn btn-lg btn-success" href="#" role="button">Sign up today</a></p>
          </div>
        </div> -->
      </div>
      <?php $nob++; ?>
    <?php endforeach ?>
  </div>
  <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
    <i class="fa fa-arrow-left" aria-hidden="true"></i>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
    <i class="fa fa-arrow-right" aria-hidden="true"></i>
    <span class="sr-only">Next</span>
  </a>
</div>
<div class="container">
  <div class="row justify-content-md-center">
    <div class="col-sm-6">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-2">
              <img src="<?php echo base_url() ?>public/img/belanja.png" style="width: 80px" alt="Card image cap">
            </div>
            <div class="col-sm-6">
              <strong class="text-success">Belanja</strong>
              <p class="card-text">Saya ingin belanja jambu camplong secara online</p>
            </div>
            <div class="col-sm-4 align-self-center">
              <a href="<?php echo site_url('store') ?>" class="btn btn-success">Berlanja</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-2">
              <img src="<?php echo base_url() ?>public/img/petani.png" style="width: 80px" alt="Card image cap">
            </div>
            <div class="col-sm-6">
              <strong class="text-success">Berjualan</strong>
              <p class="card-text">Saya petani dan ingin berjualan jambu camplong secara online</p>
            </div>
            <div class="col-sm-4 align-self-center">
              <a href="<?php echo site_url('seller/register') ?>" class="btn btn-success">Berjualan</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<br>
<br>
<div id="mapx" style="height: 320px"></div>
<?php $this->load->view('themes/front/view_footer_script') ?>
<script type="text/javascript" src="<?php echo base_url() ?>public/vendor/leaflet/leaflet-src.js"></script>
<script type="text/javascript">
  (function() {
    setTimeout(function() {peta.invalidateSize();}, 500);

      //Jika posisi penjual belum ada, maka posisi peta akan daerah camplong
      let posisi = [-7.213306382670463,113.32054138183595];
      let st_zoom = 12;
            //Inisialisasi tampilan peta
      let peta = L.map('mapx').setView(posisi, st_zoom);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        id: 'mapbox.streets'
      }).addTo(peta);
      <?php foreach ($selloc as $d): ?>
        L.marker([<?php echo $d->selloc_lat ?>, <?php echo $d->selloc_lng ?>]).addTo(peta).bindPopup("<?php echo $d->seller_name ?><br><?php echo $d->seller_address ?>");
      <?php endforeach ?>
  })();
</script>
<?php $this->load->view('themes/front/view_footer') ?>
