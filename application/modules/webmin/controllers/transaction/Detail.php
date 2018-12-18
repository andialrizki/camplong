<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
Class Detail extends CI_Controller {
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
	function index($code)
	{
		$data['url']	= $this->module_url;
		$data['alert']	= $this->session->alert;
		$data['code']	= $code;
		$data['data']	= $this->db
			->join('seller', 'seller_id = transaction_seller_id')
			->join('customer', 'customer_id = transaction_customer_id')
			->get_where($this->table, ['transaction_code'=>$code])->result();
		$this->load->view('transaction/view_detail', $data);
	}

}