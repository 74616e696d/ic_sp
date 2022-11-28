<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Extra_model extends CI_Model {

	function get_rand_ques($chapter,$limit)
	{
		$sql="select distinct id from question_bank where chapter={$chapter} order by rand() limit {$limit}";
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

	function add($data)
	{
		$this->db->insert('model_test_question',$data);
	}

	function create_model_test($data)
	{
		$this->db->insert('model_test',$data);
		return $this->db->insert_id();
	}

	function batch_add($data)
	{
		$this->db->insert_batch('model_test_question',$data);
	}

}

/* End of file extra_model.php */
/* Location: ./application/models/extra_model.php */