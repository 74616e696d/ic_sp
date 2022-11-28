<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prev_ans extends Admin_Controller {


	public function __construct() 
	{	 
		parent::__construct(); 
	}
		
	public function index()
	{

		$this->load->view('admin/v_prev_ans');		
	}
}
	
	