<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\LongNameRequest;

use Acme\Facades\Activity;
use App\LongName;
use App\Seo;

class LongNameController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        if ($name = $request->name) {
            $data = LongName::where('name', 'LIKE', '%' . $name . '%')->paginate(25);
        } else {
            $data = LongName::paginate(25);
        }
        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/long_names/index')
            ->with('title', 'LongNames')
            ->with('menu', 'long_names')
            ->with('keyword', $request->name)
            ->with('data', $data)
            ->with('pagination', $pagination);
    }

    public function create()
    {
        return view('admin/long_names/create')
            ->with('title', 'Create long_name')
            ->with('menu', 'long_names');
    }
    
    public function store(LongNameRequest $request)
    {
        $input = $request->all();
        $long_name = LongName::create($input);

        $log = 'creates a new long_name "' . $long_name->name . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('adminLongNamesEdit', [$long_name->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/long_names/show')
            ->with('title', 'Show long_name')
            ->with('data', LongName::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/long_names/view')
            ->with('title', 'View long_name')
            ->with('menu', 'long_names')
            ->with('data', LongName::findOrFail($id));
    }
    
    public function edit($id)
    {
        $data = LongName::findOrFail($id);
        $seo = $data->seo();

        return view('admin/long_names/edit')
            ->with('title', 'Edit long_name')
            ->with('menu', 'long_names')
            ->with('data', $data)
            ->with('seo', $seo);
    }

    public function update(LongNameRequest $request, $id)
    {
        $input = $request->all();
        $long_name = LongName::findOrFail($id);
        $long_name->update($input);

        $log = 'edits a long_name "' . $long_name->name . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = LongName::findOrFail($input['seoable_id']);
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

        $data = LongName::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->name;
        }
        $log = 'deletes a new long_name "' . implode(', ', $names) . '"';
        Activity::create($log);

        LongName::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminLongNames')
        ];

        return response()->json($response);
    }
    
/** Copy/paste these lines to app\Http\routes.php 
Route::get('admin/long_names', array('as'=>'adminLongNames','uses'=>'Admin\LongNameController@index'));
Route::get('admin/long_names/create', array('as'=>'adminLongNamesCreate','uses'=>'Admin\LongNameController@create'));
Route::post('admin/long_names/', array('as'=>'adminLongNamesStore','uses'=>'Admin\LongNameController@store'));
Route::get('admin/long_names/{id}/show', array('as'=>'adminLongNamesShow','uses'=>'Admin\LongNameController@show'));
Route::get('admin/long_names/{id}/view', array('as'=>'adminLongNamesView','uses'=>'Admin\LongNameController@view'));
Route::get('admin/long_names/{id}/edit', array('as'=>'adminLongNamesEdit','uses'=>'Admin\LongNameController@edit'));
Route::patch('admin/long_names/{id}', array('as'=>'adminLongNamesUpdate','uses'=>'Admin\LongNameController@update'));
Route::post('admin/long_names/seo', array('as'=>'adminLongNamesSeo','uses'=>'Admin\LongNameController@seo'));
Route::delete('admin/long_names/destroy', array('as'=>'adminLongNamesDestroy','uses'=>'Admin\LongNameController@destroy'));
*/
}
