<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Author : Shamim
 * Description : small Description
 * Total Functions :
 */
class Answer_bank_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function add_question($data)
    {
        $this->db->insert('question_bank',$data);
        return;
    }
    function answer_get_all()
    {
        $this->db->select('*');    
        $this->db->from('question_bank');
        $this->db->join('ans_option', 'question_bank.id = ans_option.qid');
        $query = $this->db->get();
        $result=$query->result();
        return $result;
    }

    function question_by_id($id)
    {
        $sql='select *from question_bank where id='.$id;
        $query=$this->db->query($sql);
        if($query->num_rows()>0)
        {
            $result=$query->row();
            return $result;
        }else{return false;}
    }

    function question_update($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('question_bank',$data);
    }

    function question_delete($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('question_bank');
		return"succss";
    }

    function ref_text_get_exam_all()
    {
        $this->db->select('*');    
        $this->db->from('question_bank');
        $this->db->join('ans_option', 'question_bank.id = ans_option.qid');
        $query = $this->db->get();
        return $query;
    }

    function ref_text_get_exam_by_cat($cid)
    {
        $sql='select * from ref_text where group_id=5 and parent='.$cid.' and display=1';
        $query=$this->db->query($sql);
        if($query->num_rows()>0){
            $result=$query->result();
            return $result;
        }else
        {
            return false;
        }
    }
}
    