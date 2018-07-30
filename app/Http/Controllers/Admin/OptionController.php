<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\OptionRequest;

use Image; 
use Acme\Facades\Activity;
use App\Option;

class OptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        if ($name = $request->name) {
            $data = Option::where('name', 'LIKE', '%' . $name . '%')->paginate(25);
        } else {
            $data = Option::paginate(25);
        }
        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/options/index')
            ->with('title', 'Options')
            ->with('menu', 'options')
            ->with('data', $data)
            ->with('pagination', $pagination);
    }

    public function create()
    {
        return view('admin/options/create')
            ->with('title', 'Create option')
            ->with('menu', 'options');
    }
    
    public function store(OptionRequest $request)
    {
        $input = $request->all();
        $option = Option::create($input);

        $log = 'creates a new option "' . $option->name . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('adminOptionsEdit', [$option->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/options/show')
            ->with('title', 'Show option')
            ->with('menu', 'options')
            ->with('data', Option::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/options/view')
            ->with('title', 'View option')
            ->with('menu', 'options')
            ->with('data', Option::findOrFail($id));
    }
    
    public function edit($id)
    {
        return view('admin/options/edit')
            ->with('title', 'Edit option')
            ->with('menu', 'options')
            ->with('data', Option::findOrFail($id));
    }

    public function update(OptionRequest $request, $id)
    {
        $input = $request->all();
        $option = Option::findOrFail($id);
        $option->update($input);

        $log = 'edits a option "' . $option->name . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.'
        ];

        return response()->json($response);
    }
    
    public function destroy(Request $request)
    {
        $input = $request->all();

        $data = Option::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->name;
        }
        $log = 'deletes a new option "' . implode(', ', $names) . '"';
        Activity::create($log);

        Option::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminOptions')
        ];

        return response()->json($response);
    }
    
/** Copy/paste these lines to app\Http\routes.php 
Route::get('admin/options', array('as'=>'adminOptions','uses'=>'Admin\OptionController@index'));
Route::get('admin/options/create', array('as'=>'adminOptionsCreate','uses'=>'Admin\OptionController@create'));
Route::post('admin/options/', array('as'=>'adminOptionsStore','uses'=>'Admin\OptionController@store'));
Route::get('admin/options/{id}/show', array('as'=>'adminOptionsShow','uses'=>'Admin\OptionController@show'));
Route::get('admin/options/{id}/view', array('as'=>'adminOptionsView','uses'=>'Admin\OptionController@view'));
Route::get('admin/options/{id}/edit', array('as'=>'adminOptionsEdit','uses'=>'Admin\OptionController@edit'));
Route::patch('admin/options/{id}', array('as'=>'adminOptionsUpdate','uses'=>'Admin\OptionController@update'));
Route::delete('admin/options/destroy', array('as'=>'adminOptionsDestroy','uses'=>'Admin\OptionController@destroy'));
*/
}
