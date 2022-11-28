<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_quiz_progress extends Member_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('ref_text_model');
		$this->load->model('model_test_model');
		$this->load->model('model_quiz_model');
		$this->load->model('model_quiz_summery_model');
		$this->load->model('model_test_question_model','test_ques');
		$this->load->model('question_bank_model');
		$this->load->model('expert_reply_model');
	}
	function index()
	{
		$quiz=$this->model_quiz_summery_model->find_user_quiz($this->userid);
		$str=$this->model_quiz_progress_str($quiz);
		$data['quiz']=$str;
		$data['title']='Model Test Result';
		$this->load->blade('member.model_quiz_progress', $data);
	}

	/**
	 * display model quiz progress string
	 * @param  object $quiz
	 * @return string      
	 */
	function model_quiz_progress_str($quiz)
	{
		$str="";
		if($quiz)
		{
			foreach($quiz as $q)
			{
				$model_test_name=model_test_model::get_text($q->test_id);
				$your_top=$this->model_quiz_summery_model->user_top_correct($this->userid,$q->test_id);
				$top_score=$this->model_quiz_summery_model->top_score($q->test_id);
				$str.="<tr>";
				$str.="<td>{$model_test_name}</td>";
				$dt=date_create($q->quiz_date);$dtf=date_format($dt,'d F, Y H:i A');
				$str.="<td>{$dtf}</td>";
				$str.="<td>{$q->total_correct}</td>";
				 $qid=$q->quiz_id; $splited=!empty($qid)?explode('_', $qid):'0'; $time=$splited[0];
				$str.="<td>";
				$str.="<a data-toggle='tooltip' title='View Wrong List' class='btn btn-danger' href=''>";
				$str.="<i class='fa fa-list'></i>&nbsp;&nbsp;{$q->total_wrong}</a>";
				$str.="</td>";

				$tm=gmdate('H:i:s',$q->time_taken); 
				$str.="<td>{$tm}</td>";
				$score=$q->total_correct-(.25*$q->total_wrong);
				$str.="<td><span title='Your score in this test' data-toggle='tooltip' class='btn btn-info'>{$score}</span></td>";
				$str.="<td>{$your_top}</td>";
				$str.="<td>{$top_score}</td>";
				$str.="<td><a class='btn btn-info' href='".base_url()."member/model_quiz_progress/show/{$q->quiz_id}''>";
				$str.="<i class='fa fa-eye'></i> View All</a></td>";
				$str.="</tr>";
			}
		}
		return $str;
	}

	function show()
	{
		$test_id=$this->uri->segment(4);
		$time='';
		$quiz_summery=$this->model_quiz_summery_model->get_quiz($test_id);
		$test_questions=$this->model_quiz_model->get_full_answer_sheet($test_id,$quiz_summery->test_id);
		// var_dump($test_questions['answer_sheet']);die();
		$str_ans="<ul class='list-group'>";
		$sl=1;
		if($test_questions['answer_sheet'])
		{
			$questions=$this->question_bank_model->get_questions_in($test_questions['qid']);
			$indx=0;
			foreach ($questions as $question) 
			{
				if(!empty($test_questions['answer_sheet'][$indx]['ans']))
				{
					// $question=$this->question_bank_model->question_by_id($user_ans->qid);
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
						$given=$test_questions['answer_sheet'][$indx]['ans']==$rng_ques[$i]?true:false;

						if($given && $correct)
						{
							$str_ans.="<li class='list-option correct'><input checked disabled type='radio' />  {$rng_ques[$i]}.&nbsp;{$ans_plain}</li>";
						}
						else if($given && !$correct)
						{
							$str_ans.="<li class='list-option wrong'><input checked disabled type='radio' />  {$rng_ques[$i]}.&nbsp;{$ans_plain}</li>";
						}
						else if(!$given && $correct)
						{
							$str_ans.="<li class='list-option correct'><input disabled type='radio' />  {$rng_ques[$i]}.&nbsp;{$ans_plain}</li>";
						}
						else
						{
							$str_ans.="<li class='list-option'><input disabled type='radio' />  {$rng_ques[$i]}.&nbsp;{$ans_plain}</li>";
						}
						$i++;
					}
					if(!empty($question->hints))
					{	
						$strip_hint=strip_tags($question->hints,'<img><p><sup><sub><i><u>');
						$str_ans.="<li class='list-group-item list-hint'><strong>Explanation:&nbsp;</strong>{$strip_hint}</li>";
					}

					// start display review form
					$ask_text=expert_reply_model::get_text($quiz_summery->quiz_id,$question->id);
					if(!empty($ask_text)){
						$str_ans.="<li class='list-group-item list-hint'><strong>Expert Opinion:</strong>&nbsp;&nbsp;&nbsp; {$ask_text}</li>";
					}
					if($this->utype=='101' || $this->utype=='102')
					{
						$str_ans.="<li class='list-group list-hint'>";
						$str_ans.="<textarea style='width:97%;margin-bottom:5px;display:block;' class='txtReview'>{$ask_text}</textarea>";
						$str_ans.="<button data-qid='{$question->id}' data-ask='{$quiz_summery->quiz_id}' class='btn btn-info btn-xs btnReview'>save</button>";
						$str_ans.="</li>";
					}
					//end display review form

					$str_ans.="<br/>";
				}
				else
				{
					// $question=$this->question_bank_model->question_by_id($ans->qid);
					$stripped_ques=strip_tags(empty($question->question)?'':$question->question);
					$str_ans.="<li class='list-group-item' style='border:1px solid #FAD160;'>{$sl}.&nbsp;&nbsp;{$stripped_ques}</li>";
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
						else
						{
							$str_ans.="<li class='list-option'>{$rng_ques[$i]}.&nbsp;{$ans_plain}</li>";
						}
						$i++;
					}
					if(!empty($question->hints))
					{	
						$strip_hint=strip_tags($question->hints,'<img><p><sup><sub><i><u>');
						$str_ans.="<li class='list-group-item list-hint'><strong>Explanation:&nbsp;</strong>{$strip_hint}</li>";
					}

					// start display review form
					$ask_text=expert_reply_model::get_text($quiz_summery->quiz_id,$question->id);
					if(!empty($ask_text)){
						$str_ans.="<li class='list-group-item list-hint'><strong>Expert Opinion:</strong>&nbsp;&nbsp;&nbsp; {$ask_text}</li>";
					}
					
					if($this->utype=='101' || $this->utype=='102')
					{
						$str_ans.="<li class='list-group list-hint'>";
						$str_ans.="<textarea style='width:95%;margin-bottom:5px;' class='txtReview'>{$ask_text}</textarea><br/>";
						$str_ans.="<button data-qid='{$question->id}' data-ask='{$quiz_summery->quiz_id}' class='btn btn-info btn-xs btnReview'>save</button>";
						$str_ans.="</li>";
					}
					//end display review form
					$str_ans.="<br/>";
				}

				$sl++;
				$indx++;
			}
		}
		$str_ans.="</ul>";
		$data['test_id']=$test_id;
		$data['quiz_summery']=$quiz_summery;
		$data['list']=$str_ans;
		$data['utype']=$this->utype;
		$data['title']="Model Test Overview";
		$this->load->blade('member.model_quiz_overview', $data);
	}

	/**
	 * add expert review
	 */
	function add_expert_review()
	{
		$qid=$this->input->post('qid');
		$ask_id=$this->input->post('ask_id');
		$details=$this->input->post('details');
		if($this->expert_reply_model->check($ask_id,$qid))
		{
			$data=['details'=>$details];
			$this->expert_reply_model->modify($ask_id,$qid,$data);
			echo "Successfully updated";
		}
		else
		{
			$data=['ask_id'=>$ask_id,'qid'=>$qid,'details'=>$details,'replay_by'=>$this->userid];
			$this->expert_reply_model->create($data);
			echo "Successfully replied !";
		}
	}

	function add_expert_review_summery()
	{
		$id=$this->input->post('summery_id');
		$review=$this->input->post('review');
		$this->model_quiz_summery_model->update($id,['expert_review'=>$review]);
		echo '1';
	}

}

/* End of file model_quiz_progress.php */
/* Location: ./application/controllers/admin/model_quiz_progress.php */