<?php

class Fyle_model extends CI_Model
{

    function getRow($branch, $l, $o)
    {
        $this->db->where('branch', $branch);
        $this->db->limit($l, $o);

        return $this->db->get('infos')->result_array();   
    }

}
