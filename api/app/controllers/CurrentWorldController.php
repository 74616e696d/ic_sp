<?php

class CurrentWorldController extends BaseController {

	function current_news($page){
		$fields = ['id','category_id','title','short_desc','details','post_by','post_date','display','tags','feature_img','is_featured'];
		$catagory_field=\CurrentNewsModel::with('fetchcatagory')->where('category_id','!=',11)->skip($page)->take(10)->orderBy('post_date','DESC')->get($fields);

		return Response::json(['catagory_field'=> $catagory_field]);
	}

	function current_news_category(){
		$fields = ['id','name','display'];
		$catagory_field = \CurrentNewsCatagoryModel::get($fields);
		return  Response::json(['catagory_field'=>$catagory_field]);
	}

	function current_news_by_tag($tag_name,$page){

		$fields = ['id','category_id','title','short_desc','details','post_by','post_date','display','tags','is_featured'];
		$where=" FIND_IN_SET('{$tag_name}',tags)";
		$news_by_catagory = \CurrentNewsModel::whereRaw($where)->skip($page)->take(10)->orderBy('post_date','DESC')->get($fields);
		return ['news_by_catagory' => $news_by_catagory];
	}

	function current_news_filtered_by_category($catagory_id,$page){
		$fields = ['id','category_id','title','short_desc','details','post_by','post_date','display','tags','feature_img','is_featured'];
		$news_by_catagory = \CurrentNewsModel::where('category_id',$catagory_id)->skip($page)->take(10)->orderBy('post_date','DESC')->get($fields);
		return ['news_by_catagory' => $news_by_catagory];
	}

