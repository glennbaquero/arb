<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Web\Auth\RegisterController as Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

use DB;
use JWTAuth;

class RegisterController extends Controller
{
    public function register(Request $request)
    {   
        DB::beginTransaction();

        	$this->validator($request->all())->validate();

            event(new Registered($user = $this->create($request->all())));

        DB::commit();

        $token = JWTAuth::fromSubject($user);

    	return response()->json([
            'token' => 'Bearer ' . $token,
    		'message' => 'Registation complete, kindly check your email to verify account.',
    	]);
    }
}
