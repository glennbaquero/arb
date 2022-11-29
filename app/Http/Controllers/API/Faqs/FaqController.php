<?php

namespace App\Http\Controllers\API\Faqs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Faqs\Faq;

class FaqController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function get()
    {
    	$items = Faq::all();

    	return response()->json([
    		'items' => $items
    	]);
    }
}
