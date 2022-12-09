<?php

namespace App\Controllers;
use App\Models\Job\Job_model;

use Illuminate\View\Factory as View;

class JobsController extends BaseController
{
    public function __construct()
    {
        //parent::__construct();
        $this->Job = new Job_model();
	
        
        $this->session = \Config\Services::session();
        $this->session->start();
        
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        // $jobCategories = [];
        $data['job_categories']=$this->Job->job_by_category();
        $data['job_location']=$this->Job->job_by_location();
        $data['job_deadline']=$this->Job->job_by_deadline();
        $data['featured_job']=$this->Job->get_featured_job();
        $data['student_jobs']=$this->Job->get_student_jobs();
        
        return $this->render('job.list',$data );
        
      /*  return $this->view->run('job.list', [
            'jobCategories' => $jobCategories
        ]);*/
    }

    public function cv()
    {
        $data['title']='CV Upload';
        return $this->render('job.cv_upload', $data);
    }

    function search()
	{
        $data['jobs']=false;
		$data['term']=$this->request->getPost('term');
        
		if($this->request->getPost('term'))
		{
			$term=$this->request->getPost('term');
			$data['term']=$term;
			$data['jobs']=$this->Job->job_search($term);
		}
		$data['title']='';
        
		$this->render('job.search', $data);
	}

}