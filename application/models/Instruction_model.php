<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instruction_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table='exam_instruction';
	}

	function get_published_instructions($ref_id)
	{
		$this->db->where('ref_id',$ref_id);
		$this->db->where('display',1);
		$qry=$this->db->get('exam_instruction');
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return false;
		}
	}	

}

/* End of file instruction_model.php */
/* Location: ./application/models/instruction_model.php */