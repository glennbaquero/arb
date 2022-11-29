<?php

namespace App\Http\Controllers\Guest\Articles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Controllers\PageTrait;

use App\Models\Articles\Article;

class ArticleController extends Controller
{
	use PageTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->view('guest.articles.index', 'articles', [
            //
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id, $slug = null)
    {
        $item = Article::withTrashed()->findOrFail($id);

        if (!$slug) {
            return redirect()->to($item->renderShowUrl('guest'));
        }

        return view('guest.articles.show', [
            'item' => $item,
        ]);
    }
}
