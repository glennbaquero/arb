<?php

namespace App\Http\Controllers\Admin\Supervisors;

use App\Extenders\Controllers\FetchController as Controller;

use App\Models\Users\Admin;

class SupervisorFetchController extends Controller
{
        /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new Admin;
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

        return $query->where('is_supervisor', true);
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
            'first_name' => $item->first_name,
            'last_name' => $item->last_name,
            'email' => $item->email,
            'created_at' => $item->renderDate(),
            'showUrl' => $item->renderSupervisorShowUrl(),
            'deleted_at' => $item->deleted_at,
            'archiveUrl' => $item->renderSupervisorArchiveUrl(),
            'restoreUrl' => $item->renderSupervisorRestoreUrl(),
        ];
    }

    public function fetchView($id = null) {
        $item = [];

        if ($id) {
            $item = Admin::withTrashed()->findOrFail($id);
            $item->archiveUrl = $item->renderSupervisorArchiveUrl();
            $item->restoreUrl = $item->renderSupervisorRestoreUrl();
            $item->renderImage = $item->renderImagePath();
        }

        return response()->json([
            'item' => $item,
        ]);
    }
}
