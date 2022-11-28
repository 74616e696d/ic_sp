<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exam_question_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='exam_question';
	}

	function get_questions($exam)
	{
		$this->db->where();
	}

}

/* End of file exam_question_model.php */
/* Location: ./application/models/exam_question_model.php */