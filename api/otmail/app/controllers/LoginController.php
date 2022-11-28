<?php
class LoginController extends BaseController {

	public function getUser()
	{
		return User::whereRaw('mem_type=3')->take(5)->get(array('user_name','email'));
	}

	/**
	 * Login user and getting authenticated users data
	 * @return [type]
	 */
	function login()
	{
		$email=Input::get('email');
		$password=Input::get('password');
		$hashed_pass=sha1($password);

		$is_email=false;
		$user=false;
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$is_email=true;
		}
		//end check if user_name if an email address
		$where="";
		// Prep the query
		if($is_email)
		{
			$where="email='{$email}' and password='{$hashed_pass}' and is_active=1 and is_locked=0";
		}
		else
		{
			$where="user_name='{$email}' and password='{$hashed_pass}' and is_active=1 and is_locked=0";
		}

		$user=User::whereRaw($where)->first();
		if($user)
		{
			return array(
				'msg'=>1,
				'uid'=>$user->id,
				'username'=>$user->user_name,
				'email'=>$user->email,
				'utype'=>$user->mem_type
				);
		}
		else
		{
			return array('msg'=>0);
		}

	}
	function loginNormal($email,$password)
	{
		//$username=Input::get('email');
		//$password=Input::get('password');
		$hashed_pass=sha1($password);

		$is_email=false;
		$user=false;
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$is_email=true;
		}
		//end check if user_name if an email address
		$where="";
		// Prep the query
		if($is_email)
		{
			$where="email='{$email}' and password='{$hashed_pass}' and is_active=1 and is_locked=0";
		}
		else
		{
			$where="user_name='{$email}' and password='{$hashed_pass}' and is_active=1 and is_locked=0";
		}

		$user=User::whereRaw($where)->first();
		if($user)
		{
			return array(
				'msg'=>1,
				'uid'=>$user->id,
				'username'=>$user->user_name,
				'email'=>$user->email,
				'utype'=>$user->mem_type
				);
		}
		else
		{
			return array('msg'=>0);
		}

	}

	function userTypeUpadate($id)
	{
		$where="";
		$where="id='{$id}'";
		
		User::whereRaw($where)
          ->update(['mem_type' => "2"]);
        $user=User::whereRaw($where)->first();
        if($user)
		{
			return array(
				'msg'=>'successful',
				'uid'=>$user->id,
				'username'=>$user->user_name,
				'email'=>$user->email,
				'utype'=>$user->mem_type
				);
		}
		else
		{
			return array('msg'=>'failed');
		}
	}

	function loginfb($email)
	{
		$is_email=false;
		$user=false;
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$is_email=true;
		}
		//end check if user_name if an email address
		$where="";
		// Prep the query
		if($is_email)
		{
			$where="email='{$email}' ";
		}
		$user=User::whereRaw($where)->first();
		if($user)
		{
			return array(
				'msg'=>1,
				'uid'=>$user->id,
				'username'=>$user->user_name,
				'email'=>$user->email,
				'utype'=>$user->mem_type
				);
		}
		else
		{
			return array('msg'=>0);
		}

	}

	function signup()
	{
		$email=Input::get('email');
		$mobile=Input::get('mobile');
		$password=Input::get('password');
		$hashed_pass=sha1($password);

		$check_user=User::where('email',$email)->get();
		if($check_user->isEmpty())
		{
			$data=array('email'=>$email,
				'password'=>$hashed_pass,
				'creation_date'=>date('Y-m-d H:i:s'),
				'is_active'=>1,
				'is_locked'=>0,
				'mem_type'=>2);

			$user=User::create($data);

			$data_details=array('user_id'=>$user->id);
			$upgrade_request=['user_id'=>$user->id,
				'mem_type'=>2,
				'status'=>2,
				'req_date'=>date('Y-m-d H:i:s'),
				'approval_date'=>date('Y-m-d H:i:s'),
				'exp_date'=>date('Y-m-d H:i:s')
				];
			UserDetails::create($data_details);

			UpgradeRequest::create($upgrade_request);


			$user=true;
			if($user)
			{
			return ['msg'=>'success'];
			}
			else
			{
				return ['msg'=>'not success'];
			}
		}
		else
		{
			return ['msg'=>"0"];
		}
	}

	function fbsignup()
	{
		
		$email=Input::get('email');
		$username=Input::get('username');
		$check_user=User::where('email',$email)->get();
		if($check_user->isEmpty())
		{
			$data=array(
				'email'=>$email,
				'user_name'=>$username,
				'creation_date'=>date('Y-m-d H:i:s'),
				'is_active'=>1,
				'is_locked'=>0,
				'mem_type'=>2);

			$user=User::create($data);

			$data_details=array('user_id'=>$user->id);
			$upgrade_request=['user_id'=>$user->id,
				'mem_type'=>2,
				'status'=>2,
				'req_date'=>date('Y-m-d H:i:s'),
				'approval_date'=>date('Y-m-d H:i:s'),
				'exp_date'=>date('Y-m-d H:i:s')
				];
			UserDetails::create($data_details);

			UpgradeRequest::create($upgrade_request);


			$user=true;
			if($user)
			{
			return ['msg'=>"1"];
			}
			else
			{
				return ['msg'=>'not success'];
			}
		}
		else
		{
			return ['msg'=>"0"];
		}
	}

}
