<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_forum_comment extends Admin_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('forum/frm_comment_model','comment');
		$this->load->library('pagination');
        $this->load->helper('common');
	}
	public function index()
	{
		$baseUrl=base_url().'admin/manage_forum_comment/index';
		$total=$this->comment->total();
		$uri_segment=4;
		$num_links=5;
		$start=0;
		if($this->uri->segment(4))
		{
			$start=$this->uri->segment(4);
		}
		$per_page=25;
		$term="";
		$data['comments']=$this->comment->get_post_comment($start,$per_page,$term);
		$data['comment_pagination']=create_pagination($baseUrl,$total,$uri_segment,$num_links,$per_page);
		$data['title']='Manage Forum Post';
		$this->load->blade('admin.forum_post_comment.index', $data);
	}

	/**
	 * update view status in forum comment
	 * @return void
	 */
	function update_view_status()
	{
		$id =$this->input->get('comment_id');
		$this->comment->update($id,['viewed_by_admin'=>1]);
		echo '1';
	}

	/**
	 * Publish/Unpublish comment
	 * @return void
	 */
	function update_display_status()
	{
		$id =$this->input->get('comment_id');
		$status=$this->input->get('status');
		$this->comment->update($id,['display'=>$status]);
		echo '1';
	}

}

/* End of file manage_forum_comment.php */
/* Location: ./application/controllers/admin/manage_forum_comment.php */