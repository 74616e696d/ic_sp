<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unauthorised extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->blade('unauthorised');
	}

}

/* End of file unauthorised.php */
/* Location: ./application/controllers/unauthorised.php */