<?php

namespace App\Controllers;

use App\Services\CurrentNewService;
use App\Services\ForumService;
use Illuminate\View\Factory as View;

class NewsController extends BaseController
{
    private $forumService;
    private $currentNewService;

    public function __construct()
    {
        $this->forumService = new ForumService;
        $this->currentNewService = new CurrentNewService;
    }

    public function index()
    {
        $internationals = $this->forumService->getTopNews([
            'category_id' => 2,
            'limit' => 1,
        ]);

        $national = $this->forumService->getTopNews([
            'category_id' => 1,
            'limit' => 1,
        ]);
        
        return $this->render('current_news.index',[
            'internationals' => $internationals,
            'national' => $national
        ]);

        /*return $this->view->run('current_news.index', [
            'internationals' => $internationals,
            'national' => $national
        ]);*/
    }

    public function all()
    {
        return $this->view->run('current_news.list', []);
    }

    public function show($title = null, $newId = null)
    {
        $new = $this->currentNewService->getCurrentNew($newId);

        return $this->view->run('current_news.details', [
            'news' => $new,
            'tags_news' => [],
            'top_news' => [],
            'category_news' => [],
            'is_admin' => false,
        ]);
    }
}