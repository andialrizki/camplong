<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
Class Shipping extends CI_Controller {
	protected $table = "transaction";
	protected $primary_id = "transaction_id";
	protected $module_url = "webmin/transaction/shipping";
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
			->get_where($this->table, ['transaction_status'=>4])->result();
		$this->load->view('transaction/view_shipping', $data);
	}

}