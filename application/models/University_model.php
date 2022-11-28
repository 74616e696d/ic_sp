<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class University_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table='uni_info';
	}


	function get_university($term)
	{
		$this->db->cache_on();
		$this->db->like('LOWER(name)',$term);
		$this->db->select('name');
		$qry=$this->db->get('uni_info');
		$this->db->cache_off();
		if($qry->num_rows()>0)
		{
			$uni= $qry->result();
			foreach ($uni as $u) 
			{
				$row_set[]=htmlentities(stripslashes($u->name));
			}
			echo json_encode($row_set);
		}
	}

}

/* End of file university.php */
/* Location: ./application/models/university.php */