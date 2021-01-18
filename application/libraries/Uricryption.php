<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uricryption {

    protected $CI;
	function __construct()
	{
            $this->CI =& get_instance();
            $this->CI->load->library('encrypt');
	}
        
        public function encode($data_key)
        {
            return str_replace(array('/'),array('-'),$this->CI->encrypt->encode($data_key));
        }

        public function decode($e_key)
        {
            $dekey = str_replace(array('-'),array('/'),$e_key);
            return $this->CI->encrypt->decode($dekey);
        }

        
}

?>