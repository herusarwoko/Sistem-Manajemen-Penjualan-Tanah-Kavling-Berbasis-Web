<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register_model extends CI_Model 
{
    public function __construct()
    {
        parent::__construct();
        // Load database library
        $this->load->database();
    }

    public function insert_user($data)
    {
        // Insert data into database
        $this->db->insert('users', $data);

        // Check if insertion was successful
        if ($this->db->affected_rows() > 0) {
            return true; // Jika berhasil
        } else {
            return false; // Jika gagal
        }
    }
}
?>
