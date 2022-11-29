<?php

namespace App\Http\Controllers\Admin\Analytics;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use App\Models\Users\Admin;
use App\Models\Users\User;
use App\Models\ActivityLogs\ActivityLog;

use App\Models\Documents\Document;

class DashboardAnalyticsController extends Controller
{
    protected $startDate;
    protected $endDate;

    public function fetch(Request $request) {
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $this->startDate = Carbon::parse($request->input('start_date'))->format('Y-m-d') . " 00:00:00";
            $this->endDate = Carbon::parse($request->input('end_date'))->format('Y-m-d') . " 23:59:59";
        }

        if ($request->filled('admin')) {
            $users = new Admin;
            $subject = 'App\Models\Users\Admin';
        } else {
            $users = new User;
            $subject = 'App\Models\Users\User';
        }

        $activities = $this->getUserActivity($users);
        $usage = $this->getSystemUsageAnalytics($users, $subject);

    	return response()->json(array_merge($usage, $activities));
    }

    protected function getUserActivity($items) {
        if ($this->startDate && $this->endDate) {
            $items = $items->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }
        
        $active = $items->whereDate('created_at', '!=', now())->count();
        $inactive = $items->onlyTrashed()->count();

        return [
            'active' => $active,
            'inactive' => $inactive,
        ];
    }

    protected function getSystemUsageAnalytics($items, $subject) {

        $uploaded = Document::get()->count();
        $approved = Document::where('status', 1)->get()->count();
        $rejected = Document::where('status', 2)->get()->count();

        if ($this->startDate && $this->endDate) {
            $uploaded = Document::whereBetween('created_at', [$this->startDate, $this->endDate])->get()->count();
            $approved = Document::whereBetween('created_at', [$this->startDate, $this->endDate])->where('status', 1)->get()->count();
            $rejected = Document::whereBetween('created_at', [$this->startDate, $this->endDate])->where('status', 2)->get()->count();
        }

        $item_usage_chart = [
            [
                'label' => 'Uploaded',
                'data' => $uploaded,
                'backgroundColor' => '#007bff',
            ],
            [
                'label' => 'Approved',
                'data' => $approved,
                'backgroundColor' => '#34c11b',
            ],
            [
                'label' => 'Rejected',
                'data' => $rejected,
                'backgroundColor' => '#dc3545',
            ],
        ];

        return [
            'usage_chart' => $item_usage_chart,
        ];
    }
}
