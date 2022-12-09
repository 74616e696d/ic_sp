<?php

namespace App\Models;

use CodeIgniter\Model;
use Illuminate\Support\Str;

class JobList extends Model
{
    protected $table = 'job_list';

    protected $returnType = JobList::class;

    public function getSlug()
    {
        return Str::slug($this->title, '-');
    }
}