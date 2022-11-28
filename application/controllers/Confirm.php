<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Confirm extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}

	public function index()
	{
		$key=$this->uri->segment(3);
		$this->user_model->activate($key,array('is_active'=>1));
		$this->load->view('v_confirm');
	}

}

/* End of file confirm.php */
/* Location: ./application/controllers/confirm.php */