<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prev_ques extends Member_controller {
	public function __construct() 
	{		 
		parent::__construct();
	}
		
	public function index()
	{
		$data['title']='Quiz';
		$data['main_content']='quiz/v_prev_ques';
		$this->load->view('layout/quiz_master',$data);
				
	}

}
