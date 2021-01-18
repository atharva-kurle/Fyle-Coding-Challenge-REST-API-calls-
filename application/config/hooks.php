<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$hook['post_controller'] = array(
        'class'    => 'Myauthhook',
        'function' => 'Checkauth',
        'filename' => 'Myauthhook.php',
        'filepath' => 'hooks',
        'params'   => array()
);