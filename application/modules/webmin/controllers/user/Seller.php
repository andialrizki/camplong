<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
Class Seller extends CI_Controller {
	protected $table = "seller";
	protected $primary_id = "seller_id";
	protected $module_url = "webmin/user/seller";
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
		$data['data']	= $this->db->get($this->table)->result();
		$this->load->view('user/view_seller', $data);
	}
}