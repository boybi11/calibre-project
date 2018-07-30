<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\{$MODEL}Request;

use Acme\Facades\Activity;
use App\{$MODEL};
use App\Seo;
{$CROP_IMPORTS}
class {$MODEL}Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        if (${$NAME_COLUMN} = $request->{$NAME_COLUMN}) {
            $data = {$MODEL}::where('{$NAME_COLUMN}', 'LIKE', '%' . ${$NAME_COLUMN} . '%')->paginate(25);
        } else {
            $data = {$MODEL}::paginate(25);
        }
        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/{$FOLDER_NAME}/index')
            ->with('title', '{$ROUTE_NAME}')
            ->with('menu', '{$FOLDER_NAME}')
            ->with('keyword', $request->{$NAME_COLUMN})
            ->with('data', $data)
            ->with('pagination', $pagination);
    }

    public function create()
    {
        return view('admin/{$FOLDER_NAME}/create')
            ->with('title', 'Create {$SINGULAR_NAME}')
            ->with('menu', '{$FOLDER_NAME}');
    }
    
    public function store({$MODEL}Request $request)
    {
        $input = $request->all();
        ${$SINGULAR_NAME} = {$MODEL}::create($input);

        // $log = 'creates a new {$SINGULAR_NAME} "' . ${$SINGULAR_NAME}->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('admin{$ROUTE_NAME}Edit', [${$SINGULAR_NAME}->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/{$FOLDER_NAME}/show')
            ->with('title', 'Show {$SINGULAR_NAME}')
            ->with('data', {$MODEL}::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/{$FOLDER_NAME}/view')
            ->with('title', 'View {$SINGULAR_NAME}')
            ->with('menu', '{$FOLDER_NAME}')
            ->with('data', {$MODEL}::findOrFail($id));
    }
    
    public function edit($id)
    {
        $data = {$MODEL}::findOrFail($id);
        $seo = $data->seo();

        return view('admin/{$FOLDER_NAME}/edit')
            ->with('title', 'Edit {$SINGULAR_NAME}')
            ->with('menu', '{$FOLDER_NAME}')
            ->with('data', $data)
            ->with('seo', $seo);
    }

    public function update({$MODEL}Request $request, $id)
    {
        $input = $request->all();
        ${$SINGULAR_NAME} = {$MODEL}::findOrFail($id);
        ${$SINGULAR_NAME}->update($input);

        // $log = 'edits a {$SINGULAR_NAME} "' . ${$SINGULAR_NAME}->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = {$MODEL}::findOrFail($input['seoable_id']);
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

        $data = {$MODEL}::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->{$NAME_COLUMN};
        }
        // $log = 'deletes a new {$SINGULAR_NAME} "' . implode(', ', $names) . '"';
        // Activity::create($log);

        {$MODEL}::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('admin{$ROUTE_NAME}')
        ];

        return response()->json($response);
    }
    {$CROP_FUNCTIONS}
/** Copy/paste these lines to app\Http\routes.web.php 
Route::get('admin/{$FOLDER_NAME}', array('as'=>'admin{$ROUTE_NAME}','uses'=>'Admin\{$MODEL}Controller@index'));
Route::get('admin/{$FOLDER_NAME}/create', array('as'=>'admin{$ROUTE_NAME}Create','uses'=>'Admin\{$MODEL}Controller@create'));
Route::post('admin/{$FOLDER_NAME}/', array('as'=>'admin{$ROUTE_NAME}Store','uses'=>'Admin\{$MODEL}Controller@store'));
Route::get('admin/{$FOLDER_NAME}/{id}/show', array('as'=>'admin{$ROUTE_NAME}Show','uses'=>'Admin\{$MODEL}Controller@show'));
Route::get('admin/{$FOLDER_NAME}/{id}/view', array('as'=>'admin{$ROUTE_NAME}View','uses'=>'Admin\{$MODEL}Controller@view'));
Route::get('admin/{$FOLDER_NAME}/{id}/edit', array('as'=>'admin{$ROUTE_NAME}Edit','uses'=>'Admin\{$MODEL}Controller@edit'));
Route::patch('admin/{$FOLDER_NAME}/{id}', array('as'=>'admin{$ROUTE_NAME}Update','uses'=>'Admin\{$MODEL}Controller@update'));
Route::post('admin/{$FOLDER_NAME}/seo', array('as'=>'admin{$ROUTE_NAME}Seo','uses'=>'Admin\{$MODEL}Controller@seo'));
Route::delete('admin/{$FOLDER_NAME}/destroy', array('as'=>'admin{$ROUTE_NAME}Destroy','uses'=>'Admin\{$MODEL}Controller@destroy'));
{$CROP_ROUTES}*/
}
