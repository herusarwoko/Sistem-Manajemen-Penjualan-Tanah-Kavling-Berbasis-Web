<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking_model extends CI_Model 
{
    public function get_all_surat_tanah_progress()
    {
        return $this->db->get('progress_surat_tanah')->result_array();
    }

    public function tambah_surat_tanah($data)
    {
        $this->db->insert('progress_surat_tanah', $data);
    }

    public function get_surat_tanah_by_id($id)
    {
        return $this->db->get_where('progress_surat_tanah', array('id' => $id))->row_array();
    }

    public function edit_surat_tanah($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('progress_surat_tanah', $data);
    }

    public function hapus_surat_tanah($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('progress_surat_tanah');
    }
}
?>
