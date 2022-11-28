<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MX_Controller {
	function __construct()
	{
		parent::__construct();
		if(isset($_SESSION['userid']) && $_SESSION['utype']=='expert')
			redirect(base_url().'expert/dashboard');
		$this->load->model('expert_user_model');
	}

	public function index()
	{
		$data['title']='Login';
		$this->load->blade('register.login', $data);
	}

	/**
	 * login expert user
	 * 
	 * @return void
	 */
	function check()
	{
		$email=$this->input->post('email');
		$password=$this->input->post('password');
		if(!empty($email) && !empty($password))
		{
			$flag=$this->expert_user_model->login($email,$password);
			if($flag)
				redirect(base_url().'expert/dashboard');

			$this->session->set_flashdata('error', 'Invalid email or password !');
			redirect(base_url().'expert/login');
		}
		$this->session->set_flashdata('error', 'Email and password must be given !');
		redirect(base_url().'expert/login');
	}

	/**
	 * logout user from system
	 * 
	 * @return void
	 */
	function logout()
	{
		$flag=$this->expert_user_model->logout();
		redirect(base_url().'expert/login');
	}

}

/* End of file login.php */
/* Location: ./application/modules/expert/controllers/login.php */