<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expert_reply_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table="expert_reply";
	}

	/**
	 * check if replied
	 * @param  string $ask_id [description]
	 * @param  int $qid    [description]
	 * @return bool
	 */
	function check($ask_id,$qid)
	{
		$this->db->where('ask_id',$ask_id);
		$this->db->where('qid',$qid);
		$qry=$this->db->get('expert_reply');
		if($qry->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}	

	/**
	 * get text
	 */
	static function get_text($ask_id,$qid)
	{
		$ci =& get_instance();
		$ci->db->where('ask_id',$ask_id);
		$ci->db->where('qid',$qid);
		$qry=$ci->db->get('expert_reply');
		if($qry->num_rows()>0)
		{
			return $qry->row()->details;
		}
		else
		{
			return '';
		}
	}

	function modify($ask_id,$qid,$data)
	{
		$this->db->where('ask_id',$ask_id);
		$this->db->where('qid',$qid);
		$this->db->update('expert_reply',$data);
	}

}

/* End of file expert_reply_model.php */
/* Location: ./application/models/expert_reply_model.php */