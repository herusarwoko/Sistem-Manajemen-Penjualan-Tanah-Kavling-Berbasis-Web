<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SuratTanah extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        // Load model dengan benar
        $this->load->model('Tracking_model');
        $this->load->library('form_validation');
        // Periksa status login
        // Sesuaikan dengan mekanisme autentikasi Anda
        check_login();
    }

    public function index()
    {
        // Panggil fungsi model untuk mendapatkan semua data progress surat tanah
        $data['surat_tanah_progress'] = $this->Tracking_model->get_all_surat_tanah_progress();

        $this->load->view('template/header', $data);
        $this->load->view('template/footer', $data);
        $this->load->view('view_surat', $data);
    }

    public function tambah()
    {
        $data = array(
            'nomor_surat_tanah' => $this->input->post('nomor_surat_tanah'),
            'status' => $this->input->post('status'),
            'tanggal_update' => $this->input->post('tanggal_update')
        );
    
        $this->Tracking_model->tambah_surat_tanah($data);
        redirect('surattanah');
    }
    
    public function edit($id)
    {
        $data = array(
            'nomor_surat_tanah' => $this->input->post('nomor_surat_tanah'),
            'status' => $this->input->post('status'),
            'tanggal_update' => $this->input->post('tanggal_update')
        );
    
        $this->Tracking_model->edit_surat_tanah($id, $data);
        redirect('surattanah');
    }
    
    public function hapus($id)
    {
        $this->Tracking_model->hapus_surat_tanah($id);
        redirect('surattanah');
    }
    
}
?>
