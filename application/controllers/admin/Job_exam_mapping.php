<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_exam_mapping extends Admin_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('company_model');
		$this->load->model('ref_text_model');
		$this->load->model('job/Company_exam_mapping_model','mapping');
	}
	public function index()
	{
		$data['mapping']=$this->mapping->get_mapping();
		$data['title']='Mapped Exam List To Job';
		$this->load->blade('admin.job.mapping_list', $data);
	}

	public function create()
	{
		$data['company']=$this->company_model->all();
		$data['exam_category']=$this->ref_text_model->all_by('group_id',2);
		$data['title']='Mapping Exam To Job';
		$this->load->blade('admin.job.mapping', $data);
	}

	function store_mapping()
	{
		$company=$this->input->post('ddl_company');
		$category=$this->input->post('ddlCategory');
		$prev_exam=$this->input->post('ddl_prev_exam');
		$model_test=$this->input->post('ddl_model_test');
		if(!empty($company) && !empty($category))
		{
			$data=[
			'company_id'=>$company,
			'cat_id'=>$category,
			'prev_exam'=>json_encode($prev_exam),
			'model_test'=>json_encode($model_test)
			];

			if(!$this->mapping->already_mapped($company,$category)){
				$this->mapping->create($data);
				$this->session->set_flashdata('success', 'Exam mapped to company successfully !');
				redirect(base_url().'admin/job_exam_mapping');
			}
			$this->session->set_flashdata('error', 'Exam to this company mapped !');
			redirect(base_url().'admin/job_exam_mapping/create');
			
		}
		$this->session->set_flashdata('error', 'Unbale to insert !');
		redirect(base_url().'admin/job_exam_mapping/create');
	}

	function edit()
	{
		$company_id=$this->uri->segment(4);
		$cat=$this->uri->segment(5);
		$data['mapped']=$this->mapping->get_one($company_id,$cat);
		$data['company']=$this->company_model->all();
		$data['exam_category']=$this->ref_text_model->all_by('group_id',2);
		$data['title']='Edit Mapped Exam To Job';
		$this->load->blade('admin.job.edit_mapping', $data);
	}

	function update()
	{
		// $this->output->enable_profiler(true);
		$company=$this->input->post('ddl_company');
		$category=$this->input->post('ddlCategory');
		$prev_exam=$this->input->post('ddl_prev_exam');
		$model_test=$this->input->post('ddl_model_test');
		if(!empty($company) && !empty($category))
		{
			$data=[
				'prev_exam'=>json_encode($prev_exam),
				'model_test'=>json_encode($model_test)
			];

			$this->mapping->update_mapping($company,$category,$data);
			$this->session->set_flashdata('success', 'Exam mapped to company successfully !');
			redirect(base_url().'admin/job_exam_mapping');
		}
		$this->session->set_flashdata('error', 'Unbale to insert !');
		redirect(base_url().'admin/job_exam_mapping/edit/'.$company.'/'.$category);
	}

	function get_prev_exam()
	{
		$sel_prev_exams=$this->input->post('sel_prev_exam')?json_decode($this->input->post('sel_prev_exam')):[];
		$cat=$this->input->post('cat');
		$prev_exams=$this->mapping->get_prev_exam($cat);
		$str='';
		if($prev_exams)
		{
			foreach ($prev_exams as $exm) 
			{
				$selected=in_array($exm->id,$sel_prev_exams)?'selected':'';
				$str.="<option {$selected} value='{$exm->id}'>{$exm->name}</option>";
			}
		}
		echo $str;
	}
	

	function model_test()
	{
		$sel_model_test=$this->input->post('sel_model_test')?json_decode($this->input->post('sel_model_test')):[];
		$cat=$this->input->post('cat');
		$model_test=$this->mapping->get_model_test($cat);
		$str='';
		if($model_test)
		{
			foreach ($model_test as $exm) 
			{
				$selected=in_array($exm->id,$sel_model_test)?'selected':'';
				$str.="<option {$selected} value='{$exm->id}'>{$exm->name}</option>";
			}
		}
		echo $str;
	}



}

/* End of file job_exam_mapping.php */
/* Location: ./application/controllers/admin/job/job_exam_mapping.php */