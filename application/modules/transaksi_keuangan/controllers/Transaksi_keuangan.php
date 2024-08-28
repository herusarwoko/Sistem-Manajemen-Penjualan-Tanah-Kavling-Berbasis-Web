<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_keuangan extends CI_Controller {

   var $data_ref = array('uri_controllers' => 'transaksi_keuangan');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Transaksi_keuangan_model','transaksi_keuangan');
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

		$list = $this->transaksi_keuangan->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $post) {

			// $link_edit = '<a class="btn btn-xs btn-primary" href="'.base_url("transaksi_keuangan/edit/".$post->transaksi_id).'" ><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
			$link_edit = ' <a class="btn btn-xs btn-primary" href="javascript:void(0)" title="edit" onclick="edit('."'".$post->transaksi_id."'".')"> Edit</a>';
			$link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$post->transaksi_id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$no++;
			$row = array();
         	$row[] = $no;
         	$row[] = tgl_INDO($post->transaksi_tanggal);
			$row[] = $post->kategori;
			// $row[] = $post->barang;
			$row[] = $post->transaksi_keterangan;

			if($post->transaksi_jenis == 'Pemasukan'){
				$row[] = rupiah($post->transaksi_nominal);
				$row[] = '-';
			}else{
				$row[] = '-';
				$row[] = rupiah($post->transaksi_nominal);
			}
			

			$row[] = $link_edit.$link_hapus;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->transaksi_keuangan->count_all(),
						"recordsFiltered" => $this->transaksi_keuangan->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}


	
	public function ajax_add()
	{

		$data = array(
			'transaksi_tanggal' 		=> $this->input->post('transaksi_tanggal'),
			'transaksi_jenis' 		=> $this->input->post('transaksi_jenis'),
			'transaksi_kategori' 		=> $this->input->post('transaksi_kategori'),
			// 'transaksi_barang' 		=> $this->input->post('transaksi_barang'),
			'transaksi_nominal' 		=> $this->input->post('transaksi_nominal'),
			'transaksi_keterangan' 		=> $this->input->post('transaksi_keterangan'),
			'transaksi_bank' 		=> $this->input->post('transaksi_bank')
		);

		$insert = $this->transaksi_keuangan->save($data);
		echo json_encode(array("status" => TRUE));
	}


	public function ajax_edit($id_transaksi)
	{

      $user_data['data_ref'] = $this->data_ref;
	  $query = "SELECT * FROM transaksi t 
		LEFT JOIN kategori k ON t.transaksi_kategori = k.kategori_id
		LEFT JOIN barang b ON t.transaksi_barang = b.barang_id 
		WHERE t.transaksi_id='$id_transaksi'";
      $items = $this->db->query($query)->row_array();

	  $items['transaksi_nominal'] = rupiah($items['transaksi_nominal']);
     	
	  echo json_encode($items);

	}


	public function ajax_select_customer(){
        $this->db->select('id_customer,nama_lengkap');
        $this->db->like('nama_lengkap',$this->input->get('q'),'both');
        $this->db->limit(20);
        $items=$this->db->get('customer')->result_array();
        //output to json format
        echo json_encode($items);
    }



    public function ajax_select_kavling(){
        $this->db->select('id_kavling,kode_kavling');
        $this->db->like('kode_kavling',$this->input->get('q'),'both');
        $this->db->limit(20);
        $items=$this->db->get_where('kavling_peta', ['status'=> '0'])->result_array();
        //output to json format
        echo json_encode($items);
    }


	public function ajax_delete($id)
	{
		$this->db->query("DELETE FROM transaksi WHERE transaksi_id = '$id'");
		$this->transaksi_keuangan->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	public function ajax_update()
	{

		$data = array(
			'transaksi_tanggal' 		=> $this->input->post('transaksi_tanggal'),
			'transaksi_jenis' 			=> $this->input->post('transaksi_jenis'),
			'transaksi_kategori' 		=> $this->input->post('transaksi_kategori'),
			'transaksi_nominal' 		=> str_replace('.','', $this->input->post('transaksi_nominal')) ,
			'transaksi_keterangan' 		=> $this->input->post('transaksi_keterangan'),
			'transaksi_bank' 			=> $this->input->post('transaksi_bank')
		);

		$this->db->update('transaksi', $data, ['transaksi_id' => $this->input->post('id')]);
		echo json_encode(array("status" => TRUE));
	}

	


}
