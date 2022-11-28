<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add_syllabus extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('syllabus_model');
	}

	public function index()
	{
		echo 'Hello';
		$data['title']='Add Syllabus';
		$data['main_content']='admin/exam/v_add_syllabus';
		$this->load->view('layout_admin/admin_layout', $data);
	}

}

/* End of file add_syllabus.php */
/* Location: ./application/controllers/admin/exam/add_syllabus.php */