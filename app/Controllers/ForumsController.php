<?php

namespace App\Controllers;
use Illuminate\View\Factory as View;

use App\Services\ForumService;

class ForumsController extends BaseController
{
    private $forumService;

    public function __construct()
    {
        $this->forumService = new ForumService;
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

    public function replies($postId = null)
    {
        $post = $this->forumService->getPost($postId);

        return $this->view->run('forum.details', [
            'post' => $post
        ]);
    }
}
