<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'DefaultController@getHome');

// Login Register Logout Routes
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');
Route::get('register/verify/{confirmationCode}', 'UserController@getConfirmcode');
Route::get('logout', 'Auth\AuthController@getLogout');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('privacy-policy', 'DefaultController@getPrivacyPolicy');
Route::get('faq', 'DefaultController@getFAQ');
Route::get('terms-conditions', 'DefaultController@getTermsConditions');
Route::get('contact', 'ContactController@getIndex');
Route::post('contact', 'ContactController@postIndex');

Route::post('subscribe-newsletter', 'DefaultController@postSubscribeNewsletter');

// Authenticated Routes
Route::group(['middleware' => 'auth'], function () {
	Route::get('submit-listing', 'ListingController@getCreate');
    Route::get('my-listings', 'ListingController@getMyListings');
    Route::get('my-account', 'UserController@getAccount');
    Route::get('change-password', 'UserController@getChangePassword');
    Route::post('change-password', 'UserController@postChangePassword');
    Route::get('listing/edit/{listingid}', 'ListingController@getEdit');
    Route::post('listing/edit/{listingid?}', 'ListingController@postCreateEdit');
    Route::get('listing/delete/{listingid}', 'ListingController@getDelete');
    Route::get('listing/claim/{listingid}', 'ListingController@getClaim');

});

Route::get('search', 'SearchController@getSearch');
Route::get('category/{categoryid}/{slug?}', 'CategoryController@getIndex');
Route::get('listing/{listingid}/{slug?}', 'ListingController@getListing');

Route::get('news', 'NewsController@getIndex');
Route::get('news/{id}/{slug?}', 'NewsController@getPost');


// Admin Routes
//Route::group(['prefix' => 'admin', 'middleware' => 'App\Http\Middleware\AdminMiddleware'], function () {

Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
	Route::get('/', 'Admin\DashboardController@getIndex');

    Route::get('categories', 'Admin\CategoryController@getIndex');
    Route::get('category/create', 'Admin\CategoryController@getCreate');
    Route::get('category/edit/{categoryid}', 'Admin\CategoryController@getEdit');
    Route::post('category/edit/{categoryid?}', 'Admin\CategoryController@postCreateEdit');
    Route::get('category/delete/{categoryid}', 'Admin\CategoryController@getDelete');


    Route::get('listings', 'Admin\ListingController@getIndex');
    Route::get('listing/create', 'Admin\ListingController@getCreate');
    Route::get('listing/edit/{listingid}', 'Admin\ListingController@getEdit');
    Route::post('listing/edit/{listingid?}', 'Admin\ListingController@postCreateEdit');
    Route::get('listing/delete/{listingid}', 'Admin\ListingController@getDelete');

    Route::get('claims', 'Admin\ListingController@getClaims');
    Route::get('approve-listings', 'Admin\ListingController@getApproveListings');
    Route::get('verify-listings', 'Admin\ListingController@getVerifyListings');

    Route::post('ajax/listing/approve', 'Admin\ListingController@postAjaxApprove');
    Route::post('ajax/listing/spam', 'Admin\ListingController@postAjaxSpam');
    Route::post('ajax/listing/verify', 'Admin\ListingController@postAjaxVerify');
    Route::post('ajax/listing/claim-delete', 'Admin\ListingController@postAjaxClaimDelete');
    Route::post('ajax/listing/claim-assignlisting', 'Admin\ListingController@postAjaxClaimAssignListing');


    Route::get('users', 'Admin\UserController@getIndex');
    Route::get('user/create', 'Admin\UserController@getCreate');
    Route::get('user/edit/{userid}', 'Admin\UserController@getEdit');
    Route::post('user/edit/{userid?}', 'Admin\UserController@postCreateEdit');
    Route::get('user/delete/{userid}', 'Admin\UserController@getDelete');

    Route::get('settings', 'Admin\SettingController@getIndex');
    Route::post('settings', 'Admin\SettingController@postIndex');

    Route::get('news', 'Admin\NewsController@getIndex');
    Route::get('news/edit/{id}', 'Admin\NewsController@getEdit');
    Route::get('news/delete/{id}', 'Admin\NewsController@getDelete');
    Route::get('news/create', 'Admin\NewsController@getCreate');
    Route::post('news/edit/{id?}', 'Admin\NewsController@postCreateEdit');


});

