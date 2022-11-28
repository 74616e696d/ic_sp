<?php 

use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;

//$ci->session = \Config\Services::session();
  //      $ci->session->start();

if(!function_exists('get_referral_url'))
{
	/**
	 * referral url to redirect after successfully sharing in facebook
	 * @return string
	 */
	function get_referral_url($session)
	{
		//$ci =& get_instance();
		$userid=$session->get('userid');
	    $ref_id=time().'-'.uniqid().'-'.$userid;
	    $link=base_url()."public/user_reg/register/{$ref_id}";
	    return $link;
	}
}

if(!function_exists('is_file_exist'))
{
	/**
	 * check if a file exist from an url
	 * 
	 * @param  string  $url
	 * @return boolean     
	 */
	function is_file_exist($url){
	    $ch = curl_init($url);    
	    curl_setopt($ch, CURLOPT_NOBODY, true);
	    curl_exec($ch);
	    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	    if($code == 200){
	       $status = true;
	    }else{
	      $status = false;
	    }
	    curl_close($ch);
	   return $status;
	}
}

if(!function_exists('date_diff_humans'))
{
	function date_diff_humans($date)
	{
		$dt=new Carbon($date);
		$days=$dt->diffInDays(Carbon::now());
		$diff='';
		if($days==0)
		{
			$hrs=$dt->diffInMinutes(Carbon::now());
			$diff=Carbon::now()->subMinute($hrs)->diffForHumans();
		}
		else
		{
			$diff=Carbon::now()->subDays($days)->diffForHumans();
		}

		return $diff;
		
	}
}

if (!function_exists('get_correct_ans')) {
	/**
	 * Determine whether a answer is correct or not
	 * @param  [type] $str_ans [description]
	 * @return [type]          [description]
	 */

function is_correct_ans($str_ans) {
		$str = $correct = substr(trim(strip_tags($str_ans, '<img>')), 0, 2) == "@@" ? true : false;
		return $str;
	}
}

if (!function_exists('get_bn_num')) {
	function get_bn_num($input) {
		$bn_digits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
		$output    = str_replace(range(0, 9), $bn_digits, $input);
		return $output;
	}
}

if (!function_exists('create_pagination_new')) {

	/**
	 * Codeigniter pagination with twitter bootstrap pagination style
	 * @return [string]
	 */
	function create_pagination_new($baseurl, $total_rows, $uri_segment, $num_link = 3, $perpage = 5) {
		$ci = &get_instance();

		$config['base_url']       = $baseurl;
		$config['total_rows']     = $total_rows;
		$config['uri_segment']    = $uri_segment;
		$config['per_page']       = $perpage;
		$config['num_links']      = $num_link;
		$config['full_tag_open']  = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open']   = '<li>';
		$config['num_tag_close']  = '</li>';
		$config['cur_tag_open']   = '<li class="curr"><a>';
		$config['cur_tag_close']  = '</a></li>';
		$config['prev_link']      = '&lt;';

		$config['prev_tag_open']  = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link']      = '&gt;';

		$config['next_tag_open']   = '<li>';
		$config['next_tag_close']  = '</li>';
		$config['first_tag_open']  = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open']   = '<li>';
		$config['last_tag_close']  = '</li>';
		$ci->pagination->initialize($config);
		$page = $ci->pagination->create_links();
		return $page;
	}
}

if (!function_exists('create_pagination')) {

	/**
	 * Codeigniter pagination with twitter bootstrap pagination style
	 * @return [string]
	 */
	function create_pagination($baseurl, $total_rows, $uri_segment, $num_link = 3, $perpage = 5) {
		$ci = &get_instance();

		$config['base_url']       = $baseurl;
		$config['total_rows']     = $total_rows;
		$config['uri_segment']    = $uri_segment;
		$config['per_page']       = $perpage;
		$config['num_links']      = $num_link;
		$config['full_tag_open']  = '<div class="pagination"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['num_tag_open']   = '<li>';
		$config['num_tag_close']  = '</li>';
		$config['cur_tag_open']   = '<li class="curr"><a>';
		$config['cur_tag_close']  = '</a></li>';
		$config['prev_link']      = '&lt;';

		$config['prev_tag_open']  = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link']      = '&gt;';

		$config['next_tag_open']   = '<li>';
		$config['next_tag_close']  = '</li>';
		$config['first_tag_open']  = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open']   = '<li>';
		$config['last_tag_close']  = '</li>';
		$ci->pagination->initialize($config);
		$page = $ci->pagination->create_links();
		return $page;
	}
}

