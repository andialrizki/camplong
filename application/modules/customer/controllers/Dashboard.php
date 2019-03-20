<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Halaman Dashboard Pelanggan
 */
class Dashboard extends CI_Controller
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
		$data['me']		= $this->db->get_where('customer', ['customer_id'=>$cust->id])->row();
		$this->load->view('view_dashboard', $data);
	}
}
 ?>