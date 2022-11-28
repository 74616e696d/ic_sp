<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Guide extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		
	}
	public function index()
	{
		$data['title']='User Manual';
		$this->load->blade('public.guide', $data);
	}

}

/* End of file guide.php */
/* Location: ./application/controllers/public/guide.php */