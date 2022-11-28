<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use Carbon\Carbon;
class Model_quiz extends Member_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('permission_model');
		$this->load->model('Exam/test_model','obj');
		$this->load->model('Exam/ans_review_model','review');
		$this->load->model('question_bank_model');
		$this->load->model('exam_model');
		$this->load->model('user_model');
		$this->load->model('ref_text_model');
		$this->load->model('permission_model');
		$this->load->model('manage_comprehension_model');
		$this->load->model('model_quiz_model');
		$this->load->model('model_quiz_summery_model');
		$this->load->model('member/mistake_model','mistake');
		$this->load->model('model_test_model');
		$this->load->model('ask_expert_model');

		/*if($this->utype!='101' && $this->utype!='102' && $this->utype!='105')
		{
			if(!$this->membership_model->is_paid($this->userid))
			{
				redirect(base_url().'public/upgrade');
			}
		}*/
	}

	public function index()
	{
		$user=0;
		if($this->session->userdata('userid'))
		{
			$user=$this->session->userdata('userid');
		}
		$test_id=$this->uri->segment(4);
		$test_meta=$this->model_test_model->find($test_id);

		$ques=$this->model_test_model->get_test_ques($test_id);
	
		$i=1;
		$str_ques='';
		$last=0;
		
       if($ques)
        {
        	
        	$last_record=end($ques);
        	$last=$last_record->id;
	        foreach($ques as $q)
	        {
		        $qs=strip_tags($q->question,'<u><b><strong><i><sub><sup><img>');
		        $str_ques.="<li><input type='hidden' class='hdn_ques' id='hdn_ques_{$q->id}' value='{$q->id}'/>
		        <a href=''>";
		        $str_ques.="<input type='hidden' id='hdn_ques_sl{$i}'/>";
		        $str_ques.="<span id='sl' style='color:#8BC2E9;font-weight:bold;'>{$i}.</span>&nbsp;{$qs}</a></li>";
		        $i++;
	      	}
        }
        $data['test_meta']=$test_meta;
        $data['ttl_ques']=count($ques);
        $data['last_ques']=$last;
        $data['user']=$user;
		$data['chapter_name']=$test_meta->id;
		$data['questions']=$str_ques;

		$data['title']='Model Quiz';
		$this->load->blade('member.model_quiz', $data);
	}

	function result()
	{
		$quiz_id=$this->uri->segment(4);
		$user=$this->uri->segment(5);
			$result=array();
		$quiz_id_arr=explode('_',$quiz_id);


		$model_meta=$this->model_test_model->find($quiz_id_arr[1]);
		$quiz_summery=$this->model_quiz_summery_model->find_by_quz_id($quiz_id,$user);
		$result=array();
		if($quiz_summery)
		{
			$dt=date_create($quiz_summery->quiz_date);
			$dtf=date_format($dt,'d F, Y');
			$top_score=$this->model_quiz_summery_model->user_top_correct($this->userid,$quiz_summery->test_id);
			$test_top=$this->model_quiz_summery_model->top_score($quiz_summery->test_id);
			$time=gmdate('H:i:s',$quiz_summery->time_taken);
			$score=$quiz_summery->total_correct-($quiz_summery->total_wrong*.50);

			$rating=($score/$model_meta->total_ques)*100;
			//var_dump($rating);
			$rating=number_format($rating,2);

			$result=array('qid'=>$quiz_summery->quiz_id,
				'test_name'=>ref_text_model::get_text($quiz_summery->test_id),
				'test_id'=>$quiz_summery->test_id,
				'dt'=>$dtf,
				'total_ques'=>$model_meta->total_ques,
				'time'=>$time,
				'correct'=>$quiz_summery->total_correct,
				'wrong'=>$quiz_summery->total_wrong,
				'score'=>$score,
				'user_top_score'=>$top_score,
				'test_top'=>$test_top,
				'rating'=>$rating,
				'not_answered'=>20-($quiz_summery->total_correct+$quiz_summery->total_wrong));
		}
		$data['model_quiz_id']=$quiz_summery->quiz_id;
		$data['quiz_id']=explode('_',$quiz_summery->quiz_id);
		$data['result']=$result;
		$data['test_meta']=$model_meta;
		$data['user']=$this->userid;
		$data['utype']=$this->utype;
		$data['title']='Model Test Score';
		$this->load->blade('member.model_quiz_result', $data);
	}


	function finish_exam()
	{
		$user=0;
		if($this->session->userdata('userid'))
	    {
		 	$user=$this->session->userdata('userid');
		}
		$dt=json_decode($this->input->post('obj'));
		
		
		$chapter_name=0;
		$time_taken=0;
		$quiz_id='';
		$correct_count=0;
		$wrong_count=0;
		if(count($dt)>2)
		{
			$i=1;
			foreach ($dt as $d) 
			{
				if($i==1)
				{
					$chapter_name=$d->test_name;
					$time_taken=$d->timeTaken;
					$quiz_id=$this->generate_test_id($chapter_name,$user);
				}
				else
				{
					$correct_ans=$this->get_correct_answer($d->qid);
					if($d->sl==$correct_ans)
					{
						$correct_count++;
					}
					else
					{
						$wrong_count++;
						if(!$this->mistake->exist('qid',$d->qid))
						{
							$data_wrong=array('user_id'=>$user,
								'qid'=>$d->qid,
								'last_attempt_date'=>Carbon::now()->toDateTimeString()
								);
							$this->mistake->add($data_wrong);
						}
						else
						{
							$data_wrong=array('last_attempt_date'=>Carbon::now()->toDateTimeString());
							$this->mistake->update($user,$d->qid,$data_wrong);
						}
					}
					$data=array('user_id'=>$user,
					'test_id'=>$chapter_name,
					'qid'=>$d->qid,
					'ans'=>$d->sl,
					'correct_ans'=>$correct_ans,
					'quiz_id'=>$quiz_id);
					$this->model_quiz_model->create($data);
				}

				$i++;
			}

			$data_summery=array('user_id'=>$user,
				'test_id'=>$chapter_name,
				'quiz_id'=>$quiz_id,
				'quiz_date'=>Carbon::now()->toDateTimeString(),
				'time_taken'=>$time_taken,
				'total_correct'=>$correct_count,
				'total_wrong'=>$wrong_count);

			$this->model_quiz_summery_model->create($data_summery);
			echo base_url()."member/model_quiz/result/{$quiz_id}/$user";
		}
	}

		/**
	 * Generating Test Id Of an exam
	 * @param  [type] $exam_id [description]
	 * @param  [type] $user    [description]
	 * @return [type] $test_id         [description]
	 */
	function generate_test_id($exam_id,$user)
	{
		$chapter_id='';
		$dt=Carbon::now();
		$stamp=$dt->timestamp;
		$chapter_id=$stamp.'_'.$exam_id.'_'.$user;
		return $chapter_id;
	}

		/**
	 * Getting Correct Answer
	 * @param  [type] $qid [description]
	 * @return [type]      [description]
	 */
	function get_correct_answer($qid)
	{
		$question=$this->question_bank_model->get_ans_options($qid);
		$options=explode('///',$question->options);
		$ans_range=range('A','H');
		$i=0;
		foreach ($options as $ans) {
			if($ans!=NULL)
			{
				$correct=substr(trim(strip_tags($ans,'<u><i><b><strong><sub><sup><img>')),0,2)=="@@"?$ans_range[$i]:null;
				if($correct!=null)
				{
					return $correct;
				}
				
			}
			$i++;
		}
	}


	/**
	 * function to ask an expert to review question
	 * @return [type] [description]
	 */
	function ask_expert()
	{
		$user=$this->userid;
		$test_id=$this->input->post('quiz_id');
		$ask_date=date('Y-m-d H:i:s');
		$status=0;
		$data=array('test_id'=>$test_id,
			'user_id'=>$user,
			'ask_date'=>$ask_date,
			'status'=>$status
			);
		if($this->ask_expert_model->is_asked($test_id,$user))
		{
			echo "asked";
		}
		else
		{
			$id=$this->ask_expert_model->create($data);
			echo "ok";
		}
		
	}

}

/* End of file model_quiz.php */
/* Location: ./application/controllers/member/model_quiz.php */