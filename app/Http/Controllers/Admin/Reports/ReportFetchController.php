<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Extenders\Controllers\FetchController;

use App\Models\Documents\Document;

class ReportFetchController extends FetchController
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new Document;
    }

    /**
     * Custom filtering of query
     * 
     * @param Illuminate\Support\Facades\DB $query
     * @return Illuminate\Support\Facades\DB $query
     */
    public function filterQuery($query)
    {
        $isAdmin = !auth()->guard('admin')->user()->is_supervisor;

    	if($this->request->filled('status')) {
    		if($isAdmin) {
    			$query = $query->where('admin_approval_status', $this->request->status)->where('supervisor_approval_status', 1);
    		} else {
    			$query = $query->where('supervisor_approval_status', $this->request->status);
    		}
        } else {
        	if($isAdmin) {
        		$query = $query->where('supervisor_approval_status', 1);
        	} else {
        		$query = $query->whereIn('supervisor_approval_status', [0, 1, 2]);
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
        if($item->documentLogs) {
            $supervisor = $item->documentLogs()->where('is_supervisor', true)->first() ? $item->documentLogs()->where('is_supervisor', true)->first()->parent->renderName() : null;
            $supervisor .= $item->documentLogs()->where('is_supervisor', true)->first() ? '('.$item->documentLogs()->where('is_supervisor', true)->first()->status.')' : null;
            $admin = $item->documentLogs()->where('is_supervisor', false)->first() ? $item->documentLogs()->where('is_supervisor', false)->first()->parent->renderName() : null;
            $admin .= $item->documentLogs()->where('is_supervisor', false)->first() ? '('.$item->documentLogs()->where('is_supervisor', false)->first()->status.')' : null;
        }

        $isAdmin = !auth()->guard('admin')->user()->is_supervisor;

        return [
            'id' => $item->id,
            'user' => $item->user->renderName(),
            'email' => $item->user->email,
            'mobile_number' => $item->user->mobile_number,
            'file_name' => $item->file_name,
            'file_type' => $item->file_type,
            'status' => $item->renderType('label', $isAdmin),
            'created_at' => $item->renderDate(),
            'showUrl' => $item->renderShowUrl(),
            'archiveUrl' => $item->renderArchiveUrl(),
            'restoreUrl' => $item->renderRestoreUrl(),
            'deleted_at' => $item->deleted_at,

            'supervisor' => $supervisor,
            'admin' => $admin
        ];
    }

    public function fetchView($id = null) {
        $item = null;

        if ($id) {
        	$item = Document::withTrashed()->findOrFail($id);
            $item->archiveUrl = $item->renderArchiveUrl();
            $item->restoreUrl = $item->renderRestoreUrl();
            $item->download = url($item->file_path);
        }

    	return response()->json([
    		'item' => $item,
    	]);
    }
}
