<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Two\InvalidStateException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Hash;
use Socialite;
use Auth;
use JWTAuth;
use DB;
use Carbon\Carbon;

use App\Helpers\FileHelper;
use App\Events\Auth\LoggedIn;
use App\Models\Users\User;

class SocialiteLoginController extends Controller
{
	/**
     * Where to redirect users after login.
     *
     * @var string
     */
	protected $redirectTo = '/dashboard';

	const SCOPES = [
        'user_birthday',
        'user_gender',
    ];

	const FIELDS = [
        'id',
        'first_name', // Default
        'last_name', // Default
        'email', // Default
        'gender',
        'birthday',
    ];

	/**
	* Create a redirect method to facebook api.
	*
	* @return void
	*/
    public function login(Request $request, $provider)
    {
        return Socialite::driver($provider)->scopes(static::SCOPES)->fields(static::FIELDS)->redirect();
    }

    /**
     * Return a callback method from facebook api.
     *
     * @return callback URL from facebook
     */
    public function callback(Request $request, $provider)
    {
    	try {
		    $socialite = Socialite::driver($provider)->scopes(static::SCOPES)->fields(static::FIELDS)->user();
    	} catch (InvalidStateException $e) {
    		$request->session()->invalidate();
    		abort(403, 'Invalid provider token, please try again');
    	}

    	$request->session()->regenerate();

		$token = $this->authenticate($socialite, $provider);

		return view('socialite.callback', [
            'provider' => $provider,
            'token' => $token,
            'redirectTo' => $this->redirectTo,
        ]);
    }

	public function authenticate($socialite, $provider) {
		DB::beginTransaction();

		$avatar_url = $socialite->getAvatar();

		/* Find user base on provider email */
		$user = User::withTrashed()->where('email', $socialite->getEmail())->first();

		/* Create user if does not exists */
		if (!$user) {
			$user = $this->createUser($socialite);
			$user->storeImage(FileHelper::getExternalImage($avatar_url), 'image_path', 'user-avatars');
		}

		/* Check if user is trashed */
		if ($user->trashed()) {
			abort(403, 'User is no longer allowed to login');
		}

		/* Find existing socialite provider */
		$userProvider = $user->providers()->where('provider', $provider)->first();

		/* Create socialite provider */
		if (!$userProvider) {
			$userProvider = $user->providers()->updateOrCreate([
				'provider' => $provider,
			], [
				'provider_id' => Hash::make($socialite->getId()),
			]);
		}

		/* Check if socialite id matches */
		if (!Hash::check($socialite->getId(), $userProvider->provider_id)) {
			abort(403, 'Invalid provider credentials');
		}

		/* Generate token and login */
		$token = 'Bearer ' . JWTAuth::fromSubject($user);
        $this->guard()->login($user);

        DB::commit();

        event(new LoggedIn($user));

		return $token;
	}

	/**
	 * Create User
	 */
	protected function createUser($socialite) {
		$socialite = json_decode(json_encode($socialite->user));

		$vars = [
			'first_name' => $socialite->first_name,
			'last_name' => $socialite->last_name,
			'email' => $socialite->email,
			'email_verified_at' => now(),
			'password' => Str::random(),
		];

		if (isset($socialite->birthday) && strtotime($socialite->birthday)) {
			$vars['birthday'] = Carbon::parse($socialite->birthday);
		}

		if (isset($socialite->gender)) {
			$vars['gender'] = ucwords($socialite->gender);
		}

		return User::create($vars);
	}

	/**
	 * Get guard
	 */
	protected function guard() {
		return Auth::guard('web');
	}
}
