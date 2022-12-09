<?php 
namespace App\Models\member;
use CodeIgniter\Model;

class Mistake_model extends Model {

	function __construct()
	{
	//	parent::__construct();
            $this->table='practice_mistake';
            
            $this->db = \Config\Database::connect();
	}

    function total($uid)
    {
        $sql="select count(id) as ttl from practice_mistake where user_id={$uid}";
        $qry=$this->db->query($sql);
        return $qry->row()->ttl;
    }

	function add($data)
	{
		$this->db->insert('practice_mistake',$data);
		return;
	}

	function exist($user,$qid)
	{
		$this->db->where('user_id',$user);
		$this->db->where('qid',$qid);
		$qry=$this->db->get('practice_mistake');
		if($qry->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function all($user)
	{
		$this->db->where('user_id',$user);
		$qry=$this->db->get('practice_mistake');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

    function get_mistake_list($user_id)
    {
        $sql="SELECT qb.id, qb.question, qb.options, qb.subject,qb.hints, 
        qb.chapter, practice_mistake.last_attempt_date from
        practice_mistake JOIN question_bank qb ON qb.id = practice_mistake.qid
        WHERE practice_mistake.user_id = {$user_id}
        ORDER BY practice_mistake.last_attempt_date desc";
        return $this->db->query($sql)->getResultObject();;
        /*if($qry->num_rows()>0)
        {
            return $qry->result();
        }
        else
        {
            return false;
        }*/
    }

	function mistake_questions($user)
    {
        $sql="select qb.id, qb.question, qb.options,pm.last_attempt_date from question_bank qb inner join practice_mistake pm on qb.id=pm.qid where pm.user_id={$user}";
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

    function get_last_mistake_date($uid,$qid)
    {
    	$this->db->where('user_id',$uid);
    	$this->db->where('qid',$qid);
    	$this->db->select('last_attempt_date');
    	$qry=$this->db->get('practice_mistake');
    	if($qry->num_rows()>0)
    	{
    		$dt='';
    		if(!empty($qry->row()->last_attempt_date))
    		{
    			$dt=date_create($qry->row()->last_attempt_date);
    			$dtf=date_format($dt,'d F, Y');
    			$dt=$dtf;
    		}
    		return $dt;

    	}
    	else
    	{
    		return false;
    	}
    }


    function get_frequent_mistake($chapter)
    {
        $sql="SELECT mq.qid,qb.id, qb.`question`,qb.`options`,qb.has_paragraph,COUNT(mq.qid) as total FROM model_quiz mq JOIN question_bank qb 
            ON mq.qid = qb.id where qb.chapter={$chapter} and (mq.ans!=mq.correct_ans)
         GROUP BY mq.qid ORDER BY COUNT(mq.id) DESC limit 10";
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

    function delete_mistake($uid,$qid)
    {
        $this->db->where('user_id',$uid);
        $this->db->where('qid',$qid);
        $this->db->delete('practice_mistake');
    }

    function update1($uid,$qid,$data)
    {
    	$this->db->where('user_id',$uid);
    	$this->db->where('qid',$qid);
    	$this->db->update('practice_mistake',$data);
    }

    function delete_user_mistake($uid)
    {
        $this->db->where('user_id',$uid);
        $qry=$this->db->delete('practice_mistake');
    }


}

/* End of file mistake_model.php */
/* Location: ./application/models/member/mistake_model.php */