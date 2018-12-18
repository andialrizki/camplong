<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 20/10/2018
 */
class Account extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!isSellerLogin()) {
			redirect('seller/signin');
		}
		$this->load->config('gmaps', TRUE);
	}
	function index()
	{
		$seller = getSellerSession();
		$data['alert']	 = $this->session->alert;
		$data['gmaps']	 = $this->config->item('gmaps_api_key', 'gmaps');
		$data['data']	 = $this->db->get_where('seller', ['seller_id'=>$seller->id])->row();
		$data['prov']	 = $this->db->get('province')->result();
		$this->load->view('view_account', $data);
	}
	function submit()
	{
		$seller = getSellerSession();
		$post = $this->input->post('post');
		$cekEmail = $this->db->get_where('seller', ['seller_email'=>$post['seller_email'], 'seller_id !=' => $seller->id])->num_rows();
		if ($cekEmail == 0) {
			$cekHp = $this->db->get_where('seller', ['seller_nohp'=>$post['seller_nohp'], 'seller_id !=' => $seller->id])->num_rows();
			if ($cekHp == 0) {
				$this->db->update('seller', $post, ['seller_id'=>$seller->id]);
				$this->session->set_flashdata('alert', ['status'=>'success', 'message'=>'Berhasil mengubah data']);
			} else {
				$this->session->set_flashdata('alert', ['status'=>'error', 'message'=>'No. HP yg Anda masukkan sudah terdaftar']);
			}
		} else {
			$this->session->set_flashdata('alert', ['status'=>'error', 'message'=>'Alamat email yg Anda masukkan sudah terdaftar']);
		}
		redirect('seller/account');
	}
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