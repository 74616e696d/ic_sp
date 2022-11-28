<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quiz_result_details extends Member_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('quiz_model');
		$this->load->model('quiz_summery_model');
		$this->load->model('ref_text_model');
	}

	public function index()
	{
		$data['quiz_lists']=$this->get_details();
		$data['title']='Quiz Details';
		$this->load->blade('member.quiz_result_details', $data);
	}

	function get_details()
	{
		$quiz_id=$this->uri->segment(4);
		$user=$this->userid;

		$quiz=$this->quiz_model
		->where(array('quiz_id|='=>$quiz_id,'user_id|='=>$user))
		->join_get(array('chapter_quiz.*','qb.question','qb.options'),array('question_bank qb'=>'qb.id|chapter_quiz.qid'));

		$str='';
		//var_dump($quiz);
		if($quiz)
		{
			$i=1;
			$str.="<ul class='list-group'>";
			foreach ($quiz as $q) 
			{
				$q_plain=strip_tags($q->question,'<img>');
				$str.="<li class='list-group-item'>{$i}. {$q_plain}</li>";
				$options=explode('///',$q->options);
				$rng_opt=range('A','E');
				
				$j=0;
				foreach ($options as $opt) {
					$opt_plain=strip_tags($opt,'<img>');
					$correct=substr($opt_plain,0,2)=="@@"?true:false;
					$wrong=$q->ans==$rng_opt[$j]?true:false;
					$opt_sl=$rng_opt[$j];
					if($correct)
					{
						$correct_ans=str_replace('@@','',trim($opt_plain));
						$str.="<li class='list-option correct'>{$opt_sl}.  {$correct_ans}</li>";
					}
					else if($wrong)
					{
						$str.="<li class='list-option wrong'>{$opt_sl}.  {$opt_plain}</li>";
					}
					else
					{
						$str.="<li class='list-option'>{$opt_sl}.  {$opt_plain}</li>";
					}
					$j++;
				}
				$i++;
			}
			$str.="</ul>";
		}

		return $str;

	}

}

/* End of file quiz_result_details.php */
/* Location: ./application/controllers/member/quiz_result_details.php */