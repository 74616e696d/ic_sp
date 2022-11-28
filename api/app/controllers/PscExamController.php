<?php

class PscExamController extends BaseController {

	function get_exam_type($user)
	{
		$psc_prev_exam_type=Reftext::whereRaw('id in(7) and display=1')
			->orderBy('serial','ASC')->get();
		 return $psc_prev_exam_type;
	}

	function get_prev_psc($user,$cat)
	{
		$psc_prev=Reftext::whereRaw("group_id=5 and parent_id={$cat} and display=1")
		->orderBy('serial','ASC')->get();
		 return $psc_prev;
	}


	function get_subject_list($user,$exam_id)
	{
		$subjects=Reftext::whereRaw("group_id=3 and parent_id={$exam_id}")->get();

		return $subjects;
	}

	function get_chapter_list($user,$subject)
	{
		$chapters=Reftext::with('children')->whereRaw("group_id=6 and parent_id={$subject}")->get();
		return $chapters;
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
						$q_plain=strip_tags($q->question,"<img><u><sup><sub><i><b>");
						$data['id']=$q->id;
						$data['question']=Quiz::sanitizeString(['&nbsp;','\n','<sub>','<sup>','&acute','&gt;','&lsquo;','&rsquo;','&mdash;','&#39;','&ndash;','&rdquo;','&hellip;','&ldquo;','&quot;','<u>','</u>','&amp;','</sub>','</sup>','&zwnj;','&times;','&radic;'],$q_plain);
						$data['subject']=$q->Subject?$q->Subject->name:'';
						$data['subject_id']=$q->subject;
						$data['chapter']=$q->Chapter?$q->Chapter->name:'';
						$data['chapter_id']=$q->chapter;
						$data['given_ans']='';

						$q_hints=strip_tags($q->hints,"<img><u><b>");
						$data['hints']=Quiz::sanitizeString(['&nbsp;','\n','<sub>','<sup>','&acute','&gt;','&lsquo;','&rsquo;','&mdash;','&#39;','&ndash;','&rdquo;','&hellip;','&ldquo;','&quot;','<u>','</u>','&amp;','</sub>','</sup>','&zwnj;','&times;','&radic;'],$q_hints);

						$comp_id=$q->Comp_Id?$q->comp_id:false;
						$comp=!$comp_id?'':strip_tags($comp_id->details,'<img><u><sub><sup><i><u>');
						$data['passage_comp']=$comp;
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
								$ans_plain=Quiz::sanitizeString(['&nbsp;','\n','<sub>','<sup>','&acute','&gt;','&lsquo;','&rsquo;','&mdash;','&#39;','&ndash;','&rdquo;','&hellip;','&ldquo;','&quot;','<u>','</u>','&amp;','</sub>','</sup>','&zwnj;','&times;','&radic;'],$ans_plain);
								$is_correct=Quiz::isCorrect($ans_plain);

								$data_ans['ans_result']=$is_correct?'C':'W';

								$ans_plain=Quiz::makePlain($ans_plain);
								$data_ans['ans']=$ans_plain;
								if($is_correct)
								{
									$data['correct_ans']=trim($ans_plain);
									//$data['correct_ans']=$ans_range[$opt_sl];
								}
								$data_ans['ans_sl']=$ans_range[$opt_sl];

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


	function get_chapter_question($user,$chapter)
	{
		// $questions=Question::with('ExamName','Subject','Chapter','Comp_Id')->whereRaw("chapter={$chapter}")->get();
		
		$ques=[];
		$msg=1;
		//$questions=Question::with('ExamName','Subject','Chapter','Comp_Id')->whereRaw("chapter={$chapter}")->orderByRaw("RAND()")->take(20)->get();
		$question_latest = Question::whereRaw("chapter={$chapter}")->orderBy('id', 'desc')->take(20)->get();
		$question_ids = array();
		foreach($question_latest as $row){
			array_push($question_ids,$row->id);
		}

		$data=[];
		if($question_ids)
		{
			$sl=1;
			shuffle($question_ids);
			foreach ($question_ids as $id) 
			{
				$q = Question::with('ExamName','Subject','Chapter','Comp_Id')->find($id);
				$data['sl']=$sl;
				$ans_plain_arr=[];
				if(!empty($q))
				{
					//getting question
					$q_plain=strip_tags($q->question,"<img><u><sup><sub><i><b>");
					$data['id']=$q->id;
					$data['question']=Quiz::sanitizeString(['&nbsp;','\n','<sub>','<sup>','&acute','&gt;','&lsquo;','&rsquo;','&mdash;','&#39;','&ndash;','&rdquo;','&hellip;','&ldquo;','&quot;','<u>','</u>','&amp;','</sub>','</sup>','&zwnj;','&times;','&radic;'],$q_plain);
					$data['subject']=$q->Subject->name;
					$data['subject_id']=$q->subject;
					$data['chapter']=$q->Chapter->name;
					$data['chapter_id']=$q->chapter;
					$data['given_ans']='';

					$comp_id=$q->Comp_Id?$q->comp_id:false;
					$comp=!$comp_id?'':strip_tags($comp_id->details,'<img><u><sub><sup><i><u>');

					$q_hints=strip_tags($q->hints,'<img><u><sup><sub><i><u><strong><b>');
					$data['hints']=Quiz::sanitizeString(['&nbsp;','\n','<sub>','<sup>','&acute','&gt;','&lsquo;','&rsquo;','&mdash;','&#39;','&ndash;','&rdquo;','&hellip;','&ldquo;','&quot;','<u>','</u>','&amp;','</sub>','</sup>','&zwnj;','&times;','&radic;'],$q_hints);

					$data['passage_comp']=$comp;
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
							$ans_plain=Quiz::sanitizeString(['&nbsp;','\n','<sub>','<sup>','&acute','&gt;','&lsquo;','&rsquo;','&mdash;','&#39;','&ndash;','&rdquo;','&hellip;','&ldquo;','&quot;','<u>','</u>','&amp;','</sub>','</sup>','&zwnj;','&times;','&radic;'],$ans_plain);
							$is_correct=Quiz::isCorrect($ans_plain);

							$data_ans['ans_result']=$is_correct?'C':'W';

							$ans_plain=Quiz::makePlain($ans_plain);
							$data_ans['ans']=$ans_plain;
							if($is_correct)
							{
								$data['correct_ans']=trim($ans_plain);
								//$data['correct_ans']=$ans_range[$opt_sl];
							}
							$data_ans['ans_sl']=$ans_range[$opt_sl];

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
		else
		{
			$msg=1;
		}

		return ['msg'=>$msg,'questions'=>$ques];
	}

	function get_chapter_details($user,$chapter)
	{
		$details=RefDetails::with('reftext')->where('ref_id',$chapter)->first();
		$msg=1;
		$data=[];
		if($details)
		{
			$data['chapter']=$details->reftext->name;
			$data['chapter_id']=$details->ref_id;

			//$content=strip_tags($details->details,'<p><br/><img><i><u><strong><sub><sup><b>');
			$content=strip_tags($details->details);
			$content=Quiz::sanitizeString(['&nbsp;','\n','<sub>','</sub>','</sup>','<sup>','&acute','&gt;','&lsquo;','&rsquo;','&mdash;','&#39;','&ndash;','&rdquo;','&hellip;','&ldquo;','&quot;','&amp;','</sub>','</sup>','&zwnj;','&times;','&radic;'],$content);
			$data['details']=$content;

		}
		else
		{
			$msg=0;
		}
		return ['msg'=>$msg,'chapter_details'=>$data];
	}

	function get_chapter_all_question($user,$chapter)
	{
			// $questions=Question::with('ExamName','Subject','Chapter','Comp_Id')->whereRaw("chapter={$chapter}")->get();
			
			$ques=[];
			$msg=1;
			$questions=Question::with('ExamName','Subject','Chapter','Comp_Id')->whereRaw("chapter={$chapter}")->orderBy('id','desc')
				->get();

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
						$q_plain=strip_tags($q->question,"<img><u><sup><sub><i><b>");
						$data['id']=$q->id;
						$data['question']=Quiz::sanitizeString(['&nbsp;','\n','<sub>','<sup>','&acute','&gt;','&lsquo;','&rsquo;','&mdash;','&#39;','&ndash;','&rdquo;','&hellip;','&ldquo;','&quot;','<u>','</u>','&amp;','</sub>','</sup>','&zwnj;','&times;','&radic;'],$q_plain);
						$data['subject']=$q->Subject->name;
						$data['subject_id']=$q->subject;
						$data['chapter']=$q->Chapter->name;
						$data['chapter_id']=$q->chapter;
						$data['given_ans']='';

						$comp_id=$q->Comp_Id?$q->comp_id:false;
						$comp=!$comp_id?'':strip_tags($comp_id->details,'<img><u><sub><sup><i><u>');

						$q_hints=strip_tags($q->hints,'<img><u><sup><sub><i><u><strong><b>');
						$data['hints']=Quiz::sanitizeString(['&nbsp;','\n','<sub>','<sup>','&acute','&gt;','&lsquo;','&rsquo;','&mdash;','&#39;','&ndash;','&rdquo;','&hellip;','&ldquo;','&quot;','<u>','</u>','&amp;','</sub>','</sup>','&zwnj;','&times;','&radic;'],$q_hints);

						$data['passage_comp']=$comp;
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
								$ans_plain=Quiz::sanitizeString(['&nbsp;','\n','<sub>','<sup>','&acute','&gt;','&lsquo;','&rsquo;','&mdash;','&#39;','&ndash;','&rdquo;','&hellip;','&ldquo;','&quot;','<u>','</u>','&amp;','</sub>','</sup>','&zwnj;','&times;','&radic;'],$ans_plain);
								$is_correct=Quiz::isCorrect($ans_plain);

								$data_ans['ans_result']=$is_correct?'C':'W';

								$ans_plain=Quiz::makePlain($ans_plain);
								$data_ans['ans']=$ans_plain;
								if($is_correct)
								{
									$data['correct_ans']=trim($ans_plain);
									//$data['correct_ans']=$ans_range[$opt_sl];
								}
								$data_ans['ans_sl']=$ans_range[$opt_sl];

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
			else
			{
				$msg=1;
			}

			return ['msg'=>$msg,'questions'=>$ques];
		}

}