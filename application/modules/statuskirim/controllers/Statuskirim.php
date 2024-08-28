<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statuskirim extends CI_Controller {

   var $data_ref = array('uri_controllers' => 'statuskirim');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Statuskirim_model','statuskirim');

	}

	public function index()
	{

      $user_data['data_ref'] = $this->data_ref;
      $user_data['title'] = 'Sekolah';
      $user_data['menu_active'] = 'Data Referensi';
      $user_data['sub_menu_active'] = 'Sekolah';
     	
      $this->load->view('template/header',$user_data);
		$this->load->view('view',$user_data);
      // $this->load->view('template/footer',$user_data);

	}

	public function ajax_list()
	{

		$list = $this->statuskirim->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $post) {

			$link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$post->id_kirim."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$no++;
			$row = array();
         	$row[] = $no;
         	$row[] = $post->tanggal.' '.$post->jam;
         	$row[] = $post->nama_pasien;
			$row[] = $post->no_tujuan;
			$row[] = $post->isi_pesan;

			if($post->stt_kirim == '0'){
				$row[] = '<button class="btn btn-xs btn-secondary">Pending</button>';
			}else if($post->stt_kirim == '1'){
				$row[] = '<button class="btn btn-xs btn-info">Terkirim</button>';
			}else if($post->stt_kirim == '2'){
				$row[] = '<button class="btn btn-xs btn-danger">Gagal</button>';
			}
			

			//add html for action
			$row[] = $link_hapus;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->statuskirim->count_all(),
						"recordsFiltered" => $this->statuskirim->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	private function _do_upload(){

	      $config['upload_path']          = './assets/lampiran_statuskirim/';
	      $config['allowed_types']        = 'gif|jpg|png|pdf';
	      $config['max_size']             = 1000; //set max size allowed in Kilobyte
	      $config['max_width']            = 3000; // set max width image allowed
	      $config['max_height']           = 3000; // set max height allowed
	      $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
	 
	      $this->load->library('upload', $config);
	 		$this->upload->initialize($config);
	        if(!$this->upload->do_upload('ktp')) //upload and validate
	        {
	            $data['inputerror'][] = 'ktp';
	            $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
	            $data['status'] = FALSE;
	            echo json_encode($data);
	            exit();
	        }
	        return $this->upload->data('file_name');
	}


	private function _do_upload_kk(){

	      $config['upload_path']          = './assets/lampiran_statuskirim/';
	      $config['allowed_types']        = 'gif|jpg|png|pdf';
	      $config['max_size']             = 1000; //set max size allowed in Kilobyte
	      $config['max_width']            = 3000; // set max width image allowed
	      $config['max_height']           = 3000; // set max height allowed
	      $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
	 
	      $this->load->library('upload', $config);
	 		$this->upload->initialize($config);
	        if(!$this->upload->do_upload('kk')) //upload and validate
	        {
	            $data['inputerror'][] = 'kk';
	            $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
	            $data['status'] = FALSE;
	            echo json_encode($data);
	            exit();
	        }
	        return $this->upload->data('file_name');
	}

	public function ajax_edit($id)
	{
		$data = $this->statuskirim->get_by_id($id);
		echo json_encode($data);
	}

	

	public function ajax_delete($id)
	{
		$this->db->delete('kirim',array('id_kirim'=>$id));
		echo json_encode(array("status" => TRUE));
	}

	


}
