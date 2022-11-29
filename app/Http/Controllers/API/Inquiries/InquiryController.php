<?php

namespace App\Http\Controllers\API\Inquiries;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\API\Inquiries\InquiryStoreRequest;
use App\Notifications\API\Inquiries\UserInquiryNotification;

use App\Models\Inquiries\Inquiry;
use App\Models\Users\Admin;
use App\Models\Permissions\Permission;

use DB;

class InquiryController extends Controller
{

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	
    public function store(InquiryStoreRequest $request)
    {
    	DB::beginTransaction();
	    	$item = Inquiry::store($request);

	    	$ids = Permission::getUsersByPermission(['admin.inquiries.crud']);
	    	$admins = Admin::whereIn('id', $ids)->get();

	    	if ($admins) {
	    		foreach($admins as $admin) {
	    		    $admin->notify(new UserInquiryNotification($item));
	    		}
	    	}

	    DB::commit();

	    return response()->json([
	    	'title' => 'Successfully Sent',
	    	'message' => 'Thank you. We truly appreciate your letter asking for information abour our services.'
	    ]);
    }
}
