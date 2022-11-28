<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expert_Controller extends MX_Controller {

	protected $userid=null;
	protected $username=null;
	protected $email=null;
	protected $is_auth=false;
	protected $utype='';

	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('userid'))
		{
			$this->userid=$this->session->userdata('userid');
			$this->username=$this->session->userdata('username');
			$this->email=true;
			$this->is_auth=true;
			$this->utype='expert';
		}
		if(!$this->is_auth)
			redirect(base_url().'expert/login');
	}

}

/* End of file Expert_Controller.php */
/* Location: ./application/base/Expert_Controller.php */