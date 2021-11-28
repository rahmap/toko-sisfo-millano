<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_Model extends CI_Model
{
	public function getAllAdmin()
	{
		$this->db->join('detail_user', 'detail_user.id_user=data_user.id_user', 'INNER');
		return $this->db->get_where('data_user', ['data_user.level' => 'Admin'])->result_array();
	}

	public function tambahAdmin($data)
	{
		$this->db->insert('data_user', $data);
		if ($this->db->affected_rows()) {
			$this->db->join('detail_user', 'detail_user.id_user=data_user.id_user');
			$id = $this->db->get_where('data_user', ['email' => $data['email']])->row_array();
			$this->db->where(['id_user' => $id['id_user']]);
			$this->db->update('detail_user', ['create_date' => time()]);
			return 1;
		} else {
			return 0;
		}
	}

	public function deleteAdmin($id)
	{
		$this->db->delete('data_user', ['id_user' => $id]);
		return $this->db->affected_rows();
	}

	public function nonaktifAdmin($id, $aktif)
	{
		$this->db->update('detail_user', ['is_active' => $aktif], ['id_user' => $id]);
		return $this->db->affected_rows();
	}

	public function getAllOwner()
	{
		$this->db->join('detail_user', 'detail_user.id_user=data_user.id_user', 'INNER');
		return $this->db->get_where('data_user', ['data_user.level' => 'Owner'])->result_array();
	}

	public function tambahOwner($data)
	{
		$this->db->insert('data_user', $data);
		if ($this->db->affected_rows()) {
			$this->db->join('detail_user', 'detail_user.id_user=data_user.id_user');
			$id = $this->db->get_where('data_user', ['email' => $data['email']])->row_array();
			$this->db->where(['id_user' => $id['id_user']]);
			$this->db->update('detail_user', ['create_date' => time()]);
			return 1;
		} else {
			return 0;
		}
	}

	public function deleteOwner($id)
	{
		$this->db->delete('data_user', ['id_user' => $id]);
		return $this->db->affected_rows();
	}

	public function nonaktifOwner($id, $aktif)
	{
		$this->db->update('detail_user', ['is_active' => $aktif], ['id_user' => $id]);
		return $this->db->affected_rows();
	}

	public function updateOwner($data, $id)
	{
		$this->db->where(['id_user' => $id]);
		$this->db->update('data_user', $data);
		return $this->db->affected_rows();
	}

	public function getDetailOwner($id)
	{
		$this->db->join('detail_user', 'detail_user.id_user=data_user.id_user', 'INNER');
		return $this->db->get_where('data_user', ['data_user.id_user' => $id])->row_array();
	}

	public function updateAdmin($data, $id)
	{
		$this->db->where(['id_user' => $id]);
		$this->db->update('data_user', $data);
		return $this->db->affected_rows();
	}

	public function getDetailAdmin($id)
	{
		$this->db->join('detail_user', 'detail_user.id_user=data_user.id_user', 'INNER');
		return $this->db->get_where('data_user', ['data_user.id_user' => $id])->row_array();
	}

	public function updateProfile($data, $dataFoto = null)
	{

		$dataDiri = [
			'nama' => $data['nama'],
			'email' => $data['email'],
		];

		$this->db->update('data_user', $dataDiri, ['id_user' => $this->session->id_user]);
		if ($dataFoto != null) {
			$foto['foto'] = $dataFoto;
			$this->db->update('detail_user', $foto, ['id_user' => $this->session->id_user]);
		}
		// die($this->db->last_query());
		if ($this->db->affected_rows()) {
			$this->session->nama = $data['nama'];
			$this->session->email = $data['email'];
			return 1;
		} else {
			return 0;
		}
	}

	public function updateKeamanan($data)
	{
		$this->db->update('data_user', $data, ['id_user' => $this->session->id_user]);
		return $this->db->affected_rows();
	}
}
