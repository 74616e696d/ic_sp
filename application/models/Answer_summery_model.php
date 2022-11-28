<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Answer_summery_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='answer_summery';
	}


	function get_user_top($user,$track_id)
	{
		$this->db->where('user_id',$user);
		$this->db->where('track_id',$track_id);
		$this->db->select_max('total_correct');
		$qry=$this->db->get($this->table);
		if($qry->num_rows()>0)
		{
			return $qry->row()->total_correct;
		}
		else
		{
			return 0;
		}
	}


	function get_top($exam_id)
	{
		$this->db->where('exam_id',$exam_id);
		$this->db->select_max('total_correct');
		$qry=$this->db->get($this->table);
		if($qry->num_rows()>0)
		{
			return $qry->row()->total_correct;
		}
		else
		{
			return 0;
		}
	}

}

/* End of file answer_summery_model.php */
/* Location: ./application/models/answer_summery_model.php */