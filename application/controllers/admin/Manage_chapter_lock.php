<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_chapter_lock extends Admin_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->model('member/chapter_lock_model','lock');
		// $this->output->enable_profiler(true);
	}

	public function index()
	{
		$data['chapters']=$this->lock->get_chapters("where group_id=4");
		$data['title']='Manage Chapter Lock';
		$this->load->blade('admin.manage_chapter_lock.index', $data);
	}


	function lock_chapter()
	{
		$chapter=$this->input->get('chapter');
		$is_paid=$this->input->get('locked');
		$this->lock->do_lock($chapter,$is_paid);
		echo "success";
	}

}

/* End of file manage_chapter_lock.php */
/* Location: ./application/controllers/admin/manage_chapter_lock.php */