<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Users\UserStoreRequest;

use Excel;
use Carbon\Carbon;

use App\Http\Controllers\Admin\Users\UserFetchController;
use App\Exports\Users\UserExport;

use App\Models\Users\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index', [

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create', [
            //
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $item = User::store($request, null, User::FILLABLE);

        $message = "You have successfully created {$item->renderName()}";
        $redirect = $item->renderShowUrl();

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
        $item = User::withTrashed()->findOrFail($id);

        return view('admin.users.show', [
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UserStoreRequest $request, $id)
    {
        $item = User::withTrashed()->findOrFail($id);
        $message = "You have successfully updated {$item->renderName()}";

        $item = User::store($request, $item, User::FILLABLE);
  
        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = User::withTrashed()->findOrFail($id);
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
        $item = User::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored {$item->renderName()}",
        ]);
    }

    public function export(Request $request)
    {
        $controller = new UserFetchController;

        $request = $request->merge(['ids_only' => 1]);

        $data = $controller->fetch($request);
        $ids = $data->getData()->items;
        
        $message = 'Exporting data, please wait...';

        if (!count($ids)) {
            throw ValidationException::withMessages([
                'items' => 'No users found.',
            ]);
        }

        if (!$request->ajax()) {
            $items = User::whereIn('id', $ids)->get();
            return Excel::download(new UserExport($items), 'Users_' . Carbon::now()->toDateTimeString() . '.xls');
        }

        if ($request->ajax()) {
            return response()->json([
                'message' => $message,
            ]);
        }
    }
}
