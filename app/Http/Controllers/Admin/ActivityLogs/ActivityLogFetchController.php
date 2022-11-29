<?php

namespace App\Http\Controllers\Admin\ActivityLogs;

use App\Extenders\Controllers\ActivityLogs\ActivityLogFetchController as Controller;

class ActivityLogFetchController extends Controller
{
    public function additionalQuery($query) 
    {
        $query = $this->filterSubject($query, 'profile', 'App\Models\Users\Admin', $this->user->id);

        return $query;
    }
}
