<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Sample;

class SampleController extends Controller
{
    public function find(Request $request)
    {
        $response = [];
        $input = $request->all();
        $data = Sample::find($input['id']);

        if (! is_null($data)) {
            $response['data'] = $data;
            $response['message'] = 'Successfully retrieved data.';
            $status = 200;
        } else {
            $response['message'] = 'Failed to retrieve data.';
            $status = 500;
        }

        return response($response, $status);
    }

    public function get(Request $request)
    {
        $response = [];
        $input = $request->all();

        $data = new Sample;
        if (isset($input['skip']) && isset($input['take'])) {
            $data = $data->skip(0)->take(25);
        }
        // FILTER DATA
        // $data->whereParam1('value1');
        // $data->whereParam2('value2');
        // $data = $data->get();

        // $input = $this->_construct_pagination_params($input);
        $data = $data->_paginate($data, $request, $input);

        if (! is_null($data)) {
            $response['data'] = $data;
            $response['message'] = 'Successfully retrieved data.';
            $status = 200;
        } else {
            $response['message'] = 'Failed to retrieve data.';
            $status = 500;
        }


        return response($response, $status);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $sample = Sample::create($input);

        if ($sample) {
            $response = [];
            $response['message'] = 'Successfully created data.';
            $response['data'] = $sample;
            $status = 200;
        } else {
            $response = [];
            $response['message'] = 'Failed to create data.';
            $status = 500;
        }

        return response($response, $status);
    }

    public function update(Request $request)
    {
        $input = $request->all();
        $data = Sample::find($input['id']);
        $data->update($input);

        if (! is_null($data)) {
            $response = [];
            $response['message'] = 'Successfully updated data.';
            $response['data'] = $data;
            $status = 200;
        } else {
            $response = [];
            $response['message'] = 'Failed to update data.';
            $status = 500;
        }

        return response($response, $status);
    }

    public function destroy(Request $request)
    {
        $input = $request->all();
        Sample::destroy($input['id']);

        $response = [];
        $response['message'] = 'Successfully deleted data.';
        $status = 200;

        return response($response, $status);
    }

/** Copy/paste these lines to app\Http\routes.php 
Route::get('api/{$FOLDER_NAME}/find', array('as'=>'api{$ROUTE_NAME}Find','uses'=>'Api\{$MODEL}Controller@find'));
Route::get('api/{$FOLDER_NAME}/get', array('as'=>'api{$ROUTE_NAME}Get','uses'=>'Api\{$MODEL}Controller@get'));
Route::post('api/{$FOLDER_NAME}/store', array('as'=>'api{$ROUTE_NAME}Store','uses'=>'Api\{$MODEL}Controller@store'));
Route::post('api/{$FOLDER_NAME}/update', array('as'=>'api{$ROUTE_NAME}Update','uses'=>'Api\{$MODEL}Controller@update'));
Route::post('api/{$FOLDER_NAME}/destroy', array('as'=>'api{$ROUTE_NAME}Destroy','uses'=>'Api\{$MODEL}Controller@destroy'));
*/
}
