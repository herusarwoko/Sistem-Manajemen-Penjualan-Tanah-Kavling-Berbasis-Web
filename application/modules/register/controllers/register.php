<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        // Load model
        $this->load->model('register_model');
    }

    public function index()
    {

        // Contoh pengaturan nilai variabel $konf
    $data['konf'] = array(
        'logo' => '1676870537867.png', // Ganti dengan nama logo yang sesuai
        // Tambahkan pengaturan lainnya sesuai kebutuhan
    );

    // Load view register_form.php dengan variabel $konf
    $this->load->view('view_register', $data);

    }

    public function process_register()
    {
        // Retrieve form data
        $data = array(
            'surname' => $this->input->post('surname'),
            'username' => $this->input->post('username'),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'email' => $this->input->post('email'),
            'is_admin' => 3, // Set nilai default is_admin
            // Isi data lainnya sesuai kebutuhan
        );
    
        // Insert data into database
        $result = $this->register_model->insert_user($data);
    
        // Check if registration was successful
        if ($result) {
            // Insert hak akses
            $inserted_id = $this->db->insert_id();
            $menu = $this->db->query("SELECT * FROM menu WHERE id_menu IN (1, 6, 26, 2, 34)")->result();
            foreach ($menu as $mn) {
                $this->db->insert('hak_akses', array('id_user' => $inserted_id, 'id_menu' => $mn->id_menu, 'status_hak' => '1'));
            }
    
            // Redirect to login page or any other page
            redirect('login');
        } else {
            // If registration failed, show error message or redirect to registration page
            echo "Registration failed!";
        }
    }
    
}
?>