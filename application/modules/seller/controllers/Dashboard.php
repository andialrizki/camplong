<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 19/10/2018
 */
class Dashboard extends CI_Controller
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
		$data['data']	 = $this->db->get_where('product', ['product_seller_id'=>$seller->id])->result();
		$data['order_num']	= $this->db
			->where_in('transaction_status', [1, 2])
			->get_where('transaction', ['transaction_seller_id'=>$seller->id])->num_rows();
		$data['me']		= $this->db->get_where('seller', ['seller_id'=>$seller->id])->row();
		$this->load->view('view_dashboard', $data);
	}
}
 ?>