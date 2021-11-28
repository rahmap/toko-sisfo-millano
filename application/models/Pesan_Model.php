<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesan_Model extends CI_Model
{

	public function insertDataPesanTemplate1($data, $jadwal, $id_segment)
	{
		$newArray = serialize($data);
		$this->db->insert('pesan_html',[
			'pesan_html_type' => PESAN_1_PRODUK,
			'pesan_html_title' => ucwords($data['judulEmail']),
			'pesan_html_data' => $newArray,
			'pesan_html_text' => NULL,
			'pesan_dijadwalkan_pada' => $jadwal['pesan_dijadwalkan_pada'],
			'pesan_dijadwalkan_status' => $jadwal['pesan_dijadwalkan_status'],
			'fk_segmentasi' => $id_segment,
			'has_segment' => 1
		]);
		if($this->db->affected_rows()){
     return $this->db->insert_id();
		}
		return 0;
	}

	public function insertDataPesanManual($data, $jadwal, $id_segment)
	{
		$this->db->insert('pesan_html',[
			'pesan_html_type' => PESAN_MANUAL,
			'pesan_html_title' => ucwords($data['judulEmail']),
			'pesan_html_data' => NULL,
			'pesan_html_text' => $data['pesan_html_text'],
			'pesan_dijadwalkan_pada' => $jadwal['pesan_dijadwalkan_pada'],
			'pesan_dijadwalkan_status' => $jadwal['pesan_dijadwalkan_status'],
			'fk_segmentasi' => $id_segment,
			'has_segment' => 1
		]);
		if($this->db->affected_rows()){
     return $this->db->insert_id();
		}
		return 0;
	}

	public function insertDataPesanManualAll($data, $jadwal)
	{
		$this->db->insert('pesan_html',[
			'pesan_html_type' => PESAN_MANUAL,
			'pesan_html_title' => ucwords($data['judulEmail']),
			'pesan_html_data' => NULL,
			'pesan_html_text' => $data['pesan_html_text'],
			'pesan_dijadwalkan_pada' => $jadwal['pesan_dijadwalkan_pada'],
			'pesan_dijadwalkan_status' => $jadwal['pesan_dijadwalkan_status'],
			'fk_segmentasi' => $id_segment,
			'has_segment' => 0
		]);
		if($this->db->affected_rows()){
     return $this->db->insert_id();
		}
		return 0;
	}

	public function allInsertDataPesanTemplate1($data, $jadwal)
	{
		$newArray = serialize($data);
		$this->db->insert('pesan_html',[
			'pesan_html_type' => PESAN_1_PRODUK,
			'pesan_html_title' => ucwords($data['judulEmail']),
			'pesan_html_data' => $newArray,
			'pesan_html_text' => NULL,
			'pesan_dijadwalkan_pada' => $jadwal['pesan_dijadwalkan_pada'],
			'pesan_dijadwalkan_status' => $jadwal['pesan_dijadwalkan_status'],
			'fk_segmentasi' => NULL,
			'has_segment' => 0
		]);
		if($this->db->affected_rows()){
     return $this->db->insert_id();
		}
		return 0;
	}

	public function allInsertDataPesanTemplate2($data, $jadwal)
	{
		$newArray = serialize($data);
		$this->db->insert('pesan_html',[
			'pesan_html_type' => PESAN_2_PRODUK,
			'pesan_html_title' => ucwords($data['judulEmail']),
			'pesan_html_data' => $newArray,
			'pesan_html_text' => NULL,
			'pesan_dijadwalkan_pada' => $jadwal['pesan_dijadwalkan_pada'],
			'pesan_dijadwalkan_status' => $jadwal['pesan_dijadwalkan_status'],
			'fk_segmentasi' => NULL,
			'has_segment' => 0
		]);
		if($this->db->affected_rows()){
     return $this->db->insert_id();
		}
		return 0;
	}




	public function insertDataPesanTemplate2($data, $jadwal, $id_segment)
	{
		$newArray = serialize($data);
		$this->db->insert('pesan_html',[
			'pesan_html_type' => PESAN_2_PRODUK,
			'pesan_html_title' => ucwords($data['judulEmail']),
			'pesan_html_data' => $newArray,
			'pesan_html_text' => NULL,
			'pesan_dijadwalkan_pada' => $jadwal['pesan_dijadwalkan_pada'],
			'pesan_dijadwalkan_status' => $jadwal['pesan_dijadwalkan_status'],
			'fk_segmentasi' => $id_segment,
			'has_segment' => 1
		]);
		if($this->db->affected_rows()){
			return $this->db->insert_id();
		}
		return 0;
	}



	public function getDataPesan()
	{
		$this->db->select(['has_segment','pesan_html_id','segmentasi.segmentasi_nama','pesan_html_title','pesan_html_type','pesan_dijadwalkan_pada',
			'pesan_dijadwalkan_status','segmentasi_id',
			'SUM(pesan_delivered) / COUNT(pesan_data_user.fk_pesan_html) * 100 AS sumDelivered',
			'SUM(pesan_clicked) / COUNT(pesan_data_user.fk_pesan_html) * 100 AS sumClicked',
			'SUM(pesan_opened) / COUNT(pesan_data_user.fk_pesan_html) * 100 AS sumOpened',
			'COUNT(pesan_data_user.fk_pesan_html) as jmlPenerima']);
		$this->db->join('segmentasi','segmentasi.segmentasi_id=pesan_html.fk_segmentasi','LEFT');
		$this->db->join('pesan_data_user','pesan_data_user.fk_pesan_html=pesan_html.pesan_html_id','LEFT');
		$this->db->group_by('pesan_html.pesan_html_id');
		return $this->db->get('pesan_html')->result_array();
	}

	public function getDetailPesan($id)
	{
		$this->db->where('fk_pesan_html', $id);
		$this->db->join('data_user','data_user.id_user=pesan_data_user.fk_user');
		return $this->db->get('pesan_data_user')->result_array();
	}

	public function getStatistikPesan($id)
	{
		$this->db->select([
			'SUM(pesan_delivered) / COUNT(pesan_data_user.fk_pesan_html) * 100 AS sumDelivered',
			'SUM(pesan_clicked) / COUNT(pesan_data_user.fk_pesan_html) * 100 AS sumClicked',
			'SUM(pesan_opened) / COUNT(pesan_data_user.fk_pesan_html) * 100 AS sumOpened',
			'COUNT(pesan_data_user.fk_pesan_html) as jmlPenerima'
		]);
		$this->db->where('fk_pesan_html', $id);
		$this->db->group_by('pesan_data_user.fk_pesan_html');
		return $this->db->get('pesan_data_user')->row_array();
	}

}
