<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    redirect('home');
  }

  public function tambahKeranjang() //fungsi Add To Cart
  {
    if ($this->session->level == 'Admin' OR $this->session->level == 'Owner') {
      $this->freeM->getSweetAlert('infoPayment', 'Upss!', 'Admin atau Owner tidak dapat berbelanja di toko sendiri, gunakan akun member!');
      redirect('/');
    }
    if($this->input->post('ukuran', true) == '' OR $this->input->post('qty', true) <= 0 OR !is_numeric($this->input->post('qty', true))){
      $this->freeM->getSweetAlert('message', 'Upss!', 'Silahkan pilih jumlah dan ukuran dulu!', 'error');
      redirect('produk/detail/' . encrypt_url($this->input->post('produk_id'))); 
    } else {
      $diskon = ($this->input->post('produk_harga') * $this->input->post('diskon') / 100);
      $data = array(
        'id' => $this->input->post('produk_id', true).'-'.rand(1,999),
        'unik_produk' => $this->input->post('produk_id', true),
        'name' => $this->input->post('produk_nama', true),
        'price' => $this->input->post('produk_harga', true) - $diskon,
        'diskon' => $this->input->post('diskon', true),
        'gambar' => $this->input->post('gambar', true),
        'ukuran' => $this->input->post('ukuran', true),
        'berat' => $this->input->post('berat', true),
        'qty' => $this->input->post('qty', true)
      );
      $this->cart->insert($data);
      // var_dump($this->cart->contents());die;
      $this->freeM->getSweetAlert('message', 'Horay!', 'Berhasil menambahkan produk ke keranjang!', 'success');
      redirect('produk/detail/' . encrypt_url($this->input->post('produk_id')));
    }
  }

  public function hapus_items($rowid)
  {
    $data = array(
      'rowid' => $rowid,
      'qty' => 0,
    );
    
    if($this->cart->update($data)){
      $this->freeM->getSweetAlert('message', 'Horay!', 'Berhasil menghapus item dari keranjang!', 'success');
    } else {
      $this->freeM->getSweetAlert('message', 'Upss!', 'Gagal menghapus item dari keranjang keranjang!', 'error');
    }
    header('location:' . $_SERVER['HTTP_REFERER']);
  }
}
