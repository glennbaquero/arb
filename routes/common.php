<?php

/*
|--------------------------------------------------------------------------
| Common Routes
|--------------------------------------------------------------------------
|
| Here is where you can register common routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "common" middleware group. Now create something great!
|
*/

/**
 * @Testing Area
 */

Route::get('sandbox', 'SandboxController@index')->name('sandbox.index');

/**
 * @Admin Routes
 */

Route::middleware('auth:admin,web')->group(function() {

	/**
	 * Ckeditor Image Upload
	 */
    Route::post('ckeditor/upload', 'CkeditorController@upload');

    /**
     * Google Fetch Address Position
     */
    Route::post('google/position/fetch', 'GoogleAPIController@fetchAddressPosition')->name('google.fetch.address-position');

    /**
     * Sortable
     */
    Route::post('sortable', 'SortableController@sort')->name('sortable');
    Route::post('sortable?image=1', 'SortableController@sort')->name('sort.image');
    Route::post('sortable?sample=1', 'SortableController@sort')->name('sort.sample');
    Route::post('sortable?article=1', 'SortableController@sort')->name('sort.article');

});