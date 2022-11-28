<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'HomeController::index');
$routes->post('/login', 'AuthController::login');

// Jobs
$routes->get('job/job_list', 'JobsController::index');
$routes->get('job/job_list/cv', 'JobsController::cv');

// News
$routes->get('current_news', 'NewsController::index');
$routes->get('news/all', 'NewsController::all');
$routes->get('news/details/(:segment)/(:num)', 'NewsController::show/$1/$2');

// Pages
$routes->get('about', 'PagesController::about');
$routes->get('faq', 'PagesController::faq');
$routes->get('user_manual', 'PagesController::userManual');

// Forum
$routes->get('forum/posts', 'ForumsController::posts');
$routes->get('forum/posts', 'ForumsController::posts');
$routes->get('forum/replies/(:num)/(:segment)', 'ForumsController::replies/$1');


// Forum
$routes->get('public/guide', 'PublicController::guide');
$routes->get('public/user_reg', 'PublicController::user_reg');
$routes->post('public/user_reg/add', 'PublicController::user_reg_add');

$routes->get('member/dashboard', 'MemberController::dashboard');
$routes->get('member/practice_subject_list', 'MemberPracticeSubjectList::index');
$routes->get('member/take_exam', 'Member\TakeExamController::index');
$routes->get('member/model_test', 'Member\TakeExamController::index');
$routes->get('member/current_world', 'Member\CurrentWorldController::index');
$routes->get('member/mistake_list', 'Member\MistakeListController::index');
$routes->get('member/review_list', 'Member\ReviewListController::index');
$routes->get('member/progress_overview', 'Member\ProgressOverviewController::index');
$routes->get('member/chapter_progress', 'Member\ChapterProgressController::index');
$routes->get('member/model_quiz_progress', 'Member\ModelQuizProgressController::index');
$routes->get('report/strength_report', 'Report\StrengthReportController::index');
$routes->post('report/strength_report', 'Report\StrengthReportController::index');
$routes->get('member/days_hints', 'Member\DaysHintsController::index');

service('auth')->routes($routes);

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
