<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chapter_details_model extends SchoolModel {

	function __construct()
	{
		parent::__construct();
		$this->table='ref_details';
	}

	function insert($data)
	{
		$this->db->insert('ref_details',$data);
		return ;
	}

	function  get_details_by_ref($ref_id)
	{
		$this->db->where('ref_id',$ref_id);
		$query=$this->db->get('ref_details');
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}
	}

	

	function update($ref_id,$data)
	{
		$this->db->where('ref_id',$ref_id);
		$this->db->update('ref_details',$data);
	}

}

/* End of file chapter_details_model.php */
/* Location: ./application/models/chapter_details_model.php */