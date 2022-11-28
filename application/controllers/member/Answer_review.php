<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Answer_review extends Member_controller {

	function __construct()
	{
		parent::__construct();
		// check user authentication
		$roles=array('101','102');
  		membership_model::is_authenticate($roles);
    	//end check user authentication
		$this->load->model('member/result_model','result');
		$this->load->model('exam_model');
		$this->load->model('question_bank_model');
		//$this->output->enable_profiler(true);
	}
	public function index()
	{
		$exam_id=$this->uri->segment(4);
		$user=$this->uri->segment(5);
		$dt=$this->uri->segment(6);
	
		$wrong_answers=$this->result->get_wrong_answered_ques($user,$exam_id,$dt);
		$str_ans="<ul class='list-group'>";
		$sl=1;
		if($wrong_answers)
		{
			foreach ($wrong_answers as $ans) 
			{
				if($ans->answer!=$ans->correct_ans)
				{
					$question=$this->question_bank_model->question_by_id($ans->question_id);
					$stripped_ques=strip_tags(empty($question->question)?'':$question->question);
					$str_ans.="<li class='list-group-item'>{$sl}.&nbsp;&nbsp;{$stripped_ques}</li>";
					$ans_arr=explode('///',trim($question->options));
					$rng_ques=range('A','H');
					$i=0;

					foreach ($ans_arr as $a) {
						$strip_ans=strip_tags(trim($a),'<img>');
						$correct=substr($strip_ans,0,2)=="@@"?true:false;
						$ans_plain=str_replace('@@','',trim($strip_ans));
						if($correct)
						{
							$str_ans.="<li class='list-option correct'>{$rng_ques[$i]}.&nbsp;{$ans_plain}</li>";
						}
						else if($ans->answer==$rng_ques[$i])
						{
							$str_ans.="<li class='list-option wrong'>{$rng_ques[$i]}.&nbsp;{$ans_plain}</li>";
						}
						else
						{
							$str_ans.="<li class='list-option'>{$rng_ques[$i]}.&nbsp;{$ans_plain}</li>";
						}
						$i++;
					}
					if(!empty($question->hints))
					{	
						$strip_hint=strip_tags($question->hints,'<img>');
						$str_ans.="<li class='list-hint'><strong>Hints:&nbsp;</strong>{$strip_hint}</li>";
					}

					$str_ans.="<br/>";



					$sl++;
				}
			}
		}
		$str_ans.="</ul>";
		
		$data['list']=$str_ans;
		$data['title']='Answer Review';
		// $data['main_content']='member/v_answer_review';
		// $this->load->view('layout/layout', $data);
		$this->load->blade('member.v_answer_review', $data);
	}

}

/* End of file answer_review.php */
/* Location: ./application/controllers/member/answer_review.php */