<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hints extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Question_bank_model','question');
	}

	public function index()
	{
		$hints=$this->input->post('hints_search_box');
		$data['hints']=false;
		if(!empty($hints)){
			$data['hints']=$this->question->search_hints($hints);
		}
		$data['title']='Search Result';
		$this->load->blade('admin.hints', $data);
	}

}

/* End of file Hints.php */
/* Location: ./application/controllers/admin/Hints.php */