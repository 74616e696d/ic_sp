<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expert_details_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='expert_details';
	}

}

/* End of file expert_details_model.php */
/* Location: ./application/modules/expert/models/expert_details_model.php */