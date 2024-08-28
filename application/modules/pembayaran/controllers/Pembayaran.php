<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller {

   var $data_ref = array('uri_controllers' => 'pembayaran');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pembayaran_model','pembayaran');
		// $this->load->model('Group/Group_model','group');

		check_login();
	}

	public function index()
    {

      $user_data['data_ref'] = $this->data_ref;
      $user_data['menu_active'] = 'Data Referensi';
      $user_data['sub_menu_active'] = 'Sekolah';
        
      $this->load->view('template/header',$user_data);
        $this->load->view('view',$user_data);
      // $this->load->view('template/footer',$user_data);

    }

    public function detail($id)
    {
        $user_data['data_ref'] = $this->data_ref;
        $user_data['cust'] = $this->db->query("SELECT * FROM kavling_peta k 
            LEFT JOIN customer c ON k.id_customer = c.id_customer 
            LEFT JOIN transaksi_kavling t ON k.id_kavling = t.id_kavling 
            WHERE k.id_kavling = '$id'")->row_array();
        $user_data['id_kavling'] = $id;
        //cari cicilan ke
        $pemKe = $this->db->query("SELECT MAX(pembayaran_ke) as besar FROM pembayaran WHERE id_kavling='$id'")->row_array();
        $user_data['pembayaranKe'] = $pemKe['besar'] + 1;
        // data rekening
        $user_data['rekening'] = $this->db->query("SELECT * FROM bank")->result();
        $this->load->view('template/header',$user_data);
        $this->load->view('detail',$user_data);
    }

    public function ajax_list()
    {

        $list = $this->pembayaran->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $post) {

            if($post->status == '0' || $post->status == '1'){
                $link_edit = '<a class="btn btn-sm btn-secondary" disabled><i class="glyphicon glyphicon-pencil"></i> Detail Transaksi</a>';
            }else{
                $link_edit = '<a class="btn btn-sm btn-primary" href="'.base_url('pembayaran/detail/'.$post->id_kavling ).'" ><i class="glyphicon glyphicon-pencil"></i> Detail Transaksi</a>';
            }
                

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $post->kode_kavling.'<br><b>'.$post->luas_tanah.' </b>meter';
            $row[] = $post->nama_lengkap;
            $row[] = rupiah($post->luas_tanah * $post->hrg_meter);

            if($post->status == '0'){
                $row[] = '<span class="btn btn-secondary btn-sm">Kosong</span>';
            }elseif($post->status == '1'){
                $row[] = '<span class="btn btn-warning btn-sm">Booking</span>';
            }elseif($post->status == '2'){
                $row[] = '<span class="btn btn-primary btn-sm">Cash</span>';
            }elseif($post->status == '3'){
                $row[] = '<span class="btn btn-info btn-sm">Kredit</span>';
            }else{
                $row[] = 'Pengurus';
            }
            

            //add html for action
            $row[] = $link_edit;
            

            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->pembayaran->count_all(),
                        "recordsFiltered" => $this->pembayaran->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

        private function _do_upload()
       {
          $config['upload_path']          = './assets/berita/';
          $config['allowed_types']        = 'gif|jpg|png';
          $config['max_size']             = 0; //set max size allowed in Kilobyte
          $config['max_width']            = 0; // set max width image allowed
          $config['max_height']           = 0; // set max height allowed
          $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
     
          $this->load->library('upload', $config);
            $this->upload->initialize($config); //Make configure upload
    
          if (!$this->upload->do_upload('image')) //upload and validate
          {
             $data['inputerror'][] = 'image';
             $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
             $data['status'] = FALSE;
             echo json_encode($data);
             exit();
          }
          return $this->upload->data('file_name');
       }

	public function ajax_bayar($cicilanKe, $idKavling)
	{
		//Buat Nomor pembayaran
		$tahun = date('Y');
		$jBayar = $this->input->post('jumlah_bayar');
		$tglBayar = $this->input->post('tanggal_bayar');
		$rekening = $this->input->post('rekening');
		$nmr = $this->db->query("SELECT MAX(no_pembayaran) as besar FROM pembayaran WHERE no_pembayaran like '%$tahun'")->row_array();
		$noSekarang = $nmr['besar'];

		$urutan = (int) substr($noSekarang, 0, 5);
        $urutan++;
        $huruf = "/BYR-KAV/$tahun";
        $noPembayaran = sprintf("%05s", $urutan).$huruf;


		//cari data kavling
		$trx = $this->db->query("SELECT * FROM transaksi_kavling WHERE id_kavling ='$idKavling'")->row_array();
		//Input pembayaran
		$param = array(
			'id_customer' 	=> $trx['id_customer'],
			'no_pembayaran' => $noPembayaran,
			'id_kavling' 	=> $idKavling,
			'tanggal' 		=> $tglBayar,
			'pembayaran_ke' => $cicilanKe,
			'jumlah_bayar' 	=> str_replace('.','', $jBayar) ,
			'id_bank'		=> $rekening
		);
		$this->db->insert('pembayaran', $param);


		 // Upload gambar pembayaran
		 if (!empty($_FILES['bukti_pembayaran']['name'])) {
			$config['upload_path']   = './assets/bukti_trx/bayar_angsuran/';
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
				$this->db->where('id_kavling', $idKavling)->update('pembayaran', array('bukti_pembayaran' => $file_name));
			}
		}



		$kav = $this->db->query("SELECT * FROM kavling_peta WHERE id_kavling='$idKavling'")->row_array();
		$idCust = $trx['id_customer'];
		$cus = $this->db->query("SELECT * FROM customer WHERE id_customer='$idCust'")->row_array();
// 		$kate = $this->db->query("SELECT * FROM kategori WHERE id_customer='$idCust'")->row_array();
		$deskripsi = "Pembayaran Cicilan ke : ".$cicilanKe.", Kavling ".$kav['kode_kavling']." a.n ".$cus['nama_lengkap'];

		//masukkan table transaksi
		$paramTrx = array(
			'transaksi_tanggal' 	=> tgl_now(),
			'transaksi_jenis' 		=> 'Pemasukan',
			'transaksi_kategori' 	=> '',
			'transaksi_barang' 		=> $idKavling,
			'transaksi_nominal' 	=> $trx['cicilan_per_bulan'],
			'transaksi_keterangan' 	=> $deskripsi,
			'transaksi_bank'		=> ''
		);
		$this->db->insert('transaksi', $paramTrx);


		echo json_encode(array("status" => TRUE));
	}

	public function ajax_add()
	{

		// $this->_validate();
		$post_date = time();
		$post_date_format = date('Y-m-d h:i:s', $post_date);
      // $user = $this->ion_auth->user()->row();
		$data = array(
				'tanggal' 	=> date('Y-m-d'),
				'judul' 	=> $this->input->post('judul'),
				'isi_agenda' 	=> $this->input->post('judul'),
				'status' 	=> $this->input->post('status_agenda'),
            	'is_trash' 	=> 0
		);

		
		$insert = $this->pembayaran->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
			'kode_kavling'	=> $this->input->post('kode_kavling'),
			'luas_tanah'	=> $this->input->post('luas_tanah'),
			'hrg_meter'		=> $this->input->post('harga_per_meter'),
			'hrg_jual'		=> $this->input->post('harga_jual'),
			'jenis_map'		=> $this->input->post('jenis_map'),
			'map'			=> $this->input->post('map')

		);



		$this->db->update('kavling', $data , array('id_kavling' => $this->input->post('id')));
		echo json_encode(array("status" => TRUE));
	}






	public function cetak_cicilan($id){
		// $this->db->from('kavling_peta a');
		$this->db->join('kavling_peta b', 'a.id_kavling = b.id_kavling', 'left');
		$this->db->join('customer c', 'a.id_customer = c.id_customer', 'left');
		$kavling = $this->db->get_where('pembayaran a', array('a.id_pembayaran'=>$id))->row_array();
		// $kavling = $this->db->query("SELECT * FROM  WHERE id_kavling = $id")->row_array();

        $file=VIEWPATH."template\kwitansi.pdf";
        $config=array('file'=>$file);
        $config['jasi']=$config;


        $this->load->library('MyPDFI',$config);
        $this->mypdfi->AddPage();
        $this->mypdfi->SetFont('Arial','',6);

		// $tanggal        = date("Y-m-d");
		$tanggal        = $kavling['tanggal'];

		$this->mypdfi->Image('http://localhost/cicilan/assets/ttd.png',130,63,50);

		
        // $this->mypdfi->SetFont('Arial','B',9);


        //Data AK 1
        $this->mypdfi->SetTextColor(229,8,8);
        $this->mypdfi->SetFont('Arial','B',9);

        
        $this->mypdfi->text(163,28, $kavling['no_pembayaran']);

        $this->mypdfi->SetTextColor(0,0,0);


        // $this->mypdfi->text(90,28,$siswa['kode_kelas']);
        $this->mypdfi->SetFont('Times','',12);

        //Data Diri
        $this->mypdfi->text(60,33, $kavling['nama_lengkap']);
        $this->mypdfi->text(60,41, ucwords(penyebut($kavling['jumlah_bayar'])).'Rupiah');
        
        $this->mypdfi->text(60,49, "Pembayaran Cicilan ke ".$kavling['pembayaran_ke']." Kavling MINAS Blok ".$kavling['kode_kavling']);

        
        $this->mypdfi->SetFont('Times','B',16);
        $this->mypdfi->text(35,69.5, rupiah($kavling['jumlah_bayar']));



        $this->mypdfi->SetFont('Times','',11);
        $this->mypdfi->text(135,69,"Palangka Raya, ".tgl_indo($tanggal));
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
        $this->mypdf->text(65,55, "Pembayaran Cicilan ke ".$kavling['pembayaran_ke']." ".$konfig['nama_kavling']." Blok ".$kavling['kode_kavling']);

        
        $this->mypdf->SetFont('Times','B',16);
        $this->mypdf->text(37,74, rupiah($kavling['jumlah_bayar']));



        $this->mypdf->SetFont('Times','',11);

		$this->mypdf->SetY(70);
		$this->mypdf->Cell(120,4,'',0,0,'C');
        $this->mypdf->Cell(60,4,$konfig['kota_penandatanganan'].', '.tgl_indo($kavling['tanggal']),0,0,'C');
		$this->mypdf->ln(21);
		$this->mypdf->Cell(120,4,'',0,0,'C');
        $this->mypdf->Cell(60,4,$konfig['nama_penandatangan'],0,0,'C');

		//Tanda Tangan
		$this->mypdf->Image(base_url().'assets/aplikasi/'.$konfig['file_ttd'],127,67,70);


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



	function cetak_rekap($id_kavling){

        
		// $this->db->join('kavling_peta b', 'a.id_kavling = b.id_kavling', 'left');
		$this->db->join('customer c', 'a.id_customer = c.id_customer', 'left');
		$kavling = $this->db->get_where('kavling_peta a', array('a.id_kavling'=>$id_kavling))->row_array();
		$konfig = $this->db->get_where('konfigurasi a', array('a.id'=>'1'))->row_array();      
		
		//Harga Jual Kavling
		$hrg = $this->db->query("SELECT * FROM transaksi_kavling WHERE id_kavling = '$id_kavling'")->row_array();
		$hrgJual = $hrg['jumlah_dp'] + ($hrg['cicilan_per_bulan'] * $hrg['lama_cicilan']);
        $config=array('orientation'=>'P','size'=>'A4');
        $this->load->library('MyPDF',$config);
        $this->mypdf->SetFont('Arial','B',10);
        $this->mypdf->SetLeftMargin(10);
        $this->mypdf->addPage();
        $this->mypdf->setTitle('Kwintasi Pembayaran');
        $this->mypdf->SetFont('Arial','B',18);

		//Master Desain background Kwitansi Pembayaran
		// $this->mypdf->Image(base_url().'assets/aplikasi/kwitansi.jpg',10,10,190);
		// LOgo Kavling
		$this->mypdf->Image(base_url().'assets/aplikasi/'.$konfig['logo'],18,10,15);
		$this->mypdf->Cell(190,8,$konfig['nama_perusahaan'],0,1,'C');
		$this->mypdf->SetFont('Arial','',9);
		$this->mypdf->Cell(190,4,$konfig['alamat'],0,1,'C');
		$this->mypdf->Cell(190,4,'TLP/WA :'.$konfig['hape'],0,1,'C');

		$this->mypdf->SetLineWidth(1);
		$this->mypdf->Line(15,30,190,30);
		$this->mypdf->SetLineWidth(0.3);
		$this->mypdf->Line(15,31,190,31);


        $this->mypdf->SetFont('Arial','B',8);
		$this->mypdf->SetTextColor(229,8,8);
        // $this->mypdf->text(158,33.7, $kavling['no_pembayaran']);
        $this->mypdf->SetTextColor(0,0,0);

		$this->mypdf->Ln(7);    
		$this->mypdf->SetFont('Times','B',10);  
		$this->mypdf->SetTextColor(218,0,0);
		$this->mypdf->Cell(190,8,'TABLE ANGSURAN',0,1,'C');
		$this->mypdf->SetTextColor(0,0,0);

		$this->mypdf->SetLineWidth(0.1);
		$this->mypdf->SetFont('Times','',9);  

		$this->mypdf->Cell(5,6,'',0,0,'L');
		$this->mypdf->Cell(21,6,'Nama ',0,0,'L');
		$this->mypdf->Cell(3,6,':',0,0,'L');
		$this->mypdf->Cell(35,6, $kavling['nama_lengkap'],0,0,'L');
		$this->mypdf->Cell(5,6,'',0,0,'L');
		$this->mypdf->Cell(21,6,'No KAV',0,0,'L');
		$this->mypdf->Cell(3,6,':',0,0,'L');
		$this->mypdf->Cell(25,6, $kavling['kode_kavling'],0,0,'L');
		$this->mypdf->Cell(5,6,'',0,0,'L');
		$this->mypdf->Cell(25,6,'Jumlah Harga',0,0,'L');
		$this->mypdf->Cell(3,6,':',0,0,'L');
		$this->mypdf->Cell(30,6, rupiah($hrgJual),0,1,'L');

		$this->mypdf->Cell(5,6,'',0,0,'L');
		$this->mypdf->Cell(21,6,'No. KTP ',0,0,'L');
		$this->mypdf->Cell(3,6,':',0,0,'L');
		$this->mypdf->Cell(35,6, $kavling['no_ktp'],0,0,'L');
		$this->mypdf->Cell(5,6,'',0,0,'L');
		$this->mypdf->Cell(21,6,'BLOK',0,0,'L');
		$this->mypdf->Cell(3,6,':',0,0,'L');
		$this->mypdf->Cell(25,6,'-',0,0,'L');
		$this->mypdf->Cell(5,6,'',0,0,'L');
		$this->mypdf->Cell(25,6,'Surat-surat',0,0,'L');
		$this->mypdf->Cell(3,6,':',0,0,'L');
		$this->mypdf->Cell(30,6,'-',0,1,'L');
		
		$this->mypdf->Cell(5,6,'',0,0,'L');
		$this->mypdf->Cell(21,6,'No. KK ',0,0,'L');
		$this->mypdf->Cell(3,6,':',0,0,'L');
		$this->mypdf->Cell(35,6, $kavling['no_kk'],0,0,'L');
		$this->mypdf->Cell(5,6,'',0,0,'L');
		$this->mypdf->Cell(21,6,'Luas',0,0,'L');
		$this->mypdf->Cell(3,6,':',0,0,'L');
		$this->mypdf->Cell(25,6, $kavling['luas_tanah'],0,0,'L');
		$this->mypdf->Cell(5,6,'',0,0,'L');
		$this->mypdf->Cell(25,6,'Atas Nama Surat',0,0,'L');
		$this->mypdf->Cell(3,6,':',0,0,'L');
		$this->mypdf->Cell(30,6,'-',0,1,'L');

		$this->mypdf->Cell(5,6,'',0,0,'L');
		$this->mypdf->Cell(21,6,'Alamat ',0,0,'L');
		$this->mypdf->Cell(3,6,':',0,0,'L');
		$this->mypdf->Cell(100,6, $kavling['alamat'],0,1,'L');

		//tabel
		$this->mypdf->SetFont('Times','B',9);  
		$this->mypdf->setFillColor(211,236,230); 
		$this->mypdf->Ln(5);    
		$this->mypdf->Cell(5,10,'',0,0,'C');
		$this->mypdf->Cell(8,10,'No. ',1,0,'C', 1);
		$this->mypdf->Cell(38,10,'Hari / Tanggal',1,0,'C', 1);
		$this->mypdf->Cell(30,10, 'Angsuran',1,0,'C', 1);
		$this->mypdf->Cell(30,10,'Sisa Angsuran',1,0,'C', 1);
		$this->mypdf->Cell(25,10,'Paraf',1,0,'C', 1);
		$this->mypdf->Cell(45,10,'Keterangan',1,1,'C', 1);

		$no = 1;
		$sisa = $hrgJual;
		$this->mypdf->SetFont('Times','',9);  
		$bayar = $this->db->query("SELECT * FROM pembayaran WHERE id_kavling='$id_kavling' ORDER BY pembayaran_ke ASC")->result();
		foreach($bayar as $byr){
			$sisa = $sisa - $byr->jumlah_bayar;
			$keterangan = explode('#', $byr->deskripsi);
			if($no % 2 == 0){
				$this->mypdf->setFillColor(255,243,243); 
			}else{
				$this->mypdf->setFillColor(255,255,255); 
			}
			$this->mypdf->Cell(5,10,'',0,0,'C');
			$this->mypdf->Cell(8,10,$no++,1,0,'C', 1);
			$this->mypdf->Cell(38,10, tgl_indo($byr->tanggal),1,0,'C', 1);
			$this->mypdf->Cell(30,10, rupiah($byr->jumlah_bayar),1,0,'C', 1);
			$this->mypdf->Cell(30,10, rupiah($sisa) ,1,0,'C', 1);
			$this->mypdf->Cell(25,10,'',1,0,'C', 1);
			$this->mypdf->Cell(45,10, $keterangan[0],1,1,'L', 1);
		}

		$this->mypdf->Ln(2);    
		$this->mypdf->SetFont('Times','',7);  
		$this->mypdf->Cell(5,3,'',0,0,'C', 1);
		$this->mypdf->Cell(45,3,'Catatan :',0,1,'L');
		$this->mypdf->Cell(5,3,'',0,0,'C', 1);
		$this->mypdf->Cell(45,3,'- Bukti Pembayaran dinyatakan sah apabila disertai kwitansi dari tangan Pemilik Kavling.',0,1,'L');
		$this->mypdf->Cell(5,3,'',0,0,'C', 1);
		$this->mypdf->Cell(45,3,'- Apabila ada yang mengaku-ngaku petugas kami "Pesona Mentaya" meminta/menagih pembayaran angsuran "HATI-HATI PENIPUAN".',0,1,'L');
		$this->mypdf->Cell(5,3,'',0,0,'C', 1);
		$this->mypdf->Cell(45,3,'- Konsumen bisa menanyakan/menghubungi informasi "Pesona Mentaya" 0895 33858 5301.',0,1,'L');

		$this->mypdf->Ln(10);  
		$this->mypdf->SetFont('Times','',9);  
		$this->mypdf->Cell(5,3,'',0,0,'C', 1);$this->mypdf->Cell(70,3,'Mengetahui',0,0,'C');
		$this->mypdf->Cell(5,3,'',0,0,'C', 1);$this->mypdf->Cell(70,3,'Menyetujui',0,1,'C');

		$this->mypdf->Ln(22);  
		$this->mypdf->SetFont('Times','B',9);  
		$this->mypdf->Cell(5,3,'',0,0,'C', 1);$this->mypdf->Cell(70,3, strtoupper($konfig['nama_penandatangan']),0,0,'C');
		$this->mypdf->Cell(5,3,'',0,0,'C', 1);$this->mypdf->Cell(70,3,strtoupper($konfig['nama_mengetahui']),0,1,'C');


		

		

		//Data Diri
		// $this->mypdf->SetFont('Times','',12);
        // $this->mypdf->text(65,39, $kavling['nama_lengkap']);
        // $this->mypdf->text(65,47, ucwords(penyebut($kavling['jumlah_bayar'])).'Rupiah');
        // $this->mypdf->text(65,55, "Pembayaran Cicilan ke ".$kavling['pembayaran_ke']." ".$konfig['nama_kavling']." Blok ".$kavling['kode_kavling']);

        
        $this->mypdf->SetFont('Times','B',16);
        // $this->mypdf->text(37,74, rupiah($kavling['jumlah_bayar']));



        $this->mypdf->SetFont('Times','',11);

		$this->mypdf->SetY(70);
		$this->mypdf->Cell(120,4,'',0,0,'C');
        // $this->mypdf->Cell(60,4,'Palangka Raya, '.tgl_indo($kavling['tanggal']),0,0,'C');
		$this->mypdf->ln(21);
		$this->mypdf->Cell(120,4,'',0,0,'C');
        // $this->mypdf->Cell(60,4,$konfig['nama_penandatangan'],0,0,'C');

		//Tanda Tangan
		// $this->mypdf->Image(base_url().'assets/aplikasi/'.$konfig['file_ttd'],135,57,50);


		// Rekening Pembayaran
		// $this->mypdf->SetFont('Times','',9);
		// $this->mypdf->text(22,82,'Rekening Pembayaran : ');
		// $this->mypdf->text(22,85,$konfig['nama_bank']);
		// $this->mypdf->SetFont('Times','B',11);
		// $this->mypdf->text(22,89,$konfig['no_rekening']);
		// $this->mypdf->SetFont('Times','',10);
		// $this->mypdf->text(22,92,$konfig['nama_pemilik_rek']);

		$namaFile = str_replace('/','-', '0123/KNG/2022');
		$noFile = explode('-', $namaFile);
		

		if(file_exists('./kwitansi/'.$namaFile.'.pdf')){
			echo '';
		}else{
			$this->mypdf->Output('F', './kwitansi/kwitansi-'.$noFile[0].'.pdf', true);
		}
        

        $this->mypdf->Output();
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

	public function balikin()
	{
		//Buat Nomor pembayaran
		$tahun = date('Y');
		$jBayar = $this->input->post('jumlah_pengembalian');
		$tglBayar = $this->input->post('tanggal_bayar');
		$rekening = $this->input->post('rekening');
		$idKavling = $this->input->post('id_kavling');
		$nama_lengkap = $this->input->post('nama_lengkap');
		$kode_kavling = $this->input->post('kode_kavling');
		$biaya_admin = $this->input->post('biaya_admin');

		$deskripsi = 'Pembatalan transaksi Pembelian Kavling '.$kode_kavling.' a.n '.$nama_lengkap.'. Biaya Admin '.$biaya_admin;

		//masukkan table transaksi
		$paramTrx = array(
			'transaksi_tanggal' 	=> tgl_now(),
			'transaksi_jenis' 		=> 'Pengeluaran',
			'transaksi_kategori' 	=> '',
			'transaksi_barang' 		=> $idKavling,
			'transaksi_nominal' 	=> $jBayar,
			'transaksi_keterangan' 	=> $deskripsi,
			'transaksi_bank'		=> ''
		);
		$this->db->insert('transaksi', $paramTrx);


		// netralkan table kavling_peta
		$this->db->query("UPDATE kavling_peta SET status='0', id_customer='0', id_marketing='0', tgl_jatuh_tempo='0' WHERE id_kavling='$idKavling'");
		// hapus history pembayaran cicilan
		$this->db->query("DELETE FROM pembayaran WHERE id_kavling='$idKavling'");
		// hapus Transaksi Pembelian Kavling
		$this->db->query("DELETE FROM transaksi_kavling WHERE id_kavling='$idKavling'");

		echo json_encode(array("status" => TRUE));
	}

}
