<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chapter_progress extends Member_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('ref_text_model');
		$this->load->model('quiz_summery_model');
	}
	public function index()
	{
		$data['quiz']=$this->quiz_summery_model->find_user_quiz($this->userid);
		$data['title']='Chapter Progress';
		$this->load->blade('member.chapter_progress', $data);
	}

}

/* End of file chapter_progress.php */
/* Location: ./application/controllers/member/chapter_progress.php */