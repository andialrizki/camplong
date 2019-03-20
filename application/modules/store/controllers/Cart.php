<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * class ini untuk proses transaksi (belanja) oleh pembeli
 */
class Cart extends CI_Controller
{
	/**
	 * [$rj_type adalah tipe paket API RajaOngkir]
	 * @var [type]
	 */
	private $rj_type;
	function __construct()
	{
		parent::__construct();
        $this->load->config('rajaongkir', TRUE);
        $this->rj_type = $this->config->item('rajaongkir_account_type', 'rajaongkir');
	}
	function index()
	{
		$data['alert'] = $this->session->alert;
		$data['data'] = $this->getCart();
		$this->load->view('view_cart', $data);
	}
	/**
	 * [getCart mengambil data cart (session) lalu diolah dan dikelompokkan berdasarkan penjual, jika pembeli belanja lebih dari 1 penjual]
	 * @return [type] [description]
	 */
	private function getCart()
	{
		$cart = $this->cart->contents();
		$seller = [];
		foreach ($cart as $d) {
			$seller[$d['seller_id']] = [
				'seller_id'=>$d['seller_id'], 
				'seller_name'=>$d['seller_name'], 
				'seller_city_id'=>$d['seller_city_id'],
				'seller_subdistrict_id'=>$d['seller_subdistrict_id'],
				'cart' => []
			];
		}
		foreach ($cart as $d) {
			array_push($seller[$d['seller_id']]['cart'], $d);
		}
		return $seller;
	}
	/**
	 * [resume untuk proses selanjutnya setelah menambahkan barang ke cart (keranjang), dilakukan pengecekan apakah barang stoknya masih adaa apa sudah habis
	 * jika sudah habis maka tidak bisa lanjut, pembeli harus menghapus produk tsb di cart (keranjang)nya terlebih dahulu.]
	 * @return [type] [description]
	 */
	function resume()
	{
		$dt = $this->cart->contents();
		$ready = true;
		$prodOutOfStock = [];
		foreach ($dt as $d) {
			if($this->cart->has_options($d['rowid'])){
				$opt = $this->cart->product_options($d['rowid']);
				$cek = $this->db->select('product_status, product_stock, product_title')->get_where('product', ['product_id'=>$opt['prod_id']])->row();
				if ($cek->product_stock == 0 || $cek->product_status != 1) {
					$prodOutOfStock[] = $cek->product_title;
					$ready = false;
				}
			}
		}
		if ($ready) {
			/**
			 * jika yang order pelanggan sudah login maka lanjut ke checkout, jika belum tampilkan halaman resume (ringkasan order,selanjutnya diarahkan
			 * untuk daftar (membuat akun) atau login)
			 */
			if(isCustomerLogin())
				redirect('store/cart/checkout');
			else
				$this->load->view('view_resume');
		} else {
			$this->session->set_flashdata('alert', ['status'=>'info', 'message'=> 'Produk: <b>'.implode(', ', $prodOutOfStock).'</b> <b>"HABIS"</b>, Anda harus menghapus produk ini dari keranjang jika ingin melanjutkan.']);
			redirect('store/cart');
		}

	}
	/**
	 * [checkout adalah halaman checkout order]
	 * @return [type] [description]
	 */
	function checkout()
	{
		if (isCustomerLogin()) {
			$cust = getCustomerSession();
			$data['cust'] = $this->db->get_where('customer', ['customer_id'=>$cust->id])->row();
			$data['alert'] = $this->session->alert;
			$data['data'] = $this->getCart();
			$data['prov']	 = $this->db->get('province')->result();
			$data['rj_type'] = $this->rj_type;
			$this->load->view("view_checkout", $data);
		} else {
			$this->session->set_flashdata('alert', ['status'=>'info','message'=>'Untuk melanjutkan pembayaran belanja Anda harus masuk terlebih dahulu']);
			redirect('customer/signin?source=cart');
		}
	}
	/**
	 * proses checkout 
	 * @return [type] [description]
	 */
	function checkout_process()
	{
		$data = $this->input->post('post'); //ambil data dari array post
		$seller = $this->input->post('seller'); //id penjual (array) 
		$courier_code = $this->input->post('courier_code'); //kode jasa pengiriman,JNE,JNT,POS,dll
		$courier_cost = $this->input->post('courier_cost'); //ongkir
		$courier_service = $this->input->post('courier_service'); //layanan jasa pengiriman, contoh: JNE REGULER, POS KILAT
		$cr = $this->getCart(); // ambil data dari cart (session) yang sudah dikelompokkan berdasarkan penjual
		$cust = getCustomerSession();
		$index = 0;
		$code = "";
		foreach ($cr as $d) {
			$code = "CPG-".strtoupper(uniqid());
			$data['transaction_code'] = $code; // buat nomor transaksi
			$data['transaction_datetime'] = date('Y-m-d H:i:s');
			$data['transaction_seller_id']	= $d['seller_id'];
			$data['transaction_customer_id'] = $cust->id;

			$data['transaction_courier'] = $courier_code[$index];
			$data['transaction_courier_cost'] = $courier_cost[$index];
			$data['transaction_courier_service'] = $courier_service[$index];

			$data['transaction_status'] = 1;
			// ambil dari keranjang
			$tot_weight = 0;
			$prod_val = 0;
			foreach ($d['cart'] as $cart) {
				$opt = $this->cart->product_options($cart['rowid']);
				$prod_val += $cart['price']; // jumlahkan harga produk (menjadi nilai produk, diluar ongkir)
				$tot_weight += ($opt['weight']*$cart['qty']); // jumlahkan berat, qty (kuantiti) juga dihitung
			}
			$data['transaction_product_value'] = $prod_val; //nilai produk,diluar ongkir
			$data['transaction_weight'] = $tot_weight; 
			$data['transaction_total_pay'] = $prod_val + $courier_cost[$index]; //total yg harus dibayar (hrg total produk + ongkir)
			$this->db->insert('transaction', $data);
			
			/**
			 * tabel pembantu, transaction_product
			 */
			foreach ($d['cart'] as $cart) {
				$opt = $this->cart->product_options($cart['rowid']);
				$prod['transprod_product_id'] = $cart['id'];
				$prod['transprod_price'] = $cart['price'];
				$prod['transprod_qty'] = $cart['qty'];
				$prod['transprod_weight'] = $opt['weight'];
				$prod['transprod_transaction_id'] = $this->db->insert_id();
				$this->db->insert('transaction_product', $prod);
			}
			$index++;
		}
		sleep(0.5);
		$this->cart->destroy();
		/**
		 * [$index, jika penjual hanya 1, arahkan ke detail order produk tersebut, jika lebih dari 1 penjual arahkan ke halaman order untuk selanjutnya tata cara pembayarannya]
		 * @var [type]
		 */
		if($index == 1)
			redirect('store/cart/payment/'.$code);
		else
			redirect('store/cart/payment');
	}
	/**
	 * [payment method ini untuk detail pembayaran yang harus dibayarkan oleh pembeli]
	 * @param  string $code [nomor transaksi]
	 * @return [type]       [description]
	 */
	function payment($code = '')
	{
		$cust = getCustomerSession();
		$action = $this->input->get('action');
		$data['alert'] = $this->session->alert;
		$cek = $this->db
			->select('transaction.*, seller_name')
			->join('seller', 'seller_id = transaction_seller_id')
			->get_where('transaction', ['transaction_code'=>$code, 'transaction_customer_id'=>$cust->id]);
		if (!empty($code) && $cek->num_rows() > 0) {
			if ($action == "confirm") {
				$this->payment_confirm($code, $cek->row()->transaction_id);
				exit;
			}
			$data['data'] = $cek->row();
			$data['prod'] = $this->db
				->join('product', 'product_id = transprod_product_id')
				->get_where('transaction_product', ['transprod_transaction_id'=>$cek->row()->transaction_id])->result();
			$data['bank'] = $this->db->get('owner_bank')->result();
			$data['conf'] = $this->db->get_where('transaction_confirm', ['transconf_transaction_id'=>$cek->row()->transaction_id]);
			$this->load->view('view_payment_detail', $data);
		} else {
			$data['data'] = $this->db
				->select('seller_name, transaction_code, transaction_id, transaction_status')
				->join('seller', 'seller_id = transaction_seller_id')
				->get_where('transaction', ['transaction_customer_id'=>$cust->id])->result();
			$this->load->view('view_payment', $data);
		}
	}
	/**
	 * [payment_confirm method ini untuk memproses konfirmasi jika telah dilakukan pembayaran oleh pembeli]
	 * @param  [type] $code [nomor transaksi]
	 * @param  [type] $tid  [id transaksi (dari database)]
	 * @return [type]       [description]
	 */
	private function payment_confirm($code, $tid)
	{
		$data = $this->input->post('dt');
		$data['transconf_transaction_id'] = $tid;
		if(!empty($_FILES['file']['name'])){
			$config['upload_path'] 		= './public/customer/buktitransfer/';
			$config['allowed_types'] 	= 'jpg|png|gif|jpeg';
			$config['max_size']			= '2000';
			$config['file_name']		= 'CONFIRM-'.$code;
			$config['overwrite']		= TRUE;

			$this->load->library('upload', $config);
			if ($this->upload->do_upload('file')){
				$upload_data = $this->upload->data();
				$data['transconf_file'] = $upload_data['file_name'];
				$cek = $this->db->get_where('transaction_confirm', ['transconf_transaction_id'=>$tid])->num_rows();
				if($cek == 0){
					$this->db->update('transaction', ['transaction_status'=>2], ['transaction_id'=>$tid]);
					$data['transconf_status'] = 1;
					$this->db->insert('transaction_confirm', $data);
				}
				else
					$this->db->update('transaction_confirm', $data, ['transconf_transaction_id'=>$tid]);
				$this->session->set_flashdata('alert', 
					['status'=>'success', 'message' => 'Konfirmasi pembayaran telah kami terima, silahkan tunggu verifikasi']);
				redirect('store/cart/payment/'.$code);

			} else {
				$this->session->set_flashdata('alert', ['status'=>'error', 'message' => 'Gagal upload bukti transfer ['.$this->upload->display_errors().']']);
				redirect('store/cart/payment/'.$code);
			}
		} else {
			$cek = $this->db->get_where('transaction_confirm', ['transconf_transaction_id'=>$tid]);
			if($cek->num_rows() > 0 && !empty($cek->row()->transconf_file)){
				$this->db->update('transaction_confirm', $data, ['transconf_transaction_id'=>$tid]);
				$this->session->set_flashdata('alert', 
					['status'=>'success', 'message' => 'Data pada Konfirmasi pembayaran telah diubah']);
				
			} else {
				$this->session->set_flashdata('alert', ['status'=>'error', 'message' => 'Anda harus upload bukti transfer']);
			}
			redirect('store/cart/payment/'.$code);
		}
	}
	/**
	 * [add_to_cart, method ini untuk menyimpan sementara produk yang ditambahkan pembeli ke cart (keranjang), menggunakan library cart bawaan codeigniter menggunakan session]
	 */
	function add_to_cart()
	{
		header('Content-Type:application/json');
		$prod = $this->input->get('prod');
		$qty = $this->input->get('qty');
		$cek = $this->db
			->join('seller', 'seller_id = product_seller_id')
			->get_where('product', ['product_status'=>1, 'product_url'=>$prod]);
		if ($cek->num_rows() > 0) {
			$dt = $cek->row();
			$data = array(
		        'id'      => $dt->product_id,
		        'qty'     => $qty,
		        'price'   => $dt->product_price,
		        'name'    => $dt->product_title,
		        'seller_id' => $dt->seller_id,
		        'seller_name' => $dt->seller_name,
		        'seller_city_id'=>$dt->seller_city_id,
		        'seller_subdistrict_id'=>$dt->seller_subdistrict_id,
		        'options' => array('url' => $dt->product_url, 'weight' => $dt->product_weight, 'picture' => $dt->product_picture, 'prod_id'=>$dt->product_id)
			);
			$this->cart->insert($data);
			echo json_encode(['status'=>'success', 'message'=>'Produk ditambahkan ke keranjang']);
		} else {
			echo json_encode(['status'=>'error', 'message' => 'Product not found.']);
		}
	}
	/**
	 * [update_item method ini untuk update item cart]
	 * @param  string $id [id cart]
	 * @return [type]     [description]
	 */
	function update_item($id='')
	{
		$item = $this->cart->get_item($id);
		if ($item) {
			if($this->cart->has_options($id)){
				$opt = $this->cart->product_options($id);
				$cek = $this->db->select('product_stock, product_title')->get_where('product', ['product_id'=>$opt['prod_id']])->row();
				$qty = $this->input->post('qty');
				if ($cek->product_stock == 0) {
					$msg = 'Stok Produk: <b>'.$cek->product_title.'</b> <b>"HABIS"</b>, Anda harus menghapus produk ini dari keranjang jika ingin melanjutkan.';
				} else if ($qty > $cek->product_stock) {
					$qty = $cek->product_stock;
					$msg = 'Produk: <b>'.$cek->product_title.'</b> hanya memiliki stok sebanyak <b>'.$cek->product_stock.'</b>';
					$data = array(
			        	'rowid' => $id,
				        'qty'   => $qty
					);
					$this->cart->update($data);
				} else {
					$data = array(
			        	'rowid' => $id,
				        'qty'   => $qty
					);
					$this->cart->update($data);
					$msg = 'Berhasil mengubah qty pada produk: <b>'.$cek->product_title.'</b>';
				}
				$this->session->set_flashdata('alert', ['status'=>'info', 'message'=>$msg]);
			}
		}
		redirect('store/cart');
	}
	function remove_from_cart($id='')
	{
		$this->cart->remove($id);
		redirect('store/cart');
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
	/**
	 * [get_cost method ini untuk mengecek ongkos kirim yang menggunakan API RajaOngkir]
	 * @return [type] [description]
	 */
	function get_cost()
	{
		header('Content-Type:application/json');
		$sel = $this->input->post('sel_id');
		$weight = $this->input->post('weight');
		$dest = $this->input->post('dest');
		$cek = $this->db
			->get_where('seller', ['seller_id'=>$sel]);
		if ($cek->num_rows() > 0) {
			$dt = $cek->row();
			$this->load->library('rajaongkir');
			if($this->rj_type == "pro")
				$courier = 'jnt:jne:pos:tiki';
			else
				$courier = 'jne:pos:tiki';
			echo $this->rajaongkir->cost($dt->seller_city_id, $dest, $weight, $courier, $this->rj_type);
		} else {
			echo json_encode(['status'=>'error', 'message'=>'produk tidak ditemukan']);
		}
	}
}
 ?>