<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question_set extends Member_controller {

	function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$data['title']='Question Set';
		//$data['main_content']='member/v_question_set';
		//$this->load->view('layout/layout', $data);
		$this->load->blade('member.v_question_set', $data);
	}

}

/* End of file question_set.php */
/* Location: ./application/controllers/member/question_set.php */