<?php

namespace App\Models;
use CodeIgniter\Model;

class Activity_log_model extends Model {

	function __construct()
	{
		parent::__construct();
		$this->table='activity_log';
	}


	function get_top_activity($limit=5)
	{
		return $this->db->table('activity_log')->where('display',1)->orderBy('id','DESC')->limit($limit)->get()->getResultObject();
		/*$qry=$this->db->get($this->table);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}*/
	}

}

/* End of file activity_log.php */
/* Location: ./application/models/activity_log.php */