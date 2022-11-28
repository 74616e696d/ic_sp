<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employeer_Controller extends CI_Controller {

	protected $company_id=null;
	protected $company_name=null;
	protected $company_email=null;
	protected $company_logo=null;
	protected $is_auth=false;

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('company_id'))
		{
			$this->is_auth=true;
			$this->company_id=$this->session->userdata('company_id');
			$this->company_name=$this->session->userdata('company_name');
			$this->company_email=$this->session->userdata('company_email');
			$this->company_logo=$this->session->userdata('company_logo');
		}

		if(!$this->is_auth)
		{
			redirect(base_url().'employeer/login');
		}
	}

}

/* End of file Employeer_Controller.php */
/* Location: ./application/base/Employeer_Controller.php */