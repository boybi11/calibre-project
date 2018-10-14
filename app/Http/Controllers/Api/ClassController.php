<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\League;

class ClassController extends Controller
{
    public function getList(Request $request)
    {
        $response = [];
        $input = $request->all();
        $data = League::with('user')->where('gm_id', $input['gm_id'])->get();

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

    public function create(Request $request)
    {
        $response = [];
        $input = $request->all();
        $input['slug'] = join("-", explode(" ", strtolower($input['name'])));
        $data = League::create($input);

        if (! is_null($data)) {
            $response['data'] = $data;
            $response['message'] = 'Successfully created data.';
            $status = 200;
        } else {
            $response['message'] = 'Failed to create data.';
            $status = 500;
        }

        return response($response, $status);
    }

    public function delete(Request $request)
    {
        $response = [];
        $input = $request->all();
        $data = League::destroy($input['ids']);

        if (! is_null($data)) {
            $response['data'] = $data;
            $response['message'] = 'Successfully deleted data.';
            $status = 200;
        } else {
            $response['message'] = 'Failed to delete data.';
            $status = 500;
        }

        return response($response, $status);
    }

/** Copy/paste these lines to app\Http\routes.api.php 
Route::get('api/classes/list', array('as'=>'apiClassesList','uses'=>'ClassController@getList', 'middleware'=>'cors'));
Route::get('api/classes/get', array('as'=>'apiClassesGet','uses'=>'ClassController@get', 'middleware'=>'cors'));
Route::post('api/classes/store', array('as'=>'apiClassesStore','uses'=>'ClassController@store', 'middleware'=>'cors'));
Route::post('api/classes/update', array('as'=>'apiClassesUpdate','uses'=>'ClassController@update', 'middleware'=>'cors'));
Route::post('api/classes/destroy', array('as'=>'apiClassesDestroy','uses'=>'ClassController@destroy', 'middleware'=>'cors'));
*/
}
