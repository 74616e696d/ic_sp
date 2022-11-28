<?php

namespace App\Services;

use App\Models\CurrentNew;

class CurrentNewService
{
    private $currentNew;

    public function __construct()
    {
        $this->currentNew = new CurrentNew();
    }

    /**
     * Get forum post
     * @return ForumPost
     */
    public function getCurrentNew($postId = null)
    {
        $post = $this->currentNew->where('id', $postId)
                    ->first();

        return $post;
    }
}