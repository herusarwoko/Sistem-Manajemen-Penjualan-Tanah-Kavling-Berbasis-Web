<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Denahtrx extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('customade');
		$this->load->library(array('form_validation'));	
		check_login();

	}
	
	public function index()
	{
		$data=array();
		$csrf = array(
		        'name' => $this->security->get_csrf_token_name(),
		        'hash' => $this->security->get_csrf_hash()
		    );
		$data=array('csrf'=>$csrf);	


		$this->load->view('template/header',$data);
		$this->load->view('denah-trx',$data);
		$this->load->view('template/footer',$data);
	}

	public function ajax_edit($id)
	{
		$data = $this->db->query("SELECT * FROM kavling_peta a 
			LEFT JOIN customer b ON a.id_customer=b.id_customer 
			WHERE a.id_kavling = '$id' ")->row_array();
			$data['harga_jual'] = rupiah($data['hrg_jual']);
		echo json_encode($data);
	}



	

}