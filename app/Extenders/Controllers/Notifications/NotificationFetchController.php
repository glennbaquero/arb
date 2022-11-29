<?php

namespace App\Extenders\Controllers\Notifications;

use App\Extenders\Controllers\FetchController as Controller;

use App\Models\Notifications\UserNotification;

class NotificationFetchController extends Controller
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new UserNotification;
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
        $filters = [
            'notifiable_type' => get_class($this->user),
            'notifiable_id' => $this->user->id,
        ];

        $query = $query->where($filters);

        if ($this->request->input('read')) {
            $query = $query->whereNotNull('read_at');
        } else if ($this->request->input('unread')) {
            $query = $query->whereNull('read_at');
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
            'title' => $item->renderDataColumn('title'),
            'message' => $item->renderDataColumn('message'),
            'created_at' => $item->renderDate(),
            'read_at' => $item->renderDate('read_at'),
            'showUrl' => $item->renderShowUrl(),
            'readUrl' => $item->renderReadUrl(),
            'unreadUrl' => $item->renderUnreadUrl(),
        ];
    }


}
