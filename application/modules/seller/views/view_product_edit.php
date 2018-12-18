<?php $this->load->view('themes/front/view_header', ['title' => 'Ubah Keterangan Produk']) ?>
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-sm-10">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-success text-center">Ubah Keterangan Produk</h5>
            <hr>
            <?php echo showAlert($alert) ?>
            <form action="<?php echo site_url('seller/product/action/edit?id='.$data->product_id) ?>" method="post" autocomplete="off">
              <div class="form-group">
                <label>Kategori</label>
                <select class="form-control" name="post[product_category_id]" required>
                  <option value="">-- Pilih --</option>
                  <?php foreach ($cat as $d): ?>
                    <option value="<?php echo $d->category_id ?>" <?php echo ($d->category_id==$data->product_category_id?'selected':'') ?>><?php echo $d->category_title ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" class="form-control" placeholder="ketik disini" name="post[product_title]" value="<?php echo $data->product_title ?>" required>
              </div>
              <div class="form-group">
                <label>Harga</label>
                <div class="form-row">
                  <div class="col-sm-4">
                    <input type="text" class="form-control" placeholder="ketik disini" name="post[product_price]" value="<?php echo $data->product_price ?>" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Berat <small class="font-italic text-primary">(dalam gram)</small></label>
                <div class="form-row">
                  <div class="col-sm-3">
                    <input type="text" class="form-control" placeholder="ketik disini" name="post[product_weight]" value="<?php echo $data->product_weight ?>" required>
                  </div>
                </div>
              </div>
              <hr>
              <label class="text-primary">Ketersediaan</label>
              <div class="form-group">
                <div class="form-row">
                  <label class="col-sm-3">Status Produk</label>
                  <div class="col-sm-3">
                    <select class="form-control" name="post[product_status]" required>
                      <option value="">-- Pilih --</option>
                      <option value="1" <?php $data->product_status==1 and print('selected') ?>>Publish</option>
                      <option value="2" <?php $data->product_status==2 and print('selected') ?>>Draf (Konsep)</option>
                      <option value="3" <?php $data->product_status==3 and print('selected') ?>>Kosong (Habis)</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                  <label class="col-sm-3">Stok</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" placeholder="ketik disini" name="post[product_stock]" value="<?php echo $data->product_stock ?>" required>
                    <small class="font-italic text-muted">jika stok = 0, status produk Anda akan menjadi KOSONG (HABIS), dan tidak akan muncul di pasar</small>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                  <label class="col-sm-3">Jenis Stok</label>
                  <div class="col-sm-3">
                    <select class="form-control" name="post[product_stock_type]" required>
                      <option value="">-- Pilih --</option>
                      <option value="Buah" <?php $data->product_stock_type=='Buah' and print('selected') ?>>Buah</option>
                      <option value="Pack" <?php $data->product_stock_type=='Pack' and print('selected') ?>>Pack</option>
                      <option value="Pcs" <?php $data->product_stock_type=='Pcs' and print('selected') ?>>Pcs</option>
                      <option value="Gram" <?php $data->product_stock_type=='Gram' and print('selected') ?>>Gram</option>
                      <option value="Kilogram" <?php $data->product_stock_type=='Kilogram' and print('selected') ?>>Kilogram</option>
                      <option value="Liter" <?php $data->product_stock_type=='Liter' and print('selected') ?>>Liter</option>
                      <option value="Sak" <?php $data->product_stock_type=='Sak' and print('selected') ?>>Sak</option>
                    </select>
                  </div>
                </div>
              </div>
              <hr>
              <div class="form-group">
                <label>Deskripsi Produk</label>
                <textarea class="form-control" placeholder="ketik disini" name="post[product_description]" rows="10" required><?php echo $data->product_description ?></textarea>
              </div>
              <div class="float-right">
                <button type="submit" class="btn btn-primary">SIMPAN</button> 
                <a href="<?php echo site_url('seller/dashboard') ?>" class="btn btn-danger">KEMBALI</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
<?php $this->load->view('themes/front/view_footer_script') ?>
<?php $this->load->view('themes/front/view_footer') ?>
