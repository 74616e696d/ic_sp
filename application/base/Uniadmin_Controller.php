<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uniadmin_Controller extends MY_Controller {

	var $userid=0;
	var $utype=0;
	var $email='';
	var $username='';
	function __construct($allowed=array('101'))
	{
		parent::__construct();
		// check user authentication
		$roles=$allowed;
  		membership_model::is_authenticate($roles);
  		if($this->session->userdata('userid'))
    	{
    		$this->userid=$this->session->userdata('userid',base_url()."admin/unauthorized");
    		$this->utype=$this->session->userdata('utype');
    		$this->email=$this->session->userdata('email');
    		$this->username=$this->session->userdata('username');
    	}
    	//end check user authentication
	}

}

/* End of file Uni_Controller.php */
/* Location: ./application/base/Uni_Controller.php */