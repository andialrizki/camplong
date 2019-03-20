<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * login penjual
 */
class Signin extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}
	function index()
	{
		if (isSellerLogin()) {
			redirect('seller/dashboard');
		}
		$data['alert'] = $this->session->alert;
		$this->load->view('view_signin', $data);
	}
	function submit()
	{
		if (isSellerLogin()) {
			redirect('seller/dashboard');
		}
		$ids = trim($this->input->post('ids'));
		$pass = trim($this->input->post('password'));
		$cek = $this->db->where('seller_email', $ids)->or_where('seller_nohp', $ids)->get('seller');
		if ($cek->num_rows() > 0) {
			$d = $cek->row();
			if (checkPassword($pass, $d->seller_password)) {
				$this->session->set_userdata('seller', [
					'islogin' => true,
					'id'=>$d->seller_id,
					'name'=>$d->seller_name,
					'picture'=>$d->seller_picture]);
				redirect('seller/dashboard');
				die();
			} else {
				$msg = 'Kata sandi Anda tidak cocok';
			}
		} else {
			$msg = 'Identitas Anda tidak terdaftar pada sistem kami';
		}
		$this->session->set_flashdata('alert', ['status'=>'error', 'message'=>$msg]);
		redirect('seller/signin');
	}
	function out()
	{
		$this->session->unset_userdata('seller');
		redirect('seller/signin');
	}
}
 ?>