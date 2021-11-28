<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Webhook extends CI_Controller
{
	public function mailgunWebhook()
	{
		$this->load->model(['Pesan_Data_User_Model' => 'PDU_M']);
		$obj = file_get_contents('php://input');
		$delivered = json_decode($obj, true);
		if($delivered == null){ //Pengecekan
			die('jnck');
		}

		if($this->PDU_M->updateDataTracking($delivered)){
			$this->output
				->set_status_header(201)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode(
					[
						'status' => 'success',
						'data' => $delivered
					], JSON_PRETTY_PRINT))
				->_display();
			exit;
		} else {
			$this->output
				->set_status_header(201)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode(
					[
						'status' => 'error',
						'data' => $delivered
					], JSON_PRETTY_PRINT))
				->_display();
			exit;
		}


	}

	public function mailgunOpened()
	{

	}

	public function mailgunClicked()
	{

	}
}
