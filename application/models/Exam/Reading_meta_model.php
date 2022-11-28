<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reading_meta_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function add($data)
	{
		$this->db->insert('reading_meta',$data);
		return;
	}

	function chapter_exists($user,$chapter)
	{
		$this->db->where('user_id',$user);
		$this->db->where('chapter_id',$chapter);
		$qry=$this->db->get('reading_meta');
		$result=$qry->num_rows()>0?true:false;
		return $result;
	}

	function get_model_test_attempt($user,$qid)
	{
	    $sql="select id from model_quiz where qid={$qid} and user_id={$user}";
	    $qry=$this->db->query($sql);
	    return $qry->num_rows();
	}

	function get_model_test_correct_attempt($user,$qid)
	{
	    $sql="select id from model_quiz where qid={$qid} and user_id={$user} and ans=correct_ans";
	    $qry=$this->db->query($sql);
	    return $qry->num_rows();
	}

}

/* End of file reading_meta.php */
/* Location: ./application/models/Exam/reading_meta.php */