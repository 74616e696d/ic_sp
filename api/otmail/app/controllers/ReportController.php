<?php

class ReportController extends BaseController {

	function quiz_details($user,$testid,$tm)
	{
		$test_id=$this->extractTestId($testid);

		$all_test_ques=DB::select("SELECT qb.id,qb.question,qb.options,qb.hints,mq.correct_ans,mq.ans FROM question_bank qb 
  	JOIN model_quiz mq ON mq.qid = qb.id 
			WHERE  mq.test_id=?",[$testid]);

		$result=[];

		if($all_test_ques)
		{	$sl=1;
			foreach ($all_test_ques as $ques) 
			{
				$data['sl']=$sl;

				//question
				$q=$ques->question;
				$q_plain=strip_tags($q,"<p><img><i><u><sub><sup><b>");
				$data['question']=$q_plain;
				//end question
				
				//hints
				$data['hints']=strip_tags($ques->hints,'<p><img><i><sub><sup><u>');
				//end hints
				
				//options
				$option=[];
				if(!empty($ques->options))
				{
					$opt_arr=explode('///',$ques->options);
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
							$ans['answer']=$plain_opt;
							array_push($option,$ans);
						}
						$opt_sl++;
					}
					
				}
				$data['options']=$option;
				//end options
				array_push($result,$data);
				$sl++;
			}
		}

		$test_name=ModelTest::find($test_id);
		$exam_text=$test_name?$test_name->name:'';

		return ['msg'=>1,'exam_text'=>$exam_text,'given'=>$result];
	}

	/**
	 * extract test id from quizId
	 * @param  [type] $quizId [description]
	 * @return [type]         [description]
	 */
	function extractTestId($quizId)
	{
		$id=0;
		if(!empty($quizId)){
			$qid=explode("_", $quizId);
			if(isset($qid[1]))
			{
				$id=$qid[1];
			}
		}
		return $id;
	}
}