<?php

class CurrentWorldController extends BaseController {

	function current_world_quiz()
	{
		$questions=$questions=Question::whereRaw("chapter=315")->get()->random(20);
		$given=[];

		$exam_text='Current World';

		if($questions)
		{
			$sl=1;
			foreach($questions as $ques)
			{
					$question=$ques;

					$stripped_ques=strip_tags(empty($question->question)?'':$question->question,'<img><i><sub><sup><b><u>');
					$data['sl']=$sl;
					$data['question']=$stripped_ques;
					
					$ans_arr=explode('///',trim($question->options));

					if(count($ans_arr))
					{
						$rng_ques=range('A','H');
						$data['answers']=[];
						$i=0;
						$ans_meta=[];
						$data['correct_ans']='';
						$data['given_ans']='';
						foreach($ans_arr as $ans)
						{
							$striped_ans=strip_tags(trim($ans),"<img></sub><sup><i><u><b>");
							$correct=substr($striped_ans,0,2)=="@@"?true:false;
							$ans_plain=str_replace('@@','',trim($striped_ans));
							if($correct)
							{
								$data['correct_ans']=$rng_ques[$i];
								array_push($ans_meta,['answer'=>$ans_plain,
									'opt_serial'=>$rng_ques[$i],'is_correct'=>'C']);
							}
							else
							{
								array_push($ans_meta,['answer'=>$ans_plain,'opt_serial'=>$rng_ques[$i],'is_correct'=>'W']);
							}
							$i++;

						}
						$data['answers']=$ans_meta;
					}
					array_push($given,$data);
				
				$sl++;
			}
		}

		return ['msg'=>1,'exam_text'=>$exam_text,'given'=>$given];
	}

	function get_hints()
	{
		$questions=Question::whereRaw("chapter=315")->orderBy('id','DESC')->get(['question','hints','tags']);
		$ques=[];
		if($questions)
		{
			$sl=1;
			foreach ($questions as $q) {
				if(!empty($q->hints))
				{
					$question_plain=strip_tags($q->question);
					$hints_plain=strip_tags($q->hints);
					$tags=!empty($q->tags)?$q->tags:'';
					$data['sl']=$sl;
					$data['tags']=$tags;
					$data['question']=$question_plain;
					$data['hints']=$hints_plain;
					array_push($ques,$data);
					$sl++;
				}
			}
			return ['msg'=>1,'current_world'=>$ques];
		}
		else
		{
			return ['msg'=>0,'current_world'=>$ques];
		}
	}

	function get_prev_psc($user,$cat)
	{
		$psc_prev=Reftext::whereRaw("group_id=5 and parent_id={$cat} and display=1")
		->orderBy('serial','ASC')->get();
		 return $psc_prev;
	}

	function get_prev_question($user,$exam_id)
	{
		$exam=Exam::whereRaw("ref_id={$exam_id}")->first();
		$ques=[];
		if($exam)
		{
			$exam_name=Reftext::find($exam_id)->name;
			$ques_str=ExamQues::whereRaw("exam_id={$exam->id}")->first(['ques_id']);
			$ques_arr=Quiz::strToArray($ques_str?$ques_str->ques_id:[]);

			$qid_str=implode($ques_arr,',');

			$questions=Question::with('ExamName','Subject','Chapter','Comp_Id')
			->whereRaw("id in($qid_str)")->get();


			$data=[];
			if($questions)
			{
				$sl=1;
				foreach ($questions as $q) 
				{

					$data['sl']=$sl;
					$ans_plain_arr=[];
					if(!empty($q))
					{
						//getting question
						$q_plain=strip_tags($q->question,"<img><u><sup><sub><i><p><b>");
						$data['id']=$q->id;
						$data['question']=$q_plain;
						//end getting question
						
						//getting answers of this question
						if($q->options)
						{
							$options=[];
							$ans_range=range('A','H');
							$opt_sl=0;
							$ans_arr=explode('///',trim($q->options));
							foreach ($ans_arr as $ans) {
								
								$ans_plain=strip_tags($ans,"<img><u><sup><sub><i><b>");
								$is_correct=Quiz::isCorrect($ans_plain);

								$data_ans['ans_result']=$is_correct?'C':'W';

								$ans_plain=Quiz::makePlain($ans_plain);
								$data_ans['ans']=$ans_plain;

								$data_ans['sl']=$opt_sl;

								array_push($options, $data_ans);

								$opt_sl++;
							}
							$data['option']=$options;
							// array_push($ans_plain_arr, $q_plain);
						}
						//end getting answers of this questions
					}

					array_push($ques, $data);
					$sl++;
				}

			}

			return ['exam_name'=>$exam_name,'exam_id'=>$exam_id,'questions'=>$ques];
		}
		
	}
}