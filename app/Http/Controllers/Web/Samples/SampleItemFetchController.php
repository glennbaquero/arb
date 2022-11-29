<?php

namespace App\Http\Controllers\Web\Samples;

use App\Extenders\Controllers\Samples\SampleItemFetchController as Controller;

use App\Models\Samples\SampleItem;

class SampleItemFetchController extends Controller
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
            'showUrl' => $item->renderShowUrl('web'),
            'archiveUrl' => $item->renderArchiveUrl('web'),
            'restoreUrl' => $item->renderRestoreUrl('web'),
            'approveUrl' => $item->renderApproveUrl('web'),
            'denyUrl' => $item->renderDenyUrl('web'),
        ];
    }

    protected function formatView($item)
    {
        $item->archiveUrl = $item->renderArchiveUrl('web');
        $item->restoreUrl = $item->renderRestoreUrl('web');
        $item->removeImageUrl = $item->renderRemoveImageUrl('web');
        $item->approveUrl = $item->renderApproveUrl('web');
        $item->denyUrl = $item->renderDenyUrl('web');

        return $item;
    }
}
