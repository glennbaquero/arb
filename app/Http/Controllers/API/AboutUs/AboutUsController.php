<?php

namespace App\Http\Controllers\API\AboutUs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\AboutUs\AboutUs;
use App\Models\AboutUs\Branch;

class AboutUsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function get()
    {
    	$item = AboutUs::first();
    	$item['banners'] = $item->getImages();
    	$item['branches'] = Branch::all();

    	return response()->json([
    		'item' => $item
    	]);
    }
}
