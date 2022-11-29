<?php

namespace App\Http\Controllers\Admin\Supervisors;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\AdminUsers\AdminUserStoreRequest;

use App\Models\Users\Admin;

class SupervisorController extends Controller
{
	public function __construct() {
	    $this->middleware('App\Http\Middleware\Admin\Supervisors\SupervisorMiddleware', 
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
        return view('admin.supervisors.index', [
        	//
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.supervisors.create', [
            //
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminUserStoreRequest $request)
    {
        $roles = [];
        array_push($roles, 3);
        $request['role_ids'] = $roles;
    	$request['is_supervisor'] = 1;
        $item = Admin::store($request);

        $message = "You have successfully stored {$item->renderName()}";
        $redirect = $item->renderSupervisorShowUrl();

        return response()->json([
            'message' => $message,
            'redirect' => $redirect,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Admin::withTrashed()->findOrFail($id);

        return view('admin.supervisors.show', [
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUserStoreRequest $request, $id)
    {
    	$roles = [];
    	array_push($roles, 3);
        $request['role_ids'] = $roles;
    	$request['is_supervisor'] = 1;
        $item = Admin::withTrashed()->findOrFail($id);
        $message = "You have successfully updated {$item->renderName()}";

        $item = Admin::store($request, $item);
  
        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SampleItem  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = Admin::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived {$item->renderName()}",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Admin  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = Admin::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully archived {$item->renderName()}",
        ]);
    }
}
