<?php $this->load->view('themes/front/view_header', ['title' => 'Detail Pesanan']) ?>
  <br>
  <div class="container">
    <?php if($data->num_rows() > 0): ?>
      <?php $d = $data->row() ?>
      <div class="row justify-content-center">
        <div class="col-sm-10 mb-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title text-success">Pemesanan</h5>
              <hr>
              <?php echo showAlert($alert) ?>
              <table class="table table-bordered">
                <tr>
                  <th>Penjual</th>
                  <td><a href=""><?php echo $d->seller_name ?></a></td>
                </tr>
                <tr>
                  <th>No. Transaksi</th>
                  <td><?php echo $d->transaction_code ?></td>
                </tr>
                <tr>
                  <th>Status Transaksi</th>
                  <td><?php echo transactionStatus($d->transaction_status) ?></td>
                </tr>
                <tr>
                  <th>Status Pembayaran</th>
                  <td>
                    <?php $sp = $this->db->get_where('transaction_confirm', ['transconf_transaction_id'=>$d->transaction_id])->row() ?>
                    <?php echo confirmStatus($sp->transconf_status) ?>
                  </td>
                </tr>
                <tr>
                  <th>Alamat Pengiriman</th>
                  <td>
                    <b>Nama Penerima: </b> <?php echo $d->transaction_receiver_name ?><br>
                    <?php $sdc = $this->db->get_where('subdistrict', ['subdistrict_id'=>$d->transaction_receiver_subdistrict_id])->row(); ?>
                    <?php echo $d->transaction_receiver_address ?>, 
                    <?php echo @$sdc->subdistrict_name.', '.@$sdc->subdistrict_city_type.' '.@$sdc->subdistrict_city.'<br>'.@$sdc->subdistrict_province; ?>
                    <br>
                    Kodepos: <?php echo $d->transaction_receiver_postcode ?><br>
                    Telepon: <?php echo $d->transaction_receiver_nohp ?>
                  </td>
                </tr>
                <tr>
                  <th>Jasa Pengiriman</th>
                  <td><?php echo strtoupper($d->transaction_courier) ?> <?php echo $d->transaction_courier_service ?></td>
                </tr>
                <tr>
                  <th>Nomor Resi</th>
                  <td>
                    <?php echo (empty($d->transaction_courier_receipt)?'-':$d->transaction_courier_receipt) ?>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-sm-10 mb-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title text-success">Hasil Lacak Resi</h5>
              <hr>
              <?php $rj = $trk->rajaongkir; ?>
              <?php if($rj->status->code == 200): ?>
                <?php if(!empty($rj->result)): ?>
                  <?php $res = $rj->result; ?>
                  <table class="table">
                    <tbody>
                      <tr>
                        <td width="130">No Resi</td>
                        <td>:</td>
                        <td><b><?php echo (empty($d->transaction_courier_receipt)?'-':$d->transaction_courier_receipt) ?></b></td>
                      </tr>
                      <tr>
                        <td>Status</td>
                        <td>:</td>
                        <td><b><?php echo $res->summary->status ?></b></td>
                      </tr>
                      <tr>
                        <td>Service</td>
                        <td>:</td>
                        <td><?php echo $res->summary->service_code ?></td>
                      </tr>
                      <tr>
                        <td>Dikirim tanggal</td>
                        <td>:</td>
                        <td><?php echo $res->details->waybill_date ?> <?php echo $res->details->waybill_time ?></td>
                      </tr>
                      <tr>
                        <td valign="top">Dikirim oleh</td>
                        <td valign="top">:</td>
                        <td valign="top"><?php echo $res->summary->shipper_name ?><br><?php echo $res->summary->origin ?></td>
                      </tr>
                      <tr>
                        <td valign="top">Dikirim ke</td>
                        <td valign="top">:</td>
                        <td valign="top"><?php echo $res->summary->receiver_name ?><br> <?php echo $res->summary->destination ?></td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="table-responsive">
                    <div style="margin-left:15px;margin-top:5px;">
                      <b>Delivery Time:</b> <?php echo $res->delivery_status->pod_date ?> <?php echo $res->delivery_status->pod_time ?>
                    </div>
                    <table class="table">
                      <tbody>
                        <tr>
                          <th width="30%">Tanggal</th>
                          <th width="70%">Keterangan</th>
                        </tr>
                        <?php foreach ($res->manifest as $m): ?>
                          <tr>
                            <td><?php echo $m->manifest_date ?> <?php echo $m->manifest_time ?></td>
                            <td><?php echo $m->manifest_description ?></td>
                          </tr>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                  </div>
                <?php endif; ?>
              <?php else: ?>
                <?php echo showAlert(['status'=>'error', 'message'=>$rj->status->description]) ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    <?php else: ?>
      <p>Transaksi tidak ditemukan</p>
    <?php endif; ?>
  </div>
  <br>
<?php $this->load->view('themes/front/view_footer_script') ?>
<?php $this->load->view('themes/front/view_footer') ?>
