<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * pendaftaran penjual
 */
class Register extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (isSellerLogin()) {
			redirect('seller/dashboard');
		}
	}
	function index()
	{
		$data['alert']	= $this->session->alert;
		$data['fdata']	= json_encode($this->session->fdata);
		$this->load->view('view_register', $data);
	}
	function submit()
	{
		$post = $this->input->post('post');
		$repass = $this->input->post('repassword');
		if (trim($post['seller_password']) == trim($repass)) {
			$cekEmail = $this->db->where('seller_email', $post['seller_email'])->get('seller');
			if ($cekEmail->num_rows() == 0) {
				$cekHp = $this->db->where('seller_nohp', $post['seller_nohp'])->get('seller');
				if ($cekHp->num_rows() == 0) {
					$post['seller_password'] = trim(createPassword($post['seller_password']));
					$post['seller_picture'] = "seller_default_img.jpg"; //foto profil default
					$post['seller_balance'] = 0; // saldo diset 0
					$post['seller_status']  = 1; //status aktif
					$this->db->insert('seller', $post);
					$this->session->set_flashdata('reg_success', true);
					redirect('seller/register/success');
					die();
				} else {
					$msg = 'Nomor HP yg Anda masukkan sudah terdaftar';
				}
			} else {
				$msg = 'Alamat Email yg Anda masukkan sudah terdaftar';
			}
		} else {
			$msg = 'Kata sandi dan Konfirmasi kata sandi tidak sama';
		}
		unset($post['seller_password']);
		$this->session->set_flashdata('fdata', $post);
		$this->session->set_flashdata('alert', ['status'=>'error', 'message'=>$msg]);
		redirect('seller/register');
	}
	function success()
	{
		$sess = $this->session->reg_success;
		if ($sess) {
			$this->load->view('view_register_success');
		} else {
			redirect('seller/signin');
		}
	}
}
 ?>