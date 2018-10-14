<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\League;
use App\User;

use Acme\Facades\Activity;
use Acme\Facades\Option;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {

        if ($name = $request->name) {
            $class = League::where('name', 'LIKE', '%' . $name . '%')->paginate(25);
        } else {
            $class = League::paginate(25);
        }

        $pagination = $class->appends($request->except('page'))->links();

        return view('admin/classes/index')
            ->with('title', 'Classes')
            ->with('menu', 'class')
            ->with('keyword', @$name)
            ->with('data', $class)
            ->with('pagination', $pagination);
    }

    public function create()
    {
        $gm_list = [];
        $gms = User::where('front_user_type', 'teacher')->get();

        foreach ($gms as $key => $value) {
            $gm_list[$value->id] = $value->first_name . ' ' . $value->last_name;
        }

        return view('admin/classes/create')
            ->with('gms', $gm_list)
            ->with('title', 'Create Class');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
        $options = Option::email();
        
        $class = new League;
        $class->name = $input['name'];
        $class->slug = join("-", explode(" ", strtolower($input['name'])));
        $class->gm_id = $input['gm_id'];
        $class->save();

        $log = 'creates a new class "' . $class->name . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to class list.',
            'resetForm'=>true,
            'redirect'=>route('adminClasses')
        ];

        return response()->json($response);
    }

    public function show($id)
    {
        return view('admin/classes/show')
            ->with('title', 'Show Class')
            ->with('class', League::findOrFail($id));
    }

    public function edit($id)
    {
        $gm_list = [];
        $gms = User::where('front_user_type', 'teacher')->get();

        foreach ($gms as $key => $value) {
            $gm_list[$value->id] = $value->first_name . ' ' . $value->last_name;
        }

        return view('admin/classes/edit')
            ->with('title', 'Edit Class')
            ->with('menu', 'class')
            ->with('gms', $gm_list)
            ->with('data', League::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $class = League::findOrFail($id);
        $class->name = $input['name'];
        $class->slug = join("-", explode(" ", strtolower($input['name'])));
        $class->gm_id = $input['gm_id'];
        $class->save();

        $log = 'edits a class "' . $class->name . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function destroy(Request $request)
    {
        $input = $request->all();

        $samples = League::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($samples as $s) {
            $names[] = $s->name;
        }
        $log = 'deletes a new sample "' . implode(', ', $names) . '"';
        Activity::create($log);

        League::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminClasses')
        ];

        return response()->json($response);
    }
}
