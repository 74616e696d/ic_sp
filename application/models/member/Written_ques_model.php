<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Written_ques_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table='written_ques';
	}

	function get_written_ques($exam)
	{
		$sql="select wq.*,wqa.answer from written_ques wq join 
		written_ques_ans wqa on wq.id=wqa.qid where 
		wq.id in (select wqm.qid from written_ques_mapping wqm where wqm.exam_name={$exam})";
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
}

/* End of file written_ques_model.php */
/* Location: ./application/models/member/written_ques_model.php */