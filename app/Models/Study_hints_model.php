<?php 
namespace App\Models;
use CodeIgniter\Model;

class Study_hints_model extends Model {

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

	 function has_hints($start,$limit=1)
	{
		//$ci =& get_instance();
		return $this->db->table('study_hints')->limit($limit,$start)->get()->getRow();
		/*if($qry->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}*/
	}

}

/* End of file study_hints_model.php */
/* Location: ./application/models/study_hints_model.php */