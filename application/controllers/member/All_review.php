<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class All_review extends Member_controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('exam_model');
		$this->load->model('answer_sheet_model');
		$this->load->helper('quiz');
		//$this->output->enable_profiler(true);
	}
	public function index()
	{
		$eid=$this->uri->segment(4);
		$user_id=$this->uri->segment(5);
		$quiz_id=$this->uri->segment(6);

		$exam_ques=$this->exam_model->get_exam_question($eid);
		$exam_ques_str=$exam_ques?$exam_ques->ques_id:'';
		$ques_list=str_to_ques_list($exam_ques_str);

		$qlist='';
		if($ques_list)
		{
			$i=1;
			foreach ($ques_list as $q) {
				$correct_ans=$this->answer_sheet_model->get_user_answer($user_id,$quiz_id,$q->id);
				$ans=$correct_ans?$correct_ans->answer:'';			
				$qlist.=get_plain_ques($q->question,$i);
				$qlist.=get_option_list_correct_wrong($q->options,$ans);
				$hints=strip_tags($q->hints,'<img><p><i><sup><sub><b><u>');
				if(!empty($hints))
				{
					$qlist.="<li class='list-group-item hnts'><strong>Explanation:</strong>  {$hints}</li>";
				}
				
				$i++;
			}
		}

		$data['exam_name']=exam_model::get_text($eid);

		$data['qlist']=$qlist;
		$data['title']='All Answer Review';
		$this->load->blade('member.all_review', $data);
	}


	function get_given_answer($objects,$value) 
	{
	  	$vl=$value;
		$given_answer_meta = array_filter($objects, function ($e)use($vl) {
	        if($e->question_id == $vl)
	        {
	        	return $e;
	        }
		});

		$given_answer_meta=array_values($given_answer_meta);
	  	$answer=$given_answer_meta[0]->answer;
	  	//return $answer;
	}


}

/* End of file all_review.php */
/* Location: ./application/controllers/member/all_review.php */