function bool_status($bool, $yes_text = '', $no_text) {
	$str = '';
	if ($yes_text != '' && $no_text != '') {
		$str = $bool ? $yes_text : $no_text;
	} else {
		$str = $bool ? 'Yes' : 'No';
	}
	return $str;
}

function create_pagination_query_string($baseurl, $total_rows, $uri_segment, $num_link = 3, $perpage = 5, $qstr = false) {
	$ci = &get_instance();

	$config['page_query_string'] = true;
	$config['first_url']         = http_build_query($_GET);
	$config['total_rows']        = $total_rows;
	$config['uri_segment']       = $uri_segment;
	$config['per_page']          = $perpage;
	$config['num_links']         = $num_link;
	$config['full_tag_open']     = '<div class="pagination"><ul>';
	$config['full_tag_close']    = '</ul></div>';
	$config['num_tag_open']      = '<li>';
	$config['num_tag_close']     = '</li>';
	$config['cur_tag_open']      = '<li class="curr"><a>';
	$config['cur_tag_close']     = '</a></li>';
	$config['prev_link']         = '&lt;';

	$config['prev_tag_open']  = '<li>';
	$config['prev_tag_close'] = '</li>';
	$config['next_link']      = '&gt;';

	$config['next_tag_open']   = '<li>';
	$config['next_tag_close']  = '</li>';
	$config['first_tag_open']  = '<li>';
	$config['first_tag_close'] = '</li>';
	$config['last_tag_open']   = '<li>';
	$config['last_tag_close']  = '</li>';
	$ci->pagination->initialize($config);
	$page = $ci->pagination->create_links();
	return $page;
}

function set_old_value($data = array(), $excluded = array(), $session) {
	//$ci = &get_instance();
	foreach ($data as $key => $value) {
		if (!in_array($key, $excluded)) {
			$session->setFlashdata($key, $value);
		}
	}
}

function in_multiarray($elem, $array) {
	$top    = sizeof($array) - 1;
	$bottom = 0;
	while ($bottom <= $top) {
		if ($array[$bottom] == $elem) {
			return true;
		} else
		if (is_array($array[$bottom])) {
			if (in_multiarray($elem, ($array[$bottom]))) {
				return true;
			}
		}

		$bottom++;
	}
	return false;
}

/**
 *retrieve old value from flash data
 * @param  [type] $key [description]
 * @return [type]      [description]
 */
function old_value($key, $session) {
    
	//$ci = &get_instance();
	if ($session->getFlashdata($key)) {

		return $session->getFlashdata($key);
		
	} else {
		return false;
	}
}

if (!function_exists('thumb_img_upload')) {
	function thumb_img_upload($filename) {
		$allowed = array('jpg', 'jpeg', 'png', 'gif');

		if ($_FILES[$filename]["error"] > 0) {
			$error = $_FILES[$filename]['error'];
			return $error;
		} else {
			$path = $_FILES[$filename]['name'];
			$ext  = pathinfo($path, PATHINFO_EXTENSION);
			if (in_array($ext, $allowed)) {
				$img_name = uniqid('ot_') . '.' . $ext;
				$img      = Image::make($_FILES[$filename]['tmp_name']);
				$img->resize(174, 142)->save("asset/images/upload/{$img_name}");
				return $img_name;

			} else {
				return "File extension is not allowed";
			}
		}
	}
}

if (!function_exists('img_upload')) {
	function img_upload($filename,$img_path='asset/images/upload/') {
		$allowed = array('jpg', 'jpeg', 'png', 'gif');

		if ($_FILES[$filename]["error"] > 0) {
			$error = $_FILES[$filename]['error'];
			return $error;
		} else {
			$path = $_FILES[$filename]['name'];
			$ext  = pathinfo($path, PATHINFO_EXTENSION);
			if (in_array($ext, $allowed)) {
				$img_name = uniqid('ot_') . '.' . $ext;
				$img      = Image::make($_FILES[$filename]['tmp_name']);
				//$img->resize(174,142)->save("assets/upload/team/{$img_name}");
				$img->save("{$img_path}{$img_name}");
				return $img_name;

			} else {
				return "File extension is not allowed";
			}
		}
	}

	/**
	 * format date long format
	 * @return [type] [description]
	 */
	function date_long($date)
	{
		$dtf='';
		$dt=date_create($date);
		$dtf=date_format($dt,'d F Y H:i a');
		return $dtf;
	}

		/**
	 * format date short format
	 * @return [type] [description]
	 */
	function date_short($date)
	{
		$dtf='';
		$dt=date_create($date);
		$dtf=date_format($dt,'d M Y');
		return $dtf;
	}
}


