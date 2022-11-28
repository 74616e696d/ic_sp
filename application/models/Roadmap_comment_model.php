<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roadmap_comment_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='roadmap_comment';
	}

	/**
	 * get all comments against a specific roadmap
	 * 
	 * @param  integer $roadmap_id
	 * 
	 * @return object|boolean           
	 */
	function get_comments($roadmap_id)
	{
		$sql="select * from roadmap_comment where roadmap_id={$roadmap_id} and display=1";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

}

/* End of file roadmap_comment_model.php */
/* Location: ./application/models/roadmap_comment_model.php */