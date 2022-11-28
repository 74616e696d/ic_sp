<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expert_tags_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='expert_tags';
	}

	/**
	 * get tags by wildcard
	 * 
	 * @param  string $name
	 * 
	 * @return  json
	 */
	function tags($name)
	{
		$sql="select name as value ,id from tags_manager where name like '%{$name}%'";
		$qry=$this->db->query($sql);

		if($qry->num_rows()>0)
		{
			$result=$qry->result_array();
			return json_encode($result);
		}
		return json_encode([]);
	}

}

/* End of file expert_tags_model.php */
/* Location: ./application/modules/expert/models/expert_tags_model.php */