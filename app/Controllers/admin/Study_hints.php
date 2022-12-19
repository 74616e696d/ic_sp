<?php

class Study_hints extends Admin_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('study_hints_model');
	}

	public function index()
	{
		$data['hints']=$this->study_hints_model->all();
		$data['title']='Manage Study Hints';
		$this->load->blade('admin.study_hints.index', $data);
	}

	function create()
	{
		$data['title']='Create Study Hints';
		$this->load->blade('admin.study_hints.create', $data);
	}

	function store()
	{
		$title=$this->input->post('title');
		$details=$this->input->post('details');
		$display=$this->input->post('display');
		$date=date('Y-m-d H:i:s');
		$data=array('title'=>$title,
			'details'=>$details,
			'hints_date'=>$date,
			'display'=>$display);
		$this->study_hints_model->create($data);
		$this->session->set_flashdata('success', 'Hints created successfully!');
		redirect(base_url().'admin/study_hints');
	}

	function edit()
	{
		$id=$this->uri->segment(4);
		$data['hints']=$this->study_hints_model->find($id);
		$data['title']='Edit Study Hints';
		$this->load->blade('admin.study_hints.edit', $data);
	}

	function update()
	{
		$id=$this->input->post('hdn_id');
		$title=$this->input->post('title');
		$details=$this->input->post('details');
		$display=$this->input->post('display');
		$date=date('Y-m-d H:i:s');
		$data=array('title'=>$title,
			'details'=>$details,
			'hints_date'=>$date,
			'display'=>$display);
		$this->study_hints_model->update($id,$data);
		$this->session->set_flashdata('success', 'Hints updated successfully!!');
		redirect(base_url().'admin/study_hints');
	}

	function destroy()
	{
		$id=$this->uri->segment(4);
		$this->study_hints_model->delete($id);
		$this->session->set_flashdata('success', 'Hints deleted successfully!!');
		redirect(base_url().'admin/study_hints');
	}

}

/* End of file study_hints.php */
/* Location: ./application/controllers/admin/study_hints.php */