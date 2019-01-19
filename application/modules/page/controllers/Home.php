<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 17/10/2018
 */
class Home extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}
	function index()
	{
		$data['bn'] = $this->db->get_where('banner', ['banner_status'=>1]);
		$data['selloc'] = $this->db
			->select('seller_name, seller_address,selloc_lat,selloc_lng')
			->join('seller', 'seller_id = selloc_seller_id')
			->get('seller_location')
			->result();
		$this->load->view('view_home',$data);
	}
}
 ?>