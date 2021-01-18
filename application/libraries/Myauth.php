<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myauth{
    protected $CI; 
    function __construct()    
    {
        $this->CI =& get_instance(); 
    }
    
    function Checkauth()
    {
        $cur_class = $this->CI->router->fetch_class();
        $cur_method = $this->CI->router->fetch_method();        
        $cur_method = ($cur_method != '')?'/'.$cur_method:'';
        $access_url = $cur_class.$cur_method;
        //echo "PreChk : ".$access_url;
        //echo "<script>alert('Hello');</script>";
        $this->CI->db->select('idmenus,Menu_link,Menu_RouteTo');
        $this->CI->db->join('menus','menus.idmenus = role_has_menus.RHMs_IdMenu');
        $this->CI->db->where('Menu_RouteTo',$access_url);
        $this->CI->db->where('RHMs_IdRole',$this->CI->session->userdata('urole'));
        $acl = $this->CI->db->get('role_has_menus')->result_array();
        return $acl;       
    }


}