<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Discussion extends Member_controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('question_bank_model');
		$this->load->model('report/common_model','common');
	}

	public function index()
	{
		$data['title']='Discussion';
		$qid=$this->uri->segment(4);
		$question=$this->question_bank_model->question_by_id($qid);
		$options=$question->options;
		$opt_arr=explode('///',$options);
		$summery=$this->get_answer_summery($qid);
		$str="<ul class='list-group'>";
		$striped_ques=strip_tags($question->question,'<img>');
		$str.="<li class='list-group-item'>{$striped_ques}</li>";
		$rng=range('A','H');
		$i=0;
		$data['qid']="q_{$qid}";
		$data['id']=$qid;
		foreach ($opt_arr as $opt) 
		{
			$striped_ans=strip_tags($opt,'<img>');
			$correct=substr(trim($striped_ans),0,2)=="@@"?true:false;
			$plain_ans=str_replace('@@','',$striped_ans);
			if($correct)
			{
				$str.="<li style='color:#34B27D;' class='list-option'>{$rng[$i]}.&nbsp;&nbsp;{$plain_ans}</li>";
			}
			else
			{
				$str.="<li class='list-option'>{$rng[$i]}.&nbsp;&nbsp;{$plain_ans}</li>";
			}
			$i++;
		}

		$str.="<li class='list-hint'><strong>Hints:</strong>&nbsp;&nbsp;{$question->hints}</li>";
		$str.="<hr>";

		$correct_percent=0;
		$wrong_percent=0;
		if($summery['total']!=0)
		{
		($summery['correct']*100)/$summery['total'];
		$wrong_percent=($summery['wrong']*100)/$summery['total'];
		}
		
		//$str.="<li class='list-summery'><span style='float:left;'>Statistics About This Question:&nbsp;&nbsp;&nbsp;<strong>Correct:</strong>&nbsp;&nbsp;{$correct_percent}%</span><span style='float:right;'><strong>Wrong:</strong>&nbsp;&nbsp;{$wrong_percent}%</span> </li>";
		$str.="</ul>";

		$data['ques']=$str;
		//$data['main_content']='member/v_discussion';
		//$this->load->view('layout/layout',$data);
		$this->load->blade('member.v_discussion', $data);
	}

	function get_answer_summery($qid)
	{
		$ans_sheet=$this->common->get_answer_by_qid($qid);
		$c=0;
		$w=0;
		$ttl=0;
		if($ans_sheet)
		{
			$ttl=count($ans_sheet);
			foreach ($ans_sheet as $sheet) 
			{
				$question=$this->question_bank_model->question_by_id($sheet->question_id);
				$options=empty($question->options)?'':explode(',',$question->options);
				foreach ($options as $opt) 
				{
					$striped_ans=trim(strip_tags($opt,'<img>'));
					$correct=substr(trim($striped_ans),0,2)=="@@"?true:false;
					if($correct)
					{
						$c++;
					}
					if(!$correct)
					{
						$w++;
					}

				}
			}
		}
		$result=array('total'=>$ttl,'correct'=>$c,'wrong'=>$w);
		return $result;
	}

}

/* End of file discussion.php */
/* Location: ./application/controllers/member/discussion.php */