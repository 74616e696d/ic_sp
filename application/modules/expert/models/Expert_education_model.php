<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expert_education_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='expert_education_details';
	}


	/**
	 * update expert education
	 * 
	 * @param  integer $id    
	 * @param  integer $userid
	 * @param  array $data  
	 * 
	 * @return void       
	 */
	function update_education($id,$userid,$data)
	{
		$this->db->where('id',$id);
		$this->db->where('user_id',$userid);
		$this->db->update('expert_education_details',$data);
	}

	/**
	 * delete expert education details
	 * 
	 * @param  integer $id     
	 * @param  integer $userid 
	 * 
	 * @return void         
	 */
	function delete_education($id,$userid)
	{
		$this->db->where('id',$id);
		$this->db->where('user_id',$userid);
		$this->db->delete('expert_education_details');
	}

}

/* End of file exper_education_model.php */
/* Location: ./application/modules/expert/models/exper_education_model.php */