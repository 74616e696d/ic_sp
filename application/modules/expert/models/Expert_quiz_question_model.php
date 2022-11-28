<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expert_quiz_question_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='expert_quiz_question';
	}

}

/* End of file expert_quiz_question_model.php */
/* Location: ./application/modules/expert/models/expert_quiz_question_model.php */