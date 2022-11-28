<?php

namespace App\Services;

use App\Models\CurrentNew;
use App\Models\ForumPost;

class ForumService
{
    private $forumPost;
    private $currentNew;

    public function __construct()
    {
        $this->forumPost = new ForumPost();
        $this->currentNew = new CurrentNew();
    }

    /**
     * Get forum post
     * @return ForumPost
     */
    public function getPost($postId = null)
    {
        $post = $this->forumPost->where('id', $postId)
                    ->first();

        return $post;
    }

    /**
     * Get posts
     * @return array
     */
    public function getPosts($queries = [])
    {
        $posts = $this->forumPost->where('frm_post.display', 1)
                    ->findAll();

        return $posts;
    }

    /**
     * Get top news
     * @return array
     */
    public function getTopNews($queries = [])
    {
        $posts = $this->currentNew->where('display', 1)
                    ->where('category_id', $queries['category_id'])
                    ->where('is_featured !=', 1)
                    ->orderBy('post_date', 'DESC')
                    ->limit($queries['limit'])
                    ->findAll();

        return $posts;
    }

    /**
     * Get post categories
     * @return array
     */
    public function getPostCategories()
    {
        $categories = $this->forumPost->select('count(frm_post.id) as total_post, frm_post.sub_category, ref_text.name')
                        ->join('ref_text', 'ref_text.id = frm_post.sub_category')
                        ->where('frm_post.display', 1)
                        ->groupBy('frm_post.sub_category')
                        ->orderBy('ref_text.serial', 'ASC')
                        ->findAll();

        return $categories;
    }
}