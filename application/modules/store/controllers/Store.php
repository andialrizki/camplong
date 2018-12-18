<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 17/10/2018
 */
class Store extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}
	function index()
	{
		$data['data'] = $this->db
			->select('product_title, product_price, product_id, product_picture, product_url, seller_id, seller_name')
			->join('seller', 'seller_id = product_seller_id')
			->or_where('product_stock >', 0)
			->get_where('product', ['product_status' => 1])->result(); //1 publish
		$this->load->view('view_store', $data);
	}
}
 ?>