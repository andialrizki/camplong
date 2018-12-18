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
		if (!isCustomerLogin()) {
			redirect('customer/signin');
		}
	}
	function index()
	{
		$cust = getCustomerSession();
		$data['data']	 = $this->db
			->join('seller', 'seller_id = transaction_seller_id')
			->join('transaction_confirm', 'transaction_id = transconf_transaction_id')
			->get_where('transaction', ['transaction_customer_id'=>$cust->id])
			->result();
		$this->load->view('view_order', $data);
	}
	function detail($code)
	{
		$cust = getCustomerSession();
		$data['alert']	= $this->session->alert;
		$data['code']	= $code;
		$data['data']	= $this->db
			->join('seller', 'seller_id = transaction_seller_id')
			->join('customer', 'customer_id = transaction_customer_id')
			->get_where('transaction', ['transaction_code'=>$code, 'transaction_customer_id'=>$cust->id]);
		$this->load->view('view_order_detail', $data);
	}
	function received($code='')
	{
		$cust = getCustomerSession();
		$cek = $this->db->get_where('transaction', ['transaction_code'=>$code, 'transaction_customer_id'=>$cust->id]);
		if ($cek->num_rows() > 0) {
			$this->db->update('transaction', ['transaction_status'=>5], ['transaction_id'=>$cek->row()->transaction_id]);
			if($cek->row()->transaction_status == 4){
				$this->db->query('UPDATE seller SET seller_balance = seller_balance + '.$cek->row()->transaction_total_pay.' WHERE seller_id = '.$cek->row()->transaction_seller_id);
			}
			$this->session->set_flashdata('alert', ['status'=>'success', 'message'=>'Pesanan sudah Anda terima dan dana sudah diteruskan ke Penjual.']);
			redirect('customer/order/detail/'.$code);
		} else {
			$this->session->set_flashdata('alert', ['status'=>'error', 'message'=>'Transaksi tidak ditemukan']);
			redirect('customer/order');
		}
	}
	function tracking($code='')
	{
		$cust = getCustomerSession();
		$cek = $this->db
			->join('seller', 'seller_id = transaction_seller_id')
			->get_where('transaction', ['transaction_code'=>$code, 'transaction_customer_id'=>$cust->id]);
		if ($cek->num_rows() > 0) {
			$this->load->library('rajaongkir');
			$res = $this->rajaongkir->waybill($cek->row()->transaction_courier_receipt, $cek->row()->transaction_courier);
			$data['trk'] = json_decode($res, false);
			$data['data'] = $cek;
			$data['alert'] = $this->session->alert;
			$this->load->view('view_order_tracking', $data);
		} else {
			$this->session->set_flashdata('alert', ['status'=>'error', 'message'=>'Transaksi tidak ditemukan']);
			redirect('customer/order');
		}
	}
}
 ?>