	function current_world_quiz()
	{
		$questions=$questions=Question::whereRaw("chapter=315")->where('expired_date','>',Carbon\Carbon::now())->get()->random(20);
		
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
					$data['id']=$ques->id;
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

	function getcourses(){

		$courses['name'] =Array('43rd BCS Preliminary', 'BCS & BANK COMBINED MODEL TEST','Primary School Teacher','Bangladesh Bank AD');

		return $courses;

	}

	function courseplan($id){

		$description='';

		if($id == 1){

		$contents = Roadmap::where('roadmap.display',1)->where('category',115)
		->leftJoin('roadmap_details','roadmap.id','=','roadmap_details.roadmap_id')
		->leftJoin('ref_text','roadmap_details.topics','=','ref_text.id')
		->select('roadmap.id as road_id', 'exam_name','test_id','exam_date','ref_text.name as name','roadmap_details.id as details_id')
		->get();


	
		$course0=[];

		foreach($contents as $content)
		{
			
			//$data['ids']= $content->id;
			array_push($course0,$content->id);


			//$content_details = RoadmapDetails::where();


		}

		$description="<b>BCS</b>
							<p><b>IF YOU</b> HAVE NOT STARTED YOUR PREPARATION, <b>IT&#8217;S TIME<br/></b> &amp; <b>IT&#8217;S THE LAST TIME.</b></p>
							<p>JOIN OUR <b>CRASH PROGRAM</b> &amp; <b>GET READY</b> FOR THE TEST.</p>
		                 			<p><span>5</span><span>0</span> <span>DAYS</span><span>CRASH PROGRAM</span></p>
		                			<p>August 31, 2021 - October 10, 2021</p>";


		$content_details = Roadmap::where('roadmap.display',1)->where('category',115)->get();

		}

		elseif($id==2){

			$description="<b>BCS & BANK COMBINED MODEL TEST</b>
							<p><b>IF YOU</b> HAVE NOT STARTED YOUR PREPARATION, <b>IT&#8217;S TIME<br/></b> &amp; <b>IT&#8217;S THE LAST TIME.</b></p>
							<p>JOIN OUR <b>CRASH PROGRAM</b> &amp; <b>GET READY</b> FOR THE TEST.</p>
		                 			<p><span>6</span><span>0</span> <span>DAYS</span><span> CRASH PROGRAM</span></p>
		                			<p>September 1 - October 30, 2021</p>";

			$contents = Roadmap::where('roadmap.display',1)->where('category',7)->where('exam_name','LIKE','%COMBINED%')
		->leftJoin('roadmap_details','roadmap.id','=','roadmap_details.roadmap_id')
		->leftJoin('ref_text','roadmap_details.topics','=','ref_text.id')
		->select('roadmap.id as road_id', 'exam_name','test_id','exam_date','ref_text.name as name','roadmap_details.id as details_id')
		->get();
	
		$course0=[];

		foreach($contents as $content)
		{
			
			//$data['ids']= $content->id;
			array_push($course0,$content->id);


			//$content_details = RoadmapDetails::where();


		}


		$content_details =Roadmap::where('roadmap.display',1)->where('category',7)->where('exam_name','LIKE','%COMBINED%')->get();

		} 




		/* BCS INCEPTION

		elseif($id==2){

			$description="<b>BCS Crash Course Powered by BCS INCEPTION</b>
							<p><b>IF YOU</b> HAVE NOT STARTED YOUR PREPARATION, <b>IT&#8217;S TIME<br/></b> &amp; <b>IT&#8217;S THE LAST TIME.</b></p>
							<p>JOIN OUR <b>CRASH PROGRAM</b> &amp; <b>GET READY</b> FOR THE TEST.</p>
		                 			<p><span>8</span><span>0</span> <span>DAYS</span><span>CRASH PROGRAM</span></p>
		                			<p>November 1, 2019 - January 10, 2020</p>";

			$contents = Roadmap::where('roadmap.display',1)->where('category',7)->where('exam_name','LIKE','%Inception%')
		->leftJoin('roadmap_details','roadmap.id','=','roadmap_details.roadmap_id')
		->leftJoin('ref_text','roadmap_details.topics','=','ref_text.id')
		->select('roadmap.id as road_id', 'exam_name','test_id','exam_date','ref_text.name as name','roadmap_details.id as details_id')
		->get();
	
		$course0=[];

		foreach($contents as $content)
		{
			
			//$data['ids']= $content->id;
			array_push($course0,$content->id);


			//$content_details = RoadmapDetails::where();


		}


		$content_details =Roadmap::where('roadmap.display',1)->where('category',7)->where('exam_name','LIKE','%Inception%')->get();

		} */

		elseif($id==3){

		$description="<b>Primary School Teacher</b>
							<p><b>IF YOU</b> HAVE NOT STARTED YOUR PREPARATION, <b>IT&#8217;S TIME<br/></b> &amp; <b>IT&#8217;S THE LAST TIME.</b></p>
							<p>JOIN OUR <b>CRASH PROGRAM</b> &amp; <b>GET READY</b> FOR THE TEST.</p>
		                 			<p><span>8</span><span>0</span> <span>DAYS</span><span>CRASH PROGRAM</span></p>
		                			<p>November 1, 2019 - January 10, 2020</p>";	

		$contents = Roadmap::where('roadmap.display',1)->where('category',1587)->where('exam_name','Not LIKE','%2nd Batch%')->where('exam_name','Not LIKE','%3rd Batch%')->where('exam_name','Not LIKE','%Crash Program%')
		->leftJoin('roadmap_details','roadmap.id','=','roadmap_details.roadmap_id')
		->leftJoin('ref_text','roadmap_details.topics','=','ref_text.id')
		->select('roadmap.id as road_id', 'exam_name','test_id','exam_date','ref_text.name as name','roadmap_details.id as details_id')
		->get();
	
		$course0=[];

		foreach($contents as $content)
		{
			
			//$data['ids']= $content->id;
			array_push($course0,$content->id);


			//$content_details = RoadmapDetails::where();


		}


		$content_details = Roadmap::where('roadmap.display',1)->where('category',1587)->where('exam_name','Not LIKE','%2nd Batch%')->where('exam_name','Not LIKE','%3rd Batch%')->where('exam_name','Not LIKE','%Crash Program%')->get();

		}

 elseif($id == 4){
 		$description="<b>Bangladesh Bank Crash Course</b>
							<p><b>IF YOU</b> HAVE NOT STARTED YOUR PREPARATION, <b>IT&#8217;S TIME<br/></b> &amp; <b>IT&#8217;S THE LAST TIME.</b></p>
							<p>JOIN OUR <b>CRASH PROGRAM</b> &amp; <b>GET READY</b> FOR THE TEST.</p>
		                 			<p><span>8</span><span>0</span> <span>DAYS</span><span>CRASH PROGRAM</span></p>
		                			<p>November 1, 2019 - January 10, 2020</p>";

			$contents = Roadmap::where('roadmap.display',1)->where('category',318)->where('exam_name','Not LIKE','%2nd Batch%')->where('exam_name','Not LIKE','%3rd Batch%')->where('exam_name','Not LIKE','%Crash Program%')
		->leftJoin('roadmap_details','roadmap.id','=','roadmap_details.roadmap_id')
		->leftJoin('ref_text','roadmap_details.topics','=','ref_text.id')
		->select('roadmap.id as road_id', 'exam_name','test_id','exam_date','ref_text.name as name','roadmap_details.id as details_id')
		->get();
	
		$course0=[];

		foreach($contents as $content)
		{
			
			//$data['ids']= $content->id;
			array_push($course0,$content->id);


			//$content_details = RoadmapDetails::where();


		}



		$content_details = Roadmap::where('roadmap.display',1)->where('category',318)->where('exam_name','Not LIKE','%2nd Batch%')->where('exam_name','Not LIKE','%3rd Batch%')->where('exam_name','Not LIKE','%Crash Program%')->get();

		}


		else {

			$courses=[];
			$content_details=[];
			$contents =[];
		}

		
		return ['description'=>$description,'bcsDetails'=>$contents, 'day'=>$content_details]; 
	  }

	function getcontentdetails($id)
	{

		$details = RoadmapDetails::where('id',$id)->get();
	//	$details =strip_tags($details);
		return $details;
	}  

	function courseplanDetails($id)
	{
	$content_details = RoadmapDetails::where('roadmap_id',$id)->join('ref_text','roadmap_details.topics','=','ref_text.id')->select('name','topics','roadmap_details.id AS rid', 'roadmap_id')->get();

	return $content_details;

	}
}