<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sample_practice extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('question_bank_model');
		$this->load->model('exam_model');
		$this->load->model('ref_text_model');
		//$this->load->model('quiz_helper');
	}
	public function index()
	{
		$data['chapter']=ref_text_model::get_text(315);
		$data['qlist']=$this->qlist();
		$data['title']='Sample Practice';
		$this->load->blade('sample_practice', $data);
	}

	function qlist()
	{
		$ques=$this->question_bank_model->get_top_chapters_question(546);
		$str='';
		if($ques)
		{
			$total_ques=count($ques);
			$sl=1;
			$comp_print_stat=0;
			$sbj_stat=0;
			$brk=10;
			$str.="<span class='page'>";
			foreach ($ques as $qstn) 
			{

				$belonging_ques_exam=$this->exam_model->get_exam_cat_by_qid($qstn->id);
				$belonging_ques_exam_str='';
				if($belonging_ques_exam)
				{
				 $belonging_ques_exam_str="(".implode(', ',$belonging_ques_exam).")";
				}
				// $icn_src=base_url().'asset/img/mark_grey.png';
				// if($is_marked)
				// {
				// 	$icn_src=base_url().'asset/img/mark.png';
				// }
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
				
				$str.="<li class='list-group-item list-ques'><span class='icn-mark' data-toggle='tooltip' title='mark for future review'></span>&nbsp;&nbsp;{$sl}.&nbsp;&nbsp;{$strip_ques}<input type='hidden' id='hdn_qid_{$sl}' value='$qstn->id'/>&nbsp;&nbsp;&nbsp;{$belonging_ques_exam_str}</li>";

				$rng=range('A','H');
				$i=0;
				$opt_original=empty($qstn->options)?'':$qstn->options;
				$ans_arr=explode('///',$opt_original);

				if(count($ans_arr)>0)
				{
					$correct_ans='';
					foreach ($ans_arr as $ans) 
					{
						$strip_ans=strip_tags($ans,"<img>");
						$correct=substr($strip_ans,0,2)=="@@"?true:false;
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
				$str.="<li class='list-group-item'><a title='Discuss about this question' data-toggle='tooltip' target='_blank' href='{$url}'></a>";
				if(!empty($qstn->hints))
				{	
					$strip_hint=strip_tags(trim($qstn->hints),'<img><i><sub><sup><a>');
					
					$str.="<span class='list-hint' id='list_hint_{$sl}'><strong>Hints:&nbsp;</strong>{$strip_hint}&nbsp;</span>";

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
		return $str;
	}

}

/* End of file sample_practice.php */
/* Location: ./application/controllers/sample_practice.php */