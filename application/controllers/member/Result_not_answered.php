<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Result_not_answered extends Member_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('answer_summery_model');
		$this->load->model('answer_sheet_model');
		$this->load->model('exam_model');
		$this->load->model('question_bank_model');
		$this->load->model('ref_text_model');
	}
	public function index()
	{
		$data['list']=$this->result_list();
		$data['title']='Unanswered Question List';
		$this->load->blade('member.result_not_answered', $data);
	}


	function result_list()
	{
		$track_id=$this->uri->segment(4);
		$track_arr=explode('_',$track_id);
		$exam_id=$track_arr[1];
		$user=$track_arr[2];
		$answered=array();
		$ques_data=$this->exam_model->get_exam_question($exam_id);
		$str='';
		if($ques_data)
		{
			$ques_str=$ques_data->ques_id;
			$ques_arr=explode(',',$ques_str);

			$sheet=$this->answer_sheet_model
			->where(array('test_track_id|='=>$track_id,'user_id|='=>$user))
			->join_get(array('answer_sheet.*','qb.question','qb.options'),array('question_bank qb'=>'qb.id|answer_sheet.question_id'));

			if($sheet)
			{
				foreach ($sheet as $s) 
				{
					array_push($answered,$s->question_id);
				}
			}

			$un_ans=array_diff($ques_arr,$answered);
			$questions=$this->question_bank_model->get_questions_in($un_ans);
			if($questions)
			{
				$sl=1;
				$str.="<ul class='list-group'>";
				foreach ($questions as $q) {
					$ques=$q->question;
					$ques_plain=strip_tags($ques,"<img><u><u><sub><sup><a>");
					$str.="<li class='list-group-item'>{$sl}. {$ques_plain}</li>";
					$j=0;
					$options=explode('///',$q->options);
					$rng_opt=range('A','E');

					foreach ($options as $opt) 
					{
						$opt_plain=strip_tags($opt,'<img><sub><sup><i><a>');
						$correct=substr($opt_plain,0,2)=="@@"?true:false;
						//$wrong=$q->answer==$rng_opt[$j]?true:false;
						$opt_sl=$rng_opt[$j];
						if($correct)
						{
							$correct_ans=str_replace('@@','',trim($opt_plain));
							$str.="<li class='list-option correct'>{$opt_sl}.  {$correct_ans}</li>";
						}
						else
						{
							$str.="<li class='list-option'>{$opt_sl}.  {$opt_plain}</li>";
						}
						$j++;
					}

					$sl++;
				}
				$str.="</ul>";
			}


		}
		return $str;

	}
}

/* End of file result_not_answered.php */
/* Location: ./application/controllers/member/result_not_answered.php */