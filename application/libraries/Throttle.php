<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Throttle{

	private $limitActionLogin=3;
	private $limitActionRegister=3;
	private $limitActionConfirmEmail=1;
	private $timeout=3;
	/** @var codeigniter objek */
	protected $CI;

	public function  __construct($config = array()){
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        $this->initialize($config);
        $this->CI->load->library('userdb');
	}

	/**
	 * Initialize preferences
	 *
	 * @param	array	$config
	 * @return	object
	 */
	public function initialize($config = array())
	{
		if(empty($config))return $this;
		foreach ($config as $key => $val)
		{
			if (isset($this->$key))
			{
				$this->$key = $val;
			}
		}

		return $this;
	}


    public function addAttempts($type, $username='NULL'){
        $ip = $this->CI->input->ip_address();
        $data=array(
        	'type'=>$type,
        	'username'=>$username,
        	'ip'=>$ip
        	);
        $this->CI->db->insert('throttle',$data);

        $attempts = $this->CI->db->get_where('throttle',array('ip'=>$ip,'type'=>$type,'username'=>$username))->num_rows();

        return $attempts;
    }

    public function getAttempts($type,$ip, $username='NULL'){
        $attempts = $this->CI->db->get_where('throttle',array('ip'=>$ip,'type'=>$type,'username'=>$username))->num_rows();
        return $attempts;
    }

    public function getAttemptsByIP($type,$ip){
        $attempts = $this->CI->db->get_where('throttle',array('ip'=>$ip,'type'=>$type))->num_rows();
        return $attempts;
    }

    public function removeAttempts(){
        $formatted_current_time = date("Y-m-d H:i:s", strtotime('-' . (int)$this->timeout . ' minutes'));
        $modifier =  ' BETWEEN "1970-00-00 00:00:00" and ' . $formatted_current_time;

        return $this->CI->db->where(array('created_at' => $modifier))->delete('throttle');
	}

    public function removeAttemptsByIP(){
        $ip = $this->CI->input->ip_address();
        return $this->CI->db->where(array('ip' => $ip))->delete('throttle');
	}
}