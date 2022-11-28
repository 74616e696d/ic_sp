<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Member_controller {

public function __construct() 
{ 
	 parent::__construct();
	 $this->load->helper('url');
	 $this->load->helper('form');	 
	 $this->load->model('Exam/home_model');
	 $this->load->model('Exam/question_paper_model');
	}
	public function index()
	{
		$data['question']=$this->home_model->show_ref_text();

		$this->load->view("Exam/home",$data);
	}
	function get_parent_text()
	{
	$p=$this->input->post('parent_id');
	$data=$this->home_model->show_parent_text($p);
	if(!empty($data)){
	foreach($data as $v){

	echo "<p><a onclick='viewme($v->id)' href='".base_url()."Exam/home/set_question_paper/$v->group_id/$v->id'>".$v->name."</a></p>";
	}
	}
	else
	{
		echo"No question found!";
	}
	}
	public function set_question_paper()
	{
	$ctg=$this->uri->segment(4);
	$exam_name=$this->uri->segment(5);
	$data['question']=$this->question_paper_model->get_questionPaper($exam_name);
	$this->load->view("Exam/question_paper",$data);
	}
}
?>