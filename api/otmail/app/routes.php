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

	Route::get('mtest_ques/{test_id}/{uid}/{mtype}','ExamController@get_test_ques');
	Route::get('exam_topic','ExamController@exam_topic');
	Route::post('save_quiz','ExamController@save_quiz');

	Route::post('saveModelQuiz','ExamController@saveModelQuiz');
	Route::post('saveModelQuizDetails','ExamController@saveModelQuizDetails');

	Route::get('quiz_details/{user}/{testid}/{tm}','ReportController@quiz_details');

	Route::get('psc_prev_exam_type/{user}','PscExamController@get_exam_type');
	Route::get('psc_prev_exam/{user}/{cat}','PscExamController@get_prev_psc');
	Route::get('psc_prev_exam_ques/{user}/{exam_id}','PscExamController@get_prev_question');
	Route::get('psc_subject_list/{user}/{exam_id}','PscExamController@get_subject_list');
	Route::get('psc_chapter_list/{user}/{exam_id}','PscExamController@get_chapter_list');
	Route::get('psc_chapter_question_list/{user}/{chapt_id}','PscExamController@get_chapter_question');
	Route::get('psc_chapter_details/{user}/{chapt_id}','PscExamController@get_chapter_details');
	Route::post('psc_chapter_quiz','ExamController@savechapQuiz');

	Route::get('current_world','CurrentWorldController@get_hints');
	Route::get('current_world_quiz','CurrentWorldController@current_world_quiz');

	Route::get('profile/{uid}','ProfileController@get_profile');

	Route::get('membership','ProfileController@get_membership');
	Route::get('lockCheck','ExamController@is_locked');
	Route::get('getExpiredate/{user_id}/{mem_type}','ExamController@fetch_expiredate');
});