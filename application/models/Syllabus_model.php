<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Syllabus_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function add($data)
	{
		$this->db->insert('syllabus',$data);
		return;
	}
	function all()
	{
		$q=$this->db->get('syllabus');
		if($q->num_rows()>0)
		{
			return $q->result();
		}else
		{
			return false;
		}
	}
	function all_with_page($start,$limit,$key)
	{
		$sql='select *from syllabus '.$key.' limit '.$start.','.$limit;
		$q=$this->db->query($sql);
		if($q->num_rows()>0)
		{
			return $q->result();
		}else
		{
			return false;
		}
	}

	function get_by_id()
	{
		$this->db->where('id',$id);
		$q=$this->db->get('syllabus');
		if($q->num_rows()>0)
		{
			return $q->row();
		}
		else{
			return false;
		}
	}

	function update($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('syllabus',$data);
	}
	function delete()
	{
		$this->db->where('id',$id);
		$this->db->delete('syllabus');
	}

}

/* End of file syllabus_model.php */
/* Location: ./application/models/Exam/syllabus_model.php */