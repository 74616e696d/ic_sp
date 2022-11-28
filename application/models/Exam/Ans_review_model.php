<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ans_review_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function total($uid)
	{
	    $sql="select count(id) as ttl from ans_review_list where user_id={$uid}";
	    $qry=$this->db->query($sql);
	    return $qry->row()->ttl;
	}

	function add($data)
	{
		$this->db->insert('ans_review_list',$data);
		return;
	}

	public function exists($user,$qid)
	{
		$this->db->where('user_id',$user);
		$this->db->where('qid',$qid);
		$qry=$this->db->get('ans_review_list');
		if($qry->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	
	function delete($user)
	{
		$this->db->where('user_id',$user);
		$this->db->delete('ans_review_list');
	}

}

/* End of file ans_review_model.php */
/* Location: ./application/models/Exam/ans_review_model.php */