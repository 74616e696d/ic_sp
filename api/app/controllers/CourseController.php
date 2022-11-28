<?php

class CourseController extends BaseController {

	public function get_all_courses()
	{
		$deatils = Course::where('display',1)->get();
        $result = array();
        foreach ($deatils as $key => $value) {
            $start_date = $value->start_date;
            $duration = $value->duration;

            $expire =strtotime($start_date)+($duration * 86400);
            $expire_date = date('Y-m-d H:m:s',$expire);
            $cur_tym = date('Y-m-d H:m:s',time());
            if($expire_date >= $cur_tym){
                $result[] = $value;
            }
        }
		$final_array = array('course_list'=>$result);
        return $final_array;
	}

	public function get_course_content($course_id){
		$cour_details = Course::where('id',$course_id)->first();
		$chapters_data = CourseContent::where('course_id',$course_id)->get();
        $chapter_ids = array();
        $day1=array();
        $course_details=array();
        if(count($chapters_data)!= 0){
            foreach ($chapters_data as $chapter) {
                if(count($chapter->chapters) > 1){
                    $temp_ids = explode(',', $chapter->chapters);
                    foreach ($temp_ids as $key => $value) {
                        if(!in_array($value, $chapter_ids)){
                            array_push($chapter_ids, $value);
                            array_push($day1, $chapter->class_serial);
                        }
                    }
                }else{
                    if(!in_array($chapter->chapters, $chapter_ids)){
                        array_push($chapter_ids, $chapter->chapters);
                        array_push($day1, $chapter->class_serial);
                    }
                }
            }
            foreach ($chapter_ids as $key => $value1) {
                $temp_val = explode(',', $value1);
                foreach ($temp_val as $value) {
                    $chap_details = RefDetails::where('ref_id',$value)->get();
                    $ref_text = Reftext::where('id',$value)->first();
                    $val =0;
                    if(array_key_exists($key, $day1)){
                        $val = $day1[$key];
                    }
                    $chapter_details[]=array(
                        'chapter_id'=>$value,
                        'chapter_name'=>$ref_text->name,
                        'day'=>$val
                    );
                }
            }
            $model_tests_data = CourseContent::where('course_id',$course_id)->get();

            $model_test_ids = array();
            foreach ($model_tests_data as $m_test) {
                if(count($m_test->model_test_id) > 1){
                    $temp_m_ids = explode(',', $m_test->model_test_id);
                    foreach ($temp_m_ids as $key => $value) {
                        if(!in_array($value, $model_test_ids)){
                            array_push($model_test_ids, $value);
                        }
                    }
                }else{
                    if(!in_array($m_test->model_test_id, $model_test_ids)){
                        array_push($model_test_ids, $m_test->model_test_id);
                    }
                }
            }
            
            foreach ($model_test_ids as $key1=>$m_test) {
                $model_test_ques= ModelTestQues::select('qid')->where('test_id',$m_test)->get();
                $model_test_details = ModelTest::find($m_test);
                foreach($model_test_ques as $mq){
                    $ques[] = Question::where('id',$mq->qid)->get();
                }
                $val1 =0;
                if(array_key_exists($key1, $day1)){
                    $val1 = $day1[$key1];
                }
                $model_test_array [] = array(
                    'model_test_id'=>$model_test_details->id,
                    'model_test_name'=>$model_test_details->name,
                    'day'=>$val1
                );
            }
            $course_details[]=array(
                'course_id' => $cour_details->id,
                'course_name'=>$cour_details->title,
                'chapter_details'=>$chapter_details,
                'model_test_array'=>$model_test_array,
            );
            
        }

        $final_array = array('course_details'=>$course_details);
            return $final_array;
	}
}