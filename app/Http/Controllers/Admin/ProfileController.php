<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\ProfilePasswordUpdateRequest;
use App\Http\Controllers\Controller;
use Acme\Facades\Activity;
use Illuminate\Support\Facades\Auth;
use App\User;
use Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin/profile/index')
            ->with('title', 'Profile')
            ->with('user', Auth::user());
    }

    public function edit()
    {
        return view('admin/profile/edit')
            ->with('title', 'Edit Profile')
            ->with('user', Auth::user());
    }

    public function update(ProfileUpdateRequest $request)
    {
        $input = $request->all();

        $user = User::findOrFail(Auth::user()->id);
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->save();

        $log = 'updates profile';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function password_edit()
    {
        return view('admin/profile/password_edit')
            ->with('title', 'Profile Change Password')
            ->with('user', Auth::user());
    }

    public function password_update(ProfilePasswordUpdateRequest $request)
    {
        $input = $request->all();
        $auth = Auth::user();

        if (Hash::check($input['current'], $auth->password)) {
            $user = User::findOrFail($auth->id);
            $user->password = Hash::make($input['new']);
            $user->save();

            $log = 'updates password';
            Activity::create($log);

            $response = [
                'notifTitle'=>'Save successful.',
                'notifMessage'=>'Redirecting to profile.',
                'resetForm'=>true,
                'redirect'=>route('adminProfile')
            ];
        } else {
            $response = [
                'notifTitle'=>'Password does not match.',
            ];
        }

        return response()->json($response);
    }

}
