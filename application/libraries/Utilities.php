<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utilities {

    protected $CI;
	function __construct()
	{
            $this->CI =& get_instance();
	}
        
        public function getbackup()
        {
            $this->CI->load->dbutil();
            $backup = $this->CI->dbutil->backup();

            $timestamp = time().date('ymd');
            $this->CI->load->helper('file');
            write_file('pvpit_web'.$timestamp.'.zip', $backup);

            $this->CI->load->helper('download');
            force_download('pvpit_web'.$timestamp.'.zip', $backup);            
        }
        
}

?>