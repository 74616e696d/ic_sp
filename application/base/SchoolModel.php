<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SchoolModel extends MY_Model {

	var $db=NULL;
	function __construct()
	{
		parent::__construct();
		$this->db=$this->load->database('school',TRUE);
	}

}

/* End of file UniModel.php */
/* Location: ./application/base/UniModel.php */