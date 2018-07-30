<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Acme\Facades\Activity;
use App\Seo;

// add models here
use App\Sample;

class SeoController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function save(Request $request)
    {
        $input = $request->all();
        $data = App\$input['sample']::new();
        dd($data);

        $seo = Seo::whereSeoable_id($input['seoable_id'])->whereSeoable_type($input['seoable_id'])->first();
        if (is_null($seo)) {
            $seo = Seo::create($input);
        } else {
            $seo->update($input);
        }

        $response = [
            'notifTitle'=>'SEO Save successful.',
        ];

        return response()->json($response);
    }
}