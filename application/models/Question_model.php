<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
/**
     * Author : Shamim
     * Description : small Description
     */
class 	Question_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	function insert_prev_question($data)
	{
		$this->db->insert('ques_bank',$data);
		return;
	}


	function get_all()
	{
		$query="select *from tblTest";
		$q=$this->db->query($query);
		if($q->num_rows()>0)
		{
			$result=$q->result();
			return $result;
		}
		else
		{
			return false;
		}
	}
    
	
	function get_prev_exam_all()
	{
		$sql='select *from ques_bank';;
		$query=$this->db->query($sql);
		if($query->num_rows()>0)
		{
			$result=$query->result();
			return $result;
		}else{
			return false;
		}
	}
	
	function prev_question_get_by_id($id)
	{
		$sql='select *from ques_bank where id='.$id;
		$query=$this->db->query($sql);
		if($query->num_rows()>0)
		{
			$result=$query->row();
			return $result;
		}else{
			return false;
		}
	}
	
	function prev_question_get_all($key,$start,$limit)
	{
		$sql='select *from ques_bank '.$key.' limit '.$start.','.$limit;
		$query=$this->db->query($sql);
		if($query->num_rows()>0)
		{
			$result=$query->result();
			return $result;
		}else{
			return false;
		}
	}	
	function prev_question_total($key)
	{
		$sql='select *from ques_bank '.$key;
		$query=$this->db->query($sql);
		if($query->num_rows()>0)
		{
			return $query->num_rows();
		}else{
			return 0;
		}
	}
   function ref_text_get_exam_all()
   {
   	$sql='select * from ref_text where group_id=2 and display=1';
	$query=$this->db->query($sql);
	if($query->num_rows()>0){
		$result=$query->result();
		return $result;
	}else
	{
		return false;
	}
   }
   
   function ref_text_get_subject_by_parent($parent_id)
   {
   		$sql='select * from ref_text where group_id=3 and display=1 and parent_id='.$parent_id;
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			
			$result=$query->result();
			return $result;
		}else{
			return false;
		}
   }
   
   function ref_text_get_chapter_by_parent($pid)
   {
   	$sql='select * from ref_text where group_id=4 and display=1 and parent='.$pid;
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			
			$result=$query->result();
			return $result;
		}else{
			return false;
		}
   }
   
   
    
}
    