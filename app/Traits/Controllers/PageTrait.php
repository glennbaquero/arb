<?php

namespace App\Traits\Controllers;

use App\Models\Pages\Page;

trait PageTrait
{
    /* Get Page Data */
    protected function getPageData($slug) {
        $item = Page::where('slug', $slug)->firstOrFail();
        return $item->getData();
    }

    public function view($view, $slug, $extra = []) {
        $data = $this->getPageData($slug);

        return view($view, array_merge($data, $extra));
    }
}