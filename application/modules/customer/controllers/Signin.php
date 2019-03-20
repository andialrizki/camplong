<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class untuk login pelanggan
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
			redirect('customer/dashboard');
		}
		$data['alert'] = $this->session->alert;
		$data['source']	= $this->input->get('source');
		$this->load->view('view_signin', $data);
	}
	function submit()
	{
		if (isSellerLogin()) {
			redirect('customer/dashboard');
		}
		$ids = trim($this->input->post('ids'));
		$pass = trim($this->input->post('password'));
		$source	= $this->input->get('source');
		$cek = $this->db->where('customer_email', $ids)->or_where('customer_nohp', $ids)->get('customer');
		if ($cek->num_rows() > 0) {
			$d = $cek->row();
			/**
			 * Cek password yang telah dienkripsi
			 */
			if (checkPassword($pass, $d->customer_password)) {
				$this->session->set_userdata('customer', [
					'islogin' => true,
					'id'=>$d->customer_id,
					'name'=>$d->customer_name,
					'picture'=>$d->customer_picture]);
				if(!empty($source))
					redirect(getSource($source));
				else
					redirect('customer/dashboard');
				die();
			} else {
				$msg = 'Kata sandi Anda tidak cocok';
			}
		} else {
			$msg = 'Identitas Anda tidak terdaftar pada sistem kami';
		}
		$this->session->set_flashdata('alert', ['status'=>'error', 'message'=>$msg]);
		redirect('customer/signin?source='.$source);
	}
	function out()
	{
		$this->session->unset_userdata('customer');
		redirect('customer/signin');
	}
}
 ?>