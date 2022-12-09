<?php

class Cvtemplate extends Member_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('cvtemp_model');
	}
	public function index()
	{
		$data['details']=$this->cvtemp_model->get_details();
		$data['cvs']=$this->cvtemp_model->all_by('display',1);
		$data['title']='CV Templates';
		$this->load->blade('member.cv.index', $data);	
	}

}

/* End of file cvtemplate.php */
/* Location: ./application/views/member/cvtemplate.php */