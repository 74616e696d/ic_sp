<?php 
namespace App\Models\member;
use CodeIgniter\Model;

class Result_model extends Model {

	function __construct()
	{
		parent::__construct();
	}

	function get_user_progress($user)
	{
		return $this->db->table('answer_summery')->where('user_id',$user)->orderBy('exam_date','desc')->get()->getResultObject();
/*
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}*/
	}

  function get_user_progress_latest($user)
  {
    return $this->db->table('answer_summery')->where('user_id',$user)->orderBy('exam_date','desc')->limit(1)->get()->getResultArray();
    //$qry=$this->db->get('answer_summery');

   /* if($qry->num_rows()>0)
    {
      return $qry->result();
    }
    else
    {
      return false;
    }*/
  }
  function get_users_exam($uid)
  {
    $this->db->where('user_id',$uid);
    $qry=$this->db->get('users_exam');
    if($qry->num_rows()>0)
    {
      return $qry->row();
    }
    else
    {
      return false;
    }
  }
  function save_users_exam($data)
  {
      $this->db->insert('users_exam',$data);
      return;
  }
  function update_users_exam($uid,$data)
  {
    $this->db->where('user_id',$uid);
    $this->db->update('users_exam',$data);
  }

  function delete_users_exam($user)
  {
    $this->db->where('user_id',$user);
    $this->db->where('users_exam');
  }
	function get_user_total_taken_exam($user)
	{
		$sql="select id from answer_summery where user_id={$user}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->num_rows();
		}
		else
		{
			return 0;
		}
	}
    function get_user_exam_wise_count($user)
    {
       $sql="SELECT exam_id,COUNT(*) AS totaltest FROM answer_summery WHERE user_id={$user} GROUP BY exam_id ";
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
   	function get_wrong_answered_ques($user,$testname,$time)
   	{
   		//$dt=gmdate('Y-m-d H:i:s',$time);
   		$this->db->where('exam_id',$testname);
   		$this->db->where('user_id',$user);
   		$this->db->where('test_track_id',$time);
   		$this->db->not_like('answer','correct_ans');
   		$this->db->select('id,question_id,answer,correct_ans');
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

    function chapter_wise_previous_test_count($chapter,$user)
    {
      $sql="select count(distinct ast.test_track_id) as ttl from answer_sheet ast inner join 
      question_bank qb on ast.question_id=qb.id where qb.chapter={$chapter} and ast.user_id={$user} and qb.is_prev=1";
      $qry=$this->db->query($sql);
      if($qry->num_rows()>0)
      {
        return $qry->row()->ttl;
      }
      else
      {
        return false;
      }
    }

   	function get_distinct_test_name()
   	{
   		$this->db->distinct();
   		$qry=$this->db->get('exam');
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

/* End of file result_model.php */
/* Location: ./application/models/member/result_model.php */