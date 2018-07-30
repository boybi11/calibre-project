<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\TestRequest;

use Acme\Facades\Activity;
use App\Test;
use App\Seo;

use Image;
use App\Asset;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        if ($name = $request->name) {
            $data = Test::where('name', 'LIKE', '%' . $name . '%')->paginate(25);
        } else {
            $data = Test::paginate(25);
        }
        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/tests/index')
            ->with('title', 'Tests')
            ->with('menu', 'tests')
            ->with('keyword', $request->name)
            ->with('data', $data)
            ->with('pagination', $pagination);
    }

    public function create()
    {
        return view('admin/tests/create')
            ->with('title', 'Create test')
            ->with('menu', 'tests');
    }
    
    public function store(TestRequest $request)
    {
        $input = $request->all();
        $test = Test::create($input);

        $log = 'creates a new test "' . $test->name . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('adminTestsEdit', [$test->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/tests/show')
            ->with('title', 'Show test')
            ->with('data', Test::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/tests/view')
            ->with('title', 'View test')
            ->with('menu', 'tests')
            ->with('data', Test::findOrFail($id));
    }
    
    public function edit($id)
    {
        $data = Test::findOrFail($id);
        $seo = $data->seo();

        return view('admin/tests/edit')
            ->with('title', 'Edit test')
            ->with('menu', 'tests')
            ->with('data', $data)
            ->with('seo', $seo);
    }

    public function update(TestRequest $request, $id)
    {
        $input = $request->all();
        $test = Test::findOrFail($id);
        $test->update($input);

        $log = 'edits a test "' . $test->name . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = Test::findOrFail($input['seoable_id']);
        $seo = Seo::whereSeoable_id($input['seoable_id'])->whereSeoable_type($input['seoable_type'])->first();
        if (is_null($seo)) {
            $seo = new Seo;
        }
        $seo->title = $input['title'];
        $seo->description = $input['description'];
        $seo->image = $input['image'];
        $data->seo()->save($seo);

        $response = [
            'notifTitle'=>'SEO Save successful.',
        ];

        return response()->json($response);
    }
    
    public function destroy(Request $request)
    {
        $input = $request->all();

        $data = Test::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->name;
        }
        $log = 'deletes a new test "' . implode(', ', $names) . '"';
        Activity::create($log);

        Test::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminTests')
        ];

        return response()->json($response);
    }
    
    public function crop_url(Request $request)
    {
        $input = $request->all();
        $response = [
            'redirect'=>route('adminTestsCropForm', [$input['id'], $input['column'], $input['asset_id']])
        ];

        return response()->json($response);
    }

    public function crop_form($id, $column, $asset_id)
    {
        $dimensions = ['width'=>300, 'height'=>300];

        return view('admin/tests/crop')
            ->with('title', 'Crop Image')
            ->with('data', Test::findOrFail($id))
            ->with('column', $column)
            ->with('asset', Asset::findOrFail($asset_id))
            ->with('dimensions', $dimensions);
    }

    public function crop(Request $request, $id)
    {
        $input = $request->all();
        $asset = Asset::findOrFail($input['asset_id']);
        
        $filename = str_slug('test-' . $id . '-' . $input['column']);
        $image = Image::make($asset->path);
        $thumbnail = 'upload/thumbnails/' . $filename . '.' . $image->extension;
        $image->crop($input['crop_width'], $input['crop_height'], $input['x'], $input['y'])
            ->resize($input['target_width'], $input['target_height'])
            ->save($thumbnail, 100);

        $data = Test::findOrFail($id);
        $data->$input['column'] = $thumbnail;
        $data->save();

        $log = 'crops ' . $input['column'] . ' of test "' . $data->name . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Crop successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminTestsCropForm', [$data->id, $input['column'], $asset->id])
        ];

        return response()->json($response);
    }

/** Copy/paste these lines to app\Http\routes.php 
Route::get('admin/tests', array('as'=>'adminTests','uses'=>'Admin\TestController@index'));
Route::get('admin/tests/create', array('as'=>'adminTestsCreate','uses'=>'Admin\TestController@create'));
Route::post('admin/tests/', array('as'=>'adminTestsStore','uses'=>'Admin\TestController@store'));
Route::get('admin/tests/{id}/show', array('as'=>'adminTestsShow','uses'=>'Admin\TestController@show'));
Route::get('admin/tests/{id}/view', array('as'=>'adminTestsView','uses'=>'Admin\TestController@view'));
Route::get('admin/tests/{id}/edit', array('as'=>'adminTestsEdit','uses'=>'Admin\TestController@edit'));
Route::patch('admin/tests/{id}', array('as'=>'adminTestsUpdate','uses'=>'Admin\TestController@update'));
Route::post('admin/tests/seo', array('as'=>'adminTestsSeo','uses'=>'Admin\TestController@seo'));
Route::delete('admin/tests/destroy', array('as'=>'adminTestsDestroy','uses'=>'Admin\TestController@destroy'));
Route::get('admin/tests/crop/url', array('as'=>'adminTestsCropUrl','uses'=>'Admin\TestController@crop_url'));
Route::get('admin/tests/{id}/crop/{column}/{asset_id}', array('as'=>'adminTestsCropForm','uses'=>'Admin\TestController@crop_form'));
Route::patch('admin/tests/{id}/crop', array('as'=>'adminTestsCrop','uses'=>'Admin\TestController@crop'));
*/
}
