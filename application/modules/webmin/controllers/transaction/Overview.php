<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
Class Overview extends CI_Controller {
	protected $table = "transaction";
	protected $primary_id = "transaction_id";
	protected $module_url = "webmin/transaction/overview";
	function __construct()
	{
		parent::__construct();
		if (!isOwnerLogin()) {
			redirect('webmin/auth');
		}
	}
	function index()
	{
		$data['url']	= $this->module_url;
		$data['alert']	= $this->session->alert;
		$data['order']	= $this->db->get_where($this->table, ['transaction_status'=>1])->num_rows();
		$data['confirm']	= $this->db->get_where('transaction_confirm', ['transconf_status'=>1])->num_rows();
		$data['process']	= $this->db->get_where($this->table, ['transaction_status'=>3])->num_rows();
		$data['shipping']	= $this->db->get_where($this->table, ['transaction_status'=>4])->num_rows();
		$data['finish']	= $this->db->get_where($this->table, ['transaction_status'=>5])->num_rows();
		$data['falied']	= $this->db
			->where('transaction_status', 6)
			->or_where('transaction_status', 7)
			->or_where('transaction_status', 8)
			->get($this->table)->num_rows();
		$data['complaint']	= $this->db->get_where($this->table, ['transaction_status'=>9])->num_rows();
		$data['refund']	= $this->db->get_where($this->table, ['transaction_status'=>10])->num_rows();
		$this->load->view('transaction/view_transaction', $data);
	}

}