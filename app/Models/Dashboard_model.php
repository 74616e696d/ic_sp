<?php 
namespace App\Models;
use CodeIgniter\Model;
//if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends Model {

	function __construct()
	{
		parent::__construct();
                $this->database = \Config\Database::connect();
                $this->table='users';
	}

	function get_profile_completed($uid)
	{
		$ttl=0;
		$cols=12;
		$per=0;
		$count = $this->db->table('users')->where('id',$uid)->countAllResults();
		//$count=$this->db->get('users');
		if($count>0)
		{
			$up=$this->db->table('users')->where('id',$uid)->get()->getRow();
			$ttl=$this->increment($up->user_name,$ttl);
			$ttl=$this->increment($up->email,$ttl);
			$ttl=$this->increment($up->password,$ttl);
		}

		$count1 = $this->db->table('user_details')->where('user_id',$uid)->countAllResults();
		//$qry1=$this->db->get('user_details');
		if($count1 > 0)
		{
			$dtls=$this->db->table('user_details')->where('user_id',$uid)->get()->getRow();
			//var_dump($dtls);
			$ttl=$this->increment($dtls->full_name,$ttl);
			$ttl=$this->increment($dtls->address,$ttl);
			$ttl=$this->increment($dtls->phone,$ttl);
			$ttl=$this->increment($dtls->photo,$ttl);
			$ttl=$this->increment($dtls->study_level,$ttl);
			$ttl=$this->increment($dtls->institute_name,$ttl);
			$ttl=$this->increment($dtls->class_name,$ttl);
			$ttl=$this->increment($dtls->dept_group,$ttl);
			$ttl=$this->increment($dtls->session,$ttl);
		}

		$per=($ttl/$cols)*100;
		return ceil($per);
	}

	

	 function total_free_chapter()
	{
		//$ci =& get_instance();
		$sql="SELECT * FROM ref_text JOIN exam_lock_list ON exam_lock_list.`ref_id` = ref_text.`id` 
			WHERE ref_text.group_id = 4 AND exam_lock_list.`is_locked` = 0 ";
		return $this->db->query($sql)->getNumRows();
		//return $qry->num_rows();
	}

	function increment($fld,$i)
	{
		if(!empty($fld))
		{
			return $i+1;
		}
		else
		{
			return $i;
		}
	}



	static function ques_text($qid)
	{
		$ci =& get_instance();
		$ci->db->where('id',$qid);
		$ci->db->select('question');
		$qry=$ci->db->get('question_bank');
		if($qry->num_rows())
		{
			return $qry->row()->question;
		}
		else
		{
			return '';
		}

	}

	function get_rank($exam,$score)
	{
		$this->db->where('exam_id',$exam);
		$this->db->order_by('total_correct','desc');
		$qry=$this->db->get('answer_summery');
		$all=array();
		if($qry->num_rows()>0)
		{
			$scores=$qry->result();
			foreach ($scores as $s) {
				array_push($all, $s->total_correct);
			}
			$newarray = (array_unique(array_values($all)));
			$rank = array_search($score,$newarray)+1;
			return $rank;
		}
		else
		{
			return 0;
		}
	}


	function get_top_score($exam)
	{
		$sql="select *from answer_summery where total_correct=(select max(asm.total_correct) from answer_summery asm where asm.exam_id={$exam}) and exam_id={$exam}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			$correct=$qry->row()->total_correct;
			$total=$qry->row()->total_question;
			return ($correct/$total)*100;
		}
		else
		{
			return 0;
		}
	}

	function find_latest_eid($user)
	{
		return $this->db->table('answer_summery')->where('user_id',$user)->limit(1)->orderBy('id','desc')->get()->getRow();
		/*if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return 0;
		}*/
	}



	function get_latest_mistakes($user,$limit=3)
	{
		return $this->db->table('practice_mistake')->where('user_id',$user)->limit($limit)->orderBY('last_attempt_date','desc')->get()->getResultArray();
		/*if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}*/
	}


	function get_latest_reviews($user,$limit=3)
	{
		return $this->db->table('ans_review_list')->where('user_id',$user)->limit($limit)->orderBy('id','desc')->get()->getResultArray();
	/*	if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}*/
	}


	function get_users_latest_exam($uid)
	{
		$this->db->where('user_id',$uid);
		$this->db->limit(1);
		$this->db->order_by('id','desc');
		$qry=$this->db->get('answer_summery');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function get_total_ques()
	{
		return $this->database->table('question_bank')->countAllResults();
		//return $qry->num_rows();
	}

	function get_total_user()
	{
		return $this->database->table('users')->where('is_active','1')->countAllResults();
		
	}


	function get_online_user()
	{
		$this->database->table('users')->select('id')->where('is_online','1')->countAllResults();
		/*$this->db->;
		$qry=$this->db->get('users');
		return $qry->num_rows();*/
	}

	function get_current_world_info($limit=0)
	{
		return $this->db->table('question_bank')->where('chapter','315')
		->orderBY('id','desc')->get()->getResultArray();
                
		if($limit!=0){
                    $qry = $qry->limit($limit);
		}
		return $qry->get()->getResultArray();
		/*if($qry->num_rows())
		{
			return $qry->result();
		}
		else
		{
			return false;
		}*/
	}

	function get_current_world($start=0,$limit=10)
	{
		return $this->db->table('question_bank')->where('chapter','315')->orderBy('id','desc')->limit($limit,$start)->get()->getResultObject();
		/*if($qry->num_rows())
		{
			return $qry->result();
		}
		else
		{
			return false;
		}*/
	}

	function total_current_world()
	{
		return $this->db->table('question_bank')->where('chapter','315')->countAllResults();
		//return $qry->num_rows();
	}

	function get_average($uid,$exam)
	{
		$this->db->where('user_id',$uid);
		$this->db->where('exam_id',$exam);
		$this->db->select_avg('total_correct');
		$qry=$this->db->get('answer_summery');
		return $qry->row()->total_correct;
	}

}

/* End of file dashboard.php */
/* Location: ./application/models/dashboard.php */