<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Author : Shamim
 * Description : small Description
 * Total Functions : 10
 */
class Ans_option_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    ///update answer option of question bank table
    function update_ans($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('question_bank',$data);
    }

    //getting ans options from question bank table by quesion id
    function get_ans_options($id)
    {
        $this->db->where('id',$id);
        $this->db->select('options');
        $q=$this->db->get('question_bank');
        if($q->num_rows()>0)
        {
            return $q->row()->options;
        }else
        {
            return false;
        }
    }
   /* function add_ans($data)
    {
        $this->db->insert('ans_option',$data);
		return"success";
    }
    function ans_get_all()
    {
        $query=$this->db->get('ans_option');
        if($query->num_rows()>0)
        {
            $result=$query->result();
            return $result;
        }else{
            return false;}
    }

    function  ans_get_by_ques($qid)
    {
        $this->db->where('qid',$qid);
        $query=$this->db->get('ans_option');
        if($query->num_rows()>0){
            $result=$query->result();
            return $result;
        }else{
            return false;
        }
    }

    function ans_get_by_id($id)
    {
        $this->db->where('id',$id);
        $query=$this->db->get('ans_option');
        if($query->num_rows()>0){
            $result=$query->row();
            return $result;
        }else{
            return false;
        }
    }

    function ans_update($id,$data){
        $this->db->where('id',$id);
        $this->db->update('ans_option',$data);
    }

    function delete_ans($id){
        $this->db->where('id',$id);
        $this->db->delete('ans_option');
    }*/
}
    