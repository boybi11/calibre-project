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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::auth();
Route::get('/', 'HomeController@index');
Route::get('/seo', 'HomeController@seo');

// Route::group(['middleware' => 'web'], function () {
//     Route::get('/', 'HomeController@index');
// });

Route::get('autogen', array('as'=>'autogen','uses'=>'AutogenController@index'));

Route::get('admin', array('as'=>'adminLogin','uses'=>'Admin\AuthController@login'));
Route::post('admin', array('as'=>'adminAuthenticate','uses'=>'Admin\AuthController@authenticate'));
Route::get('admin/logout', array('as'=>'adminLogout','uses'=>'Admin\AuthController@logout'));

Route::get('admin/dashboard', array('as'=>'adminDashboard','uses'=>'Admin\DashboardController@index'));

Route::get('admin/samples', array('as'=>'adminSamples','uses'=>'Admin\SampleController@index'));
Route::get('admin/samples/datatable', array('as'=>'adminSamplesDatatable','uses'=>'Admin\SampleController@datatable'));
Route::get('admin/samples/create', array('as'=>'adminSamplesCreate','uses'=>'Admin\SampleController@create'));
Route::post('admin/samples/', array('as'=>'adminSamplesStore','uses'=>'Admin\SampleController@store'));
Route::get('admin/samples/{id}/show', array('as'=>'adminSamplesShow','uses'=>'Admin\SampleController@show'));
Route::get('admin/samples/{id}/view', array('as'=>'adminSamplesView','uses'=>'Admin\SampleController@view'));
Route::get('admin/samples/{id}/edit', array('as'=>'adminSamplesEdit','uses'=>'Admin\SampleController@edit'));
Route::patch('admin/samples/{id}', array('as'=>'adminSamplesUpdate','uses'=>'Admin\SampleController@update'));
Route::post('admin/samples/seo', array('as'=>'adminSamplesSeo','uses'=>'Admin\SampleController@seo'));
Route::delete('admin/samples/destroy', array('as'=>'adminSamplesDestroy','uses'=>'Admin\SampleController@destroy'));
Route::get('admin/samples/crop/url', array('as'=>'adminSamplesCropUrl','uses'=>'Admin\SampleController@crop_url'));
Route::get('admin/samples/{id}/crop/{column}/{asset_id}', array('as'=>'adminSamplesCropForm','uses'=>'Admin\SampleController@crop_form'));
Route::patch('admin/samples/{id}/crop', array('as'=>'adminSamplesCrop','uses'=>'Admin\SampleController@crop'));

Route::get('admin/users', array('as'=>'adminUsers','uses'=>'Admin\UserController@index'));
Route::get('admin/users/create', array('as'=>'adminUsersCreate','uses'=>'Admin\UserController@create'));
Route::post('admin/users/', array('as'=>'adminUsersStore','uses'=>'Admin\UserController@store'));
Route::get('admin/users/{id}/show', array('as'=>'adminUsersShow','uses'=>'Admin\UserController@show'));
Route::get('admin/users/{id}/edit', array('as'=>'adminUsersEdit','uses'=>'Admin\UserController@edit'));
Route::patch('admin/users/{id}', array('as'=>'adminUsersUpdate','uses'=>'Admin\UserController@update'));
Route::delete('admin/users/destroy', array('as'=>'adminUsersDestroy','uses'=>'Admin\UserController@destroy'));

Route::get('admin/profile', array('as'=>'adminProfile','uses'=>'Admin\ProfileController@index'));
Route::get('admin/profile/edit', array('as'=>'adminProfileEdit','uses'=>'Admin\ProfileController@edit'));
Route::patch('admin/profile/edit', array('as'=>'adminProfileUpdate','uses'=>'Admin\ProfileController@update'));
Route::get('admin/profile/change_password', array('as'=>'adminProfilePasswordEdit','uses'=>'Admin\ProfileController@password_edit'));
Route::patch('admin/profile/change_password', array('as'=>'adminProfilePasswordUpdate','uses'=>'Admin\ProfileController@password_update'));

Route::get('admin/options', array('as'=>'adminOptions','uses'=>'Admin\OptionController@index'));
Route::get('admin/options/create', array('as'=>'adminOptionsCreate','uses'=>'Admin\OptionController@create'));
Route::post('admin/options/', array('as'=>'adminOptionsStore','uses'=>'Admin\OptionController@store'));
Route::get('admin/options/{id}/show', array('as'=>'adminOptionsShow','uses'=>'Admin\OptionController@show'));
Route::get('admin/options/{id}/view', array('as'=>'adminOptionsView','uses'=>'Admin\OptionController@view'));
Route::get('admin/options/{id}/edit', array('as'=>'adminOptionsEdit','uses'=>'Admin\OptionController@edit'));
Route::patch('admin/options/{id}', array('as'=>'adminOptionsUpdate','uses'=>'Admin\OptionController@update'));
Route::delete('admin/options/destroy', array('as'=>'adminOptionsDestroy','uses'=>'Admin\OptionController@destroy'));

Route::post('admin/assets/upload', array('as'=>'adminAssetsUpload','uses'=>'Admin\AssetController@upload'));
Route::post('admin/assets/redactor', array('as'=>'adminAssetsRedactor','uses'=>'Admin\AssetController@redactor'));
Route::get('admin/assets/all', array('as'=>'adminAssetsAll','uses'=>'Admin\AssetController@all'));
Route::get('admin/assets/get', array('as'=>'adminAssetsGet','uses'=>'Admin\AssetController@get'));
Route::get('admin/assets/download', array('as'=>'adminAssetsDownload','uses'=>'Admin\AssetController@download'));
Route::post('admin/assets/update', array('as'=>'adminAssetsUpdate','uses'=>'Admin\AssetController@update'));
Route::post('admin/assets/destroy', array('as'=>'adminAssetsDestroy','uses'=>'Admin\AssetController@destroy'));

Route::get('admin/classes', array('as'=>'adminClasses','uses'=>'Admin\ClassController@index'));
Route::get('admin/classes/create', array('as'=>'adminClassesCreate','uses'=>'Admin\ClassController@create'));
Route::post('admin/classes/', array('as'=>'adminClassesStore','uses'=>'Admin\ClassController@store'));
Route::get('admin/classes/{id}/show', array('as'=>'adminClassesShow','uses'=>'Admin\ClassController@show'));
Route::get('admin/classes/{id}/edit', array('as'=>'adminClassesEdit','uses'=>'Admin\ClassController@edit'));
Route::patch('admin/classes/{id}', array('as'=>'adminClassesUpdate','uses'=>'Admin\ClassController@update'));
Route::delete('admin/classes/destroy', array('as'=>'adminClassesDestroy','uses'=>'Admin\ClassController@destroy'));