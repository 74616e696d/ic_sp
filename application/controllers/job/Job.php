<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job extends Employeer_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library(['form_validation']);
		$this->load->model('job/job_model');
		$this->load->model('job_category_model');
	}

	public function index()
	{
		$data['title']='';
		$data['category']=$this->job_category_model->all();
		$this->load->blade('job.job_post.index', $data);
	}

	public function insert()
	{
		$this->form_validation->set_rules('job_cat', 'Job Category', 'trim|required');
		$this->form_validation->set_rules('post_name', 'Job Title', 'trim|required');
		$user_id=$this->input->post('user_id');
		$job_cat=$this->input->post('job_cat');
		$organization_name=$this->input->post('organization_name'); 
		$post_name=$this->input->post('post_name');
		$education=$this->input->post('education');
		$experience=$this->input->post('experience');
		$vacancy_no=$this->input->post('vacancy_no');
		$job_responsibility=$this->input->post('job_responsibility'); 
		$job_nature=$this->input->post('job_nature');
		$experience_requirement_details=$this->input->post('experience_requirement_details');
		$aditional_job_requirement=$this->input->post('aditional_job_requirement');
		$job_location=$this->input->post('job_location');
		$salary_range=$this->input->post('salary_range'); 
		$other_benefits=$this->input->post('other_benefits');
		$age=$this->input->post('age');
		$publish_date=$this->input->post('publish_date');
		$deadline=$this->input->post('deadline');

		$data=[
		'user_id'=>$this->session->userdata('current_user_id'),
		'job_cat'=>$job_cat,
		'organization_name'=>$organization_name,
		'post_name'=>$post_name,
		'education'=>$education,
		'experience'=>$experience,
		'vacancy_no'=>$vacancy_no,
		'job_responsibility'=>$job_responsibility,
		'job_nature'=>$job_nature,
		'experience_requirement_details'=>$experience_requirement_details,
		'aditional_job_requirement'=>$aditional_job_requirement,
		'job_location'=>$job_location,
		'salary_range'=>$salary_range,
		'other_benefits'=>$other_benefits,
		'age'=>$age,
		'publish_date'=>$publish_date,
		'deadline'=>$deadline];

		if($this->form_validation->run() == FALSE) {
			$this->load->blade('job.job_post.index');
		} 
		else
		{
			$this->job_model->create($data);
			$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Job inserted Successfully!</div>');
			redirect(base_url().'job_post/index');
		}
	}

}

/* End of file job.php */
/* Location: ./application/controllers/job/job.php */