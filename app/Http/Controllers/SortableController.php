<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SortableController extends Controller
{
    public function sort(Request $request) {

    	if ($request->filled('image')) {
    		$model = 'App\Models\Picture';
    	}

        if ($request->filled('sample')) {
            $model = 'App\Models\Samples\SampleItem';
        }

        if ($request->filled('article')) {
            $model = 'App\Models\Articles\Article';
        }

        if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($model))) {
            $current = $model::withTrashed()->findOrFail($request->input('current'));
            $previous = $model::withTrashed()->findOrFail($request->input('previous'));
            $next = $model::withTrashed()->findOrFail($request->input('next'));
        } else {
            $current = $model::findOrFail($request->input('current'));
            $previous = $model::findOrFail($request->input('previous'));
            $next = $model::findOrFail($request->input('next'));
        }
    	
        if ($request->input('willInsertAfter')) {
            $current->moveAfter($previous);
        } else {
            $current->moveBefore($next);
        }

    	return response()->json(true);
    }
}
