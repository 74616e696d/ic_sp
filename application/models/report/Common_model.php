<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function get_exam_subjects($exam_id)
	{
		$this->db->where('exam_id',$exam_id);
		$this->db->where('parent',0);
		$qry=$this->db->get('exam_marks_mapping');
		if($qry->num_rows()>0)
		{
			$result=$qry->result();
			return $result;
		}
		else
		{
			return false;
		}
	}

	function get_answer_sheet_by_date($exam_id,$user_id,$time)
	{
		$dt=gmdate('Y-m-d H:i:s',$time);
		$this->db->where('exam_id',$exam_id);
		$this->db->where('user_id',$user_id);
		$this->db->where('exam_date',$dt);
		$qry=$this->db->get('answer_sheet');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}

	}
	function get_wrong_ans($user,$exam,$time,$qid)
    {
      $dt=gmdate('Y-m-d H:i:s',$time);
      $this->db->where('user_id',$user);
      $this->db->where('exam_id',$exam);
      $this->db->where('exam_date',$dt);
      $this->db->where('question_id',$qid);
      $this->db->select('id,question_id,answer,correct_ans');
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

	function get_subject_by_qid($qid)
	{
		$this->db->where('id',$qid);
		$this->db->select('subject');
		$qry=$this->db->get('question_bank');
		if($qry->num_rows()>0)
		{
			return $qry->row()->subject;
		}
		else
		{
			return false;
		}
	}

	function get_subject_wise_answer($exam_id,$user_id,$time)
	{
		$answers=$this->get_answer_sheet_by_date($exam_id,$user_id,$time);
		$answer_with_subject=array();
		if($answers)
		{
			foreach ($answers as $ans) 
			{
				$subject=$this->get_subject_by_qid($ans->question_id);
				array_push($answer_with_subject,array('id'=>$ans->id,
					'user_id'=>$ans->user_id,
					'question_id'=>$ans->question_id,
					'answer'=>$ans->answer,
					'correct_ans'=>$ans->correct_ans,
					'exam_date'=>$ans->exam_date,
					'exam_id'=>$ans->exam_date,
					'test_track_id'=>$ans->test_track_id,
					'subject'=>$subject
					));
			}
		}

		return $answer_with_subject;

	}


	function get_answer_by_qid($qid)
	{
		$this->db->where('question_id',$qid);
		$qry=$this->db->get('answer_sheet');
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

/* End of file common_model.php */
/* Location: ./application/models/report/common_model.php */