<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activity_log_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='activity_log';
	}


	function get_top_activity($limit=5)
	{
		$this->db->where('display',1);
		$this->db->order_by('id','DESC');
		$this->db->limit($limit);
		$qry=$this->db->get($this->table);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

}

/* End of file activity_log.php */
/* Location: ./application/models/activity_log.php */