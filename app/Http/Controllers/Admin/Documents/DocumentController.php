<?php

namespace App\Http\Controllers\Admin\Documents;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Documents\Document;

use App\Services\PushService;

use App\Notifications\Admin\Documents\RejectionMessageNotification;
use App\Notifications\Admin\Documents\ApprovedMessageNotification;

use DB;

class DocumentController extends Controller
{
    public function __construct() {
        $this->middleware('App\Http\Middleware\Admin\Documents\DocumentMiddleware', 
            ['only' => ['index', 'create', 'store', 'show', 'update', 'archive', 'restore']]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.documents.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.documents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = Document::store($request);

        $message = "You have successfully created {$item->file_name}";
        $redirect = $item->renderShowUrl();

        return response()->json([
            'message' => $message,
            'redirect' => $redirect,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Document::withTrashed()->findOrFail($id);
        return view('admin.documents.show', [
            'item' => $item,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Document::withTrashed()->findOrFail($id);
        $admin = auth()->guard('admin')->user();
        $isAdmin = !auth()->guard('admin')->user()->is_supervisor;
        // $item = Document::store($request, $item);
        DB::beginTransaction();
        	if($isAdmin) {
	        	$item->update([
	        			'admin_approval_status' => $request->approval_status, 
	        			'status' => $request->approval_status
	        		]);

                if($request->approval_status == 1) {
                    $item->user->notify(new ApprovedMessageNotification($item));
                    $push = new PushService('Document Update', 'Your document ('.$item->file_name.'.'.$item->file_type.') has been approved.');
                    $push->pushToOne($item->user);
                }

                if($request->approval_status == 2) {
                    $item->user->notify(new RejectionMessageNotification($item, $request->rejected_reason));
                    $push = new PushService('Document Update', 'Your document ('.$item->file_name.'.'.$item->file_type.') has been rejected.');
                    $push->pushToOne($item->user);
                } 
                
                $admin->documentLogs()->create([
                    'document_id' => $item->id,
                    'status' => $item->renderType(),
                    'is_supervisor' => $admin->is_supervisor,
                    'reject_message' => $request->approval_status == 2 ? $request->rejected_reason : null
                ]);

        	} else {
        		if($request->approval_status != 2) { // check if request is rejected from supervisor
        			$item->update([
        					'supervisor_approval_status' => $request->approval_status, 
        				]);	

                    $admin->documentLogs()->create([
                        'document_id' => $item->id,
                        'status' => 'Approved',
                        'is_supervisor' => $admin->is_supervisor
                    ]);
        		} else {
        			$item->update([
        					'supervisor_approval_status' => $request->approval_status,
        					'status' => 2 
        				]);

                    $admin->documentLogs()->create([
                        'document_id' => $item->id,
                        'status' => 'Rejected',
                        'is_supervisor' => $admin->is_supervisor,
                        'reject_message' => $request->rejected_reason
                    ]);

                    $item->user->notify(new RejectionMessageNotification($item, $request->rejected_reason));
                    $push = new PushService('Document Update', 'Your document ('.$item->file_name.'.'.$item->file_type.') has been rejected');
                    $push->pushToOne($item->user);
        		}	
        	}
        DB::commit();
        
    	$message = "You have successfully updated {$item->file_name}";

        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = Document::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived {$item->file_name}",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Document  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = Document::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored {$item->file_name}",
        ]);
    }
}
