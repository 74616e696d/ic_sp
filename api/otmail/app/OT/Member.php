<?php namespace OT;
use \Eloquent;
use Carbon\Carbon;

class Member
{
	function getUser($uid)
	{
		return \User::find($uid);
	}

	function getMember($uid)
	{
		$user=\User::find($uid);
		return $user?$user->mem_type:false;
	}

/**
 * [isExpired description]
 * @param  [type]  $uid [description]
 * @return boolean      [description]
 */
	function isExpired($uid)
	{
		$user=\User::with('upgrade')->where('id',$uid)->first();
		$approval_date=$user->upgrade?$user->upgrade->approval_date:'';
		
		$expired=false;
		if(!empty($approval_date))
		{
			$mem=$user->mem_type;
			$duration=$this->getDuration($mem);
			$app_date=new Carbon($approval_date);
			$exp_date=$app_date->addDays(trim($duration));
			if($exp_date->isPast())
			{
				$expired=true;
			}
		}
		return (string)$expired;

	}


	function getAmount($mem_type)
	{
		$amount=\MembershipSetting::where('mem_type',$mem_type)->where('setting_key',2)->first();
		return $amount->setting_value;
	}

	function getDuration($mem_type)
	{
		$dur=\MembershipSetting::where('mem_type',$mem_type)->where('setting_key',1)->first();
		return $dur->setting_value;
	}
}