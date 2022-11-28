<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	var $temp_ans=array();
	function __construct()
	{
		parent::__construct();
		$this->load->model('Exam/test_model','obj');
		$this->load->model('Exam/ans_review_model','review');
		$this->load->model('question_bank_model');
		$this->load->model('exam_model');
		$this->load->model('user_model');
	}

	public function index()
	{
		$test_name=$this->uri->segment(4);
		$ques=$this->obj->get_questions_by_test($test_name);
		$ques_str=$ques?$ques->ques_id:'';
		
		$questions=array();
		$ques_arr=explode(',',$ques_str);
		foreach($ques_arr as $key) 
		{
			$ques_text=question_bank_model::ques_text($key);
			array_push($questions,array('id'=>$key,'ques_id'=>$ques_text));
		}
		$i=1;
		$str_ques='';
       if($questions)
        {
	        foreach($questions as $ques)
	        {
		        $q=strip_tags($ques['ques_id'],'<img>');
		        $str_ques.="<li><input type='hidden' class='hdn_ques' id='hdn_ques_{$ques['id']}' value='{$ques['id']}'/>
		        <a href=''><span id='sl' style='color:#8BC2E9;font-weight:bold;'>{$i}.</span>&nbsp;{$q}</a></li>";
		        $i++;
	      	}
        }

		$data['test_name']=$test_name;
		$data['questions']=$str_ques;
		//$data['main_content']='member/exam/v_test';
		//$this->load->view('layout/master', $data);
		$this->load->view('member.exam.v_test', $data, FALSE);
	}


	/**
	 * Getting All Questions
	 */
	function all_questions()
	{
		$test_name=$this->input->post('testname');
		$ques=$this->obj->get_questions_by_test($test_name);
		$ques_str=$ques->ques_id;
		
		$questions=array();
		$ques_arr=explode(',',$ques_str);
		foreach($ques_arr as $key) 
		{
			$ques_text=question_bank_model::ques_text($key);
			array_push($questions,array('id'=>$key,'ques_id'=>$ques_text));
		}
		$i=1;
		$str_ques='';
       if($questions)
        {
	        foreach($questions as $ques)
	        {
		        $q=strip_tags($ques['ques_id'],'<img>');
		        $str_ques.="<li><input type='hidden' class='hdn_ques' id='hdn_ques_{$ques['id']}' value='{$ques['id']}'/>
		        <a href=''><span id='sl' style='color:#8BC2E9;font-weight:bold;'>{$i}.</span>&nbsp;{$q}</a></li>";
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

		$questions=$this->exam_model->get_marked_questions($user);

		$str_ques='';
		$i=1;
		if($questions)
		{
			foreach ($questions as $ques) 
			{
				$qtext=question_bank_model::ques_text($ques->id);
				$q=strip_tags($qtext,'<img>');
				
		        $str_ques.="<li><input type='hidden' class='hdn_ques' id='hdn_ques_{$ques->id}' value='{$ques->id}'/>
		        <a href=''><span id='sl' style='color:#8BC2E9;font-weight:bold;'>{$i}.</span>&nbsp;{$q}</a></li>";
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
		
		$testname=$this->input->get('test_name');
		$answers=$this->obj->get_temp_data($user);
		$date=date('Y-m-d H:i:s');
		$track_id=$this->generate_test_id($testname,$user);
        if($answers)
        {
            foreach($answers as $ans)
            {
            	$corr_ans=$this->get_correct_answer($ans->qid);
                $data=array('user_id'=>$user,
                    'question_id'=>$ans->qid,
                    'answer'=>$ans->ans,
                    'correct_ans'=>$corr_ans,
                    'exam_date'=>$date,
                    'exam_id'=>$testname,
                    'test_track_id'=>$track_id);
                $this->obj->add_answer($data);
            }

            $this->add_ans_summery($testname,$user,$date,$track_id);
        }
        $this->obj->delete_temp_data($user);
        $this->exam_model->delete_marked_question($user);

        //maintaining member point after exam
        $data_point=array('user_id'=>$user,
                    'added_date'=>date('Y-m-d H:i:s'),
                    'point'=>'-10',
                    'point_type'=>'consumed');
        $this->obj->add_point_history($data_point);
        $point_total=$this->obj->total_point($user);
        if($this->obj->point_summery_exists($user))
        {
            $data_point_summery=array('point'=>$point_total,
                                'update_date'=>date('Y-m-d H:i:s'));
            $this->obj->update_point_summery($user,$data_point_summery);
        }
        else
        {
            $data_point_summery=array('user_id'=>$user,
                                'point'=>$point_total,
                                'creation_date'=>date('Y-m-d H:i:s'));
            $this->obj->add_point_summery($data_point_summery);
        }
        //end maintaining member point after exam

		echo base_url()."member/result/index/{$testname}/{$user}";
	}

	/**
	 * Getting Answers on click event on questions
	 * @return [type] [description]
	 */
	function get_ans()
	{
		$qid=$this->input->get('qid');
		$sl=$this->input->get('sl');
		$question=$this->obj->get_options($qid);
		$str='';
		$selected_answer_arr=array();
		if(test_model::is_assigned($qid))
		{
			$selected_answer=test_model::is_assigned($qid);
			$selected_answer_arr=explode(',',$selected_answer->ans);
		}

		$test_name=$this->input->get('test_name');
		$ques=$this->obj->get_questions_by_test($test_name);
		$ques_str=$ques->ques_id;
		$questions=array();
		$ques_arr=explode(',',$ques_str);
		foreach($ques_arr as $key) 
		{
			$ques_text=question_bank_model::ques_text($key);
			array_push($questions,$ques_text);
		}

		if($question)
		{
			
			$options=$question->options;
			$q_plain=strip_tags($question->question,'<img>');
			$last_ques=strip_tags(end($questions),'<img>');
		
			$tagless_options=strip_tags($options,'<img>');
			$answers=explode('///',trim($tagless_options));
			$str.="<p class='ques'><i id='flag' data-status='1' title='mark this question' class='flag flag-grey'></i>{$sl}&nbsp;&nbsp;{$q_plain}</p>";
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
				<input class='ck_ans' style='float:left;' {$cked} type='checkbox' name='ck_ans[]' value='{$ans_plain}'>&nbsp;&nbsp;{$ans_plain}<span class='pull-left'>&nbsp;&nbsp;({$ans_range[$i]}.)&nbsp;&nbsp;</span></label>";
				$str.="</div>";
				$i++;
				
			}
			if($last_ques==$q_plain)
			{
				$last=1;
			}
			else
			{
				$last=0;
			}
			$str.="<input type='hidden' value='{$last}' id='hdn_last_ques'/>";
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

		$url=base_url()."reported/index/{$qid}";
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
	      $this->email->to('muztahidul@gmail.com');
	      $this->email->subject("A Question was reported by {$username}");
	      $this->email->message($msg);
	      if($this->email->send())
	     {
	      	echo 'Your question is successfully rported.';
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
		$test_id='';
		$dt=strtotime('now');
		$yr=date('Y',$dt);
		$month=date('m',$dt);
		$day=date('d',$dt);
		$hour=date('H',$dt);
		$min=date('i',$dt);
		$second=date('s',$dt);
		$time_string=$yr.$month.$day.$hour.$min.$second;
		$test_id=$time_string.'_'.$exam_id.'_'.$user;

		return $test_id;
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
		$question=$this->question_bank_model->question_by_id($qid);
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

/* End of file test.php */
/* Location: ./application/controllers/public/test.php */