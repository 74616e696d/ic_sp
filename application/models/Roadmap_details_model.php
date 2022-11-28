<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roadmap_details_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='roadmap_details';
	}

	function get_roadmap($terms='')
	{
		$sql="select * from roadmap_details {$terms}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

	/**
	 * count all details
	 * @param  string $terms
	 * @return integer       
	 */
	function count_all($terms='')
	{
		$sql="select * from roadmap_details {$terms}";
		$qry=$this->db->query($sql);
		return $qry->num_rows();
	}

	/**
	 * get all chapter name of a roadmap
	 * 
	 * @param  integer $roadmap_id
	 * 
	 * @return object|boolean          
	 */
	static function chapter_tag($roadmap_id)
	{
		$ci =& get_instance();
		$sql="select ed.id,rtxt.name from roadmap_details ed join ref_text rtxt on ed.topics=rtxt.id where roadmap_id={$roadmap_id}";
		$qry=$ci->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;;
	}

	/**
	 * get all chapter name of a roadmap
	 * 
	 * @param  integer $roadmap_id
	 * 
	 * @return object|boolean          
	 */
	static function get_topics($id)
	{
		$ci =& get_instance();
		$sql="select ed.id,rtxt.name from roadmap_details ed join ref_text rtxt on ed.topics=rtxt.id where ed.id={$id}";
		$qry=$ci->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;;
	}


}

/* End of file roadmap_details_model.php */
/* Location: ./application/models/roadmap_details_model.php */