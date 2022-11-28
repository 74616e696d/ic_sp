<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quiz_result extends Member_controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('quiz_summery_model');
		$this->load->model('ref_text_model');
	}
	public function index()
	{
		$quiz_id=$this->uri->segment(4);
		$user=$this->uri->segment(5);
		$result=array();
		$quiz_summery=$this->quiz_summery_model->find_by_quz_id($quiz_id,$user);
		if($quiz_summery)
		{
			$dt=date_create($quiz_summery->quiz_date);
			$dtf=date_format($dt,'d F, Y');
			$top_score=$this->quiz_summery_model->user_top_correct($this->userid,$quiz_summery->chapter_id);
			$chapter_top=$this->quiz_summery_model->top_score($quiz_summery->chapter_id);
			$time=gmdate('H:i:s',$quiz_summery->time_taken);
			$result=array('qid'=>$quiz_summery->quiz_id,
				'chapter'=>ref_text_model::get_text($quiz_summery->chapter_id),
				'chapter_id'=>$quiz_summery->chapter_id,
				'dt'=>$dtf,
				'total_ques'=>20,
				'time'=>$time,
				'correct'=>$quiz_summery->total_correct,
				'wrong'=>$quiz_summery->total_wrong,
				'user_top_score'=>$top_score,
				'chapter_top'=>$chapter_top,
				'not_answered'=>20-($quiz_summery->total_correct+$quiz_summery->total_wrong));
		}

		$data['quiz_id']=$quiz_id;
		$data['result']=$result;
		$data['title']='';
		$this->load->blade('member.quiz_result', $data);
	}

}

/* End of file quiz_result.php */
/* Location: ./application/controllers/member/quiz_result.php */