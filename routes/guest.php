<?php

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
|
| Here is where you can register guest routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "guest" middleware group. Now create something great!
|
*/


/* Page Routes */
Route::namespace('Pages')->group(function() {

	Route::get('', 'PageController@showHome')->name('home');
	Route::get('terms-and-conditions', 'PageController@showTerms')->name('terms');
	Route::get('privacy-policy', 'PageController@showPrivacy')->name('privacy');

});

/* Article Routes */
Route::namespace('Articles')->group(function() {
	
	Route::get('articles', 'ArticleController@index')->name('articles.index');
	Route::get('articles/show/{id}/{slug?}', 'ArticleController@show')->name('articles.show');

	Route::post('articles/fetch', 'ArticleFetchController@fetch')->name('articles.fetch');
	Route::post('articles/fetch-item/{id?}', 'ArticleFetchController@fetchView')->name('articles.fetch-item');
	Route::post('articles/fetch-pagination/{id}', 'ArticleFetchController@fetchPagePagination')->name('articles.fetch-pagination');
});

Route::namespace('Products')->group(function() {
	
	Route::get('products', 'ProductController@index')->name('products.index');
	// Route::get('articles/show/{id}/{slug?}', 'ArticleController@show')->name('articles.show');

	// Route::post('articles/fetch', 'ArticleFetchController@fetch')->name('articles.fetch');
	// Route::post('articles/fetch-item/{id?}', 'ArticleFetchController@fetchView')->name('articles.fetch-item');
	// Route::post('articles/fetch-pagination/{id}', 'ArticleFetchController@fetchPagePagination')->name('articles.fetch-pagination');
});