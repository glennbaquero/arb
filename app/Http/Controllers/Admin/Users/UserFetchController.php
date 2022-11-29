<?php

namespace App\Http\Controllers\Admin\Users;

use App\Extenders\Controllers\FetchController as Controller;
use App\Models\Users\User;

class UserFetchController extends Controller
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new User;
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
        if ($this->request->filled('email_verified_at')) {
            if ($this->request->input('email_verified_at') == 1) {
                $query = $query->whereNotNull('email_verified_at');
            } else {
                $query = $query->whereNull('email_verified_at');
            }
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
            'firstname' => $item->first_name,
            'lastname' => $item->last_name,
            'email' => $item->email,
            'mobile_number' => $item->mobile_number,
            'status' => $item->renderStatus(),
            'status_class' => $item->renderStatus(false),
            'birthday' => $item->renderDate('birthday', 'M d, Y'),
            'user_type' => $item->renderType(),
            'verified_at' => $item->renderDate('verified_at'),
            'created_at' => $item->renderDate(),
            'showUrl' => $item->renderShowUrl(),
            'deleted_at' => $item->deleted_at,
            'archiveUrl' => $item->renderArchiveUrl(),
            'restoreUrl' => $item->renderRestoreUrl(),
        ];
    }

    public function fetchView($id = null) {
        $item = [];

        $types = User::getTypes();

        if ($id) {
            $item = User::withTrashed()->findOrFail($id);
            $item->archiveUrl = $item->renderArchiveUrl();
            $item->restoreUrl = $item->renderRestoreUrl();
            $item->renderImage = $item->renderImagePath();
            $item->mobile_number_component = $item->calling_code ? explode($item->calling_code,$item->mobile_number)[1] : $item->mobile_number;
        }

        return response()->json([
            'item' => $item,
            'types' => $types
        ]);
    }
}
