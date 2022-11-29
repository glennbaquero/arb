<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Extenders\Controllers\FetchController;

use App\Models\Documents\Document;

use App\Models\Users\User;

use Storage;

class StorageConsumedFetchController extends FetchController
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
        $query = $query->whereHas('documents', function($query) {
            $query ? true : false;
        });

        return $query->where('user_type', 0);
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
            $size = 0;

            foreach($item->documents as $document) {
                if(Storage::exists($document->file_path)) {
	                $size += Storage::size($document->file_path);
                }
            }

            array_push($result, [
            	'id' => $item->id,
                'user' => $item->renderName(),
                'email' => $item->email,
            	'mobile_number' => $item->mobile_number,
            	'usage' => $this->size_format($size),
	            'showUrl' => $item->renderShowUrl(),
            ]);
        }

        return $result;
    }

    public function size_format($size) {
        $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    } 
}
