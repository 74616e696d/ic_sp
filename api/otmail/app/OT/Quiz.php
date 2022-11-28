<?php namespace OT;
use \Eloquent;

class Quiz
{

	function isCorrect($opt)
	{
		$correct=substr(trim($opt),0,2)=="@@"?true:false;
		return $correct;
	}

	function makePlain($opt)
	{
		$correct=$this->isCorrect($opt);
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


	function strToArray($str)
	{
		$qid_arr=[];
		if(!empty($str))
		{
			$ques=explode(',',$str);
			if(count($ques)>0)
			{
				foreach ($ques as $q) 
				{
					array_push($qid_arr, $q);
				}
			}
		}
		return $qid_arr;
	}
}