<?php
/**
 * @name        Twitter Bootstrap Message helper
 * @author      Md. Shamsudddoha Majumder(Shamim)
 */

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * display message
 * @param type !function_exists('render_message') 
 * @return string
 */
if(!function_exists('render_message'))
{
	function render_message()
	{
		$ci=& get_instance();
		
		//var_dump($ci->session->flashdata('success'));
		if($ci->session->flashdata('success')){
		echo success_message($ci->session->flashdata('success')); 
		}

		if($ci->session->flashdata('info')){
      	echo info_message($ci->session->flashdata('info'));
      	}

      	if($ci->session->flashdata('warning')){
      	echo warning_message($ci->session->flashdata('warning'));
      	}

      	if($ci->session->flashdata('error')){
        echo error_message($ci->session->flashdata('error'));
    	}
	}
}


if(!function_exists('show_message'))
{
	function show_message()
	{
		$ci=& get_instance();
		if($ci->session->flashdata('success')){
		return success_message($ci->session->flashdata('success')); 
		}

		if($ci->session->flashdata('info')){
      	return info_message($ci->session->flashdata('info'));
      	}

      	if($ci->session->flashdata('warning')){
      	return warning_message($ci->session->flashdata('warning'));
      	}

      	if($ci->session->flashdata('error')){
        return error_message($ci->session->flashdata('error'));
    	}
	}
}

/**
 * display success message
 */
if(!function_exists('success_message'))
{
	function success_message($msg='')
	{
		$str_message='';
		if(!empty($msg)){
		$str_message.='<div class="alert alert-success alert-dismissable">';
    	$str_message.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    	$str_message.="<strong><i class='fa fa-check-circle'></i>&nbsp;&nbsp;{$msg}</strong>";
    	$str_message.='</div>';
		}
		return $str_message;
	}
}

/**
 * display info message
 */
if(!function_exists('info_message'))
{
	function info_message($msg='')
	{
		$str_message='';
		if(!empty($msg)){
			    $str_message.='<div class="alert alert-info alert-dismissable">';
    			$str_message.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    			$str_message.="<strong><i class='fa  fa-info-circle'></i>&nbsp;&nbsp;{$msg}</strong>";
    			$str_message.='</div>';
				}

		return $str_message;
	}
}

/**
 * display warning message
 */
if(!function_exists('warning_message'))
{
	function warning_message($msg='')
	{
		$str_message='';
		if(!empty($msg)){
		 $str_message.='<div class="alert alert-warning alert-dismissable">';
    			$str_message.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    			$str_message.="<strong><i class='fa fa-warning'></i>&nbsp;&nbsp;{$msg}</strong>";
    			$str_message.='</div>';	
		}
	
		return $str_message;
	}
}

/**
 * display error message
 */
if(!function_exists('error_message'))
{
	function error_message($msg='')
	{
		$str_message='';
		if(!empty($msg)){
			
			    $str_message.='<div class="alert alert-danger alert-dismissable">';
    			$str_message.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    			$str_message.="<strong><i class='fa fa-times-circle'></i>&nbsp;&nbsp;{$msg}</strong>";
    			$str_message.='</div>';
				}
		
		return $str_message;
	}
}
if(!function_exists('msg_success'))
{
	function msg_success($msg)
	{
		$msg_str= "<div class='notibar msgsuccess'>";
		$msg_str.="<a class='close'></a>";
		$msg_str.="<p>{$msg}</p>";
		$msg_str.="</div>";
		return $msg_str;
	}
}

if(!function_exists('msg_info'))
{
	function msg_info($msg)
	{
		$msg_str= "<div class='notibar msginfo'>";
		$msg_str.="<a class='close'></a>";
		$msg_str.="<p>{$msg}</p>";
		$msg_str.="</div>";
		return $msg_str;
	}
}

if(!function_exists('ms_gerror'))
{
	function msg_error($msg)
	{
		$msg_str= "<div class='notibar msgerror'>";
		$msg_str.="<a class='close'></a>";
		$msg_str.="<p>{$msg}</p>";
		$msg_str.="</div>";
		return $msg_str;
	}
}

if(!function_exists('msg_alert'))
{
	function msg_alert($msg)
	{
		$msg_str= "<div class='notibar msgalert'>";
		$msg_str.="<a class='close'></a>";
		$msg_str.="<p>{$msg}</p>";
		$msg_str.="</div>";
		return $msg_str;
	}
}