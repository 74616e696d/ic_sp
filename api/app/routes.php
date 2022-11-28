<?php


// Event::listen('illuminate.query', function($query)
// {
//     var_dump($query);
// });

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('test',function(){
	return Response::json(User::whereRaw('mem_type=3')->take(10)->get(array('user_name','email')));
});

Route::get('test_mail',function(){
	$message = array(
	    'subject' => 'Mail from Iconpreparation',
	    'html' => '<html><body>Email from Iconpreparation by shamim shams</body></html>',
	    'from_email' => 'shamim@revinr.com',
	    'to' => array(array('email'=>'shamim.dhoha@gmail.com'),
	    	array('email'=>'shamim.idb@hotmail.com'))
	);

	$response = Email::messages()->send($message);
});


Route::get('edit_mail',array('as'=>'preview_mail','uses'=>'UserList@edit_mail'));

Route::post('send',array('as'=>'send','uses'=>'UserList@send_email'));

Route::get('userlist',array('as'=>'userlist','uses'=>'UserList@index'));
Route::get('user_email',array('as'=>'user_email','uses'=>'UserList@user_list'));
Route::get('send_email',array('as'=>'send_email','uses'=>'UserList@send_email'));

Route::group(['prefix' => 'api'], function() 
{
	Route::resource('login','LoginController');
	Route::post('reg','LoginController@signup');
	Route::post('fbsignup','LoginController@fbsignup');
	Route::get('users','LoginController@getUser');
	Route::post('auth','LoginController@login');
	Route::get('auth/{username}/{password}','LoginController@loginNormal');
	Route::get('authfb/{username}','LoginController@loginfb');
	Route::get('updateuser/{id}','LoginController@userTypeUpadate');
	Route::resource('question','QuestionController');

	Route::get('project_list','ProjectController@index');
	Route::post('new_project','ProjectController@store');
	Route::get('project/{id}','ProjectController@find_project');

	Route::get('bcs_prev','ExamController@getBcsExam');
	Route::get('all_prev_exam/{exam_id}','ExamController@getAllPrevExam');
	Route::get('get_ques/{exam_name}/{uid}/{mtype}','ExamController@get_question_by_cat');

	Route::get('mtest/{cat_id}/{uid?}','ExamController@get_model_test');
	Route::get('livetest/{uid}','ExamController@get_live_model_test');


	Route::get('mtest_ques/{test_id}/{uid}/{mtype}','ExamController@get_test_ques');
	Route::get('get_test_sheet/{test_id}/{uid}','ExamController@get_test_sheet');
	Route::get('mistake_test/{uid}','ExamController@get_mistake_ques');
	Route::get('mistake/{uid}/{category}','ExamController@get_mistake_list_by_category');
	Route::get('review_test/{uid}','ExamController@get_review_ques');
	Route::get('review/{uid}/{category}','ExamController@get_review_list_by_category');

	Route::get('exam_topic','ExamController@exam_topic');
	Route::post('save_quiz','ExamController@save_quiz');

	Route::post('saveModelQuiz','ExamController@saveModelQuiz');
	Route::post('saveModelQuizDetails','ExamController@saveModelQuizDetails');
	Route::post('savePrevTest','ExamController@savePrevTest');
	Route::post('savePrevTestDetails','ExamController@savePrevTestDetails');

	

	Route::post('save_mistakelist','ExamController@insert_mistakelist');
	Route::post('delete_mistakelist','ExamController@delete_mistakelist');
	Route::post('save_reviewlist','ExamController@insert_reviewlist');
	Route::get('delete_mistk_n_reviw_list/{uid}/{type}','ExamController@delete_mistake_n_review_list');
	Route::get('mistk_n_reviw/delete/{uid}/{type}/{category}','ExamController@delete_mistake_n_review_list_category');

	Route::get('quiz_details/{user}/{testid}/{tm}','ReportController@quiz_details');

	Route::get('psc_prev_exam_type/{user}','PscExamController@get_exam_type');
	Route::get('psc_prev_exam/{user}/{cat}','PscExamController@get_prev_psc');
	Route::get('psc_prev_exam_ques/{user}/{exam_id}','PscExamController@get_prev_question');
	Route::get('psc_subject_list/{user}/{exam_id}','PscExamController@get_subject_list');
	Route::get('psc_chapter_list/{user}/{exam_id}','PscExamController@get_chapter_list');
	Route::get('psc_chapter_question_list/{user}/{chapt_id}','PscExamController@get_chapter_question');

	Route::get('psc_chapter_all_question/{user}/{chapt_id}','PscExamController@get_chapter_all_question');

	Route::get('psc_chapter_details/{user}/{chapt_id}','PscExamController@get_chapter_details');
	Route::post('psc_chapter_quiz','ExamController@savechapQuiz');

	Route::get('current_world','CurrentWorldController@get_hints');
	Route::get('current_world_quiz','CurrentWorldController@current_world_quiz');

	Route::get('current_news_update/{page}','CurrentWorldController@current_news');
	Route::get('getcontentdetails/{id}','CurrentWorldController@getcontentdetails');
	Route::get('courseplan/{id}','CurrentWorldController@courseplan');
	Route::get('courseplandetails/{id}','CurrentWorldController@courseplanDetails');



	Route::get('current_news_category','CurrentWorldController@current_news_category');

	Route::get('current_news_by_tag/{tag_name}/{page}','CurrentWorldController@current_news_by_tag');

	Route::get('current_news_filtered_by_category/{catagory_id}/{page}','CurrentWorldController@current_news_filtered_by_category');
	Route::get('studypress_courses','CurrentWorldController@getcourses');


	Route::get('profile/{uid}','ProfileController@get_profile');

	Route::get('membership','ProfileController@get_membership');
	Route::get('lockCheck','ExamController@is_locked');
	Route::get('lockExam','ExamController@is_exam_locked');
	Route::get('getExpiredate/{user_id}/{mem_type}','ExamController@fetch_expiredate');
	Route::get('course_list','CourseController@get_all_courses');
	Route::get('get_important_facts','HomeController@get_important_facts');
	Route::get('get_on_this_day','HomeController@get_on_this_day');
	Route::get('get_job_circular','HomeController@get_job_circular');
	Route::get('get_all_category_price','HomeController@get_all_category_price');
	Route::get('get_user_todays_course_content/{user_id}/{course_id}','HomeController@get_user_todays_course_content');
	Route::get('user_course_enrollment_check/{user_id}/{course_id}','HomeController@user_course_enrollment_check');

	Route::get('get_user_todays_model_test_questions/{user_id}/{course_id}','HomeController@get_user_todays_model_test_questions');
	Route::get('get_user_enrolled_courses/{user_id}','HomeController@get_user_enrolled_courses');
	Route::get('get_user_enrolled_courses_result/{user_id}','HomeController@get_user_enrolled_courses_result');
	Route::get('get_user_progress_report/{user_id}','HomeController@get_user_progress_report');
	Route::get('get_course_wise_content/{course_id}','CourseController@get_course_content');
	Route::get('member_details/{user_id}','HomeController@member_details');
	Route::get('last_access_update/{user_id}/{access}','HomeController@last_access_update');
	Route::get('get_user_model_test_stat/{user_id}','ExamController@get_user_model_test_stat');
	Route::get('get_user_prev_test_stat/{user_id}','ExamController@get_user_prev_test_stat');

	Route::get('get_user_vocabulary_info/{user_id}','HomeController@get_user_vocabulary_info');
	Route::get('get_user_vocabulary_content/{user_id}','HomeController@get_user_vocabulary_content');
	Route::post('vocabularyinfoSave','HomeController@vocabularyinfoSave');
	Route::get('categorypriceinfo','HomeController@categorypriceinfo');
});
