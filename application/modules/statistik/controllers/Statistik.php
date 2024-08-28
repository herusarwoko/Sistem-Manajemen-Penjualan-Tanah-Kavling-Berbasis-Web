<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistik extends CI_Controller {

   var $data_ref = array('uri_controllers' => 'statistik');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Statistik_model','statistik');
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

	public function ajax_list_statistik()
	{

		$list = $this->statistik->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $post) {
			
			$link_edit = ' <a class="btn btn-xs btn-danger" href="'.base_url('statistik/cetak/'.$post->id_pembayaran).'" target="_blank" onClick="javascript:document.location.reload(true)"> Cetak</a>';
			$link_kirim = ' <button class="btn btn-xs btn-info" onclick="kirim('.$post->id_pembayaran.')" > Kirim Kwitansi</button>';
			$no++;
			$row = array();
         	$row[] = $no;

         	if($post->status == '0'){
				$stt = 'Kosong';
			}elseif($post->status == '1'){
				$stt = 'Booking';
			}elseif($post->status == '2'){
				$stt = '<button class="btn btn-primary btn-xs">Cash</button>';
			}elseif($post->status == '3'){
				$stt = '<button class="btn btn-warning btn-xs">Kredit</button>';
			}else{
				$stt = 'Pengurus';
			}

         	
			$row[] = tgl_indo($post->tanggal);
			$row[] = $post->kode_kavling.' / '.$stt.'<br>'.$post->nama_lengkap ;
			if($post->pembayaran_ke == '0'){
				if($post->jenis_pembelian == '2'){
					$row[] = 'Pembayaran Pembelian Cash'.'<br>'.rupiah($post->jumlah_bayar);
				}else{
					$row[] = 'Pembayaran DP'.'<br>'.rupiah($post->jumlah_bayar);
				}
			}else{
				$row[] = 'Pembayaran Cicilan ke- '.$post->pembayaran_ke.'<br>'.rupiah($post->jumlah_bayar);
			}
			
			$row[] = $post->no_telp;
			$namaFile = str_replace('/','-', $post->no_pembayaran);
			$noFile = explode('-', $namaFile);
			if(file_exists('./kwitansi/kwitansi-'.$noFile[0].'.pdf')){
				$row[] = $link_edit.$link_kirim;
			}else{
				$row[] = $link_edit;
			}
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->statistik->count_all(),
						"recordsFiltered" => $this->statistik->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	

	public function ajax_kirim($id)
	{
		$param = $this->db->query("SELECT * FROM pembayaran p 
		LEFT JOIN customer c ON p.id_customer = c.id_customer 
		LEFT JOIN kavling_peta k ON k.id_kavling = p.id_kavling 
		WHERE id_pembayaran='$id'")->row_array();
		$template = $this->db->query("SELECT * FROM template WHERE jenis_pesan ='kwitansi'")->row_array();
		$pesan = str_replace('{nama}', $param['nama_lengkap'], $template['isi_template']);
		$pesan = str_replace('{kode_kavling}', $param['kode_kavling'], $pesan);

		$sekarang = date('Y-m-d H:i:s');
		$tanggal = date('Y-m-d');
		$jam = date('H:i:s');

		// echo konfig();
		// echo $param['no_telp'];
		// echo $pesan;

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
			CURLOPT_POSTFIELDS => array('device_id' => konfig(),'number' => $param['no_telp'], 'message' => $pesan),
		  ));
		  
		  $response = curl_exec($curl);
		curl_close($curl);

		$namaFile = str_replace('/','-', $param['no_pembayaran']);
		$noFile = explode('-', $namaFile);
		//Kirim Lampiran
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
		CURLOPT_POSTFIELDS => array('device_id' => konfig(),'number' => $param['no_telp'],'message' => 'Kwitansi Pembayaran Kavling : '.$param['kode_kavling'], 
		'file' => 'https://angsuran.grandtalawang.site/kwitansi/kwitansi-'.$noFile[0].'.pdf'),
		));

		$response = curl_exec($curl);
		curl_close($curl);

		$data = array(
			'tanggal' 		=> $tanggal,
			'jam' 			=> $jam,
			'nama_pasien' 	=> $param['nama_lengkap'],
			'jenis' 		=> 'pribadi',
			'no_tujuan' 	=> $param['no_telp'],
			'isi_pesan' 	=> $pesan, 
			'stt_kirim' 	=> '1'
		);
		$this->db->insert('kirim', $data);



		echo json_encode(array("status" => TRUE));
	}





	public function cetak_v1($id){

		
		// $this->db->from('kavling_peta a');
		$this->db->join('transaksi b', 'a.id_kavling = b.id_kavling', 'left');
		$this->db->join('customer c', 'a.id_customer = c.id_customer', 'left');
		$kavling = $this->db->get_where('kavling_peta a', array('a.id_kavling'=>$id))->row_array();
		// $kavling = $this->db->query("SELECT * FROM  WHERE id_kavling = $id")->row_array();

        $file=VIEWPATH."template\kwitansi.pdf";
        $config=array('file'=>$file);
        $config['jasi']=$config;


        $this->load->library('MyPDFI',$config);
        $this->mypdfi->AddPage();
        $this->mypdfi->SetFont('Arial','',6);

		$tanggal        = date("Y-m-d");

		
        $this->mypdfi->SetFont('Arial','B',9);


        //Data AK 1
        $this->mypdfi->text(163,28, "005/KBV/VIII/2020");
        $this->mypdfi->SetFont('Arial','',6.5);


        // $this->mypdfi->text(90,28,$siswa['kode_kelas']);
        $this->mypdfi->SetFont('Times','',12);

        //Data Diri
        $this->mypdfi->text(60,33, $kavling['nama_lengkap']);
        $this->mypdfi->text(60,41, ucwords(penyebut($kavling['jumlah_dp'])).'Rupiah');
        
        if($kavling['jenis_pembelian'] == '3'){
        	$this->mypdfi->text(60,49, "Pembayaran DP Pembelian Kredit Kavling MINAS Blok ".$kavling['kode_kavling']);
        }elseif($kavling['jenis_pembelian'] == '2'){
        	$this->mypdfi->text(60,49, "Pembayaran Awal Pembelian CASH Kavling MINAS Blok ".$kavling['kode_kavling']);
        }
        
        $this->mypdfi->SetFont('Times','B',16);
        $this->mypdfi->text(35,69.5, rupiah($kavling['jumlah_dp']));



        $this->mypdfi->SetFont('Times','',11);
        $this->mypdfi->text(140,69,"Palangka Raya, ".tgl_indo($tanggal));
        $this->mypdfi->text(152,85, 'Faisal Damanik');


       // 
        $this->mypdfi->Output();       

        // $pdfFilePath = FCPATH."/kartu_pdf/kartu_pelajar_".$siswa['id_siswa'].".pdf";

        // $this->mypdfi->Output($pdfFilePath, 'F');    

        // redirect('kartu/index/'.$siswa['id_siswa'],'refresh');     
	}



	function cetak($id){

        
		$this->db->join('kavling_peta b', 'a.id_kavling = b.id_kavling', 'left');
		$this->db->join('customer c', 'a.id_customer = c.id_customer', 'left');
		$kavling = $this->db->get_where('pembayaran a', array('a.id_pembayaran'=>$id))->row_array();
		$konfig = $this->db->get_where('konfigurasi a', array('a.id'=>'1'))->row_array();
        

        $config=array('orientation'=>'P','size'=>'A4');
        $this->load->library('MyPDF',$config);
        $this->mypdf->SetFont('Arial','B',10);
        $this->mypdf->SetLeftMargin(10);
        $this->mypdf->addPage();
        $this->mypdf->setTitle('Kwintasi Pembayaran');
        $this->mypdf->SetFont('Arial','B',14);

		//Master Desain background Kwitansi Pembayaran
		$this->mypdf->Image(base_url().'assets/aplikasi/kwitansi.jpg',10,10,190);
		// LOgo Kavling
		$this->mypdf->Image(base_url().'assets/aplikasi/'.$konfig['logo'],18,15,15);


		// Nomor Pembayaran_model $this->mypdfi->SetTextColor(229,8,8);
        $this->mypdf->SetFont('Arial','B',8);
		$this->mypdf->SetTextColor(229,8,8);
        $this->mypdf->text(158,33.7, $kavling['no_pembayaran']);
        $this->mypdf->SetTextColor(0,0,0);

		//Data Diri
		$this->mypdf->SetFont('Times','',12);
        $this->mypdf->text(65,39, $kavling['nama_lengkap']);
        $this->mypdf->text(65,47, ucwords(penyebut($kavling['jumlah_bayar'])).'Rupiah');
		if($kavling['pembayaran_ke']== '0'){
			if($kavling['jenis_pembelian']== '2'){
				$this->mypdf->text(65,55, "Pembayaran Pembelian ".$konfig['nama_kavling']." Blok ".$kavling['kode_kavling']);
			}else if($kavling['jenis_pembelian']== '3'){
				$this->mypdf->text(65,55, "Pembayaran DP Pembelian ".$konfig['nama_kavling']." Blok ".$kavling['kode_kavling']);
			}
		}else{
			$this->mypdf->text(65,55, "Pembayaran Cicilan kex ".$kavling['pembayaran_ke']." ".$konfig['nama_kavling']." Blok ".$kavling['kode_kavling']);
		}

        
        $this->mypdf->SetFont('Times','B',16);
        $this->mypdf->text(37,74, rupiah($kavling['jumlah_bayar']));



        $this->mypdf->SetFont('Times','',11);

		$this->mypdf->SetY(70);
		$this->mypdf->Cell(120,4,'',0,0,'C');
        $this->mypdf->Cell(60,4,'Palangka Raya, '.tgl_indo($kavling['tanggal']),0,0,'C');
		$this->mypdf->ln(21);
		$this->mypdf->Cell(120,4,'',0,0,'C');
        $this->mypdf->Cell(60,4,$konfig['nama_penandatangan'],0,0,'C');

		//Tanda Tangan
		$this->mypdf->Image(base_url().'assets/aplikasi/'.$konfig['file_ttd'],135,57,50);


		// Rekening Pembayaran
		$this->mypdf->SetFont('Times','',9);
		$this->mypdf->text(22,82,'Rekening Pembayaran : ');
		$this->mypdf->text(22,85,$konfig['nama_bank']);
		$this->mypdf->SetFont('Times','B',11);
		$this->mypdf->text(22,89,$konfig['no_rekening']);
		$this->mypdf->SetFont('Times','',10);
		$this->mypdf->text(22,92,$konfig['nama_pemilik_rek']);

		$namaFile = str_replace('/','-', $kavling['no_pembayaran']);
		$noFile = explode('-', $namaFile);
		

		if(file_exists('./kwitansi/'.$namaFile.'.pdf')){
			echo '';
		}else{
			$this->mypdf->Output('F', './kwitansi/kwitansi-'.$noFile[0].'.pdf', true);
		}
        $this->mypdf->Output();
    }



}
