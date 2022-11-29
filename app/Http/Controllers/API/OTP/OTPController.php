<?php

namespace App\Http\Controllers\API\OTP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Nexmo;

class OTPController extends Controller
{
    /**
     * Sending of OTP to user 
     */
    
    public function send()
    {
    	$user = request()->user();
        $verification = null;

        if(env('app.debug')) {
        	$verification = Nexmo::verify()->start([
        		// 'number' => explode('0',$user->mobile_number)[0] ? $user->mobile_number : '63'.ltrim($user->mobile_number, '0'),
        		'number' => $user->mobile_number,
        		'brand'  => 'ARB',
        		'code_length'  => '6'
        	])->getRequestId();
        }

    	return response()->json([
    		'user' => $user,
    		'verification_id' => $verification,
            'message' => 'We sent you another code in your mobile number. Please wait another 30 seconds for the new request of OTP code.',
            'title' => 'Successfully sent'
    	]);
    }

    /**
     * Verify of OTP from user 
     */
    
    public function verify(Request $request)
    {
    	$user = request()->user();
        $result = null;

        if(env('app.debug')) {
        	$result = Nexmo::verify()->check($request->request_id, $request->code)->getResponseData();
        }

    	return response()->json([
    		'result' => $result
    	]);
    }

    /**
     * Resend OTP from user 
     */
    
    public function cancel(Request $request)
    {
        $user = request()->user();
        $cancel = null;

        if(env('app.debug')) {
            $cancel = Nexmo::verify()->cancel($request->verification_id)->getResponseData();
        }

        return response()->json([
            'cancel' => $cancel,
        ]);
    }
}
