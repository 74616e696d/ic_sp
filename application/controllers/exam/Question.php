<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question extends Member_controller {
	
public function __construct() 
	{ 
	 parent::__construct();
	 $this->load->helper('url');
		$this->load->helper('form');	 
	 $this->load->model('Exam/question_paper_model');
	}
	public function index()
	{
		$data['question']=$this->question_paper_model->get_questionPaper();
		$this->load->view("Exam/question_paper",$data);
	}
}