<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Segmentasi_Model extends CI_Model
{

	public function getUserProv()
	{
		$this->db->distinct();
		$this->db->select('provinsi');
		$this->db->join('detail_user', 'detail_user.id_user=data_user.id_user');
		$this->db->where('detail_user.is_active', '1');
		$this->db->order_by('data_user.provinsi', 'ASC');
		return $this->db->get_where('data_user', ['data_user.level' => 'Member'])->result_array();
	}

	public function getUserKab()
	{
		$this->db->distinct();
		$this->db->select('kabupaten');
		$this->db->join('detail_user', 'detail_user.id_user=data_user.id_user');
		$this->db->where('detail_user.is_active', '1');
		$this->db->order_by('data_user.kabupaten', 'ASC');
		return $this->db->get_where('data_user', ['data_user.level' => 'Member'])->result_array();
	}

	public function getUserAge()
	{
		$this->db->distinct();
		$this->db->select('user_age');
		$this->db->join('detail_user', 'detail_user.id_user=data_user.id_user');
		$this->db->where('detail_user.is_active', '1');
		$this->db->order_by('data_user.user_age', 'ASC');
		return $this->db->get_where('data_user', ['data_user.level' => 'Member'])->result_array();
	}

	public function getUserGender()
	{
		$this->db->distinct();
		$this->db->select('gender');
		$this->db->join('detail_user', 'detail_user.id_user=data_user.id_user');
		$this->db->where('detail_user.is_active', '1');
		$this->db->order_by('data_user.gender', 'ASC');
		return $this->db->get_where('data_user', ['data_user.level' => 'Member'])->result_array();
	}

	public function save_segmentasi($form)
	{
		$ketegori = '';
		$rumus = '';
		$this->db->select(['data_user.*',
			'COUNT(pesan_data_user.fk_user) AS countUserPesan',
			'(SUM(pesan_delivered) + SUM(pesan_clicked) + SUM(pesan_opened)) / COUNT(pesan_data_user.fk_user) AS sumScore'], FALSE);
		if($form['match'] == 'AND'){
			if(!empty($form['operasiUmur'])){
				$this->db->where('data_user.user_age '.$form['operasiUmur'], $form['parameterUmur']);
				$ketegori .= 'Umur, ';
				$rumus.= 'Umur '.$form['operasiUmur'].' '.$form['parameterUmur'].', ';
			}
			if(!empty($form['operasiProvinsi'])){
				$this->db->where('data_user.provinsi '.$form['operasiProvinsi'], $form['parameterProvinsi']);
				$ketegori .= 'Provinsi, ';
				$rumus.= 'Provinsi '.$form['operasiProvinsi'].' '.$form['parameterProvinsi'].', ';
			}
			if(!empty($form['operasiKabupaten'])){
				$this->db->where('data_user.kabupaten '.$form['operasiKabupaten'], $form['parameterKabupaten']);
				$ketegori .= 'Kabupaten, ';
				$rumus.= 'Kabupaten '.$form['operasiKabupaten'].' '.$form['parameterKabupaten'].', ';
			}
			if(!empty($form['operasiGender'])){
				$this->db->where('data_user.gender '.$form['operasiGender'], $form['parameterGender']);
				$ketegori .= 'Gender, ';
				$rumus.= 'Gender '.$form['operasiGender'].' '.$form['parameterGender'].', ';
			}
			if(!empty($form['operasiRating'])){
				$this->db->having('sumScore '.$form['operasiRating'], $form['parameterRating']);
				$ketegori .= 'Rating, ';
				$rumus.= 'Rating '.$form['operasiRating'].' '.$form['parameterRating'].', ';
			}
		} else {
			if(!empty($form['operasiUmur'])){
				$this->db->or_where('data_user.user_age '.$form['operasiUmur'], $form['parameterUmur']);
				$ketegori .= 'Umur, ';
				$rumus.= 'Umur '.$form['operasiUmur'].' '.$form['parameterUmur'].', ';
			}
			if(!empty($form['operasiProvinsi'])){
				$this->db->or_where('data_user.provinsi '.$form['operasiProvinsi'], $form['parameterProvinsi']);
				$ketegori .= 'Provinsi, ';
				$rumus.= 'Provinsi '.$form['operasiProvinsi'].' '.$form['parameterProvinsi'].', ';
			}
			if(!empty($form['operasiKabupaten'])){
				$this->db->or_where('data_user.kabupaten '.$form['operasiKabupaten'], $form['parameterKabupaten']);
				$ketegori .= 'Kabupaten, ';
				$rumus.= 'Kabupaten '.$form['operasiKabupaten'].' '.$form['parameterKabupaten'].', ';
			}
			if(!empty($form['operasiGender'])){
				$this->db->or_where('data_user.gender '.$form['operasiGender'], $form['parameterGender']);
				$ketegori .= 'Gender, ';
				$rumus.= 'Gender '.$form['operasiGender'].' '.$form['parameterGender'].', ';
			}
			if(!empty($form['operasiRating'])){
				$this->db->or_having('sumScore '.$form['operasiRating'], $form['parameterRating']);
				$ketegori .= 'Rating, ';
				$rumus.= 'Rating '.$form['operasiRating'].' '.$form['parameterRating'].', ';
			}
		}
		$this->db->join('detail_user','detail_user.id_user=data_user.id_user');
		$this->db->join('pesan_data_user','pesan_data_user.fk_user=data_user.id_user','LEFT');
		$this->db->where('detail_user.is_active', 1);
		$this->db->where('detail_user.delete_at', NULL);
		$this->db->where('data_user.level', 'Member');
		$this->db->group_by('data_user.id_user');
		$this->db->get('data_user')->result_array();

		$lastQuery = $this->db->last_query();
//		dd($lastQuery);
		$this->db->insert('segmentasi', [
			'segmentasi_nama' => ucwords($form['namaSegmentasi']),
			'segmentasi_keterangan' => ucfirst($form['keteranganSegmentasi']),
			'segmentasi_kategori' => substr($ketegori,0, strlen($ketegori)-2),
			'segmentasi_match' => $form['match'],
			'segmentasi_rumus' => substr($rumus,0, strlen($rumus)-2),
			'segmentasi_query' => $lastQuery
		]);
		return $this->db->affected_rows();
	}

	public function getListSegmentasi()
	{
		return $this->db->get('segmentasi')->result_array();
	}

	public function deleteSegmentasi($id)
	{
		$this->db->where('segmentasi_id', $id);
		$this->db->delete('segmentasi');
		return $this->db->affected_rows();
	}

}
