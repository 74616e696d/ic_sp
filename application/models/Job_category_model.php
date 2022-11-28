<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_category_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='job_category';
	}	

}

/* End of file job_category_model.php */
/* Location: ./application/models/job_category_model.php */