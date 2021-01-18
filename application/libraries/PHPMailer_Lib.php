<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PHPMailer_Lib
{
    public function __construct(){
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load(){
        // Include PHPMailer library files
        require_once APPPATH.'third_party/phpmailer/class.phpmailer.php';
        
        $mail = new PHPMailer;
        return $mail;
    }
}