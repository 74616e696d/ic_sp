<?php

namespace App\Controllers;
use Illuminate\View\Factory as View;
use App\Models\Job\Job_model;
use App\Models\Dashboard_model;
use App\Models\Ref_text_model;
use App\Models\Exam_model;
use App\Models\Model_test_model;
use App\Models\Upcoming_test_model;
use App\Models\Current_news_model;
use App\Models\forum\Frm_post_model;
use App\Models\Events_model;


use Slug;


class HomeController extends BaseController
{
    public function __construct()
    {
        //parent::__construct();
        $this->Job = new Job_model();
	    $this->Dashboard_model = new Dashboard_model();
        $this->Ref_text_model = new Ref_text_model();
        $this->Exam_model = new Exam_model();
        $this->Model_test_model = new Model_test_model();
        $this->Upcoming_test_model= new Upcoming_test_model();
        $this->Current_news_model = new Current_news_model();
        $this->Events_model = new Events_model();
        $this->Frm = new Frm_post_model();
        
        $this->session = \Config\Services::session();
        $this->session->start();
        
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
         $data = [];
		 $data['jobs']=$this->Job->get_recent_jobs(3);
		 $data['student_jobs']=$this->Job->student_jobs(3);
		// //get online user statistics
		 $total_user=$this->Dashboard_model->get_total_user()+3000;
		 $online=$this->Dashboard_model->get_online_user();
		 $online_percent=($online/$total_user)*100;
		// //get online user statistics

		 $total_ques=$this->Dashboard_model->get_total_ques();
		 $data['total_user']=$total_user;
               
               
		 $data['bcs_subject']=$this->Ref_text_model->get_exam_wise_subject(7);
		 $data['bank_subject']=$this->Ref_text_model->get_exam_wise_subject(318);
		 $data['govt_subject']=$this->Ref_text_model->get_exam_wise_subject(833);
		 $data['teachers_subject']=$this->Ref_text_model->get_exam_wise_subject(713);
		 $data['mba_subject']=$this->Ref_text_model->get_exam_wise_subject(680);
		 $data['total_ques']=$total_ques;
		 $data['recent_exams']=$this->latest_exam_list();
		 $data['current_world']=$this->current_world_list();
		 $data['bcs_model_test']=$this->Model_test_model->get_model_test_by_cat(7,8);
		 $data['bank_model_test']=$this->Model_test_model->get_model_test_by_cat(318,8);
		 $data['govt_model_test']=$this->Model_test_model->get_model_test_by_cat(833,8);
		 $data['teachers_model_test']=$this->Model_test_model->get_model_test_by_cat(713,8);
		 $data['mba_model_test']=$this->Model_test_model->get_model_test_by_cat(680,8);

		 $data['online']=$online;
		 $data['online_percent']=$online_percent;
		 $data['bcs_exams']=$this->Exam_model->get_exam_list_by(7,[789,790,791,792,798,801,831,832,829,814,830,826,827,828],10);
		 $data['bank_exams']=$this->Exam_model->get_exam_list_by(318,[],8);
		 $data['govt_exams']=$this->Exam_model->get_exam_list_by(833,[],8);
		 $data['teachers_exams']=$this->Exam_model->get_exam_list_by(713,[],8);
		 $data['mba_exams']=$this->Exam_model->get_exam_list_by(680,[],8);
		 $data['next_bcs_exam']=$this->Upcoming_test_model->where('category','7')->get()->getResultArray();
		 $data['next_bank_exam']=$this->Upcoming_test_model->where('category','318')->get()->getResultArray();
		 $data['next_govt_exam']=$this->Upcoming_test_model->where('category','833')->get()->getResultArray();
		 $data['next_teachers_exam']=$this->Upcoming_test_model->where('category','713')->get()->getResultArray();
		 $data['next_mba_exam']=$this->Upcoming_test_model->where('category','680')->get()->getResultArray();
		 $data['top_news']=$this->Current_news_model->get_news(2);
		 $data['todays_class']=$this->Events_model->get_ongoing_event(3);
		 $data['forum']=$this->Frm->top_post(4);
		 $data['total_prev_count']=$this->Ref_text_model->total_prev_exams();
                 $data['is_auth'] = $this->session->get('userid');
                 $data['base_url'] = base_url(); 
                 $data['errors'] = $this->session->getFlashdata('error');
                         
      /*  $data['jobs']=array();
		 $data['student_jobs']=array();
		// //get online user statistics
		 $total_user=4000;
		 $online=5;
		 $online_percent=4;
        
        $data['total_user']=500;
                 $data['bcs_subject'] = array();
                 $data['bcs_exams'] = array();
                 $data['bcs_model_test'] = array();
                 $data['next_bcs_exam'] = 1;
                 $data['bank_subject'] = array();
                 $data['bank_exams'] = array();
                 $data['govt_exams'] = array();
                 $data['teachers_exams'] = array();
                 $data['mba_exams'] = array();
                 $data['next_bank_exam'] = array();
                 $data['next_govt_exam'] = array();
                 $data['govt_subject'] = array();
                 $data['teachers_subject'] = array();
                 $data['mba_subject'] = array();
                  $data['govt_model_test'] = array();
                  $data['bank_model_test'] = array();
                  $data['teachers_model_test'] = array();
                  $data['mba_model_test'] = array();
                  $data['next_teachers_exam'] = array();
                  $data['next_mba_exam'] = array();
                $data['next_bcs_exam'] = array();
        
        
                $data['top_news']=array();
		 $data['todays_class']=array();
		 $data['forum']=array();
		 $data['total_prev_count']=5; */
        
                //return $this->view->run('preview', $data);
                 //$this->load->view('cwblogview', $data);
                // return view('preview',$data);
                
                return $this->render('preview', $data);
    }

    function latest_exam_list()
	{
		$bcs=$this->Exam_model->get_latest_exam_by_cat(5,7,2);
		$bcs=is_array($bcs)?$bcs:[];
		$bank=$this->Exam_model->get_latest_exam_by_cat(5,318,2);
		$bank=is_array($bank)?$bank:[];

		$exams=array_merge($bcs,$bank);


	    $str='';
	    if($exams)
	    {
	        foreach ($exams as $exam)
	        {
	            $exam_name=empty($exam['test_name'])?$exam['name']:$exam['test_name'];
	            $str.="<dd><i class='fa fa-check-square-o'></i> <a href='".base_url()."public/user_reg'>{$exam_name}</a></dd>";
	        }
	    }
	    return $str;
	}

    function current_world_list()
	{
	    $result=$this->Dashboard_model->get_current_world_info(2);
	    $str='';
            
	    if($result)
	    {
               
	        foreach ($result as $r) {
                    print_r($r);
                    exit;
	            $qtext=strip_tags($r->question,'<img>');
	            $ans=strip_tags($r->options);
	            $ans_arry=explode('///',$ans);
	            $correct='';
	            foreach ($ans_arry as $a)
	            {
	                if(substr(trim(strip_tags($a,'<img>')),0,2)=="@@")
	                {

	                    $correct=str_replace("@@",'',trim(strip_tags($a,'<img>')));
	                }
	            }
	           $str.="<dd><i class='fa fa-check-square-o'></i>&nbsp;{$qtext}<br/>Ans: {$correct}</dd>";
	        }
	    }
	    return $str;
	}
}
