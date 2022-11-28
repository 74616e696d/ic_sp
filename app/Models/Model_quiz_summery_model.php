<?php 
namespace App\Models;
use CodeIgniter\Model;

class Model_quiz_summery_model extends Model {

	function __construct()
	{
		parent::__construct();
		$this->table='model_quiz_summery';
	}

	/**
	 * get model quiz summery by terms
	 * 
	 * @param  string $term
	 * 
	 * @return object|boolean     


	 */

	function get_test_info($id)
	{
		$sql="select * from model_test where id = {$id}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

	function has_taken($id, $uid){

		$sql="select * from model_quiz_summery where test_id = {$id} AND user_id={$uid}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return 1;
		}
		return 0;
	}

	function get_test_sheet($id)
	{
		$sql="select (mqs.total_correct - mqs.total_wrong/2) AS marks,  mqs.*,u.user_name,u.email,mt.name as test_name,mt.total_ques from model_quiz_summery mqs join model_test mt on mqs.test_id=mt.id join users u on u.id=mqs.user_id where mt.id= {$id} ORDER BY marks desc";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}
	function get_quiz_summery($term='')
	{
		$sql="select mqs.*,u.user_name,u.email,mt.name as test_name,mt.total_ques from model_quiz_summery mqs join model_test mt on mqs.test_id=mt.id join users u on u.id=mqs.user_id {$term}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

	/**
	 * get model quiz count by term
	 * 
	 * @param  string $term
	 * 
	 * @return integer      
	 */
	function get_count($term='')
	{
		$sql="select mqs.id from model_quiz_summery mqs join model_test mt on mqs.test_id=mt.id join users u on u.id=mqs.user_id {$term}";
		$qry=$this->db->query($sql);
		return $qry->num_rows();
	}

	/**
	 * [expert_review_summery description]
	 * @param  [type] $user [description]
	 * @return [type]       [description]
	 */
	function expert_review_summery($user,$limit=5)
	{
		$sql="SELECT * FROM model_quiz_summery WHERE user_id={$user} and expert_review IS NOT NULL AND TRIM(expert_review) <> '' order by id desc limit {$limit}";
		return $this->db->query($sql)->getResultArray();
		/*if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}*/
	}

	function get_todays_result()
	{
		$now=date('Y-m-d');
		$sql="select *from {$this->table} where DATE_FORMAT(quiz_date,'%Y-%m-%d')='{$now}'";
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

	function find_by_quz_id($quiz_id,$uid)
	{
		$this->db->where('quiz_id',$quiz_id);
		$this->db->where('user_id',$uid);
		$qry=$this->db->get('model_quiz_summery');
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return false;
		}
	}


	function user_top_correct($user,$test_id)
	{
		$this->db->where('user_id',$user);
		$this->db->where('test_id',$test_id);
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


	function top_score($test_id)
	{
		$this->db->where('test_id',$test_id);
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

	function find_user_quiz($uid)
	{
		return $this->db->table('model_quiz_summery')->where('user_id',$uid)->orderBy('quiz_date','desc')->get()->getResultObject();
		/*if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}*/
	}

	function get_quiz($quiz_id)
	{
		$this->db->where('quiz_id',$quiz_id);
		$qry=$this->db->get('model_quiz_summery');
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else{
			return false;
		}
	}

}

/* End of file model_quiz_summery.php */
/* Location: ./application/models/model_quiz_summery.php */