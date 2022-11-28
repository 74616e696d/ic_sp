<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use Carbon\Carbon;
class Chapter_quiz extends Member_controller {
	var $temp_ans=array();
	function __construct()
	{
		parent::__construct();
		$this->load->model('Exam/test_model','obj');
		$this->load->model('Exam/ans_review_model','review');
		$this->load->model('question_bank_model');
		$this->load->model('exam_model');
		$this->load->model('user_model');
		$this->load->model('ref_text_model');
		$this->load->model('permission_model');
		$this->load->model('manage_comprehension_model');
		$this->load->model('quiz_model');
		$this->load->model('quiz_summery_model');
		$this->load->model('member/mistake_model','mistake');
		if($this->session->userdata('utype')==2)
		{
			if($this->permission_model->basic_expired($this->session->userdata('userid')))
			{
				redirect(base_url()."member/account_setting/choosen_cat_view");
			}
		}
	}
	public function index()
	{
		$user=0;
		if($this->session->userdata('userid'))
		{
			$user=$this->session->userdata('userid');
		}
		$chapter_id=$this->uri->segment(4);
		
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
		$this->load->blade('member.chapter_quiz', $data);
	}


		/**
	 * Getting All Questions
	 */
	function all_questions()
	{
		$user=0;
		if($this->session->userdata('userid'))
		{
			$user=$this->session->userdata('userid');
		}

		$questions=json_decode($this->input->post('qid'));

		$str_ques='';
		$i=1;
		if(count($questions)>0)
		{
			foreach ($questions as $ques) 
			{
				$qtext=question_bank_model::ques_text($ques);
				$q=strip_tags($qtext,'<img>');
				
		        $str_ques.="<li><input type='hidden' class='hdn_ques' id='hdn_ques_{$ques}' value='{$ques}'/>
		        <a href=''>";
		        $str_ques.="<input type='hidden' id='hdn_ques_sl{$i}'/>";
		        $str_ques.="<span id='sl' style='color:#8BC2E9;font-weight:bold;'>{$i}.</span>&nbsp;{$q}</a></li>";
		        $i++;
			}
		}

		echo $str_ques;
	}


		/**
	 * Geeting Marked Questions
	 * @return [type] [description]
	 */
	function marked_questions()
	{
		$user=0;
		if($this->session->userdata('userid'))
		{
			$user=$this->session->userdata('userid');
		}

		$questions=json_decode($this->input->post('obj'));
	
		//$questions=$this->exam_model->get_marked_questions($user);

		$str_ques='';
		$i=1;
		if(count($questions)>0)
		{
			foreach ($questions as $ques) 
			{
				$qtext=question_bank_model::ques_text($ques);
				$q=strip_tags($qtext,'<img>');
				
		        $str_ques.="<li><input type='hidden' class='hdn_ques' id='hdn_ques_{$ques}' value='{$ques}'/>
		        <a href=''>";
		        $str_ques.="<input type='hidden' id='hdn_ques_sl{$i}'/>";
		        $str_ques.="<span id='sl' style='color:#8BC2E9;font-weight:bold;'>{$i}.</span>&nbsp;{$q}</a></li>";
		        $i++;
			}
		}

		echo $str_ques;
	}


		/**
	 * Storing Answer By User to Temporary Table in Databases
	 * @return [type] [description]
	 */
	function store_ans()
	{
		$qid=$this->input->get('qid');
		$ans=$this->input->get('ans_sl');
		$user=0;
		if($this->session->userdata('userid'))
		{
			$user=$this->session->userdata('userid');
		}
		
		if(!test_model::is_assigned($qid))
		{
			$data=array(
				'uid'=>$user,
				'qid'=>$qid,
				'ans'=>$ans,
                'ans_date'=>date('Y-m-d H:i:s'));
			$this->obj->add_temp_ans($data);
		}
		else
		{
			$answer=test_model::is_assigned($qid);
			$ans_arr=array();
			if(!empty($answer->ans))
			{
				$ans_arr=explode(',',$answer->ans);
			}
			$ans_segment=explode('_',$ans);
			if(count($ans_segment)==1)
			{
				if(!in_array($ans,$ans_arr))
				{
					array_push($ans_arr,$ans);
				}
			}
			if(count($ans_segment)==2)
			{
				$ans_key=array_search($ans_segment[0],$ans_arr);
				unset($ans_arr[$ans_key]);
			}
			
			$data=array(
				'ans'=>implode(',',$ans_arr));
			
			$this->obj->update_temp_ans($user,$qid,$data);
		}
		
	}

