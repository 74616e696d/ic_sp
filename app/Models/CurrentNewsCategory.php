<?php

namespace App\Models;

use CodeIgniter\Model;
use Illuminate\Support\Str;

class CurrentNewsCategory extends Model
{
    protected $table = 'current_news_category';

    protected $returnType = CurrentNewsCategory::class;

    public function getSlug()
    {
        return Str::slug($this->title, '-');
    }
}