<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Manage_comprehension_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function insert($data)
    {
        $this->db->insert('comprehension',$data);
        return;
    }

    function get_all()
    {
        $this->db->get('');
    }

    function get_list($start,$limit,$key)
    {
    	$sql ='select *from comprehension '.$key.' limit '.$start.','.$limit;
    	$query=$this->db->query($sql);
    	if($query->num_rows()>0){
    		$result=$query->result();
    		return $result;
    	}else{
    		return false;
    	}
    }

    function find($id)
    {
    	$this->db->where('id',$id);
    	$query=$this->db->get('comprehension');
    	if($query->num_rows()>0){
    		$result=$query->row();
    		return $result;
    	}else{
    		return false;
    	}
    }

    function update($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('comprehension',$data);
    }

    function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('comprehension');
    }


    function insert_ques_to_comp($data)
    {
        if(count($data)>0)
        {
            $this->db->insert_batch('comprehension_ques',$data);
        }
        return;
    }
    function exists_ques($com_id,$ques)
    {
        $this->db->where('comp_id',$com_id);
        $this->db->where('qid',$ques);
        $qry=$this->db->get('comprehension_ques');
        if($qry->num_rows()>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    function comp_ques($comp_id)
    {
        $this->db->where('comp_id',$comp_id);
        $qry=$this->db->get('comprehension_ques');
        if($qry->num_rows()>0)
        {
            return $qry->result();
        }
        else
        {
            return false;
        }
    }

    function delete_ques($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('comprehension_ques');
    }

    function get_comp_qid($qid)
    {
    	$sql="SELECT cq.* FROM comprehension_ques cq WHERE cq.comp_id IN (SELECT cq1.comp_id FROM comprehension_ques cq1 WHERE cq1.qid={$qid})";
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

    function questions_comprehension($qid)
    {
    	$sql="select details from comprehension_ques cq inner join comprehension c on cq.comp_id=c.id where cq.qid={$qid}";
    	//echo $sql;
    	$qry=$this->db->query($sql);
    	if($qry->num_rows()>0)
    	{
    		return $qry->row();
    	}
    	else
    	{
    		return false;
    	}
    }
}
