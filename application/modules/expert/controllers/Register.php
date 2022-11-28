<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * controller to handle expert registration
 */
class Register extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('common');
		$this->load->model('expert_user_model');
	}
	public function index()
	{
		if(isset($_SESSION['userid']))
			redirect(base_url().'expert/dashboard');
		$data['title']='Expert Registration';
		$this->load->blade('register/index', $data);
	}

	/**
	 * register a new user as expert
	 * 
	 * @return void
	 */
	function reg()
	{
		$this->output->enable_profiler(TRUE);
		$name=$this->input->post('name');
		$email=$this->input->post('email');
		$password=$this->input->post('password');
		$conf_password=$this->input->post('conf_password');
		$data_old=[
		'name'=>$name,
		'email'=>$email
		];

		// validate form
		if(count($this->validate_reg($name, $email, $password, $conf_password))>0)
		{
			set_old_value($data_old);
			$this->session->set_flashdata('errors',$errors);
			redirect(base_url().'expert/register');
		} //end validate form

		$user_id=$this->expert_user_model->register($name,$email,$password);
		if($user_id!=null && !empty($user_id))
		{
			$this->confirmation_email($name, $email, $user_id, $password); //send confirmation email

			$logged_in=$this->expert_user_model->login($email,$password);
			if($logged_in)
			{
				redirect(base_url().'expert/dashboard');
			}
		}
		redirect(base_url().'expert/register');
	}


	/**
	 * validate user registration form
	 * 
	 * @param  string $name         
	 * @param  string $email        
	 * @param  string $password     
	 * @param  string $conf_password
	 * 
	 * @return array              
	 */
	function validate_reg($name,$email,$password,$conf_password)
	{
		$errors=[];
		if(empty($name))
		{
			$errors[]="Name must be given !";
		}
		if(empty($email))
		{
			$errors[]="Email must be given !";
		}
		if(empty($password))
		{
			$errors[]="Password must be given !";
		}
		if($password!=$conf_password)
		{
			$errors[]="Password and confirm password does not match !";
		}

		if($this->expert_user_model->exist('email',$email))
		{
			$errors[]="Email already exist !";
		}
		return $errors;
	}

	/**
	 * check if email exist called by ajax
	 * 
	 * @return void
	 */
	function check_email()
	{
		$email=$this->input->post('email');
		$ok=$this->expert_user_model->exist('email',$email);
		echo $ok;
	}

	/**
	 * send confirmation email after successful registration
	 * 
	 * @param  string $username
	 * @param  string $email   
	 * @param  integer $uid     
	 * @param  string $pass   
	 *  
	 * @return void  
	 */
	function confirmation_email($username,$email,$uid,$pass)
	{

	}

}

/* End of file register.php */
/* Location: ./application/modules/experts/controllers/register.php */