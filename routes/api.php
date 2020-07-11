<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/auth/login', 'Api\UserController@login')->name('auth.login');
Route::post('/auth/signIn', 'Api\UserController@signIn');

Route::middleware('auth:api')->group(function () {
	Route::get('auth/logout', 'Api\UserController@logout');
    Route::get('/auth/user', 'Api\UserController@get_user_details_info');
    Route::get('/attendance/param', 'Api\AppController@getMembers');
    Route::post('/mark-attendance', 'Api\AppController@markAttendance');
    Route::get('/prayerRequest', 'Api\AppController@getPrayers');
    Route::get('/feedback', 'Api\AppController@getFeedback');
    Route::get('/store-token', 'Api\AppController@storeToken');
    //Route::resource('products', 'ProductController');
});