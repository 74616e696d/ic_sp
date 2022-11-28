<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Marks_mapping_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function add($data)
	{
		$this->db->insert('exam_marks_mapping',$data);
		return;
	}

	function get_mapping_list($eid)
	{
		$this->db->where('exam_id',$eid);
		$q=$this->db->get('exam_marks_mapping');
		if($q->num_rows()>0)
		{
			return $q->result();
		}
		else
		{
			return false;
		}
	}

	function get_marks_by_topics($exam_id,$topics)
	{
		$this->db->where('exam_id',$exam_id);
		$this->db->where('topics',$topics);
		$q=$this->db->get('exam_marks_mapping');
		if($q->num_rows()>0)
		{
			return $q->row();
		}
		else
		{
			return false;
		}
	}

	function get_mapping_by_parent($exam_id,$parent)
	{
		$sql='select *from exam_marks_mapping  where exam_id='.$exam_id.' and parent='.$parent.' order by parent';
		$q=$this->db->query($sql);
		if($q->num_rows()>0)
		{
			return $q->result();
		}
		else
		{
			return false;
		}
	}
	
	function get_mapping_top_parent($eid)
	{
		$sql="select * from exam_marks_mapping where exam_id=".$eid."  and parent=0";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}else
		{
			return false;
		}
	}

	function find($id)
	{
		$this->db->where('id',$id);
		$q=$this->db->get('exam_marks_mapping');
		if($q->num_rows()>0)
		{
			return $q->row();
		}
		else
		{
			return false;
		}
	}

	function check_topics($eid,$tid)
	{
		$this->db->where('exam_id',$eid);
		$this->db->where('topics',$tid);
		$this->db->select('id');
		$q=$this->db->get('exam_marks_mapping');
		if($q->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function check_topics_integrity($exam_id,$tid,$added_marks=0)
	{
		$total_marks=0;
		$topics_mark=0;
		$child_topics_mark=0;

		$this->db->where('id',$exam_id);
		$this->db->select('total_marks');
		$q=$this->db->get('exam');
		if($q->num_rows()>0)
		{
			$total_marks=$q->row()->total_marks;
		}

		$this->db->where('exam_id',$exam_id);
		$this->db->where('topics',$tid);
		$this->db->select('marks');
		$q=$this->db->get('exam_marks_mapping');
		
		if($q->num_rows()>0)
		{
			$topics_mark=$q->row()->marks;
		}

		$this->db->where('exam_id',$exam_id);
		$this->db->where('parent',$tid);
		$this->db->select_sum('marks');
		$qry=$this->db->get('exam_marks_mapping');
		if($qry->num_rows()>0)
		{
			$child_topics_mark=$qry->row()->marks+$added_marks;
		}
		//echo $tid."<br/>Parent:".$topics_mark."<br/>Child:".$child_topics_mark;
		if($topics_mark!=0)
		{
			if($topics_mark>=$child_topics_mark)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return true;
		}

	}

}

/* End of file marks_mapping_model.php */
/* Location: ./application/models/Exam/marks_mapping_model.php */