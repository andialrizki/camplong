<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
Class Confirm extends CI_Controller {
	protected $table = "transaction_confirm";
	protected $primary_id = "transconf_id";
	protected $module_url = "webmin/transaction/confirm";
	function __construct()
	{
		parent::__construct();
		if (!isOwnerLogin()) {
			redirect('webmin/auth');
		}
	}
	function index()
	{
		$data['alert'] = $this->session->alert;
		$data['data'] = $this->db
			->join('owner_bank', 'bank_id = transconf_bank_id')
			->join('transaction', 'transaction_id = transconf_transaction_id')
			->get_where($this->table)->result();
		$this->load->view('transaction/view_confirm', $data);
	}
	function accept($id)
	{
		$this->db->update($this->table,['transconf_status'=>2], [$this->primary_id=>$id]);
		$this->session->set_flashdata('alert', ['status'=>'success', 'message'=>'Konfirmasi pembayaran telah Anda SETUJUI, Pesanan diteruskan ke penjual']);
		redirect($this->module_url);
	}
	function reject()
	{
		$trx_code = $this->input->post('code');
		$conf_id = $this->input->post('conf_id');
		$note = $this->input->post('note');
		$this->db->update($this->table, ['transconf_status'=>3, 'transconf_note'=>$note], [$this->primary_id=>$conf_id]);
		$this->session->set_flashdata('alert', ['status'=>'success', 'message'=>'Konfirmasi pembayaran ['.$trx_code.'] telah Anda TOLAK']);
		redirect($this->module_url);

	}

}