<?php

namespace App\Http\Controllers\Web\ActivityLogs;

use App\Extenders\Controllers\ActivityLogs\ActivityLogFetchController as Controller;

class ActivityLogFetchController extends Controller
{
    /**
     * Custom filtering of query
     * 
     * @param Illuminate\Support\Facades\DB $query
     * @return Illuminate\Support\Facades\DB $query
     */
    public function additionalQuery($query)
    {
        /**
         * Queries
         * 
         */
        $filters = [
            'causer_type' => 'App\Models\Users\User',
            'causer_id' => $this->user->id,
        ];

        $query = $query->where($filters);

        $query = $this->filterSubject($query, 'profile', 'App\Models\Users\User', $this->user->id);

        return $query;
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
            'showUrl' => $item->renderShowUrl('web'),
        ];
    }
}
