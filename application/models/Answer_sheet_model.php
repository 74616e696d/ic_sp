<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Answer_sheet_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='answer_sheet';
	}	

	function get_user_answer($user,$test_id,$qid)
	{
		$this->db->where('user_id',$user);
		$this->db->where('test_track_id',$test_id);
		$this->db->where('question_id',$qid);
		$qry=$this->db->get('answer_sheet');
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return false;
		}
	}

	function get_subject_wise_answer_sheet($user,$subject)
	{
		$this->db->where('qb.subject',$subject);
		$this->db->where('ans.user_id',$user);
		$this->db->from('answer_sheet ans');
		$this->db->join('question_bank qb','ans.question_id=qb.id');
		$this->db->select(array('ans.answer','ans.correct_ans','ans.question_id','qb.subject','qb.chapter'));
		$this->db->group_by('qb.chapter');
		$qry=$this->db->get();
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

/* End of file answer_sheet_model.php */
/* Location: ./application/models/answer_sheet_model.php */