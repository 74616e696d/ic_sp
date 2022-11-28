<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notfound extends CI_Controller {

	public function index()
	{
		$this->output->set_status_header('404');
		$this->load->blade('not_found');
	}

}

/* End of file NotFound.php */
/* Location: ./application/controllers/NotFound.php */