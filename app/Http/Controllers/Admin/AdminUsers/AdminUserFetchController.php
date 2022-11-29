<?php

namespace App\Http\Controllers\Admin\AdminUsers;

use App\Extenders\Controllers\FetchController as Controller;

use App\Models\Users\Admin;
use App\Models\Roles\Role;

class AdminUserFetchController extends Controller
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

        if ($this->request->filled('role_id')) {
            $query = $query->whereHas('roles', function($query) {
                return $query->where('id', $this->request->input('role_id'));
            });
        }

        return $query->where('is_supervisor', false);
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
            'roles' => $item->renderRoleNames(),
            'created_at' => $item->renderDate(),
            'showUrl' => $item->renderShowUrl(),
            'deleted_at' => $item->deleted_at,
            'archiveUrl' => $item->renderArchiveUrl(),
            'restoreUrl' => $item->renderRestoreUrl(),
        ];
    }

    public function fetchView($id = null) {
        $item = [];
        $roleIds = [];

        if ($id) {
            $item = Admin::withTrashed()->findOrFail($id);
            $item->archiveUrl = $item->renderArchiveUrl();
            $item->restoreUrl = $item->renderRestoreUrl();
            $item->renderImage = $item->renderImagePath();
            $roleIds = $item->roles()->pluck('id')->toArray();
        }

        $roles = Role::whereNotIn('name', ['Supervisor'])->get();

        return response()->json([
            'item' => $item,
            'roles' => $roles,
            'roleIds' => $roleIds,
        ]);
    }
}
