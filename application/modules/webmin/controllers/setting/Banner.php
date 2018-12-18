<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
Class Banner extends CI_Controller {
	protected $table = "banner";
	protected $primary_id = "banner_id";
	protected $module_url = "webmin/setting/banner";
	function __construct()
	{
		parent::__construct();
		if (!isOwnerLogin()) {
			redirect('webmin/auth');
		}
	}

	function index()
	{
		$action = $this->input->get('action');
		$id = $this->input->get('id');
		if ($action == 'save') {
			$data = $this->input->post('post');


			$config['upload_path'] 		= './public/img/banner/';
			$config['allowed_types'] 	= 'jpg|png|gif|jpeg';
			$config['max_size']			= '2000';

			$this->load->library('upload', $config);
			if ($this->upload->do_upload('image')){
				$upload_data = $this->upload->data();
				// load libs
				
				$v2 = $this->load->library('imageresize', array('filename' => $config['upload_path'].$upload_data['file_name']));
				$v2->imageresize->resize(1440, 700, $allow_enlarge = True);
				$newname = 'resize-'.$upload_data['file_name'];
				$v2->imageresize->save($config['upload_path'].$newname);

				$data['banner_file'] = $newname;
			}
			
			$act = false;
			if(empty($id))
				$act = $this->db->insert('banner', $data);
			else
				$act = $this->db->update('banner', $data, array('banner_id' => $id));
			if($act)
				$this->session->set_flashdata('alert', 'success');
			else
				$this->session->set_flashdata('alert', 'danger');

			redirect($this->module_url);
			exit;
		}
		$data = array('data' => $this->db->order_by('banner_id', 'desc')->get('banner'), 
			'alert' => $this->session->alert);
		$data['url']	= $this->module_url;
		$this->load->view('setting/view_banner', $data);
	}
	function remove($id)
	{
		$this->db->delete('banner', array('banner_id' => $id));
		redirect($this->module_url);
	}
	function get_row()
	{
		header('Content-Type:application/json');
		$id = $this->input->get('id');
		$d = $this->db->get_where($this->table, [$this->primary_id=>$id])->row();
		echo json_encode($d, JSON_PRETTY_PRINT);
	}
}
