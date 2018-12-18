<?php 
	function isOwnerLogin()
	{
		$ci = &get_instance();
		if (!empty($ci->session->owner_islogin) && $ci->session->owner_islogin == true) 
			return true;
		else
			return false;
	}
	function isSellerLogin()
	{
		$ci = &get_instance();
		if (!empty($ci->session->seller) && $ci->session->seller['islogin'] == true) 
			return true;
		else
			return false;
	}
	function getSellerSession()
	{
		if (isSellerLogin()) {
			$ci = &get_instance();
			return (object) $ci->session->seller;
		} else {
			return false;
		}
	}
	function isCustomerLogin()
	{
		$ci = &get_instance();
		if (!empty($ci->session->customer) && $ci->session->customer['islogin'] == true) 
			return true;
		else
			return false;
	}
	function getCustomerSession()
	{
		if (isCustomerLogin()) {
			$ci = &get_instance();
			return (object) $ci->session->customer;
		} else {
			return false;
		}
	}
	function getSource($s='')
	{
		switch ($s) {
			case 'cart':
				return 'store/cart';
			
			default:
				return '';
		}
	}
	function getRandomWord($len = 5) {
	    $word = range('a', 'z');
	    shuffle($word);
	    return substr(implode($word), 0, $len);
	}
	function showAlertSuccess($kata=null){
		if(empty($kata)) $kata = 'Proses berhasil dieksekusi.';
		
		$str = '<div class="alert alert-success alert-dismissible slideup" role="alert">';
		$str .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		$str .= '<strong>Berhasil!</strong> '.$kata.'</div>';
		return $str;
	}
	function showAlertDanger($kata=null){
		if(empty($kata)) $kata = 'Terjadi sesuatu kesalahan silakan coba lagi.';

		$str =  '<div class="alert alert-danger alert-dismissible slideup" role="alert">';
		$str .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		$str .= '<strong>Kesalahan!</strong> '.$kata.'</div>';
		return $str;
	}
	function showAlertInfo($kata=null){
		if(empty($kata)) $kata = 'Info.';

		$str =  '<div class="alert alert-info alert-dismissible slideup" role="alert">';
		$str .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		$str .= '<strong>Info!</strong> '.$kata.'</div>';
		return $str;
	}
	function showAlert($response)
	{
		if(is_array($response)){
			if ($response['status'] == 'success') {
				return showAlertSuccess( (empty($response['message']) ? null : $response['message']) );
			} elseif ($response['status'] == 'info') {
				return showAlertInfo( (empty($response['message']) ? null : $response['message']) );
			} else {
				return showAlertDanger( (empty($response['message']) ? null : $response['message']) );
			}
		} else return null;
	}
	function createPassword($string)
	{
		return password_hash($string, PASSWORD_BCRYPT, ['cost'=>12]);
	}
	function checkPassword($string, $hash)
	{
		return password_verify($string, $hash);
	}
	function private_url($v='')
	{
		return base_url('private').'/'.$v;
	}
	function public_url($v='')
	{
		return base_url('private').'/'.$v;
	}
	function webmin_url($v='')
	{
		return site_url('webmin').'/'.$v;
	}
	function productStatus($s=0)
	{
		switch ($s) {
			case 1:
				return '<span class="text-primary">PUBLISH</span>';
			case 2:
				return '<span class="text-warning">DRAF</span>';
			case 3:
				return '<span class="text-danger">HABIS</span>';
			default:
				return '<span class="text-danger">TIDAK TERSEDIA</span>';
		}
	}
	function gramToKg($gr)
	{
		if ($gr>=1000) {
			return round($gr/1000, 2).'kg';
		} else {
			return $gr.'gr';
		}
	}
	function transactionStatus($code=1)
	{
		switch ($code) {
			case 1:
				return 'Menunggu Pembayaran';
			case 2:
				return 'Dibayar, Menunggu Konfirmasi Penjual';
			case 3:
				return 'Dikonfirmasi Penjual';
			case 4:
				return 'Dikirim';
			case 5:
				return 'Selesai';
			case 6:
				return 'Gagal, tidak dibayar';
			case 7:
				return 'Gagal, tidak dikonfirmasi penjual';
			case 8:
				return 'Gagal, tidak dikirim penjual';
			case 9:
				return 'Dikomplain Pembeli';
			case 10:
				return 'Dana dikembalikan ke saldo';
			default:
				return 'Menunggu Pembayaran';
				break;
		}
	}
	function confirmStatus($code=1)
	{
		switch ($code) {
			case 1:
				return 'Belum Verifikasi';
			case 2:
				return 'Disetujui';
			case 3:
				return 'Ditolak';
			default:
				return 'Belum Verifikasi';
				break;
		}
	}
	function checkStatus($str='')
	{
		if ($str == 1) {
			return 'Aktif';
		} elseif ($str == 0) {
			return 'Nonaktif';
		} else {
			return '-';
		}
	}
 ?>