<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hakakses extends CI_Controller {

   var $data_ref = array('uri_controllers' => 'hakakses');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Aktifitas_model','aktifitas');
		// $this->load->model('Group/Group_model','group');
		check_login();
	}

	public function index()
	{

		$user_data['data_ref'] = $this->data_ref;
		$user_data['title'] = 'Menu';
		$user_data['pengguna'] = $this->db->query("SELECT * FROM users")->result();

		$this->load->view('template/header');
		$this->load->view('view',$user_data);
	}

	public function ajax_list()
	{

		$list = $this->aktifitas->get_datatables();
		$data = array();
		$no = $_POST['start'];


		foreach ($list as $post) {


				$link_edit = '<a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="edit('."'".$post->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';

				$link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$post->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';


			$no++;
			$row = array();
         	$row[] = $no;
			 $row[] = tgl_indo($post->tanggal);
         	$row[] = $post->surname;
			$row[] = $post->username;
         	$row[] = $post->aktifitas;
         	$row[] = $post->keterangan;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->aktifitas->count_all(),
						"recordsFiltered" => $this->aktifitas->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}


	public function cariuser($id){
        $query = "SELECT * FROM users WHERE id ='$id'";
        $item = $this->db->query($query)->row_array();
        
        return $this->output->set_content_type('application/json')->set_output(json_encode($item));        
    }

	public function tampildetail($id){
        // $hakakses = $this->db->query("SELECT * FROM hak_akses h
		// LEFT JOIN users u ON h.id_user = u.id 
		// LEFT JOIN menu m ON m.id_menu = h.id_menu")->result();
		$menu = $this->db->query("SELECT * FROM menu ORDER BY id_parent, urutan ASC")->result();
		$a = '';
		$no =1;
		foreach($menu as $h){
			$menu = $this->db->query("SELECT * FROM hak_akses WHERE id_menu='$h->id_menu' AND id_user='$id'")->row_array();
			if($menu['status_hak'] == '1'){
				$checked = 'checked';
			}else{
				$checked = '';
			}
			$a .='<tr>
				<td>'.$no++.'</td>
				<td><input type="checkbox" name="che_'.$menu['id_menu'].'" value="'.$menu['id_menu'].'" class="pilihtgl" '.$checked.'></td>
				<td>'.$h->title_menu.'</td>
				<td>'.$h->title_menu.'</td>
				</tr>';
		}
		echo $a .= '<tr>
		<td colspan="4">
		<button class="btn btn-primary btn-sm">Simpan</button>
		</td></tr>';
    }

	public function update(){
        // $query = "SELECT * FROM users WHERE id ='$id'";
        // $item = $this->db->query($query)->row_array();
        // return $this->output->set_content_type('application/json')->set_output(json_encode($item));  
		$menu = $this->db->query("SELECT * FROM menu")->result();
		// $idUser = $this->encryption->decrypt($this->session->userdata('id'));
		$idUser = $this->input->post('pengguna');
		foreach($menu as $mn){
			//pastikan data menu sudah ada di hak akses
			$cek = $this->db->query("SELECT * FROM hak_akses WHERE id_menu='$mn->id_menu' AND id_user='$idUser'")->num_rows();
			if($cek){
				if($this->input->post('che_'.$mn->id_menu) == ''){
					//update data
					$this->db->update('hak_akses', ['status_hak' => '0'],['id_menu' => $mn->id_menu, 'id_user'=> $idUser]);
				}else{
					$this->db->update('hak_akses', ['status_hak' => '1'],['id_menu' => $mn->id_menu, 'id_user'=> $idUser]);
				}
				// echo 'A';
			}else{
				$this->db->insert('hak_akses', ['status_hak' => '0', 'id_menu' => $mn->id_menu, 'id_user'=> $idUser]);
				// echo 'B';
			}
			
		}
		
		redirect('hakakses');
    }

	

}
