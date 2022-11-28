<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_reg extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('common');
		$this->load->helper('message');
		$this->load->model('membership_model');
		$this->load->model('user_model');
		$this->load->model('login_model');
		$this->load->library('recaptcha');
		$this->load->library('encrypt');
		$this->load->library('my_validation');
		$this->config->load('mail_setting');
		$this->load->model('member/upgrade_model','upgrade');
	}
	public function index()
	{
		$success=0;
		if($this->session->flashdata('success'))
		{
			$success=1;
		}
		$data['recaptcha']=$this->recaptcha->recaptcha_get_html();
		$data['members']=$this->membership_model->get_members();

		$data['success']=$success;
		$data['title']='Member Registration';
		$this->load->blade('public/v_user_reg', $data);
	}

	function check_user_name()
	{
		$user=$this->input->get('username');
		$has=$this->user_model->exist('user_name',$user);
		echo $has;
	}

	function check_email()
	{
		$email=$this->input->post('email');
		$has=$this->user_model->exist('email',$email);
		echo json_encode(['ok'=>$has]);
	}

	function add()
	{
		$mem_type=2;
		$user_name='user';
		//$user_name=$this->input->post('txt_user_name');
		$email=$this->input->post('txt_email');
		$mobile=$this->input->post('txt_mobile');
		$password=$this->input->post('txt_pass');
		$pass_retype=$this->input->post('txt_pass_retype');

		$creation_date=date('Y-m-d H:i:s');
		$update_date=date('Y-m-d H:i:s');
		$last_login=date('Y-m-d H:i:s');
		$is_online=0;
		$is_active=1;
		$is_locked=0;
		$key = md5(microtime().rand());
		$point=$this->config->item('initial_point');



		$rules=array('txt_mobile|mobile'=>'required',
			'txt_email|email'=>'required|email');
		$data=array();

			if($this->my_validation->validate($_POST,$rules))
			{
				if($password==$pass_retype)
				{
					// if(!user_model::user_exist($user_name))
					// {
						if(!user_model::email_exist($email))
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

							$uid=$this->user_model->add_reg_member($data,$data_upgrade,$data_details);
							

							//$this->upgrade->add($data_upgrade);

							//$msg=$this->confirmation_mail($user_name,$email,$password,$key);
							$this->sign_in($email, $password);
							$this->session->set_flashdata('success', "ধন্যবাদ ! আইকনপ্রিপ্যারাশন এ রেজিস্ট্রেশন সফল হয়েছে। <br/>
দয়া করে লগইন করুন");

							redirect(base_url().'login/index/1');
						}//end success section
						else
						{
							set_old_value($data);
							$this->session->set_flashdata('warning', 'email already exists!');
							redirect(base_url().'public/user_reg');
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
					$this->session->set_flashdata('warning', 'password and confirm password does not match!');
					redirect(base_url().'public/user_reg');
				} //end password and confirm password section
			}
			else
			{
				set_old_value($data);
				$msg=$this->my_validation->errors;
				$this->session->set_flashdata('msg',$msg);
				redirect(base_url().'public/user_reg');
			} //end other validation section

	}



	function confirmation_mail($username,$email,$pass,$user_key)
	{

		$url=base_url()."confirm/index/{$user_key}";
		$company="Iconpreparation";

		$msg='';
		$msg.="<div>";
		$msg.="<h2>Congratulations! You have successfully registered to {$company}<h2>";
		//$msg.="<p><strong>Your User Name:&nbsp;&nbsp;</strong>{$username}</p>";
		$msg.="<p><strong>Your Email/User Name:&nbsp;&nbsp;&nbsp;</strong>{$email}</p>";
		$msg.="<p><strong>Your Password&nbsp;&nbsp;&nbsp;</strong>{$pass}</p>";
		$msg.="</div>";
		$msg.="<div style='width:100%;margin:0 auto;padding:13px 9px;font-weight:bold;height:40px;background:#2791D1;font-size:16px;'>";
		$msg.="Please <a style='color:#fff;' href='$url' target='_blank'>Click here</a> to activate your accout to login";
		$msg.="</div>";

		$config = Array(
		   'protocol' => $this->config->item('protocal'),
		   'smtp_host' => $this->config->item('smtp_host'),
		   'smtp_port' => $this->config->item('port'),
		   'smtp_user' => $this->config->item('smtp_user'),
		   'smtp_pass' => $this->config->item('smtp_pass'),
		   'mailtype' => 'html',
		   'charset' => 'utf-8',
		   'wordwrap' => TRUE
		 );

		$config = Array(
		  'protocol' => $this->config->item('protocal'),
		  'mailpath' => $this->config->item('mailpath'),
		  'mailtype' => 'html',
		  'charset' => 'utf-8',
		  'wordwrap' => TRUE
		);

	      $this->load->library('email', $config);
	      $this->email->set_newline("\r\n");
	      $this->email->from($this->config->item('smtp_user'));
	      $this->email->to($email);
	      $this->email->subject("Account Details for {$email} at {$company}");
	      $this->email->message($msg);
	      if($this->email->send())
	     {
	      	return 'Your registration is successfull.';
	     }
	     else
	     {
	     	return $this->email->print_debugger();
	     }

	}


	function sign_in($uname,$pass)
	{
		$user_name=$uname;
		$password=$pass;
		if(!empty($user_name)){
			if(!empty($password))
			{
				if($this->login_model->validate($user_name,$password))
				{
					$mtype=$this->session->userdata('utype');
					login_model::online_status($user_name,1);  //update online status
					login_model::last_login($user_name); //update last login time

					if($mtype!='101' && $mtype!='102')
					{
						redirect(base_url().'member/dashboard');
					}
					else
					{
						if($mtype=='101')
						{
							redirect(base_url().'admin/dashboard');
						}
						else
						{
							redirect(base_url().'admin/question_bank');
						}
					}
				}
				else
				{
					redirect(base_url());
				}
			}
		}
	}

	/**
	 * display registration link for referral link
	 *
	 * @return void
	 */
	function register()
	{
		$ref=$this->uri->segment(4);
		$ref_arr=explode('-',$ref);
		$ref_user_id=isset($ref_arr[2])?$ref_arr[2]:0;

		if($ref_user_id==0)
		{
			redirect(base_url().'public/user_reg');
		}
		// var_dump($this->membership_model->remaining_days(27294));
		$data['ref_user_id']=$ref_user_id;
		$data['ref_str']=$ref;

		$u_name=user_model::get_user_name($ref_user_id);
		$data['u_name']=!empty($u_name)?$u_name:'';

		$data['title']='Referral Registration';
		$this->load->blade('public.referral_register', $data);
	}

	/**
	 * user registration by reference
	 *
	 * @return void
	 */
	function ref_reg()
	{
		$mem_type=10;
		$user_name='user';
		$email=$this->input->post('txt_email');
		$mobile=$this->input->post('txt_mobile');
		$password=$this->input->post('txt_password');
		$pass_retype=$this->input->post('txt_conf_password');
		$ref_id=$this->input->post('hdn_ref_uid');
		$ref_str=$this->input->post('hdn_ref_str');

		$creation_date=date('Y-m-d H:i:s');
		$update_date=date('Y-m-d H:i:s');
		$last_login=date('Y-m-d H:i:s');
		$is_online=0;
		$is_active=1;
		$is_locked=0;
		$key = md5(microtime().rand());
		$point=$this->config->item('initial_point');

		$rules=array('txt_mobile|mobile'=>'required','txt_email|email'=>'required|email');
		$data=array();

		if($this->my_validation->validate($_POST,$rules))
		{
			if($password==$pass_retype)
			{
				if(!user_model::email_exist($email))
				{
					//creating user array
					$data=array(
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

					$exp_dt=$this->membership_model->expire_date(7)->toDateTimeString();
					$data_upgrade=array('user_id'=>0,
						'mem_type'=>$mem_type,
						'status'=>2,
						'req_date'=>$creation_date,
						'approval_date'=>$creation_date,
						'exp_date'=>$exp_dt);

					$uid=$this->user_model->add_reg_member($data,$data_upgrade,$data_details);

					$this->add_refferer($ref_id, $uid);

					//give referer 7 days full access to his existing date
					$this->membership_model->extend_membership($ref_id);

					$msg=$this->confirmation_mail($user_name,$email,$password,$key);
					$this->sign_in($email, $password);
				}//end success section
				else
				{
					set_old_value($data);
					$this->session->set_flashdata('warning', 'email already exists!');
					redirect(base_url().'public/user_reg/register/'.$ref_str);
				}//end invalid email section
			}
			else
			{
				set_old_value($data);
				$this->session->set_flashdata('warning', 'password and confirm password does not match!');
				redirect(base_url().'public/user_reg/register/'.$ref_str);
			} //end password and confirm password section
		}
		else
		{
			set_old_value($data);
			$msg=$this->my_validation->errors;
			$this->session->set_flashdata('msg',$msg);
			redirect(base_url().'public/user_reg/register/'.$ref_str);
		} //end other validation section
	}

	/**
	 * add referer info after successfull registration
	 * @param integer $ref_id
	 * @param integer $uid
	 */
	function add_refferer($ref_id,$uid)
	{
		try
		{
			$this->load->model('referral_model');
			$data=[
				'referer_id'=>$ref_id,
				'user_id'=>$uid,
				'created_at'=>date('Y-m-d H:i:s')
			];
			$uid=$this->referral_model->create($data);
		}
		catch(Exception $ex)
		{

		}

	}

	/**
	 * sending email to referer after successfully registration
	 * by his/her referral link
	 *
	 * @param  string $ref_email
	 * @return string
	 */
	function ref_reg_conf_mail($ref_email='')
	{
		$data['test']='';
		$msg=$this->load->blade('email.referral_mail', $data,true);
		echo $msg;
		$config = Array(
		  'protocol' => $this->config->item('protocal'),
		  'mailpath' => $this->config->item('mailpath'),
		  'mailtype' => 'html',
		  'charset' => 'utf-8',
		  'wordwrap' => TRUE
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from($this->config->item('smtp_user'));
		$this->email->to($ref_email);
		$this->email->subject("One of your friend has been registered to Iconpreparation.");
		$this->email->message($msg);
		 if($this->email->send())
		{
		 	return 'Your registration is successfull.';
		}
		else
		{
			return $this->email->print_debugger();
		}
	}



}
