<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Result extends Member_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Exam/test_model','obj');
		$this->load->model('exam_model');
		$this->load->model('answer_summery_model');
		$this->load->model('user_model');
	}

	public function index()
	{
		$test_name=$this->uri->segment(4);
		$user=$this->uri->segment(5);
		$summery=$this->answer_summery_model->where(array('track_id|='=>$test_name,'user_id|='=>$user))->row();
		$result=array();
		if($summery)
		{
			$dt=date_create($summery->exam_date);
			$dtf=date_format($dt,'d F, Y');
			$examname=exam_model::get_text($summery->exam_id);
			$time=gmdate('H:i:s',$summery->time_taken);

			$not_answered=$summery->total_question-($summery->total_correct+$summery->total_wrong);
			$user_top=$this->answer_summery_model->get_user_top($user,$test_name);
			$top=$this->answer_summery_model->get_top($summery->exam_id);
			$result=array('exam_id'=>$summery->track_id,
				'exam_name'=>$examname,
				'exam_date'=>$dtf,
				'time_taken'=>$time,
				'total_question'=>$summery->total_question,
				'total_correct'=>$summery->total_correct,
				'total_wrong'=>$summery->total_wrong,
				'not_answered'=>$not_answered,
				'user_top'=>$user_top,
				'top'=>$top

				);
		}
		$data['user']=$this->username;
		$data['result']=$result;
		$this->load->blade('member.v_result',$data);
	}

	function calculate_result()
	{
	
	}


}

/* End of file result.php */
/* Location: ./application/controllers/member/result.php */