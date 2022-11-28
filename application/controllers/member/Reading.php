<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reading extends Member_controller {

	function __construct()
	{
		parent::__construct();

		//$this->load->library('session');
		$this->load->model('Exam/reading_meta_model','obj');
		$this->load->model('question_bank_model');
		$this->load->model('manage_comprehension_model');
		$this->load->model('chapter_details_model');
		$this->load->model('exam_model');
		$this->load->model('member/mistake_model','mistake');
		$this->load->model('ref_text_model');
		//$this->output->enable_profiler(true);
		
	}
	public function index()
	{
		$uid=$this->userid;
		$chapter_id=$this->uri->segment(4);

		$questions=$this->question_bank_model->get_chapters_question_all($chapter_id);
		$str="<ul class='list-group'>";
		$total_ques=0;
		if($questions)
		{
			$total_ques=count($questions);
			$sl=1;
			$comp_print_stat=0;
			$sbj_stat=0;
			$brk=10;
			$str.="<span class='page'>";
			foreach ($questions as $qstn) 
			{
				$belonging_ques_exam=$this->exam_model->get_exam_cat_by_qid($qstn->id);
				//$attempt_count=$this->obj->get_model_test_attempt($uid,$qstn->id);
				//$correct_attempt_count=$this->obj->get_model_test_correct_attempt($uid,$qstn->id);
				$belonging_ques_exam_str='';
				if($belonging_ques_exam)
				{
				 $belonging_ques_exam_str="(".implode(', ',$belonging_ques_exam).")";
				}
				$is_marked=$this->exam_model->is_marked($uid,$qstn->id);
				$icn_src=base_url().'asset/img/mark_grey.png';
				if($is_marked)
				{
					$icn_src=base_url().'asset/img/mark.png';
				}
				$belonging_ques_exam=$this->exam_model->get_exam_cat_by_qid($qstn->id);
				$belonging_ques_exam_str='';
				if($belonging_ques_exam)
				{
				 $belonging_ques_exam_str=implode(', ',$belonging_ques_exam);
				}
				//echo $belonging_ques_exam_str;
				$ques_original='';
				if(!empty($qstn->question))
				{
					$ques_original=$qstn->question;
				}
				
				$strip_ques=strip_tags(trim($ques_original),"<img><u><i><sub><sup>");

				//print comprehension if exist
				if($qstn->subject!=$sbj_stat)
				{
					$comp_print_stat=0;
					$sbj_stat=$qstn->subject;
				}
				if($qstn->has_paragraph)
				{
					if($comp_print_stat==0)
					{
						$comp=$this->manage_comprehension_model->questions_comprehension($qstn->id);
						$comp_meta=$this->manage_comprehension_model->get_comp_qid($qstn->id);
						$ttl_comp=count($comp_meta);
						$range_to=($sl+$ttl_comp)-1;
						$comp_range="{$sl} To {$range_to}";
						if($comp)
						{
							if(!empty($comp->details))
							{ 
								$comp_details=$comp->details;
								$str.="<li class='list-group-item list-passage'><strong>Read the following Paragraph and answer the following questions ({$comp_range})</strong>{$comp_details}</li>";
								$comp_print_stat=1;	
							}
						}
					}
				}
				//end print comprehension if exist
				
				$str.="<li class='list-group-item list-ques'>";
				$str.="<span class='icn-mark' data-toggle='tooltip' title='mark for future review'><img src='{$icn_src}' alt=''/></span>";
				$str.="&nbsp;&nbsp;{$sl}.&nbsp;&nbsp;{$strip_ques}<input type='hidden' id='hdn_qid_{$sl}' value='$qstn->id'/><br/>";
				$str.="<p class='qmeta'><span class='label label-info'>{$belonging_ques_exam_str}</span>";
				//$str.="<span class='label label-info'>Total Attempt: {$attempt_count}</span>";
				//$str.="<span class='label label-info'>Total Correct: {$correct_attempt_count}</span></p>";
				$str.="</li>";

				$rng=range('A','H');
				$i=0;
				$opt_original=empty($qstn->options)?'':$qstn->options;
				$ans_arr=explode('///',$opt_original);

				if(count($ans_arr)>0)
				{
					$correct_ans='';
					foreach ($ans_arr as $ans) 
					{
						$strip_ans=strip_tags(trim($ans),"<img><sub><sup><u><b><i>");
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

				$chat_url=base_url().'asset/img/chat.png';
				$url=base_url().'member/discussion/index/'.$qstn->id;
				$str.="<li class='list-group-item'><a title='Discuss about this question' data-toggle='tooltip' target='_blank' href='{$url}'><img src='{$chat_url}' alt=''/></a>";
				if(!empty($qstn->hints))
				{	
					$strip_hint=strip_tags(trim($qstn->hints),'<p><img><i><sub><sup><a>');
					
					$str.="<div class='list-hint' id='list_hint_{$sl}'><strong>Hints:&nbsp;</strong>{$strip_hint}";
					$last_updated_at=$qstn->updated_at!='0000-00-00 00:00:00'?date('d F, Y',strtotime($qstn->updated_at)):date('d F, Y',strtotime($qstn->created_at));
					if($qstn->is_changeable){
					$str.="<p style='color:#444;font-size:12px;'>Note : This answer might change. We always try to keep it updated. If you think it's still not changed, please contact us.</p>";
					$str.="<p style='color:#444;font-size:12px;'>Last Updated On : {$last_updated_at}</p>";
					}
					$str.="</div>";

				}
				$str.="</li><br/>";
				
				if($sl==$brk)
				{

					$str.="</span><span class='page'>";
					$brk=$brk+10;
				}
				$sl++;
			}

			$str.="</span>";
		}
		$str.="</ul>";

		$chapter_details=$this->chapter_details_model->get_details_by_ref($chapter_id);
		$hot_tips='';
		if($chapter_details)
		{
			if($chapter_details->hot_tips)
			{
				$hot_tips.="<p><strong><u>Hot Tips</u></strong></p>";
				$hot_tips.=$chapter_details->hot_tips;
			}
		}

		if($total_ques>0)
		{
			$this->add_chapter_meta($chapter_id);
		}

		//$frequent_mistake=$this->requent_mistake($chapter_id);
		//$data['fmistake']=$frequent_mistake;
		$data['tips']=$hot_tips;
		$data['ttl_ques']=$total_ques;
		$data['qlist']=$str;
		$data['chapter_id']=$chapter_id;
		$data['chapter_text']=ref_text_model::get_text($chapter_id);
		$data['title']="Read &amp; Practice";
		//$data['main_content']='member/v_reading';
		//$this->load->view('layout/layout', $data);
		$this->load->blade('member.v_reading', $data);
	}

	function add_chapter_meta($chapter)
	{
		$user=0;
		if($this->session->userdata('userid'))
		{
			$user=$this->session->userdata('userid');
		}
		if(!$this->obj->chapter_exists($user,$chapter))
		{
			$data=array('user_id'=>$user,
				'chapter_id'=>$chapter,
				'read_date'=>date('Y-m-d H:i:s'));
			$this->obj->add($data);
		}
	}

	function add_to_mistake()
	{
		$qid=$this->input->post('qid');
		
		$data=array('user_id'=>$this->userid,
			'qid'=>$qid,
			'last_attempt_date'=>date('Y-m-d H:i:s'));

		if($this->userid!=0)
		{
			if(!$this->mistake->exist($this->userid,$qid))
			{
				$this->mistake->add($data);
			}
			else
			{
				$data_update=array('last_attempt_date'=>date('Y-m-d H:i:s'));
				$this->mistake->update($this->userid,$qid,$data_update);
			}
		}
	}

	function requent_mistake($chapter)
	{
		$question=$this->mistake->get_frequent_mistake($chapter);
		$str="";
		if($question)
		{
			$str.="<h4>Frequently mistaken question</h4>";
			$str.="<ul class='list-group' style='border:1px solid #FBD3D3'>";
			$total_ques=0;
			if($question)
			{
				$total_ques=count($question);
				$sl=1;
				$comp_print_stat=0;
				$sbj_stat=0;
				$brk=10;
				$str.="<span class='page'>";
				foreach ($question as $qstn) 
				{

					$ques_original='';
					if(!empty($qstn->question))
					{
						$ques_original=$qstn->question;
					}
					
					$strip_ques=strip_tags(trim($ques_original),"<img><u><i><sub><sup>");
					$str.="<li class='list-group-item list-ques' style='padding-left:10px;'><span class='label label-primary'>Total Mistake:&nbsp;&nbsp;{$qstn->total}</span><br/>{$sl}. {$strip_ques}</li>";
					if($qstn->has_paragraph)
					{
						if($comp_print_stat==0)
						{
							$comp=$this->manage_comprehension_model->questions_comprehension($qstn->id);
							$comp_meta=$this->manage_comprehension_model->get_comp_qid($qstn->id);
							$ttl_comp=count($comp_meta);
							$range_to=($sl+$ttl_comp)-1;
							$comp_range="{$sl} To {$range_to}";
							if($comp)
							{
								if(!empty($comp->details))
								{ 
									$comp_details=$comp->details;
									$str.="<li class='list-group-item list-passage'><strong>Read the following Paragraph and answer the following questions ({$comp_range})</strong>{$comp_details}</li>";
									$comp_print_stat=1;	
								}
							}
						}
					}
					//end print comprehension if exist
					
					$rng=range('A','H');
					$i=0;
					$opt_original=empty($qstn->options)?'':$qstn->options;
					$ans_arr=explode('///',$opt_original);

					if(count($ans_arr)>0)
					{
						$correct_ans='';
						foreach ($ans_arr as $ans) 
						{
							$strip_ans=strip_tags(trim($ans),"<img><sub><sup><u><b><i>");
							$correct=substr(trim($strip_ans),0,2)=="@@"?true:false;
							$ans_plain=str_replace('@@','',trim($strip_ans));

							if($correct)
							{
								$correct_ans=$rng[$i];
							}
							$correct_style='';
							if($correct_ans==$rng[$i])
							{
								$correct_style="style='color:green;'";
							}

							$radio="<input type='radio' class='rd_{$sl}_{$i}' name='rd_{$sl}' />";
							
							$str.="<li class='list-option' {$correct_style}>&nbsp;(<span>{$rng[$i]}</span>)&nbsp;&nbsp;{$ans_plain}</li>";	
							$i++;
						}
						$str.="<li class='list-hidden'><input type='hidden' id='hdn_correct_ans_{$sl}' value='{$correct_ans}'/></li>";
					}

					$chat_url=base_url().'asset/img/chat.png';
					$url=base_url().'member/discussion/index/'.$qstn->id;
					$str.="<li class='list-group-item'><a title='Discuss about this question' data-toggle='tooltip' target='_blank' href='{$url}'><img src='{$chat_url}' alt=''/></a>";
					
					$str.="</li><br/>";
					
					if($sl==$brk)
					{

						$str.="</span><span class='page'>";
						$brk=$brk+10;
					}
					$sl++;
				}

				$str.="</span>";
			}
			$str.="</ul>";
		}

		return $str;
	}

}

/* End of file reading.php */
/* Location: ./application/controllers/member/reading.php */