<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activity_log extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('activity_log_model');
	}
	public function index()
	{
		$data['logs']=$this->activity_log_model->all();
		$data['title']='Acitivity Logs';
		$this->load->blade('admin.log.index', $data);
	}

	function create()
	{
		$data['title']='Activity Logs | Create';
		$this->load->blade('admin.log.create', $data);
	}

	function store()
	{
		$title=$this->input->post('title');
		$details=$this->input->post('details');
		$display=$this->input->post('display');
		$activity_date=date('Y-m-d H:i:s');
		$data=array('title'=>$title,
			'details'=>$details,
			'display'=>$display,
			'activity_date'=>$activity_date,
			'user_id'=>$this->userid);

		$this->activity_log_model->create($data);
		$this->session->set_flashdata('success', 'Activity created successfully!!');
		redirect(base_url()."admin/activity_log");
	}

	function edit()
	{
		$id=$this->uri->segment(4);
		$data['log']=$this->activity_log_model->find($id);
		$data['title']='Activity Logs | Edit';
		$this->load->blade('admin.log.edit',$data);
	}

	function update()
	{
		$id=$this->input->post('hdn_id');
		$title=$this->input->post('title');
		$details=$this->input->post('details');
		$display=$this->input->post('display');
		$activity_date=date('Y-m-d H:i:s');
		$data=array('title'=>$title,
			'details'=>$details,
			'display'=>$display
			);

		$this->activity_log_model->update($id,$data);
		$this->session->set_flashdata('success', 'Activity updated successfully!!');
		redirect(base_url()."admin/activity_log");
	}

	function destroy()
	{
		$id=$this->uri->segment(4);
		$this->activity_log_model->delete($id);
		$this->session->set_flashdata('success', 'Activity deleted successfully!!');
		redirect(base_url()."admin/activity_log");
	}

}

/* End of file activity_log.php */
/* Location: ./application/controllers/admin/activity_log.php */