<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fyle extends CI_Controller {

    public function index()
	{
		$this->load->view('index');
    }

    function show()
	{
		$draw = $this->input->post('draw');
		$start = $this->input->post('start');
		$length = $this->input->post('length');
		$order = $this->input->post('order');
		$col = 0;
		$dir = "";
		$search = $this->input->post('search');
		$search = $search['value'];



		if(!empty($order)){
			foreach($order as $o)
			{
				$col = $o['column'];
				$dir = $o['dir'];
			}
		}

		if($dir!='asc' && $dir != 'desc')
		{
			$dir = 'desc';
		}

		$valid_columns = array(
			0 => 'ifsc',
			1 => 'bank_id',
			2 => 'branch',
			3 => 'address',
			4 => 'city',
            5 => 'district',
            6 => 'state',
            7 => 'type',
		);

		
		if(!isset($valid_columns[$col]))
		{
			$order = null;
		}
		else{
			$order = $valid_columns[$col];	
		}

	
		if(!empty($search))
		{
			$x = 0;
			foreach($valid_columns as $sterm)
			{
				if($x == 0)
				{
					$this->db->like($sterm, $search);
				}
				else{
					$this->db->or_like($sterm, $search);
				}
				$x++;
			}
        }

        if($order != NULL)
        {

            $this->db->order_by($order,$dir);
        }
    



		if($length == -1)
		{
			echo "len -1";
		}
		else{
			$this->db->limit($length, $start);
		}
		
		$query = $this->db->get('infos');


		if($query->num_rows()>0)
		{
			foreach($query->result() as $rows)
			{
				$js[] = [
                    '<a href="'.$rows->ifsc.'/'.$rows->bank_id.'">'.$rows->ifsc.'</a>',
					$rows->bank_id,
					$rows->branch,
					$rows->address,
                    $rows->city,
                    $rows->district,
                    $rows->state,
                    $rows->type,
				];
			}
			$total_rec = $this->db->count_all_results('infos');

			$res = array(
				'draw' => $draw,
				'recordsTotal' => $total_rec,
				'recordsFiltered' => $total_rec,
				'data' => $js,
			);
			//echo "<pre>";
			echo json_encode($res);
		}
		
    }
    

    public function branch()
    {
        error_reporting(0);
        $this->load->model('Fyle_model');
        $data['q'] = $_GET['q'];
        $data['limit'] = $_GET['limit'];
        $data['offset'] = $_GET['offset'];
        
        $result['branches'] = $this->Fyle_model->getRow($data['q'], $data['limit'],$data['offset']);
        // $result['branches'] = $this->Fyle_model->getRow($data['q'], $data['limit']);
        
        echo json_encode($result);


        
    }
}