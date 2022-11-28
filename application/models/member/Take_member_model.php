<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Take_member_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function get_exam_list()
	{
		$q=$this->db->get();
		if($q->num_rows()>0)
		{
			return $q->result();
		}else
		{
			return false;
		}
	}

	

}

/* End of file take_member_model.php */
/* Location: ./application/models/member/take_member_model.php */