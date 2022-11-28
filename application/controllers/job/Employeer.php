<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employeer extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library(array('form_validation', 'email'));
		$this->load->model('job/emp_model','emp');
	}

	public function login()
	{
		$data['title']='';
		$this->load->blade('job.employeer.login', $data);
	}

	public function user_login_check(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('reg_email','Registration Email', 'trim|xss_clean');
		$this->form_validation->set_rules('password','Password', 'trim|xss_clean');

		if( $this->form_validation->run() == FALSE){

			$this->load->blade('job.employeer.login');
		}

		else{
			$this->load->model('employer_login_model');
			$result = $this->emp->user_login_data_check();

			if($result){
				redirect('dashboard');
			}
			else{
				$data['error_login'] = 'Email Address or Password is  Invalid !';
				$this->load->blade('job.employeer.login',$data);
			}
		}

	}

	function register()
	{
		$data['title']='';
		$this->load->blade('job.employeer.register', $data);
	}

    function save_reg()
    {
		//set validation rules
		$this->form_validation->set_rules('org_name', 'Organization Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('reg_email', 'Email Address', 'trim|required|valid_email|is_unique[employers_details.reg_email]');
		$this->form_validation->set_rules('org_mobile_1', 'Mobile Number', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[rpassword]|md5');
		$this->form_validation->set_rules('rpassword', 'Retype Password', 'trim|required|md5');
		
		//validate form input
		if ($this->form_validation->run() == FALSE)
        {
			$this->load->blade('job.employeer.register');
        }
		else
		{
			//insert the user registration details into database
			$data = array(
				'org_name' => $this->input->post('org_name'),
				'reg_email' => $this->input->post('reg_email'),
				'org_mobile_1' => $this->input->post('org_mobile_1'),
				'password' => $this->input->post('password')
			);
			
			// insert form data into database
			if ($this->emp->insertUser($data))
			{
				// send email
				// if ($this->emp->sendEmail($this->input->post('reg_email')))
				// {
					// successfully sent mail
					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">You are Successfully Registered! Please confirm the mail sent to your Email-ID!!!</div>');
					redirect('job/employeer/register');
				// }
				// else
				// {
				// 	// error
				// 	$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Error.  Please try again later!!!</div>');
				// 	redirect('job/employeer/register');
				// }
			}
			else
			{
				// error
				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Error.  Please try again later!!!</div>');
				redirect('job/employeer/register');
			}
		}
	}
		
	function verify($hash=NULL)
	{
		if ($this->emp->verifyEmailID($hash))
		{
			$this->session->set_flashdata('verify_msg','<div class="alert alert-success text-center">Your Email Address is successfully verified! Please login to access your account!</div>');
			redirect('job/employeer/register');
		}
		else
		{
			$this->session->set_flashdata('verify_msg','<div class="alert alert-danger text-center">Sorry! There is error verifying your Email Address!</div>');
			redirect('job/employeer/register');
		}
	}

	public function logout(){
		$this->session->unset_userdata('current_user_id');
		$this->session->unset_userdata('current_user_name');
		$this->session->sess_destroy();
		redirect(base_url().'job/employeer/login');
	}

}

/* End of file employeer.php */
/* Location: ./application/controllers/job/employeer.php */