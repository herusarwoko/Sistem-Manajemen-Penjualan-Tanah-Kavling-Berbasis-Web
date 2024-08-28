<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marketing extends CI_Controller {

   var $data_ref = array('uri_controllers' => 'marketing');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Marketing_model','marketing');
		// $this->load->model('Group/Group_model','group');

		check_login();
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

		$list = $this->marketing->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $post) {
			$link_edit = ' <a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="edit('."'".$post->id_marketing."'".')"> Edit</a>';
			$link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$post->id_marketing."'".')"> Delete</a>';
			$link_detail = ' <a class="btn btn-xs btn-info" href="javascript:void(0)" title="detail" onclick="detail('."'".$post->id_marketing."'".')"> Detail</a>';

			$no++;
			$row = array();
         	$row[] = $no;
         	$row[] = $post->nama_marketing;
			$row[] = $post->alamat.'<br>Telp : '.$post->no_telp;
			// $row[] = "";
			// $row[] = "";
			$progres = $this->db->query("SELECT COUNT(id_pembelian) as jum FROM transaksi_kavling WHERE id_marketing=' $post->id_marketing' AND stt_transaksi = '0'")->row_array();
			$row[] = $progres['jum'];
			$close = $this->db->query("SELECT COUNT(id_pembelian) as jum FROM transaksi_kavling WHERE id_marketing=' $post->id_marketing' AND stt_transaksi = '1'")->row_array();
			$row[] = $close['jum'];
			//add html for action
				
			$row[] = $link_detail.$link_edit.$link_hapus;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->marketing->count_all(),
						"recordsFiltered" => $this->marketing->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->marketing->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
			'nama_marketing' 		=> $this->input->post('nama_lengkap'),
			'jenis_kelamin' 	=> $this->input->post('jenis_kelamin'),
			'alamat' 			=> $this->input->post('alamat'),
			'no_telp' 			=> $this->input->post('no_telp')
		);

		$this->marketing->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		// $this->_validate();
		$post_date = time();
		$post_date_format = date('Y-m-d h:i:s', $post_date);
		$data = array(
			'nama_marketing' 		=> $this->input->post('nama_lengkap'),
			'jenis_kelamin' 	=> $this->input->post('jenis_kelamin'),
			'alamat' 			=> $this->input->post('alamat'),
			'no_telp' 			=> $this->input->post('no_telp')
		);

		$this->marketing->update(array('id_marketing' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->db->delete('marketing',array('id_marketing'=>$id));
		echo json_encode(array("status" => TRUE));
	}

	public function lampiran($id)
	{
		$a = '<thead>
				<tr>
					<th width="5%">No</th>
					<th width="15%">Tanggal</th>
					<th width="25%">Kode Kavling</th>
					<th width="25%">Jenis Penjualan</th>
					<th width="25%">Jumlah Komisi</th>
			</tr>
			</thead>
			<tbody>';
		$b = '';
		$no=1;
		$query = "SELECT * FROM kavling_peta k LEFT JOIN transaksi_kavling t ON k.id_kavling = t.id_kavling WHERE t.id_marketing='$id'";
		$komisi = $this->db->query($query)->result();
		foreach($komisi as $kms){ 
			if($kms->status == '2'){
				$jenis = 'Cash';
			}elseif($kms->status == '3'){
				$jenis = 'Kredit';
			}elseif($kms->status == '1'){
				$jenis = 'Booking';
			}
		$b .= '<tr>
				
			<td>'.$no++.'</td>
			<td>'.tgl_indo($kms->tgl_pembelian).'</td>
			<td>'.$kms->kode_kavling.'</td>
			<td>'.$jenis.'</td>
			<td>'.rupiah($kms->fee_marketing).'</td>
		</tr>';
		}

		echo $a.$b.'</tbody>';

	}


	
}
