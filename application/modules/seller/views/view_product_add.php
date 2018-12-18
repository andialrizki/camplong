<?php $this->load->view('themes/front/view_header', ['title' => 'Tambah Produk']) ?>
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-sm-10">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-success text-center">Tambah Produk</h5>
            <hr>
            <?php echo showAlert($alert) ?>
            <?php if(!empty($seller->seller_province_id) && !empty($seller->seller_city_id) && !empty($seller->seller_subdistrict_id) && !empty($seller->seller_address)): ?>
              <form action="<?php echo site_url('seller/product/action/add') ?>" method="post" autocomplete="off">
                <div class="form-group">
                  <label>Kategori</label>
                  <select class="form-control" name="post[product_category_id]" required>
                    <option value="">-- Pilih --</option>
                    <?php foreach ($cat as $d): ?>
                      <option value="<?php echo $d->category_id ?>"><?php echo $d->category_title ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Nama Produk</label>
                  <input type="text" class="form-control" placeholder="ketik disini" name="post[product_title]" required>
                </div>
                <div class="form-group">
                  <label>Harga</label>
                  <div class="form-row">
                    <div class="col-sm-4">
                      <input type="text" class="form-control" placeholder="ketik disini" name="post[product_price]" required>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>Berat <small class="font-italic text-primary">(dalam gram)</small></label>
                  <div class="form-row">
                    <div class="col-sm-3">
                      <input type="text" class="form-control" placeholder="ketik disini" name="post[product_weight]" required>
                    </div>
                  </div>
                </div>
                <label class="text-primary">Ketersediaan</label>
                <div class="form-group">
                  <div class="form-row">
                    <label class="col-sm-3">Stok</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" placeholder="ketik disini" name="post[product_stock]" required>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="form-row">
                    <label class="col-sm-3">Jenis Stok</label>
                    <div class="col-sm-3">
                      <select class="form-control" name="post[product_stock_type]" required>
                        <option value="">-- Pilih --</option>
                        <option value="Buah">Buah</option>
                        <option value="Pack">Pack</option>
                        <option value="Pcs">Pcs</option>
                        <option value="Gram">Gram</option>
                        <option value="Kilogram">Kilogram</option>
                        <option value="Liter">Liter</option>
                        <option value="Sak">Sak</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>Deskripsi Produk</label>
                  <textarea class="form-control" placeholder="ketik disini" name="post[product_description]" rows="10" required></textarea>
                </div>
                <div class="float-right">
                  <button type="submit" class="btn btn-primary">SIMPAN</button> 
                  <a href="<?php echo site_url('seller/dashboard') ?>" class="btn btn-danger">KEMBALI</a>
                </div>
              </form>
            <?php else: ?>
              <?php echo showAlert(['status'=>'info', 'message'=>'Anda belum dapat menambahkan produk, dikarenakan Anda belum melengkapi profil Anda, silahkan lengkapi terlebih dahulu melalui <b><a href="'.site_url('seller/account').'">Edit Profil</a></b>.']) ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
<?php $this->load->view('themes/front/view_footer_script') ?>
<?php $this->load->view('themes/front/view_footer') ?>
