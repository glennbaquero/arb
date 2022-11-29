<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('config/fetch','ConfigFetchController@fetch')->name('fetch.config');

Route::namespace('Auth')->group(function() {

    Route::post('login', 'LoginController@login')->name('login');
    Route::post('register', 'RegisterController@register')->name('register');
    Route::post('forgot-password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');

});

// Route::group(['middleware' => ['assign.guard:web', 'jwt.auth', 'api.auth:web']], function() {
Route::group(['middleware' => ['assign.guard:api', 'jwt.auth']], function() {

	Route::namespace('Auth')->group(function() {
        
        Route::post('email/reset', 'VerificationController@resend')->name('verification.resend');
        Route::post('first-time/password/reset', 'UserController@firstLoginUpdatePassword')->name('first-time.password.reset');
        Route::post('update/password', 'UserController@update')->name('update.password');
        Route::post('logout', 'UserController@logout')->name('logout');

    });

    Route::namespace('Notifications')->group(function() {
    	Route::get('notifications', 'NotificationController@notifications')->name('notifications');
    	Route::post('notification/read', 'NotificationController@readNotification')->name('notification.read');

    	Route::get('announcements', 'AnnouncementController@announcements')->name('announcements');
    });

    Route::namespace('Inquiries')->group(function() {
        Route::post('inquiry/store', 'InquiryController@store')->name('inquiry.store');
    });


    Route::namespace('Faqs')->group(function() {
        Route::get('faqs', 'FaqController@get')->name('faqs');
    });


    Route::namespace('AboutUs')->group(function() {
        Route::get('about-us', 'AboutUsController@get')->name('about-us');
    });
    
    Route::namespace('OTP')->group(function() {
        Route::get('otp/send', 'OTPController@send')->name('otp.send');
        Route::post('otp/verify', 'OTPController@verify')->name('otp.verify');
        Route::post('otp/cancel', 'OTPController@cancel')->name('otp.cancel');
    });


    Route::namespace('Clients')->group(function() {
        Route::post('clients', 'ClientController@clients')->name('clients');
    });

    Route::namespace('Documents')->group(function() {
        Route::post('documents/index', 'DocumentController@index')->name('documents.index');
        Route::post('documents/store', 'DocumentController@store')->name('documents.store');
        Route::post('documents/get', 'DocumentController@get')->name('documents.get');
        Route::post('documents/update', 'DocumentController@update')->name('documents.update');
        Route::post('documents/archive', 'DocumentController@archive')->name('documents.archive');
        Route::post('documents/restore', 'DocumentController@restore')->name('documents.restore');
    });

    Route::post('fetch-resources', 'ResourceFetchController@fetch')->name('resources.fetch');
    Route::post('dashboard', 'ResourceFetchController@dashboard')->name('dashboard');
    Route::post('time-usage', 'ResourceFetchController@saveUsage')->name('time-usage');

    Route::post('device-token/store','DeviceTokenController@store')->name('device-token.store');
      
});
