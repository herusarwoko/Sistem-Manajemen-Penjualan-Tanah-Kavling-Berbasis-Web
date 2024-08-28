<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LandingPage extends CI_Controller {

    public function index()
    {
        $this->load->view('landing_page');
        // $this->load->view('template/header',$data);
        $this->load->view('template/footer');
    }
    
    public function ajax_edit($id)
	{
		$data = $this->db->query("SELECT * FROM kavling_peta a 
			LEFT JOIN customer b ON a.id_customer=b.id_customer 
			WHERE a.id_kavling = '$id' ")->row_array();
			$data['harga_jual'] = rupiah($data['hrg_jual']);
		echo json_encode($data);
	}
}
?>
