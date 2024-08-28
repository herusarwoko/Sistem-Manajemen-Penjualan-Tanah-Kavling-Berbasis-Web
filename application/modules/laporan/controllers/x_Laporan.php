<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

   var $data_ref = array('uri_controllers' => 'transaksi');

	public function __construct()
	{
		parent::__construct();
		check_login();
	}

	public function index()
	{
      	$user_data['title'] = 'Laporan';
     	
      	$this->load->view('template/header',$user_data);
		$this->load->view('index',$user_data);
	}

	public function customer()
	{
      	$user_data['title'] = 'Laporan';
     	
      	$this->load->view('template/header',$user_data);
		$this->load->view('form_customer',$user_data);
	}

	public function kategori()
	{
      	$user_data['title'] = 'Laporan';
     	
      	$this->load->view('template/header',$user_data);
		$this->load->view('form_kategori',$user_data);
	}


	public function tampil()
	{
      	$user_data['title'] = 'Laporan';
     	
      	$this->load->view('template/header_kosong',$user_data);
		$this->load->view('tampil',$user_data);
	}


	public function tampil_customer()
	{
      	$user_data['title'] = 'Laporan';
     	
      	$this->load->view('template/header_kosong',$user_data);
		$this->load->view('tampil_customer',$user_data);
	}


	public function tampil_kategori()
	{
      	$user_data['title'] = 'Laporan';
     	
      	$this->load->view('template/header_kosong',$user_data);
		$this->load->view('tampil_kategori',$user_data);
	}

	public function excel()
	{
      	$user_data['title'] = 'Laporan';
     	
      	$this->load->view('template/header_kosong',$user_data);
		$this->load->view('excel',$user_data);
	}


	public function ajax_list()
	{

		$list = $this->transaksi->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $post) {


				// $link_edit = '<a class="btn btn-xs btn-primary" href="'.base_url("transaksi/edit/".$post->id_pembelian).'" ><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
		
				$link_hapus = ' <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$post->id_pembelian."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		

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
			$row[] = $link_hapus;

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


	public function edit($id_transaksi)
	{

      $user_data['data_ref'] = $this->data_ref;
	  $query = "SELECT * FROM transaksi t 
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
		$nomor = $this->db->query("SELECT MAX(no_transaksi) as besar FROM transaksi WHERE no_transaksi like '%$tahun'")->row_array();
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

		$insert = $this->db->insert('transaksi', $data);
		$id = $this->db->insert_id();
		if($this->input->post('jenis') != '1'){
			$this->cetak($id);

			//
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
		
		
		redirect('transaksi');
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


	public function cari_kavling($id){
        $getcity = $this->db->query("SELECT * FROM kavling_peta WHERE id_customer='$id'")->result();
       	foreach($getcity as $gt){
            echo '<option value="'.$gt->id_kavling.'">'.$gt->kode_kavling.'</option>';
       	}
        // echo json_encode($items);
    }


	


	public function cetak($id_transaksi)
	{

		$query = "SELECT * FROM transaksi t 
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
		$transaksi = $this->db->query("SELECT * FROM transaksi WHERE id_pembelian='$id'")->row_array();
		$idKavling = $transaksi['id_kavling'];
		//normalkan data kavling
		$this->db->query("UPDATE kavling_peta SET status='0', id_customer='0' WHERE id_kavling = '$idKavling'");
		//Hapus data pembayaran yang terelasi dengan penghapusan transaksi
		$this->db->query("DELETE FROM pembayaran WHERE id_kavling = '$idKavling'");
		$this->transaksi->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}



	function cetak_pengeluaran(){

        $jenis = $this->input->get('jenis');
		if($jenis == '1'){
			$jen = "Pemasukan";
		}else{
			$jen = "Pengeluaran";
		}
        $awal = $this->input->get('awal');
		$akhir = $this->input->get('akhir');


		$query = "SELECT * FROM transaksi WHERE transaksi_tanggal >= '$awal' AND transaksi_tanggal <= '$akhir' AND transaksi_jenis= '$jen'";
		$data = $this->db->query($query)->result();
        

        $config=array('orientation'=>'P','size'=>'A4');
        $this->load->library('MyPDF',$config);
        $this->mypdf->SetFont('Arial','B',10);
        $this->mypdf->SetLeftMargin(10);
        $this->mypdf->addPage();
        $this->mypdf->setTitle('Laporan Pengeluaran');
        $this->mypdf->SetFont('Arial','B',14);
		$this->mypdf->SetX(25);
		$this->mypdf->MultiCell(160,5, 'LAPORAN PENGELUARAN' ,0,'C',false);
		$this->mypdf->SetFont('Arial','',10);
		$this->mypdf->Cell(190,7,'Periode : '.tgl_indo($awal).' - '.tgl_indo($akhir),0,1,'C');
		$y = $this->mypdf->GetY() + 2;
		$this->mypdf->Line(10, $y, 200, $y);
		
		
        $this->mypdf->Ln();

		$this->mypdf->SetFont('Arial','',8);
		$this->mypdf->Cell(10,10,'NO.',1,0,'C');
		$this->mypdf->Cell(30,10,'TANGGAL',1,0,'C');
		$this->mypdf->Cell(80,10,'DESKRIPSI',1,0,'C');
		$this->mypdf->Cell(40,10,'JENIS / KETERANGAN',1,0,'C');
		$this->mypdf->Cell(30,10,'JENIS',1,1,'C');

		$no 		= 1;
		$this->mypdf->SetFont('Arial','',8);
		// $detail =$this->db->query($query)->result();
		foreach ($data as $dtl) {
			
			$bar = $this->mypdf->GetY();
			$this->mypdf->MultiCell(10,7, $no++ ,1,'C',false);
			$this->mypdf->SetY($bar);
			$this->mypdf->SetX(20);
			$this->mypdf->Cell(30,7,tgl_indo($dtl->transaksi_tanggal),1,0,'L');
			$this->mypdf->Cell(80,7,$dtl->transaksi_keterangan,1,0,'L');
			$this->mypdf->Cell(40,7,$dtl->transaksi_jenis,1,0,'L');
			$this->mypdf->Cell(30,7,rupiah($dtl->transaksi_nominal),1,1,'R');

		}
       

        $this->mypdf->Output();
    }


	function cetak_pemasukan(){

        $jenis = $this->input->get('jenis');
		if($jenis == '1'){
			$jen = "Pemasukan";
		}else{
			$jen = "Pengeluaran";
		}
        $awal = $this->input->get('awal');
		$akhir = $this->input->get('akhir');


		$query = "SELECT * FROM transaksi WHERE transaksi_tanggal >= '$awal' AND transaksi_tanggal <= '$akhir' AND transaksi_jenis= '$jen'";
		$data = $this->db->query($query)->result();
        

        $config=array('orientation'=>'P','size'=>'A4');
        $this->load->library('MyPDF',$config);
        $this->mypdf->SetFont('Arial','B',10);
        $this->mypdf->SetLeftMargin(10);
        $this->mypdf->addPage();
        $this->mypdf->setTitle('Laporan Pengeluaran');
        $this->mypdf->SetFont('Arial','B',14);
		$this->mypdf->SetX(25);
		$this->mypdf->MultiCell(160,5, 'LAPORAN PEMASUKAN' ,0,'C',false);
		$this->mypdf->SetFont('Arial','',10);
		$this->mypdf->Cell(190,7,'Periode : '.tgl_indo($awal).' - '.tgl_indo($akhir),0,1,'C');
		$y = $this->mypdf->GetY() + 2;
		$this->mypdf->Line(10, $y, 200, $y);
		
		
        $this->mypdf->Ln();

		$this->mypdf->SetFont('Arial','',8);
		$this->mypdf->Cell(10,10,'NO.',1,0,'C');
		$this->mypdf->Cell(30,10,'TANGGAL',1,0,'C');
		$this->mypdf->Cell(80,10,'DESKRIPSI',1,0,'C');
		$this->mypdf->Cell(40,10,'JENIS / KETERANGAN',1,0,'C');
		$this->mypdf->Cell(30,10,'JENIS',1,1,'C');

		$no 		= 1;
		$this->mypdf->SetFont('Arial','',8);
		// $detail =$this->db->query($query)->result();
		foreach ($data as $dtl) {
			
			$bar = $this->mypdf->GetY();
			$this->mypdf->MultiCell(10,7, $no++ ,1,'C',false);
			$this->mypdf->SetY($bar);
			$this->mypdf->SetX(20);
			$this->mypdf->Cell(30,7,tgl_indo($dtl->transaksi_tanggal),1,0,'L');
			$this->mypdf->Cell(80,7,$dtl->transaksi_keterangan,1,0,'L');
			$this->mypdf->Cell(40,7,$dtl->transaksi_jenis,1,0,'L');
			$this->mypdf->Cell(30,7,rupiah($dtl->transaksi_nominal),1,1,'R');

		}
       

        $this->mypdf->Output();
    }

	


}
