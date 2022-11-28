<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UniModel extends MY_Model {

	var $db=NULL;
	function __construct()
	{
		parent::__construct();
		$this->db=$this->load->database('uni',TRUE);
	}

}

/* End of file UniModel.php */
/* Location: ./application/base/UniModel.php */