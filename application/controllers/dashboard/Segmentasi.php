<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Segmentasi extends CI_Controller {

    public function __construct() {
			parent::__construct();
		
			$this->load->library('form_validation');
			$this->load->library('upload');
			$this->load->model(['Admin_Model','Segmentasi_Model' => 'S_M']);
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

    public function create_segment(){
//    		dd($this->S_M->getUserAge());
    		$data = [
    			'title' => 'Buat Segmentasi - Admin',
					'user_age' => $this->S_M->getUserAge(),
					'user_prov' => $this->S_M->getUserProv(),
					'user_kab' => $this->S_M->getUserKab(),
					'user_gender' => $this->S_M->getUserGender()
				];
        return $this->load->view('dashboard/segmentasi/create_segment', $data);
    }

		public function create_segment_save(){
			if($this->input->post()){
				
				if($this->S_M->save_segmentasi($this->input->post())){
					$this->freeM->getSweetAlert('message', 'Success!', 'Berhasil membuat segmentasi.','success');
				} else {
					$this->freeM->getSweetAlert('message', 'Upss!', 'Gagal membuat segmentasi.','error');
				}
				redirect('dashboard/segmentasi/create_segment');
			} else {
				redirect('dashboard/segmentasi/create_segment');
			}
		}

		public function get_list_segment()
		{
			$data = [
				'title' => 'List Segmentasi - Admin',
				'segmentasi' => $this->S_M->getListSegmentasi()
			];
			return $this->load->view('dashboard/segmentasi/list_segment', $data);
		}

		public function delete_segment(){
			$segment = $this->input->get('id');
			if(empty($segment)){ redirect('dashboard/Segmentasi/get_list_segment'); }
			if($this->S_M->deleteSegmentasi($segment)){
				$this->freeM->getSweetAlert('message', 'Success!', 'Berhasil menghapus segmentasi.','success');
			} else {
				$this->freeM->getSweetAlert('message', 'Upss!', 'Gagal menghapus segmentasi.','error');
			}
			redirect('dashboard/Segmentasi/get_list_segment');
		}

		public function kirim_pesan_manual($id_segment = NULL)
		{
			if(empty($id_segment)){ redirect('dashboard/Segmentasi/get_list_segment'); }

			$data = [
				'title' => 'Kirim Pesan - Admin',
				'segmentasi' => $this->db->get_where('segmentasi', ['segmentasi_id' => $id_segment])->row_array()
			];
			return $this->load->view('dashboard/pesan/buat_pesan_manual', $data);
		}

	public function all_kirim_pesan_manual()
	{

		$data = [
			'title' => 'Kirim Pesan - Admin'
		];
		return $this->load->view('dashboard/pesan/all_buat_pesan_manual', $data);
	}

		public function kirim_pesan_template($id_template = NULL, $id_segment = NULL)
		{
			if(empty($id_segment) OR empty($id_template) OR $id_template != '1' AND $id_template != '2'){
				redirect('dashboard/Segmentasi/get_list_segment');
			}

			$data = [
				'title' => 'Kirim Pesan - Admin',
				'segmentasi' => $this->db->get_where('segmentasi', ['segmentasi_id' => $id_segment])->row_array()
			];
			if($id_template == 1){
				return $this->load->view('dashboard/pesan/buat_pesan_template_1', $data);
			} else {
				return $this->load->view('dashboard/pesan/buat_pesan_template_2', $data);
			}
		}

		public function all_kirim_pesan_template($id_template = NULL)
		{
			if(empty($id_template) OR $id_template != '1' AND $id_template != '2'){
				redirect('dashboard/Segmentasi/get_list_segment');
			}

			$data = [
				'title' => 'Kirim Pesan - Admin'
			];
			if($id_template == 1){
				return $this->load->view('dashboard/pesan/all_buat_pesan_template_1', $data);
			} else {
				return $this->load->view('dashboard/pesan/all_buat_pesan_template_2', $data);
			}
		}

		public function kirim_pesan_post($id_segment = NULL)
		{
			if($this->input->post()){
				dd($this->input->post());
			} else {
				redirect('dashboard/segmentasi/kirim_pesan');
			}
		}

		public function lihat_penerima($idSegment)
		{
			$segment = $this->db->get_where('segmentasi', ['segmentasi_id' => $idSegment])->row_array();
			$data = [
				'title' => 'Daftar Penerima - Admin',
				'segmentasi' => $segment,
				'dataPenerima' => $this->db->query($segment['segmentasi_query'])->result_array()
			];
//			dd($data);
			return $this->load->view('dashboard/segmentasi/list_penerima', $data);
		}

}
