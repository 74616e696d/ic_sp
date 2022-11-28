<?php

namespace App\Models;

use CodeIgniter\Model;
use Illuminate\Support\Str;

class CurrentNew extends Model
{
    protected $table = 'current_news';

    protected $returnType = CurrentNew::class;

    public function getSlug()
    {
        return Str::slug($this->title, '-');
    }

    public function category()
    {
        $currentNewsCategory = new CurrentNewsCategory();

        return $currentNewsCategory->find($this->category_id);
    }
}