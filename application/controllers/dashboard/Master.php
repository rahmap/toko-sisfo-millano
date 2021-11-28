<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->library('upload');
		$this->load->model(['Master_Model' => 'M_M']);
		if ($this->session->has_userdata('email')) {
			if ($this->session->level != 'Master') {
				redirect('home');
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
			'title' => APP_NAME.' - Welcome Master'
		];
		$this->load->view('master/v_master_welcome', $data);
	}

	public function tambah_admin()
	{
		$data = [
			'title' => APP_NAME.' - Tambahkan Admin'
		];
		$this->load->view('master/add_admin', $data);
	}

	public function actionTambahAdmin()
	{
		$this->form_validation->set_rules('email', 'Email Address', 'required|trim|valid_email|is_unique[data_user.email]');
		$this->form_validation->set_rules('nama', 'Nama Admin', 'required|trim|min_length[3]|max_length[20]|alpha_numeric_spaces');
		if($this->form_validation->run() == false){
			$this->freeM->getSweetAlert('message', 'Upss!', 'Email sudah dipakai atau email tidak valid!','error');
			redirect('dashboard/master/tambah_admin');
		} else {
			$newPass = $this->input->post('PasswordBaru', true);
			$newPassFix = $this->input->post('fixPasswordBaru', true);
			if(strlen($newPass) < 8 OR strlen($newPass) >= 30){
				$this->freeM->getSweetAlert('message', 'Upss!', 'Password Min 8 karakter dan Max 30 karakter!', 'error');
				redirect('dashboard/master/tambah_admin');
			} else {
				if($newPass != $newPassFix){
					$this->freeM->getSweetAlert('message', 'Upss!', 'Password baru dan konfirmasi password baru tidak sama!', 'error');
					redirect('dashboard/master/tambah_admin');
				} else {
					$data = [
						'nama' => ucwords($this->input->post('nama', true)),
						'email' => $this->input->post('email', true),
						'password' => password_hash($newPass, PASSWORD_DEFAULT),
						'level' => 'Admin'
					];
					if($this->M_M->tambahAdmin($data)){
						$this->freeM->getSweetAlert('message', 'Horayy!', 'Berhasil menambahkan admin.', 'success');
						redirect('dashboard/master/tambah_admin');
					} else {
						$this->freeM->getSweetAlert('message', 'Upss!', 'Sistem error atau query salah!', 'error');
						redirect('dashboard/master/tambah_admin');
					}
				}
			}
		}
	}

	public function data_admin()
	{
		$data['title'] = APP_NAME.' - Data Admin';
		$data['admin'] = $this->M_M->getAllAdmin();
		$this->load->view('master/data_admin', $data);
	}

	public function delete_admin($id = null)
	{
		if ($id != NULL) {
			if ($this->M_M->deleteAdmin(decrypt_url($id))) {
				$this->freeM->getSweetAlert('message', 'Success!', 'Data admin berhasil di hapus!.', 'success');
			} else {
				$this->freeM->getSweetAlert('message', 'Upss!', 'Data admin gagal di hapus!', 'error');
			}
		} else {
			redirect('dashboard/master/data_admin');
		}
		redirect('dashboard/master/data_admin');
	}

	public function nonaktif_admin($id = null)
	{
		if ($id != NULL) {
			if ($this->M_M->nonaktifAdmin(decrypt_url($id), 0)) {
				$this->freeM->getSweetAlert('message', 'Success!', 'Admin berhasil di nonaktifkan!.', 'success');
				redirect('dashboard/master/data_admin', 'refresh');
			} else {
				$this->freeM->getSweetAlert('message', 'Upss!', 'Admin gagal di nonaktifkan!', 'error');
				redirect('dashboard/master/data_admin', 'refresh');
			}
		} else {
			redirect('dashboard/master/data_admin', 'refresh');
		}

	}

	public function aktif_admin($id = null)
	{
		if ($id != NULL) {
			if ($this->M_M->nonaktifAdmin(decrypt_url($id), 1)) {
				$this->freeM->getSweetAlert('message', 'Success!', 'Admin berhasil di aktifkan!.', 'success');
				redirect('dashboard/master/data_admin', 'refresh');
			} else {
				$this->freeM->getSweetAlert('message', 'Upss!', 'Admin gagal di aktifkan!', 'error');
				redirect('dashboard/master/data_admin', 'refresh');
			}
		} else {
			redirect('dashboard/master/data_admin', 'refresh');
		}
	}

	public function tambah_owner()
	{
		$data = [
			'title' => APP_NAME.' - Tambahkan Owner'
		];
		$this->load->view('master/add_owner', $data);
	}

	public function actionTambahOwner()
	{
		$this->form_validation->set_rules('email', 'Email Address', 'required|trim|valid_email|is_unique[data_user.email]');
		$this->form_validation->set_rules('nama', 'Nama Owner', 'required|trim|min_length[3]|max_length[20]|alpha_numeric_spaces');
		if($this->form_validation->run() == false){
			$this->freeM->getSweetAlert('message', 'Upss!', 'Email sudah dipakai atau email tidak valid!','error');
			redirect('dashboard/master/tambah_owner');
		} else {
			$newPass = $this->input->post('PasswordBaru', true);
			$newPassFix = $this->input->post('fixPasswordBaru', true);
			if(strlen($newPass) < 8 OR strlen($newPass) >= 30){
				$this->freeM->getSweetAlert('message', 'Upss!', 'Password Min 8 karakter dan Max 30 karakter!', 'error');
				redirect('dashboard/master/tambah_owner');
			} else {
				if($newPass != $newPassFix){
					$this->freeM->getSweetAlert('message', 'Upss!', 'Password baru dan konfirmasi password baru tidak sama!', 'error');
					redirect('dashboard/master/tambah_owner');
				} else {
					$data = [
						'nama' => ucwords($this->input->post('nama', true)),
						'email' => $this->input->post('email', true),
						'password' => password_hash($newPass, PASSWORD_DEFAULT),
						'level' => 'Owner'
					];
					if($this->M_M->tambahOwner($data)){
						$this->freeM->getSweetAlert('message', 'Horayy!', 'Berhasil menambahkan owner.', 'success');
						redirect('dashboard/master/tambah_owner');
					} else {
						$this->freeM->getSweetAlert('message', 'Upss!', 'Sistem error atau query salah!', 'error');
						redirect('dashboard/master/tambah_owner');
					}
				}
			}
		}
	}

	public function data_owner()
	{
		$data['title'] = APP_NAME.' - Data Owner';
		$data['owner'] = $this->M_M->getAllOwner();
		$this->load->view('master/data_owner', $data);
	}

	public function delete_owner($id = null)
	{
		if ($id != NULL) {
			if ($this->M_M->deleteOwner(decrypt_url($id))) {
				$this->freeM->getSweetAlert('message', 'Success!', 'Data owner berhasil di hapus!.', 'success');
			} else {
				$this->freeM->getSweetAlert('message', 'Upss!', 'Data owner gagal di hapus!', 'error');
			}
		} else {
			redirect('dashboard/master/data_owner');
		}
		redirect('dashboard/master/data_owner');
	}

	public function nonaktif_owner($id = null)
	{
		if ($id != NULL) {
			if ($this->M_M->nonaktifOwner(decrypt_url($id), 0)) {
				$this->freeM->getSweetAlert('message', 'Success!', 'Owner berhasil di nonaktifkan!.', 'success');
				redirect('dashboard/master/data_owner', 'refresh');
			} else {
				$this->freeM->getSweetAlert('message', 'Upss!', 'Owner gagal di nonaktifkan!', 'error');
				redirect('dashboard/master/data_owner', 'refresh');
			}
		} else {
			redirect('dashboard/master/data_owner', 'refresh');
		}

	}

	public function aktif_owner($id = null)
	{
		if ($id != NULL) {
			if ($this->M_M->nonaktifOwner(decrypt_url($id), 1)) {
				$this->freeM->getSweetAlert('message', 'Success!', 'Owner berhasil di aktifkan!.', 'success');
				redirect('dashboard/master/data_owner', 'refresh');
			} else {
				$this->freeM->getSweetAlert('message', 'Upss!', 'Owner gagal di aktifkan!', 'error');
				redirect('dashboard/master/data_owner', 'refresh');
			}
		} else {
			redirect('dashboard/master/data_owner', 'refresh');
		}
	}

	public function update_owner($id = null)
	{
		if(!empty($id)){
			$dataOwner = $this->M_M->getDetailOwner(($id));
			$data = [
				'title' => APP_NAME.' - Update Data Owner',
				'owner' => $dataOwner
			];
			$this->load->view('master/update_owner', $data);
		} else {
			redirect('dashboard/master/data_owner', 'refresh');
		}
	}

	public function actionUpdateOwner($id = null)
	{
		if(!empty($id)){
			$newPass = '';
			$this->form_validation->set_rules('nama', 'Nama Owner', 'required|trim|min_length[3]|max_length[20]|alpha_numeric_spaces');
			if($this->input->post('PasswordBaru') AND $this->input->post('fixPasswordBaru')){
				if(!empty($_POST['PasswordBaru']) OR !empty($_POST['fixPasswordBaru'])){
					$this->form_validation->set_rules('fixPasswordBaru', 'Konfirmasi Password Baru', 'required|trim|min_length[3]|max_length[20]|matches[PasswordBaru]');
					$this->form_validation->set_rules('PasswordBaru', 'Password Baru', 'required|trim|min_length[3]|max_length[20]|matches[fixPasswordBaru]');
					$newPass = password_hash($this->input->post('PasswordBaru', true), PASSWORD_DEFAULT);
				} else {
					$dataOwner = $this->M_M->getDetailOwner(($id));
					$newPass = $dataOwner['password'];
				}
			} else {
				$dataOwner = $this->M_M->getDetailOwner(($id));
				$newPass = $dataOwner['password'];
			}
			if($this->form_validation->run() == false){
				$this->freeM->getAlertBSAdmin('messageForm', 'danger', 'Data Tidak Benar!', validation_errors());
				redirect('dashboard/master/update_owner/'.$id);
			} else {
				$data = [
					'nama' => ucwords($this->input->post('nama', true)),
					'password' => $newPass
				];
				if($this->M_M->updateOwner($data, ($id))){
					$this->freeM->getSweetAlert('message', 'Horayy!', 'Berhasil mengupdate data owner.', 'success');
					redirect('dashboard/master/update_owner/'.$id);
				} else {
					$this->freeM->getSweetAlert('message', 'Upss!', 'Sistem error atau query salah!', 'error');
					redirect('dashboard/master/update_owner/'.$id);
				}
			}
		} else {
			redirect('dashboard/master/data_owner', 'refresh');
		}
	}

	public function update_admin($id = null)
	{
		if(!empty($id)){
			$dataAdmin = $this->M_M->getDetailAdmin(($id));
			$data = [
				'title' => APP_NAME.' - Update Data Admin',
				'admin' => $dataAdmin
			];
			$this->load->view('master/update_admin', $data);
		} else {
			redirect('dashboard/master/data_admin', 'refresh');
		}
	}

	public function actionUpdateAdmin($id = null)
	{
		if(!empty($id)){
			$newPass = '';
			$this->form_validation->set_rules('nama', 'Nama Admin', 'required|trim|min_length[3]|max_length[20]|alpha_numeric_spaces');
			if($this->input->post('PasswordBaru') AND $this->input->post('fixPasswordBaru')){
				if(!empty($_POST['PasswordBaru']) OR !empty($_POST['fixPasswordBaru'])){
					$this->form_validation->set_rules('fixPasswordBaru', 'Konfirmasi Password Baru', 'required|trim|min_length[3]|max_length[20]|matches[PasswordBaru]');
					$this->form_validation->set_rules('PasswordBaru', 'Password Baru', 'required|trim|min_length[3]|max_length[20]|matches[fixPasswordBaru]');
					$newPass = password_hash($this->input->post('PasswordBaru', true), PASSWORD_DEFAULT);
				} else {
					$dataAdmin = $this->M_M->getDetailAdmin(($id));
					$newPass = $dataAdmin['password'];
				}
			} else {
				$dataAdmin = $this->M_M->getDetailAdmin(($id));
				$newPass = $dataAdmin['password'];
			}
			if($this->form_validation->run() == false){
				$this->freeM->getAlertBSAdmin('messageForm', 'danger', 'Data Tidak Benar!', validation_errors());
				redirect('dashboard/master/update_admin/'.$id);
			} else {
				$data = [
					'nama' => ucwords($this->input->post('nama', true)),
					'password' => $newPass
				];
				if($this->M_M->updateAdmin($data, ($id))){
					$this->freeM->getSweetAlert('message', 'Horayy!', 'Berhasil mengupdate data admin.', 'success');
					redirect('dashboard/master/update_admin/'.$id);
				} else {
					$this->freeM->getSweetAlert('message', 'Upss!', 'Sistem error atau query salah!', 'error');
					redirect('dashboard/master/update_admin/'.$id);
				}
			}
		} else {
			redirect('dashboard/master/data_admin', 'refresh');
		}
	}

	public function pengaturan()
	{
		$data['title'] = 'Pengaturan Akun - Master';
		$this->load->view('master/setting/pengaturan', $data);
	}

	public function updateProfile()
	{
		$dataFoto = null;
		if( ($this->input->post('nama', true) == $this->session->nama AND
				$this->input->post('email', true) == $this->session->email) AND
			empty($_FILES['foto']['name'])
		){
			$this->freeM->getSweetAlert('message', 'Hemmm..','Data tidak berubah!','info');
			redirect('dashboard/master/pengaturan');
		} else if(!empty($_FILES['foto']['name'])) {
			$dataFoto = $this->uploadFotoProfile();
		}

		$this->form_validation->set_rules('nama', 'Nama Baru', 'required|trim|min_length[3]|max_length[25]|alpha_numeric_spaces');
		if ($this->form_validation->run() == false) {
			$this->freeM->getSweetAlert('message', 'Upss!', 'Panjang Nama Max 25 Min 3!','error');
			redirect('dashboard/master/pengaturan');
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
					if($this->M_M->updateProfile($data, $dataFoto)){
						$this->freeM->getSweetAlert('message', 'Horayy!', 'Data diri anda berhasil diubah!','success');
						redirect('dashboard/master/pengaturan');
					} else {
						$this->freeM->getSweetAlert('message', 'Upss!', 'Sistem error atau query salah!','error');
						redirect('dashboard/master/pengaturan');
					}
				} else {
					$this->freeM->getSweetAlert('message', 'Upss!', 'Email sudah dipakai atau email tidak valid!','error');
					redirect('dashboard/master/pengaturan');
				}
			} else {
				$data = [
					'nama' => htmlspecialchars($this->input->post('nama', true)),
					'email' => $this->session->email
				];
				if($this->M_M->updateProfile($data, $dataFoto)){
					$this->freeM->getSweetAlert('message', 'Horayy!', 'Data diri anda berhasil diubah!','success');
					redirect('dashboard/master/pengaturan');
				} else {
					$this->freeM->getSweetAlert('message', 'Upss!', 'Sistem error atau query salah!','error');
					redirect('dashboard/master/pengaturan');
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
			redirect('dashboard/master/pengaturan');
		}
	}

	public function updateKeamanan()
	{
		$oldPass = $this->input->post('OldPassword', true);
		$newPass = $this->input->post('PasswordBaru', true);
		$newPassFix = $this->input->post('fixPasswordBaru', true);
		if(!password_verify($oldPass, $this->freeM->getPassword())){
			$this->freeM->getSweetAlert('message', 'Upss!', 'Password lama salah!', 'error');
			redirect('dashboard/master/pengaturan');
		} else {
			if(strlen($newPass) < 8 OR strlen($newPass) >= 30){
				$this->freeM->getSweetAlert('message', 'Upss!', 'Password Min 8 karakter dan Max 30 karakter!', 'error');
				redirect('dashboard/master/pengaturan');
			} else {
				if($newPass != $newPassFix){
					$this->freeM->getSweetAlert('message', 'Upss!', 'Password baru dan konfirmasi password baru tidak sama!', 'error');
					redirect('dashboard/master/pengaturan');
				} else {
					$data = [
						'password' => password_hash($newPass, PASSWORD_DEFAULT)
					];
					if($this->M_M->updateKeamanan($data)){
						$this->freeM->getSweetAlertHref('updatePswSuccess', 'Horayy!', 'Password anda berhasil diubah! Silahkan login lagi.', 'success', base_url('auth/logout'));
						redirect('dashboard/master/pengaturan');
					} else {
						$this->freeM->getSweetAlert('message', 'Upss!', 'Sistem error atau query salah!', 'error');
						redirect('dashboard/master/pengaturan');
					}
				}
			}
		}
	}
}
