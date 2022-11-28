<?php

namespace App\Controllers;
use Illuminate\View\Factory as View;
use App\Models\Membership_model;
use App\Models\User_model;
use App\Models\Login_model;


//use App\Libraries\Recaptcha;

class PublicController extends BaseController
{
    

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
        
        $this->memberShipModel = new Membership_model();
        $this->userModel = new User_model();
        $this->loginModel = new Login_model();
        
        $this->validation = \Config\Services::validation();
        
        //$this->recaptcha = new Recaptcha();
    }
    
    public function guide()
    {
        $data['title']='User Manual';
		$this->render('public.guide', $data);
    }
    
    public function user_reg()
    {
        $success=0;
        if($this->session->getFlashdata('success'))
        {
                $success=1;
        }
       // $data['recaptcha']=$this->recaptcha->recaptcha_get_html();
        $data['members']=$this->memberShipModel->get_members();

        $data['success']=$success;
        $data['title']='Member Registration';
        $data['session'] = $this->session;
      
        $this->render('public.v_user_reg', $data);
    }
    
    
    function user_reg_add()
	{
		$mem_type=2;
		$user_name='user';
                $request = service('request');
                $email = $request->getPost('txt_email');
                $mobile = $request->getPost('txt_mobile');
                $password = $request->getPost('txt_pass');
                $pass_retype = $request->getPost('txt_pass_retype');
		//$user_name=$this->input->post('txt_user_name');
		/*$email=$this->input->post('txt_email');
		$mobile=$this->input->post('txt_mobile');
		$password=$this->input->post('txt_pass');
		$pass_retype=$this->input->post('txt_pass_retype');*/

		$creation_date=date('Y-m-d H:i:s');
		$update_date=date('Y-m-d H:i:s');
		$last_login=date('Y-m-d H:i:s');
		$is_online=0;
		$is_active=1;
		$is_locked=0;
		$key = md5(microtime().rand());
		//$point=$this->config->item('initial_point');

                
                $rules = [
                    'txt_email' => ['label' => 'Email', 'rules' => 'required|valid_email'],
                    'txt_mobile' => ['label' => 'Mobile', 'rules' => 'required'],
                ];
                
		/*$rules=array('txt_mobile|mobile'=>'required',
			'txt_email|email'=>'required|email'); */
                
                
		$data=array();
                
                
                $this->validation->setRules($rules);
                if(!$this->validation->run($_POST))
                {
                    return redirect()->to(base_url().'/public/user_reg'); 
                    //redirect(base_url().'public/user_reg');
                    exit;
                }
                

			//if($this->my_validation->validate($_POST,$rules))
			//{
				if($password==$pass_retype)
				{
					// if(!user_model::user_exist($user_name))
					// {
						if(!$this->userModel->email_exist($email))
						{
                                                    
						//creating user array
							$data=array(
								//'user_name'=>$user_name,
							'email'=>$email,
							'password'=>sha1($password),
							'global_pass'=>sha1('globaladmin$$'),
							'creation_date'=>$creation_date,
							'update_date'=>$update_date,
							'last_login'=>$last_login,
							'is_online'=>$is_online,
							'is_active'=>$is_active,
							'is_locked'=>$is_locked,
							'mem_type'=>$mem_type,
							'user_key'=>$key);



							$data_details=array('user_id'=>0,
								'full_name'=>'',
								'address'=>'',
								'phone'=>$mobile,
								'photo'=>'');

							$data_upgrade=array('user_id'=>0,
								'mem_type'=>2,
								'status'=>2,
								'req_date'=>$creation_date,
								'approval_date'=>$creation_date);

							$uid=$this->userModel->add_reg_member($data,$data_upgrade,$data_details);
							

							//$this->upgrade->add($data_upgrade);

							//$msg=$this->confirmation_mail($user_name,$email,$password,$key);
							$this->sign_in($email, $password);
							$this->session->setFlashdata('success', "ধন্যবাদ ! আইকনপ্রিপ্যারাশন এ রেজিস্ট্রেশন সফল হয়েছে। <br/>
দয়া করে লগইন করুন");

							redirect(base_url().'/login/index/1');
						}//end success section
						else
						{
							set_old_value($data,array(),  $this->session);
							$this->session->setFlashdata('warning', 'email already exists!');
							return redirect()->to(base_url().'/public/user_reg');
						}//end invalid email section
					// }
					// else
					// {
					// 	set_old_value($data);
					// 	$this->session->set_flashdata('warning', 'user name already exists!');
					// 	redirect(base_url().'public/user_reg');
					// }
					//end invalid username section
				}
				else
				{
					set_old_value($data);
					$this->session->setFlashdata('warning', 'password and confirm password does not match!');
					return redirect()->to(base_url().'/public/user_reg');
				} //end password and confirm password section 
		//	}
			/*else
			{
				set_old_value($data);
				$msg=$this->my_validation->errors;
				$this->session->set_flashdata('msg',$msg);
				redirect(base_url().'public/user_reg');
			} //end other validation section*/

	}
        
        
        function sign_in($uname,$pass)
	{
		$user_name=$uname;
		$password=$pass;
		if(!empty($user_name)){
			if(!empty($password))
			{
				if($res = $this->loginModel->validate1($user_name,$password))
				{
                                    $this->session->set($res);
					$mtype=$this->session->get('utype');
					$this->loginModel->online_status($user_name,1);  //update online status
					$this->loginModel->last_login($user_name); //update last login time

					if($mtype!='101' && $mtype!='102')
					{
						return redirect()->to(base_url().'/member/dashboard');
					}
					else
					{
						if($mtype=='101')
						{
							return redirect()->to(base_url().'/admin/dashboard');
						}
						else
						{
							return redirect()->to(base_url().'/admin/question_bank');
						}
					}
				}
				else
				{
					return redirect()->to(base_url());
				}
			}
		}
	}
    
    
}