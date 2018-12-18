<?php $this->load->view('themes/front/view_header', ['title' => 'Proses Belanja']) ?>
  <br>
  <div class="container">
    <form action="<?php echo site_url('store/cart/checkout_process') ?>" method="POST">
      <div class="row justify-content-center">
        <div class="col-sm-10 mb-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title text-success">Tujuan Pengiriman</h5>
              <hr>
              <?php echo showAlert($alert) ?>
              <div class="form-group">
                <label>Nama Penerima</label>
                <input type="text" class="form-control" placeholder="ketik disini" name="post[transaction_receiver_name]" autocomplete="off" value="<?php echo @$cust->customer_name ?>" required>
              </div>
              <div class="form-group">
                <label>Nomor Handphone</label>
                <input type="text" class="form-control" placeholder="ketik disini" name="post[transaction_receiver_nohp]" autocomplete="off" value="<?php echo @$cust->customer_nohp ?>" required>
              </div>
              <div class="form-group">
                <label>Provinsi</label>
                <select class="form-control" name="post[transaction_receiver_province_id]" id="province" onchange="changeProv(this.value)" required>
                  <option value="">-- Pilih --</option>
                  <?php foreach ($prov as $d): ?>
                    <option value="<?php echo $d->province_id ?>" <?php @$data->receiver_province_id==$d->province_id and print('selected') ?>><?php echo $d->province ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <label>Kota/Kabupaten</label>
                <select class="form-control" id="city" name="post[transaction_receiver_city_id]" onchange="changeCity(this.value)" required>
                  <option value="">-- Pilih --</option>
                </select>
              </div>
              <div class="form-group">
                <label>Kecamatan</label>
                <select class="form-control" id="subdistrict" name="post[transaction_receiver_subdistrict_id]" required>
                  <option value="">-- Pilih --</option>
                </select>
              </div>
              <div class="form-group">
                <label>Kodepos</label>
                <input type="text" class="form-control" placeholder="ketik disini" name="post[transaction_receiver_postcode]" autocomplete="off" id="Kodepos" required>
              </div>
              <div class="form-group">
                <label>Alamat</label>
                <textarea class="form-control" name="post[transaction_receiver_address]" required><?php echo @$cust->receiver_address ?></textarea>
                <small class="font-italic text-info">Nama jalan, RT RW Dusun, Desa/Kelurahan</small>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-sm-10 mb-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title text-success">Ringkasan Pesanan Anda</h5>
              <?php foreach ($data as $dt): ?>
                <nav class="mt-3">
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active bg-success text-white data-toggle="tab" href="<?php echo site_url('store/seller/'.$dt['seller_id']) ?>" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fa fa-user"></i> <?php echo $dt['seller_name'] ?></a>
                  </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                  <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="nav-home-tab" style="border:1px solid #eee">
                    <div class="table-responsive">
                      <table class="table">
                        <tr class="bg-success text-white">
                          <th colspan="2">Produk</th>
                          <th class="text-center">Qty</th>
                          <th>Berat Satuan</th>
                          <th>Harga</th>
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
                            <td class="text-center"><?php echo $d['qty'] ?>
                            </td>
                            <?php $weight = $opt['weight']*$d['qty'] ?>
                            <td><?php echo gramToKg($opt['weight']) ?></td>
                            <td>Rp<?php echo number_format($d['price']) ?></td>
                          </tr>
                          <?php 
                            $t_price+=($d['price']*$d['qty'] );
                            $t_qty+=$d['qty'];
                            $t_weight+=$weight;
                          ?>
                        <?php endforeach ?>
                        <tr>
                          <td colspan="2" class="text-right">Sub-total</td>
                          <td class="text-center"><?php echo $t_qty ?></td>
                          <td><?php echo gramToKg($t_weight) ?></td>
                          <td>Rp<?php echo number_format($t_price) ?></td>
                        </tr>
                        <tr>
                          <td colspan="4" class="text-right align-middle">Pilih Jasa Pengiriman</td>
                          <td>
                            <input type="hidden" name="seller[]" value="<?php echo $dt['seller_id'] ?>">
                            <input type="hidden" name="courier_code[]" id="kurirkode-<?php echo $dt['seller_id'] ?>">
                            <input type="hidden" name="courier_cost[]" id="kurircost-<?php echo $dt['seller_id'] ?>">
                            <select class="form-control kurir" id="kurir-<?php echo $dt['seller_id'] ?>" data-id="<?php echo $dt['seller_id'] ?>" name="courier_service[]" required>
                              <option value="">-- Pilih --</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4" class="text-right">Ongkos Kirim</td>
                          <td class="seller-ongkir" id="ongkir-<?php echo $dt['seller_id'] ?>" data-id="<?php echo $dt['seller_id'] ?>" data-weight="<?php echo $t_weight ?>">Rp<?php echo number_format(0) ?> </td>
                        </tr>
                        <tr>
                          <td colspan="4" class="text-right">Total</td>
                          <td id="total-<?php echo $dt['seller_id'] ?>" data-prodtotal="<?php echo $t_price ?>">Rp<?php echo number_format($t_price) ?></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
              <hr>
              <div class="float-left">
                <button class="btn btn-danger" type="button"><i class="fa fa-arrow-left"></i> Kembali</button>
              </div>
              <div class="float-right">
                <button class="btn btn-warning text-white" type="submit">Menuju Pembayaran <i class="fa fa-arrow-right"></i></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  <br>
