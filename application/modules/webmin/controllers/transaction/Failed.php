<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * class ini untuk transaksi yang gagal
 */
Class Failed extends CI_Controller {
	protected $table = "transaction";
	protected $primary_id = "transaction_id";
	protected $module_url = "webmin/transaction/falied";
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
			->join('seller', 'seller_id = transaction_seller_id')
			->where_in('transaction_status', [7,8,9])
			->get($this->table)->result();
		$this->load->view('transaction/view_failed', $data);
	}

}