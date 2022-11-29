<?php

namespace App\Http\Controllers\API\Documents;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;

use Illuminate\Support\Str;

use App\Models\Users\User;
use App\Models\Documents\Document;

use App\Http\Requests\API\Documents\DocumentStoreRequest;

use Storage;
use DB;

class DocumentController extends Controller
{

    public function index(Request $request) 
    {
        $user = $request->user();

        if($user->user_type != User::USER) {
            $selected_user = User::find($request->user_id);
        } else {
            $selected_user = $user;
        }

        $item['my_files'] = $selected_user->documents()->count();
        $item['archives'] = $selected_user->documents()->onlyTrashed()->count();

        return response()->json([
            'item' => $item,
        ]);
    }

    public function store(DocumentStoreRequest $request)
    {
    	$file = $request->file('file');
    	$user = $request->user();

        if($user->user_type != User::USER) {
            $selected_user = User::find($request->user_id);
        } else {
            $selected_user = $user;
        }

    	DB::beginTransaction();
    		$file_type = $file->getClientOriginalExtension();
    		$file_name = $file->getClientOriginalName();
    		$file_name = explode('.', $file_name)[0];
    		$file_with_extension = $file_name.' -'.uniqid() . Str::random(40).'.'.$file_type;

            $path = "public/documents/{$selected_user->renderName()}/";
    		$file->storeAs($path, $file_with_extension);

    		if($user->user_type == User::USER) {
    			$document = $user->documents()->create([
    				'file_name' => $file_name,
    				'file_type' => $file_type,
    				'file_path' => $path.$file_with_extension
    			]);
    		} else {
				$document = Document::create([
					'user_id' => $request->user_id,
					'file_name' => $file_name,
					'file_type' => $file_type,
					'file_path' => $path.$file_with_extension,
                    'bg_image' => $document->bg_image
				]);    			
    		}

    	DB::commit();

    	return response()->json([
    		'title' => 'File successfully uploaded',
    		'message' => 'Please note that your file is currently reviewing by the supervisor/admin and will appear on pending tab.' 
    	]);
    }

    public function get(Request $request)
    {
		$user = $request->user();

    	if($user->user_type != User::USER) {
    		$selected_user = User::find($request->user_id);
    		$documents = $selected_user->getFormattedDocument(false, 0, true, $request->status, $request->search, $request->filled('is_archived'), $request->sort);
    	} else {
    		$documents = $user->getFormattedDocument(false, 0, true, $request->status, $request->search, $request->filled('is_archived'), $request->sort);
    	}

    	return response()->json([
    		'documents' => $documents
    	]);
    }

    public function update(Request $request)
    {
        if(!$request->filled('file_name')) {
            throw ValidationException::withMessages([
                'file_name' => "File name is required.",
            ]);
        }
        
    	$user = $request->user();

    	DB::beginTransaction();
	    	$document = Document::withTrashed()->findOrFail($request->id);
	    	$old_file = $document->file_path;

	    	$new_file = "public/documents/{$user->renderName()}/".$request->file_name.' -'.uniqid() . Str::random(40).'.'.$document->file_type;

	    	$document->file_name = $request->file_name;
	    	$document->file_path = $new_file;
	    	$document->save();

	    	Storage::copy($old_file, $new_file);

    	DB::commit();

    	return response()->json([
    		'title' => 'File successfully updated',
    		'message' => 'You successfully updated the file name.' 
    	]);
    }

    public function archive(Request $request)
    {
        $item = Document::withTrashed()->findOrFail($request->id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived {$item->file_name}",
        ]);
    }

    public function restore(Request $request)
    {
        $item = Document::withTrashed()->findOrFail($request->id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored {$item->file_name}",
        ]);
    }
}
