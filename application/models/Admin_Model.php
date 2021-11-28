<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_Model extends CI_Model
{
    public function getAllCustomers()
    {
        $this->db->select('detail_user.*, data_user.*, (SUM(pesan_delivered) + SUM(pesan_clicked) + SUM(pesan_opened)) / COUNT(pesan_data_user.fk_user) AS sumScore');
        $this->db->join('detail_user', 'detail_user.id_user=data_user.id_user', 'INNER');
        $this->db->join('pesan_data_user', 'pesan_data_user.fk_user=data_user.id_user', 'LEFT');
        $this->db->where(['detail_user.delete_at' => null]);
        $this->db->group_by('data_user.id_user');
        return $this->db->get_where('data_user', ['data_user.level' => 'Member'])->result_array();
    }

    public function getAllAdmin()
    {
        $this->db->join('detail_user', 'detail_user.id_user=data_user.id_user', 'INNER');
        return $this->db->get_where('data_user', ['data_user.level' => 'Admin'])->result_array();
    }

    public function generateUserToken($id)
    {
        $this->load->helper('string');
        $token = random_string('alnum', 69);
        $this->db->delete('user_token', ['id_user' => $id]); //Hapus token jika sudah ada
        $this->db->insert('user_token', ['id_user' => $id, 'token' => $token, 'expire_at' => time() + (86400)]); //Buat token
        return $this->db->affected_rows();
    }

    public function getInfoUserById($id) //Dengan user_token

    {
        $this->db->select([
            'data_user.nama',
            'data_user.email',
            'user_token.token',
            'user_token.expire_at',
        ]);
        $this->db->join('user_token', 'user_token.id_user=data_user.id_user');
        return $this->db->get_where('data_user', ['data_user.id_user' => $id])->row_array();
    }

    public function getInfoUserByIdWOToken($id) //Tanpa user_token

    {
        $this->db->select([
            'data_user.nama',
            'data_user.email',
        ]);
        return $this->db->get_where('data_user', ['id_user' => $id])->row_array();
    }

    public function deleteCustomers($id)
    {
        // $this->db->delete('data_user', ['id_user' => $id]); //hard delete
        $this->db->delete('user_token', ['id_user' => $id]); //Hapus token jika sudah ada
        $this->db->update('detail_user', ['delete_at' => time(), 'is_active' => 0], ['id_user' => $id]); //soft delete
        return $this->db->affected_rows();
    }

    public function deleteAdmin($id)
    {
        $this->db->delete('data_user', ['id_user' => $id]);
        return $this->db->affected_rows();
    }

    public function nonaktifAdmin($id, $aktif)
    {
        $this->db->update('detail_user', ['is_active' => $aktif], ['id_user' => $id]);
        return $this->db->affected_rows();
    }

    public function nonaktifCustomers($id)
    {
        $this->db->update('detail_user', ['is_active' => 0], ['id_user' => $id]);
        return $this->db->affected_rows();
    }

    public function inputProduct($data, $tags, $detail)
    {
        $this->db->trans_begin();
        $this->db->insert('produk', $data);
        $id_produk = $this->db->insert_id();
        $detail['id_produk'] = $id_produk;
        $this->db->insert('detail_produk', $detail);
        foreach ($tags as $tag) {
            $dataTags = [
                'id_produk' => $id_produk,
                'id_tags' => $tag,
            ];
            $this->db->insert('tags_produk', $dataTags);
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }

    public function deleteProduct($id)
    {
        $this->db->update('produk', ['produk.delete_at' => time()], ['produk.id_produk' => $id]);
        $this->db->update('detail_produk', ['detail_produk.aktif' => 0], ['detail_produk.id_produk' => $id]);
        return $this->db->affected_rows();
    }

    public function statusProduct($id, $status)
    {
        $this->db->where('id_produk', $id);
        $this->db->update('detail_produk', ['aktif' => $status]);
        return $this->db->affected_rows();
    }

    public function getAllProduk()
    {
        $this->db->join('detail_produk', 'detail_produk.id_produk=produk.id_produk', 'INNER');
        $this->db->join('tags_produk', 'tags_produk.id_produk=produk.id_produk', 'INNER');
        $this->db->join('tags', 'tags_produk.id_tags=tags.id_tags', 'INNER');
        $this->db->join('kategori', 'kategori.id_cat=produk.id_cat', 'INNER');
        return $this->db->get_where('produk', ['produk.delete_at' => 0])->result_array();
    }

    public function getCatTag($tabel, $field = array())
    {
        return $this->db->get_where($tabel, $field)->result_array();
    }

    // @begin Tag Produk
    public function getAllTag($status)
    {
        $this->db->where('active', $status);
        return $this->db->get('tags')->result_array();
    }

    public function inputTagProduk($data)
    {
        $this->db->insert('tags', $data);
        return $this->db->affected_rows();
    }

    public function updateStatusTag($id, $status)
    {
        $this->db->where('id_tags', $id);
        $this->db->update('tags', ['active' => $status]);
        return $this->db->affected_rows();
    }

    public function deleteTag($id)
    {
        $this->db->delete('tags', ['id_tags' => $id]);
        return $this->db->affected_rows();
    }
    // @end Tag Produk

    // @begin Category Produk
    public function getAllCategory($status)
    {
        $this->db->where('active', $status);
        return $this->db->get('kategori')->result_array();
    }

    public function getAllParentSingle($id)
    {
        $this->db->where('parent_kategori_id', $id);
       return ($this->db->get('parent_kategori')->row_array());
    }

    public function getAllParentCategory()
    {
        $this->db->select([
            'kategori.*',
            'parent_kategori.*',
            'parent_kategori_kategori.parent_kategori_kategori_id',
            'GROUP_CONCAT(kategori.nama_cat) as sub_kategori',
        ]);
        $this->db->join('parent_kategori', 'parent_kategori_kategori.parent_kategori_id=parent_kategori.parent_kategori_id');
        $this->db->join('kategori', 'parent_kategori_kategori.kategori_id=kategori.id_cat');
        $this->db->group_by('parent_kategori.parent_kategori_id');
        $data = $this->db->get('parent_kategori_kategori')->result_array();
        // dd($data);
        return $data;
    }
    
    public function getAllParentCategoryWithoutSub()
    {
        $data = $this->db->get('parent_kategori')->result_array();
        // dd($data);
        return $data;
    }

    public function inputCategoryProduk($val)
    {
        $data = array(
            'nama_cat' => $val['nama_cat'],
            'ket_cat' => $val['ket_cat'],
            'active' => $val['active'],
        );
        $this->db->insert('kategori', $data);
        return $this->db->affected_rows();
    }

    public function updateStatusCategory($id, $status)
    {
        $this->db->where('id_cat', $id);
        $this->db->update('kategori', ['active' => $status]);
        return $this->db->affected_rows();
    }

    public function deleteCategory($id)
    {
        $this->db->delete('kategori', ['id_cat' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteCategoryParent($id)
    {
        $this->db->delete('parent_kategori', ['parent_kategori_id' => $id]);
        return $this->db->affected_rows();
    }
    // @end Category Produk

    public function updateTagCat($id, $tabel, $data)
    {
        $whereID = ($tabel == 'tags') ? 'id_tags' : 'id_cat';
        $this->db->update($tabel, $data, [$whereID => $id]);
        return $this->db->affected_rows();
    }

    public function updateCatParent($id, $data)
    {
        $this->db->update('parent_kategori', $data, ['parent_kategori_id' => $id]);
        return $this->db->affected_rows();
    }

    public function updateProduk($produk, $detail, $id)
    {
        $this->db->trans_begin();
        $this->db->update('produk', $produk, ['id_produk' => $id]);
        $this->db->update('detail_produk', $detail, ['id_produk' => $id]);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }

    public function getAllOrders($status, $resi = '=')
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
        $this->db->join('midtrans', 'orders.id_orders=midtrans.order_id');
        $this->db->join('pengiriman', 'orders.id_orders=pengiriman.id_orders');
        $this->db->join('orders_produk', 'orders.id_orders=orders_produk.id_orders');
        $this->db->join('produk', 'produk.id_produk=orders_produk.id_produk');
        $this->db->join('detail_produk', 'produk.id_produk=detail_produk.id_produk');
        $this->db->join('data_user', 'orders.id_user=data_user.id_user');
        $this->db->where('orders.status_order', $status);
        $this->db->where('orders.nomer_resi' . $resi, null);
        $this->db->group_by('orders.id_orders');
        $this->db->order_by('orders.tanggal_order', 'DESC');
        return $this->db->get('orders')->result_array();
    }

    public function updateResi($id, $resi)
    {
        $this->db->update('orders', ['nomer_resi' => $resi], ['orders.id_orders' => $id]);
        return $this->db->affected_rows();
    }

    public function inputResi($id, $resi)
    {
        if ($resi == null) {
            $this->db->update(
                'orders',
                ['status_pengiriman' => null],
                ['orders.id_orders' => $id]
            );
            $this->db->update('orders', ['nomer_resi' => $resi], ['orders.id_orders' => $id]);
            $this->db->update('orders', ['Keterangan' => 'Pembayaran Berhasil Dilakukan'], ['orders.id_orders' => $id]);
        } else {
            $this->db->update(
                'orders',
                ['status_pengiriman' => 'Sedang Dikirim'],
                ['orders.id_orders' => $id]
            );
            $this->db->update('orders', ['nomer_resi' => $resi], ['orders.id_orders' => $id]);
            $this->db->update('orders', ['Keterangan' => 'Nomer Resi telah di inputkan'], ['orders.id_orders' => $id]);
        }
        return $this->db->affected_rows();
    }

    public function getOrdersDone()
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
        $this->db->join('midtrans', 'orders.id_orders=midtrans.order_id');
        $this->db->join('pengiriman', 'orders.id_orders=pengiriman.id_orders');
        $this->db->join('orders_produk', 'orders.id_orders=orders_produk.id_orders');
        $this->db->join('produk', 'produk.id_produk=orders_produk.id_produk');
        $this->db->join('detail_produk', 'produk.id_produk=detail_produk.id_produk');
        $this->db->join('data_user', 'orders.id_user=data_user.id_user');
        $this->db->where('orders.status_pengiriman', 'Terkirim');
        $this->db->group_by('orders.id_orders');
        $this->db->order_by('orders.tanggal_order', 'DESC');
        return $this->db->get('orders')->result_array();
    }

    public function countPendapatan()
    {
        $this->db->select([
            'SUM(midtrans.gross_amount) as tot_beli',
        ]);
        $this->db->join('midtrans', 'orders.id_orders=midtrans.order_id');
        $this->db->where('orders.status_pengiriman', 'Terkirim');
        return $this->db->get('orders')->row_array();
    }

    public function countPendapatanHari()
    {
        $this->db->select([
            'SUM(midtrans.gross_amount) as tot_hari',
        ]);
        $this->db->join('midtrans', 'orders.id_orders=midtrans.order_id');

        $time = (new DateTime('today'))->format('d/m/Y');
        $time1 = (new DateTime('today'))->format('d/m/Y');
        $this->db->where('orders.tanggal_selesai BETWEEN "' . $time . '" and "' . $time1 . '"');

        $this->db->where('orders.status_pengiriman', 'Terkirim');

        return $this->db->get('orders')->row_array();
    }

    public function countPendapatanBulan()
    {
        $this->db->select([
            'SUM(midtrans.gross_amount) as tot_bulan',
        ]);
        $this->db->join('midtrans', 'orders.id_orders=midtrans.order_id');

        $time = (new DateTime('first day of this month'))->format('d/m/Y');
        $time1 = (new DateTime('today'))->format('d/m/Y');
        $this->db->where('orders.tanggal_selesai BETWEEN "' . $time . '" and "' . $time1 . '"');

        $this->db->where('orders.status_pengiriman', 'Terkirim');

        return $this->db->get('orders')->row_array();
        // echo $this->db->last_query();
        // die($tot['tot_bulan']);
    }

    public function countAdmin()
    {
        $this->db->where(['level' => 'Admin']);
        return $this->db->count_all_results('data_user');
    }

    public function countProduk($where = null)
    {
        $this->db->join('produk', 'produk.id_produk=detail_produk.id_produk');
        if ($where != null) {
            $this->db->where('detail_produk.aktif', $where);
        }
        $this->db->where('produk.delete_at', 0);
        return $this->db->count_all_results('detail_produk');
    }

    public function countCustomers($kondisi = null)
    {
        $this->db->join('detail_user', 'detail_user.id_user=data_user.id_user');
        $this->db->where('detail_user.delete_at', null);
        $this->db->where('data_user.level', 'Member');
        if ($kondisi == 'bulan') {
            $time = (new DateTime('first day of this month'))->format('Y-m');
            $this->db->where('detail_user.create_date BETWEEN "' . strtotime($time) . '" and "' . strtotime('last day of this month', time()) . '"');
        } else if ($kondisi == 'hari') {
            $time = (new DateTime('today'))->format('Y-m-d');
            $this->db->where('detail_user.create_date BETWEEN "' . strtotime($time) . '" and "' . time() . '"');
        }
        return $this->db->count_all_results('data_user');
    }

    public function countOrders($status = null)
    {
        $this->db->join('midtrans', 'orders.id_orders=midtrans.order_id', 'INNER');
        if ($status != null) {
            $this->db->where(['orders.status_order' => $status]);
        } else {
            $this->db->group_start();
            $this->db->where(['status_order' => 'pending']);
            $this->db->or_where(['status_order' => 'settlement']);
            $this->db->group_end();
            $time = (new DateTime('today'))->format('Y-m-d');
            $this->db->where('orders.tanggal_order BETWEEN "' . strtotime($time) . '" and "' . time() . '"');
        }
        $this->db->where(['nomer_resi' => null]);
        return $this->db->count_all_results('orders');
    }

    public function countPengiriman()
    {
        $this->db->where(['nomer_resi !=' => null]);
        $this->db->where(['status_pengiriman' => 'Sedang Dikirim']);
        return $this->db->count_all_results('orders');
    }

    public function countDone()
    {
        $this->db->where(['status_order' => 'Selesai']);
        $this->db->where(['status_pengiriman' => 'Terkirim']);
        return $this->db->count_all_results('orders');
    }

    public function updateProfile($data, $dataFoto = null)
    {
        // var_dump($dataFoto);
        // die();
        $dataDiri = [
            'nama' => $data['nama'],
            'email' => $data['email'],
        ];

        $this->db->update('data_user', $dataDiri, ['id_user' => $this->session->id_user]);
        if ($dataFoto != null) {
            $foto['foto'] = $dataFoto;
            $this->db->update('detail_user', $foto, ['id_user' => $this->session->id_user]);
        }
        // die($this->db->last_query());
        if ($this->db->affected_rows()) {
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

    public function tambahAdmin($data)
    {
        $this->db->insert('data_user', $data);
        if ($this->db->affected_rows()) {
            $this->db->join('detail_user', 'detail_user.id_user=data_user.id_user');
            $id = $this->db->get_where('data_user', ['email' => $data['email']])->row_array();
            $this->db->where(['id_user' => $id['id_user']]);
            $this->db->update('detail_user', ['create_date' => time()]);
            return 1;
        } else {
            return 0;
        }
    }

    public function getLaporanPenjualan($start = null, $end = null)
    {
        $this->db->select([
            'orders.tanggal_selesai',
            'SUM(midtrans.gross_amount) as pendapatan',
            'COUNT(orders.id_orders) as jumlah_perhari',
        ]);
        $this->db->join('midtrans', 'orders.id_orders=midtrans.order_id');
        $this->db->where('orders.status_pengiriman', 'Terkirim');
        if ($start != null or $end != null) {
            $end = strtotime($end) + (60 * 60 * 24) - 1;
            $this->db->where('orders.tanggal_order BETWEEN "' . strtotime($start) . '" and "' . $end . '"');
        }
        $this->db->group_by('orders.tanggal_selesai');
        $this->db->order_by('orders.tanggal_selesai', 'ASC');
        return $this->db->get('orders')->result_array();
    }

    public function getLaporanBarang($start = null, $end = null)
    {
        $this->db->select([
            'orders.tanggal_selesai',
            'orders_produk.nama_orders',
            'SUM(orders_produk.qty) as tot_barang',
            'COUNT(orders.id_orders) as jumlah_perhari',
        ]);
        $this->db->join('orders_produk', 'orders.id_orders=orders_produk.id_orders');
        $this->db->join('produk', 'orders_produk.id_produk=produk.id_produk');
        $this->db->where('orders.status_pengiriman', 'Terkirim');
        if ($start != null or $end != null) {
            $end = strtotime($end) + (60 * 60 * 24) - 1;
            $this->db->where('orders.tanggal_order BETWEEN "' . strtotime($start) . '" and "' . $end . '"');
        }
        $this->db->group_by('produk.id_produk');
        $this->db->order_by('orders.tanggal_selesai', 'ASC');
        return $this->db->get('orders')->result_array();
    }

    public function getLaporanPelanggan($start = null, $end = null)
    {
        $this->db->select([
            'data_user.id_user',
            'data_user.provinsi',
            'data_user.kabupaten',
            'data_user.tanggal_lahir',
            'detail_user.create_date',
            'data_user.nama',
            'SUM(midtrans.gross_amount) as tot_beli',
            'COUNT(orders.id_orders) as jumlah_beli',
        ]);
        $this->db->join('midtrans', 'orders.id_orders=midtrans.order_id');
        $this->db->join('data_user', 'orders.id_user=data_user.id_user');
        $this->db->join('detail_user', 'detail_user.id_user=data_user.id_user');
        $this->db->where('orders.status_pengiriman', 'Terkirim');
        if ($start != null or $end != null) {
            $end = strtotime($end) + (60 * 60 * 24) - 1;
            $this->db->where('orders.tanggal_order BETWEEN "' . strtotime($start) . '" and "' . $end . '"');
        }
        $this->db->group_by('data_user.id_user');
        $this->db->order_by('data_user.nama', 'ASC');
        return $this->db->get('orders')->result_array();
    }

    public function getDataChartPemesanan()
    {
        $this->db->select([
            'orders.tanggal_selesai',
            'COUNT(orders.id_orders) as jumlah_beli',
        ]);
        $this->db->join('midtrans', 'orders.id_orders=midtrans.order_id');
        $this->db->where('orders.status_pengiriman', 'Terkirim');
        $start = (new DateTime('-10 days'))->format('Y-m-d');
        $this->db->where('orders.tanggal_order BETWEEN "' . strtotime($start) . '" and "' . time() . '"');
        $this->db->group_by('orders.tanggal_selesai');
        $this->db->order_by('orders.tanggal_selesai', 'ASC');
        return $this->db->get('orders')->result_array();
    }

    public function getDataChartPenjualan()
    {
        $this->db->select([
            'orders.tanggal_selesai',
            'SUM(midtrans.gross_amount) as jumlah_pendapatan',
        ]);
        $this->db->join('midtrans', 'orders.id_orders=midtrans.order_id');
        $this->db->where('orders.status_pengiriman', 'Terkirim');
        $start = (new DateTime('-10 days'))->format('Y-m-d');
        $this->db->where('orders.tanggal_order BETWEEN "' . strtotime($start) . '" and "' . time() . '"');
        $this->db->group_by('orders.tanggal_selesai');
        $this->db->order_by('orders.tanggal_selesai', 'ASC');
        return $this->db->get('orders')->result_array();
    }

    public function getOrderItem($id)
    {
        $this->db->select([
            'GROUP_CONCAT(orders_produk.nama_orders) as all_nama',
            'GROUP_CONCAT(orders_produk.harga_orders) as each_harga',
            'GROUP_CONCAT(orders_produk.diskon_orders) as each_diskon',
            'GROUP_CONCAT(orders_produk.qty) as each_qty',
            'GROUP_CONCAT(orders_produk.ukuran_orders) as each_ukuran',
        ]);
        $this->db->join('orders_produk', 'orders.id_orders=orders_produk.id_orders');
        $this->db->join('produk', 'produk.id_produk=orders_produk.id_produk');
        $this->db->join('detail_produk', 'produk.id_produk=detail_produk.id_produk');
        $this->db->join('data_user', 'orders.id_user=data_user.id_user');
        $this->db->where('orders.id_orders', $id);
        $this->db->group_by('orders.id_orders');
        $this->db->order_by('orders.tanggal_order', 'DESC');
        return $this->db->get('orders')->result_array();
    }

    public function getInfoResiById($id_order)
    {
        $this->db->select([
            'data_user.nama',
            'data_user.email',
            'pengiriman.*',
            'orders.nomer_resi',
            'orders.id_orders',
            'orders.keterangan',
            'midtrans.transaction_id',
        ]);
        $this->db->join('midtrans', 'orders.id_orders=midtrans.order_id');
        $this->db->join('pengiriman', 'pengiriman.id_orders=orders.id_orders');
        $this->db->join('data_user', 'orders.id_user=data_user.id_user');
        $this->db->where('orders.id_orders', $id_order);
        $this->db->where('orders.status_order', 'settlement');
        $this->db->where('orders.status_pengiriman', 'Sedang Dikirim');
        return $this->db->get('orders')->row_array();
    }

    public function getInfoHapusResi($id_order)
    {
        $this->db->select([
            'data_user.nama',
            'data_user.email',
            'pengiriman.*',
            'orders.nomer_resi',
            'orders.id_orders',
            'orders.keterangan',
            'midtrans.transaction_id',
        ]);
        $this->db->join('midtrans', 'orders.id_orders=midtrans.order_id');
        $this->db->join('pengiriman', 'pengiriman.id_orders=orders.id_orders');
        $this->db->join('data_user', 'orders.id_user=data_user.id_user');
        $this->db->where('orders.id_orders', $id_order);
        $this->db->where('orders.status_order', 'settlement');
        return $this->db->get('orders')->row_array();
    }

    public function getInfoByIdOrders($id_order)
    {
        $this->db->select([
            'data_user.nama',
            'data_user.email',
            'orders.id_orders',
            'orders.keterangan',
        ]);
        $this->db->join('data_user', 'orders.id_user=data_user.id_user');
        $this->db->where('orders.id_orders', $id_order);
        $this->db->where('orders.status_order', 'Dibatalkan');
        $this->db->where('orders.status_pengiriman', 'Batal Dikirim');
        return $this->db->get('orders')->row_array();
    }

    public function updateNotifPenerimaan($id)
    {
        $this->db->update('pengiriman', ['notifikasi_email' => time() + (86400 * 2)], ['id_orders' => $id]);
        return $this->db->affected_rows();
    }

    public function getBatalkanOrders($data)
    {
        $dataUpdate = [
            'keterangan' => $data['alasan'],
            'status_order' => 'Dibatalkan',
            'status_pengiriman' => 'Batal Dikirim',
        ];
        foreach ($this->db->get_where('orders_produk', ['id_orders' => $data['id_orders']])->result_array() as $row) {
            $this->db->where(['id_produk' => $row['id_produk']]);
            $this->db->set('stok', 'stok + ' . $row['qty'], false);
            $this->db->update('detail_produk'); //Update stok
        }
        $this->db->update('orders', $dataUpdate, ['id_orders' => $data['id_orders']]);
        return $this->db->affected_rows();
    }

}
