<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_list extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$config = array(
		    'table' => 'job_list',
		    'id' => 'id',
		    'field' => 'slug',
		    'title' => 'title',
		    'replacement' => 'dash' // Either dash or underscore
		);
		$this->load->library('slug', $config);
		$this->load->model('job/job_model','job');
		$this->load->model('job_category_model');
		$this->load->model('job/emp_model','emp');
		$this->load->model('company_model');
		$this->load->model('job/company_exam_mapping_model','mapping');
		$this->load->helper('common');
	}	

	function index()
	{
		$data['job_category']=$this->job->job_by_category();
		$data['job_location']=$this->job->job_by_location();
		$data['job_company']=$this->job->job_by_company();
		$data['job_deadline']=$this->job->job_by_deadline();
		$data['featured_job']=$this->job->get_featured_job();
		$data['student_jobs']=$this->job->get_student_jobs();
		$data['title']='';
		$this->load->blade('job.list', $data);
	}

	function details()
	{
		$cat=$this->uri->segment(4);
		// $data['jobs']=$this->job->job_list_by_category($cat);
		$data['cats']=$this->job_category_model->all_by('display',1);
		$data['current_cat']=$cat;
		$data['title']='';
		$this->load->blade('job.job_details', $data);
	}

	function cv()
	{
		$data['title']='CV Upload';
		$this->load->blade('job.cv_upload', $data);
	}

	function get_job_excerpt_list()
	{
		$cat=$this->input->post('cat');
		$jobs=$this->job->job_list_by_category($cat);
		$data['jobs']=$jobs;
		$res=$this->load->blade('job.partial.job_excerpt', $data, TRUE);
		echo json_encode(['res'=>(string)$res,'total'=>count($jobs)]);
	}

	function details_location()
	{
		$loc=$this->uri->segment(4);
		$location=file_get_contents(base_url().'asset/district.json');
		$data['location']=json_decode($location);
		$data['current_loc']=$loc;
		$data['title']='';
		$this->load->blade('job.job_details_location', $data);
	}

	function get_job_excerpt_list_loc()
	{
		$loc=$this->input->post('loc');
		$data['jobs']=$this->job->job_list_by_location($loc);
		$res=$this->load->blade('job.partial.job_excerpt', $data, TRUE);
		echo $res;
	}

	function details_company()
	{
		$com=$this->uri->segment(4);
		$company=$this->company_model->all_by('active',1);
		$data['company']=$company;
		$data['current_com']=$com;
		$data['title']='';
		$this->load->blade('job.job_details_company', $data);
	}

	function get_job_excerpt_list_com()
	{
		$com=$this->input->post('com');
		$data['jobs']=$this->job->job_list_by_company($com);
		$res=$this->load->blade('job.partial.job_excerpt', $data, TRUE);
		echo $res;
	}

	function search()
	{
		$data['jobs']=false;
		$data['term']='';
		if($this->input->post('term'))
		{
			$term=$this->input->post('term');
			$data['term']=$term;
			$data['jobs']=$this->job->job_search($term);
		}
		$data['title']='';
		$this->load->blade('job.search', $data);
	}

	function single()
	{
		$data['title']='';
		$id=$this->uri->segment(4);
		$job=$this->job->find($id);
		$data['job']=$job;
		$data['company']=$this->company_model->find($job->com_info);
		$this->load->blade('job.single', $data);
	}

}

/* End of file list.php */
/* Location: ./application/controllers/job/list.php */