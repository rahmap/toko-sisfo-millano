<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ongkir extends CI_Controller
{
  private $apiRaja = API_RAJA_ONGKIR; // cek config/Constants.php
  private $curl;

  public function __construct()
  {
    parent::__construct();
    $this->curl = curl_init();
    $this->load->model('Produk_Model');
  }

  public function getDataPengiriman($dataForm)
  {

  }

  
  public function getKabupaten($prov_id = null){
    // $this->freeM->cek_ajax();
    $this->load->library('rajaongkir');
    return 'halo';
    // return $this->rajaongkir->city($prov_id);
}

  public function data_kota($pilih = null){
    $this->freeM->cek_ajax();

    $pilih = $this->uri->segment(3);
    switch ($pilih) {
    
      case'kotatujuan':
      curl_setopt_array($this->curl, array(
        CURLOPT_URL => "http://api.rajaongkir.com/starter/city",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "key: $this->apiRaja"
        ),
      ));
      $response = curl_exec($this->curl);
      $err = curl_error($this->curl);
      curl_close($this->curl);
      $data = json_decode($response, true);

      // echo '<pre>';    Cek daily limit
      // var_dump($data);
      // echo '</pre>'; die();

      echo "<option></option>";
      for($i=0; $i < count($data['rajaongkir']['results']); $i++) { 
          echo "<option value='".$data['rajaongkir']['results'][$i]['city_id']."'>".$data['rajaongkir']['results'][$i]['city_name']."</option>";
      }
      break;
    }
  }

  public function cek_ongkir()
  {
    // $this->freeM->cek_ajax();
    $this->load->library('form_validation');
    $this->form_validation->set_rules('kota_tujuan', 'Kota Tujuan', 'required');
    $this->form_validation->set_rules('kurir', 'Kurir', 'required');
    $this->form_validation->set_rules('berat', 'Berat Barang', 'required');
    if ($this->form_validation->run() === false) {
      // echo json_encode(array('success'=> 'false'));
      http_response_code(501);
      echo validation_errors();
    } else {
      $kota_tujuan = $this->input->post('kota_tujuan', true);
      $kurir = $this->input->post('kurir', true);
      $berat = $this->input->post('berat', true) * 1000;
  
      curl_setopt_array($this->curl, array(
        CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=365&destination=".$kota_tujuan."&weight=".$berat."&courier=".$kurir."",
        CURLOPT_HTTPHEADER => array(
          "content-type: application/x-www-form-urlencoded",
          "key: $this->apiRaja"
        ),
      ));
      $response = curl_exec($this->curl);
      $err = curl_error($this->curl);
      curl_close($this->curl);
      $data= json_decode($response, true);
      
      $banyak = count($data['rajaongkir']['results'][0]['costs']);
  
      for($i = 0; $i < $banyak; $i++){
        $data['rajaongkir']['results'][0]['costs'][$i]['total'] = $this->cart->total();
      }
      http_response_code(200);
      echo json_encode($data['rajaongkir']['results'][0]['costs']);
    }
  }

  public function getDetailOngkir()
  {
    // $this->freeM->cek_ajax();
    $this->load->library('form_validation');
    //Data dibawah ini di kirim lewat ajax halaman Checkout
    //Cek /assets/js/Ongkir.js
    $this->form_validation->set_rules('penerima', 'Nama Penerima', 'required|trim|min_length[3]|alpha_numeric_spaces|max_length[20]');
    $this->form_validation->set_rules('alamat', 'Alamat Penerima', 'required|trim|min_length[10]|max_length[90]');
    $this->form_validation->set_rules('kurir', 'Kurir', 'required');
    $this->form_validation->set_rules('estimasi', 'estimasi', 'required');
    $this->form_validation->set_rules('service', 'Service', 'required');
    $this->form_validation->set_rules('berat', 'Berat Total', 'required');
    $this->form_validation->set_rules('total_ongkir', 'Total Ongkir', 'required');
    $this->form_validation->set_rules('kode_pos', 'Kode Pos', 'required|min_length[3]|max_length[20]|alpha_numeric_spaces');
    $this->form_validation->set_rules('nohp', 'Nomer HP Penerima', 'required|min_length[8]|max_length[20]|is_natural');
    if ($this->form_validation->run() === false) {
      // echo json_encode(array('success'=> 'false'));
      http_response_code(501);
      echo validation_errors();
    } else {
      $totalBayar = $this->input->post('totalBayar', true);
      $ongkir = [
        'id_orders' => '',
        'kurir' => $this->input->post('kurir', true),
        'service' => $this->input->post('service', true),
        'estimasi' => $this->input->post('estimasi', true),
        'alamat_pengiriman' => $this->input->post('alamat', true),
        'kode_pos' => $this->input->post('kode_pos', true),
        'nama_penerima' => $this->input->post('penerima', true),
        'no_penerima' => $this->input->post('nohp', true),
        'berat' => $this->input->post('berat', true) * 1000,
        'total_ongkir' => $this->input->post('total_ongkir', true)
      ];
      $this->session->set_userdata($ongkir);
      $this->session->set_userdata('triggerCheckout', time());
      $this->session->set_userdata('totalBayar', $totalBayar);
      http_response_code(200);
    }


    // echo '<pre>';
    // var_dump($this->session->alamat_pengiriman);
    // echo '</pre>';

    // echo '<pre>';
    // var_dump('Total bayar '.$this->session->totalBayar);
    // echo '</pre>';

    // echo '<pre>';
    // var_dump($this->cart->contents());
    // echo '</pre>';
  }

}