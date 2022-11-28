<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ask_question extends Member_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('member_question_model');
		$this->load->model('qtags_model');
	}
	public function index()
	{
		$data['title']='Ask a question';
		$this->load->blade('member.ask_question', $data);
	}

	function get_tags()
	{
		$tags=$this->qtags_model->all(array('id','name'));
		header('Content-Type: application/json');
		echo json_encode($tags);
	}


	function make()
	{
		$tags=$this->input->post('tag');
		$title=$this->input->post('title');
		$question=$this->input->post('question');
		$tags_arr=!empty($tags)?explode(',',$tags):array('no_category');
		$img_name='';

		$img_name=thumb_img_upload('userfile');		

		$image=$img_name==4?'':$img_name;


		$data=array('title'=>$title,
			'ques'=>$question,
			'user_id'=>$this->userid,
			'post_date'=>date('Y-m-d H:i:s'),
			'published'=>0,
			'tags'=>$tags,
			'img'=>$image
			);
		//die(var_dump($data));
		$this->member_question_model->create($data);
		$this->session->set_flashdata('success', 'Question posted successfully!! ');
		redirect(base_url()."member/ask_question");
	}
}

/* End of file ask_question.php */
/* Location: ./application/controllers/member/ask_question.php */