<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('membership_model');
		$this->load->model('user_model');
		$this->load->helper('message');
		$this->load->config('mail_setting');
		$this->load->library('validate_request');
	}
	public function index()
	{
		$msg='';
		if($this->uri->segment(3))
		{
			$msg=success_message('ধন্যবাদ ! আইকনপ্রিপ্যারাশন এ রেজিস্ট্রেশন সফল হয়েছে। <br/>
দয়া করে লগইন করুন');
		}

		$data['msg']=$msg;
		$data['authenticated']=login_model::is_auth();
		$data['title']='';
		$this->load->blade('v_login', $data);
	}


	function user_login()
	{
		$user_name=$this->input->post('user');
		$password=$this->input->post('pass');
		$this->session->set_flashdata('action_type', 'login');
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
					$this->session->set_flashdata('error', 'invalid user name or password!');
					redirect(base_url().'public/user_reg');
				}
			}
			else
			{
				$this->session->set_flashdata('error', 'Password required !!');
				redirect(base_url().'public/user_reg');
			}
		}
		else
		{
			$this->session->set_flashdata('error', 'Email required !!');
			redirect(base_url().'public/user_reg');
		}
	}

/* 	function global_login()
	{
		$data['authenticated']=login_model::is_auth();
		$data['title']='';
		$this->load->blade('global_login', $data);
	}
 */

/* 	function global_sign_in()
	{
		$user_name=$this->input->post('login');
		$password=$this->input->post('pass');
		
		if(!empty($user_name)){
			if(!empty($password))
			{
				if($this->login_model->global_validate($user_name,$password))
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
					$this->session->set_flashdata('error', 'invalid user name or password!');
					redirect(base_url().'login/global_login');
				}
			}
		}
	} */

	function sign_in()
	{
		$user_name=$this->input->post('login');
		$password=$this->input->post('pass');
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
					$this->session->set_flashdata('error', 'invalid user name or password!');
					redirect(base_url().'login');
				}
			}
			else
			{
				$this->session->set_flashdata('error', 'Password required !!');
				redirect(base_url().'login');
			}
		}
		else
		{
			$this->session->set_flashdata('error', 'Email required !!');
			redirect(base_url().'login');
		}
	}

	function sign_out()
	{
		if($this->session->userdata('username'))
		{
		$uname=$this->session->userdata('username');
		login_model::online_status($uname,0);  //update online status
		}
		$this->login_model->logout();
		
	}

	function sign_out_frontend()
	{
		if($this->session->userdata('username'))
		{
		$uname=$this->session->userdata('username');
		login_model::online_status($uname,0);  //update online status
		}
		$this->login_model->logout_frontend();
		
	}

	function forget_password_view()
	{
		$data['title']='';
		$this->load->blade('forget_password', $data);
	}


	function forget_password_mail()
	{
		$uid=0;
		try
		{
			$email=$this->input->post('txt_email');
			$user=$this->user_model->find_by_email($email);
			$uid=$user?$user->id:0;
			if($user)
			{

				$this->password_retrieve_mail($uid,$email);
				$data['msg']="Help is on the way. Please check your email";
			}
			else
			{
				$data['msg']='Email does not exists';
			}
		}
		catch (Exception $ex)
		{
			//var_dump($ex);
		}
		$data['title']='';
		$this->load->blade('forget_password_mail',$data);
	}

	function password_retrieve_mail($uid,$email)
	{
		$company="Iconpreparation.com";
		$logo_url="http://iconpreparation.com/asset/frontend/img/logo.png";
		$key = md5(microtime().rand()).'-'.$uid;
		$url="http://iconpreparation.com/retrieve_password/index/{$key}";
		
		$msg='';

		$msg.="<!DOCTYPE html><html>";
		$msg.="<head></head><body style='background:#f6f6f6;font-family:Tahoma,Arial,Helvetica,sans-serif;font-size:12px;'>";

		$msg.="<div style='margin:0 auto;width:400px;'>";
		$msg.="<div style='margin: 30px 0 10px;'>";
		$msg.="<div style='margin:15px;color:#777;'>";
		$msg.="<div style='background:#fff;border:1px solid #dcdde1;box-shadow:2px 2px 0 1px rgba(235, 235, 235, 1);'>";
		$msg.="<h2 style='background:none repeat scroll 0 0 #0177bf;margin-top:0;padding-left:15px;padding-top:5px;'><img alt='logo' src='{$logo_url}'></h2>";

		$msg.="<div style='padding:10px;'>";
		$msg.="<h4 style='font-size:15px;'>Hello Iconpreparation User</h4>"; 
		$msg.="<p><strong> We heard you need a password reset. Click the link below and you'll be redirected to a secure site from which you can set a new password.</strong></p>";
		$msg.="</div>";
		$msg.="<div style='width:100%;margin:0 auto;padding:3px 9px;font-weight:bold;height:40px;font-size:16px;'>";
		$msg.="<a style='padding:4px 12px;display:inline-block;font-size:15px;color:#fff;text-decoration:none;background:#49afcd;border-radius:4px;border-width:1px;border-color:rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);' href='$url' target='_blank'>Reset Password</a>";
		$msg.="</div>";

		$msg.="<div style='padding:9px;'>";
		$msg.="If you didn't try to reset your password, <a target='_blank' href='http://iconpreparation.com/'>click here</a> and we'll forget this ever happened.";
		$msg.="</div>";

		$msg.="</div>";
		$msg.="</div>";
		$msg.="</div>";
		$msg.="</div>";

		$msg.="</body></html>";
		// echo $msg;

		$config = Array(
		  'protocol' => 'sendmail',
		  'smtp_host' => $this->config->item('smtp_host'),
		  'smtp_port' => $this->config->item('port'),
		  'smtp_user' => $this->config->item('smtp_user'),
		  'smtp_pass' => $this->config->item('smtp_pass'),
		  'mailpath'=> '/usr/sbin/sendmail',
		  'charset' => 'utf-8',
		  'mailtype' => 'html',
		  'charset' => 'utf-8',
		  'wordwrap' => TRUE
		);
		
	      $this->load->library('email', $config);
	      $this->email->set_newline("\r\n");
	      $this->email->from($this->config->item('smtp_user')); 
	      $this->email->to($email);
	      $this->email->subject("Password reset at Iconpreparation");
	      $this->email->message($msg);
	      $this->email->send();
	     // echo $this->email->print_debugger();die();
	}

	function get_password()
	{
		$email=$this->input->post('txt_email');
		$user=$this->membership_model->user_by_email($email);
		if($user)
		{
			//
		}
		else
		{
			$this->session->set_flashdata('warning', 'Invalid Email');
			redirect(base_url().'login/forget_password_view');
		}
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */