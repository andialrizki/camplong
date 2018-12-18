<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 17/10/2018
 */
class Product extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}
	function detail($url='')
	{
		$data['data'] = $this->db
			->join('category', 'category_id = product_category_id')
			->join('seller', 'seller_id = product_seller_id')
			->get_where('product', ['product_url'=>trim($url)]);
		$this->load->view('view_product', $data);
	}
}
 ?>