<?php

class Instruction extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ref_text_model');
		$this->load->model('instruction_model');
	}

	public function index()
	{
		$data['instructions']=$this->instruction_model->all();
		$data['title']='Exam Instructions';
		$this->load->blade('admin.instruction.index', $data);
	}

	function create()
	{
		$data['exams']=$this->ref_text_model->get_ref_text_by_group(2);
		$data['title']='Create Exam Instruction';
		$this->load->blade('admin.instruction.create', $data);
	}

	function store()
	{
		$exams=$this->input->post('reftexts');
		$details=$this->input->post('details');
		$req=$this->input->post('req');
		$syllabus=$this->input->post('syllabus');
		$hwprepare=$this->input->post('hwprepare');
		$ck_display=$this->input->post('ck_display');
		$data=array('ref_id'=>$exams,
			'details'=>$details,
			'syllabus'=>$syllabus,
			'hwprepare'=>$hwprepare,
			'display'=>$ck_display);
		if(!empty($exams))
		{
			$this->instruction_model->create($data);
			$this->session->set_flashdata('success', 'Successfully inserted !');
			redirect(base_url()."admin/instruction");
		}
		else
		{
			$this->session->set_flashdata('error', 'Exam Category must be selected !');
			redirect(base_url()."admin/instruction/create");
		}
	}

	function edit()
	{
		$id=$this->uri->segment(4);
		$data['exams']=$this->ref_text_model->get_ref_text_by_group(2);
		$data['ins']=$this->instruction_model->find($id);
		$data['title']='Edit Exam Instruction';
		$this->load->blade('admin.instruction.edit', $data);
	}

	function update()
	{
		$id=$this->input->post('hdn_id');
		$exams=$this->input->post('reftexts');
		$details=$this->input->post('details');
		$req=$this->input->post('req');
		$syllabus=$this->input->post('syllabus');
		$hwprepare=$this->input->post('hwprepare');
		$ck_display=$this->input->post('ck_display');
		$data=array('ref_id'=>$exams,
			'details'=>$details,
			'syllabus'=>$syllabus,
			'hwprepare'=>$hwprepare,
			'display'=>$ck_display);
		if(!empty($exams))
		{
			$this->instruction_model->update($id,$data);
			$this->session->set_flashdata('success', 'Successfully updated !');
			redirect(base_url()."admin/instruction");
		}
		else
		{
			$this->session->set_flashdata('error', 'Exam Category must be selected !');
			redirect(base_url()."admin/instruction/create");
		}
	}

	function destroy()
	{
		$id=$this->uri->segment(4);
		$this->instruction_model->delete($id);
		$this->session->set_flashdata('success', 'successfully deleted!!');
		redirect(base_url()."admin/instruction");
	}

}

/* End of file instruction.php */
/* Location: ./application/controllers/admin/instruction.php */