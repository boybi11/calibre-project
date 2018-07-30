<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use App\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin/auth/login');
    }

    public function authenticate(Request $request)
    {
        $input = $request->all();
        if (Auth::attempt(['email' => $input['email'], 'password' => $input['password'], 'status' => 'active', 'cms' => 1])) {
            $user = User::findOrFail(Auth::user()->id);
            $user->last_ip = $request->ip();
            $user->last_login = new Carbon();
            $user->save();

            return redirect()->route('adminSamples');
        } else {
            $errors = new MessageBag(['message' => ['Email and/or password invalid.']]);
            return redirect()->back()->withErrors($errors)->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('adminLogin');
    }
}
