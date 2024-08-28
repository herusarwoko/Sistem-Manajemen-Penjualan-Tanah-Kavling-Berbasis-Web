<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userdb{

	/** @var codeigniter objek */
	protected $CI;
	protected $table='users';

	public function  __construct(){
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        $this->CI->load->helper('date');
	}


    /**
     * {@inheritDoc}
     */
    public function create(array $newUser){
		ignore_user_abort(true);
    	$newUser['password']=password_hash($newUser['password'], PASSWORD_DEFAULT);
    	$this->CI->db->insert($this->table,$newUser);
    	return $this->CI->db->insert_id();
    }

	public function update(array $newUser,$id) {
		ignore_user_abort(true);
    	if(isset($newUser['password']))$newUser['password']=password_hash($newUser['password'], PASSWORD_DEFAULT);
		$this->CI->db->update($this->table, $newUser,array('id'=>$id));			
		return true;
	}

	public function updateLogin($id) {
		$this->CI->db->update($this->table, array('last_login'=>mdate('%Y-%m-%d %h:%i:%s')),array('id'=>$id));			
		return true;
	}

	public function updateLogout($id) {
		$this->CI->db->update($this->table, array('last_logout'=>mdate('%Y-%m-%d %h:%i:%s')),array('id'=>$id));			
		return true;
	}

	public function getAll() {
		$this->CI->db->from($this->table);
		$query=$this->CI->db->get();
		return $query->result_array();
	}

	public function getById($id) {
		$this->CI->db->from($this->table)->where(array('id'=>$id));
		$query=$this->CI->db->get();
		return $query->row_array();
	}

	public function getStatus($id) {
		$this->CI->db->from($this->table)->where(array('id'=>$id));
		$query=$this->CI->db->get();
		$item=$query->row_array();
		return $item['status'];
	}

	public function getByUsername($username) {
		// $this->CI->db->from($this->table)->where(array('NIP'=>$username));
		$this->CI->db->from($this->table)->where(array('username'=>$username));
		$query=$this->CI->db->get();
		return $query->row_array();
	}

	public function getByUsernameOPD($username) {
		$this->CI->db->from('master_skpd')->where(array('KOLOK'=>$username));
		$query=$this->CI->db->get();
		return $query->row_array();
	}

	public function getByEmail($email) {
		$this->CI->db->from($this->table)->where(array('email'=>$email));
		$query=$this->CI->db->get();
		return $query->row_array();
	}

	public function deleteById($id) {
		$this->CI->db->delete($this->table, array('id'=>$id));			
		return true;
	}

	public function blockById($id) {
		$this->CI->db->update($this->table,array('status'=>'BLOKIR'), array('id'=>$id));			
		return true;
	}

	public function activatedById($id) {
		$this->CI->db->update($this->table,array('status'=>'AKTIF'), array('id'=>$id));			
		return true;
	}

	public function blockByUsername($username) {
		$this->CI->db->update($this->table,array('status'=>'BLOKIR'), array('id'=>$username));			
		return true;
	}

}