<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subject_quiz_result_details extends Member_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('subject_quiz_model');
		$this->load->model('subject_quiz_summery_model');
		$this->load->model('ref_text_model');
	}
	public function index()
	{
		$track_id=$this->uri->segment(4);
		$track_arr=explode('_',$track_id);

		$subject_name=ref_text_model::get_text($track_arr[1]);
		$result=$this->subject_quiz_model->where(array('user_id|='=>$track_arr[2],'subject_id|='=>$track_arr[1]))->row();
		$details=$this->get_details();
		$data['details']=$details;
		$data['subject_name']=$subject_name;
		$data['title']='Subject Quiz Result Details';
		$this->load->blade('member.subject_quiz_details', $data);
	}


	function get_details()
	{
		$quiz_id=$this->uri->segment(4);
		$user=$this->userid;

		$quiz=$this->subject_quiz_model
		->where(array('quiz_id|='=>$quiz_id,'user_id|='=>$user))
		->join_get(array('subject_quiz.*','qb.question','qb.options'),array('question_bank qb'=>'qb.id|subject_quiz.qid'));

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

/* End of file subject_quiz_result_details.php */
/* Location: ./application/controllers/member/subject_quiz_result_details.php */