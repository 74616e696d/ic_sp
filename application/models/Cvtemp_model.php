<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cvtemp_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='cv_template';
	}

	function get_details()
	{
		$this->db->limit(1);
		$qry=$this->db->get('cv_desc');
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		return false;
	}
	function save_details($details,$link,$id=0)
	{	
		$qry=$this->db->get('cv_desc');
		if($qry->num_rows()>0)
		{
			$data=['description'=>$details,'video_link'=>$link];
			$this->db->where('id',$id);
			$this->db->update('cv_desc',$data);
		}else{
			$data=['description'=>$details,'video_link'=>$link];
			$this->db->insert('cv_desc',$data);
		}
	}
}

/* End of file cvtemp_model.php */
/* Location: ./application/models/cvtemp_model.php */