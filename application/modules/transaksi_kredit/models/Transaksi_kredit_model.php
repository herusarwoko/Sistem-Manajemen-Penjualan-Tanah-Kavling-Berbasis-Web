<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_kredit_model extends CI_Model {

	var $table = 'transaksi_kavling';
	var $column_order = array('nama_lengkap','alamat','no_telp',null); //set column field database for datatable orderable
	var $column_search = array('nama_lengkap','alamat','no_telp'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('customer.id_customer' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);
		$this->db->join('customer', 'transaksi_kavling.id_customer = customer.id_customer', 'left');
		$this->db->join('kavling_peta', 'transaksi_kavling.id_kavling = kavling_peta.id_kavling', 'left');
		$this->db->where("lama_cicilan != '0'");

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{

		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);

		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_customer',$id);
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
		$this->db->delete($this->table, ['id_pembelian'=>$id]);
	}

	public function get_transaksi_by_id($id_pembelian) {
		$this->db->select('transaksi_kavling.*, customer.nama_lengkap, customer.no_telp');
		$this->db->from('transaksi_kavling');
		$this->db->join('customer', 'transaksi_kavling.id_customer = customer.id_customer', 'left');
		$this->db->where('transaksi_kavling.id_pembelian', $id_pembelian);
		return $this->db->get()->row();
	}
	

}
