<?php

class ExamController extends BaseController {

	function getBcsExam()
	{
		$bcs=Reftext::whereRaw('group_id=5 and parent_id=7 and display=1')->orderBy('serial','ASC')->get();
		if($bcs)
		{
			return ['bcs'=>$bcs,'msg'=>1];
		}
		else
		{
			return ['msg'=>0];
		}
	}

	function getAllPrevExam($exam_id)
	{
		$bcs=Reftext::whereRaw("group_id=5 and parent_id={$exam_id} and display=1")->orderBy('serial','ASC')->get();
		$exam=[];
        if($bcs)
        {
            foreach ($bcs as $row) {
                $data['id']=$row->id;
                $data['name']=$row->name;
                $data['group_id']=$row->group_id;
                $data['parent_id']=$row->parent_id;
                $data['serial']=$row->serial;
                $data['dispaly']=$row->display;
                if($row->parent_id==7){
                $data['time']=60;
                }
                elseif($row->parent_id==118){
                    $data['time']=120;
                }
                array_push($exam, $data);

            }
        }

		if($bcs)
		{
			return ['bcs'=>$exam,'msg'=>1];
		}
		else
		{
			return ['msg'=>0];
		}
	}


	function get_question_by_cat($exam_name,$uid,$mtype)
	{
		$exam_ques=ExamQues::whereRaw("exam_id={$exam_name}")->first();
		$exam_id=$exam_name;
		$exam_text=Reftext::find($exam_name)->name;
		$ques_arr=Quiz::strToArray($exam_ques->ques_id);

		$questions=Question::with('ExamName','Subject','Chapter','Comp_Id.Comprehension')
		->whereIn('id',$ques_arr)
		->get(array('id','exam_name','subject','chapter','question','hints','options','has_paragraph'));

		$ques=$this->question_process($questions);
		
		
		return ['ques'=>$ques,'exam_id'=>$exam_id,'exam_text'=>$exam_text];
	}


	function question_process($questions)
	{
		$ques=[];
		if($questions)
		{
			$sl=1;

			foreach ($questions as $q) {
				$data['sl']=$sl;
				$data['id']=$q->id;
				$data['subject']=$q->subject;
				$data['subject_name']=$q->Subject?$q->Subject->name:'';
				$data['chapter']=$q->chapter;
				$data['chapter_name']=$q->Chapter?$q->Chapter->name:'';
				$strip_ques=strip_tags($q->question,'<p><img><u><i><sub><sup>');
				$data['ques']=$strip_ques;
				$data['hints']=strip_tags($q->hints,'<p><img><i><sub><sup><u>');

				$comp_id=$q->Comp_Id;

				$comp=$comp_id?$comp_id->details:'';

				if(!empty($comp))
				{
					$striped_comp=strip_tags($q->comp,'<i><sub><sup><img>');
					$data['comp']=$striped_comp;
					$data['has_comp']=true;
				}
				else
				{
					$data['comp']='';
					$data['has_comp']=false;
				}
				$data['given_ans']='';
				//process answer options
				$option=[];
				if(!empty($q->options))
				{
					$opt_arr=explode('///',$q->options);
					$ans_range=range('A','H');
					$opt_sl=0;
					foreach ($opt_arr as $opt) {
						$striped_opt=strip_tags($opt,'<u><i><sub><sup><b><img>');
						$plain_opt=Quiz::makePlain($striped_opt);
						if(Quiz::isCorrect($striped_opt))
						{
							$ans['opt_serial']=$ans_range[$opt_sl];
							$data['correct_ans']=$ans_range[$opt_sl];
							$ans['is_correct']='C';
							$ans['ans']=$plain_opt;
							array_push($option,$ans);
						}
						else
						{
							$ans['opt_serial']=$ans_range[$opt_sl];
							$ans['is_correct']='W';
							$ans['ans']=$plain_opt;
							array_push($option,$ans);
						}
						$opt_sl++;
					}
					
				}
				$data['options']=$option;
				//end process answer options

				array_push($ques,$data);
				$sl++;
			}
		}

		return $ques;
	}


	function get_model_test($cat_id,$uid=5)
	{
		$modeltests=ModelTest::where('display',1)->where('category',$cat_id)->orderBy('id','DESC')->get();
		//dd($modeltests);
		$exp=Member::isExpired($uid);
		$expired=$exp;
		$member=Member::getMember($uid);
		if($modeltests)
		{
			return ['msg'=>1,'modeltests'=>$modeltests,'is_expired'=>$expired,'member'=>$member];
		}
		else
		{
			return ['msg'=>0];
		}
	}


	function get_test_ques($test_id,$uid,$mtype)
	{
		$expired=Member::isExpired($uid);
		$member=Member::getMember($uid);
		$mques=ModelTestQues::where('test_id',$test_id)->get();
		$test_name=ModelTest::find($test_id);

		$exam_text=$test_name?$test_name->name:'';

		$time=$test_name?$test_name->time:0;

		$ques=[];
		if($mques)
		{
			foreach ($mques as $q) {
				array_push($ques,$q->qid);
			}
		}

		$ids=count($ques)>0?implode(',',$ques):'';

		if(count($ques)>0)
		{
			$test_ques=Question::with('Subject','Chapter','Comp_Id.Comprehension')
			->whereIn('id',$ques)
			->orderByRaw(DB::raw("FIELD(id, {$ids})"))
			->get(array('id','exam_name','subject','chapter','question','hints','options','has_paragraph'));
			if($test_ques)
			{
				$test_ques_arr=$this->question_process($test_ques);
				
				
				return ['msg'=>1,'test_ques'=>$test_ques_arr,
				'test_id'=>$test_id,
				'time'=>$time,
				'exam_text'=>$exam_text,
				'is_expired'=>$expired,
				'member'=>$member];
			}
			else
			{
				return ['msg'=>0];
			}
		}
		else
		{
			return ['msg'=>0];
		}

	}

