<?php

namespace App\Controllers;
use Illuminate\View\Factory as View;

class JobsController extends BaseController
{

    public function index()
    {
        $jobCategories = [];
        return $this->render('job.list', [
            'jobCategories' => $jobCategories
        ]);
      /*  return $this->view->run('job.list', [
            'jobCategories' => $jobCategories
        ]);*/
    }

    public function cv()
    {
        return $this->view->run('job.cv_upload', []);
    }

}