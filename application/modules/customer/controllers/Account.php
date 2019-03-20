<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 			class untuk kelola akun pelanggan
 */
class Account extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!isCustomerLogin()) {
			redirect('customer/signin');
		}
	}
	function index()
	{
		$cust = getCustomerSession();
		$data['alert']	 = $this->session->alert;
		$data['data']	 = $this->db->get_where('customer', ['customer_id'=>$cust->id])->row();
		$data['prov']	 = $this->db->get('province')->result();
		$this->load->view('view_account', $data);
	}
	function submit()
	{
		$cust = getCustomerSession();
		$post = $this->input->post('post');
		$cekEmail = $this->db->get_where('customer', ['customer_email'=>$post['customer_email'], 'customer_id !=' => $cust->id])->num_rows();
		if ($cekEmail == 0) {
			$cekHp = $this->db->get_where('customer', ['customer_nohp'=>$post['customer_nohp'], 'customer_id !=' => $cust->id])->num_rows();
			if ($cekHp == 0) {
				$this->db->update('customer', $post, ['customer_id'=>$cust->id]);
				$this->session->set_flashdata('alert', ['status'=>'success', 'message'=>'Berhasil mengubah data']);
			} else {
				$this->session->set_flashdata('alert', ['status'=>'error', 'message'=>'No. HP yg Anda masukkan sudah terdaftar']);
			}
		} else {
			$this->session->set_flashdata('alert', ['status'=>'error', 'message'=>'Alamat email yg Anda masukkan sudah terdaftar']);
		}
		redirect('customer/account');
	}
	/*
		method mengambil data kota dan kecamatan, ouput berupa json
	 */
	function get_city()
	{
		header('Content-Type:application/json');
		$prov = $this->input->get('prov');
		$d = $this->db->get_where('city', ['city_province_id'=>$prov])->result();
		echo json_encode($d, JSON_PRETTY_PRINT);
	}
	function get_subdistrict()
	{
		header('Content-Type:application/json');
		$city = $this->input->get('city');
		$d = $this->db->get_where('subdistrict', ['subdistrict_city_id'=>$city])->result();
		echo json_encode($d, JSON_PRETTY_PRINT);
	}
}
 ?>