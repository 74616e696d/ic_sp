<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sample_exam extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('exam_model');
		$this->load->model('question_bank_model');
		$this->load->model('ref_text_model');
		$this->load->model('manage_comprehension_model');
		$this->load->helper('quiz');
	}
	public function index()
	{
		$user=0;
		if($this->session->userdata('userid'))
		{
			$user=$this->session->userdata('userid');
		}
		$chapter_id='323';
		
		$ques=$this->question_bank_model->get_chapters_question_rand($chapter_id,20);
	
		$i=1;
		$str_ques='';
		$last=0;
       if($ques)
        {
        	$last_record=end($ques);
        	$last=$last_record->id;
	        foreach($ques as $q)
	        {
		        $qs=strip_tags($q->question,'<img>');
		        $str_ques.="<li><input type='hidden' class='hdn_ques' id='hdn_ques_{$q->id}' value='{$q->id}'/>
		        <a href=''>";
		        $str_ques.="<input type='hidden' id='hdn_ques_sl{$i}'/>";
		        $str_ques.="<span id='sl' style='color:#8BC2E9;font-weight:bold;'>{$i}.</span>&nbsp;{$qs}</a></li>";
		        $i++;
	      	}
        }

        $data['ttl_ques']=count($ques);
        $data['last_ques']=$last;
        $data['user']=$user;
		$data['chapter_name']=$chapter_id;
		$data['questions']=$str_ques;
		$data['title']='';
		$this->load->blade('sample_exam', $data);
	}



	/**
	 * Getting Answers on click event on questions
	 * @return [type] [description]
	 */
	function get_ans()
	{
		$qid=$this->input->get('qid');
		$sl=$this->input->get('sl');
		$question=$this->question_bank_model->question_by_id($qid);
		$str='';
		$selected_answer_arr=array();
		// if(test_model::is_assigned($qid))
		// {
		// 	$selected_answer=test_model::is_assigned($qid);
		// 	$selected_answer_arr=explode(',',$selected_answer->ans);
		// }

		$test_name=$this->input->get('test_name');
		

		if($question)
		{
			// start passage comprehension
			if($question->has_paragraph)
			{
				$comp=$this->manage_comprehension_model->questions_comprehension($qid);
				if(!empty($comp->details))
				{
					$str.="<p><strong><u>Reading the following paragraph and answer the following question</u></strong></p>";
					$str.="{$comp->details}";
				}
			}
			//end passage comprehension
			$options=$question->options;
			$q_plain=strip_tags($question->question,'<img>');
			//$last_ques=strip_tags(end($questions),'<img>');
			
		
			$tagless_options=strip_tags($options,'<img>');
			$answers=explode('///',trim($tagless_options));
			$str.="<p class='ques'><i title='mark this question' class='flag flag-grey'></i><span>{$sl}</span>&nbsp;&nbsp;{$q_plain}</p>";
			$i=0;
			$correct_ans='';
			$last=0;
			$ans_range=range('A','H');

			foreach ($answers as $ans) 
			{
				$correct=substr(trim(strip_tags($ans,'<img>')),0,2)=="@@"?true:false;
				$ans_plain=str_replace('@@','',trim($ans));
				$cked=in_array($ans_range[$i],$selected_answer_arr)?'checked':'';
				if($correct)
				{
					$correct_ans=$ans_plain;
				}
				
				$str.="<input type='hidden' id='hdn_qid' value='{$question->id}'/>";
				$str.="<div class='radio'>";
				$str.="<label>
				<input class='ck_ans' style='margin-left:0;float:left;' type='radio' name='ck_ans' value='{$ans_plain}'>&nbsp;&nbsp;{$ans_plain}<span class='pull-left'>&nbsp;&nbsp;({$ans_range[$i]}.)&nbsp;&nbsp;</span></label>";
				$str.="</div>";
				$i++;
				
			}
			//echo $this->last_ques+"="+$qid;
			// $last_ques=$this
			// if($this->last_ques==$qid)
			// {
			// 	$last=1;
			// }
			// else
			// {
			// 	$last=0;
			// }
			//$str.="<input type='hidden' value='{$last}' id='hdn_last_ques'/>";
			$str.="</div>";
		}

		echo $str;
	}


	function show_result()
	{
		$time=$this->uri->segment(3);
		$data['time']=$time;
		$data['title']='';
		$this->load->blade('sample_exam_result', $data);
	}

	function display_result()
	{
		$obj=$this->input->post('obj');
		$result=json_decode($obj);
		$str='';
		if(count($result)>1)
		{
			$chapter_name=ref_text_model::get_text(323);
			$str.="<h4>Chapter Name : {$chapter_name}</h4>";
			$str.="<ul class='list-group'>";
			$correct_count=0;
			$wrong_count=0;
			$time_taken=0;
			$i=0;
			foreach ($result as $r) 
			{
				if($i>0)
				{
					$qid=$r->qid;
					$given=$r->sl;
					$ques=$this->question_bank_model->get_ans_options($qid);
					$correct=get_correct_index($ques->options);
					if($given==$correct)
					{
						$correct_count++;
					}
					else
					{
						$wrong_count++;
					}
				}
				else
				{
					$time_taken=$r->timeTaken;
				}
				$i++;
			}
			$time_taken=gmdate('H:i:s',$time_taken);
			$unanswered=20-($correct_count+$wrong_count);
			$str.="<li class='list-group-item'><span>Time Taken:</span>  <span style='margin-right:13px;' class='pull-right'>{$time_taken}</span></li>";
			$str.="<li class='list-group-item'><span>Total Question:</span>  <span style='margin-right:13px;' class='pull-right'>20</span></li>";
			$str.="<li class='list-group-item'><span>Total Correct:</span>  <span style='margin-right:13px;' class='pull-right'>{$correct_count}</span></li>";
			$str.="<li class='list-group-item'><span>Total Wrong:</span>  <span style='margin-right:13px;' class='pull-right'>{$wrong_count}</span></li>";
			$str.="<li class='list-group-item'><span>Not Answered:</span>  <span style='margin-right:13px;' class='pull-right'>{$unanswered}</span></li>";

			$str.="</ul>";
		}
		echo $str;
	}

}

/* End of file sample_exam.php */
/* Location: ./application/controllers/sample_exam.php */