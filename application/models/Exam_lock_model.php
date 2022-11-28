<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exam_lock_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function add($data)
	{
		$this->db->insert('exam_lock_list',$data);
		return;
	}

	function is_locked($rid)
	{
		$this->db->where('ref_id',$rid);
		$this->db->select('is_locked');
		$qry=$this->db->get('exam_lock_list');
		if($qry->num_rows()>0)
		{
			if($qry->row()->is_locked==1)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		else
		{
			return true;
		}
	}


	function exists($rid)
	{
		$this->db->where('ref_id',$rid);
		$this->db->select('is_locked');
		$qry=$this->db->get('exam_lock_list');
		if($qry->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function update($rid,$data)
	{
		$this->db->where('ref_id',$rid);
		$this->db->update('exam_lock_list',$data);
	}

	/**
	 * check if exam is locked or not
	 * @param  $exam_id int  
	 * @param  $locked_exams array
	 * @return boolean            
	 */
	function locked($exam_id,$locked_exams=[])
	{
		if(in_array($exam_id,$locked_exams))
		{
			return true;
		}
		return false;
	}

	/**
	 * lock exam
	 * @param  int $exam_id
	 * @param  bool $is_lock   
	 * @return void            
	 */
	function do_lock($exam_id)
	{
		if($this->exam_exist($exam_id))
		{
			$this->db->where('exam_id',$exam_id);
			$this->db->delete('locked_exam');
		}
		else
		{
			$qry=$this->db->insert('locked_exam',['exam_id'=>$exam_id]);
		}
	}

	/**
	 * check exam already exists or not
	 * @param  int $exam_id 
	 * @return bool             
	 */
	private function exam_exist($exam_id)
	{
		$this->db->where('exam_id',$exam_id);
		$qry=$this->db->get('locked_exam');
		if($qry->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Get Locked Exam Lists
	 * @return Array
	 */
	function get_locked_exams()
	{
		$this->db->cache_off();
		$qry=$this->db->get('locked_exam');
		if($qry->num_rows()>0)
		{
			$exams=[];
			foreach ($qry->result() as $row) {
				array_push($exams,$row->exam_id);
			}
			return $exams;
		}
		return [];
	}


}

/* End of file exam_lock_model.php */
/* Location: ./application/models/exam_lock_model.php */