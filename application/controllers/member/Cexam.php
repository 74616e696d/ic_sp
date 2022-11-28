<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cexam extends Member_controller {
	private $title='41st BCS Preliminary Course';

	private $course_category=7;
	function __construct()
	{
		parent::__construct();
		$this->load->model('roadmap_model');
		$this->load->model('roadmap_details_model');
		$this->load->model('ref_text_model');
		$this->load->model('membership_model');
		$this->load->model('roadmap_comment_model');
		$this->load->model('user_model');
	}

	public function index()
	{
		$data['is_paid']=$this->membership_model->is_paid($this->userid);
		$data['roadmap']=$this->roadmap_model->get_all(115);
		$data['title']='43rd Preliminary Test Preparation';
		$this->load->blade('member.upcoming.index', $data);
	}

	function ntrca()
	{
		$data['batch']='';
		$data['all']=$this->roadmap_model->get_roadmap(" where display=1 and category=713 and exam_name not like '%2nd Batch%' and exam_name not like '%3rd Batch%'");

		$data['is_paid']=$this->membership_model->is_paid($this->userid);
		$roadmap=$this->roadmap_model->todays_roadmap($this->course_category);
		$data['roadmap']=$roadmap;
		$test_id=0;
		if($roadmap)
		{
			if(!empty($roadmap->test_id))
			{
				$test_id=$roadmap->test_id;
			}
		}
		$data['start_date']='';
		$data['tops']=$this->roadmap_model->get_top_scorer($test_id,date('Y-m-d'));
		$data['title']='17th NTRCA';
		$this->load->blade('member.upcoming.ntrca', $data);
	}

	function bank()
	{
		$data['batch']='';
		$data['all']=$this->roadmap_model->get_roadmap(" where display=1 and category=318 and exam_name not like '%2nd Batch%' and exam_name not like '%3rd Batch%' and exam_name not like '%Crash Program%'");

		$data['is_paid']=$this->membership_model->is_paid($this->userid);
		$roadmap=$this->roadmap_model->todays_roadmap($this->course_category);
		$data['roadmap']=$roadmap;
		$test_id=0;
		if($roadmap)
		{
			if(!empty($roadmap->test_id))
			{
				$test_id=$roadmap->test_id;
			}
		}
		$data['start_date']='';
		$data['tops']=$this->roadmap_model->get_top_scorer($test_id,date('Y-m-d'));
		$data['title']='BANGLADESH BANK AD COURSE';
		$this->load->blade('member.upcoming.bank_course', $data);
	}

	function primary_school()
	{
		$data['batch']='';
		$data['all']=$this->roadmap_model->get_roadmap(" where display=1 and category=1587 and exam_name not like '%2nd Batch%' and exam_name not like '%3rd Batch%' and exam_name not like '%Crash Program%'");

		$data['is_paid']=$this->membership_model->is_paid($this->userid);
		$roadmap=$this->roadmap_model->todays_roadmap($this->course_category);
		$data['roadmap']=$roadmap;
		$test_id=0;
		if($roadmap)
		{
			if(!empty($roadmap->test_id))
			{
				$test_id=$roadmap->test_id;
			}
		}
		$data['start_date']='';
		$data['tops']=$this->roadmap_model->get_top_scorer($test_id,date('Y-m-d'));
		$data['title']='PRIMARY SCHOOL TEACHER COURSE';
		$this->load->blade('member.upcoming.primary_school', $data);
	}


function inception()
	{
		$data['batch']='';
		$data['all']=$this->roadmap_model->get_roadmap(" where display=1 and category=7 and exam_name like '%COMBINED%' ");

		$data['is_paid']=$this->membership_model->is_paid($this->userid);
		$roadmap=$this->roadmap_model->todays_roadmap($this->course_category);
		$data['roadmap']=$roadmap;
		$test_id=0;
		if($roadmap)
		{
			if(!empty($roadmap->test_id))
			{
				$test_id=$roadmap->test_id;
			}
		}
		$data['start_date']='';
		$data['tops']=$this->roadmap_model->get_top_scorer($test_id,date('Y-m-d'));
		$data['title']='Combined Course for BCS & Bangladesh Bank AD';
		$this->load->blade('member.upcoming.inception', $data);
	}

	function ongoing()
	{
		$batch='';
		if($this->uri->segment(4))
		{
			$batch=$this->uri->segment(4);
		}

		$data['batch']='';
		$data['start_date']='STARTS FROM 20 TH JANUARY';
		

		if(!empty($batch))
		{
			if($batch=='batch2')
			{
				// $this->output->enable_profiler(true);
				$data['batch']='batch2';
				$data['start_date']='';
				$data['all']=$this->roadmap_model->get_roadmap(" where display=1 and category={$this->course_category} and exam_name like '%2nd Batch%'");
			}
			elseif($batch=='batch3')
			{
				$data['batch']='batch3';
				$data['start_date']='';
				$data['all']=$this->roadmap_model->get_roadmap(" where display=1 and category={$this->course_category} and exam_name like '%3rd Batch%'");
			}
			
		}
		else
		{
			$data['batch']='';
			$data['all']=$this->roadmap_model->get_roadmap(" where display=1 and category={$this->course_category} and exam_name not like '%2nd Batch%' and exam_name not like '%3rd Batch%'");
		}



		$data['is_paid']=$this->membership_model->is_paid($this->userid);
		$roadmap=$this->roadmap_model->todays_roadmap($this->course_category);
		$data['roadmap']=$roadmap;
		$test_id=0;
		if($roadmap)
		{
			if(!empty($roadmap->test_id))
			{
				$test_id=$roadmap->test_id;
			}
		}
		$data['tops']=$this->roadmap_model->get_top_scorer($test_id,date('Y-m-d'));
		$data['title']=$this->title;
		$this->load->blade('member.upcoming.ongoing', $data);
	}

	function details()
	{
		if($this->membership_model->is_expired($this->userid) && $this->utype!='101')
			redirect(base_url().'public/upgrade');
		$id=$this->uri->segment(4);
		$data['details']=$this->roadmap_details_model->find($id);
		$data['title']='Study';
		$this->load->blade('member.upcoming.details', $data);
	}

	/**
	 * save roadmap comment to database
	 * 
	 * @return void
	 */
	function make_comment()
	{
		$rid=$this->input->post('rid');
		$comment=$this->input->post('comment');
		if(!empty($comment))
		{
			$data=['comment'=>$comment,
			'roadmap_id'=>$rid,
			'comment_by'=>$this->userid,
			'display'=>1,
			'created_at'=>date('Y-m-d H:i:s')];

			$this->roadmap_comment_model->create($data);
			echo 'Comment posted successfully !';
		}
		else{
			echo "Unable to post comment !";
		}
	}

	/**
	 * get roadmap comment via ajax request
	 * 
	 * @return void
	 */
	function get_comments()
	{
		$rid=$this->input->post('rid');
		$comments=$this->roadmap_comment_model->get_comments($rid);
		$str="<ul class='list-unstyled list-comment'>";
		if($comments)
		{
			foreach ($comments as $comment) 
			{
				$str.="<li>";
				$str.='<p>'.$comment->comment.'</p>';

				$user=$this->user_model->find($comment->comment_by);
				$user=!empty($user->user_name)?$user->user_name:$user->email;
				$str.="<span class='pull-left'><i class='fa fa-user'></i>&nbsp;&nbsp; {$user}</span>";

				$tm=date('d M, Y',strtotime($comment->created_at));
				$str.="<span class='pull-right'><i class='fa fa-clock'></i>&nbsp;&nbsp; {$tm}</span>";
				$str.="<div class='clearfix'></div> <hr/>";
				$str.="</li>";
			}
		}
		else
		{
			$str.="<li>Be first to post your opinion !</li>";
		}
		$str.="</ul>";
		echo $str;
	}

}

/* End of file upcoming.php */
/* Location: ./application/views/member/upcoming.php */