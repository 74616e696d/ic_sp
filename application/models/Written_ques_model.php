<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Written_ques_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table='written_ques';
		// $this->output->enable_profiler(true);
	}

	/**
	 * Find all written questions by terms
	 * 
	 * @param  string $terms
	 * @return object|boolean      
	 */
	function get_all($terms='')
	{
		$sql="select wq.*,wqa.answer from written_ques wq inner join written_ques_ans wqa on wq.id=wqa.qid {$terms}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}


	/**
	 * Get total records
	 * 
	 * @param  string $terms
	 * @return integer      
	 */
	function get_total($terms='')
	{
		$sql="select wq.id from written_ques wq inner join written_ques_ans wqa on wq.id=wqa.qid {$terms}";
		$qry=$this->db->query($sql);
		return $qry->num_rows();
	}


	function get_all_limit($start=0,$limit=100)
	{
		$this->db->from('written_ques wq');
		$this->db->join('written_ques_ans wqa','wq.id=wqa.qid');
		$this->db->limit($limit,$start);
		$this->db->select(array('wq.*','wqa.answer'));
		$qry=$this->db->get();
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

}

/* End of file written_ques_model.php */
/* Location: ./application/models/written_ques_model.php */