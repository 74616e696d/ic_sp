<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vocabulary_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='vocabulary';
	}

	
	function todays_word($start,$limit)
	{
		$sql="select *from vocabulary where display=1 and id>{$start} limit {$limit}";
		$qry=$this->db->query($sql);
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

/* End of file vocabulary_model.php */
/* Location: ./application/models/vocabulary_model.php */