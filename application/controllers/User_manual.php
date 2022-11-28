<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_manual extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$data['title']='User Manual';
		$this->load->blade('user_manual', $data);	
	}

}

/* End of file user_manual.php */
/* Location: ./application/controllers/user_manual.php */