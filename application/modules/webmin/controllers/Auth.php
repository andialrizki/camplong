<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
Class Auth extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	}
	function index()
	{
		$this->load->view('auth/view_auth');
	}
	function check()
	{
		$uname = $this->input->post('uname');
		$upass = $this->input->post('upass');
		$data = $this->db->get_where('owner', ['owner_username'=>$uname]);
		if ($data->num_rows() > 0) {
			$d = $data->row();
			if (checkPassword($upass, $d->owner_password)) {
				$this->session->set_userdata('owner_islogin', true);
				redirect('webmin/dashboard');
			} else {
				die("Password salah");	
			}
		} else {
			die("Username salah");
		}
	}
	function logout()
	{
		$this->session->sess_destroy();
		redirect('webmin/auth');
	}
}



 ?>