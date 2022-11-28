<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Retrieve_password extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('membership_model');
		$this->load->model('user_model');
		$this->load->config('mail_setting');
	}

	public function index()
	{
		if($this->uri->segment(3))
		{
			$key=$this->uri->segment(3);
			$data["key"]=$key;
			$this->load->blade('v_retrieve_password',$data);
		}
		else
		{
			redirect(base_url().'login');
		}
		
	}

	function send()
	{
		$pass=$this->input->post('pass');
		$pass_again=$this->input->post('pass_again');
		$key=$this->input->post('hdn_key');
		$key_arr=explode('-',$key);
		
		$logo_url="http://iconpreparation.com/asset/frontend/new/img/logo-white.png";
		if($pass==$pass_again)
		{
			$uid=$key_arr[1];
			$user=$this->user_model->find($uid);

			if($user)
			{
				$email=$user->email;
				$new_pass=sha1($pass);
				$this->user_model->update_user($uid,array('password'=>$new_pass));

				$url=base_url();
				$company="iconpreparation.com";
				
				$msg='';
				$msg.="<!DOCTYPE html><html>";
				$msg.="<head></head><body style='background:#f6f6f6;font-family:Tahoma,Arial,Helvetica,sans-serif;font-size:12px;'>";

				$msg.="<div style='margin:0 auto;width:400px;'>";
				$msg.="<div style='margin: 30px 0 10px;'>";
				$msg.="<div style='margin:15px;color:#777;'>";
				$msg.="<div style='background:#fff;border:1px solid #dcdde1;box-shadow:2px 2px 0 1px rgba(235, 235, 235, 1);'>";
				$msg.="<h2 style='background:none repeat scroll 0 0 #0177bf;margin-top:0;padding-left:15px;padding-top:5px;'><img alt='logo' src='{$logo_url}'></h2>";

				$msg.="<div style='padding:10px 8px;'>";
				$msg.="<h3>Your password was successfully reset.</h3>"; 
				// $msg.="You have given new auto generated password.
				//Please activate your account by clicking the following link and login<h2>";
				$msg.="<h4><strong>Your password is:&nbsp;&nbsp;</strong>{$pass}</h4>";
				$msg.="</div>";
				$msg.="<div style='margin:0 auto;padding:13px 9px;font-weight:bold;height:40px;background:#2791D1;color:#fff;font-size:14px;'>";
				$msg.="Please <a style='text-decoration:none;' href='$url' target='_blank'>Click here</a> to login";
				$msg.="</div>";


				$msg.="</div>";
				$msg.="</div>";
				$msg.="</div>";
				$msg.="</div>";

				$msg.="</body></html>";

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
			      $this->email->subject("Password reset for {$email} at {$company}");
			      $this->email->message($msg);
			      if($this->email->send())
			     {
			      	 $this->session->set_flashdata('success', "<div style='font-size:14px;color:green;'>".'Your 
			      		password have been successfully reset</div>');
			      	redirect(base_url());
			     }
			     else
			     {
			     	 $this->session->set_flashdata('error',"<div style='font-size:14px;color:red;'>Something wrong !</div>");
			     	redirect(base_url().'retrieve_password');
			     }
		     }
		     else
		     {
		     	 $this->session->set_flashdata('error',"<div style='font-size:14px;color:red;'>This email does not exists!</div>");

		     	redirect(base_url().'retrieve_password');
		     }
		

		}
		else
		{
			$this->session->set_flashdata('error', 'Password and  repeat-password does not match!! ');
			redirect(base_url()."retrieve_password");
		}
	
	}

	function test()
	{
		$pass='123';
		$logo_url="http://iconpreparation.com/asset/frontend/new/img/logo-white.png";
		$url=base_url()."login";
		$company="iconpreparation.com";
		
		$msg='';
		$msg.="<!DOCTYPE html><html>";
		$msg.="<head></head><body style='background:#f6f6f6;font-family:Tahoma,Arial,Helvetica,sans-serif;font-size:12px;'>";

		$msg.="<div style='margin:0 auto;width:400px;'>";
		$msg.="<div style='margin: 30px 0 10px;'>";
		$msg.="<div style='margin:15px;color:#777;'>";
		$msg.="<div style='background:#fff;border:1px solid #dcdde1;box-shadow:2px 2px 0 1px rgba(235, 235, 235, 1);'>";
		$msg.="<h2 style='background:none repeat scroll 0 0 #0177bf;margin-top:0;padding-left:15px;padding-top:5px;'><img alt='logo' src='{$logo_url}'></h2>";

		$msg.="<div style='padding:10px 8px;'>";
		$msg.="<h3>You have successfully restrived your password.</h3>"; 
		// $msg.="You have given new auto generated password.
		//Please activate your account by clicking the following link and login<h2>";
		$msg.="<h4><strong>Your Password:&nbsp;&nbsp;</strong>{$pass}</h4>";
		$msg.="</div>";
		$msg.="<div style='margin:0 auto;padding:13px 9px;font-weight:bold;height:40px;background:#2791D1;color:#fff;font-size:14px;'>";
		$msg.="Please <a style='color:#FF6C2C;text-decoration:none;' href='$url' target='_blank'>Click here</a> to login in iconpreparation.com";
		$msg.="</div>";


		$msg.="</div>";
		$msg.="</div>";
		$msg.="</div>";
		$msg.="</div>";

		$msg.="</body></html>";
		echo $msg;
	}

	function get_pass()
	{
		 $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		 $randomString = '';
    	for ($i = 0; $i <5; $i++) {
        	$randomString .= $characters[rand(0, strlen($characters) - 1)];
    	}
    	return $randomString;
	}

}

/* End of file retrieve_password.php */
/* Location: ./application/controllers/retrieve_password.php */