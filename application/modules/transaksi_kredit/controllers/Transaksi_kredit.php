<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_kredit extends CI_Controller {

   var $data_ref = array('uri_controllers' => 'transaksi_kredit');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Transaksi_kredit_model','transaksi_kredit');
		// $this->load->model('Transaksi_booking_model','transaksi_booking');
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


	public function booking()
	{

      $user_data['data_ref'] = $this->data_ref;
    	
      $this->load->view('template/header',$user_data);
		$this->load->view('index_booking',$user_data);
      // $this->load->view('template/footer',$user_data);

	}


	public function ajax_list()
{
    $list = $this->transaksi_kredit->get_datatables();
    $data = array();
    $no = $_POST['start'];

    foreach ($list as $post) {

        $link_detail = ' <a class="btn btn-xs btn-warning" href="' . base_url("pembayaran/detail/" . $post->id_kavling) . '" > Detail Pembayaran</a>';
        $link_notif = ' <a class="btn btn-xs btn-info btn-kirim-notif" href="#" title="Kirim Notif" data-id="' . $post->id_pembelian . '">Kirim Notif</a>';

        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $post->nama_lengkap . '<br>' . $post->no_telp;
        $row[] = $post->kode_kavling;

        if ($post->tgl_jatuh_tempo == '0') {
            $row[] = '<a class="btn btn-xs btn-warning" href="#" onclick="tempo(' . "'" . $post->id_kavling . "'" . ')"> Belum di Set</a>';
            $diset = '0';
        } else {
            $row[] = $post->tgl_jatuh_tempo;
            $diset = '1';
        }

        //cari pembayaran bulan ini
        $bulan = date('m');
        $cari = $this->db->query("SELECT * FROM transaksi_kavling WHERE MONTH(tgl_pembelian) = '$bulan' AND id_kavling='$post->id_kavling'")->row_array();
        if ($cari) {
            $row[] = 'Sudah Bayar';
            $bayar = '1';
            $terlambat = '0';
        } else {
            $bayar = '0';
            //cari yang jatuh temponya sudah di set
            if ($post->tgl_jatuh_tempo != '0') {
                $sekarang = date('Y-m-d');
                $jTempo = date('Y-m') . '-' . $post->tgl_jatuh_tempo;
                $tgl1 = strtotime($jTempo);
                $tgl2 = strtotime($sekarang);
                $jarak = $tgl1 - $tgl2;

                $hari = $jarak / 60 / 60 / 24;
                if ($hari < 0) {
                    $row[] = '<span class="badge badge-danger">Terlambat ' . str_replace('-', '', $hari) . ' Hari </span>';
                    $terlambat = '1';
                } else {
                    $row[] = $hari . ' Hari lagi';
                    $terlambat = '0';
                }

            } else {
                $row[] = '';
            }

        }


        $row[] = '';
        //add html for action
        if ($diset == '1' AND $bayar == '0' AND $terlambat == '1') {
            $row[] = $link_detail . $link_notif;
        } else {
            $row[] = $link_detail;
        }


        $data[] = $row;
    }

    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->transaksi_kredit->count_all(),
        "recordsFiltered" => $this->transaksi_kredit->count_filtered(),
        "data" => $data,
    );
    //output to json format
    echo json_encode($output);
}

