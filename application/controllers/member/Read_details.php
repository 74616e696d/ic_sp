<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Read_details extends Member_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('chapter_details_model');
		$this->load->model('chapter_media_model');
		$this->load->model('ref_text_model');
	}
	public function index()
	{
		$chapter_id=$this->uri->segment(4);
		$is_written=$this->uri->segment(5)?true:false;
		$chapter_name=ref_text_model::get_text($chapter_id);
		$data['details']='';
		$data['media']=$this->chapter_media_model->get_by_role($chapter_id,$this->utype);
		if($this->chapter_details_model->get_details_by_ref($chapter_id))
		{
			$data['details']=$this->chapter_details_model->get_details_by_ref($chapter_id)->details;
		}
		$data['chapter_id']=$chapter_id;
		$data['title']='Chapter Details';
		$data['is_written']=$is_written;
		$data['chapter_name']=$chapter_name;
		$this->load->blade('member.read_details', $data);
	}

}

/* End of file read_details.php */
/* Location: ./application/views/member/read_details.php */