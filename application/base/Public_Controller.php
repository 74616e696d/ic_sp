<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Public_controller extends CI_Controller {

	var $userid=0;
	var $utype=0;
	var $email='';
	var $username='';
	function __construct()
	{
		parent::__construct();
		die("parent controller");

		if($this->session->userdata('userid'))
    	{
    		$this->userid=$this->session->userdata('userid');
    		$this->utype=$this->session->userdata('utype');
    		$this->email=$this->session->userdata('email');
    		$this->username=$this->session->userdata('username');
    	}
		//$this->load->library('session');

		$this->load->model('login_model');

    	
	}
	public function index()
	{
		
	}

}