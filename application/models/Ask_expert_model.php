<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ask_expert_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table="expert_ask";
	}

	function is_asked($test_id,$user_id)
	{
		$this->db->where('test_id',$test_id);
		$this->db->where('user_id',$user_id);
		$qry=$this->db->get('expert_ask');
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

/* End of file ask_expert_model.php */
/* Location: ./application/models/ask_expert_model.php */