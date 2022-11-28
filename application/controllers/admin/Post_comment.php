<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_comment extends Admin_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('event_post_comment');
		$this->load->model('user_model');
	}
	public function index()
	{
		$data['comments']=$this->event_post_comment->all_comment();
		$data['title']='Manage Post Comment';
		$this->load->blade('admin.post_comment.index', $data);
	}

	function edit()
	{
		$id=$this->uri->segment(4);
		$data['comment']=$this->event_post_comment->find($id);
		$data['title']='Edit Post Comment';
		$this->load->blade('admin.post_comment.edit', $data);
	}

	function update()
	{
		$id=$this->input->post('hdn_id');
		$comment=$this->input->post('comment');
		$display=$this->input->post('ck_display');
		$data=['comment'=>$comment,'display'=>$display];
		if(!empty($comment)){
			$this->event_post_comment->update($id,$data);
		}
		redirect(base_url()."admin/post_comment");
	}

	function delete()
	{
		$id=$this->uri->segment(4);
		$this->event_post_comment->delete($id);
		$this->session->set_flashdata('error', 'Successfully deleted!!');
		redirect(base_url()."admin/post_comment");
	}

}

/* End of file event_post_comment.php */
/* Location: ./application/controllers/admin/event_post_comment.php */