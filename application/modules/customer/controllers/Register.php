<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 25/10/2018
 */
class Register extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (isSellerLogin()) {
			redirect('customer/dashboard');
		}
	}
	function index()
	{
		$data['alert']	= $this->session->alert;
		$data['fdata']	= json_encode($this->session->fdata);
		$data['source']	= $this->input->get('source');
		$this->load->view('view_register', $data);
	}
	function submit()
	{
		$post = $this->input->post('post');
		$repass = $this->input->post('repassword');
		$source = $this->input->get('source');
		if (trim($post['customer_password']) == trim($repass)) {
			$cekEmail = $this->db->where('customer_email', $post['customer_email'])->get('customer');
			if ($cekEmail->num_rows() == 0) {
				$cekHp = $this->db->where('customer_nohp', $post['customer_nohp'])->get('customer');
				if ($cekHp->num_rows() == 0) {
					$post['customer_password'] = trim(createPassword($post['customer_password']));
					$post['customer_picture'] = "customer_default_img.jpg";
					$post['customer_balance'] = 0;
					$post['customer_status']  = 1;
					$this->db->insert('customer', $post);
					$this->session->set_flashdata('reg_success', true);
					if(!empty($source)){
						$this->session->set_userdata('customer', [
							'islogin' => true,
							'id'=>$d->customer_id,
							'name'=>$d->customer_name,
							'picture'=>$d->customer_picture]);
						redirect(getSource($source));
					}
					else
						redirect('customer/register/success');
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
		unset($post['customer_password']);
		$this->session->set_flashdata('fdata', $post);
		$this->session->set_flashdata('alert', ['status'=>'error', 'message'=>$msg]);
		redirect('customer/register?source='.$source);
	}
	function success()
	{
		$sess = $this->session->reg_success;
		if ($sess) {
			$this->load->view('view_register_success');
		} else {
			redirect('customer/signin');
		}
	}
}
 ?>