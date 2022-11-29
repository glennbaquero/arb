<?php

namespace App\Http\Controllers\Admin\Documents;

use App\Extenders\Controllers\FetchController;

use App\Models\Documents\Document;

class DocumentFetchController extends FetchController
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
        }

        if($this->request->filled('user')) {
            $query = $query->where('user_id', $this->request->user);
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
            'user' => $item->user->renderName(),
            'email' => $item->user->email,
            'file_name' => $item->file_name,
            'file_type' => $item->file_type,
            'created_at' => $item->renderDate(),
            'showUrl' => $item->renderShowUrl(),
            'archiveUrl' => $item->renderArchiveUrl(),
            'restoreUrl' => $item->renderRestoreUrl(),
            'approveUrl' => $item->renderApprovedUrl(),
            'rejectUrl' => $item->renderRejectUrl(),
            'deleted_at' => $item->deleted_at,
        ];
    }

    public function fetchView($id = null) {
        $item = null;

        if ($id) {
        	$item = Document::withTrashed()->findOrFail($id);
            $item->archiveUrl = $item->renderArchiveUrl();
            $item->restoreUrl = $item->renderRestoreUrl();
            $item->download = $item->renderImagePath('file_path');
        }

    	return response()->json([
    		'item' => $item,
    	]);
    }
}
