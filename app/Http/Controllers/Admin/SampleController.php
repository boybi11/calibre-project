<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\SampleRequest;

use Image; 
use Acme\Facades\Activity;
use Illuminate\Support\Facades\Auth;

use App\Sample;
use App\Asset;
use App\Seo;

class SampleController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        if ($name = $request->name) {
            $samples = Sample::where('name', 'LIKE', '%' . $name . '%')->paginate(25);
        } else {
            $samples = Sample::paginate(25);
        }
        $pagination = $samples->appends($request->except('page'))->links();

        return view('admin/samples/index')
            ->with('title', 'Samples')
            ->with('menu', 'samples')
            ->with('keyword', $request->name)
            ->with('data', $samples)
            ->with('pagination', $pagination);
    }

    public function datatable()
    {
        return view('admin/samples/datatable')->with('data', Sample::all());
    }
    
    public function create()
    {
        return view('admin/samples/create')
            ->with('title', 'Create Sample')
            ->with('menu', 'samples');
    }
    
    public function store(SampleRequest $request)
    {
        $input = $request->all();
        $sample = Sample::create($input);

        $log = 'creates a new sample "' . $sample->name . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('adminSamplesEdit', [$sample->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/samples/show')
            ->with('title', 'Show Sample')
            ->with('sample', Sample::findOrFail($id));
    }

    public function view($id)
    {
        $data = Sample::findOrFail($id);
        $seo = $data->seo->first();

        return view('admin/samples/view')
            ->with('title', 'View Sample')
            ->with('menu', 'samples')
            ->with('data', $data)
            ->with('seo', $seo);
    }
    
    public function edit($id)
    {
        $data = Sample::findOrFail($id);
        $seo = $data->seo->first();

        return view('admin/samples/edit')
            ->with('title', 'Edit Sample')
            ->with('menu', 'samples')
            ->with('data', $data)
            ->with('seo', $seo);
    }

    public function update(SampleRequest $request, $id)
    {
        $input = $request->all();

        $sample = Sample::findOrFail($id);
        $sample->name = $input['name'];
        $sample->range = $input['range'];
        $sample->image = $input['image'];
        $sample->runes = $input['runes'];
        $sample->embedded_rune = $input['embedded_rune'];
        $sample->evaluation = $input['evaluation'];
        $sample->save();

        $log = 'edits a sample "' . $sample->name . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = Sample::findOrFail($input['seoable_id']);
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

        $samples = Sample::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($samples as $s) {
            $names[] = $s->name;
        }
        $log = 'deletes a new sample "' . implode(', ', $names) . '"';
        Activity::create($log);

        Sample::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminSamples')
        ];

        return response()->json($response);
    }

    public function crop_url(Request $request)
    {
        $input = $request->all();
        $response = [
            'redirect'=>route('adminSamplesCropForm', [$input['id'], $input['column'], $input['asset_id']])
        ];

        return response()->json($response);
    }

    public function crop_form($id, $column, $asset_id)
    {
        $dimensions = ['width'=>300, 'height'=>300];

        return view('admin/samples/crop')
            ->with('title', 'Crop Image')
            ->with('data', Sample::findOrFail($id))
            ->with('column', $column)
            ->with('asset', Asset::findOrFail($asset_id))
            ->with('dimensions', $dimensions);
    }

    public function crop(Request $request, $id)
    {
        $input = $request->all();
        $asset = Asset::findOrFail($input['asset_id']);
        
        $filename = str_slug('sample-' . $id . '-' . $input['column']);
        $image = Image::make($asset->path);
        $thumbnail = 'upload/thumbnails/' . $filename . '.' . $image->extension;
        $image->crop($input['crop_width'], $input['crop_height'], $input['x'], $input['y'])
            ->resize($input['target_width'], $input['target_height'])
            ->save($thumbnail, 100);

        $sample = Sample::findOrFail($id);
        $sample->$input['column'] = $thumbnail;
        $sample->save();

        $log = 'crops image thumbnail of sample "' . $sample->name . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Crop successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminSamplesCropForm', [$sample->id, $input['column'], $asset->id])
        ];

        return response()->json($response);
    }
}
