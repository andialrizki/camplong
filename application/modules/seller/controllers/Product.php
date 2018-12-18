<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 20/10/2018
 */
class Product extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!isSellerLogin()) {
			redirect('seller/signin');
		}
	}
	function add()
	{
		$seller = getSellerSession();
		$data['alert'] = $this->session->alert;
		$data['cat'] = $this->db->get('category')->result();
		$data['seller'] = $this->db->get_where('seller', ['seller_id'=>$seller->id])->row();
		$this->load->view('view_product_add', $data);
	}
	function edit($id='')
	{
		$seller = getSellerSession();
		$cek = $this->db
			->join('category', 'category_id = product_category_id')
			->get_where('product', ['product_id'=>$id, 'product_seller_id'=>$seller->id]);
		if ($cek->num_rows() > 0) {
			$data['alert'] = $this->session->alert;
			$data['cat'] = $this->db->get('category')->result();
			$data['data'] = $cek->row();
			$this->load->view('view_product_edit', $data);
		}
	}
	function action($act='')
	{
		$id = $this->input->get('id');
		$post = $this->input->post('post');
		$seller = getSellerSession();
		switch ($act) {
			case 'add':
				$post['product_url'] = url_title($post['product_title'], '-', true).'-'.getRandomWord();
				$post['product_picture'] = "product_picture_default.jpg";
				$post['product_status'] = 2; //draf 
				$post['product_seller_id'] = $seller->id;
				$this->db->insert('product', $post);
				$id = $this->db->insert_id();
				$this->session->set_flashdata('alert', [
					'status'=>'success', 
					'message'=>'Anda telah menambahkan produk baru, selanjutnya Anda dapat menambah gambar untuk produk Anda']);
				redirect('seller/product/picture/'.$id.'?first=add');
				break;
			case 'edit':
				$cek = $this->db->get_where('product', ['product_seller_id'=>$seller->id, 'product_id'=>$id]);
				if($cek->num_rows() > 0){
					if (empty($post['product_stock']) || $post['product_stock'] == 0) {
						$post['product_status'] = 3;
					}
					$this->session->set_flashdata('alert', [
						'status'=>'success', 
						'message'=>'Anda telah mengubah keterangan produk']);
					$this->db->update('product', $post, ['product_id'=>$id]);
					redirect('seller/product/edit/'.$id);
				} else {
					redirect('seller/dashboard');
				}
				break;
			case 'picture':
				$cek = $this->db->get_where('product', ['product_seller_id'=>$seller->id, 'product_id'=>$id]);
				if($cek->num_rows() > 0){
					$first = $this->input->get('first');
					$config['upload_path'] 		= './public/seller/product/';
					$config['allowed_types'] 	= 'jpg|jpeg|png|gif';
					$config['max_size']			= '2000';
					$config['file_name']		= $cek->row()->product_url;
					$config['overwrite']		= TRUE;
					$this->load->library('upload', $config);
					if ($this->upload->do_upload('file')){
						$upload_data = $this->upload->data();
						if (file_exists($config['upload_path'].'resize-'.$cek->row()->product_url)) {
							unlink($config['upload_path'].'resize-'.$cek->row()->product_url);
							sleep(0.5);
						}
						// load libs
						$v1 = $this->load->library('imageresize', 
							array('filename' => $config['upload_path'].$upload_data['file_name']));
						$v1->imageresize->resize(500, 300, true);
						$newfile = $config['upload_path'].'resize-'.$upload_data['file_name'];
						$v1->imageresize->save($newfile);
						$data['product_picture'] = $upload_data['file_name'];
						// unlink($config['upload_path'].$upload_data['file_name']);
						if ($first=="add") {
							$data['product_status'] = 1; //publish
						}
						$this->db->update('product', $data, ['product_id' => $id]);
						$this->session->set_flashdata('alert', [
							'status'=>'success', 
							'message'=>'Anda telah mengubah gambar produk']);
						redirect('seller/product/picture/'.$id);
						
					} else {
						$this->session->set_flashdata('alert', [
							'status'=>'error', 
							'message'=>$this->upload->display_errors()]);
						redirect('seller/product/picture/'.$id.'?first='.$first);
					}
				} else {
					redirect('seller/dashboard');
				}
				break;
			default:
				# code...
				break;
		}
	}
	function picture($id='')
	{
		$seller = getSellerSession();
		$cek = $this->db
			->join('category', 'category_id = product_category_id')
			->get_where('product', ['product_id'=>$id, 'product_seller_id'=>$seller->id]);
		if ($cek->num_rows() > 0) {
			$data['alert'] = $this->session->alert;
			$data['data'] = $cek->row();
			$data['first'] = $this->input->get('first');
			$this->load->view('view_product_picture', $data);
		}
	}
}
 ?>