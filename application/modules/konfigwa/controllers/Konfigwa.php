<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfigwa extends CI_Controller {

   var $data_ref = array('uri_controllers' => 'konfigwa');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Konfigwa_model','konfigwa');
	}

	public function index()
	{
     	$user_data['konfig'] = $this->db->get_where('konfigurasi_wa', array('id'=>'1'))->row_array();
		$this->load->view('template/header',$user_data);
		$this->load->view('view',$user_data);
		$this->load->view('template/footer',$user_data);

	}


	public function ajax_edit($id)
	{
		$data = $this->berita->get_by_id($id);
		echo json_encode($data);
	}


	public function ajax_update()
	{
		$data = array(
			'id_device' 		=> $this->input->post('id_device'),
			'no_telp' 			=> $this->input->post('no_telp'),
			'jam_ultah' 		=> $this->input->post('jam_ultah'),
			'acak' 				=> $this->input->post('acak')
		);

		$this->konfigwa->update(array('id' => '1'), $data);
		echo json_encode(array("status" => TRUE));
	}


}
