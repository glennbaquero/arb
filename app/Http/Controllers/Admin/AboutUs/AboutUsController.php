<?php

namespace App\Http\Controllers\Admin\AboutUs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\AboutUs\AboutUsStoreRequest;

use App\Models\AboutUs\AboutUs;

class AboutUsController extends Controller
{

    public function __construct() {
        $this->middleware('App\Http\Middleware\Admin\AboutUs\AboutUsMiddleware', 
            ['only' => ['index', 'store', 'update', 'removeImage']]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$item = AboutUs::first();
    	$page = 'create';
    	if($item) {
    		$page = 'show';
    	}
        return view('admin.about-us.'.$page, compact('item'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AboutUsStoreRequest $request)
    {
        $item = AboutUs::store($request);

        $message = "You have successfully created {$item->title}";
        $redirect = $item->renderShowUrl();

        return response()->json([
            'message' => $message,
            'redirect' => $redirect,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AboutUsStoreRequest $request, $id)
    {
        $item = AboutUs::withTrashed()->findOrFail($id);
        $message = "You have successfully updated {$item->title}";

        $item = AboutUs::store($request, $item);

        return response()->json([
            'message' => $message,
        ]);
    }

    public function removeImage(Request $request, $id)
    {
        $item = AboutUs::withTrashed()->findOrFail($id);
        $message = "You have successfully remove the image in {$item->title}";

        $result = $item->removeImage($request);

        return response()->json([
            'message' => $message,
        ]);
    }
}
