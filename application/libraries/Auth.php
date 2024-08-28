<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth{

	const THROTTLE_ACTION_LOGIN = 'login';
	const THROTTLE_ACTION_REGISTER = 'register';
	const THROTTLE_ACTION_CONSUME_TOKEN = 'confirm_email';

	protected $CI;
	private $id;
	private $surname;
	private $nip;
	private $NIP;
	private $EMAIL;
	private $IDPEGAWAI;
	private $username;
	private $email;
	private $jenis_pengguna;
	private $stt_mediator;
	private $password;
	private $created_at;
	private $updated_at;
	private $status;
	private $last_login;
	private $last_logout;
	private $is_admin;
	private $access;
	private $attempts;
	private $needCaptha=false;

	public function __construct(){
		$this->CI=& get_instance();
	    $this->CI->load->library(array('userdb','throttle','encryption'));
		if(!empty($this->CI->session->id)){
			$userData=$this->CI->userdb->getById($this->CI->encryption->decrypt($this->CI->session->id));
			$this->initialize($userData);
		}

	}

	public function initialize(array $userData){
		if(!empty($userData)){
			foreach ($userData as $key => $value) {
				# code...
				if(property_exists($this, $key)){
					$this->{$key}=$value;
				}
			}
		}
	}

	public function getUser(){
		return array($this->id,
					$this->surname,
					$this->nip,
					$this->created_at,
					$this->updated_at,
					$this->email,
					$this->status,
					$this->last_logout,
					$this->last_login
						);		
	}

	public function register(array $user){
		$idNewUser=$this->userdb->create($user);
		return $this->userdb->getById($idNewUser);
	}

	public function check($access){
		if(empty($this->id))return false;
		if($this->is_admin)return true;
		$accessUser=unserialize($this->access);
		if(in_array($access,$accessUser)){
			return true;
		}
		return false;
	}

	public function login($username,$password,$captcha=false){
		$status=$this->isBlockedByAttempts(self::THROTTLE_ACTION_LOGIN,$username);
		if($status)return false;
		if($this->needCaptha && !$captcha)return false;
		$userData=$this->CI->userdb->getByUsername($username);
		if(!empty($userData)){
			$this->CI->throttle->addAttempts(self::THROTTLE_ACTION_LOGIN,$username);
			if (password_verify($password, $userData['password'])) {
				if($userData['status']=='BLOKIR'){
					return false;
				}
				// $this->CI->userdb->updateLogin($userData['id']);
				$this->onLoginSuccessful($userData);
				return true;
			}else {
				return false;
			}
		}
		return false;
	}


	public function loginByEmail($email,$password,$captcha=false){
		$status=$this->isBlockedByAttempts(self::THROTTLE_ACTION_LOGIN,$username);
		if($status)return false;
		if($this->needCaptha && !$captcha)return false;
		$userData=$this->CI->userdb->getByUsername($username);
		if(!empty($userData)){
			$this->CI->throttle->addAttempts(self::THROTTLE_ACTION_LOGIN,$username);
			if (password_verify($password, $userData['password'])) {
				if($userData['status']=='BLOKIR'){
					return false;
				}
				// $this->CI->userdb->updateLogin($userData['id']);
				$this->onLoginSuccessful($userData);
				return true;
			}else {
				return false;
			}
		}
		return false;
	}


	public function isBlockedByAttempts($type,$username=NULL){
        $ip = $this->CI->input->ip_address();
		$this->CI->throttle->removeAttempts();
		if($this->CI->throttle->getAttemptsByIP($type,$ip)>5){
			$this->needCaptha=true;
		}

		if($this->CI->throttle->getAttempts($type,$ip,$username)>5){
			$this->CI->userdb->blockByUsername($username);
			return true;
		}
		return false;
	}

	public function onLoginSuccessful(array $user) {
		$this->CI->throttle->removeAttemptsByIP();
		$this->initialize($user);
		$newdata = array(
		        'id'  		=> $this->CI->encryption->encrypt($this->id),
		        'username'  => $this->CI->encryption->encrypt($this->username),
		        'is_admin'  => $this->CI->encryption->encrypt($this->is_admin),
		        'email'  	=> $this->CI->encryption->encrypt($this->email),
		        'logged_in' => TRUE
		);

		$this->CI->session->set_userdata($newdata);		
	}


	public function logout(){
		// $this->CI->userdb->updateLogout($this->CI->encryption->decrypt($this->CI->session->id));			
		$this->CI->session->sess_destroy();		
		return true;		
	}

}