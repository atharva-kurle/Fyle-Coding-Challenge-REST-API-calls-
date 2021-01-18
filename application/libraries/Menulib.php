<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Menulib
{
    protected $CI;    
    function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();    
    } 

    /*
     * Listing of banks
     */
    function get_menu()
    {
        //$allmenus = $this->Web_menu_model->get_all_web_menus();
        $this->CI->load->model('Menu_model');
        $menus = $this->CI->Menu_model->get_role_parent_menu($this->CI->session->userdata('urole'));
       
        foreach ($menus as $m)
        {
            if($m['RHMs_MenuType']==MSM || $m['RHMs_IdMenu']==$m['RHMs_MenuParent'])
            {
                if($m['RHMs_IdMenu']==$m['RHMs_MenuParent'] && $m['RHMs_MenuType']!=MSM)
                {
                     echo '<li><a href="'.site_url($m['Menu_link']).'"><i class="'.$m['Menu_Icon'].'"></i>'.$m['Menu_Name'].'</a></li>'; 
                }
                if($m['RHMs_IdMenu']==$m['RHMs_MenuParent'] && $m['RHMs_MenuType']==MSM)
                {
                     echo '<li class="treeview"><a href="#"><i class="'.$m['Menu_Icon'].' ftlayer"></i><span>'.$m['Menu_Name'].'</span><i class="fa fa-angle-left pull-right"></i></a>';
                    echo '<ul class="treeview-menu" style="display: none;">';
                    foreach($menus as $mn)
                    {
                        if($mn['RHMs_MenuType']==CM && $m['RHMs_MenuParent']==$mn['Menu_Parrent'])
                        {
                            echo '<li class=""><a href="'.site_url($mn['Menu_link']).'"><i class="fa fa-angle-double-right" style="color:orange"></i>'.$mn['Menu_Name'].'</a></li>';
                        }
                    }
                    echo '</ul></li>';
                }
            }
        }
    }
}
