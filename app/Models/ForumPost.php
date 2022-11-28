<?php

namespace App\Models;

use CodeIgniter\Model;
use Illuminate\Support\Str;

class ForumPost extends Model
{
    protected $table = 'frm_post';

    protected $returnType = ForumPost::class;

    public function getSlug()
    {
        return Str::slug($this->title, '-');
    }
}