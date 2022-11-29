<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\API\Auth\LoginRequest;

use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\ThrottlesLogins;

use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Hash;
use Auth;

use App\Events\Auth\LoggedIn;
use App\Models\Users\User;
use Nexmo;

class LoginController extends Controller
{
    use ThrottlesLogins;

    /**
     * Fetch the auth token of the specified user
     * @return JSON
     */
    public function login(LoginRequest $request)
    {
        $token = null;
        $action = false;
        $verification = null;
        $email = $request->input('email');
        $verification = null;

        $user = User::where('email', $email)->first();

        /* Short circuit if no user found with requested email */
        if (!$user) {
            $appName = config('app.name');

            throw ValidationException::withMessages([
                'email' => "{$email} is not associated with any {$appName} account.",
            ]);
        }

        if (!$user->email_verified_at) {
            throw ValidationException::withMessages([
                'email' => "The email used is still not verified. Please verify your email first.",
            ]);
        }

        $response = Hash::check($request->input('password'), $user->password);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        /* Short circuit if password doesn't match */
        if (!$response) {
            $this->incrementLoginAttempts($request);

            throw ValidationException::withMessages([
                'password' => "The password you've entered is incorrect.",
            ]);
        }
        
        $token = JWTAuth::fromSubject($user);

        event(new LoggedIn($user));

        if(env('app.debug')) {
            $verification = Nexmo::verify()->start([
                // 'number' => explode('0',$user->mobile_number)[0] ? $user->mobile_number : '63'.ltrim($user->mobile_number, '0'),
                'number' => $user->mobile_number,
                'brand'  => 'ARB',
                'code_length'  => '6',
                'pin_expiry' => 300
            ])->getRequestId();
        }

        return response()->json([
            'token' => 'Bearer ' . $token,
            'user' => $user,
            'verification_id' => $verification
        ]);
    }

    /**
     * Used on ThrottlesLogins
     * @return string username
     */
    public function username() {
        return 'email';
    }
}