public function kirim_pesan_whatsapp($id_pembelian) {
	// Load model Transaksi_kredit_model
	$this->load->model('Transaksi_kredit_model');

	// Ambil data transaksi berdasarkan ID pembelian
	$transaksi = $this->Transaksi_kredit_model->get_transaksi_by_id($id_pembelian);

	// Jika data transaksi ditemukan
	if ($transaksi) {
		// Bangun pesan WhatsApp
		$pesan = 'Halo, ' . $transaksi->nama_lengkap . '! Ini adalah notifikasi untuk transaksi Anda.';
		$pesan .= ' Mohon untuk segera melakukan pembayaran. Terima kasih.';

		// Bangun URL pesan WhatsApp
		$url = 'https://api.whatsapp.com/send?phone=' . $transaksi->no_telp . '&text=' . urlencode($pesan);

		// Redirect ke URL pesan WhatsApp
		redirect($url);
	} else {
		// Jika data transaksi tidak ditemukan, tampilkan pesan error atau lakukan redirect ke halaman yang sesuai
		echo 'Data transaksi tidak ditemukan.';
	}
}




	





	public function ajax_list_booking()
	{

		$list = $this->transaksi_booking->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $post) {

			// $link_edit = '<a class="btn btn-xs btn-primary" href="'.base_url("transaksi/edit/".$post->id_pembelian).'" ><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
			$link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$post->id_pembelian."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$no++;
			$row = array();
         	$row[] = $no;
         	$row[] = $post->nama_lengkap;
			$row[] = $post->no_telp;
			$row[] = $post->kode_kavling;

			// if($post->jenis_pembelian == '1'){
			// 	$row[] = "Booking";
			// }else if($post->jenis_pembelian == '2'){
			// 	$row[] = "Cash";
			// }else if($post->jenis_pembelian == '3'){
			// 	$row[] = "Kredit";
			// }
			
			$row[] = $post->keterangan_booking;
			//add html for action
			$row[] = $link_hapus;

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

		$user_data['data_ref'] = $this->data_ref;
		$user_data['title'] = 'Sekolah';
		$user_data['menu_active'] = 'Data Referensi';
		$user_data['sub_menu_active'] = 'Sekolah';
			
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

		$tahun = date('Y');
		$nomor = $this->db->query("SELECT MAX(no_transaksi) as besar FROM transaksi_kavling WHERE no_transaksi like '%$tahun'")->row_array();
		$noSekarangTRX = $nomor['besar'];

		$urutanTRX = (int) substr($noSekarangTRX, 0, 3);
		$urutanTRX++;
		$hurufTRX = "/TRX-KAV/$tahun";
		$noPembayaranTRX = sprintf("%03s", $urutanTRX).$hurufTRX;

		$data = array(
			'tgl_pembelian' 	=> $this->input->post('tanggal'),
			'no_transaksi' 		=> $noPembayaranTRX,
			'jenis_pembelian' 	=> $this->input->post('jenis'),
			'id_kavling' 		=> $this->input->post('kode_kavling'),
			'id_customer' 		=> $this->input->post('customer'),
			'harga_jual' 		=> str_replace('.', '', $this->input->post('harga_jual')),
			'jumlah_dp' 		=> str_replace('.', '', $this->input->post('dp')),
			'cicilan_per_bulan' => str_replace('.', '', $this->input->post('cicilan_per_bulan')),	
			'lama_cicilan' 		=> str_replace('.', '', $this->input->post('lama_cicilan'))

		);

		$insert = $this->db->insert('transaksi_kavling', $data);
		$id = $this->db->insert_id();


		$idKav = $this->input->post('kode_kavling');
		$kav = $this->db->query("SELECT * FROM kavling_peta WHERE id_kavling='$idKav'")->row_array();
		$idCust = $this->input->post('customer');
		$cus = $this->db->query("SELECT * FROM customer WHERE id_customer='$idCust'")->row_array();
		$kate = $this->db->query("SELECT * FROM kategori WHERE id_customer='$idCust'")->row_array();

		//jenis Pembelian
		if($this->input->post('jenis') == '3'){
			//Jika Kredit
			$deskripsi = 'Pembayaran DP Kavling #'.$kav['kode_kavling'].' a.n '.$cus['nama_lengkap'];
		}else if($this->input->post('jenis') == '2'){
			//Jika cash
			$deskripsi = 'Pembayaran Pembelian Kavling #'.$kav['kode_kavling'].' a.n '.$cus['nama_lengkap'];
		}

		if($this->input->post('jenis') != '1'){
			$this->cetak($id);

			//Buat Nomor pembayaran
			//Buat pembayaran awal Kavling
			$tahun = date('Y');
			$nmr = $this->db->query("SELECT MAX(no_pembayaran) as besar FROM pembayaran WHERE no_pembayaran like '%$tahun'")->row_array();
			$noSekarang = $nmr['besar'];

			$urutan = (int) substr($noSekarang, 0, 3);
			$urutan++;
			$huruf = "/BYR-KAV/$tahun";
			$noPembayaran = sprintf("%03s", $urutan).$huruf;

			//Input pembayaran
			$param = array(
				'id_customer' 	=> $this->input->post('customer'),
				'no_pembayaran' => $noPembayaran,
				'deskripsi' 	=> $deskripsi,
				'id_kavling' 	=> $this->input->post('kode_kavling'),
				'tanggal' 		=> tgl_now(),
				'pembayaran_ke' => '0',
				'jumlah_bayar' 	=> str_replace('.', '', $this->input->post('dp')),
				'keterangan'	=> '',
				'jenis_pembelian'	=> $this->input->post('jenis'),
				'status'		=> '1'
			);

			$this->db->insert('pembayaran', $param);

		}
		
		//Update ke tabel kavling
		$this->db->update('kavling_peta', array('id_customer'=> $this->input->post('customer'), 'status'=> $this->input->post('jenis')) , array('id_kavling' => $this->input->post('kode_kavling')));

		//Update ke modul Transaksi keuangan
		//Input pembayaran
		$paramTrx = array(
			'transaksi_tanggal' 	=> $this->input->post('tanggal'),
			'transaksi_jenis' 		=> 'Pemasukan',
			'transaksi_kategori' 	=> $kate['kategori_id'],
			'transaksi_barang' 		=> $this->input->post('kode_kavling'),
			'transaksi_nominal' 	=> str_replace('.','', $this->input->post('dp')),
			'transaksi_keterangan' 	=> $deskripsi,
			'transaksi_bank'		=> ''
		);
		$this->db->insert('transaksi', $paramTrx);
		
		redirect('transaksi');
	}




	public function booking_proses()
	{

		$data = array(
			'tgl_pembelian' 	=> $this->input->post('tanggal'),
			'jenis_pembelian' 	=> $this->input->post('jenis'),
			'id_kavling' 		=> $this->input->post('kode_kavling'),
			'id_customer' 		=> $this->input->post('customer'),
			'keterangan_booking' 		=> $this->input->post('keterangan')
		);
		$this->db->insert('transaksi_booking', $data);
		//Update ke tabel kavling
		$this->db->update('kavling_peta', array('id_customer'=> $this->input->post('customer'), 'status'=> '1') , array('id_kavling' => $this->input->post('kode_kavling')));
		redirect('transaksi/booking');
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
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($file);

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

		$harga_jual = $item['luas_tanah'] * $item['hrg_meter'];
		$templateProcessor->setValue('harga_jual', rupiah($harga_jual));

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


	public function ajax_tempo($id)
	{
		$data = $this->db->query("SELECT * FROM kavling_peta k LEFT JOIN customer c ON k.id_customer=c.id_customer WHERE id_kavling='$id'")->row_array();
		echo json_encode($data);
	}

	public function ajax_update()
	{
		$this->db->update('kavling_peta', array('tgl_jatuh_tempo' => $this->input->post('tanggal')) , array('id_kavling' => $this->input->post('id')));
		echo json_encode(array("status" => TRUE));
	}

	public function detail()
	{
			$user_data['data_ref'] = $this->data_ref;
			$user_data['menu_active'] = 'Data Referensi';
		   
			$this->load->view('template/header',$user_data);
		  	$this->load->view('detail',$user_data);
	}

	public function filterdata($id)
	{

		$a = '<table id="table" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%"  >
		<thead>
			<tr>
				<th width="5%">No</th>
				<th width="5%">Lok Kavling</th>
				<th width="15%">Nama Customer</th>
				<th width="10%">Cicilan / Bulan</th>
				<th width="10%">Stt Bulan ini</th>
				<th width="10%">Jatuh Tempo</th>
				<th width="10%">Tunggakan</th>
				<th width="10%">Byr Terakhir</th>
				<th width="25%">Action</th>
			</tr>
		</thead>
		<tbody>';

		$tglSekarang = date('d');
		$BlnSekarang = date('m');
		$ThnSekarang = date('Y');
			$i =1;
			$kavling = $this->db->query("SELECT * FROM kavling_peta k 
			LEFT JOIN customer c ON k.id_customer=c.id_customer 
			LEFT JOIN transaksi_kavling t ON t.id_kavling=k.id_kavling 
			WHERE k.status='3' ORDER BY kode_kavling")->result();
			foreach($kavling as $kvg){
				//Pembayaran Terakhir
				$byrTerakhir = $this->db->query("SELECT * FROM pembayaran WHERE id_kavling='$kvg->id_kavling' ORDER by pembayaran_ke DESC limit 0,1")->row_array();
				$pembayaranTerakhir = @$byrTerakhir['tanggal'];
				$bulanTerakhir = substr($pembayaranTerakhir, 5,2);
				//Tanggal Jatuh Tempo
				if($kvg->tgl_jatuh_tempo == '0'){ $jt = '10';}else{$jt = $kvg->tgl_jatuh_tempo;}

				$selisihBulan =  selisihBulan($kvg->tgl_mulai_cicilan);
				$selisihBulan = $selisihBulan;
				$pembayaranKe = @$byrTerakhir['pembayaran_ke'];

				//Cari pembayaran bulan ini
				$bulan = date('m');
				$bulanIni = $this->db->query("SELECT * FROM pembayaran WHERE MONTH(tanggal) = '$bulan' AND id_kavling='$kvg->id_kavling' ORDER BY tanggal DESC LIMIT 0,1")->row_array();
				if($bulanIni){ 
					$lunas = '<span class="badge badge-secondary">Sudah Bayar</span>';
					$sudahBayar = '1';
					$tunggakan = '';
					
				}else{ 
					if($jt <= date('d')){
						$lunas = '<span class="badge badge-danger">Belum Bayar</span>';
					  }else{
						$lunas = '<span class="badge badge-warning">Belum Bayar</span>';
					  }
					$sudahBayar = '0';
					//Hitung tunggakan
					// $tung = $bulan - $bulanTerakhir;
					@$tung = $selisihBulan - $pembayaranKe -1;
					$tunggakan = @$tung.' x<br>'.rupiah(@$tung * $kvg->cicilan_per_bulan);
				}


				//Cari pembayaran bulan ini
				$bulan = date('m');
				$bulanIni = $this->db->query("SELECT * FROM pembayaran WHERE (MONTH(tanggal) = '$BlnSekarang' AND YEAR(tanggal) = '$ThnSekarang') AND id_kavling='$kvg->id_kavling' ORDER BY tanggal DESC LIMIT 0,1")->row_array();
				if($bulanIni){ 
					$lunas = '<span class="badge badge-secondary">Sudah Bayar</span>';
					$tunggakan = '';
					$sudahBayar = '1';
				}else{ 
				  //cek apakah sudah jatuh Tempo
				  if($jt <= date('d')){
					$lunas = '<span class="badge badge-warning">Belum Bayar</span>';
				  }else{
					$lunas = '<span class="badge badge-danger">Belum Bayar</span>';
				  }
				  $sudahBayar = '0';
					//Hitung tunggakan
					// $tung = $bulan - $bulanTerakhir;
					@$tung = $selisihBulan - $pembayaranKe -1;
					$tunggakan = @$tung.' x<br>'.rupiah(@$tung * $kvg->cicilan_per_bulan);
				}

				$link_detail = ' <a class="btn btn-xs btn-success" href="javascript:void(0)" title="Edit" onclick="edit('."'".$kvg->id_kavling."'".')">Edit Detail</a>';
				$link_history = ' <a class="btn btn-xs btn-warning" href="javascript:void(0)" title="Pembayaran" onclick="pembayaran('."'".$kvg->id_kavling."'".')">History Pembayaran</a>';
				$link_notif = ' <a class="btn btn-xs btn-info" href="javascript:void(0)" title="Hapus" onclick="notif('."'".$kvg->id_kavling."'".')"> Kirim Notif</a>';


				//Looping Baris
				if($id == '0'){
					//Tampilkan semua data
					$a .= '<tr>
							<td align="center">'.$i++.'</td>
							<td align="center">'.$kvg->kode_kavling.'</td>
							<td>'.$kvg->nama_lengkap.'<br><span class="badge badge-success">'.$kvg->no_telp.'</span><br>'.tgl_indo($kvg->tgl_akad).'</td>
							<td>'.$kvg->lama_cicilan.' Bulan<br>@ '.rupiah($kvg->cicilan_per_bulan).'<br><span class="badge badge-info">Berjalan '.$selisihBulan.' Bulan</span></td>
							<td><span class="badge badge-info">Bayar '.$pembayaranKe.' x</span><br>Sisa : '.($kvg->lama_cicilan - @$byrTerakhir['pembayaran_ke']).'</td>
							<td>Tgl : '.$jt.'<br>'.$lunas.'</td>
							<td>'.$tunggakan.'</td>
							<td align="center">'.@tgl_indo($byrTerakhir['tanggal']).'</td>
							<td>'.$link_detail.$link_history.$link_notif.'</td>
						</tr>';
				}else if($id == '10'){
					//Tampilkan data yang sudah Bayar
					if($sudahBayar == '1'){
						$a .= '<tr>
							<td align="center">'.$i++.'</td>
							<td align="center">'.$kvg->kode_kavling.'</td>
							<td>'.$kvg->nama_lengkap.'<br><span class="badge badge-success">'.$kvg->no_telp.'</span><br>'.tgl_indo($kvg->tgl_akad).'</td>
							<td>'.$kvg->lama_cicilan.' Bulan<br>@ '.rupiah($kvg->cicilan_per_bulan).'<br><span class="badge badge-info">Berjalan '.$selisihBulan.' Bulan</span></td>
							<td><span class="badge badge-info">Bayar '.$pembayaranKe.' x</span><br>Sisa : '.($kvg->lama_cicilan - @$byrTerakhir['pembayaran_ke']).'</td>
							<td>Tgl : '.$jt.'<br>'.$lunas.'</td>
							<td>'.$tunggakan.'</td>
							<td align="center">'.@tgl_indo($byrTerakhir['tanggal']).'</td>
							<td>'.$link_detail.$link_history.$link_notif.'</td>
						</tr>';
					}
				}else if($id == '11'){
					//Tampilkan data yang sudah Bayar
					if($sudahBayar == '0'){
						$a .= '<tr>
							<td align="center">'.$i++.'</td>
							<td align="center">'.$kvg->kode_kavling.'</td>
							<td>'.$kvg->nama_lengkap.'<br><span class="badge badge-success">'.$kvg->no_telp.'</span><br>'.tgl_indo($kvg->tgl_akad).'</td>
							<td>'.$kvg->lama_cicilan.' Bulan<br>@ '.rupiah($kvg->cicilan_per_bulan).'<br><span class="badge badge-info">Berjalan '.$selisihBulan.' Bulan</span></td>
							<td><span class="badge badge-info">Bayar '.$pembayaranKe.' x</span><br>Sisa : '.($kvg->lama_cicilan - @$byrTerakhir['pembayaran_ke']).'</td>
							<td>Tgl : '.$jt.'<br>'.$lunas.'</td>
							<td>'.$tunggakan.'</td>
							<td align="center">'.@tgl_indo($byrTerakhir['tanggal']).'</td>
							<td>'.$link_detail.$link_history.$link_notif.'</td>
						</tr>';
					}
				}else if($id == '1' AND @$tung == '1'){
					//Tampilkan data yang sudah Bayar
					if($sudahBayar == '0'){
						$a .= '<tr>
							<td align="center">'.$i++.'</td>
							<td align="center">'.$kvg->kode_kavling.'</td>
							<td>'.$kvg->nama_lengkap.'<br><span class="badge badge-success">'.$kvg->no_telp.'</span><br>'.tgl_indo($kvg->tgl_akad).'</td>
							<td>'.$kvg->lama_cicilan.' Bulan<br>@ '.rupiah($kvg->cicilan_per_bulan).'<br><span class="badge badge-info">Berjalan '.$selisihBulan.' Bulan</span></td>
							<td><span class="badge badge-info">Bayar '.$pembayaranKe.' x</span><br>Sisa : '.($kvg->lama_cicilan - @$byrTerakhir['pembayaran_ke']).'</td>
							<td>Tgl : '.$jt.'<br>'.$lunas.'</td>
							<td>'.$tunggakan.'</td>
							<td align="center">'.@tgl_indo($byrTerakhir['tanggal']).'</td>
							<td>'.$link_detail.$link_history.$link_notif.'</td>
						</tr>';
					}
				}else if($id == '2' AND @$tung == '2'){
					//Tampilkan data yang sudah Bayar
					if($sudahBayar == '0'){
						$a .= '<tr>
							<td align="center">'.$i++.'</td>
							<td align="center">'.$kvg->kode_kavling.'</td>
							<td>'.$kvg->nama_lengkap.'<br><span class="badge badge-success">'.$kvg->no_telp.'</span><br>'.tgl_indo($kvg->tgl_akad).'</td>
							<td>'.$kvg->lama_cicilan.' Bulan<br>@ '.rupiah($kvg->cicilan_per_bulan).'<br><span class="badge badge-info">Berjalan '.$selisihBulan.' Bulan</span></td>
							<td><span class="badge badge-info">Bayar '.$pembayaranKe.' x</span><br>Sisa : '.($kvg->lama_cicilan - @$byrTerakhir['pembayaran_ke']).'</td>
							<td>Tgl : '.$jt.'<br>'.$lunas.'</td>
							<td>'.$tunggakan.'</td>
							<td align="center">'.@tgl_indo($byrTerakhir['tanggal']).'</td>
							<td>'.$link_detail.$link_history.$link_notif.'</td>
						</tr>';
					}
				}else if($id == '3' AND @$tung == '3'){
					//Tampilkan data yang sudah Bayar
					if($sudahBayar == '0'){
						$a .= '<tr>
							<td align="center">'.$i++.'</td>
							<td align="center">'.$kvg->kode_kavling.'</td>
							<td>'.$kvg->nama_lengkap.'<br><span class="badge badge-success">'.$kvg->no_telp.'</span><br>'.tgl_indo($kvg->tgl_akad).'</td>
							<td>'.$kvg->lama_cicilan.' Bulan<br>@ '.rupiah($kvg->cicilan_per_bulan).'<br><span class="badge badge-info">Berjalan '.$selisihBulan.' Bulan</span></td>
							<td><span class="badge badge-info">Bayar '.$pembayaranKe.' x</span><br>Sisa : '.($kvg->lama_cicilan - @$byrTerakhir['pembayaran_ke']).'</td>
							<td>Tgl : '.$jt.'<br>'.$lunas.'</td>
							<td>'.$tunggakan.'</td>
							<td align="center">'.@tgl_indo($byrTerakhir['tanggal']).'</td>
							<td>'.$link_detail.$link_history.$link_notif.'</td>
						</tr>';
					}
				}else if($id == '4' AND @$tung > '3'){
					//Tampilkan data yang sudah Bayar
					if($sudahBayar == '0'){
						$a .= '<tr>
							<td align="center">'.$i++.'</td>
							<td align="center">'.$kvg->kode_kavling.'</td>
							<td>'.$kvg->nama_lengkap.'<br><span class="badge badge-success">'.$kvg->no_telp.'</span><br>'.tgl_indo($kvg->tgl_akad).'</td>
							<td>'.$kvg->lama_cicilan.' Bulan<br>@ '.rupiah($kvg->cicilan_per_bulan).'<br><span class="badge badge-info">Berjalan '.$selisihBulan.' Bulan</span></td>
							<td><span class="badge badge-info">Bayar '.$pembayaranKe.' x</span><br>Sisa : '.($kvg->lama_cicilan - @$byrTerakhir['pembayaran_ke']).'</td>
							<td>Tgl : '.$jt.'<br>'.$lunas.'</td>
							<td>'.$tunggakan.'</td>
							<td align="center">'.@tgl_indo($byrTerakhir['tanggal']).'</td>
							<td>'.$link_detail.$link_history.$link_notif.'</td>
						</tr>';
					}
				}
				
				
			}
		
				$a .= '</tbody>
			</table>';

			echo $a;

	}


	public function ajax_edit($id)
	{
		$data = $this->db->query("SELECT * FROM kavling_peta k 
		LEFT JOIN customer c ON k.id_customer = c.id_customer 
		LEFT JOIN transaksi_kavling t ON k.id_kavling=t.id_kavling 
		WHERE k.id_kavling='$id'")->row_array();
		$data['cicilan_per_bulan'] = rupiah($data['cicilan_per_bulan']);
		echo json_encode($data);
	}

	public function ajax_edit_pesan($id)
	{
		$data = $this->db->query("SELECT * FROM kavling_peta k 
		LEFT JOIN customer c ON k.id_customer = c.id_customer 
		LEFT JOIN transaksi_kavling t ON k.id_kavling=t.id_kavling 
		WHERE k.id_kavling='$id'")->row_array();
		$data['cicilan_per_bulan'] = rupiah($data['cicilan_per_bulan']);

		//Cari Template Pesan
		$pesan = $this->db->query("SELECT * FROM template WHERE jenis_pesan='notif'")->row_array(); 
		$pesan = str_replace('{nama}', $data['nama_lengkap'], $pesan['isi_template']);
		$pesan = str_replace('{kode_kavling}', $data['kode_kavling'], $pesan);
		$pesan = str_replace('{cicilan_per_bulan}', $data['cicilan_per_bulan'], $pesan);

		$data['pesan'] = $pesan;
		echo json_encode($data);
	}


	public function ajax_update_kredit()
	{
		$this->db->update('kavling_peta', array('tgl_jatuh_tempo' => $this->input->post('tgl_jt')) , array('id_kavling' => $this->input->post('id')));
		$this->db->update('transaksi_kavling', array('tgl_akad' => $this->input->post('tgl_akad'), 'tgl_mulai_cicilan' => $this->input->post('tgl_mulai_cicilan')) , array('id_kavling' => $this->input->post('id')));
		echo json_encode(array("status" => TRUE));
	}

	public function pembayaran($id_kavling)
	{
		$a = '';
		$cust = $this->db->query("SELECT * FROM kavling_peta k 
			LEFT JOIN customer c ON k.id_customer = c.id_customer 
			LEFT JOIN transaksi_kavling t ON k.id_kavling = t.id_kavling 
			WHERE k.id_kavling = '$id_kavling'")->row_array();

		$tglAkad = $cust['tgl_mulai_cicilan'];
		$bulanMulai = substr($tglAkad, 5,2);
	
		$a .= $cust['nama_lengkap'].'<br><br>';
		$a .= '<table class="table table-bordered">
		<tr>
		  <th width="5%">#</th>
		  <th width="20%">Bulan </th>
		  <th width="20%">Pembayaran </th>
		  <th width="20%">Tanggal Bayar</th>
		  <th width="20%">Jumlah Bayar</th>
		  <th width="15%">Action</th>
		</tr>
		<tr>
		<td></td>
			<td> - </td>
		  <td>Uang Muka</td>
		  <td>';
			//cek pembayaran DP di tabel pembayaran (cicilan ke 0)
			$idCust = $cust['id_customer'];
			$cekDP = $this->db->query("SELECT * FROM pembayaran WHERE id_kavling='$id_kavling' AND pembayaran_ke='0'")->row_array();

			$a .=  tgl_indo($cekDP['tanggal']). '</td>
		  <td align="right">'.rupiah($cekDP['jumlah_bayar']).'</td>
		</tr>';
		
		for ($i=1; $i <= $cust['lama_cicilan']; $i++) { 

		$bulanKredit = $bulanMulai + $i - 1;
		if($bulanKredit > 48){
			$bulanKredit = $bulanKredit - 48;
		}else if($bulanKredit > 36){
			$bulanKredit = $bulanKredit - 36;
		}else if($bulanKredit > 24){
			$bulanKredit = $bulanKredit - 24;
		}else if($bulanKredit > 12){
			$bulanKredit = $bulanKredit - 12;
		}
		  //Cek apakah ciclan bulan $i sudah terbayar
		  $query = "SELECT * FROM pembayaran WHERE pembayaran_ke='$i' AND id_kavling='$id_kavling'";
		  $cekk = $this->db->query($query)->num_rows();
		  if($cekk){
			$bayar = $this->db->query($query)->row_array();
			$a .= '<tr>
			<td>'.$i.'</td>
				<td>'.getbln($bulanKredit).'</td>
			  <td>ke '.$i.'</td>
			  <td>'.tgl_indo($bayar['tanggal']).'</td>
			  <td align="right">'.rupiah($bayar['jumlah_bayar']).'</td>
			  <td align="center"><a class="btn btn-primary btn-xs" href="'.base_url('pembayaran/cetak/'.$bayar['id_pembayaran']).'" target="_blank">Cetak</a></td>
			</tr>';
		  }else{
			$a .= '<tr>
			<td>'.$i.'</td>
				<td>'.getbln($bulanKredit).'</td>
			  <td>ke '.$i.'</td>
			  <td></td>
			  <td></td>
			  <td align="center">-</td>
			</tr>';
		  }
		  
		}
		
		$a .= '</table>';
		echo $a;

	}



	public function kirim()
	{
		$id = $this->input->post('id');
		$tanggal = date('Y-m-d');
		$jam = date('H:i:s');
		$this->db->insert('kirim', array(
			'tanggal' 		=> $tanggal, 
			'jam' 			=> $jam, 
			'jenis' 		=> 'notif', 
			'nama_pasien' 	=> $this->input->post('nama_lengkap'), 
			'no_tujuan' 	=> $this->input->post('no_telp'), 
			'isi_pesan' 	=> $this->input->post('isi_pesan'),
			'stt_kirim'		=> '1'
			) 
		);
		

		// $template = $this->db->query("SELECT * FROM template WHERE jenis_pesan ='notif'")->row_array();
		// $pesan = str_replace('{nama}', $param['nama_lengkap'], $template['isi_template']);
		// $pesan = str_replace('{kode_kavling}', $param['kode_kavling'], $pesan);

		// $sekarang = date('Y-m-d H:i:s');
		// $tanggal = date('Y-m-d');
		// $jam = date('H:i:s');


		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://app.whacenter.com/api/send',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => array('device_id' => konfig(),'number' => $this->input->post('no_telp'), 'message' => $this->input->post('isi_pesan')),
		  ));
		  
		  $response = curl_exec($curl);
		curl_close($curl);
		// $this->db->update('transaksi_kavling', array('tgl_akad' => $this->input->post('tgl_akad')) , array('id_kavling' => $this->input->post('id')));
		echo json_encode(array("status" => TRUE));
	}


}
