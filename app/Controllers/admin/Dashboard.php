<?php

class Dashboard extends Admin_Controller {

	public function __construct() 
	{	 
		parent::__construct(); 
		$this->load->model('admin_dash_model');
	}

	public function index()
	{
		$data['todays_users']=$this->admin_dash_model->get_todays_user();
		$data['months_users']=$this->admin_dash_model->get_months_user();
		$data['total_user']=$this->admin_dash_model->total_user();
		$data['title']='Dashboard';
		$this->load->blade('admin.v_dashboard', $data);	
	}
}
	
	