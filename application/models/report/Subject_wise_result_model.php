<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subject_wise_result_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->model('ref_text_model');
	}


}

/* End of file subject_wise_result_model.php */
/* Location: ./application/models/report/subject_wise_result_model.php */