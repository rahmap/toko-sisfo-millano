<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home_Model extends CI_Model
{

    public function getProduk($limit, $start)
    {
        $this->db->join('detail_produk', 'detail_produk.id_produk=produk.id_produk');
        $this->db->join('kategori', 'kategori.id_cat=produk.id_cat');
        $this->db->limit($limit, $start);
        $this->db->order_by('produk.id_produk','DESC');
        return $this->db->get_where('produk', ['detail_produk.aktif' => 1])->result_array();
    }

    public function hitungProduk()
    {
        $this->db->from('produk');
        $this->db->join('detail_produk', 'detail_produk.id_produk=produk.id_produk');
        $this->db->where('detail_produk.aktif', 1);
        return $this->db->count_all_results();
    }

    public function getInfoResiByIdTrx($id_trx, $email)
    {
        $this->db->select([
            'data_user.nama',
            'data_user.email',
            'pengiriman.*',
            'orders.nomer_resi',
            'midtrans.transaction_id',
            'orders.id_orders'
        ]);
        $this->db->join('midtrans','orders.id_orders=midtrans.order_id');
        $this->db->join('pengiriman','pengiriman.id_orders=orders.id_orders');
        $this->db->join('data_user','orders.id_user=data_user.id_user');
        $this->db->where('midtrans.transaction_id', $id_trx);
        $this->db->where('data_user.email', $email);
        $this->db->where('pengiriman.notifikasi_email >', time());
        $this->db->where('orders.status_order', 'settlement');
        return $this->db->get('orders')->row_array();
    }

    public function updateKonfirmasi($id, $email)
    {
        $this->db->select(['midtrans.order_id']);
        $this->db->join('pengiriman','pengiriman.id_orders=midtrans.order_id');
        $this->db->join('orders','orders.id_orders=midtrans.order_id');
        $this->db->join('data_user','orders.id_user=data_user.id_user');
        $this->db->where('midtrans.transaction_id', $id);
        $this->db->where('data_user.email', $email);
        $this->db->where('pengiriman.notifikasi_email >', time());
        $this->db->where('orders.status_order', 'settlement');
        if($id_orders = $this->db->get('midtrans')->row_array()){
            $where = [
                'id_orders' => $id_orders['order_id'],
                'status_order'  => 'settlement',
                'tanggal_selesai' => NULL
            ];
            $data = [
                'status_order' => 'Selesai',
                'status_pengiriman' => 'Terkirim',
                'tanggal_selesai' => date('d/m/Y', time())
            ];
            $this->db->update('orders', $data, $where);
            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }

    public function getInfoByToken($token)
    {
        $this->db->select([
            'data_user.nama',
            'data_user.email',
            'user_token.token',
            'user_token.expire_at',
            'data_user.id_user'
        ]);
        $this->db->join('data_user','data_user.id_user=user_token.id_user');
        return $this->db->get_where('user_token',['user_token.token' => $token])->row_array();
    }

    public function aktif_customers($id)
    {
        $this->db->delete('user_token', ['id_user' => $id]); //Hapus token
        $this->db->update('detail_user', ['is_active' => 1, 'delete_at' => NULL], ['id_user' => $id]);
        return $this->db->affected_rows();
    }

}
