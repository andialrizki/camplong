<?php $this->load->view('themes/front/view_header', ['title' => 'Keranjang']) ?>
  <br>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-success">Keranjang Anda</h5>
            <hr>
            <?php echo showAlert($alert) ?>
            <?php foreach ($data as $dt): ?>
              <nav class="mt-3">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <a class="nav-item nav-link active bg-success text-white data-toggle="tab" href="<?php echo site_url('store/seller/'.$dt['seller_id']) ?>" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fa fa-user"></i> <?php echo $dt['seller_name'] ?></a>
                </div>
              </nav>
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="nav-home-tab" style="border:1px solid #eee">
                  <table class="table">
                    <tr class="bg-success text-white">
                      <th colspan="2">Produk</th>
                      <th class="pl-5">Qty</th>
                      <th>Berat Satuan</th>
                      <th>Harga</th>
                      <th style="width: 100px">Aksi</th>
                    </tr>
                    <?php $t_price=0; $t_qty=0; $t_weight=0; ?>
                    <?php foreach ($dt['cart'] as $d): ?>
                      <?php $opt = $this->cart->product_options($d['rowid']); ?>
                      <tr>
                        <td style="width: 100px">
                          <img src="<?php echo base_url('public/seller/product/resize-'.$opt['picture']) ?>" style="max-width: 80px" alt="<?php echo $d['name'] ?>">
                        </td>
                        <td class="align-middle text-left">
                          <a href="<?php echo site_url('store/product/detail/'.$opt['url']) ?>"><?php echo $d['name'] ?></a>
                        </td>
                        <td>
                          <form class="form-inline" action="<?php echo site_url('store/cart/update_item/'.$d['rowid']) ?>" method="post">
                            <div class="form-group mb-2 mr-2 ml-2">
                              <input type="number" min="1" class="form-control" style="width: 40px; text-align: center;" name="qty" placeholder="(cth: 1)" value="<?php echo $d['qty'] ?>" required>
                            </div>
                            <div class="mb-2">
                              <button type="submit" class="btn btn-sm btn-info" style="min-width: 30px;" data-toggle="tooltip" data-title="Update"><i class="fa fa-check"></i></button>
                            </div>
                          </form>
                        </td>
                        <?php $weight = $opt['weight']*$d['qty'] ?>
                        <td><?php echo gramToKg($opt['weight']) ?></td>
                        <td>Rp<?php echo number_format($d['price']) ?></td>
                        <td>
                          <a href="<?php echo site_url('store/cart/remove_from_cart/'.$d['rowid']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang Anda?')"  style="min-width: 30px;">
                            <i class="fa fa-trash"></i>
                          </a>
                        </td>
                      </tr>
                      <?php 
                        $t_price+=($d['price']*$d['qty'] );
                        $t_qty+=$d['qty'];
                        $t_weight+=$weight;
                      ?>
                    <?php endforeach ?>
                    <tr>
                      <td colspan="2" class="text-right">Jumlah</td>
                      <td class="pl-5"><?php echo $t_qty ?></td>
                      <td><?php echo gramToKg($t_weight) ?></td>
                      <td>Rp<?php echo number_format($t_price) ?></td>
                      <td>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            <?php endforeach; ?>
            <?php if ($this->cart->total_items() > 0): ?>
              <div class="text-right mt-3">
                <a href="<?php echo site_url('store/cart/resume') ?>" class="btn btn-warning text-white">Selanjutnya <i class="fa fa-arrow-right"></i></a>
              </div>
            <?php else: ?>
              <?php echo showAlert(['status'=>'info','message'=>'Keranjang Anda kosong, silahkan berbelanja terlebih dahulu di <a href="'.site_url('store').'"><b>DISINI</b></a>']) ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
<?php $this->load->view('themes/front/view_footer_script') ?>
<?php $this->load->view('themes/front/view_footer') ?>
