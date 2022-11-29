<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Extenders\Controllers\FetchController as Controller;

use App\Models\Pages\Page;
use App\Models\Pages\PageItem;

class PageItemFetchController extends Controller
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new PageItem;
    }

    /**
     * Custom filtering of query
     * 
     * @param Illuminate\Support\Facades\DB $query
     * @return Illuminate\Support\Facades\DB $query
     */
    public function filterQuery($query)
    {
        /**
         * Queries
         * 
         */
        if ($this->request->filled('page_id')) {
            $query = $query->where('page_id', $this->request->input('page_id'));
        }

        return $query;
    }

    /**
     * Custom formatting of data
     * 
     * @param Illuminate\Support\Collection $items
     * @return array $result
     */
    public function formatData($items)
    {
        $result = [];

        foreach($items as $item) {
            $data = $this->formatItem($item);
            array_push($result, $data);
        }

        return $result;
    }

    /**
     * Build array data
     * 
     * @param  App\Contracts\AvailablePosition
     * @return array
     */
    protected function formatItem($item)
    {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'slug' => $item->renderName(),
            'type' => $item->renderType(),
            'type_class' => $item->renderType('class'),
            'page' => $item->renderPageColumn('name'),
            'created_at' => $item->renderDate(),
            'parentUrl' => $item->page->renderShowUrl(),
            'showUrl' => $item->renderShowUrl(),
            'archiveUrl' => $item->renderArchiveUrl(),
            'restoreUrl' => $item->renderRestoreUrl(),
            'deleted_at' => $item->deleted_at,
        ];
    }

    public function fetchView($id = null) {
        $item = null;

        if ($id) {
        	$item = PageItem::withTrashed()->findOrFail($id);
            $item->content = $item->renderContent();
            $item->archiveUrl = $item->renderArchiveUrl();
            $item->restoreUrl = $item->renderRestoreUrl();
            $item->parentUrl = $item->page->renderShowUrl();
        }

        $pages = Page::all();
        $types = PageItem::getTypes();

    	return response()->json([
    		'item' => $item,
            'pages' => $pages,
            'types' => $types,
    	]);
    }
}
