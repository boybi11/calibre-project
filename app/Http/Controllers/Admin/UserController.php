<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Controllers\Controller;
use App\User;
use Hash;
use Mail;

use Acme\Facades\Activity;
use Acme\Facades\Option;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        $this->middleware('super', ['only' => ['edit', 'update']]);
    }

    public function index(Request $request)
    {
        if ($name = $request->name) {
            $users = User::where('name', 'LIKE', '%' . $name . '%')->paginate(25);
        } else {
            $users = User::paginate(25);
        }
        $pagination = $users->appends($request->except('page'))->links();

        return view('admin/users/index')
            ->with('title', 'Users')
            ->with('menu', 'users')
            ->with('data', $users)
            ->with('pagination', $pagination);
    }

    public function datatable()
    {
        return view('admin/users/datatable')->with('data', User::all());
    }

    public function create()
    {
        Option::email();
        return view('admin/users/create')
            ->with('title', 'Create User');
    }
    
    public function store(UserStoreRequest $request)
    {
        $input = $request->all();
        $options = Option::email();

        $data = [];
        $data['user'] = $input;
        $data['password'] = str_random(8);
        $data['options'] = $options;

        Mail::send('emails.user-create', $data, function ($m) use ($input, $options) {
            $m->from($options['email'], $options['name']);
            $m->to($input['email'], $input['name'])->subject($options['name'] . ': User account created');
        });
        
        $user = new User;
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->cms = $input['cms'];
        $user->password = bcrypt($data['password']);
        $user->verified = 1;
        $user->status = 'active';
        $user->type = $input['type'];
        $user->save();

        $log = 'creates a new user "' . $user->name . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to users list.',
            'resetForm'=>true,
            'redirect'=>route('adminUsers')
        ];

        return response()->json($response);
    }

    public function show($id)
    {
        return view('admin/users/show')
            ->with('title', 'Show User')
            ->with('user', User::findOrFail($id));
    }

    public function edit($id)
    {
        return view('admin/users/edit')
            ->with('title', 'Edit User')
            ->with('menu', 'users')
            ->with('user', User::findOrFail($id));
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $input = $request->all();

        $user = User::findOrFail($id);
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->cms = $input['cms'];
        $user->type = $input['type'];
        $user->save();

        $log = 'edits a user "' . $user->name . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function destroy(Request $request)
    {
        $input = $request->all();

        $samples = User::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($samples as $s) {
            $names[] = $s->name;
        }
        $log = 'deletes a new sample "' . implode(', ', $names) . '"';
        Activity::create($log);

        User::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminUsers')
        ];

        return response()->json($response);
    }
}
