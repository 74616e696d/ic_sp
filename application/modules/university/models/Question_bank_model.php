<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Author : Shamim
 * Description : small Description
 * Total Functions :
 */
class Question_bank_model extends UniModel {

    function __construct()
    {
        parent::__construct();
    }

    function add_question($data)
    {
        $this->db->trans_start();
        $this->db->insert('question_bank',$data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function total_model_test_question($key)
    {
        $sql="select qb.*,mtq.test_id from question_bank qb join 
                model_test_question mtq on qb.id=mtq.qid 
                {$key}";
        $query=$this->db->query($sql);
        return $query->num_rows();
    }

    function model_test_question($start=0,$limit=10,$key='')
    {
        $sql="select qb.*,mtq.test_id from question_bank qb join 
                model_test_question mtq on qb.id=mtq.qid 
                {$key}  order by id DESC limit {$start},{$limit}";
        //echo $sql;
        $query=$this->db->query($sql);
        if($query->num_rows()>0)
        {
            $result=$query->result();
            return $result;
        }
        else
        {
            return false;
        }
    }

    function question_get_all($start=0,$limit=10,$key='')
    {
        $sql='select *from question_bank '.$key.'  order by id DESC limit '.$start.','.$limit;
        //echo $sql;
        $query=$this->db->query($sql);
        if($query->num_rows()>0)
        {
            $result=$query->result();
            return $result;
        }
		else
		{
            return false;
        }
    }

    function qlist_get_all($terms='')
    {
        $sql="select *from question_bank {$terms}";
        $query=$this->db->query($sql);
        if($query->num_rows()>0)
        {
            $result=$query->result();
            return $result;
        }
        else
        {
            return false;
        }
    }

    function count_all($terms='')
    {
        $sql="select id from question_bank {$terms}";
        $query=$this->db->query($sql);
        return $query->num_rows();
    }

     function get_questions($key)
    {
        $sql='select id,question from question_bank '.$key;

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

    function question_by_key($key)
    {
        $sql='select question from question_bank '.$key;
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

    function question_by_cat($cat)
    {
         $sql='select question from question_bank where find_in_set(exam_cat,'.$cat.')';
        $query=$this->db->query($sql);
        if($query->num_rows()>0)
        {
            $result=$query->result();
            return $result;
        }
        else
        {
            return false;
        }
    }

    function get_matched_question($subj)
    {
        //$this->db->where('exam_name',$cat);
        $this->db->where('subject',$subj);
        $q=$this->db->get('question_bank');
        if($q->num_rows()>0)
        {
            return $q->result();
        }else
        {
            return false;
        }
    }

    function get_ans_options($id)
    {
        $this->db->where('id',$id);
        $this->db->select('options');
        $query=$this->db->get('question_bank');
        if($query->num_rows()>0){
            return $query->row();
        }
        else
        {
            return false;
        }
    }

    function total_question($key)
    {
        $sql='select id from question_bank '.$key;
        $query=$this->db->query($sql);
        if($query->num_rows()>0)
        {
            return $query->num_rows();
        }else
        {
            return false;
        }
    }
    function question_by_id($id)
    {
    	$this->db->cache_on();
        $this->db->where('id',$id);
        $query=$this->db->get('question_bank');
        $this->db->cache_off();
        if($query->num_rows()>0)
        {
            $result=$query->row();
            return $result;
        }
        else
        {
            return false;
        }
    }


    function get_questions_in($ques_arr=array())
    {
        $this->db->where_in('id',$ques_arr);
        $this->db->select(array('id','question','options','hints'));
        $qry=$this->db->get('question_bank');
        if($qry->num_rows()>0)
        {
            return $qry->result();
        }
        else
        {
            return false;
        }
    }


    function question_update($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('question_bank',$data);
    }

    function question_delete($id)
    {
        $this->db->trans_start();
        $this->db->where('id',$id);
        $this->db->delete('question_bank');
        $sql="select *from exam_question where find_in_set($id,'ques_id')";
        $qry=$this->db->query($sql);
        if($qry->num_rows()>0)
        {
            $result=$qry->result();
            foreach($result as $r)
            {
                $ques_id=$r->ques_id;
                if(!empty($ques_id)){
                $ques_id_arr=explode(',',$ques_id);
                $delete_qid=array_search($id,$ques_id_arr);
                unset($ques_id_arr[$delete_qid]);
                $ques_id_str=implode(',',$ques_id_arr);
                $this->db->where('id',$r->id);
                $this->db->update('exam_question',array('ques_id'=>$ques_id_str));
                }
            }
        }
        $this->db->trans_complete();
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

    function get_ques_by_subj($subject)
    {
        $sql='select * from question_bank where subject='.$subject .' and has_paragraph=1';
        $query=$this->db->query($sql);
        if($query->num_rows()>0){
            $result=$query->result();
            return $result;
        }else
        {
            return false;
        }
    }

    function get_ques_by_chapter($chapter)
    {
        $sql='select * from question_bank where chapter='.$chapter .' and has_paragraph=1';
        $query=$this->db->query($sql);
        if($query->num_rows()>0){
            $result=$query->result();
            return $result;
        }else
        {
            return false;
        }
    }

    function get_chapters_question($chapter)
    {
        $sql="select id, question, options,subject,hints,has_paragraph from question_bank where chapter={$chapter} and is_prev=1";
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

    function get_chapters_question_all($chapter)
    {
        $sql="select id, question, options,subject,hints,has_paragraph from question_bank where chapter={$chapter} order by id desc";
        //echo $sql;
        $this->db->cache_on();
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

    function get_subject_question_rand($subject)
    {
        $sql="select id, question, options,subject,hints,has_paragraph from question_bank where subject={$subject} order by rand() limit 50";
      
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

    function get_chapters_question_rand($chapter,$limit=10)
    {
        $sql="select id, question, options,subject,hints,has_paragraph from question_bank where chapter={$chapter} order by rand() limit {$limit}";
        //echo $sql;
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

    function get_top_chapters_question($chapter)
    {
        $sql="select id, question, options,subject,hints,has_paragraph from question_bank where chapter={$chapter} order by id limit 20";
        //echo $sql;
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

    public static function ques_text($id)
    {
    	$ci =& get_instance();
    	$ci->db->where('id',$id);
    	$query=$ci->db->get('question_bank');
    	if($query->num_rows()>0){

    		return $query->row()->question;
    	}else{
    		return false;
    	}
    }

    function ref_text_get_exam_by_cat($cid)
    {
        $sql='select * from ref_text where group_id=5 and parent_id='.$cid.' and display=1';
        $query=$this->db->query($sql);
        if($query->num_rows()>0){
            $result=$query->result();
            return $result;
        }else
        {
            return false;
        }
    }

  

    /**
     * Get Questions for exam practice
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    function get_practice_ques($key)
    {
        $sql="select id,question,options from question_bank {$key} order by rand() limit 100";
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
	
	function add_comprehension($data)
    {
	//Create availability validation
	$sql="select * from tb_comprehension where exam_name='".$data['exam_name']."' and subject='".$data['subject']."'";
    $query=$this->db->query($sql);
    	if($query->num_rows()>0)
    	{
        	echo"This comprehension already exists!";
        	return false;
    	}
        else
    	{	
            $this->db->insert('tb_comprehension',$data);
            echo"Comprehension is stored!";
    	}
    }


    function search_hints($hints)
    {
        $sql="select id,hints from question_bank where hints like '%{$hints}%'";
        $qry=$this->db->query($sql);
        if($qry->num_rows())
        {
            return $qry->result();
        }
        return false;
    }
}
    