<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Result extends CI_Controller {

	public function index()
	{
		$data['title']='HSC Result 2016';
		$this->load->blade('public.result', $data);	
	}

}

/* End of file result.php */
/* Location: ./application/controllers/public/result.php */