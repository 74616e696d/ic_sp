<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Written_ques_mapping_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table='written_ques_mapping';
	}	

	function get_all($qid)
	{
		$this->db->where('qid',$qid);
		$qry=$this->db->get($this->table);
		if($qry->num_rows()>0)
		{
			$result=$qry->result();
			$exm=[];
			foreach ($result as $key) {
				array_push($exm,$key->exam_name);
			}
			return $exm;
		}
		else
		{
			return [];
		}
	}
}

/* End of file written_ques_mapping.php */
/* Location: ./application/models/written_ques_mapping.php */