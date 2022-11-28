<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Uniadmin_Controller {
	function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$data['title']='University Dashboard';
		$this->load->blade('admin.dashboard.index', $data);
	}

}

/* End of file dashboard.php */
/* Location: ./application/modules/university/controllers/admin/dashboard.php */