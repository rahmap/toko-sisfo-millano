<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Upload extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('');
    }
    
    public function index(){
        $file = $_FILES['img'];
        
        $filename = $file['name'];
        $arr = explode(".", $filename);
        $ext = end($arr);
        $this_file = uniqid();	
        
        $tmp_name = $file['tmp_name'];
        
        move_uploaded_file($tmp_name, FCPATH . "assets/img/$this_file.$ext");
        echo "$this_file.$ext";
    }
}
