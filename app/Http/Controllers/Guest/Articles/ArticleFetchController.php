<?php

namespace App\Http\Controllers\Guest\Articles;

use App\Extenders\Controllers\Articles\ArticleFetchController as Controller;

class ArticleFetchController extends Controller
{
	/**
     * Build array data
     * 
     * @param  App\Contracts\AvailablePosition
     * @return array
     */
    protected function formatItem($item)
    {
        return [
        	'path' => $item->renderImagePath(),
            'showUrl' => $item->renderShowUrl('guest'),
        ];
    }

    protected function formatView($item)
    {
        return $item;
    }
}
