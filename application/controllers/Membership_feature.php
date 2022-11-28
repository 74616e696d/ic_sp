<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Membership_feature extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$data['title']='';
		$this->load->blade('membership_feature', $data);	
	}

}

/* End of file membership_feature.php */
/* Location: ./application/controllers/membership_feature.php */