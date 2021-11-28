<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_Model extends CI_Model
{
    public function regisUser($data)
    {
        $this->db->insert('data_user', $data);
        if ($this->db->affected_rows()) {
            $this->db->join('detail_user', 'detail_user.id_user=data_user.id_user');
            $id = $this->db->get_where('data_user', ['email' => $data['email']])->row_array(); //pakai insert_id juga bisa
            $this->db->where(['id_user' => $id['id_user']]);
            $this->db->update('detail_user', ['create_date' => time()]);
            return 1;
        } else {
            return 0;
        }
    }

    public function loginUser($email)
    {
        $this->db->join('detail_user', 'detail_user.id_user=data_user.id_user');
        $data = $this->db->get_where('data_user', ['email' => $email])->row_array();
        if($data['delete_at'] == NULL){
            return $data;
        } else {
            return NULL;
        }
    }

}
