<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Practice_test extends Member_controller {

	function __construct()
	{
		parent::__construct();
    	
		$this->load->model('member/result_model','result');
		$this->load->model('exam_model');
		$this->load->model('question_bank_model');
		$this->load->model('manage_comprehension_model');
		$this->load->model('ref_text_model');

		// check membership expiration
    	$this->load->model('permission_model');
    // 	if($this->utype!='101' && $this->utype!='102')
    // 	{
	  	// 	if($this->permission_model->is_expired($this->userid))
	  	// 	{
	  	// 		$this->session->set_flashdata('warning', 'You basic membership is expired! please upgrade now!');
	  	// 		redirect(base_url().'public/upgrade');
	  	// 	}
  		// }
  		//end check membership expiration
	}
	public function index()
	{
		$uid=0;
		if($this->session->userdata('userid'))
		{
			$uid=$this->session->userdata('userid');
		}
		$id=$this->uri->segment(4);
		$questions=$this->exam_model->get_exam_question($id);
		$exam_name=ref_text_model::get_text($this->exam_model->find($id)->ref_id);

		$str="<ul class='list-group'>";
		$total_ques=0;
		if($questions)
		{
			$ques_arr=explode(',',$questions->ques_id);
			$total_ques=count($ques_arr);
			$sl=1;
			$comp_print_stat=0;
			$sbj_stat=0;
			foreach ($ques_arr as $ques) 
			{
				if(!empty($ques)){
				$is_marked=$this->exam_model->is_marked($uid,$ques);
				$icn_src=base_url().'asset/img/mark_grey.png';
				if($is_marked)
				{
					$icn_src=base_url().'asset/img/mark.png';
				}
				
				$qstn=$this->question_bank_model->question_by_id($ques);
				$ques_original='';
				if(!empty($qstn->question))
				{
					$ques_original=$qstn->question;
				}
				
				$strip_ques=strip_tags(trim($ques_original),"<img><sub><sup><u><i><table><thead><tbody><tr><th><td><a>");


				//print comprehension if exist
				if($qstn)
				{
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
				}
				//end print comprehension if exist
			
				$str.="<li class='list-group-item list-ques'><span class='icn-mark' data-toggle='tooltip' title='mark for future review'><img src='{$icn_src}' alt=''/></span>&nbsp;&nbsp;{$sl}.&nbsp;&nbsp;{$strip_ques}<input type='hidden' id='hdn_qid_{$sl}' value='$ques'/></li>";

				$rng=range('A','H');
				$i=0;
				$opt_original=empty($qstn->options)?'':$qstn->options;
				$ans_arr=explode('///',$opt_original);

				if(count($ans_arr)>0)
				{
					$correct_ans='';
					foreach ($ans_arr as $ans) 
					{
						$strip_ans=strip_tags($ans,"<img><sub><sup><i><u>");
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
				$url=base_url().'member/discussion/index/'.$ques;
				$str.="<li class='list-group-item'><a title='Discuss about this question' data-toggle='tooltip' target='_blank' href='{$url}'><img src='{$chat_url}' alt=''/></a>";
				if(!empty($qstn->hints))
				{	
					$strip_hint=strip_tags(trim($qstn->hints),'<p><sub><sup><i><u><img><a>');
					
					$str.="<span class='list-hint' id='list_hint_{$sl}'><strong>Hints:&nbsp;</strong>{$strip_hint}&nbsp;</span>";

				}
				$str.="</li><hr/>";

				$sl++;
				}
			}
		}
		$str.="</ul>";
		$data['total_ques']=$total_ques;
		$data["qlist"]=$str;
		$data['title']="Practice Test ({$exam_name})";
		//$data['main_content']='member/v_practice_test';
		//$this->load->view('layout/layout',$data);
		$this->load->blade('member.v_practice_test', $data);
	}

}

/* End of file practice_test.php */
/* Location: ./application/controllers/member/practice_test.php */