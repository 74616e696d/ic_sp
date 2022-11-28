<?php
// use DB;  
class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

	public function get_important_facts(){
		$test= StudyHint::orderByRaw('RAND()')->take(5)->get();
		$final_array = array('important_facts'=>$test);
        return $final_array;
	}

	public function get_on_this_day(){
		$test=Today::whereMonth('happening_date','=',date('m'))->whereDay('happening_date','=', date('d'))->get();
		$final_array = array('on_this_day'=>$test);
        return $final_array;
	}

	public function get_job_circular(){
        $today = date('Y-m-d 00:00:00',time());
		$jobs = Job::where('deadline','>=',$today)->orderBy('id','desc')->limit(5)->get();
		foreach($jobs as $job)
      	{
        	$company=Company::find($job->com_info);
        	$category=JobCat::find($job->job_cat);
        	$job_details[]=array(
                        'id'=>$job->id,
                        'title'=>$job->title,
                        'job_category'=>$category->title,
                        'company'=>$company->company_name,
                        'post_name'=>$job->post_name,
                        'education_requirement'=>$job->education,
                        'experience'=>$job->experience,
                        'gender_requirement'=>$job->gender_requirement,
                        'deadline'=>$job->deadline,
                        'vacancy_no'=>$job->vacancy_no,
                        'job_responsibility'=>$job->job_responsibility,
                        'job_nature'=>$job->job_nature,
                        'job_requirements'=>$job->job_requirements,
                        'experience_requirement_details'=>$job->experience_requirement_details,
                        'aditional_job_requirement'=>$job->aditional_job_requirement,
                        'job_location'=>$job->job_location,
                        'salary_range'=>$job->salary_range,
                        'other_benefits'=>$job->other_benefits,
                        'job_source'=>$job->job_source,
                        'publish_date'=>$job->publish_date,
                        'apply_instructions'=>$job->apply_instructions,
                        'location'=>$job->location,
                      );
      	}
      	$final_array = array('job_circular'=>$job_details);
        return $final_array;
	}
    public function get_all_category_price(){
        $categories     =   Reftext::where('group_id',2)->where('display',1)->get();
        foreach($categories as $category){
            $cat_price  =   CategoryPrice::where('category_id',$category->id)->first();
            $cat_details[]=array(
                            'id'=>$category->id,
                            'name'=>$category->name,
                            'price'=>$cat_price->price,
                        );
        }
        $final_array = array('category_details'=>$cat_details);
        return $final_array;
    }

    public function user_course_enrollment_check($user_id,$course_id){
        $data = CourseEnrollmentRequest::where('is_approved',1)->where('user_id',$user_id)->where('course_id',$course_id)->whereDate('expire_date','>=', date('Y-m-d') )->get();
        if(count($data)>0){
            return "Yes";
        } else {
            return "No";
        }
    }
    public function get_user_todays_course_content($user_id,$course_id){
    	$enrollment_check=CourseEnrollmentRequest::where('user_id',$user_id)->where('course_id',$course_id)->first();
    	$today = date('Y-m-d',time());
    	$enroll_date = $enrollment_check->approve_date;
    	$diff = abs(strtotime($today) - strtotime($enroll_date));
    	$class_serial = ($diff/(60*60*24))+1;
        $chapters = CourseContent::where('course_id',$course_id)->pluck('chapters');
        $chapter_ids= explode(',', $chapters);
        foreach ($chapter_ids as $key => $value) {
            $chap_details = RefDetails::where('ref_id',$value)->get();
            $ref_text = Reftext::where('id',$value)->first();
            foreach($chap_details as $chap){
                $chapter_details[]=array(
                            'chapter_id'=>$value,
                            'chapter_name'=>$ref_text->name,
                            'hot_tips'=>$chap->hot_tips,
                            'details'=>$chap->details,
                        );
            }
        }
        /*foreach ($model_test_ids as $m_test) {
            $model_test_ques= ModelTestQues::select('qid')->where('test_id',$m_test)->get();
            $model_test_details = ModelTest::find($m_test);
            foreach($model_test_ques as $mq){
            	$ques[] = Question::where('id',$mq->qid)->get();
            }
            $model_test_array [] = array(
            	'model_test_id'=>$model_test_details->id,
            	'model_test_name'=>$model_test_details->name,
                'model_test_questions'=>$ques
            );
        }*/
        
        $final_array = array('chapter_details'=>$chapter_details);
        return $final_array;
    }
    public function get_user_todays_model_test_questions($user_id,$course_id){
    	$enrollment_check=CourseEnrollmentRequest::where('user_id',$user_id)->where('course_id',$course_id)->first();
    	$today = date('Y-m-d',time());
    	$enroll_date = $enrollment_check->approve_date;
    	$diff = abs(strtotime($today) - strtotime($enroll_date));
    	$class_serial = ($diff/(60*60*24))+1;
    	$model_tests = CourseContent::where('course_id',$course_id)->pluck('model_test_id');
        $model_test_ids = explode(',', $model_tests);
        foreach ($model_test_ids as $m_test) {
            $model_test_ques= ModelTestQues::select('qid')->where('test_id',$m_test)->get();
            $model_test_details = ModelTest::find($m_test);
            foreach($model_test_ques as $mq){
            	$ques[] = Question::where('id',$mq->qid)->get();
            }
            $model_test_array [] = array(
            	'model_test_id'=>$model_test_details->id,
            	'model_test_name'=>$model_test_details->name,
                'model_test_questions'=>$ques
            );
        }
        $final_array = array('model_test_details'=>$model_test_array);
        return $final_array;
    }
    public function get_user_enrolled_courses($user_id){
    	$data = CourseEnrollmentRequest::where('is_approved',1)->where('user_id',$user_id)->whereDate('expire_date','>=', date('Y-m-d') )->get();
        $enrolled_course_details='';
        if(count($data)>0){
            date_default_timezone_set("Asia/Dhaka");
            $yesterday=date('Y-m-d',strtotime('-1 day'));
            $yestarday_top_score=0;
            $user_total_correct=0;
            $user_total_wrong =0;
            $enrolled_course_details='';
            $yestarday_top_scorer_name="N/A";
            $courses = CourseEnrollmentRequest::where('is_approved',1)->where('user_id',$user_id)->whereDate('expire_date','>=', date('Y-m-d') )->get();
            foreach ($courses as $course) {
                $m_tests = CourseContent::where('course_id',$course->course_id)->pluck('model_test_id');
                $cour_details = Course::where('id',$course->course_id)->first();
                $course_wise_model_tests=explode(",",$m_tests);
                foreach ($course_wise_model_tests as $value) {
                    $m_details = ModelTest::find($value);
                    $test_result=DB::table('model_quiz_summery')
                        ->select(['test_id', DB::raw('MAX(total_correct) AS max_correct')])
                        ->where('test_id', '=', $value)
                        ->whereDate('quiz_date', '=', $yesterday)
                        ->first();
                    if($test_result->max_correct == ''){
                        $yestarday_top_score = 0;
                    } else{
                        $yestarday_top_score = $test_result->max_correct;
                        $user_info = User::find($test_result->user_id);
                        $yestarday_top_scorer_name=$user_info->user_name;
                    }

                    $user_test_correct=DB::table('model_quiz_summery')
                        ->select(['test_id', DB::raw('MAX(total_correct) AS user_max_correct')])
                        ->where('user_id', '=', $user_id)
                        ->where('test_id', '=', $value)
                        ->whereDate('quiz_date', '=', $yesterday)
                        ->first();
                    if($user_test_correct->user_max_correct == ''){
                        $user_total_correct = 0;
                    } else{
                        $user_total_correct = $user_test_correct->user_max_correct;
                    }

                    $user_test_wrong=ModelQuizSummery::where('user_id', '=', $user_id)->where('test_id', '=', $value)->whereDate('quiz_date', '=', $yesterday)->first();
                    
                    if($user_test_wrong){
                        $user_total_wrong = $user_test_wrong->total_wrong;
                    } else{
                        $user_total_wrong = 0;
                    }
                    $user_total=$user_total_correct-(0.25*$user_total_wrong);
                    $course_wise_model_test_result[]=array(
                                                      'course_id'=>$cour_details->id,
                                                      'course_name'=>$cour_details->title,
                                                      'model_test_name'=>$m_details->name,
                                                      'top_score'=>$yestarday_top_score,
                                                      'yestarday_top_scorer_name'=>$yestarday_top_scorer_name,
                                                      'your_score'=>$user_total
                                                    );
                    
                }
                
                $enrollment_check=CourseEnrollmentRequest::where('user_id',$user_id)->where('course_id',$course->course_id)->first();
	            $today = date('Y-m-d',time());
	            $enroll_date = $enrollment_check->approve_date;
                $enroll_expire= $enrollment_check->expire_date;
	            $diff = abs(strtotime($today) - strtotime($enroll_date));
	            $class_serial = ($diff/(60*60*24))+1;
	            $chapters = CourseContent::where('course_id',$course->course_id)->where('class_serial',$class_serial)->pluck('chapters');
	            $chapter_ids= explode(',', $chapters);
	            foreach ($chapter_ids as $key => $value) {
	                $chap_details = RefDetails::where('ref_id',$value)->get();
	                $ref_text = Reftext::where('id',$value)->first();
	                foreach($chap_details as $chap){
                        $chapter = Reftext::where('id',$chap->id)->first();
	                    $chapter_details[]=array(
	                                'chapter_id'=>$value,
	                                'chapter_name'=>$chapter->name
	                            );
	                }
	            }
                //dd($chapter_details);
	            $model_tests = CourseContent::where('course_id',$course->course_id)->where('class_serial',$class_serial)->pluck('model_test_id');
	            $model_test_ids = explode(',', $model_tests);
	            foreach ($model_test_ids as $m_test) {
	                $model_test_ques= ModelTestQues::select('qid')->where('test_id',$m_test)->get();
	                $model_test_details = ModelTest::find($m_test);
	                foreach($model_test_ques as $mq){
	                    $ques[] = Question::where('id',$mq->qid)->get();
	                }
                    if($model_test_details){
                        $model_test_array [] = array(
                            'model_test_id'=>$model_test_details->id,
                            'model_test_name'=>$model_test_details->name,
                            'model_test_total_ques'=>$model_test_details->total_ques,
                            'model_test_time'=>$model_test_details->time
                        ); 
                    }else{
                        $model_test_array = array();
                    }
	            }

	            $enrolled_course_details[]=array(
                        'course_id' => $cour_details->id,
                        'course_name'=>$cour_details->title,
                        'chapter_details'=>$chapter_details,
                        'model_test_array'=>$model_test_array,
                        'course_wise_model_test_result'=>$course_wise_model_test_result,
                        'course_enroll_date'=>$enroll_date,
                        'today_days'=>$class_serial,
                        'expire_date'=>$enroll_expire

                    );
            }

            
            
            $encourses = CourseEnrollmentRequest::where('is_approved',1)->where('user_id',$user_id)->whereDate('expire_date','>=', date('Y-m-d') )->get();

        	$final_array = array('enrollment_message'=>'yes','enrolled_course_details'=>$enrolled_course_details);
        	return $final_array;
        } else {
        	$final_array = array('enrollment_message'=>'no','enrolled_course_details'=>$enrolled_course_details);
        	return $final_array;
        }
    }

    public function get_user_enrolled_courses_result($user_id){
    	date_default_timezone_set("Asia/Dhaka");
    	$yesterday=date('Y-m-d',strtotime('-1 day'));
    	$yestarday_top_score=0;
    	$user_total_correct=0;
    	$user_total_wrong =0;
    	$courses = CourseEnrollmentRequest::where('is_approved',1)->where('user_id',$user_id)->whereDate('expire_date','>=', date('Y-m-d') )->get();
    	foreach ($courses as $course) {
    		$m_tests = CourseContent::where('course_id',$course->course_id)->pluck('model_test_id');
    		$cour_details = Course::where('id',$course->course_id)->first();
    		$course_wise_model_tests=explode(",",$m_tests);
    		foreach ($course_wise_model_tests as $value) {
    			$m_details = ModelTest::find($value);
    			$test_result=DB::table('model_quiz_summery')
				    ->select(['test_id', DB::raw('MAX(total_correct) AS max_correct')])
				    ->where('test_id', '=', $value)
				    ->whereDate('quiz_date', '=', $yesterday)
				    ->first();
				if($test_result->max_correct == ''){
					$yestarday_top_score = 0;
				} else{
					$yestarday_top_score = $test_result->max_correct;
				}

				$user_test_correct=DB::table('model_quiz_summery')
				    ->select(['test_id', DB::raw('MAX(total_correct) AS user_max_correct')])
				    ->where('user_id', '=', $user_id)
				    ->where('test_id', '=', $value)
				    ->whereDate('quiz_date', '=', $yesterday)
				    ->first();
				if($user_test_correct->user_max_correct == ''){
					$user_total_correct = 0;
				} else{
					$user_total_correct = $user_test_correct->user_max_correct;
				}

				$user_test_wrong=ModelQuizSummery::where('user_id', '=', $user_id)->where('test_id', '=', $value)->whereDate('quiz_date', '=', $yesterday)->first();
				
				if($user_test_wrong){
					$user_total_wrong = $user_test_wrong->total_wrong;
				} else{
					$user_total_wrong = 0;
				}
				$user_total=$user_total_correct-(0.25*$user_total_wrong);
            	$course_wise_model_test_result[]=array(
                                                  'course_name'=>$cour_details->title,
                                                  'model_test_name'=>$m_details->name,
                                                  'top_score'=>$yestarday_top_score,
                                                  'your_score'=>$user_total
                                                );
    		}
    	}
        $final_array = array('course_wise_model_test_result'=>$course_wise_model_test_result);
        return $final_array;
    }


    public function get_user_progress_report($user_id){
    	$user_batches=Enrollment::where('user_id',$user_id)->get();
    	$user_category=array();
        $cat_rep_array=array();
        $new_array=array();
        $chap_rep_array=array();
        
        if(count($user_batches)!= 0){ 
    		foreach ($user_batches as  $ubatch) {
    			$batches=Batch::where('batch_id',$ubatch->batch_id)->get();
    			foreach ($batches as $key => $batch) {
    				if(!in_array($batch['category_id'], $user_category)){
    					array_push($user_category, $batch['category_id']);
    				}
    			}	
    		}
    		foreach ($user_category as $ucat) {
    			$category_details = Reftext::find($ucat);
    			$category_name=$category_details->name;
    			$subjects = Reftext::where('parent_id',$ucat)->where('group_id',3)->orderBy('serial','asc')->get();
    			$sub_count=count($subjects);
    			$com_sub_count=0;
    			foreach($subjects as $sub){
    				$ttc=Reftext::where('parent_id',$sub->id)->orderBy('serial','asc')->get();
    				$i=0;
    				$data=array();
    				foreach ($ttc as $item) {
    					$count_var=Reftext::where('parent_id',$item->id)->count();
    					$i=$i+$count_var;
    					$su_count=Reftext::where('parent_id',$item->id)->get();
    					foreach ($su_count as $r) {
    						array_push($data,$r->id);
    					}
    				}
    				$total_chaps = $i;
    				$attempted_chapters=ChapterQuizSummery::where('user_id',$user_id)->whereIn('chapter_id',$data)->count();
    				$percentage=($attempted_chapters/$total_chaps)*100;
    				$corrects=DB::table('chapter_quiz_summery')
    						    ->where('user_id',$user_id)
    						    ->whereIn('chapter_id',$data)
    						    ->sum('total_correct');
    	            $marks=$attempted_chapters*20;
    	            $score=$marks!=0?($corrects/$marks)*100:0;
    	            $score=$attempted_chapters==0?0:number_format($score,2);
    	            $new_array[]  =array(
    	                'category_id'=>$ucat,
    	                'category_name'=>$category_name,
    	                'subject_id'=>$sub->id,
    	                'subject_name'=>$sub->name,
    	                'percentage'=>$percentage.'%',
    	                'score'=>$score
    	            );
    	            if($percentage == 100){
    	            	$com_sub_count++;
    	            }
    	            $attempted_chapters_details=ChapterQuizSummery::where('user_id',$user_id)->whereIn('chapter_id',$data)->get();
                       foreach($attempted_chapters_details as $acd){
    	            	$chap_det=Reftext::where('id',$acd->chapter_id)->first();
                       	$chap_name=$chap_det->name;
    	            	$total_qus=$acd->total_correct+$acd->total_wrong;
    	            	$chp_per=($acd->total_correct/$total_qus)*100;
    	            	$chap_rep_array[]=array(
    								'chapter_id'=>$acd->chapter_id,
    	                			'chapter_name'=>$chap_name,
    	                			'total_question'=>$total_qus,
    	                			'total_correct'=>$acd->total_correct,
    	                			'total_wrong'=>$acd->total_wrong,
    	                			'percentage'=>$chp_per.'%',
    	                			'subject_id'=>$sub->id,
    	                			'subject_name'=>$sub->name,
                                    'category_name'=>$category_name,
                                    'category_id'=>$ucat

    							);
    	            }
    			}
    			$per=($com_sub_count/$sub_count*100);
    			$cat_rep_array[]=array(
    								'category_id'=>$ucat,
    	                			'category_name'=>$category_name,
    	                			'total_subject'=>$sub_count,
    	                			'completed_subject'=>$com_sub_count,
    	                			'percentage'=>$per.'%'
    							);
    		}
    		
        }

        $final_array = array('category_progress_report'=>$cat_rep_array,'subject_progress_report'=>$new_array,'chpater_progress_report'=>$chap_rep_array);
            return $final_array;
        
    }

    public function member_details($user_id){
        $user_info = User::find($user_id);
        $user_last_accessed = $user_info->last_accessed;
        if($user_last_accessed > 0){
            $last_accessed = $user_last_accessed;
            $ref_data = Reftext::find($last_accessed);
            $name = $ref_data->name;
            $group_id = $ref_data->group_id;
        }else{
            $last_accessed = null;
            $name = null;
            $group_id = null;
        }
    	$cats_arr=['7','318','713','680','833'];
      	$cats=Reftext::whereIn('id',$cats_arr)->get();
      	$user_batches= Enrollment::where('user_id',$user_id)->get(['batch_id']);
      	$user_category=array();
        $membership_array = array();
        $cur_tym = date('Y-m-d H:m:s',time());
        if(count($user_batches)!= 0){ 
    		foreach ($user_batches as  $ubatch) {
    			$batches=Batch::where('batch_id',$ubatch->batch_id)->where('expire_date','>=',$cur_tym)->get(['category_id']);
    			foreach ($batches as $batch) {
    				if(!in_array($batch->category_id, $user_category)){
    					array_push($user_category, $batch->category_id);
    				}
    			}	
    		}
    		if($cats){
    			if(!empty($user_category)){
    				foreach($cats as $i=>$cat){
    					if(in_array($cat->id,$user_category)){
    						$batch=Batch::where('display',1)->where('category_id',$cat->id)->first();
                            if(count($batch)!= 0){
                                $membership_array[] = array(
                                    'category_id'=>$cat->id,
                                    'name'=>$cat->name,
                                    'batch_id'=>$batch->batch_id,
                                    'batch_name'=>$batch->batch_name,
                                    'membership_expire'=>$batch->expire_date
                                );
                            }

    					}
    				}
    			}
    		}
    		
        }
        $final_array = array(
            'membership_info'       =>$membership_array,
            'last_accessed'         => $last_accessed,
            'name'                  => $name,
            'group_id'              => $group_id
        );
        return $final_array;
    }

    public function last_access_update($user_id,$access){
        $user_info = User::find($user_id);
        $user_info->last_accessed = $access;
        $user_info->update();
        $Msg = ['msg'=>'Successfully Updated'];
        return json_encode($Msg,JSON_PRETTY_PRINT);
    }

    public function get_user_vocabulary_info($user_id){
        $curr_level_query = UserPoint::where('user_id',$user_id)->first();
        $correct_ids = array();
        $incorrect_ids = array();
        if(count($curr_level_query) > 0)
        {
            $curr_level = $curr_level_query->user_level;
            $user_correct   = json_decode($curr_level_query->correct_words,true);
            $user_incorrect = json_decode($curr_level_query->incorrect_words,true);
            $user_point  = $curr_level_query->point;
            $correct_count  = count($user_correct);
            $mistake_count  = count($user_incorrect);
            $user_tried  = count($user_incorrect) + count($user_correct);

            foreach ($user_correct as $key => $value) {
                array_push($correct_ids, $value);
            }
            foreach ($user_incorrect as $key => $value) {
                array_push($incorrect_ids, $value);
            }
        }
        else 
        {
            $curr_level = 1;
            $correct_count  = 0;
            $mistake_count  = 0;
            $user_tried  = 0;
            $user_point  = 0;
        }
        $total_word = Vocabulary::count();

        $result_array = array(
            'user_id' => $user_id,
            'curr_level' => $curr_level,
            'point' => $user_point,
            'total_word' => $total_word,
            'total_correct' => $correct_count,
            'correct_ids' => $correct_ids,
            'total_incorrect' => $mistake_count,
            'incorrect_ids' => $incorrect_ids
        );

        $final_array = array('user_vocabulary_info'=>$result_array);
        return $final_array;
    }

    public function get_user_vocabulary_content($user_id){
        $curr_level_query = UserPoint::where('user_id',$user_id)->first();
        if(count($curr_level_query) > 0)
        {
            $curr_level = $curr_level_query->user_level;
            $user_correct   = json_decode($curr_level_query->correct_words,true);
            $user_incorrect = json_decode($curr_level_query->incorrect_words,true);
            $user_point  = $curr_level_query->point;
            $correct_count  = count($user_correct);
            $mistake_count  = count($user_incorrect);
            $user_tried  = count($user_incorrect) + count($user_correct);
        }
        else 
        {
            $curr_level = 1;
            $user_correct = array();
            $correct_count  = 0;
            $mistake_count  = 0;
            $user_tried  = 0;
            $user_point  = 0;
        }
        $word_all = VocabularyQuestion::whereNotIn('word_id',$user_correct)->get();
        //$word_all = VocabularyQuestion::where('level',$curr_level)->whereNotIn('word_id',$user_correct)->get();
        $total_word = Vocabulary::count();
        //dd($word_all);
        if(!empty($word_all))
        {
            foreach($word_all as $row) {
                $word_id = $row->word_id;
                $word_data     = Vocabulary::find($word_id);
                if(!empty($word_data)){
                    $word = $word_data->word;
                }else{
                    $word = '';
                }
                $level = $row->level;
                $question_id = $row->vocabulary_question_id;
                $question = $row->question;
                $options = $row->options;
                $options_array = explode('///',$options);
                $word_details  = Vocabulary::where('id',$word_id)->get();
                /*foreach($options_array as $opt){
                  if(substr(trim(strip_tags($opt,'<img>')),0,2)=="@@")
                  {
                      $correct =  str_replace("@@",'',trim(strip_tags($opt,'<img>')));
                  }else{
                    $correct = '';
                  }
                }
                $options     = $options_array;*/
                $option_final=array();
                if(!empty($options))
                {
                    //$opt_arr=explode('///',$q->options);
                    $ans_range=range('A','H');
                    $opt_sl=0;
                    foreach ($options_array as $opt) {
                        $striped_opt=strip_tags($opt,'');
                        $plain_opt=Quiz::sanitizeString(['&nbsp;','\n','<sub>','<sup>','&acute','&gt;','&lsquo;','&rsquo;','&mdash;','&#39;','&ndash;','&rdquo;','&hellip;','&ldquo;','&quot;','<u>','</u>','&amp;','</sub>','</sup>','&zwnj;','&times;','&radic;'],$striped_opt);
                        $plain_opt=Quiz::makePlain($plain_opt);
                        if(Quiz::isCorrect($striped_opt))
                        {
                            $ans['opt_serial']=$ans_range[$opt_sl];
                            $correct = $ans_range[$opt_sl];
                            $ans['is_correct']='C';
                            $ans['ans']=$plain_opt;
                            array_push($option_final,$ans);
                        }
                        else
                        {
                            $ans['opt_serial']=$ans_range[$opt_sl];
                            $ans['is_correct']='W';
                            $ans['ans']=$plain_opt;
                            array_push($option_final,$ans);
                        }
                        $opt_sl++;
                    }
                    
                }
                $options = $option_final;

                $word_result[] = array(
                    'word_id' => $word_id,
                    'word' => $word,
                    'level' => $level,
                    'question_id' => $question_id,
                    'question' => $question,
                    'options' => $options,
                    'correct_ans' => $correct,
                    'more_details' => $word_details,
                );
            }
        }else{
            $word_result = array();
        }

        $result_array = array(
            'user_id' => $user_id,
            'curr_level' => $curr_level,
            'point' => $user_point,
            'total_word' => $total_word,
            'total_correct' => $correct_count,
            'total_incorrect' => $mistake_count,
            'available_word' => $word_result
        );

        $final_array = array('user_vocabulary_content'=>$result_array);
        return $final_array;
    }

    function vocabularyinfoSave()
    {
        $json = Input::json()->all();       
        $userid = $json['user_id'];    

        $validuser = DB::table('users')->where('id', '=', $userid )->first();
        if ( $validuser === null ) {
            $Msg = ['msg'=>'Invalid User Attempt!Try Again!'];
            return json_encode($Msg,JSON_PRETTY_PRINT);
        } else {
            $userid             = $json['user_id'];       
            $point              = $json['point'];      
            $user_level         = $json['user_level'];       
            $correct_words      = json_encode($json['correct_words']);
            $incorrect_words    = json_encode($json['incorrect_words']);

            $data_summery=array(
                'user_id'           =>  $userid,
                'correct_words'     =>  $correct_words,
                'incorrect_words'   =>  $incorrect_words,
                'user_level'        =>  $user_level,
                'point'             =>  $point,
                //'taken_time'=>$time_taken
                );

            $user = DB::table('user_point')->where('user_id', '=', $userid)->first();
            if ($user === null) {
                $get_status = DB::table('user_point')->insert($data_summery);
            } else {
                $get_status = DB::table('user_point')->where('user_id',$userid)->update($data_summery);
            }

            if ( $get_status ) {
                $Msg =  ['msg'=>'Successfull'];
                return json_encode($Msg,JSON_PRETTY_PRINT);
            } else {
                $Msg = ['msg'=>'Unsuccessful Attempt!Try Again!'];
                return json_encode($Msg,JSON_PRETTY_PRINT);
            }
        }
        
        
    }


    function categorypriceinfo()
    {
        $categoryprice = DB::table('category_price AS cp')
            ->join('ref_text AS rt', 'rt.id', '=', 'cp.category_id')
            ->select('cp.category_id', 'cp.price AS category_price', 'rt.name AS category_name')
            ->get();
        $formatedData = [ 'category_details',$categoryprice];
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($formatedData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );  
    }
}
