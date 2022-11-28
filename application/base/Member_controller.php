<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Member_controller extends MY_Controller {

	var $userid=0;
	var $utype=0;
	var $email='';
	var $username='';
	var $msg='';
	function __construct()
	{
		parent::__construct();
		// check user authentication
		$roles=array('101','102','105','2','3','4','5','6','7','8','10');
  		membership_model::is_authenticate($roles);
    	//end check user authentication
    	
    	if($this->session->userdata('userid'))
    	{
    		$this->userid=$this->session->userdata('userid');
    		$this->utype=$this->session->userdata('utype');
    		$this->email=$this->session->userdata('email');
    		$this->username=$this->session->userdata('username');
    	}

    	$this->load->model('message_model');
    	$this->load->model('user_message_model');
    	$this->load->model('permission_model');
    	$this->load->helper('notify');
        $this->load->model('member/mistake_model','mistake');
    	
        if($this->utype!='101' && $this->utype!='102' && $this->utype!='105')
        {
        	if($this->membership_model->is_expired($this->userid))
        	{
                if($this->userid!=2)
                {
                    $this->permission_model->reset_user($this->userid);
                }
        	}
        }
	}

	public function index()
	{
		
	}
	function get_notification()
	{

	}

}

/* End of file member_controller.php */
/* Location: ./application/core/member_controller.php */