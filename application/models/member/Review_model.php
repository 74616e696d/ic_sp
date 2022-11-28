<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Review_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='ans_review_list';
	}

	function total($uid)
	{
	    $sql="select count(id) as ttl from ans_review_list where user_id={$uid}";
	    $qry=$this->db->query($sql);
	    return $qry->row()->ttl;
	}

	function all()
	{
		$qry=$this->db->get('ans_review_list');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function search_review_list($user='')
	{
		if($user!='')
		{
		$this->db->where('user_id',$user);
		}
		$qry=$this->db->get('ans_review_list');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}


	function delete_user_review($uid)
	{
		$this->db->where('user_id',$uid);
		$qry=$this->db->delete('ans_review_list');
	}

	function delete_review($uid,$qid)
	{
		$this->db->where('user_id',$uid);
		$this->db->where('qid',$qid);
		$this->db->delete('ans_review_list');
	}


}

/* End of file review_model.php */
/* Location: ./application/models/member/review_model.php */