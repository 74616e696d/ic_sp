<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Carbon\Carbon;
class Admin_controller extends MY_Controller {

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
    	//$this->output->enable_profiler(true);
    	
	}
	

}

/* End of file admin_controller.php */
/* Location: ./application/core/admin_controller.php */