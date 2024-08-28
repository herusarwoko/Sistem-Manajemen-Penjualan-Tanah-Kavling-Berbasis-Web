<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter HTML Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/html_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Heading
 *
 * Generates an HTML heading tag.  First param is the data.
 * Second param is the size of the heading tag.
 *
 * @access	public
 * @param	string
 * @param	integer
 * @return	string
 */
/**
 * Utilities
 * Fungsi-fungsi utility
 *
 * @access public
 * @author Agung Harry Purnama (agung.hp@awakami.com)
 * @since 7/21/2006 3:31PM
 */

/* ----------------------------------------------------------------------
 * DATE AND TIME FUNCTIONS
 * ---------------------------------------------------------------------- */

/**
 * convertDate
 * fungsi untuk melakukan konversi dari format dd-mm-yyyy ke yyyy-mm-dd atau sebaliknya
 * 
 * @author agung.hp
 * @since 09/10/2005 20:39
 * @param string date
 * @return string converted date
 */
 if ( ! function_exists('convertDate'))
{
	function convertDate($date){
		$date = trim($date);
		if (empty($date))    
			return NULL;

		$pieces = explode('-', $date);
		if (count($pieces) != 3)
			return NULL;
		
		return $pieces[2].'-'.$pieces[1].'-'.$pieces[0];    
	}
}

 if ( ! function_exists('convertDateByDelimiter'))
{
	function convertDateByDelimiter($date,$delimiter){
		$date = trim($date);
		if (empty($date))    
			return NULL;

		$pieces = explode($delimiter, $date);
		if (count($pieces) != 3)
			return NULL;
		
		return $pieces[2].'-'.$pieces[1].'-'.$pieces[0];    
	}
}

 if ( !function_exists('indexToBulan'))
{ 
	function indexToBulan($ddmmyyyy){
		$date = trim($ddmmyyyy);
		if (empty($date))    
			return NULL;

		$pieces = explode('-', $date);
		if (count($pieces) != 3)
			return NULL;
		$namabulan = array('01'=> 'Januari',
							'02'=> 'Februari',
							'03'=> 'Maret',
							'04'=> 'April',
							'05'=> 'Mei',
							'06'=> 'Juni',
							'07'=> 'Juli',
							'08'=> 'Agustus',
							'09'=> 'September',
							'10'=> 'Oktober',
							'11'=> 'Nopember',
							'12'=> 'Desember');    
		return $pieces[2].' '.$namabulan[$pieces[1]].' '.$pieces[0];        
	}
}

/* End of file html_helper.php */
/* Location: ./system/helpers/html_helper.php */
