<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once './application/libraries/Veritrans.php';

class Payment extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        Veritrans_Config::$serverKey = API_MIDTRANS;
				$this->load->model(['Payment_Model','Produk_Model']);
    }

	public function index()
	{
		redirect('payment/checkout');
	}

	public function finish()
	{
		$this->session->unset_userdata(['id_orders','kurir','service','estimasi','alamat_pengiriman',
																		'kode_pos','nama_penerima','no_penerima',
																		'berat', 'total_ongkir','totalBayar','triggerCheckout']);
		$this->cart->destroy();
		$this->freeM->getSweetAlert('infoPayment', 'Success!', 'Pemesanan berhasil di lakukan!', 'success');
		redirect('home');
	}

	public function unfinish()
	{
		$this->session->unset_userdata(['id_orders','kurir','service','estimasi','alamat_pengiriman',
																		'kode_pos','nama_penerima','no_penerima',
																		'berat', 'total_ongkir','totalBayar','triggerCheckout']);
		$this->cart->destroy();
		$this->freeM->getSweetAlert('infoPayment', 'Upss!', 'Pemesanan gagal di lakukan!', 'error');
		redirect('home');
	}

	public function checkout()
	{
		if($this->session->totalBayar == 0 or !$this->session->has_userdata('triggerCheckout')){
			redirect('/');
		}
		$transaction_details = array(
			'order_id' 			=> 'Sisfo-'.uniqid(),
			'gross_amount' 	=> $this->session->totalBayar
		);

		// Populate items
		$i=0;
		foreach($this->cart->contents() as $key => $val):
			$items[$i] = [
					'id' 				=> $val['id'],
					'price' 		=> $val['price'],
					'quantity' 	=> $val['qty'],
					'name' 			=> $val['name'].'('.strtoupper($val['ukuran'].')')
			];
			$i++;
		endforeach;
		$ongkir = [
				'id'				=> 'ongkir',
				'price' 		=> $this->session->total_ongkir,
				'quantity' 	=> 1,
				'name' 			=> 'Biaya Pengiriman'
		];
		array_push($items,$ongkir); //Menambahkan list ongkir ke midtrans


		// echo '<pre>';
    // var_dump($items);
		// echo '</pre>';
		// die;

		$newPenerima = explode(' ',$this->session->nama_penerima);
		// Populate customer's billing address
		$billing_address = array(
			'first_name' 			=> $newPenerima[0],
			'last_name' 			=> (!isset($newPenerima[1]))? '' : $newPenerima[1],
			'address' 				=> $this->session->alamat_pengiriman,
			'city' 						=> $this->session->kota_tujuan,
			'postal_code' 		=> $this->session->kode_pos,
			'phone' 					=> $this->session->no_penerima,
			'country_code'		=> 'IDN'
			);

		// Populate customer's shipping address
		$newPenerima = explode(' ',$this->session->nama_penerima);
		$shipping_address = array(
			'first_name' 			=> $newPenerima[0],
			'last_name' 			=> (!isset($newPenerima[1]))? '' : $newPenerima[1],
			'address' 				=> $this->session->alamat_pengiriman,
			'city' 						=> $this->session->kota_tujuan,
			'postal_code' 		=> $this->session->kode_pos,
			'phone' 					=> $this->session->no_penerima,
			'country_code'		=> 'IDN'
			);

		// Populate customer's Info
		$newNama = explode(' ',$this->session->nama);
		$customer_details = array(
			'first_name' 			=> $newNama[0],
			'last_name' 			=> (!isset($newNama[1]))? '' : $newNama[1],
			'email' 					=> $this->session->email,
			'phone' 					=> $this->session->no_penerima,
			'billing_address' => $billing_address,
			'shipping_address'=> $shipping_address
			);

		// Data yang akan dikirim untuk request redirect_url.
		// Uncomment 'credit_card_3d_secure' => true jika transaksi ingin diproses dengan 3DSecure.
		$transaction_data = array(
      'enabled_payments' 	=> ['permata_va',
				'bca_va', 'bni_va', 'echannel'],
			'transaction_details'=> $transaction_details,
			'item_details' 			 => $items,
			'customer_details' 	 => $customer_details
		);

		try
		{
      $paymentUrl = Veritrans_Snap::createTransaction($transaction_data)->redirect_url;
			$this->Payment_Model->insertDataOrders($transaction_details['order_id']); //insert data ke DB (Orders)

      header('Location: ' . $paymentUrl);
		} 
		catch (Exception $e) 
		{
    		echo $e->getMessage();	
		}
		
	}

	public function handling() //Webhook untuk menangkap respon dari Midtrans
  {

    $obj = file_get_contents('php://input');
		$midtrans = json_decode($obj, true);
		if($midtrans == null){ //Pengecekan
			die('jnck');
		} else  {
			if($midtrans['merchant_id'] != MARCHANT_ID){
				die('wtf');
			}
		}

		$this->Payment_Model->insertDataMidtrans($midtrans); //Olah data respon dari midtrans

    $this->output
      ->set_status_header(201)
      ->set_content_type('application/json', 'utf-8')
      ->set_output(json_encode($midtrans, JSON_PRETTY_PRINT))
      ->_display();
      exit;
  }
}
