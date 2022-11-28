<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function add_answer($data)
	{
		$this->db->insert('answer_sheet',$data);
        return;
	}
	function get_questions()
	{
		$q=$this->db->get('question_bank');
		if($q->num_rows()>0)
		{
			return $q->result();
		}
		else
		{
			return false;
		}
	}

	function get_questions_by_test($test_name)
	{
		$this->db->where('exam_id',$test_name);	
		$q=$this->db->get('exam_question');
		if($q->num_rows()>0)
		{
			return $q->row();
		}
		else
		{
			return false;
		}
	}

	function get_options($id)
	{
		$this->db->where('id',$id);
		$q=$this->db->get('question_bank');
		if($q->num_rows()>0)
		{
			return $q->row();
		}
		else
		{
			return false;
		}
	}

	function get_correct_ans($qid)
	{
		$this->db->where('id',$qid);
		$this->db->select('options');
		$qry=$this->db->get('question_bank');
		if($qry->num_rows()>0)
		{
			$result=$qry->row()->options;
			$options_arr=explode('///',$result);
			$option_range=range('A','H');
			$i=0;
			$correct_answer=array();
			if(count($options_arr)>0)
			{
				foreach ($options_arr as $opt) 
				{
					$correct=substr(trim(strip_tags($opt,'<img>')),0,2)=="@@"?true:false;

					if($correct)
					{
						$answer_val=$option_range[$i];
						array_push($correct_answer,$answer_val);
					}
					$i++;
				}

			}
			return $correct_answer;
		}
		else
		{
			return false;
		}
	}

	function get_given_answer($uid,$exam_id)
	{
		$sql="SELECT * FROM answer_sheet 
		WHERE SUBSTRING_INDEX(test_track_id,'_',1)=
		(SELECT MAX(SUBSTRING_INDEX(test_track_id,'_',1)) FROM answer_sheet) and exam_id={$exam_id} and user_id={$uid}";

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

	function get_max_exam_number($mtype,$key)
	{
		$this->db->where('mem_type',$mtype);
		$this->db->where('setting_key',$key);
		$q=$this->db->get('member_setting');
		if($q->num_rows()>0)
		{
			return $q->row();
		}
		else
		{
			return false;
		}
	}
	
	function get_answer_sheet_meta($eaxm_id,$user)
	{
		$this->db->where('exam_id',$exam_id);
		$this->db->where('user_id',$user);
		$this->db->distinct();
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

	//creating temporary table to store user answers
	public static function is_assigned($qid)
	{
		$ci =& get_instance();
		$ci->db->where('qid',$qid);
		$qry=$ci->db->get("temp_ans");
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return false;
		}
	}
	function add_temp_ans($data)
	{
		$this->db->insert("temp_ans",$data);
		return;
	}

	function update_temp_ans($uid,$qid,$data)
	{
		$this->db->where('uid',$uid);
		$this->db->where('qid',$qid);
		$this->db->update("temp_ans",$data);
	}

	function get_exam_meta($id)
	{
		$this->db->where('id',$id);
		$qry=$this->db->get('exam');
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return false;
		}
	}

	function get_temp_data($uid)
	{
        $this->db->where('uid',$uid);
		$qry=$this->db->get('temp_ans');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function delete_temp_data($uid)
	{
		$this->db->where('uid',$uid);
		$this->db->delete('temp_ans');
	}
	//end creating temporary table to store user answers

    //test summery
    function add_summery($data)
    {
        $this->db->insert('answer_summery',$data);
        return;
    }

    //adjust member point
    function add_point_history($data)
    {
        $this->db->insert('mem_point_history',$data);
        return;
    }

    function point_summery_exists($uid)
    {
        $this->db->where('user_id',$uid);
        $qry=$this->db->get('mem_point');
        if($qry->num_rows()>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function total_point($uid)
    {
        $this->db->where('user_id',$uid);
        $this->db->select_sum('point');
        $qry=$this->db->get('mem_point_history');
        if($qry->num_rows()>0)
        {
            return $qry->row()->point;
        }
        else
        {
            return false;
        }
    }
    function add_point_summery($data)
    {
        $this->db->insert('mem_point',$data);
        return;
    }
    function update_point_summery($uid,$data)
    {
        $this->db->where('user_id',$uid);
        $this->db->update('mem_point',$data);
    }
}

/* End of file test_model.php */
/* Location: ./application/models/Exam/test_model.php */