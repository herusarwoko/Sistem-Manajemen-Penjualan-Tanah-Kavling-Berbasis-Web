<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfigurasi extends CI_Controller {

   var $data_ref = array('uri_controllers' => 'konfigurasi');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Konfigurasi_model','konfigurasi');
		// $this->load->model('Group/Group_model','group');
		check_login();
	}

	public function index()
	{
     	$user_data = $this->db->get_where('konfigurasi', array('id'=>'1'))->row_array();
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
			'nama_kavling' 		=> $this->input->post('nama_kavling'),
			'nama_perusahaan' 	=> $this->input->post('nama_perusahaan'),
			'alamat' 			=> $this->input->post('alamat'),
			'email' 			=> $this->input->post('email'),
			'telp' 				=> $this->input->post('no_telp'),
			'hape'      		=> $this->input->post('no_hp'),
			'nama_bank' 		=> $this->input->post('nama_bank'),
			'no_rekening' 				=> $this->input->post('no_rekening'),
			'nama_pemilik_rek' 			=> $this->input->post('nama_pemilik_rek'),
			'kota_penandatanganan' 		=> $this->input->post('kota_penandatanganan'),
			'nama_mengetahui' 	    => $this->input->post('nama_mengetahui'),
			'nama_penandatangan' 	    => $this->input->post('nama_penandatangan')
		);

		if($this->input->post('remove_photo')) // if remove photo checked
			{
			 if(file_exists('./assets/images/'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
			    unlink('./assets/images/'.$this->input->post('remove_photo'));
			 $data['logo'] = '';
			}
 
      if(!empty($_FILES['logo']['name']))
      {
         $upload = $this->_do_upload();
             
         //delete file
         $berita = $this->konfigurasi->get_by_id('1');
         // var_dump($berita);
         if(file_exists('./assets/aplikasi/'.$berita->logo) && $berita->logo)
             unlink('./assets/aplikasi/'.$berita->logo);
 
         $data['logo'] = $upload;
      }

	  // upload tanda tangan ---------------------------------------
      if(!empty($_FILES['file_ttd']['name']))
      {
         $upload = $this->_do_upload_file_ttd();
             
         //delete file
         $berita = $this->konfigurasi->get_by_id('1');
         // var_dump($berita);
         if(file_exists('./assets/aplikasi/'.$berita->file_ttd) && $berita->file_ttd)
             unlink('./assets/aplikasi/'.$berita->file_ttd);
 
         $data['file_ttd'] = $upload;
      }

	  // upload akad cash ---------------------------------------
      if(!empty($_FILES['akad_cash']['name']))
      {
        //delete file
         if(file_exists('./assets/aplikasi/akad_cash.docx') && 'akad_cash.docx')
             unlink('./assets/aplikasi/akad_cash.docx');

		$upload = $this->_do_upload_akad_cash();
 
         $data['akad_cash'] = $upload;
      }

	  // upload akad Kredit ---------------------------------------
	  if(!empty($_FILES['akad_kredit']['name']))
      {
         //delete file
		 if(file_exists('./assets/aplikasi/akad_kredit.docx') && 'akad_kredit.docx')
		 unlink('./assets/aplikasi/akad_kredit.docx');
 
		$upload = $this->_do_upload_akad_kredit();
        $data['akad_kredit'] = $upload;
      }

		$this->konfigurasi->update(array('id' => '1'), $data);
		echo json_encode(array("status" => TRUE));
	}






	private function _do_upload()
	{
		$config['upload_path']          = './assets/aplikasi/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_size']             = 0; //set max size allowed in Kilobyte
		$config['max_width']            = 0; // set max width image allowed
		$config['max_height']           = 0; // set max height allowed
		$config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

		$this->load->library('upload', $config);
			$this->upload->initialize($config);
		if(!$this->upload->do_upload('logo')) //upload and validate
		{
		    $data['inputerror'][] = 'logo';
		    $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
		    $data['status'] = FALSE;
		    echo json_encode($data);
		    exit();
		}
		return $this->upload->data('file_name');
	}

	private function _do_upload_file_ttd()
	{
		$config['upload_path']          = './assets/aplikasi';
		$config['allowed_types']        = 'jpg|png';
		$config['max_size']             = 0; //set max size allowed in Kilobyte
		$config['max_width']            = 0; // set max width image allowed
		$config['max_height']           = 0; // set max height allowed
		$config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

		$this->load->library('upload', $config);
			$this->upload->initialize($config);
		if(!$this->upload->do_upload('file_ttd')) //upload and validate
		{
		    $data['inputerror'][] = 'file_ttd';
		    $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
		    $data['status'] = FALSE;
		    echo json_encode($data);
		    exit();
		}
		return $this->upload->data('file_name');
	}


	private function _do_upload_akad_cash()
	{
		$config['upload_path']          = './assets/aplikasi';
		$config['allowed_types']        = 'docx';
		$config['max_size']             = 0; //set max size allowed in Kilobyte
		$config['max_width']            = 0; // set max width image allowed
		$config['max_height']           = 0; // set max height allowed
		// $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
		$config['file_name']            = 'akad_cash.docx'; //just milisecond timestamp fot unique name

		$this->load->library('upload', $config);
			$this->upload->initialize($config);
		if(!$this->upload->do_upload('akad_cash')) //upload and validate
		{
		    $data['inputerror'][] = 'akad_cash';
		    $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
		    $data['status'] = FALSE;
		    echo json_encode($data);
		    exit();
		}
		return $this->upload->data('file_name');
	}


	private function _do_upload_akad_kredit()
	{
		$config['upload_path']          = './assets/aplikasi';
		$config['allowed_types']        = 'docx';
		$config['max_size']             = 0; //set max size allowed in Kilobyte
		$config['max_width']            = 0; // set max width image allowed
		$config['max_height']           = 0; // set max height allowed
		// $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
		$config['file_name']            = 'akad_kredit.docx'; //just milisecond timestamp fot unique name

		$this->load->library('upload', $config);
			$this->upload->initialize($config);
		if(!$this->upload->do_upload('akad_kredit')) //upload and validate
		{
		    $data['inputerror'][] = 'akad_kredit';
		    $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
		    $data['status'] = FALSE;
		    echo json_encode($data);
		    exit();
		}
		return $this->upload->data('file_name');
	}




}
