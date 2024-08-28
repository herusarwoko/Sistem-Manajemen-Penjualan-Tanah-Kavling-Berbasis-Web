<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));	
	}
	
	public function index()
	{
		$data=array();
		$csrf = array(
		        'name' => $this->security->get_csrf_token_name(),
		        'hash' => $this->security->get_csrf_hash()
		    );
		$data=array('csrf'=>$csrf);	
		$data['konf'] = $this->db->get_where('konfigurasi', array('id'=>'1'))->row_array();
		$this->load->view('login',$data);
	}



	public function loginadmin(){
		$this->load->library(array('auth'));	

		if($this->auth->login($this->input->post('username'),$this->input->post('pass'))){

			redirect('dashboard','refresh');
		}else{
			// echo "salah";
			redirect('login');	
		}	

	}

	public function _validasiFormLogin(){
        $this->form_validation->set_rules('username', 'Username', 'required',
                array('required' => ' %s Harus Di isi.')
        );

        $this->form_validation->set_rules('password', 'Password', 'required',
                array('required' => ' %s Harus Di isi.')
        );
        if ($this->form_validation->run() == FALSE)
        {
                return false;
        }
        else
        {
                return true;
        }

	}

	function logout(){
		//$this->CI->userdb->updateLogout($this->CI->encryption->decrypt($this->CI->session->id));	

		session_unset(); 		
		$this->session->sess_destroy();		
		redirect('login');
	}


}