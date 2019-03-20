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
	/**
	 * [index method ini untuk halaman pasar (produk yang dijual penjual)]
	 * @return [type] [description]
	 */
	function index()
	{
		$data['data'] = $this->db
			->select('product_title, product_price, product_id, product_picture, product_url, seller_id, seller_name, AVG(rating) AS rating')
			->join('seller', 'seller_id = product_seller_id')
			->join('seller_rating', 'rating_seller_id = seller_id','left')
			->or_where('product_stock >', 0)
			->group_by('product_id')
			->order_by('rating','desc')
			->get_where('product', ['product_status' => 1])->result(); //1 publish
		$this->load->view('view_store', $data);
	}
}
 ?>