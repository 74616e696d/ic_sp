<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_question_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='member_question';
	}

	static function has_answered($qid)
	{
		$ci =& get_instance();
		$ci->db->where('id',$qid);
		$qry=$this->db->get($this->table);
		if($qry->num_rows()>0)
		{
			$ansered=$qry->row()->answered;
			if($answered)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

}

/* End of file member_question_model.php */
/* Location: ./application/models/member_question_model.php */