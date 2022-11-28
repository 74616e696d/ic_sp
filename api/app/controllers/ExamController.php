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
		$bcs=Reftext::with('meta')->whereRaw("group_id=5 and parent_id={$exam_id} and display=1")->orderBy('name','ASC')->get();
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
                $time=$row->meta?$row->meta->total_time:60;
                $time=$time!=null?$time:60;
                $data['time']=$time;
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

function get_test_sheet($test_id, $uid)
{
	$result = ModelQuizSummery::where('test_id',$test_id)
	->join('users','users.id','=','model_quiz_summery.user_id')
	->selectRaw("users.user_name, users.email, model_quiz_summery.*, (model_quiz_summery.total_correct - model_quiz_summery.total_wrong/2) AS 'marks'",FALSE)
	->orderBy('marks','DESC')->get();
	return $result;
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
				$strip_ques=strip_tags($q->question,'');
				$data['ques']=Quiz::sanitizeString(['&nbsp;','\n','<sub>','<sup>','&acute','&gt;','&lsquo;','&rsquo;','&mdash;','&#39;','&ndash;','&rdquo;','&hellip;','&ldquo;','&quot;','<u>','</u>','&amp;','</sub>','</sup>','&zwnj;','&times;','&radic;'],$strip_ques);
				$striped_hints=strip_tags($q->hints,'<p><img><i><sub><sup><u>');
				$data['hints']=Quiz::sanitizeString(['&nbsp;','\n','<sub>','<sup>','&acute','&gt;','&lsquo;','&rsquo;','&mdash;','&#39;','&ndash;','&rdquo;','&hellip;','&ldquo;','&quot;','<u>','</u>','&amp;','</sub>','</sup>','&zwnj;','&times;','&radic;'],$striped_hints);

				$comp_id=$q->Comp_Id;

				$comp=$comp_id?$comp_id->details:'';

				if(!empty($comp))
				{
					$striped_comp=strip_tags($q->comp,'');
					$data['comp']=Quiz::sanitizeString(['&nbsp;','\n','<sub>','<sup>','&acute','&gt;','&lsquo;','&rsquo;','&mdash;','&#39;','&ndash;','&rdquo;','&hellip;','&ldquo;','&quot;','<u>','</u>','&amp;','</sub>','</sup>','&zwnj;','&times;','&radic;'],$striped_comp);
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
						$striped_opt=strip_tags($opt,'');
						$plain_opt=Quiz::sanitizeString(['&nbsp;','\n','<sub>','<sup>','&acute','&gt;','&lsquo;','&rsquo;','&mdash;','&#39;','&ndash;','&rdquo;','&hellip;','&ldquo;','&quot;','<u>','</u>','&amp;','</sub>','</sup>','&zwnj;','&times;','&radic;'],$striped_opt);
						$plain_opt=Quiz::makePlain($plain_opt);
						if(Quiz::isCorrect($striped_opt))
						{
							$ans['opt_serial']=$ans_range[$opt_sl];
							//$data['correct_ans']=$ans_range[$opt_sl];
							$data['correct_ans']=$plain_opt;
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

	function get_live_model_test($uid)
	{
		$all_tests=ModelQuizSummery::where('user_id',$uid)->select('test_id')->get();

		$all_test_ids=[];

		foreach($all_tests as $test){

			array_push($all_test_ids, $test->test_id);

		}

		$modeltests=ModelTest::where('type', 55)->where('display',1)->orderBy('id','DESC')->get()->toArray();
		if($modeltests){

			$data=[];

			foreach($modeltests as $row){

				$row['attended']=0;
				if(in_array($row['id'], $all_test_ids)) $row['attended']=1;

				array_push($data, $row);

			}

			return ['msg'=>1,'modeltests'=>$data];
		}
		else
		{
			return ['msg'=>0];
		}
	}

	function get_model_test($cat_id,$uid=5)
	{
		$modeltests=ModelTest::where('type',1)->where('display',1)->where('category',$cat_id)->orderBy('id','DESC')->get();
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

	function get_mistake_ques($uid)
	{
		$expired=Member::isExpired($uid);
		$member=Member::getMember($uid);
		$mques=MistakeList::where('user_id',$uid)->orderBy('last_attempt_date','desc')->get();
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
			// ->orderBy('last_attempt_date','desc')
			->get(array('id','exam_name','subject','chapter','question','hints','options','has_paragraph'));
			if($test_ques)
			{
				$test_ques_arr=$this->question_process($test_ques);
				
				
				return ['msg'=>1,'test_ques'=>$test_ques_arr,
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

	function get_review_ques($uid)
	{
		$expired=Member::isExpired($uid);
		$member=Member::getMember($uid);
		$mques=ReviewList::where('user_id',$uid)->get();
		
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
			// ->orderByRaw(DB::raw("FIELD(id, {$ids})"))
			->orderBy('id','desc')
			->get(array('id','exam_name','subject','chapter','question','hints','options','has_paragraph'));
			if($test_ques)
			{
				$test_ques_arr=$this->question_process($test_ques);
				
				
				return ['msg'=>1,'test_ques'=>$test_ques_arr,
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
		$ExamTopic = Reftext::where('group_id',2)->orderBy('exam_serial','asc')->get($fields);
		foreach ($ExamTopic as $key => $value) {
			$price_data = DB::table('category_price')->where('category_id', $value->id)->first();
			if($price_data){
				$price = $price_data->price;
			}else{
				$price = null;
			}
			$result[] = array(
				'id' => $value->id,
				'name' => $value->name,
				'price' => $price
			);
		}
		
		return ['topicName'=>$result];
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

	function savePrevTest(){

		$uid=Input::get('user');
		$exam_id=Input::get('exam_id');
		//$quiz_id=Input::get('quiz_id');
		$today=Input::get('exam_date');
		$time_taken=Input::get('time_taken');
		$total_correct=Input::get('total_correct');
		$total_wrong=Input::get('total_wrong');

		$data_summery=array(
			'user_id'=>$uid,
			'exam_id'=>$exam_id,
			//'quiz_id'=>$quiz_id,
			'exam_date'=>$today,
			'time_taken'=>$time_taken,
			'total_correct'=>$total_correct,
			'total_wrong'=>$total_wrong);

		AnswerSummery::create($data_summery);
		return ['Previous_Test_Summary'=>$data_summery,'msg'=>'successfull'];
	}

	function savePrevTestDetails(){

		$json = Input::json()->all();
		print_r($json);

		// $data = json_decode($json);
		// ModelQuiz::create($data);
		$data_summery=array();
		foreach ($json as $key => $value) {
			$uid = $json[$key]['user'];
			$exam_id = $json[$key]['exam_id'];
			$qid=$json[$key]['question_id'];
			$ans=$json[$key]['answer'];
			$correct_ans=$json[$key]['correct_ans'];
			$exam_date=$json[$key]['exam_date'];
		//	$quiz_id=$json[$key]['quiz_id'];

			/*$data_summery=array(
				'user_id'=>$uid,
				'exam_id'=>$exam_id,
				'question_id'=>$qid,
				'answer'=>$ans,
				'correct_ans'=>$correct_ans,
				'exam_date'=>$exam_date
				//'quiz_id'=>$quiz_id,
			//	'exam_date'=>$exam_date
				//'taken_time'=>$time_taken
				);*/

			$data = new AnswerDetail;
			$data->user_id = $uid;
			$data->exam_id = $exam_id;
			$data->question_id = $qid;
			$data->answer = $ans;
			$data->correct_ans = $correct_ans;
			$data->exam_date = $exam_date;
			$data->save();

			//AnswerDetail::create($data_summery);
		}
		
		//$time_taken=$json[0]['timetaken'];

		/*if($data_summery)
		return ['msg'=>'successfull'];
	else return 0;*/
	}


	function saveModelQuiz(){
		$uid=Input::get('user');
		$test_id=Input::get('test_id');
		//$quiz_id=Input::get('quiz_id');
		$today=Input::get('quiz_date');
		$time_taken=Input::get('timetaken');
		$total_correct=Input::get('total_correct');
		$total_wrong=Input::get('total_wrong');

		$data_summery=array(
			'user_id'=>$uid,
			'test_id'=>$test_id,
			//'quiz_id'=>$quiz_id,
			'quiz_date'=>$today,
			'time_taken'=>$time_taken,
			'total_correct'=>$total_correct,
			'total_wrong'=>$total_wrong);

		ModelQuizSummery::create($data_summery);

		return ['result'=>$data_summery,'msg'=>'successfull'];
	}
	function saveModelQuizDetails(){

		$json = Input::json()->all();
		//$data = json_decode($json);
		//ModelQuiz::create($data);
		$time = time();
		foreach ($json as $key => $value) {
			$uid = $json[$key]['user'];
			$test_id = $json[$key]['test_id'];
			$qid=$json[$key]['qid'];
			$ans=$json[$key]['ans'];
			$correct_ans=$json[$key]['correct_ans'];
			$quiz_id=$time.'_'.$test_id.'_'.$uid;

			$data_summery=array(
				'user_id'=>$uid,
				'test_id'=>$test_id,
				'qid'=>$qid,
				'ans'=>$ans,
				'correct_ans'=>$correct_ans,
				'quiz_id'=>$quiz_id,
				);

			ModelQuiz::create($data_summery);
		}
				
		return ['msg'=>'successfull'];
		
		/*$validuser = DB::table('users')->where('id', '=', Input::get('user') )->first();
		if ( $validuser == null ) {
		    $Msg = ['msg'=>'Invalid User Attempt!Try Again!'];
		    return json_encode($Msg,JSON_PRETTY_PRINT);
		} else {
		    $data_quize=array(
		        'user_id'       =>  Input::get('user'),
		        'test_id'     	=>  Input::get('test_id'),
		        'quiz_id'       =>  Input::get('quiz_id'),
		        'qid'   		=>  Input::get('qid'),
		        'ans'        	=>  Input::get('ans'),
		        'correct_ans'   =>  Input::get('correct_ans'),
		        //'taken_time'=>$time_taken
		        );

		    $data_summery=array(
		        'user_id'       =>  Input::get('user'),
		        'test_id'     	=>  Input::get('test_id'),
		        'quiz_id'       =>  Input::get('quiz_id'),
		        'quiz_date'     =>  Input::get('quiz_date'),
		        'time_taken'   	=>  Input::get('timetaken'),
		        'total_correct' =>  Input::get('total_correct'),
		        'total_wrong'   =>  Input::get('total_wrong'),
		        //'taken_time'=>$time_taken
		        );

			$get_status = DB::table('model_quiz')->insert($data_quize);
			$get_status = DB::table('model_quiz_summery')->insert($data_summery);
		    if ( $get_status ) {
		        $Msg =  ['msg'=>'Successfull'];
		        return json_encode($Msg,JSON_PRETTY_PRINT);
		    } else {
		        $Msg = ['msg'=>'Unsuccessful Attempt!Try Again!'];
		        return json_encode($Msg,JSON_PRETTY_PRINT);
		    }
		}*/
	}


	function is_locked()
	{
	    $locked=ChapterLockMapping::get(['chapter_id'])
	    ->toArray();
	    $locked=array_fetch( $locked,'chapter_id');
	   return ['lock_chapter'=>$locked];
	   // return in_array($chapter_id,$locked)?'true':'false';
	}
	function is_exam_locked()
	{
		 $locked=ExamLockList::get(['ref_id'])
	    ->toArray();
	    $locked=array_fetch( $locked,'ref_id');
	  	 return ['lock_exam'=>$locked];
	}
	function fetch_expiredate($user_id,$mem_type)
	{
		$update_date = User::where('id',$user_id)->pluck('update_date');
		if($mem_type == 3){
			$expired_date = date('Y-m-d h:m:s', strtotime($update_date. ' + 30 days'));
		}
		else if($mem_type == 4){
			$expired_date = date('Y-m-d h:m:s', strtotime($update_date. ' + 120 days'));
		}
		else if($mem_type == 5){
			$expired_date = date('Y-m-d h:m:s', strtotime($update_date. ' + 180 days'));
		}
		else if($mem_type == 6){
			$expired_date = date('Y-m-d h:m:s', strtotime($update_date. ' + 365 days'));
		}
		else if($mem_type == 7){
			$expired_date = date('Y-m-d h:m:s', strtotime($update_date. ' + 7 days'));
		}
		else if($mem_type == 8){
			$expired_date = date('Y-m-d h:m:s', strtotime($update_date. ' + 60 days'));
		}
		else if($mem_type==10)
		{
			$req=UpgradeRequest::where('user_id',$user_id)->first();
			$expired_date=	date('Y-m-d h:m:s', strtotime($req->exp_date));
		}
		return ['expired_date'=>$expired_date];
	}
	function insert_mistakelist(){


		$json = $_POST;
		//var_dump($json['user_id'],true); 		
		if(isset($json['user_id'])) {

			//var_dump($json, true); die;
		foreach ($json['user_id'] as $key => $value) {
				$uid = $value;
				$qid= $json['qid'][$key];
				$last_attempt_date= Carbon\Carbon::now();		
				$affectedRows = MistakeList::create(array('user_id' => $uid,'qid' => $qid,'last_attempt_date' => $last_attempt_date));
				
		}

			return ['msg'=>'successfull'];
		}
		
		return ['msg'=>'failed'];
	}

	function delete_mistakelist(){
		$json = Input::json()->all();
		$sl = 0;
		//dd($json);
		foreach ($json as $key => $value) {
			$sl = $key+1;
			$uid = $json[$key]['user_id'];
			$qid=$json[$key]['qid'];

			$mistake_count=MistakeList::where('user_id',$uid)->where('qid',$qid)->count();
			if($mistake_count>0)
			{
				MistakeList::where('user_id',$uid)->where('qid',$qid)->delete();
			}
		}
		if(count($json) == $sl){
			return ['msg'=>'successfull'];
		}else{
			return ['msg'=>'unsuccessfull'];
		}
	}

	function insert_reviewlist(){
		$json = Input::json()->all();
		foreach ($json as $key => $value) {
			$uid = $json[$key]['user_id'];
			$qid=$json[$key]['qid'];
			
			$review_count=ReviewList::where('user_id',$uid)->where('qid',$qid)->count();

			if($review_count==0)
			{
				$affectedRows = ReviewList::create(array('user_id' => $uid,'qid' => $qid));
			}
		}
		return ['msg'=>'successfull'];
	}

	function delete_mistake_n_review_list($uid,$type){

		$mistake_count=MistakeList::where('user_id',$uid)->count();

		$review_count=ReviewList::where('user_id',$uid)->count();
		if($mistake_count>0 && $type=='mistake')
		{
			$affectedRows = MistakeList::where('user_id', '=', $uid)->delete();
			return ['msg'=> 'successfull'];
		}
		else if($review_count>0 && $type=='review')
		{
			$affectedRows = ReviewList::where('user_id', '=', $uid)->delete();
			return ['msg'=> 'successfull'];
		}

	}

	function delete_mistake_n_review_list_category($uid,$type,$category){

		$mistake_count=MistakeList::where('user_id',$uid)->count();

		$review_count=ReviewList::where('user_id',$uid)->count();
		if($mistake_count>0 && $type=='mistake')
		{
			$mques=\DB::select("SELECT pm.qid FROM question_bank qb JOIN practice_mistake pm ON qb.id = pm.qid WHERE user_id ={$uid} AND qb.subject IN (SELECT id FROM ref_text WHERE parent_id = {$category} AND group_id = 3) order by pm.last_attempt_date desc");
			$ques=[];
			if($mques)
			{
				foreach ($mques as $q) {
					array_push($ques,$q->qid);
				}
			}
			$affectedRows = MistakeList::where('user_id', '=', $uid)->whereIn('qid',$ques)->delete();
			return ['msg'=> 'successfull'];
		}
		else if($review_count>0 && $type=='review')
		{
			$mques=\DB::select("SELECT pm.qid FROM question_bank qb JOIN ans_review_list pm ON qb.id = pm.qid WHERE user_id ={$uid} AND qb.subject IN (SELECT rtxt.id FROM ref_text rtxt WHERE rtxt.parent_id = {$category} AND rtxt.group_id = 3) order by pm.id desc");

			$ques=[];
			if($mques)
			{
				foreach ($mques as $q) {
					array_push($ques,$q->qid);
				}
			}

			$affectedRows = ReviewList::where('user_id', '=', $uid)->whereIn('qid',$ques)->delete();
			return ['msg'=> 'successfull'];
		}

	}


	function get_mistake_list_by_category($uid,$category)
	{
		$expired=Member::isExpired($uid);
		$member=Member::getMember($uid);
		// $mques=MistakeList::where('user_id',$uid)->orderBy('last_attempt_date','desc')->get();
		$mques=\DB::select("SELECT pm.qid FROM question_bank qb JOIN practice_mistake pm ON qb.id = pm.qid WHERE user_id ={$uid} AND qb.subject IN (SELECT id FROM ref_text WHERE parent_id = {$category} AND group_id = 3) order by pm.last_attempt_date desc");
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
			// ->orderBy('last_attempt_date','desc')
			->get(array('id','exam_name','subject','chapter','question','hints','options','has_paragraph'));
			if($test_ques)
			{
				$test_ques_arr=$this->question_process($test_ques);
				
				
				return ['msg'=>1,'test_ques'=>$test_ques_arr,
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

	function get_review_list_by_category($uid,$category)
	{
		$expired=Member::isExpired($uid);
		$member=Member::getMember($uid);
		$mques=\DB::select("SELECT pm.qid FROM question_bank qb JOIN ans_review_list pm ON qb.id = pm.qid WHERE user_id ={$uid} AND qb.subject IN (SELECT rtxt.id FROM ref_text rtxt WHERE rtxt.parent_id = {$category} AND rtxt.group_id = 3) order by pm.id desc");

		//$mques=ReviewList::where('user_id',$uid)->get();
		
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
			// ->orderByRaw(DB::raw("FIELD(id, {$ids})"))
			->orderBy('id','desc')
			->get(array('id','exam_name','subject','chapter','question','hints','options','has_paragraph'));
			if($test_ques)
			{
				$test_ques_arr=$this->question_process($test_ques);
				
				
				return ['msg'=>1,'test_ques'=>$test_ques_arr,
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

	public function get_user_model_test_stat($uid){

		//$quiz=$this->model_quiz_summery_model->find_user_quiz($this->userid);

		/*$this->db->where('user_id',$uid);
		$this->db->order_by('quiz_date','desc');
		$quiz=$this->db->get('model_quiz_summery');*/
		$quiz=ModelQuizSummery::where('user_id',$uid)->orderBy('quiz_date','desc')->get();
		$final_array=array();
		if(count($quiz)>0)
		{
			//$str = '';
			foreach($quiz as $q)
			{
				$model_test=ModelTest::find($q->test_id);
				if($model_test->type == 1){
					$model_test_name= $model_test->name;
					$total_marks=$model_test->total_ques;
					//$your_top=$this->model_quiz_summery_model->user_top_correct($this->userid,$q->test_id);
					//$top_score=$this->model_quiz_summery_model->top_score($q->test_id);
					$your_top=ModelQuizSummery::where('test_id',$q->test_id)->where('user_id',$uid)->orderBy('total_correct','desc')->first();
					$top_score=ModelQuizSummery::where('test_id',$q->test_id)->orderBy('total_correct','desc')->first();
					$score=$q->total_correct-(.25*$q->total_wrong);
					$percentage = ($score/$total_marks)*100;
					if($percentage<0)
						$percentage=0;
					$dt=date_create($q->quiz_date);
					$dtf=date_format($dt,'d F, Y H:i A');
					$final_array[]= array(
						'model_test_name' => $model_test_name,
						'id' => $q->id,
						'user_id'=>$uid,
						'test_id'=>$q->test_id,
						'quiz_date'=>$dtf,
						'time_taken'=>gmdate('H:i:s',$q->time_taken),
						'total_correct'=>$q->total_correct,
						'total_wrong'=>$q->total_wrong,
						'score' => $score,
						'percentage'=>$percentage,
						'total_marks'=>$total_marks

					);
				}
				/*$str ="<tr>";
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
				//$str.="<td><a class='btn btn-info' href='".url()."member/model_quiz_progress/show/{$q->quiz_id}''>";
				//$str.="<i class='fa fa-eye'></i> View All</a></td>";
				$str.="</tr>";*/
			}
			
		}

		$doomed_array=array('ModelTest_Stat'=>$final_array);
		return $doomed_array;
	}
	public function get_user_prev_test_stat($uid){

		$result = AnswerSummery::where('user_id',$uid)->orderBy('id','desc')->get();
		$data = array();
		if(count($result)>0){
			foreach ($result as $key => $value) {
				$exam = Exam::find($value->exam_id);
				$percentage= ($value->total_correct-$value->total_wrong)*100/$value->total_question;
				$data[] = array(
					'id' => $value->id,
					'exam_name' => $exam->test_name,
					'exam_date' => $value->exam_date,
					'total_question' => $value->total_question,
					'total_correct' => $value->total_correct,
					'total_wrong' => $value->total_wrong,
					'percentage' =>$percentage,
					'time_taken' =>$value->time_taken
				);
			}

			$final_array = array('previous_test_stat'=>$data);
            return $final_array;

		}else{
			$final_array = array('previous_test_stat'=>$data);
            return $final_array;
		}
	}


}