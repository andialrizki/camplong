<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 21/10/2018
 */
class Payment extends CI_Controller
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
		$this->load->view('view_payment');
	}
}
 ?>