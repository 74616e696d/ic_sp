<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Applied_jobs extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='applied_jobs';
	}

}

/* End of file applied_jobs.php */
/* Location: ./application/models/job/applied_jobs.php */