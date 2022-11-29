<?php

namespace App\Http\Controllers\Admin\Articles;

use App\Extenders\Controllers\Articles\ArticleController as Controller;

class ArticleController extends Controller
{
    protected $indexView = 'admin.articles.index';
    protected $createView = 'admin.articles.create';
    protected $showView = 'admin.articles.show';

    public function __construct() {
        $this->middleware('App\Http\Middleware\Admin\Articles\ArticleMiddleware', 
            ['only' => ['index', 'create', 'store', 'show', 'update', 'archive', 'restore']]
        );
    }
}
