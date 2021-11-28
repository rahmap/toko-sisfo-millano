<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pesan extends CI_Controller {

    public function __construct() {
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

    public function kirim_pesan_template1($id_segment = null)
		{
			if(empty($id_segment)){ redirect('dashboard/segmentasi/get_list_segment'); }

			$this->load->model(['Pesan_Model' => 'P_M']);
			$dataArray = [
				'judulKecil' => strtoupper($this->input->post('judulKecil')),
				'judulBesar' => strtoupper($this->input->post('judulBesar')),
				'urlGambar' => $this->input->post('urlGambar'),
				'judulProduk' => ucwords($this->input->post('judulProduk')),
				'keteranganProduk' => ucfirst($this->input->post('keteranganProduk')),
				'titleTombol' => ucwords($this->input->post('titleTombol')),
				'urlProduk' => $this->input->post('urlProduk'),
				'judulEmail' => ucwords($this->input->post('judulEmail'))
			];
			if(isset($_POST['jadwalTanggal']) AND !empty($_POST['jadwalTanggal'])){
				$jadwal = $this->input->post('jadwalTanggal').' '.$this->input->post('jadwalJam');
			} else {
				$jadwal = NULL;
			}
			$dataPenjadwalan = [
				'pesan_dijadwalkan_pada' => $jadwal,
				'pesan_dijadwalkan_status' => ($this->input->post('jadwal') == 'sekarang') ? 1 : 0
			];
//			dd($this->input->post());
			$dataSegment = $this->db->get_where('segmentasi', ['segmentasi_id' => $id_segment])->row_array();
			if($ID_PESAN = $this->P_M->insertDataPesanTemplate1($dataArray, $dataPenjadwalan, $id_segment)){
				if($dataPenjadwalan['pesan_dijadwalkan_status'] == 1){
					$this->freeM->sendSegmentasi($dataArray['judulEmail'], $dataArray, $ID_PESAN, 'segment_1_product');
					$this->freeM->getSweetAlert('message', 'Success!', 'Berhasil mengirim Pesan. Segmentasi : '.$dataSegment['segmentasi_nama'],
					'success');
				} else {
					$this->freeM->getSweetAlert('message', 'Success!', 'Penjadwalan Pesan berhasil dibuat. Segmentasi : '.$dataSegment['segmentasi_nama'],
					'info');
				}
			} else {
				$this->freeM->getSweetAlert('message', 'Upss!', 'Gagal mengirim Pesan. Segmentasi : '.$dataSegment['segmentasi_nama'],
					'error');
			}
			redirect('dashboard/segmentasi/get_list_segment');
		}
        
        
		public function kirim_pesan_template2($id_segment = null)
		{
			if(empty($id_segment)){ redirect('dashboard/segmentasi/get_list_segment'); }

			$this->load->model(['Pesan_Model' => 'P_M']);
			$dataArray = [
				'judulKecil' => strtoupper($this->input->post('judulKecil')),
				'judulBesar' => strtoupper($this->input->post('judulBesar')),
				'urlGambar1' => $this->input->post('urlGambar'),
				'urlGambar2' => $this->input->post('urlGambar1'),
				'namaProduk1' => ucwords($this->input->post('judulProduk')),
				'namaProduk2' => ucwords($this->input->post('judulProduk1')),
				'ketProduk1' => ucfirst($this->input->post('keteranganProduk')),
				'ketProduk2' => ucfirst($this->input->post('keteranganProduk1')),
				'urlProduk1' => $this->input->post('urlProduk'),
				'urlProduk2' => $this->input->post('urlProduk1'),
				'judulEmail' => ucwords($this->input->post('judulEmail'))
			];
			if(isset($_POST['jadwalTanggal']) AND !empty($_POST['jadwalTanggal'])){
				$jadwal = $this->input->post('jadwalTanggal').' '.$this->input->post('jadwalJam');
			} else {
				$jadwal = NULL;
			}
			$dataPenjadwalan = [
				'pesan_dijadwalkan_pada' => $jadwal,
				'pesan_dijadwalkan_status' => ($this->input->post('jadwal') == 'sekarang') ? 1 : 0
			];
		//			dd($this->input->post());
			$dataSegment = $this->db->get_where('segmentasi', ['segmentasi_id' => $id_segment])->row_array();
			if($ID_PESAN = $this->P_M->insertDataPesanTemplate2($dataArray, $dataPenjadwalan, $id_segment)){
				if($dataPenjadwalan['pesan_dijadwalkan_status'] == 1){
					$this->freeM->sendSegmentasi($dataArray['judulEmail'], $dataArray, $ID_PESAN, 'segment_2_product');
					$this->freeM->getSweetAlert('message', 'Success!', 'Berhasil mengirim Pesan. Segmentasi : '.$dataSegment['segmentasi_nama'],
						'success');
				} else {
					$this->freeM->getSweetAlert('message', 'Success!', 'Penjadwalan Pesan berhasil dibuat. Segmentasi : '.$dataSegment['segmentasi_nama'],
						'info');
				}
			} else {
				$this->freeM->getSweetAlert('message', 'Upss!', 'Gagal mengirim Pesan. Segmentasi : '.$dataSegment['segmentasi_nama'],
					'error');
			}
			redirect('dashboard/segmentasi/get_list_segment');
		}

		public function all_kirim_pesan_template1()
		{
			$this->load->model(['Pesan_Model' => 'P_M']);
			$dataArray = [
				'judulKecil' => strtoupper($this->input->post('judulKecil')),
				'judulBesar' => strtoupper($this->input->post('judulBesar')),
				'urlGambar' => $this->input->post('urlGambar'),
				'judulProduk' => ucwords($this->input->post('judulProduk')),
				'keteranganProduk' => ucfirst($this->input->post('keteranganProduk')),
				'titleTombol' => ucwords($this->input->post('titleTombol')),
				'urlProduk' => $this->input->post('urlProduk'),
				'judulEmail' => ucwords($this->input->post('judulEmail'))
			];
			if(isset($_POST['jadwalTanggal']) AND !empty($_POST['jadwalTanggal'])){
				$jadwal = $this->input->post('jadwalTanggal').' '.$this->input->post('jadwalJam');
			} else {
				$jadwal = NULL;
			}
			$dataPenjadwalan = [
				'pesan_dijadwalkan_pada' => $jadwal,
				'pesan_dijadwalkan_status' => ($this->input->post('jadwal') == 'sekarang') ? 1 : 0
			];
		//			dd($this->input->post());
			if($ID_PESAN = $this->P_M->allInsertDataPesanTemplate1($dataArray, $dataPenjadwalan)){
				if($dataPenjadwalan['pesan_dijadwalkan_status'] == 1){
					$this->freeM->sendSegmentasiAll($dataArray['judulEmail'], $dataArray, $ID_PESAN, 'segment_1_product');
					$this->freeM->getSweetAlert('message', 'Success!', 'Berhasil mengirim Pesan ke semua pelanggan.',
						'success');
				} else {
					$this->freeM->getSweetAlert('message', 'Success!', 'Penjadwalan Pesan berhasil dibuat ke semua pelanggan.',
						'info');
				}
			} else {
				$this->freeM->getSweetAlert('message', 'Upss!', 'Gagal mengirim Pesan ke semua pelanggan.',
					'error');
			}
			redirect('dashboard/segmentasi/get_list_segment');
		}

		public function all_kirim_pesan_template2()
	{
		$this->load->model(['Pesan_Model' => 'P_M']);
		$dataArray = [
			'judulKecil' => strtoupper($this->input->post('judulKecil')),
			'judulBesar' => strtoupper($this->input->post('judulBesar')),
			'urlGambar1' => $this->input->post('urlGambar'),
			'urlGambar2' => $this->input->post('urlGambar1'),
			'namaProduk1' => ucwords($this->input->post('judulProduk')),
			'namaProduk2' => ucwords($this->input->post('judulProduk1')),
			'ketProduk1' => ucfirst($this->input->post('keteranganProduk')),
			'ketProduk2' => ucfirst($this->input->post('keteranganProduk1')),
			'urlProduk1' => $this->input->post('urlProduk'),
			'urlProduk2' => $this->input->post('urlProduk1'),
			'judulEmail' => ucwords($this->input->post('judulEmail'))
		];
		if(isset($_POST['jadwalTanggal']) AND !empty($_POST['jadwalTanggal'])){
			$jadwal = $this->input->post('jadwalTanggal').' '.$this->input->post('jadwalJam');
		} else {
			$jadwal = NULL;
		}
		$dataPenjadwalan = [
			'pesan_dijadwalkan_pada' => $jadwal,
			'pesan_dijadwalkan_status' => ($this->input->post('jadwal') == 'sekarang') ? 1 : 0
		];
//			dd($this->input->post());
		if($ID_PESAN = $this->P_M->allInsertDataPesanTemplate2($dataArray, $dataPenjadwalan)){
			if($dataPenjadwalan['pesan_dijadwalkan_status'] == 1){
				$this->freeM->sendSegmentasiAll($dataArray['judulEmail'], $dataArray, $ID_PESAN, 'segment_2_product');
				$this->freeM->getSweetAlert('message', 'Success!', 'Berhasil mengirim Pesan ke semua pelanggan.',
					'success');
			} else {
				$this->freeM->getSweetAlert('message', 'Success!', 'Penjadwalan Pesan berhasil dibuat ke semua pelanggan.',
					'info');
			}
		} else {
			$this->freeM->getSweetAlert('message', 'Upss!', 'Gagal mengirim Pesan ke semua pelanggan.',
				'error');
		}
		redirect('dashboard/segmentasi/get_list_segment');
	}

		public function all_kirim_pesan_manual()
		{
			$this->load->model(['Pesan_Model' => 'P_M']);
			$dataArray = [
				'pesan_html_text' => $this->input->post('pesan_html'),
				'judulEmail' => ucwords($this->input->post('judulEmail'))
			];
			if(isset($_POST['jadwalTanggal']) AND !empty($_POST['jadwalTanggal'])){
				$jadwal = $this->input->post('jadwalTanggal').' '.$this->input->post('jadwalJam');
			} else {
				$jadwal = NULL;
			}
			$dataPenjadwalan = [
				'pesan_dijadwalkan_pada' => $jadwal,
				'pesan_dijadwalkan_status' => ($this->input->post('jadwal') == 'sekarang') ? 1 : 0
			];

			if($ID_PESAN = $this->P_M->insertDataPesanManualAll($dataArray, $dataPenjadwalan)){
				if($dataPenjadwalan['pesan_dijadwalkan_status'] == 1){
					$this->freeM->sendSegmentasiManualAll($dataArray['judulEmail'], $ID_PESAN);
					$this->freeM->getSweetAlert('message', 'Success!', 'Berhasil mengirim Pesan ke semua pelanggan.',
						'success');
				} else {
					$this->freeM->getSweetAlert('message', 'Success!', 'Penjadwalan Pesan berhasil dibuat ke semua pelanggan.',
						'info');
				}
			} else {
				$this->freeM->getSweetAlert('message', 'Upss!', 'Gagal mengirim Pesan ke semua pelanggan.',
					'error');
			}
			redirect('dashboard/segmentasi/get_list_segment');
		}

		public function kirim_pesan_manual($id_segment = null)
		{
			if(empty($id_segment)){ redirect('dashboard/segmentasi/get_list_segment'); }

			$this->load->model(['Pesan_Model' => 'P_M']);
			$dataArray = [
				'pesan_html_text' => $this->input->post('pesan_html'),
				'judulEmail' => ucwords($this->input->post('judulEmail'))
			];
			if(isset($_POST['jadwalTanggal']) AND !empty($_POST['jadwalTanggal'])){
				$jadwal = $this->input->post('jadwalTanggal').' '.$this->input->post('jadwalJam');
			} else {
				$jadwal = NULL;
			}
			$dataPenjadwalan = [
				'pesan_dijadwalkan_pada' => $jadwal,
				'pesan_dijadwalkan_status' => ($this->input->post('jadwal') == 'sekarang') ? 1 : 0
			];
//			dd($this->input->post());
			$dataSegment = $this->db->get_where('segmentasi', ['segmentasi_id' => $id_segment])->row_array();
			if($ID_PESAN = $this->P_M->insertDataPesanManual($dataArray, $dataPenjadwalan, $id_segment)){
				if($dataPenjadwalan['pesan_dijadwalkan_status'] == 1){
					$this->freeM->sendSegmentasiManual($dataArray['judulEmail'], $ID_PESAN);
					$this->freeM->getSweetAlert('message', 'Success!', 'Berhasil mengirim Pesan. Segmentasi : '.$dataSegment['segmentasi_nama'],
						'success');
				} else {
					$this->freeM->getSweetAlert('message', 'Success!', 'Penjadwalan Pesan berhasil dibuat. Segmentasi : '.$dataSegment['segmentasi_nama'],
						'info');
				}
			} else {
				$this->freeM->getSweetAlert('message', 'Upss!', 'Gagal mengirim Pesan. Segmentasi : '.$dataSegment['segmentasi_nama'],
					'error');
			}
			redirect('dashboard/segmentasi/get_list_segment');
		}

		public function get_list_pesan()
		{
			$this->load->model(['Pesan_Model' => 'P_M']);
			$data = [
				'title' => 'List Pesan - Admin',
				'dataPesan' => $this->P_M->getDataPesan()
			];
//			dd($data);
			return $this->load->view('dashboard/pesan/list_pesan', $data);
		}

		public function detail($idPesan)
		{
			if(empty($idPesan)){ redirect('dashboard/Segmentasi/get_list_pesan'); }

			$this->load->model(['Pesan_Model' => 'P_M']);
			$data = [
				'title' => 'Detail Pesan - Admin',
				'dataPesan' => $this->P_M->getDetailPesan($idPesan),
				'statistikPesan' => $this->P_M->getStatistikPesan($idPesan),
				'pesan' => $this->db->get_where('pesan_html', ['pesan_html_id' => $idPesan])->row_array()
			];
//			dd($data);
			return $this->load->view('dashboard/pesan/detail_pesan', $data);
		}
		

}
