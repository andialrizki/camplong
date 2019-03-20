<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
Class Reqfund extends CI_Controller {
	/**
	 * untuk mengkonfirmasi dan memproses permintaan pencairan dana oleh penjual
	 * @var string
	 */
	protected $table = "reqfund";
	protected $primary_id = "reqfund_id";
	protected $module_url = "webmin/seller/reqfund";
	function __construct()
	{
		parent::__construct();
		if (!isOwnerLogin()) {
			redirect('webmin/auth');
		}
	}
	function index()
	{
		$filter = $this->input->get('filter');
		$data['alert'] = $this->session->alert;
		$data['filter'] = [1=>'Menunggu Konfirmasi', 2=>'Diproses', 3=>'Ditolak', 4=>'Selesai'];
		$data['filter_selected'] = $filter;
		if(empty($filter)){
			$data['data'] = $this->db
				->join('seller', 'seller_id = reqfund_seller_id')
				->join('seller_bank', 'bank_seller_id = seller_id')
				->get($this->table)->result();
		} else {
			$data['data'] = $this->db
				->join('seller', 'seller_id = reqfund_seller_id')
				->join('seller_bank', 'bank_seller_id = seller_id')
				->get_where($this->table, ['reqfund_status'=>$filter])->result();
		}
		$this->load->view('seller/view_reqfund', $data);
	}
	/**
	 * tolak pengajuan pencairan saldo,saldo dikembalikan kepada penjual
	 * @param  [type] $id [id permintaan pencairan saldo]
	 * @return [type]     [description]
	 */
	function reject($id)
	{
		$qseller = $this->db
			->join('seller', 'seller_id = reqfund_seller_id')
			->get_where($this->table, ['reqfund_id'=>$id]);
		if($qseller->num_rows() > 0){		
			$seller = $qseller->row();
			$bal = $this->db->get_where('seller', ['seller_id'=>$seller->seller_id])->row()->seller_balance;
			$newbal = $bal + $seller->reqfund_value;
			$this->db->update('seller',['seller_balance'=>$newbal], ['seller_id'=>$seller->seller_id]);
			$this->db->update('reqfund', ['reqfund_status'=>3], ['reqfund_id'=>$id]);
			$this->session->set_flashdata('alert', ['status'=>'success', 'message'=>'Anda telah menolak pencairan saldo ini, saldo dikembalikan ke penjual']);
		}
		redirect($this->module_url);
	}
	/**
	 * terima pengajuan pencairan saldo, selanjutnya admin diharuskan mentransfer ke rekening penjual lalu mengkonfirmasinya kembali dengan mengklik tombol selesai
	 * @param  [type] $id [id permintaan pencairan saldo]
	 * @return [type]     [description]
	 */
	function accept($id)
	{
		$qseller = $this->db
			->join('seller', 'seller_id = reqfund_seller_id')
			->get_where($this->table, ['reqfund_id'=>$id]);
		if($qseller->num_rows() > 0){		
			$seller = $qseller->row();
			$this->db->update('reqfund', ['reqfund_status'=>2], ['reqfund_id'=>$id]);
			$this->session->set_flashdata('alert', ['status'=>'success', 'message'=>'Anda telah menyetujui pencairan saldo ini, selanjutnya anda harus melakukan setoran/transfer ke rekening penjual']);
		}
		redirect($this->module_url);
	}
	/**
	 * konfirmasi sudah transfer oleh admin ke rekening penjual
	 * @param  [type] $id [id permintaan pencairan saldo]
	 * @return [type]     [description]
	 */
	function finish($id)
	{
		$qseller = $this->db
			->join('seller', 'seller_id = reqfund_seller_id')
			->get_where($this->table, ['reqfund_id'=>$id]);
		if($qseller->num_rows() > 0){		
			$seller = $qseller->row();
			$this->db->update('reqfund', ['reqfund_status'=>4], ['reqfund_id'=>$id]);
			$this->session->set_flashdata('alert', ['status'=>'success', 'message'=>'Proses Pencairan saldo ini sudah selesai']);
		}
		redirect($this->module_url);
	}
}