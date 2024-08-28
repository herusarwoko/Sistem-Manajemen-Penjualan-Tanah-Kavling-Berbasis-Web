<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends CI_Controller {

   var $data_ref = array('uri_controllers' => 'template');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Template_model','template');
	}

	public function index()
	{

		$user_data['data_ref'] = $this->data_ref;
	
     	$this->load->view('template/header');
		$this->load->view('view',$user_data);

	}

	public function ajax_list()
	{
		$list = $this->template->get_datatables();
		$data = array();
		$no = $_POST['start'];


		foreach ($list as $post) {


				$link_edit = '<a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="edit('."'".$post->id_template."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
				$link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$post->id_template."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
				

				

			$no++;
			$row = array();
         	$row[] = $no;
			$row[] = $post->nama_template;
			$row[] = $post->isi_template;
			$row[] = $post->jenis_pesan;
			$row[] = $link_edit.$link_hapus;
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->template->count_all(),
						"recordsFiltered" => $this->template->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->template->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{

			$data = array(
				'nama_template' 	=> $this->input->post('nama_template'),
            	'isi_template' 			=> $this->input->post('isi_template'),
				'jenis_pesan' 			=> $this->input->post('jenis_pesan')
			);
		
		
		$this->template->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{

		$data = array(
			'nama_template' 	=> $this->input->post('nama_template'),
			'isi_template' 			=> $this->input->post('isi_template'),
			'jenis_pesan' 			=> $this->input->post('jenis_pesan')
		);
		
		$this->template->update(array('id_template' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}


	public function ajax_delete($id)
	{
		$this->db->query("DELETE FROM template WHERE id_template='$id'");
		echo json_encode(array("status" => TRUE));
	}


}
