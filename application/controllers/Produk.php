<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Produk_Model');
        $this->load->library('pagination');
    }

    public function index()
    {
        redirect('');
    }

    public function detail($id = null)
    {
        if ($id != null) {
            $data['produkLain'] = $this->Produk_Model->produkLainnya(decrypt_url($id));
            $data['produk'] = $this->Produk_Model->getDetail(decrypt_url($id));
            if ($data['produk']) {
                $data['title'] = 'Produk - ' . ucwords($data['produk']['nama_produk']);
                $data['ukuranNew'] = explode(', ', $data['produk']['ukuran']);
                $data['tags'] = $this->Produk_Model->getTagsById(decrypt_url($id));
                $this->load->view('produk/product-page', $data);
            } else {
                redirect('');
            }
        } else {
            redirect('');
        }
    }

    public function checkout()
    {
        if (count($this->cart->contents()) == 0) {
            if ($this->session->level == 'Admin' OR $this->session->level == 'Owner') {
                $this->freeM->getSweetAlert('infoPayment', 'Upss!', 'Admin atau Owner tidak dapat berbelanja di toko sendiri, gunakan akun member!');
            }
            redirect('/');
        } else {
            $this->load->library('form_validation');
            $data['berat'] = 0;
            foreach($this->cart->contents() as $cart):
                $data['berat'] += (int)$cart['berat'] * $cart['qty'];
            endforeach;
            $data['berat'] = $data['berat'] / 1000;
            if ($this->session->email) {
                $data['title'] = APP_NAME.' - Pembayaran';
                $this->load->view('produk/checkout-page', $data);
            } else {
                $this->session->set_userdata('checkout_url', current_url());
                redirect('auth/login');
            }
        }
    }

    public function cari($jenis = null, $nama = null)
    {   
        if($jenis == null OR $nama == null){ redirect('home'); }
        $jenis = $this->uri->segment(3);
		$data['tags'] = $this->Produk_Model->getAllTags();
		$data['cat'] = $this->Produk_Model->getAllCat();
        $data['title'] = APP_NAME.' - Pencarian '.ucwords($nama);
        $data['totData'] = $this->Produk_Model->hitungProdukKategori($jenis, $nama);
        //konfigurasi pagination
		$config['base_url'] = base_url('produk/cari/'.$jenis.'/'.$nama); //site url
		$config['total_rows'] = $data['totData']; //total row
		$config['per_page'] = 8;  //show record per halaman
		$config['uri_segment'] = 5;  // uri parameter
		$choice = $config['total_rows'] / $config['per_page'];
		$config['num_links'] = floor($choice);

		$this->pagination->initialize($config);
		$data['page'] = ($this->uri->segment(5));
        //konfigurasi pagination

        $data['produk'] = $this->Produk_Model->cariProduk($jenis, $nama, $config['per_page'], $data['page']);         

		$data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('produk/cari-produk', $data);
    }

    public function cari_produk($keyword = null)
    {
        $keyword = $this->uri->segment(3);
        if($keyword == null){ redirect('home'); }
		$data['tags'] = $this->Produk_Model->getAllTags();
		$data['cat'] = $this->Produk_Model->getAllCat();
        $data['title'] = APP_NAME.' - Pencarian '. str_replace('%20',' ',ucwords($keyword));
        $data['totData'] = $this->Produk_Model->hitungProdukKeyword($keyword);
                //konfigurasi pagination
		$config['base_url'] = base_url('produk/cari_produk/'.$keyword); //site url
		$config['total_rows'] = $data['totData']; //total row
		$config['per_page'] = 8;  //show record per halaman
		$config['uri_segment'] = 4;  // uri parameter
		$choice = $config['total_rows'] / $config['per_page'];
		$config['num_links'] = floor($choice);

		$this->pagination->initialize($config);
		$data['page'] = ($this->uri->segment(4));
        //konfigurasi pagination

        $data['produk'] = $this->Produk_Model->cariProdukKeyword($keyword, $config['per_page'], $data['page']);         

        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('produk/cari-produk-keyword', $data);
    }


}
