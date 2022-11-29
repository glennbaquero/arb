<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class VerificationController extends Controller
{
    /**
     * Based on Illuminate\Foundation\Auth\VerifiesEmails
     */
    
    /**
     * Resend Email Verification
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function resend(Request $request)
    {
    	$message = 'A fresh verification link has been sent to your email address.';
    	$user = $request->user();

    	if ($user && $user->hasVerifiedEmail()) {
    		throw ValidationException::withMessages([
    			'email' => 'Email has already been verified',
    		]);
    	}

    	if ($user) {
    		$user->sendEmailVerificationNotification();
    	}

    	return response()->json([
    		'message' => $message,
    	]);
    }
}