		/**
	 * Storing Answers to Answer Sheet Table and removing temporary table
	 * @return [type] [description]
	 */
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
					'chapter_id'=>$chapter_name,
					'qid'=>$d->qid,
					'ans'=>$d->sl,
					'correct_ans'=>$correct_ans,
					'quiz_id'=>$quiz_id);
					//var_dump($data);
					$this->quiz_model->create($data);
				}

				$i++;
			}

			$data_summery=array('user_id'=>$user,
				'chapter_id'=>$chapter_name,
				'quiz_id'=>$quiz_id,
				'quiz_date'=>Carbon::now()->toDateTimeString(),
				'time_taken'=>$time_taken,
				'total_correct'=>$correct_count,
				'total_wrong'=>$wrong_count);

			$this->quiz_summery_model->create($data_summery);
			echo base_url()."member/quiz_result/index/{$quiz_id}/$user";


		}
		
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
			$str.="<p class='ques'><i id='flag' data-status='1' title='mark this question' class='flag flag-grey'></i><span>{$sl}</span>&nbsp;&nbsp;{$q_plain}</p>";
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

		/**
	 * Question Reported via email by users
	 * @return [type] [description]
	 */
	function report_question()
	{
		$qid=$this->input->post('qid');
		$ques=$this->question_bank_model->question_by_id($qid);
		$username='';
		$email='';
		if($this->session->userdata('userid'))
		{
			$username=$this->session->userdata('username');
			$email=$this->session->userdata('email');
		}
		$question=$ques->question;

		$url=base_url()."admin/reported/index/{$qid}";
		$urlencoded=
		$msg='';
		$msg.="<div style='font-size:15px;'>";
		$msg.="This following question was reported<br/><br/>";
		$msg.="<strong>Reported Question:&nbsp;&nbsp;</strong><a href='{$url}' target='_blank'>{$question}</a>\n";
		$msg.="<strong>Reported By:&nbsp;&nbsp;</strong>{$username}\n";
		$msg.="</div>";

		$config = Array(
		  'protocol' => 'smtp',
		  'smtp_host' => 'smtp.mailgun.org',
		  'smtp_port' => 587,
		  'smtp_user' => 'postmaster@mail.iconpreparation.com',
		  'smtp_pass' => '3f17d564ae63bf6ac197a5de35b2381d-4534758e-b90b8473',
		  'mailtype' => 'html',
		  'charset' => 'utf-8',
		  'wordwrap' => TRUE
		);

	      $this->load->library('email', $config);
	      $this->email->set_newline("\r\n");
	      $this->email->from($email); 
	      $this->email->to('revinr.studypress@gmail.com');
	      $this->email->subject("A Question was reported by {$username}");
	      $this->email->message($msg);
	      if($this->email->send())
	     {
	      	echo 'Your question is successfully reported.';
	     }
	     else
	     {
	     	echo $this->email->print_debugger();
	     }
		
	}

		/**
	 * Adding answers to answer_review table for future review
	 */
	function add_to_review()
	{
		$qid=$this->input->post('qid');

		$user=0;
		if($this->session->userdata('userid'))
		{
			$user=$this->session->userdata('userid');
		}
		if($this->review->exists($user,$qid))
		{
			
		}
		else if(!$this->review->exists($user,$qid))
		{
			$this->review->add(array('user_id'=>$user,'qid'=>$qid));
			echo 'successfully added';
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
	 * Add Answer Summery to answer summery table
	 * @param [type] $test_name [description]
	 * @param [type] $user      [description]
	 * @param [type] $exam_date [description]
	 * @param [type] $trackid   [description]
	 */
	function add_ans_summery($test_name,$user,$exam_date,$trackid)
	{
		$exam=$this->exam_model->find($test_name);
		$answers=$this->obj->get_given_answer($user,$test_name);
		$timeTaken=$this->input->get('timeTaken');
		$correct=array();
		$wrong=array();
		foreach($answers as $ans)
		{
			$given_answer_arr=explode(',',$ans->answer);
			$answer_arr=$this->obj->get_correct_ans($ans->question_id);
			$correct_answer='';
			if(isset($answer_arr[0]))
			{
			$correct_answer=$answer_arr[0];
			}
			
			if(in_array($correct_answer,$given_answer_arr))
			{
				array_push($correct,'c');
			}
			else
			{
				array_push($wrong,'w');
			}
		}

		$gained=(count($correct)*$exam->mark_carry)-(count($wrong)*$exam->negative_marks);
	
		$correct_ans=count($correct);
		$wrong_ans=count($wrong);
		$notanswered=$exam->total_ques-(count($correct)+count($wrong));
		//$data['exam']=$exam;
		$data_ans_summery=array('exam_id'=>$test_name,
			'track_id'=>$trackid,
			'exam_date'=>$exam_date,
			'user_id'=>$user,
            'time_taken'=>$timeTaken,
			'total_correct'=>$correct_ans,
			'total_wrong'=>$wrong_ans);
		$this->obj->add_summery($data_ans_summery);
		
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
				$correct=substr(trim(strip_tags($ans,'<img>')),0,2)=="@@"?$ans_range[$i]:null;
				if($correct!=null)
				{
					return $correct;
				}
				
			}
			$i++;
		}
	}

		/**
	 * Marks Question For Review in an exam period
	 * @return [type] [description]
	 */
	function mark_question()
	{
		$qid=$this->input->post('qid');
		$user=0;
		if($this->session->userdata('userid'))
		{
			$user=$this->session->userdata('userid');
		}
		if(!$this->exam_model->exists_marks_question($user,$qid))
		{
			$data=array('user_id'=>$user,'qid'=>$qid);
			$this->exam_model->add_marked_question($data);
			echo 'successfully marked';
		}
		else
		{
			//$data=array('user_id'=>$user,'$qid'=>$qid);
		}
	}

}

/* End of file chapter_quiz.php */
/* Location: ./application/controllers/member/chapter_quiz.php */