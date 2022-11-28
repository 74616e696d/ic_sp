<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Study_hints_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='study_hints';

	}

	function todays_hints($start,$limit)
	{
		$this->db->where('display','1');
		$this->db->limit($limit,$start);
		$qry=$this->db->get($this->table);
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return false;
		}
	}

	static function has_hints($start,$limit=1)
	{
		$ci =& get_instance();
		$ci->db->limit($limit,$start);
		$qry=$ci->db->get('study_hints');
		if($qry->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

}

/* End of file study_hints_model.php */
/* Location: ./application/models/study_hints_model.php */