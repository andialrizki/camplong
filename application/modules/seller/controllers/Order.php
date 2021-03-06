<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 19/10/2018
 */
class Order extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!isSellerLogin()) {
			redirect('seller/signin');
		}
	}
	/**
	 * halaman pesanan penjual, menampilkan daftar pesanan
	 * untuk status transkasi bisa diliat di database, tabel: transaction cek bagian comment
	 * atau pada helpers/myhelper_helper.php
	 */
	function index()
	{
		$seller = getSellerSession();
		$filter = $this->input->get('filter');
		if ($filter == "not-confirm") {
			$status = 2;
		} elseif ($filter == "shipping") {
			$status = 4;
		} elseif ($filter == "finish") {
			$status = 5;
		} else {
			$status = "all";
		}
		if ($status == "all"){
			$data['data']	 = $this->db
				->join('customer', 'customer_id = transaction_customer_id')
				->join('transaction_confirm', 'transaction_id = transconf_transaction_id')
				->get_where('transaction', ['transaction_seller_id'=>$seller->id])
				->result();
		} else {
			$data['data']	 = $this->db
				->join('customer', 'customer_id = transaction_customer_id')
				->join('transaction_confirm', 'transaction_id = transconf_transaction_id')
				->where('transaction_status', $status)
				->get_where('transaction', ['transaction_seller_id'=>$seller->id])
				->result();
		}
		$data['filter'] = $filter;
		$this->load->view('view_order', $data);
	}
	/**
	 * method recap,sama dengan index, hanya ditambahkan header agar bisa didownload menjadi format excel
	 * @return [type] [description]
	 */
	function recap()
	{
		$filename = 'Rekap-Pesanan-di-sistem-camplong-'.date('d-m-y-H-i-s');
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$filename.xls");
		header('Content-Transfer-Encoding: binary');
		ob_clean(); flush();

		$seller = getSellerSession();
		$filter = $this->input->get('filter');
		if ($filter == "not-confirm") {
			$status = 2;
		} elseif ($filter == "shipping") {
			$status = 4;
		} elseif ($filter == "finish") {
			$status = 5;
		} else {
			$status = "all";
		}
		if ($status == "all"){
			$data['data']	 = $this->db
				->join('customer', 'customer_id = transaction_customer_id')
				->join('transaction_confirm', 'transaction_id = transconf_transaction_id')
				->get_where('transaction', ['transaction_seller_id'=>$seller->id])
				->result();
		} else {
			$data['data']	 = $this->db
				->join('customer', 'customer_id = transaction_customer_id')
				->join('transaction_confirm', 'transaction_id = transconf_transaction_id')
				->where('transaction_status', $status)
				->get_where('transaction', ['transaction_seller_id'=>$seller->id])
				->result();
		}
		$data['filter'] = $filter;
		$this->load->view('xls_order_recap', $data);
	}
	/**
	 * method detail, melihat detail pesanan (order)
	 * @param  [type] $code [nomor transaksi]
	 * @return [type]       [description]
	 */
	function detail($code)
	{
		$seller = getSellerSession();
		$data['alert']	= $this->session->alert;
		$data['code']	= $code;
		$data['data']	= $this->db
			->join('customer', 'customer_id = transaction_customer_id')
			->get_where('transaction', ['transaction_code'=>$code, 'transaction_seller_id'=>$seller->id]);
		$this->load->view('view_order_detail', $data);
	}
	/**
	 * method accept, jika penjual mengkonfirmasi pesanan dan akan segera dikirim
	 * @param  [type] $code [nomor transaksi]
	 * @return [type]       [description]
	 */
	function accept($code)
	{
		$seller = getSellerSession();
		$cek = $this->db->get_where('transaction', ['transaction_code'=>$code, 'transaction_seller_id'=>$seller->id]);
		if ($cek->num_rows() > 0) {
			$this->db->update('transaction', ['transaction_status'=>3], ['transaction_id'=>$cek->row()->transaction_id]);
			$this->session->set_flashdata('alert', ['status'=>'success', 'message'=>'Pesanan ini telah Anda konfirmasi, selanjutnya silahkan Anda melakukan pengiriman barang menggunakan jasa pengiriman yang telah dipilih oleh pembeli dan masukkan nomor resi pada halaman ini.']);
			redirect('seller/order/detail/'.$code);
		} else {
			$this->session->set_flashdata('alert', ['status'=>'error', 'message'=>'Transaksi tidak ditemukan']);
			redirect('seller/order');
		}
	}
	/**
	 * method reject, jika penjual menolak pesanan
	 * @param  [type] $code [nomor transksi]
	 * @return [type]       [description]
	 */
	function reject($code)
	{
		$seller = getSellerSession();
		$cek = $this->db->get_where('transaction', ['transaction_code'=>$code, 'transaction_seller_id'=>$seller->id]);
		if ($cek->num_rows() > 0) {
			$this->db->update('transaction', ['transaction_status'=>7], ['transaction_id'=>$cek->row()->transaction_id]);
			$this->session->set_flashdata('alert', ['status'=>'success', 'message'=>'Pesanan ini telah Anda TOLAK.']);
			redirect('seller/order/detail/'.$code);
		} else {
			$this->session->set_flashdata('alert', ['status'=>'error', 'message'=>'Transaksi tidak ditemukan']);
			redirect('seller/order');
		}
	}
	/**
	 * method updateresi, jika penjual sudah mengirimkan barang, maka selanjutnya penjual akan menginput nomor resi
	 * @param  [type] $code [nomor transaksi]
	 * @return [type]       [description]
	 */
	function updateresi($code)
	{
		$seller = getSellerSession();
		$cek = $this->db->get_where('transaction', ['transaction_code'=>$code, 'transaction_seller_id'=>$seller->id]);
		if ($cek->num_rows() > 0) {
			$resi = $this->input->post('resi');
			$this->db->update('transaction', ['transaction_status'=>4, 'transaction_courier_receipt'=>$resi], ['transaction_id'=>$cek->row()->transaction_id]);
			$this->session->set_flashdata('alert', ['status'=>'success', 'message'=>'Resi telah disimpan']);
			redirect('seller/order/detail/'.$code);
		} else {
			$this->session->set_flashdata('alert', ['status'=>'error', 'message'=>'Transaksi tidak ditemukan']);
			redirect('seller/order');
		}
	}
}
 ?>