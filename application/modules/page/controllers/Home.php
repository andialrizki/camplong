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
		$this->load->view('view_home',$data);
	}
}
 ?>