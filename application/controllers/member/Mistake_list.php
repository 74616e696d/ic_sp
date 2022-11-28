<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mistake_list extends Member_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('ref_text_model');
		$this->load->model('exam_model');
		$this->load->model('member/mistake_model','mistake');
		//$this->output->enable_profiler(true);
	}
	public function index()
	{
		$uid=0;
		if($this->session->userdata('userid'))
		{
			$uid=$this->session->userdata('userid');
		}

		$where=array('practice_mistake.user_id|='=>$uid);

		$ques_flds=array('qb.id','qb.question','qb.options','qb.subject','qb.chapter','practice_mistake.last_attempt_date');
		$joined=array('question_bank qb'=>'qb.id|practice_mistake.qid');
		//$questions=$this->mistake->where($where)->join_get($ques_flds,$joined);

		$questions=$this->mistake->get_mistake_list($uid);

		$str="<ul class='list-group'>";
		$total_ques=0;
		if($questions)
		{
			$total_ques=count($questions);
			$sl=1;
			//var_dump($questions);
			foreach ($questions as $qstn) 
			{
				$belonging_ques_exam=$this->exam_model->get_exam_cat_by_qid($qstn->id);
				$belonging_ques_exam_str='';
				if($belonging_ques_exam)
				{
				 $belonging_ques_exam_str="(".implode(', ',$belonging_ques_exam).")";
				}

				//echo $belonging_ques_exam_str;
				$ques_original='';
				if(!empty($qstn->question))
				{
					$ques_original=$qstn->question;
				}
				
				$strip_ques=strip_tags(trim($ques_original),"<img>");
				$mdt=date_create($qstn->last_attempt_date);
				$mistake_date=date_format($mdt,'d F, Y');

				$str.="<li class='list-group-item'>&nbsp;&nbsp;<i onClick='delete_ques({$qstn->id})' title='delete' style='cursor:pointer;' class='fa fa-trash-o'></i>&nbsp;{$sl}.&nbsp;&nbsp;{$strip_ques}<input type='hidden' id='hdn_qid_{$sl}' value='{$qstn->id}'/>
					&nbsp;&nbsp;&nbsp;&nbsp;<span style='font-size:12px;font-weight:normal;'>{$belonging_ques_exam_str}</span>&nbsp;&nbsp;<span data-toggle='tooltip' title='Last mistake date' style='font-size:12px;font-weight:normal;'>({$mistake_date})</span></li>";

				$rng=range('A','H');
				$i=0;
				$opt_original=empty($qstn->options)?'':$qstn->options;
				$ans_arr=explode('///',$opt_original);

				if(count($ans_arr)>0)
				{
					$correct_ans='';
					foreach ($ans_arr as $ans) 
					{
						$strip_ans=strip_tags(trim($ans),"<img>");
						$correct=substr(trim($strip_ans),0,2)=="@@"?true:false;
						$ans_plain=str_replace('@@','',trim($strip_ans));

						if($correct)
						{
							$correct_ans=$rng[$i];
						}

						$radio="<input type='radio' class='rd_{$sl}_{$i}' name='rd_{$sl}' />";
						
						$str.="<li class='list-option'>$radio&nbsp;(<span>{$rng[$i]}</span>)&nbsp;&nbsp;{$ans_plain}</li>";	
						$i++;
					}
					$str.="<li class='list-hidden'><input type='hidden' id='hdn_correct_ans_{$sl}' value='{$correct_ans}'/></li>";
				}
				//var_dump($qstn->hints);
				if(!empty($qstn->hints))
				{	
					$strip_hint=strip_tags(trim($qstn->hints),'<img>');
					$url=base_url().'member/discussion/index/'.$qstn->id;
					$str.="<li class='list-hint' id='list_hint_{$sl}'><strong>Hints:&nbsp;</strong>{$strip_hint}&nbsp;<a target='_blank' href='{$url}'><i class='fa fa-search-plus fa-lg'></i></a></li>";

				}
				$sl++;
			}
		}
		$str.="</ul>";

		$data['cats']=$this->ref_text_model->get_ref_text_by_group(2);

		$data['ttl_ques']=$total_ques;
		$data['qlist']=$str;
		//$data['chapter_text']=ref_text_model::get_text($chapter_id);


		$data['title']='Mistake List';
		// $data['main_content']='member/mistake_list';
		// $this->load->view('layout/layout', $data);
		$this->load->blade('member.mistake_list', $data);
	}


	function clearAll()
	{
		$uid=$this->userid;
		$this->mistake->delete_user_mistake($uid);
		$this->session->flashdata('success','You have successfully cleared all the mistake list !!');
		redirect(base_url()."member/mistake_list");
	}
	function remove()
	{
		$qid=$this->input->post('qid');
		//var_dump($qid);
		$this->mistake->delete_mistake($this->userid,$qid);
		echo "success";
	}

}

/* End of file mistake_list.php */
/* Location: ./application/controllers/member/mistake_list.php */