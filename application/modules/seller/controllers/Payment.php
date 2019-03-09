<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 21/10/2018
 */
class Payment extends CI_Controller
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
		$data['alert'] = $this->session->alert;
		$data['me'] = $this->db->get_where('seller',['seller_id'=>$seller->id])->row();
		$data['bank'] = $this->db->get_where('seller_bank',['bank_seller_id'=>$seller->id])->result();
		$data['history'] = $this->db
			->join('seller_bank', 'bank_id = reqfund_bank_id')
			->get_where('reqfund',['reqfund_seller_id'=>$seller->id])->result();
		$data['count_req'] = $this->db->get_where('reqfund', ['reqfund_status !='=>4])->num_rows();
		$this->load->view('view_payment',$data);
	}
	function add_bank()
	{
		$seller = getSellerSession();
		$dt = $this->input->post('post');
		$dt['bank_seller_id'] = $seller->id;
		$this->db->insert('seller_bank', $dt);
		$this->session->set_flashdata('alert', [
			'status'=>'success', 
			'message'=>'Data Rekening Sudah Disimpan']);
		redirect('seller/payment');
	}
	function get_bank()
	{
		$id = $this->input->get('id');
		$seller = getSellerSession();
		header('Content-Type: application/json');
		$dt = $this->db->get_where('seller_bank', ['bank_id'=>$id, 'bank_seller_id'=>$seller->id])->row();
		echo json_encode($dt);
	}
	function edit_bank($id)
	{
		$seller = getSellerSession();
		$dt = $this->input->post('post');
		$this->db->update('seller_bank', $dt, ['bank_seller_id'=>$seller->id, 'bank_id'=>$id]);
		$this->session->set_flashdata('alert', [
				'status'=>'success', 
				'message'=>'Data bank berhasil disimpan']);
		redirect('seller/payment');
	}
	function del_bank($id)
	{
		$seller = getSellerSession();
		$dt = $this->input->post('post');
		$this->db->delete('seller_bank', ['bank_seller_id'=>$seller->id, 'bank_id'=>$id]);
		$this->session->set_flashdata('alert', [
				'status'=>'success', 
				'message'=>'Data bank berhasil dihapus']);
		redirect('seller/payment');
	}
	function request_fund()
	{
		$seller = getSellerSession();
		$dt = $this->input->post('post');
		$dt['reqfund_status'] = 1; //request
		$dt['reqfund_datetime'] = date('Y-m-d H:i:s');
		$dt['reqfund_seller_id'] = $seller->id;
		$bal = $this->db->get_where('seller', ['seller_id'=>$seller->id])->row()->seller_balance;
		if($bal >= 50000){
			$this->db->insert('reqfund', $dt);
			$newbal = $bal - $dt['reqfund_value'];
			$this->db->update('seller', ['seller_balance'=>$newbal], ['seller_id'=>$seller->id]);
			$this->session->set_flashdata('alert', [
				'status'=>'success', 
				'message'=>'Permintaan pencairan saldo sudah kami terima, akan kami proses secepatnya, silahkan menunggu konfirmasi selanjutnya']);
		} else {
			$this->session->set_flashdata('alert', [
				'status'=>'error', 
				'message'=>'Permintaan pencairan saldo gagal, minimal untuk melakukan pencairan adalah sebesar Rp. 50.000']);
		}
		redirect('seller/payment');

	}

}
 ?>