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
	function index()
	{
		$seller = getSellerSession();
		$data['data']	 = $this->db
			->join('customer', 'customer_id = transaction_customer_id')
			->join('transaction_confirm', 'transaction_id = transconf_transaction_id')
			->get_where('transaction', ['transaction_seller_id'=>$seller->id])
			->result();
		$this->load->view('view_order', $data);
	}
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