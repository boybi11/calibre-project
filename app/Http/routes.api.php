<?php

/*
|--------------------------------------------------------------------------
| WEB API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::post('api/auth', array('as'=>'apiAuth','uses'=>'AuthController@authenticate', 'middleware'=>['api','cors']));
Route::get('api/auth/logout', array('as'=>'apiAuthLogout','uses'=>'AuthController@logout', 'middleware'=>['api','cors']));

Route::post('api/auth/register', array('as'=>'apiRegister','uses'=>'AuthController@register', 'middleware'=>['api','cors']));
Route::post('api/auth/login', array('as'=>'apiLogin','uses'=>'AuthController@login', 'middleware'=>['api','cors']));
Route::post('api/auth/get_user_details', array('as'=>'apiGetUserDetails','uses'=>'AuthController@get_user_details', 'middleware'=>['api','cors', 'jwt-auth']));
Route::get('api/auth/dup_email', array('as'=>'apiAuthDupEmail','uses'=>'AuthController@checkForDuplicateEmail', 'middleware'=>['api','cors']));

Route::get('api/samples/find', array('as'=>'apiSamplesFind','uses'=>'SampleController@find', 'middleware'=>['api','cors']));
Route::get('api/samples/get', array('as'=>'apiSamplesGet','uses'=>'SampleController@get', 'middleware'=>['api','cors']));
Route::post('api/samples/store', array('as'=>'apiSamplesStore','uses'=>'SampleController@store', 'middleware'=>['api','cors']));
Route::post('api/samples/update', array('as'=>'apiSamplesUpdate','uses'=>'SampleController@update', 'middleware'=>['api','cors']));
Route::post('api/samples/destroy', array('as'=>'apiSamplesDestroy','uses'=>'SampleController@destroy', 'middleware'=>['api','cors']));

Route::get('api/products/find', array('as'=>'apiProductsFind','uses'=>'ProductController@find', 'middleware'=>'cors'));
Route::get('api/products/get', array('as'=>'apiProductsGet','uses'=>'ProductController@get', 'middleware'=>'cors'));
Route::post('api/products/store', array('as'=>'apiProductsStore','uses'=>'ProductController@store', 'middleware'=>'cors'));
Route::post('api/products/update', array('as'=>'apiProductsUpdate','uses'=>'ProductController@update', 'middleware'=>'cors'));
Route::post('api/products/destroy', array('as'=>'apiProductsDestroy','uses'=>'ProductController@destroy', 'middleware'=>'cors'));