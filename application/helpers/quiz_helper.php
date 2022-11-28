<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

if(!function_exists('str_to_ques_list'))
{
	function str_to_ques_list($ques_str)
	{
		$list=false;
		if(!empty($ques_str))
		{
			$ques_arr=explode(',',trim($ques_str));
			if(count($ques_str)>0)
			{
				$ci =& get_instance();
				$ci->load->model('question_bank_model');
				$list=$ci->question_bank_model->get_questions_in($ques_arr);
			}
		}
		return $list;
	}
}


if(!function_exists('get_plain_ques'))
{
	function get_plain_ques($str_ques,$indx='')
	{
		$ques='';
		$plain=strip_tags($str_ques,"<img>,<b><i><u><sub><sup>");
		$ques="<li class='list-group-item'>{$indx}.&nbsp;&nbsp;{$plain}</li>";
		return $ques;
	}
}

if(!function_exists('get_option_list_plain'))
{
	function get_option_list_plain($str_option)
	{
		$options=explode('///',$str_option);
		$correct='';
		$str='';
		if(count($options)>0)
		{
			$rng_ques=range('A','H');
			$i=0;
			foreach ($options as $opt) {
				$strip_ans=strip_tags(trim($opt),'<img>');
				$ans_plain=make_plain($strip_ans);
				$str.="<li class='list-option'>{$rng_ques[$i]}.&nbsp;{$ans_plain}</li>";
				$i++;
			}
		}
		return $str;
	}
}


if(!function_exists('get_option_list_correct'))
{
	function get_option_list_correct($str_option)
	{
		$options=explode('///',$str_option);
		$correct='';
		$str='';
		if(count($options)>0)
		{
			$rng_ques=range('A','H');
			$i=0;
			foreach ($options as $opt) {
				$strip_ans=trim(strip_tags(trim($opt),'<img>'));
				$correct=substr($strip_ans,0,2)=="@@"?true:false;
				if($correct)
				{
					$ans_plain=str_replace('@@','',trim($opt));
					$str.="<li class='list-option correct'>{$rng_ques[$i]}.&nbsp;{$ans_plain}</li>";
				}
				else
				{
					$str.="<li class='list-option'>{$rng_ques[$i]}.&nbsp;{$strip_ans}</li>";
				}
				
				$i++;
			}
		}
		return $str;
	}
}


if(!function_exists('get_option_list_correct_wrong'))
{
	function get_option_list_correct_wrong($str_option,$given)
	{
		$options=explode('///',$str_option);
		$correct='';
		$str='';
		if(count($options)>0)
		{
			$rng_ques=range('A','H');
			$i=0;
			foreach ($options as $opt) {
				$strip_ans=trim(strip_tags(trim($opt),'<img>'));
				$correct=substr($strip_ans,0,2)=="@@"?true:false;
				$correct_index='';
				if($correct)
				{
					$ans_plain=str_replace('@@','',trim($strip_ans));
					$str.="<li class='list-option correct'><strong>{$rng_ques[$i]}.&nbsp;{$ans_plain}</strong></li>";
				}
				else
				{
					if($given==$rng_ques[$i])
					{
						$str.="<li class='list-option wrong'>{$rng_ques[$i]}.&nbsp;{$strip_ans}</li>";
					}
					else
					{
						$str.="<li class='list-option'>{$rng_ques[$i]}.&nbsp;{$strip_ans}</li>";
					}
				}
				
				$i++;
			}
		}
		return $str;
	}
}



if(!function_exists('is_correct'))
{
	function is_correct($opt)
	{
		$correct=substr($opt,0,2)=="@@"?true:false;
		return $correct;
	}
}




if(!function_exists('get_correct_index'))
{
	function get_correct_index($str_option)
	{
		$options=explode('///',$str_option);
		$indx='';
		if(count($options)>0)
		{
			$i=0;
			$rng_ques=range('A','H');
			foreach ($options as $opt) {
				$strip_ans=trim(strip_tags(trim($opt),'<img>'));
				$correct=substr($opt,0,2)=="@@"?true:false;
				if($correct)
				{
					$indx=$rng_ques[$i];
				}
				$i++;
			}
		
		}
		return $indx;
	}
}


if(!function_exists('correct_ans'))
{
	function correct_ans($opt)
	{
		$correct=substr($opt,0,2)=="@@"?true:false;
		$correct_ans_str='';
		if($correct)
		{
			$ans_plain=str_replace('@@','',trim($opt));
		}
		
		return $correct_ans_str;
	}
}

if(!function_exists('make_plain'))
{
	function make_plain($opt)
	{
		$correct=substr($opt,0,2)=="@@"?true:false;
		$ans_str='';
		if($correct)
		{
			$ans_str=str_replace('@@','',trim($opt));
		}
		else
		{
			$ans_str=trim($opt);
		}
		
		return $ans_str;
	}
}



