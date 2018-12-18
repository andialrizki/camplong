<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
Class Category extends CI_Controller {
	protected $table = "category";
	protected $primary_id = "category_id";
	protected $module_url = "webmin/product/category";
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
		$this->load->view('product/view_category', $data);
	}
	function action($act='')
	{
		$id = $this->input->get('id');
		$post = $this->input->post('post');
		switch ($act) {
			case 'add':
				$post['category_url'] = url_title($post['category_title'], '-', true);
				$this->db->insert($this->table, $post);
				$this->session->set_flashdata('alert', ['status'=>'success', 'message'=>'Berhasil menambah data']);
				redirect($this->module_url);
				break;
			case 'edit':
				$post['category_url'] = url_title($post['category_title'], '-', true);
				$this->db->update($this->table, $post, [$this->primary_id=>$id]);
				$this->session->set_flashdata('alert', ['status'=>'success', 'message'=>'Berhasil mengubah data']);
				redirect($this->module_url);
				break;
			case 'remove':
				$this->db->delete($this->table, [$this->primary_id=>$id]);
				$this->session->set_flashdata('alert', ['status'=>'success', 'message'=>'Berhasil menghapus data']);
				redirect($this->module_url);
				break;
			default:
				# code...
				break;
		}
	}
	function get_row()
	{
		header('Content-Type:application/json');
		$id = $this->input->get('id');
		$d = $this->db->get_where($this->table, [$this->primary_id=>$id])->row();
		echo json_encode($d, JSON_PRETTY_PRINT);
	}
}