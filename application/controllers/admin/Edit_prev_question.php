<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edit_prev_question extends Admin_Controller {


	public function __construct() 
	{	 
		parent::__construct(); 
		$this->load->model('question_model');
		$this->load->model('ref_text_model');
	}
		
	public function index()
	{
		$data['exams']=$this->question_model->ref_text_get_exam_all();
		$id=$this->uri->segment(4);
		$data['pq']=$this->question_model->prev_question_get_by_id($id);
		$this->load->view('admin/v_edit_prev_question',$data);
				
	}
	
	function update()
	{
		$question=$this->input->post('txt_ques_edit');
		$exam=$this->input->post('ddl_exam_edit');
		$period=$this->input->post('txt_period_edit');
		$subject=$this->input->post('txt_subject_edit');
		$chapter=$this->input->post('txt_chapter_edit');
		$marks=$this->input->post('txt_mark_edit');
	}
}
	
	