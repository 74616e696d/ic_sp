<?php 
namespace App\Models;
use CodeIgniter\Model;

class Quiz_summery_model extends Model {

	function __construct()
	{
		parent::__construct();
		$this->table="chapter_quiz_summery";
	}

	function find_by_quz_id($quiz_id,$uid)
	{
		$this->db->where('quiz_id',$quiz_id);
		$this->db->where('user_id',$uid);
		$qry=$this->db->get('chapter_quiz_summery');
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return false;
		}
	}

	function user_top_correct($user,$chapter)
	{
		$this->db->where('user_id',$user);
		$this->db->where('chapter_id',$chapter);
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


	static function attempted_chapter_quiz($user,$chapter=[])
	{
		$ci =& get_instance();
		$ci->db->where('user_id',$user);
		$ci->db->where_in('chapter_id',$chapter);
		$qry=$ci->db->get('chapter_quiz_summery');
		return $qry->num_rows();
	}


	static function attempted_chapter_correct($user,$chapter=[])
	{
		$ci =& get_instance();
		$ci->db->where('user_id',$user);
		$ci->db->where_in('chapter_id',$chapter);
		$ci->db->select_sum('total_correct');
		$qry=$ci->db->get('chapter_quiz_summery');
		return $qry->row()->total_correct;
	}


	function top_score($chapter)
	{
		$this->db->where('chapter_id',$chapter);
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
		return $this->db->table('chapter_quiz_summery')->where('user_id',$uid)->orderBy('quiz_date','desc')->get()->getResultObject();
		/*if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}*/
	}

}

/* End of file quiz_summery_model.php */
/* Location: ./application/models/quiz_summery_model.php */