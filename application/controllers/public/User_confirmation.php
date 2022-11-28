<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_confirmation extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('membership_model');
	}
	public function index()
	{
		$key=$this->uri->segment(4);

	}

}

