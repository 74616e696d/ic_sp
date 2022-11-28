<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Market_Controller {

	function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$data['title']='This is module';
		$this->load->blade('dashboard/index', $data);
	}

}

/* End of file dashboard.php */
/* Location: ./application/modules/marketplace/controllers/dashboard.php */