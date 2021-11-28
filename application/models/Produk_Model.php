<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk_Model extends CI_Model
{
    public function getDetail($id)
    {
        $this->db->select('*')->from('produk')->where(['unik_produk'  => $id]);
        $this->db->join('kategori', 'kategori.id_cat=produk.id_cat');
        $this->db->join('detail_produk', 'detail_produk.id_produk=produk.id_produk');
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return 0;
        }
    }

    public function getTagsById($id)
    {
        $this->db->select('tags.nama_tag');
        $this->db->join('tags_produk', 'tags_produk.id_produk=produk.id_produk', 'INNER');
        $this->db->join('tags', 'tags_produk.id_tags=tags.id_tags', 'INNER');
        $query = $this->db->get_where('produk', ['produk.unik_produk' => $id]);
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else if ($query->num_rows() > 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function getAllTags()
    {   
        $this->db->select('nama_tag');
        return $this->db->get_where('tags', ['active' => 1])->result_array();
    }

    Public function getAllCat()
    {
        // $this->db->select('nama_cat');
        // // return $this->db->get_where('kategori', ['active' => 1])->result_array();
        // return $this->db->get('kategori')->result_array();

        $this->db->select([
            'parent_kategori.parent_kategori_nama',
            'GROUP_CONCAT(kategori.nama_cat) as sub_kategori',
        ]);
        $this->db->join('parent_kategori', 'parent_kategori_kategori.parent_kategori_id=parent_kategori.parent_kategori_id');
        $this->db->join('kategori', 'parent_kategori_kategori.kategori_id=kategori.id_cat');
        $this->db->group_by('parent_kategori.parent_kategori_id');
        $data = $this->db->get('parent_kategori_kategori')->result_array();
        // dd($data);
        return $data;
    }

    public function cariProduk($jenis, $nama, $limit, $start)
    {
        if($jenis == 'kategori'){
            $namaField = 'kategori.nama_cat';
        } else {
            $namaField = 'tags.nama_tag';
        }
        $this->db->join('detail_produk', 'detail_produk.id_produk=produk.id_produk');
        $this->db->join('kategori', 'kategori.id_cat=produk.id_cat');
        $this->db->limit($limit, $start);
        $kondisi = [
            'detail_produk.aktif' => 1,
            $namaField => ucwords($nama)
        ];
        return $this->db->get_where('produk', $kondisi)->result_array();
    }

    public function cariProdukKeyword($keyword, $limit, $start)
    {
        $this->db->join('detail_produk', 'detail_produk.id_produk=produk.id_produk');
        $this->db->join('kategori', 'kategori.id_cat=produk.id_cat');
        $this->db->like('produk.nama_produk', $keyword);
        $this->db->limit($limit, $start);
        $kondisi = [
            'detail_produk.aktif' => 1,
        ];
        return $this->db->get_where('produk', $kondisi)->result_array();
    }

    public function hitungProdukKeyword($keyword)
    {
        $this->db->select('produk.nama_produk');
        $this->db->from('produk');
        $this->db->join('detail_produk', 'detail_produk.id_produk=produk.id_produk');
        $this->db->join('kategori', 'kategori.id_cat=produk.id_cat');
        $this->db->where('detail_produk.aktif', 1);
        $this->db->like('produk.nama_produk', $keyword);
        return $this->db->count_all_results();
    }

    public function hitungProdukKategori($jenis, $nama)
    {
        if($jenis == 'kategori'){
            $namaField = 'kategori.nama_cat';
        } else {
            $namaField = 'tags.nama_tag';
        }
        $this->db->select('kategori.nama_cat');
        $this->db->from('produk');
        $this->db->join('detail_produk', 'detail_produk.id_produk=produk.id_produk');
        $this->db->join('kategori', 'kategori.id_cat=produk.id_cat');
        $this->db->where('detail_produk.aktif', 1);
        $this->db->where($namaField, $nama);
        return $this->db->count_all_results();
    }

    public function produkLainnya($id)
    {
        $this->db->select(['kategori.nama_cat','produk.unik_produk']);
        $this->db->from('produk');
        $this->db->join('kategori','kategori.id_cat=produk.id_cat');
        $this->db->where('produk.unik_produk', $id);
        $kategori = $this->db->get()->row_array();
        if($kategori != null){
            $this->db->select('*')->limit(6);
            $this->db->order_by('produk.id_produk', 'RANDOM');
            $this->db->join('kategori', 'kategori.id_cat=produk.id_cat');
            $this->db->join('detail_produk', 'detail_produk.id_produk=produk.id_produk');
            $this->db->where('produk.unik_produk !=', $kategori['unik_produk']);
            $this->db->where('detail_produk.aktif', 1);
            return $this->db->get_where('produk',['kategori.nama_cat' => $kategori['nama_cat']])->result_array();
            // die($this->db->last_query());
        }
    }

    public function getIdByUnik($unik){
        $this->db->select('produk.id_produk');
        return $this->db->get_where('produk',['produk.unik_produk' => $unik])->row_array();
    }
}

// echo '<pre>';
// var_dump($tes);
// echo '</pre>';
// die;