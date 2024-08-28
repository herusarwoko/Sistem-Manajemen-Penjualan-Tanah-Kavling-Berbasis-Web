<?php
/**
 * MyPDF
 *
 * MyPDF 
 * This is codeigniter library for generating pdf using fpdf library (http://www.fpdf.org/).
 * Documentation for fpdf see http://www.fpdf.org/
 * The licence for fpdf see http://www.fpdf.org/
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2016 Indra Yoga Permana
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	MyPDF
 * @author	Indra Yoga P
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0 29/12/2016
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

spl_autoload_register(function ($class_name) {
    include APPPATH.'third_party/fpdf/FPDI-1.6.1/'. $class_name . '.php';
});

class MyPDFI extends FPDI {

    var $_tplIdx;
	var $fullPathToFile;
    function __construct($config=array()){
        parent::__construct();
        $this->fullPathToFile=$config['file'];
    }
    function Header() {


        if (is_null($this->_tplIdx)) {

            // THIS IS WHERE YOU GET THE NUMBER OF PAGES
            $this->numPages = $this->setSourceFile($this->fullPathToFile);
            $this->_tplIdx = $this->importPage(1);

        }
        $this->useTemplate($this->_tplIdx, 0, 0,200);

    }

    function Footer() {
      // Go to 1.5 cm from bottom
      $this->SetY(-15);
      // Select Arial italic 8
      $this->SetFont('Arial','I',8);

    }


}