<?php

class Authenticate{

    var $CI;
    public function __construct()
    {
            $this->CI = &get_instance(); 
    }

    public function isSessionExists(){

        if($this->CI->session->has_userdata('uid')){
            return $this->CI->session->userdata('uid');
        }else{
            return false;
        }
    }
}