<!-- FOOTER -->
<!-- Modal -->
<div class="modal fade" id="mdl-register" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Mendaftar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
	        <div class="row justify-content-md-center">
	          <div class="col-sm-12 mb-2 mt-2">
	            <div class="card">
	              <div class="card-body">
	                <div class="row">
	                  <div class="col-sm-2">
	                    <img src="<?php echo base_url() ?>public/img/belanja.png" style="width: 80px" alt="Card image cap">
	                  </div>
	                  <div class="col-sm-6">
	                    <strong class="text-success">Mendaftar sebagai pembeli</strong>
	                    <p class="card-text">Saya ingin belanja jambu camplong secara online</p>
	                  </div>
	                  <div class="col-sm-4 align-self-center">
	                    <a href="<?php echo site_url('customer/register') ?>" class="btn btn-success">Daftar</a>
	                  </div>
	                </div>
	              </div>
	            </div>
	          </div>
	          <div class="col-sm-12 mb-2">
	            <div class="card">
	              <div class="card-body">
	                <div class="row">
	                  <div class="col-sm-2">
	                    <img src="<?php echo base_url() ?>public/img/petani.png" style="width: 80px" alt="Card image cap">
	                  </div>
	                  <div class="col-sm-6">
	                    <strong class="text-success">Mendaftar sebagai penjual</strong>
	                    <p class="card-text">Saya petani dan ingin berjualan jambu camplong secara online</p>
	                  </div>
	                  <div class="col-sm-4 align-self-center">
	                    <a href="<?php echo site_url('seller/register') ?>" class="btn btn-success">Daftar</a>
	                  </div>
	                </div>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="mdl-signin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Masuk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
	        <div class="row justify-content-md-center">
	          <div class="col-sm-12 mb-2 mt-2">
	            <div class="card">
	              <div class="card-body">
	                <div class="row">
	                  <div class="col-sm-2">
	                    <img src="<?php echo base_url() ?>public/img/belanja.png" style="width: 80px" alt="Card image cap">
	                  </div>
	                  <div class="col-sm-6">
	                    <strong class="text-success">Masuk sebagai pembeli</strong>
	                    <p class="card-text">Saya ingin belanja jambu camplong secara online</p>
	                  </div>
	                  <div class="col-sm-4 align-self-center">
	                    <a href="<?php echo site_url('customer/signin') ?>" class="btn btn-success">Masuk</a>
	                  </div>
	                </div>
	              </div>
	            </div>
	          </div>
	          <div class="col-sm-12 mb-2">
	            <div class="card">
	              <div class="card-body">
	                <div class="row">
	                  <div class="col-sm-2">
	                    <img src="<?php echo base_url() ?>public/img/petani.png" style="width: 80px" alt="Card image cap">
	                  </div>
	                  <div class="col-sm-6">
	                    <strong class="text-success">Masuk sebagai penjual</strong>
	                    <p class="card-text">Saya petani dan ingin berjualan jambu camplong secara online</p>
	                  </div>
	                  <div class="col-sm-4 align-self-center">
	                    <a href="<?php echo site_url('seller/signin') ?>" class="btn btn-success">Masuk</a>
	                  </div>
	                </div>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
      </div>
    </div>
  </div>
</div>
      <footer class="container">
        <p class="float-right"><a href="javascript:void()" onclick="backToTop()"><i class="fa fa-arrow-up"></i> ke-atas</a></p>
        <p>&copy; E-Commerce 2018. &middot; <a href="">Privacy</a> &middot; <a href="">Terms</a></p>
      </footer>
    </main>
 
  </body>
</html>