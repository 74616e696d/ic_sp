<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use Carbon\Carbon;

if(!function_exists('get_message'))
{
	function get_message()
	{
		
		$ci =& get_instance();
		$ci->load->model('user_message_model');
		$messages=$ci->user_message_model->get_user_message($ci->userid);
		$str='';
		if($messages)
		{
			foreach ($messages as $msg) 
			{
				  $publish=new Carbon($msg->publish_date);
				  $diff=$publish->diffForHumans(Carbon::now());
				  $str.="<li>";
                     $str.="<a href='".base_url()."member/message_box/show/{$msg->id}'>";
                        $str.="<div class='pull-left'>";
                          //$str.="<img src='".base_url()."asset/member/img/avatar3.png' class='img-circle' alt='User Image'/>";
                           $str.="<i style='color:#444' class='fa fa-envelope'></i>";
                        $str.="</div>";
                            //$str.="<h4>";   
                                //$str.="<small><i class='fa fa-clock-o'></i>&nbsp;{$diff}</small>";
                           //$str.="</h4>";
                            $str.="<p>{$msg->title}<br><small><i class='fa fa-clock-o'></i>&nbsp;{$diff}</small><br>
                            </p>";
                    $str.="</a>";
                  $str.="</li>";
			}

		}

		return  $str;
	}



	if(!function_exists('message_count'))
	{
		function message_count()
		{
			$ci =& get_instance();
			$ci->load->model('user_message_model');
			//$ci->load->model('upgrade_model');
			$messages=$ci->user_message_model->get_user_message($ci->userid);
			if($messages)
			{
				return count($messages);
			}
			else
			{
				return 0;
			}
		}
	}

	if(!function_exists('all_count'))
	{
		function all_count()
		{
			$ci =& get_instance();
			$ci->load->model('user_message_model');
			$user=$ci->userid;
			$total=$ci->user_message_model->total("where user_id={$user}");
			if($total)
			{
				return $total;
			}
			else
			{
				return 0;
			}
		}
	}

	if(!function_exists('unread_count'))
	{
		function unread_count()
		{
			$ci =& get_instance();
			$ci->load->model('user_message_model');
			$user=$ci->userid;
			$total=$ci->user_message_model->total("where user_id={$user} and is_read=0");
			if($total)
			{
				return $total;
			}
			else
			{
				return 0;
			}
		}
	}

	if(!function_exists('notification_count'))
	{
		function notification_count()
		{
			$ci =& get_instance();
			$ci->load->model('user_message_model');
			$messages=$ci->user_message_model->get_user_notification($ci->userid);
			if($messages)
			{
				return count($messages);
			}
			else
			{
				return 0;
			}
		}
	}

}