<?php

namespace App\Http\Controllers\Web\Notifications;

use App\Extenders\Controllers\Notifications\NotificationFetchController as Controller;

use Auth;

class NotificationFetchController extends Controller
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
            'id' => $item->id,
            'title' => $item->renderDataColumn('title'),
            'message' => $item->renderDataColumn('message'),
            'created_at' => $item->renderDate(),
            'read_at' => $item->renderDate('read_at'),
            'showUrl' => $item->renderShowUrl('web'),
            'readUrl' => $item->renderReadUrl('web'),
            'unreadUrl' => $item->renderUnreadUrl('web'),
        ];
    }
}
