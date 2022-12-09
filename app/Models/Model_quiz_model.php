<?php 
namespace App\Models;
use CodeIgniter\Model;

class Model_quiz_model extends Model {

	function __construct()
	{
		parent::__construct();
		$this->table='model_quiz';
	}	

	function get_answer_list($user,$test_id,$time)
	{
		$this->db->cache_on();
		$this->db->where('user_id',$user);
		$this->db->where('test_id',$test_id);
		$this->db->where("SUBSTRING_INDEX(quiz_id,'_',1)",$time);

		$this->db->select('id,qid,ans,correct_ans,expert_review');
		$qry=$this->db->get('model_quiz');
		$this->db->cache_off();
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function get_full_answer_sheet($quiz_id,$test_id)
	{
		$this->db->where('quiz_id',$quiz_id);
		$qry=$this->db->get('model_quiz');
		$qid_arr=[];
		$answer_sheet=[];
		if($qry->num_rows()>0)
		{
			//get data from model quiz table
			$quiz_result= $qry->result();
			foreach ($quiz_result as $row) 
			{
				array_push($qid_arr,$row->qid);
				$data['qid']=$row->qid;
				$data['ans']=$row->ans;
				$data['correct_ans']=$row->correct_ans;
				array_push($answer_sheet, $data);
			}
			//get data from model test table
			$this->db->where('test_id',$test_id);
			$this->db->where_not_in('qid',$qid_arr);
			$qry1=$this->db->get('model_test_question');
			if($qry1->num_rows()>0)
			{
				foreach ($qry1->result() as $row1) {
					array_push($qid_arr,$row1->qid);
					$data1['qid']=$row1->qid;
					$data1['ans']='';
					$data1['correct_ans']='';
					array_push($answer_sheet, $data1);
				}
			}
			usort($answer_sheet,function($a,$b){
				return $a['qid'] - $b['qid'];
			});
			return ['answer_sheet'=>$answer_sheet,'qid'=>$qid_arr];
		}
	}


	function find_ans($user,$test_id,$time,$qid)
	{
		$this->db->cache_on();
		$this->db->where('user_id',$user);
		$this->db->where('test_id',$test_id);
		$this->db->where("SUBSTRING_INDEX(quiz_id,'_',1)",$time);
		$this->db->where('qid',$qid);
		$qry=$this->db->get('model_quiz');
		$this->db->cache_off();
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return false;
		}
	}

	function get_answers_all($user,$test_id,$time)
	{
		$sql="select mtq.* from model_test_question mtq left join model_quiz mq 
		on mtq.test_id=mq.test_id where mq.user_id={$user} and mq.test_id={$test_id} and SUBSTRING_INDEX(mq.quiz_id,'_',1)={$time}";
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

/* End of file model_quiz_model.php */
/* Location: ./application/models/model_quiz_model.php */