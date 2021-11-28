<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customers extends CI_Controller
{

  public function __construct()
  {
      parent::__construct();
      if ($this->session->has_userdata('email')) {
        if ($this->session->level != 'Member') {
          redirect('dashboard/admin');
        }
        $data['image'] = $this->freeM->getImageUser(); //Load Image user
        $data['joinAt'] = $this->freeM->getDateJoin(); //Load Create Date user
        
        $this->load->vars($data);
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->model('Customers_Model','C_M');
        $this->load->model('Admin_Model');
      } else {
        redirect('home');
      }
  }

  public function index()
  {
      $data = [
        'title' => 'Dashboard - Customers',
        'countPemesanan'  => $this->C_M->getCountPemesanan(),
        'countBelanja'  => $this->C_M->getCountBelanja(),
        'countItem'  => $this->C_M->getCountItem(),
        'dataChartPesan' => $this->setDataChartPemesanan(),
        'dataChartPenjualan' => $this->setDataChartPenjualan()
      ];
      $this->load->view('user/home', $data);
  }

  public function data_orders()
  {
    $data['title'] = 'Data Pemesanan - Customers';
    $data['settlement'] = $this->C_M->data_orders('settlement');
    $data['pending'] = $this->C_M->data_orders('pending');
    $data['expired'] = $this->C_M->data_orders('expire');
    $data['batalkan'] = $this->C_M->data_orders('Dibatalkan');
    $data['countSettlement'] = $this->C_M->getCountOrders('settlement');
    $data['countPending'] = $this->C_M->getCountOrders('pending');
    $data['countExpire'] = $this->C_M->getCountOrders('expire');
    // echo '<pre>';
    // var_dump($this->C_M->data_orders('a'));
    // echo '</pre>';
    // die();
    $this->load->view('user/orders/data_orders', $data);
  }

  public function setOrderItem()
  {
    $id = $this->input->post('id_orders', true);
    $data = $this->C_M->getOrderItem($id);
    $newData['nama'] = explode(',', $data[0]['all_nama']);
    $newData['harga'] = explode(',', $data[0]['each_harga']);
    $newData['diskon'] = explode(',', $data[0]['each_diskon']);
    $newData['qty'] = explode(',', $data[0]['each_qty']);
    $newData['ukuran'] = explode(',', $data[0]['each_ukuran']);
    // echo $newData['nama'][0];
    // echo '<pre>';
    // var_dump($newData);
    // var_dump($data);
    // echo '</pre>';
    // echo '<table class="table" id="tblItem">';
      echo '	
      <thead>
        <tr>
          <th>Nama Produk</th>
          <th>Harga/item (setelah diskon)</th>
          <th>Jumlah</th>
          <th>Diskon/item</th>
          <th>Subtotal</th>
        </tr>
      </thead>';
      for($i = 0; $i < count($newData['nama']); $i++){
        echo '
        <tbody>
          <tr>
            <td>'.$newData['nama'][$i].' ('.$newData['ukuran'][$i].')</td>
            <td>Rp '.number_format($newData['harga'][$i], 0, ',', '.').'</td>
            <td>'.$newData['qty'][$i].' item</td>
            <td>'.$newData['diskon'][$i].'%</td>
            <td>Rp '.number_format($newData['harga'][$i] * $newData['qty'][$i], 0, ',', '.').'</td>
          </tr>
        </tbody>';
      }
    // echo '</table>';
  }

  public function data_pengiriman()
  {
    //Status Pengiriman => Sedang Dikirim | Terkirim

    $data['title'] = 'Data Pemesanan - Customers';
    $data['pending'] = $this->C_M->data_pengiriman('settlement', 'Sedang Dikirim');
    $data['done'] = $this->C_M->data_pengiriman('Selesai', 'Terkirim');
    $data['countPending'] = $this->C_M->getCountOrders('settlement', 'Sedang Dikirim', 1);
    $data['countDone'] = $this->C_M->getCountOrders('Selesai', 'Terkirim', 1);
    $this->load->view('user/orders/orders_pengiriman', $data);
  }

  public function konfirmasi()
  {
    $id = $this->input->post('id_orders');
    $res = $this->Admin_Model->getInfoResiById($id);
    if($this->C_M->konfirmasi($id)){
      $this->freeM->getSweetAlert('message', 'Horayy!', 'Berhasil melakukan konfirmasi barang telah diterima.', 'success');
      $this->load->model('Admin_Model');
      $dataEmail = [
        'id_orders' => $res['id_orders'],
        'nomerResi' => $res['nomer_resi'],
        'nama' => ucwords($res['nama']),
        'email' => $res['email']
      ];
      $this->freeM->sendEmail($dataEmail, 'Terima kasih Telah Berbelanja '.$res['id_orders'],EMAIL_FROM,'notif-terimakasih');
      redirect('dashboard/customers/data_pengiriman');
    } else {
      $this->freeM->getSweetAlert('message', 'Upss!', 'Gagal melakukan konfirmasi barang telah diterima.', 'error');
      redirect('dashboard/customers/data_pengiriman');
    }
  }

  public function pengaturan()
  {
    $data['title'] = 'Pengaturan Akun - Customers';
    $this->load->view('user/setting/pengaturan', $data);
  }

  public function updateProfile()
  {
    $dataFoto = null;
    if( ($this->input->post('nama', true) == $this->session->nama AND 
        $this->input->post('email', true) == $this->session->email) AND
        empty($_FILES['foto']['name'])
      ){
      $this->freeM->getSweetAlert('message', 'Hemmm..','Data tidak berubah!','info');
      redirect('dashboard/customers/pengaturan');
    } else if(!empty($_FILES['foto']['name'])) {
      $dataFoto = $this->uploadFotoProfile();
    }

    $this->form_validation->set_rules('nama', 'Nama Baru', 'required|trim|min_length[3]|max_length[25]|alpha_numeric_spaces');
    if ($this->form_validation->run() == false) {
      $this->freeM->getSweetAlert('message', 'Upss!', 'Panjang Nama Max 25 Min 3!','error');
      redirect('dashboard/customers/pengaturan');
    } else if($this->form_validation->run() == true){
      $this->form_validation->set_rules('email', 'Email Address', 'required|trim|valid_email|is_unique[data_user.email]', [
        'is_unique' => 'Email ini sudah dipakai!'
      ]);
      if ($this->form_validation->run() == false) {
        if($this->input->post('email') == $this->session->email){
          $data = [
            'nama' => htmlspecialchars($this->input->post('nama', true)),
            'email' => $this->session->email
          ];
          if($this->C_M->updateProfile($data, $dataFoto)){
            $this->freeM->getSweetAlert('message', 'Horayy!', 'Data diri anda berhasil diubah!','success');
            redirect('dashboard/customers/pengaturan');
          } else {
            $this->freeM->getSweetAlert('message', 'Upss!', 'Sistem error atau query salah!','error');
            redirect('dashboard/customers/pengaturan');
          }
        } else {
          $this->freeM->getSweetAlert('message', 'Upss!', 'Email sudah dipakai atau email tidak valid!','error');
          redirect('dashboard/customers/pengaturan');
        }
      } else {
        $data = [
          'nama' => htmlspecialchars($this->input->post('nama', true)),
          'email' => $this->session->email
        ];
        if($this->C_M->updateProfile($data, $dataFoto)){
          $this->freeM->getSweetAlert('message', 'Horayy!', 'Data diri anda berhasil diubah!','success');
          redirect('dashboard/customers/pengaturan');
        } else {
          $this->freeM->getSweetAlert('message', 'Upss!', 'Sistem error atau query salah!','error');
          redirect('dashboard/customers/pengaturan');
        }
      }
    } 
  }

  public function uploadFotoProfile()
  {
    $config['upload_path']       = './assets/images/user/';
    $config['allowed_types']     = 'gif|jpg|png|jpeg';
    $config['max_size']          = 4000;
    $config['remove_spaces']     = TRUE;
    $config['file_name']         = round(microtime(true) * 1000);

    $this->load->library('upload');
    $this->upload->initialize($config);

    if ($this->upload->do_upload('foto')) {
      $config['image_library'] = 'gd2';
      $config['source_image'] = './assets/images/user/' .  $this->upload->data('file_name');
      $config['create_thumb'] = FALSE;
      $config['maintain_ratio'] = FALSE;
      // $config['quality'] = '50%';
      $config['width'] = 372;
      $config['height'] = 431;
      $config['new_image'] = './assets/images/user/' .  $this->upload->data('file_name');
      $this->load->library('image_lib', $config);
      $this->image_lib->resize();

      return $this->upload->data('file_name');
    } else {
      $this->freeM->getSweetAlert('message', 'Upss!', 'Foto profile gagal diupload.<br>'.$this->upload->display_errors(), 'error');
      redirect('dashboard/customers/pengaturan');
    }
  }

  public function updateKeamanan()
  {
    $oldPass = $this->input->post('OldPassword', true);
    $newPass = $this->input->post('PasswordBaru', true);
    $newPassFix = $this->input->post('fixPasswordBaru', true);
    if(!password_verify($oldPass, $this->freeM->getPassword())){
      $this->freeM->getSweetAlert('message', 'Upss!', 'Password lama salah!', 'error');
      redirect('dashboard/customers/pengaturan');
    } else {
      if(strlen($newPass) < 8 OR strlen($newPass) >= 30){
        $this->freeM->getSweetAlert('message', 'Upss!', 'Password Min 8 karakter dab Max 30 karakter!', 'error');
        redirect('dashboard/customers/pengaturan');
      } else {
        if($newPass != $newPassFix){
          $this->freeM->getSweetAlert('message', 'Upss!', 'Password baru dan konfirmasi password baru tidak sama!', 'error');
          redirect('dashboard/customers/pengaturan');
        } else {
          $data = [
            'password' => password_hash($newPass, PASSWORD_DEFAULT)
          ];
          if($this->C_M->updateKeamanan($data)){
            $this->freeM->getSweetAlertHref('updatePswSuccess', 'Horayy!', 'Password anda berhasil diubah! Silahkan login lagi.', 'success', base_url('auth/logout'));
            redirect('dashboard/customers/pengaturan');
          } else {
            $this->freeM->getSweetAlert('message', 'Upss!', 'Sistem error atau query salah!', 'error');
            redirect('dashboard/customers/pengaturan');
          }
        }
      }
    }
  }

  public function setDataChartPemesanan()
  {
    $tanggal= array();
    $dataUrut = array();
    for($i=0; $i < 10; $i++){
        $tanggal[$i] = (new DateTime('-'.$i.' days'))->format('d/m/Y');
        $dataUrut[$i] = 
          [
            'tanggal_selesai' => $tanggal[$i],
            'jumlah_beli' => '0'       
          ]
        ;
    }
    $dataChartPesan = $this->C_M->getDataChartPemesanan();
    foreach($dataChartPesan as $tgl => $val){
      for($i=0; $i < 10; $i++){
        if($val['tanggal_selesai'] == $dataUrut[$i]['tanggal_selesai']){
          $dataUrut[$i]['jumlah_beli'] = $val['jumlah_beli'];
        }
      }
    }

    return $dataUrut;
  }

  public function setDataChartPenjualan()
  {
    $tanggal= array();
    $dataUrut = array();
    for($i=0; $i < 10; $i++){
        $tanggal[$i] = (new DateTime('-'.$i.' days'))->format('d/m/Y');
        $dataUrut[$i] = 
          [
            'tanggal_selesai' => $tanggal[$i],      
            'jumlah_pendapatan' => '0'       
          ]
        ;
    }
    $dataChartPesan = $this->C_M->getDataChartPenjualan();
    foreach($dataChartPesan as $tgl => $val){
      for($i=0; $i < 10; $i++){
        if($val['tanggal_selesai'] == $dataUrut[$i]['tanggal_selesai']){
          $dataUrut[$i]['jumlah_pendapatan'] = $val['jumlah_pendapatan'];
        }
      }
    }

    return $dataUrut;
  }

  public function invoice($id_orders = null)
  {
    ($id_orders == NULL)? redirect('dashboard/customers') : '';
    ($this->C_M->cekInvoice($id_orders) == 0)? redirect('dashboard/customers') : '';

    $grup = $this->C_M->getOrderItem($id_orders);
    $data['nama_produk_all'] = explode(',', $grup[0]['all_nama']);
    $data['harga_produk_all'] = explode(',', $grup[0]['each_harga']);
    $data['diskon_produk_all'] = explode(',', $grup[0]['each_diskon']);
    $data['qty_produk_all'] = explode(',', $grup[0]['each_qty']);
    $data['ukuran_produk_all'] = explode(',', $grup[0]['each_ukuran']);
    $data['inv'] = $this->C_M->getInfoInvoice($id_orders);
    $data['title'] = 'Invoice - '.$data['inv']['id_orders'];
    // echo '<pre>';
    // var_dump($data);
    // echo '</pre>'; die();
    $this->load->view('invoice/invoice', $data);
  }
}
