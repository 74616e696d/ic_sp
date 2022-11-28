<?php

class ProfileController extends BaseController {

	function get_profile($uid)
	{
		$data=[];
		$user=User::with('details','membership')->whereRaw("id={$uid} and is_active=1")->first();
		if($user)
		{
			$data['username']=$user->user_name;
			$data['email']=$user->email;
			if($user->mem_type==101)
			{
				$data['mem_type']='Site Admin';
			}
			else
			{
				$data['mem_type']=$user->membership->name;
			}
			//$avatar=!empty($user->details->photo)?"http://iconpreparation.com/asset/images/upload/".$user->details->photo:'';
			$data['avatar']=!empty($user->details->photo)?"http://localhost/OnlineTest/asset/images/upload/".$user->details->photo:'';
			$data['mem_type_id']=$user->mem_type;
			$dt=date_create($user->creation_date);
			$data['creation_date']=date_format($dt,'d F, Y');
			$data['phone']=$user->details->phone;

		}
		
		return ["msg"=>1,'user'=>$data];
	}

	/**
	 * gettings all package and membership data
	 * @return void
	 */
	function get_membership()
	{
		$package=[];
		
		$memtypes=implode(',',[7,3,8,4,5,6]);

		$membership=MembershipSetting::with('membership','meta')
			->orderByRaw(DB::raw("FIELD(mem_type, {$memtypes})"))
			->get();
		if($membership)
		{
			foreach ($membership as $m) {
				if($m->mem_type!=2)
				{
					
					if($m->setting_key==2)
					{
						$data['package']=$m->membership->name;
						$data['price']=$m->setting_value;
						array_push($package, $data);
					}
					
				}
			}
		}

		return ['msg'=>1,'membership'=>$package];
	}
}