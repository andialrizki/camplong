<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
Class Show extends CI_Controller {
	/**
	 * tampilkan produk 
	 * @var string
	 */
	protected $table = "product";
	protected $primary_id = "product_id";
	protected $module_url = "webmin/product/show";
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
		$data['data']	= $this->db
			->join('seller', 'seller_id = product_seller_id')
			->join('category', 'category_id = product_category_id')
			->get($this->table)->result();
		$this->load->view('product/view_product', $data);
	}
	function detail($id)
	{
		$data['url']	= $this->module_url;
		$data['alert']	= $this->session->alert;
		$data['data']	= $this->db
			->join('seller', 'seller_id = product_seller_id')
			->join('category', 'category_id = product_category_id')
			->get_where('product', ['product_id'=>$id])->row();
		$this->load->view('product/view_product_detail', $data);
	}
}