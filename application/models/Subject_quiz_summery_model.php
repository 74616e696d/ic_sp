<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subject_quiz_summery_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='subject_quiz_summery';
	}

	function get_user_top($user,$quiz_id)
	{
		$this->db->where('user_id',$user);
		$this->db->where('quiz_id',$quiz_id);
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

	function get_top($subject_id)
	{
		$this->db->where('subject_id',$subject_id);
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

	function find_by_quz_id($quiz_id,$uid)
	{
		$this->db->where('quiz_id',$quiz_id);
		$this->db->where('user_id',$uid);
		$qry=$this->db->get('subject_quiz_summery');
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return false;
		}
	}

	function find_user_quiz($uid)
	{
		$this->db->where('user_id',$uid);
		$this->db->order_by('quiz_date','desc');
		$qry=$this->db->get('subject_quiz_summery');
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

/* End of file subject_quiz_summery_model.php */
/* Location: ./application/models/subject_quiz_summery_model.php */