if (!function_exists('do_upload')) {
	function do_upload($filename,$path_to_save='asset/images/upload/') {
		$allowed = array('jpg', 'jpeg', 'png', 'gif');

		if ($_FILES[$filename]["error"] > 0) {
			$error = $_FILES[$filename]['error'];
			return $error;
		} else {
			$path = $_FILES[$filename]['name'];
			$ext  = pathinfo($path, PATHINFO_EXTENSION);
			if (in_array($ext, $allowed)) {
				$img_name = uniqid('sp_') . '.' . $ext;
				$img      = Image::make($_FILES[$filename]['tmp_name']);
				$img->save($path_to_save.$img_name);
				return $img_name;

			} else {
				return "";
			}
		}
	}

	/**
	 * upload thumb image for current news landing page
	 * @param  [type] $filename [description]
	 * @param  [type] $save_as  [description]
	 * @return [type]           [description]
	 */
	function news_thumb($save_as)
	{
		if (file_exists('asset/news/'.$save_as)) 
		{
			$img = Image::make('asset/news/'.$save_as);
			$img->fit(222,295);
			$img->save('asset/news/small/'.$save_as);
		} 
	}

	/**
	 * resize image for current news categorized news page
	 * @param  string $filename
	 * @param  string $save_as 
	 * @return void         
	 */
	function news_thumb_square($save_as)
	{
		if (file_exists('asset/news/'.$save_as)) 
		{
			$img = Image::make('asset/news/'.$save_as);
			$img->fit(300, 300);
			$img->save('asset/news/square/'.$save_as);
		} 
	}

	/**
	 * format date long format
	 * @return [type] [description]
	 */
	
	if(!function_exists('date_long')){
		function date_long($date)
		{
			$dtf='';
			$dt=date_create($date);
			$dtf=date_format($dt,'d F Y H:i a');
			return $dtf;
		}
	}

		/**
	 * format date short format
	 * @return [type] [description]
	 */
	if(!function_exists('date_short')){
		function date_short($date)
		{
			$dtf='';
			$dt=date_create($date);
			$dtf=date_format($dt,'d F Y');
			return $dtf;
		}
	}
}


if(!function_exists('is_member'))
{
	/**
	 * detemine loggedin user is member
	 * @return boolean
	 */
	function is_member()
	{
		$utype=['2','3','4','5','6','7','8'];
		$ci =& get_instance();
		$member=false;
		if(in_array($ci->session->userdata('utype'),$utype))
		{
			$member=true;
		}
		return $member;
	}
}

function date_picker($name,$sel='',$class='form-control')
{
	$sel_year=date('Y');
	$sel_month=date('m');
	$sel_date=date('d');
	$str="";
	if(!empty($sel))
	{
		$date=date_create($sel);
		$sel_year=date_format($date,'Y');
		$sel_month=date_format($date,'m');
		$sel_date=date_format($date,'d');
	}
	$str.="<select name='{$name}[]' class='{$class} dt'>";
	
	for ($i=2010; $i <2030 ; $i++) { 
		$selected1=$sel_year==$i?'selected':'';
		$str.="<option {$selected1} value='{$i}'>{$i}</option>";
	}
	$str.="</select>";

	$str.="<select name='{$name}[]' class='{$class} dt'>";
	for ($i=1; $i <13 ; $i++) { 
		$selected2=$sel_month==$i?'selected':'';
		$str.="<option {$selected2} value='{$i}'>{$i}</option>";
	}
	$str.="</select>";

	$str.="<select name='{$name}[]' class='{$class} dt'>";
	for ($i=1; $i <32 ; $i++) { 
		$selected3=$sel_date==$i?'selected':'';
		$str.="<option {$selected3} value='{$i}'>{$i}</option>";
	}
	$str.="</select>";

	return $str;
}

function get_date_picker($name)
{
	$ci =& get_instance();
	$dt=$ci->input->post($name);
	$dt_year=$dt[0];
	$dt_month=$dt[1];
	$dt_date=$dt[2];
	$date = new DateTime("{$dt_year}-{$dt_month}-{$dt_date}");
	$result = $date->format('Y-m-d H:i:s');
	return $result;
}

function date_current_news($date)
{
	$dt=date_create($date);
	return date_format($dt,'d/m/Y');
}

/**
 * formate jquery datepicker value as mysql format
 * @param  string $dt
 * @return string   
 */
function format_jquery_date($dt)
{
	$str_date=$dt;
	$date_arr=explode('-',$dt);
	if(count($date_arr))
	{
		$str_date=$date_arr[2].'-'.$date_arr[1].'-'.$date_arr[0];
	}
	return $str_date;
}