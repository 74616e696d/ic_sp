<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Font_help extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$data['title']='';
		$this->load->blade('font_help', $data);
	}

}

/* End of file font_help.php */
/* Location: ./application/controllers/font_help.php */