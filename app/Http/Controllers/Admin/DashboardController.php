<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;

use App\Activity;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $activities = Activity::with('user')->latest()->paginate(25);
        $pagination = $activities->appends($request->except('page'))->links();

        return view('admin/dashboard/index')
            ->with('title', 'Dashboard')
            ->with('menu', 'dashboard')
            ->with('data', $activities)
            ->with('pagination', $pagination);
    }
}
