<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CronJob extends CI_Controller
{
  public function cronKonfirmasi983242dfsf98fdfpp() //Url cronjob konfirmasi barang diterima
  {
    $this->db->select([
      'pengiriman.notifikasi_email',
      'orders.tanggal_selesai',
      'orders.status_order',
      'orders.id_orders'
    ]);
    $this->db->join('pengiriman','pengiriman.id_orders=orders.id_orders');
    $this->db->where('pengiriman.notifikasi_email <', time());
    $this->db->where('orders.tanggal_selesai', NULL);
    $this->db->where('orders.status_order', 'settlement');
    $hasil = $this->db->get('orders')->result_array();
    $jml = 0;
    if(count($hasil) > 0){
      $this->load->model('Admin_Model');
      foreach($hasil as $res){
        $resDataEmail = $this->Admin_Model->getInfoResiById($res['id_orders']);
        $dataEmail = [
          'id_orders' => $resDataEmail['id_orders'],
          'nomerResi' => $resDataEmail['nomer_resi'],
          'nama' => ucwords($resDataEmail['nama']),
          'email' => $resDataEmail['email']
        ];
        $id_orders = $res['id_orders'];
        $data = [
          'status_order' => 'Selesai',
          'status_pengiriman' => 'Terkirim',
          'tanggal_selesai' => date('d/m/Y', time())
        ];
        $where = [
          'id_orders' => $id_orders,
          'status_order'  => 'settlement',
          'tanggal_selesai' => NULL
        ];
        $this->db->update('orders', $data, $where);
        $this->freeM->sendEmail($dataEmail, 'Terima kasih Telah Berbelanja '.$id_orders,EMAIL_FROM,'notif-terimakasih'); //Auto send email ke pelanggan
        echo $this->db->last_query();
        echo '<br><br>';
        $jml++;
      }
      echo 'Terupdate '.$jml.' tanggal '.date('d/m/Y H:i');
    }
  }

  public function cronjobpenjadwalanemail84328750972375841110()
	{
		$time1 = time() - 900;
		$time2 = time() + 300;
		$this->db->where('pesan_html.pesan_dijadwalkan_pada BETWEEN "' . date('Y-m-d H:i:s', $time1) . '" and "' . date('Y-m-d H:i:s', $time2) . '"');
		$this->db->where('pesan_html.pesan_dijadwalkan_status', 0);
		$dataPesan = $this->db->get('pesan_html')->result_array();
		if(!empty($dataPesan)){
			foreach ($dataPesan as $DP){
				if($DP['fk_segmentasi'] != null){
					$this->db->where('segmentasi_id', $DP['fk_segmentasi']);
					$dataSegmentasi = $this->db->get('segmentasi')->row_array();
					$dataQuery = $this->db->query($dataSegmentasi['segmentasi_query'])->result_array();
					if(!empty($dataQuery)){
						foreach ($dataQuery as $DQ){
							$this->load->library('mailgun');
							$unique_pesan = uniqid();
							$this->mailgun->initialize(array(
								'apikey' => API_MAILGUN, //Ganti dengan key anda
								'domain' => DOMAIN_MAILGUN, //Ganti dengan domain anda, cek config/Constants.php,
								'user-variables' => [
									'fk_pesan' => $DP['pesan_html_id'],
									'pesan_data_user_unique_id' => $unique_pesan
								]
							));

							$this->mailgun->from(getenv('EMAIL_FROM'), APP_NAME);
							$this->mailgun->to($DQ['email'], $DQ['nama']);
							$this->mailgun->subject($DP['pesan_html_title']);
							if($DP['pesan_html_type'] == 1){
								$this->mailgun->message($this->load->view('email/segmentasi/segment_1_product', $DP['pesan_html_data'], TRUE));
							} else if($DP['pesan_html_type'] == 2) {
								$this->mailgun->message($this->load->view('email/segmentasi/segment_2_product', $DP['pesan_html_data'], TRUE));
							} else {
								$this->mailgun->message($DP['pesan_html_text']);
							}

							$this->mailgun->send();
							$this->db->insert('pesan_data_user', [
								'pesan_data_user_unique_id' => $unique_pesan,
								'fk_user' => $DQ['id_user'],
								'fk_pesan_html' => $DP['pesan_html_id'],
								'pesan_delivered' => 0,
								'pesan_clicked' => 0,
								'pesan_opened' => 0,
								'pesan_data_user_created_at' => date('Y-m-d H:i:s')
							]);
						}
						$this->db->where('pesan_html.pesan_dijadwalkan_status', 0);
						$this->db->where('pesan_html.pesan_html_id', $DP['pesan_html_id']);
						$this->db->update('pesan_html', ['pesan_dijadwalkan_status' => 1]);
					}
				} else {
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
								'fk_pesan' => $DP['pesan_html_id'],
								'pesan_data_user_unique_id' => $unique_pesan
							]
						));

						$this->mailgun->from(getenv('EMAIL_FROM'), APP_NAME);
						$this->mailgun->to($DU['email'], $DU['nama']);
						$this->mailgun->subject($DP['pesan_html_title']);
						if($DP['pesan_html_type'] == 1){
							$this->mailgun->message($this->load->view('email/segmentasi/segment_1_product', $DP['pesan_html_data'], TRUE));
						} else if($DP['pesan_html_type'] == 2) {
							$this->mailgun->message($this->load->view('email/segmentasi/segment_2_product', $DP['pesan_html_data'], TRUE));
						} else {
							$this->mailgun->message($DP['pesan_html_text']);
						}

						$this->mailgun->send();
						$this->db->insert('pesan_data_user', [
							'pesan_data_user_unique_id' => $unique_pesan,
							'fk_user' => $DU['id_user'],
							'fk_pesan_html' => $DP['pesan_html_id'],
							'pesan_delivered' => 0,
							'pesan_clicked' => 0,
							'pesan_opened' => 0,
							'pesan_data_user_created_at' => date('Y-m-d H:i:s')
						]);
					endforeach;
					$this->db->where('pesan_html.pesan_dijadwalkan_status', 0);
					$this->db->where('pesan_html.pesan_html_id', $DP['pesan_html_id']);
					$this->db->update('pesan_html', ['pesan_dijadwalkan_status' => 1]);
				}
			}
		}

	}
}
