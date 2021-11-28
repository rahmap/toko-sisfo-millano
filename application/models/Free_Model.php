<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Free_Model extends CI_Model
{

    private $namaFlash;

    public function getInfoUser()
    {
        $this->db->join('detail_user', 'detail_user.id_user=data_user.id_user');
        return $this->db->get_where('data_user', ['data_user.id_user' => $this->session->id_user])->row_array();
    }

    public function getImageUser()
    {
        $img = $this->getInfoUser();
        return  $img['foto'];
    }

    public function getDateJoin()
    {
        $joinAt = $this->getInfoUser();
        return  $joinAt['create_date'];
    }

    public function getPassword()
    {
        $password = $this->getInfoUser();
        return  $password['password'];
    }

    public function getAlertBS($namaFlash, $jenis, $judul, $pesan)
    {
        return  $this->session->set_flashdata($namaFlash, '<div class="alert alert-' . $jenis . ' alert-dismissible fade show" role="alert">
        <strong>' . $judul . '</strong> ' . $pesan . '.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
    }

    public function getAlertBSAdmin($namaFlash, $jenis, $judul, $pesan)
    {

        return  $this->session->set_flashdata($namaFlash, '<div class="alert alert-' . $jenis . ' alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        <strong>' . $judul . '</strong> ' . $pesan . '.
        </div>');
    }

    public function getSweetAlert($namaFlash, $title = '', $text = '', $type = '')
    {
        return  $this->session->set_flashdata($namaFlash, "<script>
		var title = '$title';
		var text = '$text'; 
		var type = '$type';
			Swal.fire(title,text,type);
		</script>");
    }


    public function getSweetAlertHref($namaFlash, $title = '', $text = '', $type = '', $href = '')
    {
        return  $this->session->set_flashdata($namaFlash, "<script>
		var title = '$title';
		var text = '$text'; 
		var type = '$type';
			Swal.fire(title,text,type).then(function() {
              window.location = '$href';
          });
		</script>");
    }

    public function getUnikProduk($id)
    {
        $this->db->select_max('id_produk', 'max');
        $data = $this->db->get('produk')->row_array();
        $nama = $this->db->get_where('kategori', ['id_cat' => $id])->row_array();
        $noUrut = substr($data['max'], 0, 6);
        $noUrut++;
        return strtoupper($nama['nama_cat']) . sprintf("%06s", $noUrut);
    }

    public function cek_ajax()
    {
      if(!$this->input->is_ajax_request()){
        die('mdfk');
      }
    }

	public function sendEmail($data, $subject, $from, $file)
	{
		//Jika tidak mau pake Mailgun, mungkin bisa di ganti pake Email sender dari CI nya
		($data == null)? die('DATA KOSONG'): '';
		if(MAILGUN == 'TRUE'){
			$this->load->library('mailgun');
			$this->mailgun->initialize(array(
				'apikey' => API_MAILGUN, //Ganti dengan key anda
				'domain' => DOMAIN_MAILGUN, //Ganti dengan domain anda, cek config/Constants.php,
				'user-variables' => [
					'id_segmentasi' => 2
				]
			));

			$this->mailgun->from($from, APP_NAME);
			$this->mailgun->to($data['email'], $data['nama']);
			$this->mailgun->subject($subject);
			$this->mailgun->message($this->load->view('email/'.$file, $data, TRUE));

			return $this->mailgun->send();
		} else {
			$this->load->library('email');

			$body = $this->load->view('email/'.$file, $data, TRUE);

			$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => SMTP_HOST,
				'smtp_port' => SMTP_PORT,
				'smtp_user' => $from,
				'smtp_pass' => SMTP_PASS,
				'mailtype'  => 'html',
				'charset'   =>'utf-8',
				'wordwrap'  => TRUE,
				'smtp_timeout' => 30
			);

			$this->email->initialize($config);
			// $this->email->set_newline("\r\n");
			// $this->email->set_header('MIME-Version', '1.0; charset=utf-8');
			// $this->email->set_header('Content-type', 'text/html');

			$this->email->from($from, APP_NAME);
			$this->email->to($data['email']);
			$this->email->subject($subject);
			$this->email->message($body);

			return $this->email->send();
		}
	}

	public function sendSegmentasi($subject, $dataTemplate, $PK_Pesan, $file)
	{
		$this->load->library('mailgun');
		$rowPesan = $this->db->get_where('pesan_html', ['pesan_html_id' => $PK_Pesan ])->row_array();
		$querySegmentasi = $this->db->get_where('segmentasi', ['segmentasi_id' => $rowPesan['fk_segmentasi']])
			->row_array();
		$dataUser = $this->db
			->query($querySegmentasi['segmentasi_query'])->result_array();
		foreach($dataUser as $DU):
			$unique_pesan = uniqid();
			$this->mailgun->initialize(array(
				'apikey' => API_MAILGUN, //Ganti dengan key anda
				'domain' => DOMAIN_MAILGUN, //Ganti dengan domain anda, cek config/Constants.php,
				'user-variables' => [
					'fk_pesan' => $PK_Pesan,
					'pesan_data_user_unique_id' => $unique_pesan
				]
			));
//		$this->load->model(['Segmentasi_Model' => 'S_M','Pesan_Model' => 'P_M']);

//		dd($dataUser);

			$this->mailgun->from(getenv('EMAIL_FROM'), APP_NAME);
			$this->mailgun->to($DU['email'], $DU['nama']);
			$this->mailgun->subject($subject);
			$this->mailgun->message($this->load->view('email/segmentasi/'.$file, $dataTemplate, TRUE));

			$this->mailgun->send();
			$this->db->insert('pesan_data_user', [
				'pesan_data_user_unique_id' => $unique_pesan,
				'fk_user' => $DU['id_user'],
				'fk_pesan_html' => $PK_Pesan,
				'pesan_delivered' => 0,
				'pesan_clicked' => 0,
				'pesan_opened' => 0,
				'pesan_data_user_created_at' => date('Y-m-d H:i:s')
			]);

		endforeach;
		return 1;
	}

	public function sendSegmentasiAll($subject, $dataTemplate, $PK_Pesan, $file)
	{
		$this->load->library('mailgun');
		$dataUser = $this->db
			->select(['nama','email','data_user.id_user'])
			->join('detail_user', 'detail_user.id_user=data_user.id_user')
			->where('detail_user.is_active', 1)
			->where('detail_user.delete_at', NULL)
			->where('data_user.level', 'Member')
			->get('data_user')->result_array();
		foreach($dataUser as $DU):
			$unique_pesan = uniqid();
			$this->mailgun->initialize(array(
				'apikey' => API_MAILGUN, //Ganti dengan key anda
				'domain' => DOMAIN_MAILGUN, //Ganti dengan domain anda, cek config/Constants.php,
				'user-variables' => [
					'fk_pesan' => $PK_Pesan,
					'pesan_data_user_unique_id' => $unique_pesan
				]
			));

			$this->mailgun->from(getenv('EMAIL_FROM'), APP_NAME);
			$this->mailgun->to($DU['email'], $DU['nama']);
			$this->mailgun->subject($subject);
			$this->mailgun->message($this->load->view('email/segmentasi/'.$file, $dataTemplate, TRUE));

			$this->mailgun->send();
			$this->db->insert('pesan_data_user', [
				'pesan_data_user_unique_id' => $unique_pesan,
				'fk_user' => $DU['id_user'],
				'fk_pesan_html' => $PK_Pesan,
				'pesan_delivered' => 0,
				'pesan_clicked' => 0,
				'pesan_opened' => 0,
				'pesan_data_user_created_at' => date('Y-m-d H:i:s')
			]);

		endforeach;
		return 1;
	}

	public function sendSegmentasiManual($subject, $PK_Pesan)
	{
		$this->load->library('mailgun');
		$rowPesan = $this->db->get_where('pesan_html', ['pesan_html_id' => $PK_Pesan ])->row_array();
		$querySegmentasi = $this->db->get_where('segmentasi', ['segmentasi_id' => $rowPesan['fk_segmentasi']])
			->row_array();
		$dataUser = $this->db
			->query($querySegmentasi['segmentasi_query'])->result_array();
		foreach($dataUser as $DU):
			$unique_pesan = uniqid();
			$this->mailgun->initialize(array(
				'apikey' => API_MAILGUN, //Ganti dengan key anda
				'domain' => DOMAIN_MAILGUN, //Ganti dengan domain anda, cek config/Constants.php,
				'user-variables' => [
					'fk_pesan' => $PK_Pesan,
					'pesan_data_user_unique_id' => $unique_pesan
				]
			));

			$this->mailgun->from(getenv('EMAIL_FROM'), APP_NAME);
			$this->mailgun->to($DU['email'], $DU['nama']);
			$this->mailgun->subject($subject);
			$this->mailgun->message($rowPesan['pesan_html_text']);

			$this->mailgun->send();
			$this->db->insert('pesan_data_user', [
				'pesan_data_user_unique_id' => $unique_pesan,
				'fk_user' => $DU['id_user'],
				'fk_pesan_html' => $PK_Pesan,
				'pesan_delivered' => 0,
				'pesan_clicked' => 0,
				'pesan_opened' => 0,
				'pesan_data_user_created_at' => date('Y-m-d H:i:s')
			]);

		endforeach;
		return 1;
	}

	public function sendSegmentasiManualAll($subject, $PK_Pesan)
	{
		$this->load->library('mailgun');
		$rowPesan = $this->db->get_where('pesan_html', ['pesan_html_id' => $PK_Pesan ])->row_array();
		$dataUser = $this->db
			->select(['nama','email','data_user.id_user'])
			->join('detail_user', 'detail_user.id_user=data_user.id_user')
			->where('detail_user.is_active', 1)
			->where('detail_user.delete_at', NULL)
			->where('data_user.level', 'Member')
			->get('data_user')->result_array();
		foreach($dataUser as $DU):
			$unique_pesan = uniqid();
			$this->mailgun->initialize(array(
				'apikey' => API_MAILGUN, //Ganti dengan key anda
				'domain' => DOMAIN_MAILGUN, //Ganti dengan domain anda, cek config/Constants.php,
				'user-variables' => [
					'fk_pesan' => $PK_Pesan,
					'pesan_data_user_unique_id' => $unique_pesan
				]
			));

			$this->mailgun->from(getenv('EMAIL_FROM'), APP_NAME);
			$this->mailgun->to($DU['email'], $DU['nama']);
			$this->mailgun->subject($subject);
			$this->mailgun->message($rowPesan['pesan_html_text']);

			$this->mailgun->send();
			$this->db->insert('pesan_data_user', [
				'pesan_data_user_unique_id' => $unique_pesan,
				'fk_user' => $DU['id_user'],
				'fk_pesan_html' => $PK_Pesan,
				'pesan_delivered' => 0,
				'pesan_clicked' => 0,
				'pesan_opened' => 0,
				'pesan_data_user_created_at' => date('Y-m-d H:i:s')
			]);

		endforeach;
		return 1;
	}
}