	 function exam_topic(){
		$fields = ['id','name'];
		$ExamTopic = RefText::where('group_id',2)->get($fields);
		
		return ['topicName'=>$ExamTopic];
	 }


	function save_quiz()
	{
		$uid=Input::get('user');
		$test_id=Input::get('test_id');
		$ans=Input::get('ans');
		$qid=Input::get('qid');
		$quiz_id=Input::get('quiz_id');
		$correct_ans=Input::get('correct_ans');
		$time_taken=Input::get('timeTaken');
		$today=date('Y-m-d H:i:s');

		$total_correct=0;
		$total_wrong=0;

		$quiz_data=[];
		
		if(count($qid)>0)
		{
			$i=0;
			foreach ($qid as $q) {
				if($ans[$i]==$correct_ans[$i])
				{
					$total_correct++;
				}
				else
				{
					$total_wrong++;
				}
				$data=array('user_id'=>$uid,
					'test_id'=>$test_id,
					'qid'=>$qid[$i],
					'ans'=>$ans[$i],
					'correct_ans'=>$correct_ans[$i],
					'quiz_id'=>$quiz_id,
					'taken_time'=>$time_taken);
				array_push($quiz_data, $data);

				$i++;
			}
		}

		$id=ModelQuiz::insert($quiz_data);
		
		$data_summery=array(
			'user_id'=>$uid,
			'test_id'=>$test_id,
			'quiz_id'=>$quiz_id,
			'quiz_date'=>$today,
			'time_taken'=>$time_taken,
			'total_correct'=>$total_correct,
			'total_wrong'=>$total_wrong);

		ModelQuizSummery::create($data_summery);
		return ['result'=>$data_summery,'msg'=>'successfull'];
	}

	function savechapQuiz(){
		$uid=Input::get('user');
		$test_id=Input::get('test_id');
		$quiz_id=Input::get('quiz_id');
		$today=Input::get('quiz_date');
		$time_taken=Input::get('timetaken');
		$total_correct=Input::get('total_correct');
		$total_wrong=Input::get('total_wrong');

		$data_summery=array(
			'user_id'=>$uid,
			'chapter_id'=>$test_id,
			'quiz_id'=>$quiz_id,
			'quiz_date'=>$today,
			'time_taken'=>$time_taken,
			'total_correct'=>$total_correct,
			'total_wrong'=>$total_wrong);

		ChapterQuizSummery::create($data_summery);
		return ['result'=>$data_summery,'msg'=>'successfull'];
	}

	function saveModelQuiz(){
		$uid=Input::get('user');
		$test_id=Input::get('test_id');
		$quiz_id=Input::get('quiz_id');
		$today=Input::get('quiz_date');
		$time_taken=Input::get('timetaken');
		$total_correct=Input::get('total_correct');
		$total_wrong=Input::get('total_wrong');

		$data_summery=array(
			'user_id'=>$uid,
			'test_id'=>$test_id,
			'quiz_id'=>$quiz_id,
			'quiz_date'=>$today,
			'time_taken'=>$time_taken,
			'total_correct'=>$total_correct,
			'total_wrong'=>$total_wrong);

		ModelQuizSummery::create($data_summery);
		return ['result'=>$data_summery,'msg'=>'successfull'];
	}
	function saveModelQuizDetails(){
		$uid=Input::get('user');
		$test_id=Input::get('test_id');
		$qid=Input::get('qid');
		$ans=Input::get('ans');
		$correct_ans=Input::get('correct_ans');
		$quiz_id=Input::get('quiz_id');
		$time_taken=Input::get('timeTaken');

		$data_summery=array(
			'user_id'=>$uid,
			'test_id'=>$test_id,
			'qid'=>$qid,
			'ans'=>$ans,
			'correct_ans'=>$correct_ans,
			'quiz_id'=>$quiz_id,
			'taken_time'=>$time_taken);

		ModelQuiz::create($data_summery);
		return ['result'=>$data_summery,'msg'=>'successfull'];
	}


	function is_locked()
	{
	    $locked=ChapterLockMapping::where('is_paid',1)
	    ->get(['chapter_id'])
	    ->toArray();
	    $locked=array_fetch( $locked,'chapter_id');
	   return ['lock_chapter'=>$locked];
	   // return in_array($chapter_id,$locked)?'true':'false';
	}
	function fetch_expiredate($user_id,$mem_type)
	{
		$update_date = User::where('id',$user_id)->pluck('update_date');
		if($mem_type == 3){
			$expired_date = date('Y-m-d', strtotime($update_date. ' + 30 days'));
		}
		else if($mem_type == 4){
			$expired_date = date('Y-m-d', strtotime($update_date. ' + 120 days'));
		}
		else if($mem_type == 5){
			$expired_date = date('Y-m-d', strtotime($update_date. ' + 180 days'));
		}
		else if($mem_type == 6){
			$expired_date = date('Y-m-d', strtotime($update_date. ' + 365 days'));
		}
		else if($mem_type == 7){
			$expired_date = date('Y-m-d', strtotime($update_date. ' + 7 days'));
		}
		else if($mem_type == 8){
			$expired_date = date('Y-m-d', strtotime($update_date. ' + 60 days'));
		}
		return ['expired_date'=>$expired_date];
	}
}