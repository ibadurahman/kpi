<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH."/third_party/tcpdf_6_2_8/tcpdf.php";

class Pdf extends TCPDF {
    public function __construct() {
        parent::__construct();
    }
}
