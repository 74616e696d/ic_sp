<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qtags_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='qtags';
	}

	function tag_exist($tag)
	{
		$this->db->where('name',$tag);
		$qry=$this->db->get('qtags');
		if($qry->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

/* End of file qtags.php */
/* Location: ./application/models/qtags.php */