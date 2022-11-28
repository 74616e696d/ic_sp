<?php

class UserList extends \BaseController
{
	function index()
	{
		$ulist=false;
		$pgae_num=100;
		if(Input::has('search'))
		{
			$uname=Input::has('un')?Input::get('un'):'';
			$id=Input::has('uid')?Input::get('uid'):'';
			$mtp=Input::has('mtp')?Input::get('mtp'):'';
			$term=$this->terms($id,$mtp);
			if($term=='')
			{
				$ulist=User::paginate($pgae_num);
			}
			else
			{
				$ulist=User::whereRaw($term)->paginate($pgae_num);
			}
			
			Session::flash('un',$uname);
			Session::flash('id',$id);
			Session::flash('mtp',$mtp);
		}
		else
		{
			$ulist=User::paginate($pgae_num);
		}
		
		$data['total']=User::all()->count();
		$data['ulist']=$ulist;
		$mtype=Membership::all()->lists('name','id');
		$mtype=array(''=>'Select Membership')+$mtype;
		$data['mtype']=$mtype;
		$data['title']='Send Email From User List';
		return View::make('userlist.index',$data);
		
	}

	function terms($id,$mtp) 
	{
		$stringToFinalReturn='';
	
		$stringReturned = '';
		if ($id!='') {
			$stringReturned .= " id={$id} and ";
		}
		if($mtp!='')
		{
			$stringReturned .= " mem_type={$mtp} and ";
		}
		$stringToFinalReturn=substr($stringReturned,0,strlen($stringReturned)-4);

		return $stringToFinalReturn;
	}

	function user_list()
	{
		$key=Input::get('term');
		//$users=$this->user_model->get_user_like($key);
		$users=User::where('email','LIKE',"%{$key}%")->get();
		return $users;
	}

	function edit_mail()
	{
		$mtype=Membership::all()->lists('name','id');
		$mtype=array(''=>'Select Membership')+$mtype;
		$data['mtype']=$mtype;
		$data['title']='';
		return View::make('preview.edit_mail',$data);
	}

	function send_email()
	{
			$utype=Input::get('mtp');
			$title=Input::get('title');
			$body=Input::get('body');


			$users=User::where('mem_type',$utype)->get(array('email'))->toArray();

			//$mail_lists=$this->sanitize_mail($users);
			//dd($mail_lists);
			if($users)
			{
				foreach ($users as $user) {
					$message = array(
					    'subject' => $title,
					    'html' => $body,
					    'from_email' => 'info@iconpreparation.com',
					    'to' => [['email'=>trim($user['email'])]]
					);

					$response = Email::messages()->send($message);
					var_dump($response);
				}
			}
			echo "send email done !!";
			
	}

	function sanitize_mail($users)
	{
		$usr=[];
		if(count($users)>0)
		{
			foreach ($users as $u) 
			{
				$usr[]=['email'=>trim($u['email'])];
			}
		}
		return $usr;
	}



	function news_letter()
	{
		
	}

}