<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment_Model extends CI_Model
{

  public function insertDataOrders($midtransOrderId)
  {
    $this->load->model('Produk_Model');
    $this->db->trans_begin();

    $id_orders = $midtransOrderId;

    $order = [
      'id_orders' => $midtransOrderId,
      'id_user' => $this->session->id_user,
      'status_order' => NULL,
      'total_harga_barang' => $this->session->totalBayar - $this->session->total_ongkir,
      'tanggal_order' => time(),
      'keterangan' => 'Menunggu Pembayaran'
    ]; // set data orders
		 
    $this->db->insert('orders', $order);  //Insert to Orders
    // $id_orders = $this->db->insert_id();  Jika pakai AI
    
		$ongkir = [ //Data pengiriman
      'kurir' => $this->session->kurir,
      'service' => $this->session->service,
      'estimasi' => $this->session->estimasi,
      'alamat_pengiriman' => $this->session->alamat_pengiriman,
      'kode_pos' => $this->session->kode_pos,
      'nama_penerima' => $this->session->nama_penerima,
      'no_penerima' => $this->session->no_penerima,
      'berat' => $this->session->berat,
      'total_ongkir' => $this->session->total_ongkir
    ];
    $ongkir['id_orders'] = $id_orders;
    $this->db->insert('pengiriman', $ongkir);  //Insert to Pengiriman

    foreach($this->cart->contents() as $items){
      foreach($this->Produk_Model->getIdByUnik($items['unik_produk']) as $id){
        $id_produk = $id;
      }
      $orders_produk = [
        'id_orders' => $id_orders,
        'id_produk' => $id_produk,
        'ukuran_orders' => $items['ukuran'],
        'qty' => $items['qty'],
        'diskon_orders' => $items['diskon'],
        'harga_orders' => $items['price'],
        'nama_orders' => $items['name']
      ];
      $this->db->where(['id_produk' => $id_produk]);
      $this->db->set('stok', 'stok - '.$items['qty'], FALSE);
      $this->db->update('detail_produk'); //Update stok 
      $this->db->insert('orders_produk', $orders_produk);  //Insert to Orders_Produk
    }

    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        return 0;
    } else {
        $this->db->trans_commit();
        return 1;
    }
  }

  public function getInfoOrderId($id){
    $this->db->where(['order_id' => $id]);
    return $this->db->count_all_results('midtrans');
  }

  public function insertDataMidtrans($data)
  {
    if($this->getInfoOrderId($data['order_id']) == 0){  //Cek data sudah ada atau belum, jika sudah Update, jika belum Insert
      if(isset($data['permata_va_number'])){
        $bank = 'permata';
        $va_number = $data['permata_va_number'];
      } else if(isset($data['va_numbers'])){
        foreach ($data['va_numbers'] as $va => $val) {
          $va_number = $val['va_number'];
          $bank = $val['bank'];
        }
      } else {
        if(isset($data['biller_code']) AND isset($data['bill_key'])){
          $va_number = $data['bill_key'];
          if($data['biller_code'] == '70012'){
            $bank = 'mandiri-'.'kode bank-'.$data['biller_code'];
          } else {
            $bank = $data['biller_code'];
          }
        } else {
          $va_number = NULL;
          $bank = NULL;
        }
      }

      if($data['payment_type'] == 'gopay'){
        $bank = 'Gopay';
      } else if($data['payment_type'] == 'cstore'){
        if($data['store'] == 'indomaret'){
          $bank = 'Indomaret';
          $va_number = $data['payment_code'];
        } else if($data['store'] == 'alfamart'){
          $bank = 'Alfamart';
          $va_number = $data['payment_code'];
        }
      }
  
      if(isset($data['settlement_time'])){  //Set settlement_time
        $settlement_time = $data['settlement_time'];
      } else {
        $settlement_time = null;
      }
      
      $midtrans = [
        'transaction_id' => $data['transaction_id'],
        'status_message' => $data['status_message'],
        'va_number' => $va_number,
        'bank' => $bank,
        'payment_type' => $data['payment_type'],
        'order_id' => $data['order_id'],
        'gross_amount' => $data['gross_amount'],
        'transaction_time' => $data['transaction_time'],
        'transaction_status' => $data['transaction_status'],
        'settlement_time' => $settlement_time
      ];
      $this->db->insert('midtrans', $midtrans);
      $this->db->update('orders', ['status_order' => 'pending'], ['id_orders' => $data['order_id']]);
    } else {
      if($data['transaction_status'] == 'expire'){
        $midtrans = [
          'transaction_status' => $data['transaction_status']
        ];
      } else {
        $sett_time = (!isset($data['settlement_time']))? date("Y-m-d H:i:s") : $data['settlement_time'] ;
        $midtrans = [
          'transaction_status' => $data['transaction_status'],
          'settlement_time' => $sett_time
        ];
      }

      if(($data['transaction_status']) == 'settlement'){
        $ketOrders = 'Pembayaran Berhasil Dilakukan';
      } else if(($data['transaction_status']) == 'expire'){
        $ketOrders = 'Pembayaran Gagal Dilakukan';
        foreach($this->db->get_where('orders_produk',['id_orders' => $data['order_id']])->result_array() as $row){
          $this->db->where(['id_produk' => $row['id_produk']]);
          $this->db->set('stok', 'stok + '.$row['qty'], FALSE);
          $this->db->update('detail_produk'); //Update stok 
        }

      } else {
        $ketOrders = 'Menunggu Pembayaran';
      }
      $updateOrders = [
        'status_order' => $data['transaction_status'],
        'keterangan' => $ketOrders
      ];
      $this->db->update('orders', $updateOrders, ['id_orders' => $data['order_id']]);
      $this->db->update('midtrans', $midtrans, ['order_id' => $data['order_id']]);
    }
  }
}
