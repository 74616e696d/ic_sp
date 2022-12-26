<?php

namespace App\Controllers;
use Illuminate\View\Factory as View;
use App\Services\ForumService;
use App\Models\Ref_text_model;


class ForumsController extends BaseController
{
    private $forumService;

    public function __construct()
    {
        $this->forumService = new ForumService();
        $this->Ref_text_model= new Ref_text_model();
        
    }

    public function posts()
    {
        $postCategories = $this->forumService->getPostCategories();
        $posts = $this->forumService->getPosts([]);

       /* return $this->view->run('forum.posts', [
            'posts' => $posts,
            'postCategories' => $postCategories
        ]);*/
        
        return $this->render('forum.posts',[
            'posts' => $posts,
            'postCategories' => $postCategories
        ]);
    }
    function create()
	{
        echo "Under construction...";
        exit();
		$category=$this->Ref_text_model->where(array('group_id|='=>8,'display|='=>1))->get();
		$data['category']=$category;
		$data['title']='New Post';
		
        return $this->render('forum.create',[
            'category' => $category,
            'title' => 'New Post'
        ]);
        //$this->load->blade('forum.create', $data);
	}

    public function replies($postId = null)
    {   
        $postId = $this->request->uri->getSegment(3);
        $post = $this->forumService->getPost($postId);
        return $this->render('forum.details', ['post' => $post]);
    }
}
