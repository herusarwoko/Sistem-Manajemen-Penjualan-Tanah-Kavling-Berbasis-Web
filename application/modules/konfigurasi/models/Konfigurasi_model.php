<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfigurasi_model extends CI_Model {

	var $table = 'konfigurasi';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	

	function count_filtered()
	{
		$this->_get_datatables_query();
		$data = array(
			'is_trash ' => 0
		);
		$this->db->where($data);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$data = array(
			'is_trash ' => 0
		);
		$this->db->where($data);
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$data = array(
			'is_trash ' => 1
		);

		$this->db->set($data);
		$this->db->where('id', $id);
		$this->db->update($this->table);
	}

}
