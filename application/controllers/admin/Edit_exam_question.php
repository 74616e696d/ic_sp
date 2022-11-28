<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_exam_question extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('exam_question_model');
		$this->load->model('exam_model');
		$this->load->model('ref_text_model');
	}
	public function index()
	{
		$data['title']='Edit Exam Question';
		$data['exams']=$this->exam_model->get_test_name();
		$this->load->blade('admin.edit_exam_question', $data);
	}

	function get_questions()
	{
		$eid=$this->input->post('eid');
		$q=$this->exam_question_model->find_by('exam_id',$eid);
		echo $q?$q->ques_id:'';
	}

	function update_questions()
	{
		$exam_name=$this->input->post('ddl_exam_name');
		$qid=$this->input->post('txt_qid');
		$data=['ques_id'=>$qid];
		$this->exam_question_model->update_by('exam_id',$exam_name,$data);
		$this->session->set_flashdata('success', 'Question updated successfully!');
		redirect(base_url().'admin/edit_exam_question');
	}

}

/* End of file edit_exam_question.php */
/* Location: ./application/controllers/admin/edit_exam_question.php */