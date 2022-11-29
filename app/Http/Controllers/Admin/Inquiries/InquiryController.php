<?php

namespace App\Http\Controllers\Admin\Inquiries;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Inquiries\Inquiry;

class InquiryController extends Controller
{
    
    public function __construct() {
        $this->middleware('App\Http\Middleware\Admin\Inquiries\InquiryMiddleware', 
            ['only' => ['index', 'show', 'archive', 'restore']]
        );
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.inquiries.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Inquiry::withTrashed()->findOrFail($id);
        return view('admin.inquiries.show', [
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Faq  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = Inquiry::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived {$item->full_name}",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Faq  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = Inquiry::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored {$item->full_name}",
        ]);
    }
}
