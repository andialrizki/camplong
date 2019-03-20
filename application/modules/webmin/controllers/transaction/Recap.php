<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * class ini untuk menampilkan rekap transaksi
 */
Class Recap extends CI_Controller {
	protected $table = "transaction";
	protected $primary_id = "transaction_id";
	protected $module_url = "webmin/transaction/recap";
	function __construct()
	{
		parent::__construct();
		if (!isOwnerLogin()) {
			redirect('webmin/auth');
		}
	}
	function index()
	{
		$data['alert'] = $this->session->alert;
		$filter = $this->input->get('filter');
		$data['filter'] = ['all'=>'Semua', 2=>'Belum Dikonfirmasi Penjual', 4=>'Dikirim', 5=>'Selesai'];
		$data['filter_selected'] = $filter;
		if(empty($filter) || $filter == 'all'){
			$data['data'] = $this->db
				->join('customer', 'customer_id = transaction_customer_id')
				->join('seller', 'seller_id = transaction_seller_id')
				->get($this->table)->result();
		} else {
			$data['data'] = $this->db
				->join('customer', 'customer_id = transaction_customer_id')
				->join('seller', 'seller_id = transaction_seller_id')
				->get_where($this->table, ['transaction_status'=>$filter])->result();
		}
		$this->load->view('transaction/view_recap', $data);
	}
	function xls()
	{
		$filename = 'Rekap-Pesanan-di-sistem-camplong-'.date('d-m-y-H-i-s');
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$filename.xls");
		header('Content-Transfer-Encoding: binary');
		ob_clean(); flush();

		$filter = $this->input->get('filter');
		$data['filter'] = ['all'=>'Semua', 2=>'Belum Dikonfirmasi Penjual', 4=>'Dikirim', 5=>'Selesai'];
		$data['filter_selected'] = $filter;
		if(empty($filter) || $filter == 'all'){
			$data['data'] = $this->db
				->join('customer', 'customer_id = transaction_customer_id')
				->join('seller', 'seller_id = transaction_seller_id')
				->join('transaction_confirm', 'transaction_id = transconf_transaction_id')
				->get($this->table)->result();
		} else {
			$data['data'] = $this->db
				->join('customer', 'customer_id = transaction_customer_id')
				->join('seller', 'seller_id = transaction_seller_id')
				->join('transaction_confirm', 'transaction_id = transconf_transaction_id')
				->get_where($this->table, ['transaction_status'=>$filter])->result();
		}
		$this->load->view('transaction/xls_recap', $data);
	}

}