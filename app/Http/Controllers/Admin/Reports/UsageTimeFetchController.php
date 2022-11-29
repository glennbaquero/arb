<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Extenders\Controllers\FetchController;

use App\Models\Documents\Document;

use App\Models\Users\User;
use App\Models\Usages\TimeUsage;

use Storage;
use Carbon\Carbon;

class UsageTimeFetchController extends FetchController
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new TimeUsage;
    }

    /**
     * Custom filtering of query
     * 
     * @param Illuminate\Support\Facades\DB $query
     * @return Illuminate\Support\Facades\DB $query
     */
    public function filterQuery($query)
    {
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
            $usage = 0;

            // foreach($item->timeUsage as $usage) {
                $usage_date = Carbon::parse($item->date)->format('M d, Y');
                $time_usage = $this->convertSeconds($item->seconds);
                array_push($result, [
                    'id' => $item->id,
                    'user' => $item->user->renderName(),
                    'email' => $item->user->email,
                    'date' => $usage_date,
                    'mobile_number' => $item->user->mobile_number,
                    'usage' => $time_usage,
                    'showUrl' => $item->user->renderShowUrl(),
                ]);
            // }
        }
        return $result;
    }

    protected function dateQuery($query) {
        if ($this->request->filled('start_date') && $this->request->filled('end_date')) {
            $startDate = $this->request->input('start_date');
            $endDate = $this->request->input('end_date');
            $query = $query->whereBetween('date', [$startDate, $endDate]);
        }

        return $query;
    }

    public function convertSeconds($duration) {
        $minutes = ($duration / 60) % 60;
        $hours = floor(($duration / 60) / 60);

        if($hours > 0) {
            $extension = $hours >= 10 ? ' hours' : ' hour';
            $hours = $hours >= 10 ? $hours : '0'.$hours;

            $hours .= $extension;
        } else {
            $hours = '';
        }

        if($minutes >= 0) {
            $extension = $minutes >= 10 ? ' minutes' : ' minute';
            $minutes = $minutes >= 10 ? $minutes : '0'.$minutes;
            $minutes .= $extension;
        }

        $result = $hours.' '.$minutes;

        return $result;
    } 
}
