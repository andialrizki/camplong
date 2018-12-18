<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
Class Customer extends CI_Controller {
	protected $table = "customer";
	protected $primary_id = "customer_id";
	protected $module_url = "webmin/user/customer";
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
		$this->load->view('user/view_customer', $data);
	}
}