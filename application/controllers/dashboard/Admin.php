<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->library('upload');
    $this->load->model(['Admin_Model']);
    if ($this->session->has_userdata('email')) {
      if ($this->session->level == 'Member') {
        redirect('dashboard/customers');
      } else if($this->session->level == 'Master'){
				redirect('dashboard/master');
			}
      $data['image'] = $this->freeM->getImageUser(); //Load Image user
      $data['joinAt'] = $this->freeM->getDateJoin(); //Load Create Date user
      $this->load->vars($data);
    } else {
      redirect('home');
    }
  }

  public function index()
  {
    $data = [
      'title' => 'Dashboard - Admin',
      'totPelanggan' => $this->Admin_Model->countCustomers(),
      'totOrders' => $this->Admin_Model->countDone(),
      'totProduk' => $this->Admin_Model->countProduk(),
      'totAdmin' => $this->Admin_Model->countAdmin(),
      'totHari' => $this->Admin_Model->countPendapatanHari(),
      'totBulan' => $this->Admin_Model->countPendapatanBulan(),
      'totUang' => $this->Admin_Model->countPendapatan(),
      'dataChartPesan' => $this->setDataChartPemesanan(),
      'dataChartPenjualan' => $this->setDataChartPenjualan()
    ];
    $this->load->view('admin/home', $data);
  }

  public function data_rating()
  {

      $data = [
        'title' => 'Daftar Penerima - Admin',
        'dataPenerima' =>  $this->Admin_Model->getAllCustomers()
        ];

    // var_dump($this->db->last_query());
    $this->load->view('admin/customers/data_rating', $data);
  }
    
  public function data_customers()
  {
    $data['title'] = 'Data Customers - Admin';
    $data['customers'] = $this->Admin_Model->getAllCustomers();
    $data['allCustomers'] = $this->Admin_Model->countCustomers();
    $data['bulanCustomers'] = $this->Admin_Model->countCustomers('bulan');
    $data['hariCustomers'] = $this->Admin_Model->countCustomers('hari');
    // var_dump($this->db->last_query());
    $this->load->view('admin/customers/data_customers', $data);
  }

  public function delete_customers($id = null)
  {
    if ($id != NULL) {
      if ($this->Admin_Model->deleteCustomers(decrypt_url($id))) {
        $this->freeM->getSweetAlert('message', 'Success!', 'Data pelanggan berhasil di hapus!.', 'success');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Data pelanggan gagal di hapus!', 'error');
      }
    } else {
      redirect('dashboard/admin/data_customers');
    }
    redirect('dashboard/admin/data_customers');
  }

  public function nonaktif_customers($id = null)
  {
    if ($id != NULL) {
      if ($this->Admin_Model->nonaktifCustomers(decrypt_url($id))) {
        $res = $this->Admin_Model->getInfoUserByIdWOToken(decrypt_url($id)); //get info pengiriman
        $dataEmail = [
          'nama' => $res['nama'],
          'email' => $res['email']
        ];
        $this->freeM->sendEmail($dataEmail, 'Informasi Akun ['.$res['email'].']',  EMAIL_FROM, 'nonaktif-pelanggan');
        $this->freeM->getSweetAlert('message', 'Success!', 'Berhasil mengirim email pengaktifan!.', 'success');
        $this->freeM->getSweetAlert('message', 'Success!', 'Pelanggan berhasil di nonaktifkan!.', 'success');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Pelanggan gagal di nonaktifkan!', 'error');
      }
    } else {
      redirect('dashboard/admin/data_customers');
    }
    redirect('dashboard/admin/data_customers');
  }

  public function aktifkan_customers($id = null) //Belum selesai
  {
    if ($id != NULL) {
      if ($this->Admin_Model->generateUserToken(decrypt_url($id))) {
        $res = $this->Admin_Model->getInfoUserById(decrypt_url($id)); //get info pengiriman
        $dataEmail = [
          'nama' => $res['nama'],
          'email' => $res['email'],
          'token' => $res['token']
        ];
        $this->freeM->sendEmail($dataEmail, 'Pengaktifan Akun ['.$res['email'].']',  EMAIL_FROM, 'aktif-pelanggan');
        $this->freeM->getSweetAlert('message', 'Success!', 'Berhasil mengirim email pengaktifan!.', 'success');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Gagal mengirim email pengaktifan!', 'error');
      }
    } else {
      redirect('dashboard/admin/data_customers');
    }
    redirect('dashboard/admin/data_customers');
  }

  public function add_product()
  {
    $this->form_validation->set_rules('nama', 'Nama Produk', 'min_length[6]|max_length[50]|required|trim|alpha_numeric_spaces');
    $this->form_validation->set_rules('harga', 'Harga Produk', 'min_length[4]|required|trim|numeric');
    $this->form_validation->set_rules('diskon', 'Diskon Produk', 'min_length[1]|required|trim|numeric');
    $this->form_validation->set_rules('stok', 'Stok Produk', 'min_length[1]|required|trim|numeric');
    $this->form_validation->set_rules('berat', 'Berat Produk', 'min_length[1]|required|trim|numeric');
    // $this->form_validation->set_rules('ukuran', 'Ukuran Produk', 'required');
    $this->form_validation->set_rules('kategori', 'Kategori Produk', 'required');
    // $this->form_validation->set_rules('tags', 'Tags Produk', 'required');
    $this->form_validation->set_rules('ket_produk', 'Keterangan Produk', 'min_length[20]|required|max_length[200]|trim|alpha_numeric_spaces');

    if ($this->form_validation->run() == false) {
      $data['title'] = 'Add Products - Admin';
      $data['tag'] = $this->Admin_Model->getCatTag('tags', ['active' => 1]);
      $data['cat'] = $this->Admin_Model->getCatTag('kategori', ['active' => 1]);
      $this->load->view('admin/product/addProduct', $data);
    } else if ($this->form_validation->run() == true) {
      $tags = $this->input->post('tags', true); //Tags Produk
      if (!empty($_FILES['foto']['name'])) {
        $data = [
          'unik_produk' => $this->freeM->getUnikProduk($this->input->post('kategori'), true),
          'nama_produk' => ucwords($this->input->post('nama', true)),
          'ket_produk' => ucfirst($this->input->post('ket_produk', true)),
          'id_cat' => $this->input->post('kategori', true),
          'harga_produk' => $this->input->post('harga', true),
          'gambar_produk' => $this->uploadFotoProduk(),
          'create_date' => time()
        ];
        $ukuran = $this->input->post('ukuran', true);
        $newUk = '';
        foreach ($ukuran as $uk) {
          $newUk .= $uk . ', ';
        }
        $detail = [
          'stok' => $this->input->post('stok', true),
          'diskon' => $this->input->post('diskon', true),
          'ukuran' => $newUk,
          'berat' => $this->input->post('berat', true),
          'aktif' => 1
        ];
        if ($this->Admin_Model->inputProduct($data, $tags, $detail)) {
          $this->freeM->getSweetAlert('message', 'Success!', 'Data Produk berhasil ditambahkan.', 'success');
        } else {
          $this->freeM->getSweetAlert('message', 'Upss!', 'Data Produk gagal ditambahkan.', 'error');
        }
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Foto Produk gagal diupload.', 'error');
      }
      redirect('dashboard/admin/add_product');
    }
  }

  public function uploadFotoProduk()
  {
    $config['upload_path']       = './assets/images/produk/';
    $config['allowed_types']     = 'gif|jpg|png|jpeg';
    $config['max_size']          = 4000;   //Tergantung dari php.ini juga
    $config['remove_spaces']     = TRUE;
    $config['file_name']         = round(microtime(true) * 1000);

    $this->load->library('upload');
    $this->upload->initialize($config);

    if ($this->upload->do_upload('foto')) {
      $config['image_library'] = 'gd2';   //Meng resize foto hasil upload
      $config['source_image'] = './assets/images/produk/' .  $this->upload->data('file_name');
      $config['create_thumb'] = FALSE;
      $config['maintain_ratio'] = FALSE;
      // $config['quality'] = '50%';
      $config['width'] = 372;
      $config['height'] = 431;
      $config['new_image'] = './assets/images/produk/' .  $this->upload->data('file_name');
      $this->load->library('image_lib', $config);
      $this->image_lib->resize();

      return $this->upload->data('file_name');
    } else {
      $this->freeM->getSweetAlert('message', 'Upss!', 'Foto profile gagal diupload.<br>'.$this->upload->display_errors(), 'error');
      redirect('dashboard/admin/add_product');
    }
  }

  public function data_product()
  {
    $data['title'] = 'Data Produk - Admin';
    $res = $this->Admin_Model->getAllProduk();

    $tags = [];
    $newAr = [];
    foreach ($res as $produk) {
      //Membuat array baru jika kosong
      if (empty($tags[$produk['id_produk']])) {
        $tags[$produk['id_produk']] = [];
      }
      //Push value array
      array_push($tags[$produk['id_produk']], [
        'id_tags' => $produk['id_tags'],
        'nama_tag' => $produk['nama_tag']
      ]);
      //Membuat result array baru
      $newAr[$produk['id_produk']] = [
        'id_produk' => $produk['id_produk'],
        'unik_produk' => $produk['unik_produk'],
        'nama_produk' => $produk['nama_produk'],
        'ket_produk' => $produk['ket_produk'],
        'nama_cat' => $produk['nama_cat'],
        'harga_produk' => $produk['harga_produk'],
        'gambar_produk' => $produk['gambar_produk'],
        'create_date' => $produk['create_date'],
        'delete_at' => $produk['delete_at'],
        'id_detail' => $produk['id_detail'],
        'stok' => $produk['stok'],
        'diskon' => $produk['diskon'],
        'ukuran' => $produk['ukuran'],
        'aktif' => $produk['aktif'],
        'id_tags_produk' => $produk['id_tags_produk'],
        'ket_tag' => $produk['ket_tag'],
        'nama_tag' => $tags[$produk['id_produk']]
      ];
    }

    $data['produk'] = $newAr;
    // echo '<pre>';
    // var_dump($data['produk']);
    // echo '</pre>';
    // die;
    //count produk
      $data['aktifProduk'] =$this->Admin_Model->countProduk('1');
      $data['allProduk'] = $this->Admin_Model->countProduk();
      $data['nonaktif'] = $this->Admin_Model->countProduk('0');
    $this->load->view('admin/product/data_product', $data);
  }

  public function delete_produk($id = null)
  {
    if ($id != null) {
      if ($this->Admin_Model->deleteProduct(decrypt_url($id))) {
        $this->freeM->getSweetAlert('message', 'Horay!', 'Produk berhasil dihapus.', 'success');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Produk gagal dihapus.', 'error');
      }
      redirect('dashboard/admin/data_product');
    } else {
      redirect('dashboard/admin/data_product');
    }
  }

  public function aktif_produk($id = null)
  {
    if ($id != null) {
      if ($this->Admin_Model->statusProduct(decrypt_url($id), 1)) {
        $this->freeM->getSweetAlert('message', 'Horay!', 'Produk berhasil diaktifkan.', 'success');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Produk gagal diaktifkan.', 'error');
      }
      redirect('dashboard/admin/data_product');
    } else {
      redirect('dashboard/admin/data_product');
    }
  }

  public function nonaktif_produk($id = null)
  {
    if ($id != null) {
      if ($this->Admin_Model->statusProduct(decrypt_url($id), 0)) {
        $this->freeM->getSweetAlert('message', 'Horay!', 'Produk berhasil dinonaktifkan.', 'success');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Produk gagal dinonaktifkan.', 'error');
      }
      redirect('dashboard/admin/data_product');
    } else {
      redirect('dashboard/admin/data_product');
    }
  }

  public function add_tag()
  {
    $this->form_validation->set_rules('nama_tag', 'Nama Tag', 'required|trim|min_length[3]|max_length[20]|alpha_numeric_spaces');
    $this->form_validation->set_rules('ket_tag', 'Keterangan Tag', 'required|min_length[8]|max_length[50]|trim|alpha_numeric_spaces');
   
    if ($this->form_validation->run() == false) {
      $data['title'] = 'Tambah Tag Produk - Admin';
      $data['tagAktif'] = $this->Admin_Model->getAllTag(1);
      $data['tagNonaktif'] = $this->Admin_Model->getAllTag(0);
      $this->load->view('admin/product/addTag', $data);
    } else {
      $data = [
        'nama_tag' => clean(ucwords($this->input->post('nama_tag', true))),
        'ket_tag' =>  clean(ucfirst($this->input->post('ket_tag', true))),
        'active' => 1
      ];
      if ($this->Admin_Model->inputTagProduk($data) > 0) {
        $this->freeM->getSweetAlert('message', 'Horay!', 'Tag Produk berhasil ditambahkan.', 'success');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Tag Produk gagal ditambahkan.', 'error');
      }
      redirect('dashboard/admin/add_tag');
    }
  }

  public function deactive_tag($id = null)
  {
    if ($id != null) {
      if ($this->Admin_Model->updateStatusTag(decrypt_url($id), 0)) {
        $this->freeM->getSweetAlert('message', 'Horay!', 'Tag Produk berhasil dinonaktifkan.', 'success');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Tag Produk gagal dinonaktifkan.', 'error');
      }
      redirect('dashboard/admin/add_tag');
    } else {
      redirect('dashboard/admin/add_tag');
    }
  }

  public function reactive_tag($id = null)
  {
    if ($id != null) {
      if ($this->Admin_Model->updateStatusTag(decrypt_url($id), 1)) {
        $this->freeM->getSweetAlert('message', 'Horay!', 'Tag Produk berhasil diaktifkan.', 'success');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Tag Produk gagal diaktifkan.', 'error');
      }
      redirect('dashboard/admin/add_tag');
    } else {
      redirect('dashboard/admin/add_tag');
    }
  }

  public function delete_tag($id)
  {
    if ($id != null) {
      if ($this->Admin_Model->deleteTag(decrypt_url($id))) {
        $this->freeM->getSweetAlert('message', 'Horay!', 'Tag Produk berhasil dihapus selamanya.', 'success');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Tag Produk gagal dihapus selamanya.', 'error');
      }
      redirect('dashboard/admin/add_tag');
    } else {
      redirect('dashboard/admin/add_tag');
    }
  }

  public function addParentKategori($id_parent)
  {
    if(!isset($_POST['submit'])){
      redirect('dashboard/admin/edit_parent_kategori/'.$id_parent);
    } else {
      $data = $this->input->post('subKategori', true);
      $this->db->delete('parent_kategori_kategori', ['parent_kategori_id' => $id_parent]);
      foreach($data as $key => $val){
        $this->db->insert('parent_kategori_kategori', [
          'parent_kategori_id' => $id_parent,
          'kategori_id' => $val
        ]);
      }
      if ($this->db->affected_rows() > 0) {
        $this->freeM->getSweetAlert('message', 'Horay!', 'Parent Kategori Produk berhasil atur.', 'success');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Parent Kategori Produk gagal atur.', 'error');
      }
      redirect('dashboard/admin/edit_parent_kategori/'.$id_parent);
    }
  }

  public function addParent()
  {
    if(isset($_POST['submit'])){
      $parent = $this->input->post('nama_parent', true);
      if($this->db->insert('parent_kategori', ['parent_kategori_nama' => $parent])){
        $this->freeM->getSweetAlert('message', 'Horay!', 'Parent Kategori Produk berhasil ditambahkan.', 'success');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Parent Kategori Produk gagal ditambahkan.', 'error');
      }
      redirect('dashboard/admin/add_category');
    }
  }

  public function add_category()
  {
    $this->form_validation->set_rules('nama_cat', 'Nama Kategori', 'required|trim|min_length[3]|max_length[20]|alpha_numeric_spaces');
    $this->form_validation->set_rules('ket_cat', 'Keterangan Kategori', 'required|trim|min_length[8]|max_length[50]|alpha_numeric_spaces');
    if ($this->form_validation->run() == false) {
      $data['title'] = 'Tambah Kategori Produk - Admin';
      $data['categoryAktif'] = $this->Admin_Model->getAllCategory(1);
      $data['categoryNonaktif'] = $this->Admin_Model->getAllCategory(0);

      $data['parentKategori'] = $this->Admin_Model->getAllParentCategory();
      $data['parentKategoriOnly'] = $this->Admin_Model->getAllParentCategoryWithoutSub();
      $this->load->view('admin/product/addCategory', $data);
    } else if ($this->form_validation->run() == true) {
      $data = [
        'nama_cat' => ucwords($this->input->post('nama_cat', true)),
        'ket_cat' =>  ucfirst($this->input->post('ket_cat', true)),
        'active' => 1
      ];
      if ($this->Admin_Model->inputCategoryProduk($data) > 0) {
        $this->freeM->getSweetAlert('message', 'Horay!', 'Kategori Produk berhasil ditambahkan.', 'success');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Kategori Produk gagal ditambahkan.', 'error');
      }
      redirect('dashboard/admin/add_category');
    }
  }

  public function edit_parent_kategori($id_parent)
  {
    $this->form_validation->set_rules('parent', 'Nama Kategori', 'required');
    $this->form_validation->set_rules('subKategori', 'Keterangan Kategori', 'required|trim|min_length[3]|max_length[100]|alpha_numeric_spaces');
    if ($this->form_validation->run() == false) {
      $data['title'] = 'Atur Parent Kategori - Admin';
      $data['parent'] = $this->Admin_Model->getAllParentSingle($id_parent);
      $data['kategori'] = $this->Admin_Model->getAllCategory(1);

      $this->load->view('admin/product/addSubOnParent', $data);
    } else if ($this->form_validation->run() == true) {
      $data = [
        'nama_cat' => ucwords($this->input->post('nama_cat', true)),
        'ket_cat' =>  ucfirst($this->input->post('ket_cat', true)),
        'active' => 1
      ];
      if ($this->Admin_Model->inputCategoryProduk($data) > 0) {
        $this->freeM->getSweetAlert('message', 'Horay!', 'Kategori Produk berhasil ditambahkan.', 'success');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Kategori Produk gagal ditambahkan.', 'error');
      }
      redirect('dashboard/admin/add_category');
    }
  }

  public function deactive_category($id = null)
  {
    if ($id != null) {
      if ($this->Admin_Model->updateStatusCategory(decrypt_url($id), 0)) {
        $this->freeM->getSweetAlert('message', 'Horay!', 'Kategori Produk berhasil dinonaktifkan.', 'success');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Kategori Produk gagal dinonaktifkan.', 'error');
      }
      redirect('dashboard/admin/add_category');
    } else {
      redirect('dashboard/admin/add_category');
    }
  }

  public function reactive_category($id = null)
  {
    if ($id != null) {
      if ($this->Admin_Model->updateStatusCategory(decrypt_url($id), 1)) {
        $this->freeM->getSweetAlert('message', 'Horay!', 'Kategori Produk berhasil diaktifkan.', 'success');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Kategori Produk gagal diaktifkan.', 'error');
      }
      redirect('dashboard/admin/add_category');
    } else {
      redirect('dashboard/admin/add_category');
    }
  }

  public function delete_category($id)
  {
    if ($id != null) {
      if ($this->Admin_Model->deleteCategory(decrypt_url($id))) {
        $this->freeM->getSweetAlert('message', 'Horay!', 'Kategori Produk berhasil dihapus selamanya.', 'success');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Kategori Produk gagal dihapus selamanya.', 'error');
      }
      redirect('dashboard/admin/add_category');
    } else {
      redirect('dashboard/admin/add_category');
    }
  }

  public function delete_categoryParent($id)
  {
    if ($id != null) {
      if ($this->Admin_Model->deleteCategoryParent(decrypt_url($id))) {
        $this->freeM->getSweetAlert('message', 'Horay!', 'Parent Kategori Produk berhasil dihapus selamanya.', 'success');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Parent Kategori Produk gagal dihapus selamanya.', 'error');
      }
      redirect('dashboard/admin/add_category');
    } else {
      redirect('dashboard/admin/add_category');
    }
  }

  public function updateTag()
  {
    $this->form_validation->set_rules('nama_tag_new', 'Nama Tag', 'required|trim|min_length[3]|max_length[20]|alpha_numeric_spaces');
    $this->form_validation->set_rules('ket_tag_new', 'Keterangan Tag', 'required|trim|min_length[8]|max_length[50]|alpha_numeric_spaces');
    if ($this->form_validation->run() == false) {
      $this->freeM->getSweetAlert('message', 'Upss!', 'Tag Produk gagal diupdate. Perbaiki data inputan!', 'error');
      redirect('dashboard/admin/add_tag');
    } else {
      $idTag =  $this->input->post('id_tag_new', true);
      $data = [
        'nama_tag' => ucwords($this->input->post('nama_tag_new', true)),
        'ket_tag' =>  $this->input->post('ket_tag_new', true),
      ];
      if($this->Admin_Model->updateTagCat($idTag, 'tags', $data)){
        $this->freeM->getSweetAlert('message', 'Horay!', 'Tag Produk berhasil diupdate.', 'success');
        redirect('dashboard/admin/add_tag');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Tag Produk gagal diupdate. Query Error!', 'error');
        redirect('dashboard/admin/add_tag');
      }
    }
  }

  public function updateCat()
  {
    $this->form_validation->set_rules('nama_cat_new', 'Nama Kategori', 'required|trim|min_length[3]|max_length[20]|alpha_numeric_spaces');
    $this->form_validation->set_rules('ket_cat_new', 'Keterangan Kategori', 'required|trim|min_length[8]|max_length[50]|alpha_numeric_spaces');
    if ($this->form_validation->run() == false) {
      $this->freeM->getSweetAlert('message', 'Upss!', 'Kategori Produk gagal diupdate. Perbaiki data inputan!', 'error');
      redirect('dashboard/admin/add_category');
    } else if ($this->form_validation->run() == true) {
      $idCat =  $this->input->post('id_cat_new', true);
      $data = [
        'nama_cat' => ucwords($this->input->post('nama_cat_new', true)),
        'ket_cat' =>  $this->input->post('ket_cat_new', true),
      ];
      if($this->Admin_Model->updateTagCat($idCat, 'kategori', $data)){
        $this->freeM->getSweetAlert('message', 'Horay!', 'Kategori Produk berhasil diupdate.', 'success');
        redirect('dashboard/admin/add_category');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Kategori Produk gagal diupdate. Query Error!', 'error');
        redirect('dashboard/admin/add_category');
      }
    }
  }

  public function updateCatParent()
  {
    $this->form_validation->set_rules('nama_cat_new', 'Nama Kategori', 'required|trim|min_length[3]|max_length[20]|alpha_numeric_spaces');
    if ($this->form_validation->run() == false) {
      $this->freeM->getSweetAlert('message', 'Upss!', 'Parent Kategori Produk gagal diupdate. Perbaiki data inputan!', 'error');
      redirect('dashboard/admin/add_category');
    } else if ($this->form_validation->run() == true) {
      $idCat =  $this->input->post('id_cat_new', true);
      $data = [
        'parent_kategori_nama' => ucwords($this->input->post('nama_cat_new', true))
      ];
      if($this->Admin_Model->updateCatParent($idCat, $data)){
        $this->freeM->getSweetAlert('message', 'Horay!', 'Parent Kategori Produk berhasil diupdate.', 'success');
        redirect('dashboard/admin/add_category');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Parent Kategori Produk gagal diupdate. Query Error!', 'error');
        redirect('dashboard/admin/add_category');
      }
    }
  }

  public function updateDataProduk()
  {
    $ukuran = $this->input->post('ukuran', true);
    $newUk = '';
    foreach ($ukuran as $uk) {
      $newUk .= $uk . ', ';
    }
    $id = clean($this->input->post('id_produk', true));
    $produk = [
      'nama_produk' => clean($this->input->post('nama', true)),
      'harga_produk' => clean($this->input->post('harga', true)),
    ];
    $detail = [
      'stok' => clean($this->input->post('stok', true)),
      'diskon' => clean($this->input->post('diskon', true)),
      'ukuran' => $newUk
    ];
    // var_dump([$produk, $detail]);die;
    if($this->Admin_Model->updateProduk($produk, $detail, $id)){
      $this->freeM->getSweetAlert('message', 'Horay!', 'Data Produk berhasil diupdate.', 'success');
      redirect('dashboard/admin/data_product','refresh');
    } else {
      $this->freeM->getSweetAlert('message', 'Upss!', 'Data Produk gagal diupdate.', 'error');
      redirect('dashboard/admin/data_product','refresh');
    }
  }

  public function data_orders()
  {
    $data['title'] = 'Data Pemesanan - Admin';
    $data['pending'] = $this->Admin_Model->getAllOrders('pending');
    $data['settlement'] = $this->Admin_Model->getAllOrders('settlement');
    $data['expired'] = $this->Admin_Model->getAllOrders('expire');
    $data['batalkan'] = $this->Admin_Model->getAllOrders('Dibatalkan');
    $data['totBayar'] = $this->Admin_Model->countOrders('settlement');
    $data['totPending'] = $this->Admin_Model->countOrders('pending');
    $data['totExpire'] = $this->Admin_Model->countOrders('expire');
    $data['totHari'] = $this->Admin_Model->countOrders();

    // echo '<pre>';
    // var_dump($data['orders']);
    // echo '</pre>';
    // die;
    $this->load->view('admin/orders/data_orders', $data);
  }

  public function inputResi()
  {
    $id = $this->input->post('id_orders', true);
    $resi = $this->input->post('no_resi', true);
    if($this->Admin_Model->inputResi($id, $resi)){

      $res = $this->Admin_Model->getInfoResiById($id); //get info pengiriman
      $dataEmail = [
        'id_orders' => $res['id_orders'],
        'nomerResi' => $res['nomer_resi'],
        'est' => ucwords($res['estimasi']),
        'kurir' => strtoupper($res['kurir']),
        'service' => strtoupper($res['service']),
        'nama' => ucwords($res['nama']),
        'email' => $res['email']
      ];

      $this->freeM->sendEmail($dataEmail, 'Nomer Resi Pengiriman '.$res['id_orders'],  EMAIL_FROM, 'input-resi'); //send email to customers
      $this->freeM->getSweetAlert('message', 'Horayy!', 'Nomer Resi Pengiriman berhasil diupdate.', 'success');
      redirect('dashboard/admin/data_orders');
    } else {
      $this->freeM->getSweetAlert('message', 'Upss!', 'Nomer Resi Pengiriman gagal diupdate.', 'error');
      redirect('dashboard/admin/data_orders');
    }
  }
  
  public function hapusResi($id)
  {
    ($id == null)? redirect('dashboard/admin/orders_pengiriman') : '' ;
    $resi = null;
    if($this->Admin_Model->inputResi($id, $resi)){
      $res = $this->Admin_Model->getInfoHapusResi($id); //get info pengiriman
      $dataEmail = [
        'id_orders' => $res['id_orders'],
        'nomerResi' => $res['nomer_resi'],
        'kurir' => strtoupper($res['kurir']),
        'service' => strtoupper($res['service']),
        'nama' => ucwords($res['nama']),
        'email' => $res['email']
      ];

      $this->freeM->sendEmail($dataEmail, 'Penghapusan Nomer Resi Pengiriman '.$res['id_orders'],  EMAIL_FROM, 'hapus-resi'); //send email to customers
      $this->freeM->getSweetAlert('message', 'Horayy!', 'Nomer Resi Pengiriman berhasil dihapus.', 'success');
      redirect('dashboard/admin/orders_pengiriman');
    } else {
      $this->freeM->getSweetAlert('message', 'Upss!', 'Nomer Resi Pengiriman gagal dihapus.', 'error');
      redirect('dashboard/admin/orders_pengiriman');
    }
  }

  public function orders_pengiriman()
  {
    $data['title'] = 'Data Pemesanan - Admin';
    $data['orders'] = $this->Admin_Model->getAllOrders('settlement', '!=');
    $data['totResi'] = $this->Admin_Model->countPengiriman();
    $this->load->view('admin/orders/orders_pengiriman', $data);
  }

  public function updateResi()
  {
    $id = $this->input->post('id_orders', true);
    $resi = $this->input->post('no_resi', true);
    if($this->Admin_Model->updateResi($id, $resi)){
      $res = $this->Admin_Model->getInfoResiById($id); //get info pengiriman
      $dataEmail = [
        'id_orders' => $res['id_orders'],
        'nomerResi' => $res['nomer_resi'],
        'est' => ucwords($res['estimasi']),
        'kurir' => strtoupper($res['kurir']),
        'service' => strtoupper($res['service']),
        'nama' => ucwords($res['nama']),
        'email' => $res['email']
      ];

      $this->freeM->sendEmail($dataEmail, 'Perubahan Nomer Resi Pengiriman '.$res['id_orders'],  EMAIL_FROM, 'update-resi'); //send email to customers
      $this->freeM->getSweetAlert('message', 'Horayy!', 'Nomer Resi Pengiriman berhasil diupdate!', 'success');
      redirect('dashboard/admin/orders_pengiriman');
    } else {
      $this->freeM->getSweetAlert('message', 'Upss!', 'Nomer Resi Pengiriman gagal diupdate!', 'error');
      redirect('dashboard/admin/orders_pengiriman');
    }
  }

  public function orders_done()
  {
    $data['title'] = 'Data Pemesanan - Admin';
    $data['orders'] = $this->Admin_Model->getOrdersDone();  
    $data['totSelesai'] = $this->Admin_Model->countDone();
    $this->load->view('admin/orders/orders_done', $data);
  }

  public function delete_admin($id = null)
  {
    if ($id != NULL) {
      if ($this->Admin_Model->deleteAdmin(decrypt_url($id))) {
        $this->freeM->getSweetAlert('message', 'Success!', 'Data admin berhasil di hapus!.', 'success');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Data admin gagal di hapus!', 'error');
      }
    } else {
      redirect('dashboard/admin/data_admin');
    }
    redirect('dashboard/admin/data_admin');
  }

  public function data_admin()
  {
    ($this->session->level == 'Admin')? redirect('dashboard/admin/customers'): '' ;
    $data['title'] = 'Data Admin - Owner';
    $data['admin'] = $this->Admin_Model->getAllAdmin();  
    $this->load->view('admin/customers/data_admin', $data);
  }

  public function tambah_admin()
  {
      ($this->session->level == 'Admin')? redirect('dashboard/admin/customers'): '' ;
      $data['title'] = 'Tambah Admin - Owner';
      $this->load->view('admin/customers/addAdmin', $data);
  }

  public function actionTambahAdmin()
  {
    ($this->session->level == 'Admin')? redirect('dashboard/admin/customers'): '' ;
    $this->form_validation->set_rules('email', 'Email Address', 'required|trim|valid_email|is_unique[data_user.email]');
    $this->form_validation->set_rules('nama', 'Nama Admin', 'required|trim|min_length[3]|max_length[20]|alpha_numeric_spaces');
    if($this->form_validation->run() == false){
      $this->freeM->getSweetAlert('message', 'Upss!', 'Email sudah dipakai atau email tidak valid!','error');
      redirect('dashboard/admin/tambah_admin');
    } else {
      $newPass = $this->input->post('PasswordBaru', true);
      $newPassFix = $this->input->post('fixPasswordBaru', true);
      if(strlen($newPass) < 8 OR strlen($newPass) >= 30){
        $this->freeM->getSweetAlert('message', 'Upss!', 'Password Min 8 karakter dan Max 30 karakter!', 'error');
        redirect('dashboard/admin/tambah_admin');
      } else {
        if($newPass != $newPassFix){
          $this->freeM->getSweetAlert('message', 'Upss!', 'Password baru dan konfirmasi password baru tidak sama!', 'error');
          redirect('dashboard/admin/tambah_admin');
        } else {
          $data = [
            'nama' => $this->input->post('nama', true),
            'email' => $this->input->post('email', true),
            'password' => password_hash($newPass, PASSWORD_DEFAULT),
            'level' => 'Admin'
          ];
          if($this->Admin_Model->tambahAdmin($data)){
            $this->freeM->getSweetAlert('message', 'Horayy!', 'Berhasil menambahkan admin.', 'success');
            redirect('dashboard/admin/tambah_admin');
          } else {
            $this->freeM->getSweetAlert('message', 'Upss!', 'Sistem error atau query salah!', 'error');
            redirect('dashboard/admin/tambah_admin');
          }
        }
      }
    }
  }

  public function pengaturan()
  {
    $data['title'] = 'Pengaturan Akun - Admin';
    $this->load->view('admin/setting/pengaturan', $data);
  }

  public function updateProfile()
  {
    $dataFoto = null;
    if( ($this->input->post('nama', true) == $this->session->nama AND 
        $this->input->post('email', true) == $this->session->email) AND
        empty($_FILES['foto']['name'])
      ){
      $this->freeM->getSweetAlert('message', 'Hemmm..','Data tidak berubah!','info');
      redirect('dashboard/admin/pengaturan');
    } else if(!empty($_FILES['foto']['name'])) {
      $dataFoto = $this->uploadFotoProfile();
    }

    $this->form_validation->set_rules('nama', 'Nama Baru', 'required|trim|min_length[3]|max_length[25]|alpha_numeric_spaces');
    if ($this->form_validation->run() == false) {
      $this->freeM->getSweetAlert('message', 'Upss!', 'Panjang Nama Max 25 Min 3!','error');
      redirect('dashboard/admin/pengaturan');
    } else if($this->form_validation->run() == true){
      $this->form_validation->set_rules('email', 'Email Address', 'required|trim|valid_email|is_unique[data_user.email]', [
        'is_unique' => 'Email ini sudah dipakai!'
      ]);
      if ($this->form_validation->run() == false) {
        if($this->input->post('email', true) == $this->session->email){
          $data = [
            'nama' => htmlspecialchars($this->input->post('nama', true)),
            'email' => $this->session->email
          ];
          if($this->Admin_Model->updateProfile($data, $dataFoto)){
            $this->freeM->getSweetAlert('message', 'Horayy!', 'Data diri anda berhasil diubah!','success');
            redirect('dashboard/admin/pengaturan');
          } else {
            $this->freeM->getSweetAlert('message', 'Upss!', 'Sistem error atau query salah!','error');
            redirect('dashboard/admin/pengaturan');
          }
        } else {
          $this->freeM->getSweetAlert('message', 'Upss!', 'Email sudah dipakai atau email tidak valid!','error');
          redirect('dashboard/admin/pengaturan');
        }
      } else {
        $data = [
          'nama' => htmlspecialchars($this->input->post('nama', true)),
          'email' => $this->session->email
        ];
        if($this->Admin_Model->updateProfile($data, $dataFoto)){
          $this->freeM->getSweetAlert('message', 'Horayy!', 'Data diri anda berhasil diubah!','success');
          redirect('dashboard/admin/pengaturan');
        } else {
          $this->freeM->getSweetAlert('message', 'Upss!', 'Sistem error atau query salah!','error');
          redirect('dashboard/admin/pengaturan');
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
      redirect('dashboard/admin/pengaturan');
    }
  }

  public function updateKeamanan()
  {
    $oldPass = $this->input->post('OldPassword', true);
    $newPass = $this->input->post('PasswordBaru', true);
    $newPassFix = $this->input->post('fixPasswordBaru', true);
    if(!password_verify($oldPass, $this->freeM->getPassword())){
      $this->freeM->getSweetAlert('message', 'Upss!', 'Password lama salah!', 'error');
      redirect('dashboard/admin/pengaturan');
    } else {
      if(strlen($newPass) < 8 OR strlen($newPass) >= 30){
        $this->freeM->getSweetAlert('message', 'Upss!', 'Password Min 8 karakter dan Max 30 karakter!', 'error');
        redirect('dashboard/admin/pengaturan');
      } else {
        if($newPass != $newPassFix){
          $this->freeM->getSweetAlert('message', 'Upss!', 'Password baru dan konfirmasi password baru tidak sama!', 'error');
          redirect('dashboard/admin/pengaturan');
        } else {
          $data = [
            'password' => password_hash($newPass, PASSWORD_DEFAULT)
          ];
          if($this->Admin_Model->updateKeamanan($data)){
            $this->freeM->getSweetAlertHref('updatePswSuccess', 'Horayy!', 'Password anda berhasil diubah! Silahkan login lagi.', 'success', base_url('auth/logout'));
            redirect('dashboard/admin/pengaturan');
          } else {
            $this->freeM->getSweetAlert('message', 'Upss!', 'Sistem error atau query salah!', 'error');
            redirect('dashboard/admin/pengaturan');
          }
        }
      }
    }
  }

  public function laporan_penjualan()
  {
    ($this->session->level == 'Admin')? redirect('dashboard/admin/customers'): '' ;
    $data['title'] = 'Laporan Penjualan';
    $data['laporan'] = $this->Admin_Model->getLaporanPenjualan();
    $this->load->view('admin/laporan/penjualan', $data);
  }

  public function setRangePenjualan()
  {
    $dari = $this->input->post('from_date', true);
    $sampai = $this->input->post('to_date', true);

    if($dari == NULL OR $sampai == NULL){
      $laporan = $this->Admin_Model->getLaporanPenjualan();
      foreach($laporan as $item):
        echo '<tr>
          <td class="text-center"> '.$item['tanggal_selesai'].' </td>
          <td class="text-center"> '.$item['jumlah_perhari'].' </td>
          <td>Rp  '.number_format($item['pendapatan'], 0, ',', '.').'  </td>
        </tr>';
        endforeach;
    } else {
      $laporan = $this->Admin_Model->getLaporanPenjualan($dari, $sampai);
      foreach($laporan as $item):
        echo '<tr>
          <td class="text-center"> '.$item['tanggal_selesai'].' </td>
          <td class="text-center"> '.$item['jumlah_perhari'].' </td>
          <td>Rp  '.number_format($item['pendapatan'], 0, ',', '.').'  </td>
        </tr>';
        endforeach;
      // echo '<pre>';
      // var_dump();
      // echo $this->db->last_query();
      // echo '</pre>';
    }
  }

  public function laporan_barang()
  {
    ($this->session->level == 'Admin')? redirect('dashboard/admin/customers'): '' ;
    $data['title'] = 'Laporan Barang';
    $data['laporan'] = $this->Admin_Model->getLaporanBarang();
    $this->load->view('admin/laporan/barang', $data);
  }

  public function setRangeBarang()
  {
    $dari = $this->input->post('from_date', true);
    $sampai = $this->input->post('to_date', true);

    if($dari == NULL OR $sampai == NULL){
      $laporan = $this->Admin_Model->getLaporanBarang();
      foreach($laporan as $item):
        echo '<tr>
          <td class="text-center">'. $item['tanggal_selesai'].'</td>
          <td >'.$item['nama_orders'].'</td>
          <td >'.$item['jumlah_perhari'].' penjualan</td>
          <td>'.$item['tot_barang'].' item</td>
        </tr>';
        endforeach;
    } else {
      $laporan = $this->Admin_Model->getLaporanBarang($dari, $sampai);
      foreach($laporan as $item):
        echo '<tr>
          <td class="text-center">'. $item['tanggal_selesai'].'</td>
          <td >'.$item['nama_orders'].'</td>
          <td >'.$item['jumlah_perhari'].' penjualan</td>
          <td>'.$item['tot_barang'].' item</td>
        </tr>';
        endforeach;
    }
  }

  public function laporan_pelanggan()
  {
    ($this->session->level == 'Admin')? redirect('dashboard/admin/customers'): '' ;
    $data['title'] = 'Laporan Pelanggan';
    $data['laporan'] = $this->Admin_Model->getLaporanPelanggan();
      //     echo '<pre>';
      // var_dump($data['laporan']);
      // echo $this->db->last_query();
      // echo '</pre>'; die();
    $this->load->view('admin/laporan/pelanggan', $data);
  }

  public function setRangePelanggan()
  {
    $dari = $this->input->post('from_date', true);
    $sampai = $this->input->post('to_date', true);

    if($dari == NULL OR $sampai == NULL){
      $laporan = $this->Admin_Model->getLaporanPelanggan();
      foreach($laporan as $item):
        echo '<tr>
          <td class="text-center">'.$item['id_user'].'</td>
          <td >'.$item['nama'].'</td>
          <td>'.$item['provinsi'].'</td>
          <td>'.$item['kabupaten'].'</td>
          <td>'.$item['tanggal_lahir'].'</td>
          <td >'.date('d/m/Y H:i',$item['create_date']).'</td>
          <td>'.$item['jumlah_beli'] .' pesanan</td>
          <td>Rp '.number_format($item['tot_beli'], 0, ',', '.').'</td>
        </tr>';
        endforeach;
    } else {
      $laporan = $this->Admin_Model->getLaporanPelanggan($dari, $sampai);
      foreach($laporan as $item):
        echo '<tr>
          <td class="text-center">'.$item['id_user'].'</td>
          <td >'.$item['nama'].'</td>
          <td>'.$item['provinsi'].'</td>
          <td>'.$item['kabupaten'].'</td>
          <td>'.$item['tanggal_lahir'].'</td>
          <td >'.date('d/m/Y H:i',$item['create_date']).'</td>
          <td>'.$item['jumlah_beli'] .' pesanan</td>
          <td>Rp '.number_format($item['tot_beli'], 0, ',', '.').'</td>
        </tr>';
        endforeach;
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
    $dataChartPesan = $this->Admin_Model->getDataChartPemesanan();
    foreach($dataChartPesan as $tgl => $val){
      for($i=0; $i < 10; $i++){
        if($val['tanggal_selesai'] == $dataUrut[$i]['tanggal_selesai']){
          $dataUrut[$i]['jumlah_beli'] = $val['jumlah_beli'];
        }
      }
    }

    return $dataUrut;

        // echo '<pre>';
        // var_dump($dataUrut);
        // echo '</pre>';
        // echo '<pre>';
        // var_dump($this->Admin_Model->getDataChartPemesanan());
        // echo '</pre>'; die();
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
    $dataChartPesan = $this->Admin_Model->getDataChartPenjualan();
    foreach($dataChartPesan as $tgl => $val){
      for($i=0; $i < 10; $i++){
        if($val['tanggal_selesai'] == $dataUrut[$i]['tanggal_selesai']){
          $dataUrut[$i]['jumlah_pendapatan'] = $val['jumlah_pendapatan'];
        }
      }
    }

    return $dataUrut;
  }

  public function setOrderItem()
  {
    $id = $this->input->post('id_orders', true);
    $data = $this->Admin_Model->getOrderItem($id);
    $newData['nama'] = explode(',', $data[0]['all_nama']);
    $newData['harga'] = explode(',', $data[0]['each_harga']);
    $newData['diskon'] = explode(',', $data[0]['each_diskon']);
    $newData['qty'] = explode(',', $data[0]['each_qty']);
    $newData['ukuran'] = explode(',', $data[0]['each_ukuran']);

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
  }

  public function nonaktif_admin($id)
  {
    if ($id != NULL) {
      if ($this->Admin_Model->nonaktifAdmin(decrypt_url($id), 0)) {
        $this->freeM->getSweetAlert('message', 'Success!', 'Admin berhasil di nonaktifkan!.', 'success');
        redirect('dashboard/admin/data_admin', 'refresh');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Admin gagal di nonaktifkan!', 'error');
        redirect('dashboard/admin/data_admin', 'refresh');
      }
    } else {
      redirect('dashboard/admin/data_admin', 'refresh');
    }
    
  }

  public function aktif_admin($id)
  {
    if ($id != NULL) {
      if ($this->Admin_Model->nonaktifAdmin(decrypt_url($id), 1)) {
        $this->freeM->getSweetAlert('message', 'Success!', 'Admin berhasil di aktifkan!.', 'success');
        redirect('dashboard/admin/data_admin', 'refresh');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Admin gagal di aktifkan!', 'error');
        redirect('dashboard/admin/data_admin', 'refresh');
      }
    } else {
      redirect('dashboard/admin/data_admin', 'refresh');
    }
  }

  public function remiderUserKonfirmasi($id = null)
  {
    ($id == null)? redirect('dashboard/admin/orders_pengiriman'): '';
    $res = $this->Admin_Model->getInfoResiById($id); //get info pengiriman
    $dataEmail = [
      'id_orders' => $res['id_orders'],
      'nomerResi' => $res['nomer_resi'],
      'est' => ucwords($res['estimasi']),
      'kurir' => strtoupper($res['kurir']),
      'service' => strtoupper($res['service']),
      'nama' => ucwords($res['nama']),
      'email' => $res['email'],
      'id_trx'  => $res['transaction_id']
    ];
    if($this->Admin_Model->updateNotifPenerimaan($id)){
        $this->freeM->sendEmail($dataEmail, 'Konfirmasi Penerimaan Barang '.$id, EMAIL_FROM,'notif-terkirim');
        $this->freeM->getSweetAlert('message', 'Success!', 'Pemberitahuan konfirmasi barang diterima berhasil dikirim!', 'success');
        redirect('dashboard/admin/orders_pengiriman');
      } else {
        $this->freeM->getSweetAlert('message', 'Upss!', 'Pemberitahuan konfirmasi barang diterima gagal dikirim! Query Error!', 'error');
        redirect('dashboard/admin/orders_pengiriman');
      }
  }

  public function batalkanPesanan()
  {
    $data = [
      'id_orders' =>  $this->input->post('id_orders_batalkan', true),
      'alasan' =>  $this->input->post('alasan_batal', true)
    ];
    if($this->Admin_Model->getBatalkanOrders($data)){
      $res = $this->Admin_Model->getInfoByIdOrders($data['id_orders']); //get info pengiriman
      $dataEmail = [
        'id_orders' => $res['id_orders'],
        'nama' => ucwords($res['nama']),
        'email' => $res['email'],
        'keterangan' => $res['keterangan']
      ];
      $this->freeM->sendEmail($dataEmail, 'Pembatalan Pemesanan '.$dataEmail['id_orders'], EMAIL_FROM,'notif-batalkan');
      $this->freeM->getSweetAlert('message', 'Success!', 'Pembatalan pemesanan berhasil!', 'success');
      redirect('dashboard/admin/data_orders');
    } else {
      $this->freeM->getSweetAlert('message', 'Upss!', 'Pembatalan pemesanan gagal!', 'error');
      redirect('dashboard/admin/data_orders');
    }
  }

}
