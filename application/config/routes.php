<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['default_controller'] = "Index";
//$route['default_controller'] = 'Login';

$route['about']='index/about';
$route['privacypolicy']='index/privacypolicy';
$route['job']='index/news_details';
$route['job/details/:any']='index/news_details';
$route['fbrequest']='index/fb_request';
$route['handle_fbrequest']='index/handle_fb_request';
$route['news'] = "current_news/index";
$route['news/details/:any'] = "current_news/news_details";
$route['news/categorized/:any'] = "current_news/categorized";
$route['news/:any'] = "current_news/news_list";
$route['chapters/:any'] = "index/chapter_list";
$route['faq'] = "index/faq";
$route['offer'] = "public/offer/index";
$route['offer/ateo'] = "public/offer/ateo";
$route['offer/bcs'] = "public/offer/bcs";
$route['offer/ntrca'] = "public/offer/ntrca";
$route['employeer/login'] = "job/employeer/login";
$route['employeer/logout'] = "job/employeer/logout";
$route['employeer/register'] = "job/employeer/register";
$route['employeer/dashboard'] = "job/employeer_dashboard/index";
$route['employeer/jobs'] = "job/posted_jobs/index";
$route['employeer/profile'] = "job/employeer_dashboard/profile";
$route['employeer/job_post'] = "job/employeer_dashboard/new_job";
$route['employeer/save_post'] = "job/employeer_dashboard/store_job";
$route['employeer/update_logo'] = "job/employeer_dashboard/update_logo";
$route['404_override'] = 'notfound';
$route['translate_uri_dashes'] = FALSE;


/* End of file routes.php */
/* Location: ./application/config/routes.php */