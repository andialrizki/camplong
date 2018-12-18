<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
Class Dashboard extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		if (!isOwnerLogin()) {
			redirect('webmin/auth');
		}
	}
	function index()
	{
		$data['prod_active'] = $this->db->get_where('product', ['product_status'=>1])->num_rows();
		$data['prod_nonactive'] = $this->db->get_where('product', ['product_status !='=>1])->num_rows();
		$data['customer'] 	= $this->db->count_all('customer');
		$data['seller']		= $this->db->count_all('seller');
		$data['order']		= $this->db
			->where_in('transaction_status', [1,2,3,4])
			->get('transaction')->num_rows();
		$data['confirm']	= $this->db->get_where('transaction_confirm', ['transconf_status'=>1])->num_rows();
		$data['process'] = $this->db->get_where('transaction', ['transaction_status'=>3])->num_rows();
		$data['shipping'] = $this->db->get_where('transaction', ['transaction_status'=>4])->num_rows();
		$data['finish'] = $this->db->get_where('transaction', ['transaction_status'=>5])->num_rows();
		$data['failed']	= $this->db
			->where_in('transaction_status', [6,7,8])
			->get('transaction')->num_rows();

		$this->load->view('dashboard/view_dashboard', $data);
	}
}