<?php $this->load->view('themes/back/view_header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Produk
      <small><?php echo $data->product_title ?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo webmin_url() ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li>Produk</li>
      <li>Detail</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <!-- solid sales graph -->
        <div class="box box-primary">
          <div class="box-header">
            <i class="fa fa-circle-o"></i>
            <h3 class="box-title">Detail Produk</h3>
          </div>
          <div class="box-body border-radius-none">
            <?php echo showAlert($alert) ?>
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <th style="width: 180px">Judul</th>
                  <td><?php echo $data->product_title ?></td>
                </tr>
                <tr>
                  <th>Penjual</th>
                  <td><?php echo $data->seller_name ?></td>
                </tr>
                <tr>
                  <th>Kategori</th>
                  <td><?php echo $data->category_title ?></td>
                </tr>
                <tr>
                  <th>Harga</th>
                  <td>Rp<?php echo number_format($data->product_price) ?></td>
                </tr>
                <tr>
                  <th>Status</th>
                  <td><?php echo productStatus($data->product_status) ?></td>
                </tr>
                <tr>
                  <th>Stok</th>
                  <td><?php echo $data->product_stock.' '.$data->product_stock_type ?></td>
                </tr>
                <tr>
                  <th>Berat</th>
                  <td><?php echo gramToKg($data->product_weight) ?></td>
                </tr>
                <tr>
                  <th>Gambar</th>
                  <td>
                    <?php if(file_exists('public/seller/product/'.$data->product_picture) && !empty($data->product_picture)): ?>
                      <img src="<?php echo base_url('public/seller/product/'.$data->product_picture) ?>" style="max-width: 400px">
                    <?php else: ?>
                      Gambar tidak ada.
                    <?php endif; ?>
                  </td>
                </tr>
                <tr>
                  <th>Deskripsi</th>
                  <td><?php echo $data->product_description ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php $this->load->view('themes/back/view_footer_script'); ?>
<?php $this->load->view('themes/back/view_footer'); ?>
