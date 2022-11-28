<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use Carbon\Carbon;
class Forum extends Public_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('ref_text_model');
		$this->load->model('forum/frm_post_model','frm');
		$this->load->model('forum/frm_comment_model','frm_comment');
		$this->load->model('user_detail_model');
		$this->load->model('user_model');
		$this->load->helper('text');
		$this->load->helper('message');
		$this->load->helper('common');
		$this->load->library('pagination');
		$this->load->library('slug');
		$this->load->helper('form');
	}

	public function index()
	{
		redirect(base_url().'forum/forum/posts');
	}


	/**
	 * facebook share
	 * @return void
	 */
	function share()
	{
		$data['title']=urldecode($_GET['t']);
		$data['summery']=urldecode($_GET['s']);
		$data['url']=urldecode($_GET['u']);
		$this->load->blade('forum/share',$data);
	}

	function create()
	{
		$category=$this->ref_text_model->where(array('group_id|='=>8,'display|='=>1))->get();
		$data['category']=$category;
		$data['title']='New Post';
		$this->load->blade('forum.create', $data);
	}

	/**
	 * display forum post lists view
	 * @return void
	 */
	function posts()
	{
		// $this->output->enable_profiler(true);
		$categorised_post=$this->frm->categorised_post();
		$data['categorised_post']=$categorised_post;
		$category=$this->ref_text_model->where(array('group_id|='=>8,'display|='=>1))->get();
		$data['category']=$category;
		$total=$this->frm->total();
		$baseUrl=base_url()."forum/forum/posts/0";
		$start=0;
		if($this->uri->segment(5))
		{
			$start=$this->uri->segment(5);
		}
		$perPage=12;
		$uriSegment=5;
		$numLinks=3;
		$posts=false;
		if($this->uri->segment(4)>0)
		{
			$sub_cat_id=$this->uri->segment(4);
			$baseUrl=base_url()."forum/forum/posts/{$sub_cat_id}";
			$total=$this->frm->total("where display=1");
			$posts=$this->frm->get_posts($start,$perPage,"where display=1 and sub_category={$sub_cat_id}");
		}
		else
		{
			$posts=$this->frm->get_posts($start,$perPage,"where display=1");
		}
		$data['page_link']=create_pagination($baseUrl,$total,$uriSegment,$numLinks,$perPage);
		$data['recent']=$this->frm->get_recent_post();
		$data['posts']=$posts;
		$data['user_post']=$this->frm->get_user_posts();
		$data['title']='Iconpreparation Forum';
		$this->load->blade('forum.posts', $data);
	}

	function get_sub_cat()
	{
		$id=$this->input->get('id');
		$sub_category=$this->ref_text_model
			->where(array('group_id|='=>9,'parent_id|='=>$id,'display|='=>1))
			->get();
			$str="<option value=''>Select Sub Category</option>";
		if($sub_category)
		{
			foreach ($sub_category as $sc) {
				$str.="<option value='{$sc->id}'>{$sc->name}</option>";
			}
		}
		echo $str;
	}

	/**
	 * save forum post
	 * @return void
	 */
	function save_post()
	{
		$sub_category=$this->input->post('subcategory')?$this->input->post('subcategory'):5000;//5000 is user post category
		$title=$this->input->post('title');
		$details=$this->input->post('post');
		$post_date=date('Y-m-d H:i:s');
		$scat=!empty($sub_category)?$sub_category:601;

		$feature_image=$this->upload_feature_image();

		// if(!empty($sub_category))
		// {
			$data=array('sub_category'=>$scat,
				'title'=>$title,
				'details'=>$details,
				'post_date'=>$post_date,
				'user_id'=>$this->userid,
				'display'=>0,
				'feature_image'=>$feature_image
				);
			$this->frm->create($data);
			$this->session->set_flashdata('success', 'Your post saved successfully and pending for admin approval');
			redirect(base_url()."forum/forum/posts");
		// }
		// else
		// {
		// 	$this->session->set_flashdata('error', 'Please select a sub category!');
		// 	redirect(base_url()."forum/forum/posts");
		// }
	
	}

	function upload_feature_image()
	{
		$file_name='';
		$config['upload_path'] = './asset/upload/forum/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size']  = '10000';
		$config['file_name']  = time().'_forum';
		// $config['max_width']  = '1024';
		// $config['max_height']  = '768';
		
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
		}
		else
		{
			$data = $this->upload->data();
			$file_name=$data['file_name'];
		}
		return $file_name;
	}

	/**
	 * display forum post details view
	 * @return void
	 */
	function replies()
	{
		$categorised_post=$this->frm->categorised_post();
		$data['categorised_post']=$categorised_post;
		$id=$this->uri->segment(4);
		$dtls=$this->frm->find($id);
		$data['next_prev_post']=$this->frm->get_next_prev_post($id);
		$data['recent']=$this->frm->get_recent_post();
		$data['user_post']=$this->frm->get_user_posts();
		$data['total_reply']=$this->frm_comment->total_post_comment($dtls->id);

		$replies=$this->comment_of_post($dtls->id,$dtls->user_id);

		$data['replies']=$replies;
		$data['title']='Iconpreparation Forum';
		$data['pid']=$id;
		$data['details']=$dtls;
		$this->load->blade('forum.details', $data);
	}

	/**
	 * save post comment
	 * @return void
	 */
	function save_reply()
	{
		$post_id=$this->input->post('post_id');
		$details=$this->input->post('reply');
		$data=array('post_id'=>$post_id,
			'user_id'=>$this->userid,
			'details'=>$details,
			'comment_date'=>date('Y-m-d H:i:s'),
			'display'=>1);

		$this->frm_comment->create($data);
	}


	/**
	 * Refresh comments after a comment/reply is posted
	 * @return void
	 */
	
	function refresh_comment()
	{
		$post_id=$this->input->post('pid');
		$user_id=$this->input->post('uid');

		$comment=$this->comment_of_post($post_id,$user_id);
		echo $comment;
		
	}

	/**
	 * Construct comments againts a post
	 * 
	 * @param  interger $post_id
	 * @param  interger $uid    
	 * 
	 * @return void
	 */
	function comment_of_post($post_id,$uid)
	{
		$str='';
		$replies=$this->frm_comment->post_comment($post_id);
		if($replies)
		{
			foreach($replies as $rpl)
			{

				$str.="<div class='bx bx-body post-reply'>";
				$str.="<div class='col-sm-2' style='padding-right:0;'>";
				$img_src=user_detail_model::get_img($rpl->user_id);
				$dt=date_create($rpl->comment_date);
				$comment_date=date_format($dt,'H:i a M d, Y');
				$str.="<img width='100' height='100' style='max-width:60%;' src='{$img_src}' alt=''>";
				$str.="</div>";

				$str.="<div class='col-sm-10' style='padding-left:0'>";
				$str.=$rpl->details;
				if($uid==$this->userid){
				$stl=$rpl->correct?"style='color:green;'":"style:color:#ccc;";
				}
				$str.="</div>";
				$str.="<div class='col-sm-12'>";
				$user=user_model::get_user_name($rpl->user_id);
				$user_name=!empty($user)?$user:'Anonymous';

				$str.="<span class='reply-name'><i class='fa fa-user'></i> {$user_name}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				$str.="<span class='reply-name'><i class='fa fa-clock-o'></i> {$comment_date}</span>";
				$str.="</div>";
				$str.="<div class='clearfix'></div>";
				$str.="</div>";
				$str.="<hr>";
			}
		}
		else
		{
			$str.="<p>Be first to reply this post</p>";
		}

		return $str;
	}

	/**
	 * Get total comment of a post
	 * @return void
	 */
	function total_comment()
	{
		$post_id=$this->input->get('post_id');
		$total=$this->frm_comment->total_post_comment($post_id);
		echo $total;
	}

	function mark()
	{
		$post=$this->input->get('post');
		$reply=$this->input->get('reply');
		$this->frm->update($post,array('solved'=>1));
		$this->frm_comment->update($reply,array('correct'=>1));
		echo 1;
	}

}

/* End of file forum.php */
/* Location: ./application/controllers/forum/forum.php */