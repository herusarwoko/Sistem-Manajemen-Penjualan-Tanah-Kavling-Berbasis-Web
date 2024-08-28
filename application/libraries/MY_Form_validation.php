<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation{

    public function __construct($config = array()){
            parent::__construct($config);
    }
	
	/**
	 * is_date
	 *
	 * @param	string => dd-mm-yyyy
	 * @return	bool
	 */
	public function is_date($str){
		$date = trim($str);
		if (empty($date))
			return false;
		
		// 2. check length
		if (strlen($date) != 10){
			return false;
		}
		// 3. check num index
		$pieces = explode('-', $date);
		if (count($pieces) != 3)
			return false;
		
		$day = $pieces[0];
		$month = $pieces[1];
		$year = $pieces[2];
		
		// 4. check data type
		if (!is_numeric($month) || !is_numeric($day) || !is_numeric($year))
			return false;
		
		// 5. check date value
		if (!checkdate($month, $day, $year))
			return false;
		
		// valid 
		return true;		
	}
}
?>
