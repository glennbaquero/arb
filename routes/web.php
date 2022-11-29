<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::namespace('Auth')->group(function() {

    Route::post('forgot-password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	/* Guest Routes */
	Route::middleware('guest:web')->group(function() {


        Route::get('verified/account', 'LoginController@showLoginForm')->name('login');
        Route::post('verified/account', 'LoginController@login');

        Route::get('success', function(){
            return view('web.auth.success-page');
        })->name('success');

        Route::get('verify/{token}/{email}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('reset-password/change', 'ResetPasswordController@reset')->name('password.change');

        Route::get('forgot-password', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');

        Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'RegisterController@register');

        /* Socialite Login */
        Route::get('socialite/{provider}/login', 'SocialiteLoginController@login')->name('socialite.login');
		Route::get('socialite/{provider}/callback', 'SocialiteLoginController@callback')->name('socialite.callback');

		/* Facebook Login */
		Route::get('socialite/facebook/login', 'SocialiteLoginController@login')->name('facebook.login');
		Route::get('socialite/facebook/callback', 'SocialiteLoginController@callback')->name('facebook.callback');

	});

    Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
    Route::get('account/verify', 'VerificationController@successVerifyPage')->name('verify.page');

});