<?php $this->load->view('themes/front/view_footer_script') ?>
<script type="text/javascript">
  function changeProv(id){
    $.ajax({
      url: "<?php echo site_url('store/cart/get_city') ?>",
      type: "GET",
      dataType: "json",
      data: {prov: id},
      beforeSend: function() {
        $("#city, #subdistrict, .kurir").prop('disabled', true);
        $(".seller-ongkir").html('Rp0');
      },
      success: function(res) {
        $("#city, #subdistrict, .kurir").prop('disabled', false);
        $("#city").html('<option value="">-- Pilih --</option>');
        $("#subdistrict, .kurir").html('<option value="">-- Pilih --</option>');
        $.each(res, function (i, v) {
          $("#city").append('<option value="'+v.city_id+'">'+v.city_name +' ' + v.city_type.replace('Kabupaten', 'Kab.') + '</option>');

        });
      }
    })
  }
  function changeCity(id){
    $.ajax({
      url: "<?php echo site_url('store/cart/get_subdistrict') ?>",
      type: "GET",
      dataType: "json",
      data: {city: id},
      beforeSend: function() {
        $("#subdistrict, .kurir").prop('disabled', true);
        $(".seller-ongkir").html('Rp0');
      },
      success: function(res) {
        $("#subdistrict, .kurir").prop('disabled', false);
        $("#subdistrict, .kurir").html('<option value="">-- Pilih --</option>');
        $.each(res, function (i, v) {
          $("#subdistrict").append('<option value="'+v.subdistrict_id+'">'+v.subdistrict_name+'</option>');
        });
        <?php if($rj_type == "basic"): ?>
          checkCost(id);
        <?php endif; ?>
      }
    })
  }
  <?php if($rj_type == "pro"): ?>
    $("#subdistrict").change(function() {
      checkCost($(this).val());
    });
  <?php endif; ?>
  function checkCost(dest) {
    var no = 1;
    $(".seller-ongkir").each(function() {
      var id = $(this).attr('data-id');
      var weight = $(this).attr('data-weight');
      $.ajax({
        url: "<?php echo site_url('store/cart/get_cost') ?>",
        data: {
          sel_id: id,
          weight: weight,
          dest: dest
        },
        type: "POST",
        dataType: "json",
        beforeSend: function () {
          $("#kurir-"+id).prop('disabled', true);
          $("#ongkir-"+id).html('Rp0');
        },
        success: function (res) {
         $("#kurir-"+id).prop('disabled', false);
         var rj = res.rajaongkir;
         if (rj.status.code == 200) {
          $("#kurir-"+id).html('<option value="">-- Pilih --</option>');
          $.each(rj.results, function (ia, va) {
            
            $.each(va.costs, function (ib, vb) {
              var cost = vb.cost[0].value;
              var etd = vb.cost[0].etd
                .replace('HARI','')
                .replace('DAYS')
                .replace('DAY').trim();
              if (etd.length > 0) {
                etd = '('+ etd + ' HARI)';
              }
              $("#kurir-"+id).append('<option value="'+vb.service+'" data-code="'+va.code+'" data-cost="'+cost+'">'+va.code.toUpperCase()+' '+vb.service+' '+etd+'</option>');
            })
          })
         }
        }
      });
      no++;
    });
  }
  $(".kurir").change(function() {
    var id = $(this).attr('data-id');
    var val = $('.kurir option:selected').attr('data-cost');
    var cd = $('.kurir option:selected').attr('data-code');
    var tot = $("#total-" + id).attr('data-prodtotal');
    if(val.length > 0){
      $("#ongkir-"+id).html('Rp'+val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
      $("#total-" + id).html('Rp'+ (parseInt(tot)+parseInt(val)).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
      $("#kurircost-"+id).val(val);
      $("#kurirkode-"+id).val(cd);
    }
    else{
      $("#ongkir-"+id).html('Rp0');
      $("#total-" + id).html('Rp'+tot.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
      $("#kurircost-"+id).val("0");
      $("#kurirkode-"+id).val("cd");
    }
  })
</script>
<?php $this->load->view('themes/front/view_footer') ?>
