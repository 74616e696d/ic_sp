<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chapter_quiz_wrong extends Member_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('quiz_model');
		$this->load->model('question_bank_model');

	}
	public function index()
	{
		$chapter=$this->uri->segment(4);
		$time=$this->uri->segment(5);
		$wrong_answers=$this->quiz_model->get_quiz_wrong_list($this->userid,$chapter,$time);
		$str_ans="<ul class='list-group'>";
		$sl=1;
		if($wrong_answers)
		{
			foreach ($wrong_answers as $ans) 
			{
				if($ans->ans!=$ans->correct_ans)
				{
					$question=$this->question_bank_model->question_by_id($ans->qid);
					$stripped_ques=strip_tags(empty($question->question)?'':$question->question);
					$str_ans.="<li class='list-group-item'>{$sl}.&nbsp;&nbsp;{$stripped_ques}</li>";
					$ans_arr=explode('///',trim($question->options));
					$rng_ques=range('A','H');
					$i=0;

					foreach ($ans_arr as $a) 
					{
						$strip_ans=strip_tags(trim($a),'<img>');
						$correct=substr($strip_ans,0,2)=="@@"?true:false;
						$ans_plain=str_replace('@@','',trim($strip_ans));
						if($correct)
						{
							$str_ans.="<li class='list-option correct'>{$rng_ques[$i]}.&nbsp;{$ans_plain}</li>";
						}
						else if($ans->ans==$rng_ques[$i])
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
		$data['title']='Chapter Quiz Mistake List';
		$this->load->blade('member.chapter_quiz_wrong', $data);
	}

}

/* End of file chapter_quiz_wrong.php */
/* Location: ./application/controllers/member/chapter_quiz_wrong.php */