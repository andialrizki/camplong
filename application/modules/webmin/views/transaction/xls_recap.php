<!DOCTYPE html>
<html>
<head>
  <title>Rekap Order</title>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/print.css') ?>">
</head>
<body>
  <h4 class="text-center">REKAP DATA PESANAN</h4><br>
  <table class="table-print" border="1">
    <thead>
      <tr>
        <th>No</th>
        <th>Kode</th>
        <th>Waktu</th>
        <th>Pembeli</th>
        <th>Penjual</th>
        <th>Produk</th>
        <th>Pengiriman</th>
        <th>Status Transaksi</th>
        <th>Status Pembayaran</th>
        <th>Catatan Pembeli</th>
        <th>Total Hrg Produk</th>
        <th>Ongkir</th>
        <th>Total Bayar</th>
      </tr>
    </thead>
    <tbody>
      <?php $no=1; ?>
      <?php $total_hrg_prd = 0; ?>
      <?php $total_ongkir = 0; ?>
      <?php $total_all = 0; ?>
      <?php foreach ($data as $d): ?>
        <tr>
          <td><?php echo $no ?></td>
          <td><?php echo $d->transaction_code ?></td>
          <td><?php echo $d->transaction_datetime ?></td>
          <td><?php echo $d->customer_name ?></td>
          <td><?php echo $d->seller_name ?></td>
          <td>
            <?php 
              $prod = $this->db
                ->select('product_title, transprod_price, transprod_qty')
                ->join('product', 'product_id = transprod_product_id')
                ->get_where('transaction_product', ['transprod_transaction_id'=>$d->transaction_id])
                ->result();
              $dt_prod = [];
              $nop=1;
              foreach ($prod as $p) {
                $dt_prod[] = $nop.'. '.$p->product_title . ' <b>x</b> '.$p->transprod_qty.' (Rp. '.number_format($p->transprod_price).')';
                $nop++;
              }
            ?>
            <?php echo implode('<br>', $dt_prod) ?>
          </td>
          <td><?php echo strtoupper($d->transaction_courier. ' '.$d->transaction_courier_service) ?></td>
          <td><?php echo transactionStatus($d->transaction_status) ?></td>
          <td><?php echo confirmStatus($d->transconf_status) ?></td>
          <td><?php echo (empty($d->transaction_note)?'-':$d->transaction_note) ?></td>
          <td>Rp. <?php echo number_format($d->transaction_product_value) ?></td>
          <td>Rp. <?php echo number_format($d->transaction_courier_cost) ?> (<?php echo gramToKg($d->transaction_weight) ?>)</td>
          <td>Rp. <?php echo number_format($d->transaction_total_pay) ?></td>
        </tr>
        <?php $no++ ?>
        <?php $total_hrg_prd += $d->transaction_product_value ?>
        <?php $total_ongkir += $d->transaction_courier_cost ?>
        <?php $total_all += $d->transaction_total_pay ?>
      <?php endforeach ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="9" style="text-align: right;">Total</th>
        <td>Rp. <?php echo number_format($total_hrg_prd) ?></td>
        <td>Rp. <?php echo number_format($total_ongkir) ?></td>
        <td>Rp. <?php echo number_format($total_all) ?></td>
      </tr>
    </tfoot>
  </table>
  <br>
  <small>Rekap Pesanan, diunduh pada: <?php echo date('d-m-Y H:i:s') ?></small>
</body>
</html>