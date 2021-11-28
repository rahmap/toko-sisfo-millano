<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesan_Data_User_Model extends CI_Model
{

	public function updateDataTracking($data)
	{
		$mailgunUniqueId = $data['event-data']['user-variables']['pesan_data_user_unique_id'];
		if($data['event-data']['event'] == 'delivered'){
			$this->db->where('pesan_data_user_unique_id', $mailgunUniqueId);
			$this->db->update('pesan_data_user', ['pesan_delivered' => 1]);
		} else if($data['event-data']['event'] == 'opened') {
			$this->db->where('pesan_data_user_unique_id', $mailgunUniqueId);
			$this->db->update('pesan_data_user', ['pesan_opened' => 1]);
		} else if($data['event-data']['event'] == 'clicked'){
			$this->db->where('pesan_data_user_unique_id', $mailgunUniqueId);
			$this->db->update('pesan_data_user', ['pesan_clicked' => 1]);
		}

		return $this->db->affected_rows();
	}

}
