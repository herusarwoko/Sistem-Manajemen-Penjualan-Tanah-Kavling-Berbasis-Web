<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

   var $data_ref = array('uri_controllers' => 'transaksi');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Transaksi_model','transaksi');
		$this->load->model('Transaksi_booking_model','transaksi_booking');
		// $this->load->model('Group/Group_model','group');

		check_login();
	}

	public function index()
	{

      $user_data['data_ref'] = $this->data_ref;
      $user_data['menu_active'] = 'Data Referensi';
     	
      $this->load->view('template/header',$user_data);
		$this->load->view('index',$user_data);
      // $this->load->view('template/footer',$user_data);

	}


	public function daridenah($id,$status)
	{
		$user_data['data_ref'] = $this->data_ref;
		$user_data['kav'] = $this->db->query("SELECT * FROM kavling_peta WHERE id_kavling='$id'")->row_array();
		if($status == '0'){
			// JIka Kosong
			$this->load->view('template/header',$user_data);
			$this->load->view('transaksi',$user_data);
		}elseif($status == '1'){
			// JIka booking
			
		}elseif($status == '2'){
			// JIka CAsh
		}elseif($status == '3'){
			// JIka Kredit
			// $user_data['data_ref'] = $this->data_ref;
			// $user_data['cust'] = $this->db->query("SELECT * FROM kavling_peta k 
			// 	LEFT JOIN customer c ON k.id_customer = c.id_customer 
			// 	LEFT JOIN transaksi_kavling t ON k.id_kavling = t.id_kavling 
			// 	WHERE k.id_kavling = '$id'")->row_array();
			// $user_data['id_kavling'] = $id;

			// $this->load->view('template/header',$user_data);
			// $this->load->view('pembayaran/detail',$user_data);
			redirect('pembayaran/detail/'.$id);
		}

	}


	public function booking()
	{

      $user_data['data_ref'] = $this->data_ref;
    	
      $this->load->view('template/header',$user_data);
		$this->load->view('index_booking',$user_data);
      // $this->load->view('template/footer',$user_data);

	}


	public function ajax_list()
	{

		$list = $this->transaksi->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $post) {

			$link_edit = '<a class="btn btn-xs btn-primary" href="'.base_url("transaksi/edit/".$post->id_pembelian).'" ><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
			$link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$post->id_pembelian."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			$bukti_pembayaran = '';
			$bukti_pembayaran = '';
				if (!empty($post->bukti_pembayaran)) {
				$bukti_pembayaran = '<a href="#" onclick="showImage(' . "'" . base_url('assets/bukti_trx/' . $post->bukti_pembayaran) . "'" . ')">Lihat Bukti Pembayaran</a>';
    		}

			$no++;
			$row = array();
         	$row[] = $no;
         	$row[] = $post->nama_lengkap.'<br>'.$post->no_telp;
			$row[] = $post->kode_kavling;

			if($post->jenis_pembelian == '1'){
				$row[] = "Booking";
			}else if($post->jenis_pembelian == '2'){
				$row[] = "Cash";
			}else if($post->jenis_pembelian == '3'){
				$row[] = "Kredit";
			}
			
			if($post->jenis_pembelian != '1'){
				$akad = '<a href="'.base_url('ajb/akad_'.$post->id_pembelian.'.docx').'" target="_blank">Cetak Akad</a><br>';
			}else{
				$akad = '';
			}
			$row[] = $akad;
			//add html for action
			$row[] = $bukti_pembayaran;
			$row[] = $link_edit . ' ' . $link_hapus;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->transaksi->count_all(),
						"recordsFiltered" => $this->transaksi->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}





	public function ajax_list_booking()
	{

		$list = $this->transaksi_booking->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $post) {

			$link_edit = ' <a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="edit('."'".$post->id_pembelian."'".')"> Edit</a>';
			$link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$post->id_pembelian."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$no++;
			$row = array();
         	$row[] = $no;
         	$row[] = $post->kode_kavling;
         	$row[] = $post->nama_lengkap.'<br>'.$post->no_telp;
			$row[] = rupiah($post->nominal_booking);
			$row[] = tgl_indo($post->tgl_expired);	
			$row[] = $post->keterangan_booking;
			//add html for action
			$row[] = $link_edit.$link_hapus;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->transaksi_booking->count_all(),
						"recordsFiltered" => $this->transaksi_booking->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}



	public function tambah()
	{
		$a = $this->input->post('submit');
		if ( isset($a) ) {
			$user_data['harga_jual'] 		= $this->input->post('harga_jual');
			$user_data['dp'] 				= $this->input->post('uang_muka');
			$user_data['lama_cicilan'] 		= $this->input->post('bulan');
			$user_data['cicilan_per_bulan'] = $this->input->post('cicilan');
	   }else{
			$user_data['harga_jual'] 		= '';
			$user_data['dp'] 				= '';
			$user_data['lama_cicilan'] 		= '';
			$user_data['cicilan_per_bulan'] = '';
	   }

		// $user_data['data_ref'] = $this->data_ref;
		// $user_data['title'] = 'Sekolah';
		// $user_data['menu_active'] = 'Data Referensi';
		// $user_data['sub_menu_active'] = 'Sekolah';
			
		$this->load->view('template/header',$user_data);
		$this->load->view('transaksi',$user_data);
      // $this->load->view('template/footer',$user_data);

	}


	public function tambah_booking()
	{

		$user_data['data_ref'] = $this->data_ref;
			
		$this->load->view('template/header',$user_data);
		$this->load->view('transaksi_booking',$user_data);
      // $this->load->view('template/footer',$user_data);

	}


	public function edit($id_transaksi)
	{

      $user_data['data_ref'] = $this->data_ref;
	  $query = "SELECT * FROM transaksi_kavling t 
		LEFT JOIN kavling_peta p ON t.id_kavling = p.id_kavling 
		LEFT JOIN customer c ON t.id_customer = c.id_customer 
		WHERE t.id_pembelian='$id_transaksi'";
      $user_data['transaksi'] = $this->db->query($query)->row_array();
     	
      	$this->load->view('template/header',$user_data);
		$this->load->view('edit',$user_data);
      // $this->load->view('template/footer',$user_data);

	}

	
	public function baru()
{
    // Mendapatkan nomor transaksi baru
    $tahun = date('Y');
    $nomor = $this->db->query("SELECT MAX(no_transaksi) as besar FROM transaksi_kavling WHERE no_transaksi like '%$tahun'")->row_array();
    $noSekarangTRX = $nomor['besar'];
    $urutanTRX = (int) substr($noSekarangTRX, 0, 5);
    $urutanTRX++;
    $hurufTRX = "/TRX-KAV/$tahun";
    $noPembayaranTRX = sprintf("%05s", $urutanTRX) . $hurufTRX;

    // Data transaksi dari form
    $data = array(
        'tgl_pembelian'     => $this->input->post('tanggal'),
        'tgl_akad'          => $this->input->post('tanggal'),
        'tgl_mulai_cicilan' => $this->input->post('tanggal_tempo'),
        'no_transaksi'      => $noPembayaranTRX,
        'jenis_pembelian'   => $this->input->post('jenis'),
        'id_kavling'        => $this->input->post('id_kavling'),
        'id_customer'       => $this->input->post('customer'),
        'id_marketing'      => $this->input->post('marketing'),
        'fee_marketing'     => str_replace('.', '', $this->input->post('fee_marketing')),
        'fee_notaris'       => str_replace('.', '', $this->input->post('fee_notaris')),
        'harga_jual'        => str_replace('.', '', $this->input->post('harga_jual')),
        'bayar_cash'        => str_replace('.', '', $this->input->post('pem_cash')),
        'jumlah_dp'         => str_replace('.', '', $this->input->post('dp')),
        'booking_rp'        => str_replace('.', '', $this->input->post('pem_booking')),
        'cicilan_per_bulan' => str_replace('.', '', $this->input->post('cicilan_per_bulan')),
        'lama_cicilan'      => str_replace('.', '', $this->input->post('lama_cicilan'))
    );

    // Menyimpan data transaksi ke dalam database
    $this->db->insert('transaksi_kavling', $data);
    $id = $this->db->insert_id();

    // Mendapatkan informasi kavling dan customer
    $idKav = $this->input->post('id_kavling');
    $kav = $this->db->query("SELECT * FROM kavling_peta WHERE id_kavling='$idKav'")->row_array();
    $idCust = $this->input->post('customer');
    $cus = $this->db->query("SELECT * FROM customer WHERE id_customer='$idCust'")->row_array();

    // Deskripsi transaksi berdasarkan jenis pembelian
    if ($this->input->post('jenis') == '3') {
        // Jika Kredit
        $deskripsi = 'Pembayaran DP Kavling #' . $kav['kode_kavling'] . ' a.n ' . $cus['nama_lengkap'];
    } else if ($this->input->post('jenis') == '2') {
        // Jika cash
        $deskripsi = 'Pembayaran Pembelian Kavling #' . $kav['kode_kavling'] . ' a.n ' . $cus['nama_lengkap'];
    } else if ($this->input->post('jenis') == '1') {
        // Jika Booking
        $deskripsi = 'Pembayaran Booking Kavling #' . $kav['kode_kavling'] . ' a.n ' . $cus['nama_lengkap'];
    }

    // Menentukan nominal pembayaran berdasarkan jenis pembelian
    if ($this->input->post('jenis') == '1') {
        $nominal = str_replace('.', '', $this->input->post('pem_booking'));
    } else if ($this->input->post('jenis') == '2') {
        $nominal = str_replace('.', '', $this->input->post('pem_cash'));
    } else if ($this->input->post('jenis') == '3') {
        $nominal = str_replace('.', '', $this->input->post('dp'));
    }

    // Jika transaksi bukan booking
    if ($this->input->post('jenis') != '1') {
        // Menyimpan data pembayaran
        $tahun = date('Y');
        $nmr = $this->db->query("SELECT MAX(no_pembayaran) as besar FROM pembayaran WHERE no_pembayaran like '%$tahun'")->row_array();
        $noSekarang = $nmr['besar'];

        $urutan = (int) substr($noSekarang, 0, 5);
        $urutan++;
        $huruf = "/BYR-KAV/$tahun";
        $noPembayaran = sprintf("%05s", $urutan) . $huruf;

        $param = array(
            'id_customer'     => $this->input->post('customer'),
            'no_pembayaran'   => $noPembayaran,
            'deskripsi'       => $deskripsi,
            'id_kavling'      => $this->input->post('id_kavling'),
            'tanggal'         => tgl_now(),
            'pembayaran_ke'   => '0',
            'jumlah_bayar'    => $nominal,
            'keterangan'      => '',
            'jenis_pembelian' => $this->input->post('jenis'),
            'status'          => '1'
        );

        $this->db->insert('pembayaran', $param);
    } else {
        // Jika Transaksi Booking
        $data = array(
            'tgl_pembelian'       => $this->input->post('tanggal'),
            'tgl_expired'         => $this->input->post('tgl_expired'),
            'jenis_pembelian'     => $this->input->post('jenis'),
            'id_kavling'          => $this->input->post('id_kavling'),
            'id_customer'         => $this->input->post('customer'),
            'nominal_booking'     => $this->input->post('pem_booking_int'),
            'keterangan_booking'  => $this->input->post('keterangan_booking')
        );
        $this->db->insert('transaksi_booking', $data);
    }

    // Update tabel kavling
    $tglTempo = substr($this->input->post('tanggal_tempo'), 8, 2);
    $this->db->update(
        'kavling_peta',
        array(
            'id_customer'      => $this->input->post('customer'),
            'id_marketing'     => $this->input->post('marketing'),
            'tgl_jatuh_tempo'  => $tglTempo,
            'status'           => $this->input->post('jenis')
        ),
        array('id_kavling' => $this->input->post('id_kavling'))
    );

    // Update modul Transaksi keuangan
    $paramTrx = array(
        'transaksi_tanggal'     => $this->input->post('tanggal'),
        'transaksi_jenis'       => 'Pemasukan',
        'transaksi_barang'      => $this->input->post('kode_kavling'),
        'transaksi_nominal'     => $nominal,
        'transaksi_keterangan'  => $deskripsi,
        'transaksi_bank'        => ''
    );
    $this->db->insert('transaksi', $paramTrx);

    // Upload gambar pembayaran
    if (!empty($_FILES['bukti_pembayaran']['name'])) {
        $config['upload_path']   = './assets/bukti_trx/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size']      = 2048; // maksimal 2MB
        $config['encrypt_name']  = TRUE; // Enkripsi nama file

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('bukti_pembayaran')) {
            $error = $this->upload->display_errors();
            // Handle error upload jika diperlukan
        } else {
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];
            // Simpan nama file ke dalam data transaksi
            $this->db->where('id_pembelian', $id)->update('transaksi_kavling', array('bukti_pembayaran' => $file_name));
        }
    }

    redirect('transaksi');
}





	public function booking_proses()
	{

		$data = array(
			'tgl_pembelian' 		=> $this->input->post('tanggal'),
			'tgl_expired' 			=> $this->input->post('tgl_expired'),
			'jenis_pembelian' 		=> $this->input->post('jenis'),
			'id_kavling' 			=> $this->input->post('kode_kavling'),
			'id_customer' 			=> $this->input->post('customer'),
			'nominal_booking' 		=> $this->input->post('nominal_booking'),
			'keterangan_booking' 	=> $this->input->post('keterangan')
		);
		$this->db->insert('transaksi_booking', $data);
		//Update ke tabel kavling
		$this->db->update('kavling_peta', array('id_customer'=> $this->input->post('customer'), 'status'=> '1') , array('id_kavling' => $this->input->post('kode_kavling')));
		redirect('transaksi/booking');
	}

	public function ajax_edit($id)
	{
		$this->db->from('transaksi_booking');
		$this->db->join('customer', 'transaksi_booking.id_customer = customer.id_customer', 'left');
		$this->db->join('kavling_peta', 'transaksi_booking.id_kavling = kavling_peta.id_kavling', 'left');
		$this->db->where('id_pembelian',$id);
		$data = $this->db->get()->row();

		echo json_encode($data);
	}


	public function ajax_select_customer(){
        $this->db->select('id_customer,nama_lengkap');
        $this->db->like('nama_lengkap',$this->input->get('q'),'both');
        $this->db->limit(20);
        $items=$this->db->get('customer')->result_array();
        //output to json format
        echo json_encode($items);
    }


	public function ajax_select_marketing(){
        $this->db->select('id_marketing, nama_marketing');
        $this->db->like('nama_marketing',$this->input->get('q'),'both');
        $this->db->limit(20);
        $items=$this->db->get('marketing')->result_array();
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


	public function cetak($id_transaksi)
	{

		$query = "SELECT * FROM transaksi_kavling t 
		LEFT JOIN kavling_peta p ON t.id_kavling = p.id_kavling 
		LEFT JOIN customer c ON t.id_customer = c.id_customer 
		WHERE t.id_pembelian='$id_transaksi'";
		$item = $this->db->query($query)->row_array();

		if($item['jenis_pembelian'] == '3'){
			$file= 'assets/aplikasi/akad_kredit.docx';
		}else if($item['jenis_pembelian'] == '2'){
			$file= 'assets/aplikasi/akad_cash.docx';
		}

		// $jJual = is_numeric($item['jumlah_dp']) + (is_numeric($item['cicilan_per_bulan']) * is_numeric($item['lama_cicilan']));
		$jJual = $item['jumlah_dp'] + ($item['cicilan_per_bulan'] * $item['lama_cicilan']);
		$jumlahHutang = ($item['cicilan_per_bulan'] * $item['lama_cicilan']);

		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($file);
		$templateProcessor->setValue('harga_jual', rupiah($jJual));
		$templateProcessor->setValue('terbilang', ucwords(penyebut($jJual)));
		$templateProcessor->setValue('jumlah_dp_terbilang', ucwords(penyebut($item['jumlah_dp'])));
		$templateProcessor->setValue('jumlah_hutang', rupiah($jumlahHutang));
		$templateProcessor->setValue('jumlah_hutang_terbilang', ucwords(penyebut($jumlahHutang)));
        
		// $kodeKavling = $item['kode_kavling'];
		$templateProcessor->setValue('no_transaksi', $item['no_transaksi']);

        $templateProcessor->setValue('tgl', tgl_indo(date('d')));
        $templateProcessor->setValue('tanggal', tgl_indo(date('Y-m-d')));
        $templateProcessor->setValue('nama_hari', namaHari(date('Y-m-d')));

        $templateProcessor->setValue('kode_kavling', $item['kode_kavling']);
        $templateProcessor->setValue('nama_lengkap', $item['nama_lengkap']);
        $templateProcessor->setValue('no_ktp', $item['no_ktp']);
        $templateProcessor->setValue('jenis_kelamin', $item['jenis_kelamin']);
        $templateProcessor->setValue('tempat_lahir', $item['tempat_lahir']);
        $templateProcessor->setValue('tgl_lahir', $item['tgl_lahir']);
        $templateProcessor->setValue('alamat', $item['alamat']);
        $templateProcessor->setValue('pekerjaan', $item['pekerjaan']);
        $templateProcessor->setValue('no_telp', $item['no_telp']);

        $templateProcessor->setValue('lama_cicilan', $item['lama_cicilan']);
        $templateProcessor->setValue('jumlah_dp', rupiah($item['jumlah_dp']));
        $templateProcessor->setValue('cicilan_per_bulan', rupiah($item['cicilan_per_bulan']));


		$templateProcessor->setValue('luas_tanah', $item['luas_tanah']);

		// $harga_jual = $item['luas_tanah'] * $item['hrg_meter'];
		// $templateProcessor->setValue('harga_jual', rupiah($harga_jual));

		$templateProcessor->saveAs('ajb/akad_'.$id_transaksi.'.docx');
		
	}


	public function ajax_delete($id)
	{
		//normalkan data kavling
		$transaksi = $this->db->query("SELECT * FROM transaksi_kavling WHERE id_pembelian='$id'")->row_array();
		$idKavling = $transaksi['id_kavling'];
		//normalkan data kavling
		$this->db->query("UPDATE kavling_peta SET status='0', id_customer='0' WHERE id_kavling = '$idKavling'");
		//Hapus data pembayaran yang terelasi dengan penghapusan transaksi
		$this->db->query("DELETE FROM pembayaran WHERE id_kavling = '$idKavling'");
		$this->transaksi->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete_booking($id)
	{
		//normalkan data kavling
		$transaksi = $this->db->query("SELECT * FROM transaksi_booking WHERE id_pembelian='$id'")->row_array();
		$idKavling = $transaksi['id_kavling'];
		//normalkan data kavling
		$this->db->query("UPDATE kavling_peta SET status='0', id_customer='0' WHERE id_kavling = '$idKavling'");
		//Hapus data pembayaran yang terelasi dengan penghapusan transaksi
		$this->transaksi_booking->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	





}
