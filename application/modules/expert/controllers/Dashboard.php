<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Expert_Controller {

	function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$data['title']='Dashboard';
		$this->load->blade('dashboard/index', $data);
	}

}

/* End of file dashboard.php */
/* Location: ./application/modules/marketplace/controllers/dashboard.php */