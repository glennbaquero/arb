<?php

namespace App\Extenders\Controllers\ActivityLogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ActivityLogs\ActivityLog;

class ActivityLogController extends Controller
{
    protected $indexView;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filterTypes = json_encode(ActivityLog::getTypes());

        return view($this->indexView, [
            'filterTypes' => $filterTypes,
        ]);
    }
}
