<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subject_quiz_result extends Member_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('subject_quiz_summery_model','sqsm');
		$this->load->model('ref_text_model');
	}

	public function index()
	{
		//$this->output->enable_profiler(true);
		$quiz_id=$this->uri->segment(4);
		$user=$this->uri->segment(5);

		$quiz_summery=$this->sqsm->where(array('quiz_id|='=>$quiz_id,'user_id|='=>$user))->row();

		$dt=date_create($quiz_summery->quiz_date);
		$dtf=date_format($dt,'d F, Y');

		$user_top=$this->sqsm->get_user_top($this->userid,$quiz_id);
		$top=$this->sqsm->get_top($quiz_summery->subject_id);

		$result=array('qid'=>$quiz_summery->quiz_id,
			'subject'=>ref_text_model::get_text($quiz_summery->subject_id),
			'dt'=>$dtf,
			'total'=>50,
			'time'=>$time=gmdate('H:i:s',$quiz_summery->time_taken),
			'correct'=>$quiz_summery->total_correct,
			'wrong'=>$quiz_summery->total_wrong,
			'unanswered'=>50-($quiz_summery->total_correct+$quiz_summery->total_wrong),
			'user_top'=>$user_top,
			'subject_top'=>$top);

		$data['username']=strtoupper($this->username);
		$data['result']=$result;
		$data['title']='';
		$this->load->blade('member.subject_quiz_result', $data);
	}

}

/* End of file subject_quiz_result.php */
/* Location: ./application/controllers/member/subject_quiz_result.php */