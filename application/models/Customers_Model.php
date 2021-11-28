<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customers_Model extends CI_Model
{

  public function data_orders($status, $resi = '=')
  {
    $this->db->select([
      'detail_produk.diskon',
      'orders_produk.*',
      'orders.*',
      'data_user.*',
      'produk.*',
      'midtrans.*',
      'pengiriman.*',
    ]);
    $this->db->join('midtrans','orders.id_orders=midtrans.order_id');
    $this->db->join('pengiriman','orders.id_orders=pengiriman.id_orders');
    $this->db->join('orders_produk','orders.id_orders=orders_produk.id_orders');
    $this->db->join('produk','produk.id_produk=orders_produk.id_produk');
    $this->db->join('detail_produk','produk.id_produk=detail_produk.id_produk');
    $this->db->join('data_user','orders.id_user=data_user.id_user');
    $this->db->where('orders.status_order', $status);
    $this->db->where('orders.id_user', $this->session->id_user);
    $this->db->where('orders.nomer_resi'.$resi, null);
    $this->db->group_by('orders.id_orders'); 
    $this->db->order_by('orders.tanggal_order','DESC');
    return $this->db->get('orders')->result_array();
  }

  public function data_pengiriman($status, $setP)
  {
    $this->db->select([
      'detail_produk.diskon',
      'orders_produk.*',
      'orders.*',
      'data_user.*',
      'produk.*',
      'midtrans.*',
      'pengiriman.*',
    ]);
    $this->db->join('midtrans','orders.id_orders=midtrans.order_id');
    $this->db->join('pengiriman','orders.id_orders=pengiriman.id_orders');
    $this->db->join('orders_produk','orders.id_orders=orders_produk.id_orders');
    $this->db->join('produk','produk.id_produk=orders_produk.id_produk');
    $this->db->join('detail_produk','produk.id_produk=detail_produk.id_produk');
    $this->db->join('data_user','orders.id_user=data_user.id_user');
    $this->db->where('orders.status_order', $status);
    $this->db->where('orders.id_user', $this->session->id_user);
    $this->db->where('orders.status_pengiriman', $setP);
    $this->db->group_by('orders.id_orders'); 
    $this->db->order_by('orders.tanggal_order','DESC');
    return $this->db->get('orders')->result_array();
  }

  public function konfirmasi($id)
  {
    $this->db->update(
      'orders', 
      [
        'status_pengiriman' => 'Terkirim',
        'status_order' => 'Selesai',
        'tanggal_selesai' => date('d/m/Y', time())
      ], 
      ['orders.id_orders' => $id]
    );
    return $this->db->affected_rows();
  }

  public function updateProfile($data, $dataFoto = null)
  {
    // var_dump($dataFoto);
    // die();
    $dataDiri = [
      'nama' => $data['nama'],
      'email' => $data['email']
    ];
    
    $this->db->update('data_user', $dataDiri, ['id_user' => $this->session->id_user]);
    if($dataFoto != null){
      $foto['foto'] = $dataFoto;
      $this->db->update('detail_user', $foto, ['id_user' => $this->session->id_user]);
    }
    // die($this->db->last_query());
    if($this->db->affected_rows()){
      $this->session->nama = $data['nama'];
      $this->session->email = $data['email'];
      return 1;
    } else {
      return 0;
    }
  }

  public function updateKeamanan($data)
  {
    $this->db->update('data_user', $data, ['id_user' => $this->session->id_user]);
    return $this->db->affected_rows();
  }

  public function getCountPemesanan()
  {
    $this->db->select([
      'COUNT(orders.id_orders) as total_order'
    ]);
    $this->db->join('data_user','data_user.id_user=orders.id_user');
    $this->db->where('orders.status_pengiriman', 'Terkirim');
    $this->db->where('data_user.id_user', $this->session->id_user);
    return $this->db->get('orders')->row_array();
  }

  public function getCountBelanja()
  {
    $this->db->select([
      'SUM(midtrans.gross_amount) as total_beli'
    ]);
    $this->db->join('data_user','data_user.id_user=orders.id_user');
    $this->db->join('midtrans','orders.id_orders=midtrans.order_id');
    $this->db->where('orders.status_pengiriman', 'Terkirim');
    $this->db->where('data_user.id_user', $this->session->id_user);
    return $this->db->get('orders')->row_array();
  }

  public function getCountItem()
  {
    $this->db->select([
      'SUM(orders_produk.qty) as total_item'
    ]);
    $this->db->join('data_user','data_user.id_user=orders.id_user');
    $this->db->join('orders_produk','orders_produk.id_orders=orders.id_orders');
    $this->db->where('orders.status_pengiriman', 'Terkirim');
    $this->db->where('data_user.id_user', $this->session->id_user);
    return $this->db->get('orders')->row_array();
  }

  public function getCountOrders($status, $sPengiriman = null, $resi = null)
  {
    if($resi == null){
      $this->db->where('orders.nomer_resi', NULL);
    }
    $this->db->where('orders.status_pengiriman', $sPengiriman);
    $this->db->where('orders.status_order', $status);
    $this->db->where('orders.id_user', $this->session->id_user);
    return $this->db->count_all_results('orders');
  }

  public function getDataChartPemesanan()
  {
    $this->db->select([
        'orders.tanggal_selesai',
        'COUNT(orders.id_orders) as jumlah_beli',
    ]);
    $this->db->join('midtrans','orders.id_orders=midtrans.order_id');
    $this->db->where('orders.status_pengiriman', 'Terkirim');
    $this->db->where('orders.id_user', $this->session->id_user);
    $start = (new DateTime('-10 days'))->format('Y-m-d');
    $this->db->where('orders.tanggal_order BETWEEN "'. strtotime($start). '" and "'. time().'"');
    $this->db->group_by('orders.tanggal_selesai'); 
    $this->db->order_by('orders.tanggal_selesai','ASC');
    return $this->db->get('orders')->result_array();
  }

  public function getDataChartPenjualan()
  {
    $this->db->select([
        'orders.tanggal_selesai',
        'SUM(midtrans.gross_amount) as jumlah_pendapatan'
    ]);
    $this->db->join('midtrans','orders.id_orders=midtrans.order_id');
    $this->db->where('orders.status_pengiriman', 'Terkirim');
    $this->db->where('orders.id_user', $this->session->id_user);
    $start = (new DateTime('-10 days'))->format('Y-m-d');
    $this->db->where('orders.tanggal_order BETWEEN "'. strtotime($start). '" and "'. time().'"');
    $this->db->group_by('orders.tanggal_selesai'); 
    $this->db->order_by('orders.tanggal_selesai','ASC');
    return $this->db->get('orders')->result_array();
  }

  public function getOrderItem($id)
  {
    $this->db->select([
      'GROUP_CONCAT(orders_produk.nama_orders) as all_nama',
      'GROUP_CONCAT(orders_produk.harga_orders) as each_harga',
      'GROUP_CONCAT(orders_produk.diskon_orders) as each_diskon',
      'GROUP_CONCAT(orders_produk.qty) as each_qty',
      'GROUP_CONCAT(orders_produk.ukuran_orders) as each_ukuran'
    ]);
    $this->db->join('orders_produk','orders.id_orders=orders_produk.id_orders');
    $this->db->join('produk','produk.id_produk=orders_produk.id_produk');
    $this->db->join('detail_produk','produk.id_produk=detail_produk.id_produk');
    $this->db->join('data_user','orders.id_user=data_user.id_user');
    $this->db->where('orders.id_orders', $id);
    $this->db->where('orders.id_user', $this->session->id_user);
    $this->db->group_by('orders.id_orders'); 
    $this->db->order_by('orders.tanggal_order','DESC');
    return $this->db->get('orders')->result_array();
  }

  public function cekInvoice($id)
  {
    $this->db->where('orders.id_orders', $id);
    $this->db->where('orders.id_user', $this->session->id_user);
    return $this->db->count_all_results('orders');
  }

  public function getInfoInvoice($id)
  {
    $this->db->select([
      'detail_produk.diskon',
      'orders_produk.*',
      'orders.*',
      'data_user.*',
      'produk.*',
      'midtrans.*',
      'pengiriman.*',
      'GROUP_CONCAT(orders_produk.nama_orders) as all_nama',
      'GROUP_CONCAT(orders_produk.harga_orders) as each_harga',
      'GROUP_CONCAT(orders_produk.diskon_orders) as each_diskon',
      'GROUP_CONCAT(orders_produk.qty) as each_qty'
    ]);
    $this->db->join('midtrans','orders.id_orders=midtrans.order_id');
    $this->db->join('pengiriman','orders.id_orders=pengiriman.id_orders');
    $this->db->join('orders_produk','orders.id_orders=orders_produk.id_orders');
    $this->db->join('produk','produk.id_produk=orders_produk.id_produk');
    $this->db->join('detail_produk','produk.id_produk=detail_produk.id_produk');
    $this->db->join('data_user','orders.id_user=data_user.id_user');
    $this->db->where('orders.id_orders', $id);
    $this->db->where('orders.id_user', $this->session->id_user);
    $this->db->group_by('orders.id_orders'); 
    $this->db->order_by('orders.tanggal_order','DESC');
    return $this->db->get('orders')->row_array();
  }

}