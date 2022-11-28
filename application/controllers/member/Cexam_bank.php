<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cexam_bank extends Member_controller {
	private $title='Bank Exam Crash Program';

	private $course_category=318;
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
		$data['roadmap']=$this->roadmap_model->get_all($this->course_category);
		$data['title']=$this->title;
		$this->load->blade('member.upcoming_bank.index', $data);
	}

	function ongoing()
	{
		$data['all']=$this->roadmap_model->get_roadmap(" where display=1 and category={$this->course_category}");
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
		$this->load->blade('member.upcoming_bank.ongoing', $data);
	}

	function details()
	{
		//if($this->membership_model->is_expired($this->userid) && $this->utype!='101')
		//	redirect(base_url().'public/upgrade');

		$id=$this->uri->segment(4);
		$data['details']=$this->roadmap_details_model->find($id);
		$data['roadmap']=$this->roadmap_model->find($data['details']->roadmap_id);
		$test_id=0;
		if($data['roadmap'])
		{
			if(!empty($data['roadmap']->test_id))
			{
				$test_id=$data['roadmap']->test_id;
			}
		}
		$data['tops']=$this->roadmap_model->get_top_scorer($test_id,date('Y-m-d'));
		$data['title']='Study Topics';
		$this->load->blade('member.upcoming_bank.details', $data);
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

/* End of file upcoming_bank.php */
/* Location: ./application/views/member/upcoming_bank.php */