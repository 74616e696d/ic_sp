<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use Carbon\Carbon;
class Quiz_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table="chapter_quiz";
	}

   function get_chapter_wise_quiz_result($user,$subject)
   {
      $this->db->where('qb.subject',$subject);
      $this->db->where('qz.user_id',$user);
      $this->db->from('chapter_quiz qz');
      $this->db->join('question_bank qb','qz.qid=qb.id');
      $this->db->select(array('qz.ans','qz.correct_ans','qz.qid','qb.subject','qb.chapter'));
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
   
	function get_quiz_wrong_list($user,$chapter,$time)
	{
		$this->db->where('user_id',$user);
		$this->db->where('chapter_id',$chapter);
		$this->db->where("SUBSTRING_INDEX(quiz_id,'_',1)",$time);

		$this->db->select('id,qid,ans,correct_ans');
		$qry=$this->db->get('chapter_quiz');
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

/* End of file quiz_model.php */
/* Location: ./application/models/quiz_model.php */