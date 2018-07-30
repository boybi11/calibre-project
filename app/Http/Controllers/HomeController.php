<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Acme\Facades\Seo;
use App\Sample;

class HomeController extends Controller
{
    public function index()
    {
        return view('app/home');
    }

    public function seo()
    {
        $sample = Sample::findOrFail(1);
        $seo = Seo::get($sample);

        return view('app/home');
    }
}
