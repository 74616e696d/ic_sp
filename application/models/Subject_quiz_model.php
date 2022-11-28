<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subject_quiz_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='subject_quiz';
	}	

}

/* End of file subject_quiz_model.php */
/* Location: ./application/models/subject_quiz_model.php */