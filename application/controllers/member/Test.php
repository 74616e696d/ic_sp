<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use Carbon\Carbon;
class Test extends Member_controller {

	var $temp_ans=array();
	function __construct()
	{
		parent::__construct();
		// check membership expiration
    	$this->load->model('permission_model');
    // 	if($this->utype!='101' && $this->utype!='102')
    // 	{
	  	// 	if($this->permission_model->is_expired($this->userid))
	  	// 	{
	  	// 		$this->session->set_flashdata('warning', 'You current membership is expired! please renew or upgrade now!');
	  	// 		redirect(base_url().'public/upgrade');
	  	// 	}
  		// }
  		//end check membership expiration
		$this->load->model('Exam/test_model','obj');
		$this->load->model('Exam/ans_review_model','review');
		$this->load->model('member/mistake_model','mistake');
		$this->load->model('question_bank_model');
		$this->load->model('exam_model');
		$this->load->model('user_model');
		$this->load->model('manage_comprehension_model');
	}

	public function index()
	{
		$test_name=$this->uri->segment(4);
		$ques=$this->obj->get_questions_by_test($test_name);
		// $question_id=
		$ques_str=$ques?rtrim($ques->ques_id,','):'';
		
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
		        $q=strip_tags($ques['ques_id'],'<img><sub><u><sup>');
		        $str_ques.="<li><input type='hidden' class='hdn_ques' id='hdn_ques_{$ques['id']}' value='{$ques['id']}'/>
		        <a href=''>";
		        $str_ques.="<input type='hidden' id='hdn_ques_sl{$i}'/>";
		        $str_ques.="<span id='sl' style='color:#8BC2E9;font-weight:bold;'>{$i}.</span>&nbsp;{$q}</a></li>";
		        $i++;
	      	}
        }
        $data['test_meta']=$this->exam_model->find($test_name);
        $data['ttl_ques']=count($questions);
		$data['test_name']=$test_name;
		$data['questions']=$str_ques;
		$this->load->blade('member.exam.v_test', $data);
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
		        $q=strip_tags($ques['ques_id'],'<img><sub><u><sup>');
		        $str_ques.="<li><input type='hidden' class='hdn_ques' id='hdn_ques_{$ques['id']}' value='{$ques['id']}'/>
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
	
		$marked_ques=json_decode($this->input->post('obj'));
		$questions=false;
		if(count($marked_ques)>0){
		$questions=$this->exam_model->get_marked_questions($marked_ques);
		}

		$str_ques='';
		$i=1;
		if($questions)
		{
			foreach ($questions as $ques) 
			{
				$qtext=question_bank_model::ques_text($ques->id);
				$q=strip_tags($ques->question,'<img><img><sub><u><sup>');
				
		        $str_ques.="<li><input type='hidden' class='hdn_ques' id='hdn_ques_{$ques->id}' value='{$ques->id}'/>
		        <a href=''>";
		        $str_ques.="<input type='hidden' id='hdn_ques_sl{$i}'/>";
		        $str_ques.="<span id='sl' style='color:#8BC2E9;font-weight:bold;'>{$i}.</span>&nbsp;{$q}</a></li>";
		        $i++;
			}
		}
		else
		{
			$str_ques.="<li>Not Question Marked<li>";
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
		$user=$this->userid;
		$dt=json_decode($this->input->post('obj'));
	
		$test_name=0;
		$time_taken=0;
		$quiz_id='';
		$correct_count=0;
		$wrong_count=0;

		$date=date('Y-m-d H:i:s');
		$track_id='';
		
        if(count($dt)>2)
        {
        	$i=1;
        	
            foreach($dt as $ans)
            {
            	if($i==1)
            	{
            		$test_name=$ans->test_name;
					$time_taken=$ans->timeTaken;
					$track_id=$this->generate_test_id($test_name,$user);
            	}
            	else
            	{
	            	$corr_ans=$this->get_correct_answer($ans->ques_id);
	            	if($ans->ques_sl==$corr_ans)
	            	{
	            		$correct_count++;
	            	}
	            	else
	            	{
	            		$wrong_count++;
	            		if($this->mistake->exist($this->userid,$ans->ques_id))
	            		{
	            			$data_mistake=array('last_attempt_date'=>$date);
	            			$this->mistake->update($this->userid,$ans->ques_id,$data_mistake);
	            		}
	            		else
	            		{
	            			$data_mistake=array('user_id'=>$this->userid,
	            				'qid'=>$ans->ques_id,
	            				'last_attempt_date'=>$date);
	            			$this->mistake->add($data_mistake);
	            		}
	            	}
	                $data=array('user_id'=>$user,
	                    'question_id'=>$ans->ques_id,
	                    'answer'=>$ans->ques_sl,
	                    'correct_ans'=>$corr_ans,
	                    'exam_date'=>$date,
	                    'exam_id'=>$test_name,
	                    'test_track_id'=>$track_id);
	                $this->obj->add_answer($data);
                  }
                  $i++;
            }

            $total_question=$this->exam_model->get_total_question($test_name);
            $data_summery=array('exam_id'=>$test_name,
            	'track_id'=>$track_id,
            	'exam_date'=>$date,
            	'user_id'=>$user,
            	'time_taken'=>$time_taken,
            	'total_question'=>$total_question,
            	'total_correct'=>$correct_count,
            	'total_wrong'=>$wrong_count);

           $this->obj->add_summery($data_summery);
           echo base_url()."member/result/index/{$track_id}/{$user}";
        }
        else
        {
        	echo base_url()."member/take_exam";
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
		$ques_str=empty($ques->ques_id)?'':$ques->ques_id;
		$questions=array();
		$ques_arr=explode(',',$ques_str);
		foreach($ques_arr as $key) 
		{
			$ques_text=question_bank_model::ques_text($key);
			if(!empty($ques_text)){
			array_push($questions,$ques_text);
			}
		}
		$total=count($questions);
		if($question)
		{
			// start passage comprehension
			if($question->has_paragraph)
			{
				$comp=$this->manage_comprehension_model->questions_comprehension($qid);
				$comp_meta=$this->manage_comprehension_model->get_comp_qid($qid);
				$ttl_comp=count($comp_meta);
				$range_to=($sl+$ttl_comp)-1;
				$comp_range="{$sl} To {$range_to}";
				if($comp)
				{
					if(!empty($comp->details))
					{
						$str.="<p><strong><u>Reading the following paragraph and answer the following question ({$comp_range})</u></strong></p>";
						$str.="{$comp->details}";
					}
				}
			}
			//end passage comprehension
			$options=$question->options;
			$q_plain=strip_tags($question->question,'<img><img><sub><u><sup>');
			$last_ques=strip_tags(end($questions),'<img>');

			
			$tagless_options=strip_tags($options,'<img><img><sub><u><sup>');
			$answers=explode('///',trim($tagless_options));
			$str.="<p class='ques'><i id='flag' data-status='0' title='mark this question' class='flag flag-grey'></i><span>{$sl}</span>&nbsp;&nbsp;{$q_plain}</p>";
			$i=0;
			$correct_ans='';
			$last=0;
			$ans_range=range('A','H');

			foreach ($answers as $ans) 
			{
				$correct=substr(trim(strip_tags($ans,'<img>')),0,2)=="@@"?true:false;
				$ans_plain=str_replace('@@','',trim($ans));
				//$cked=in_array($ans_range[$i],$selected_answer_arr)?'checked':'';
				if($correct)
				{
					$correct_ans=$ans_plain;
				}
				
				$str.="<input type='hidden' id='hdn_qid' value='{$question->id}'/>";
				$str.="<div class='radio'>";
				$str.="<label>
				<input class='ck_ans' style='margin-left:0;float:left;' type='radio' name='ck_ans[]' value='{$ans_plain}'>&nbsp;&nbsp;{$ans_plain}<span class='pull-left'>&nbsp;&nbsp;({$ans_range[$i]}.)&nbsp;&nbsp;</span></label>";
				$str.="</div>";
				$i++;
				
			}
			if($total==$sl)
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
		$this->config->load('mail_setting');
		$config_protocal=$this->config->item('protocal');
		$config_smtp_host=$this->config->item('smtp_host');
		$config_port=$this->config->item('port');
		$config_smtp_user=$this->config->item('smtp_user');
		$config_smtp_pass=$this->config->item('smtp_pass');

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

		$url=base_url()."admin/reported/index/{$qid}/{$this->userid}";
		$urlencoded=
		$msg='';
		$msg.="<div style='font-size:15px;'>";
		$msg.="This following question was reported<br/><br/>";
		$msg.="<strong>Reported Question:&nbsp;&nbsp;</strong><a href='{$url}' target='_blank'>{$question}</a>\n";
		$msg.="<strong>Reported By:&nbsp;&nbsp;</strong>{$username}\n";
		$msg.="</div>";

		$config = Array(
		  'protocol' => $config_protocal,
		  'smtp_host' => $config_smtp_host,
		  'smtp_port' =>$config_port,
		  'smtp_user' =>$config_smtp_user,
		  'smtp_pass' =>$config_smtp_pass,
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
		$examid='';
		$dt=Carbon::now();
		$stamp=$dt->timestamp;
		$examid=$stamp.'_'.$exam_id.'_'.$user;
		return $examid;
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