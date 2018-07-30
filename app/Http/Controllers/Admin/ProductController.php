<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;

use Acme\Facades\Activity;
use App\Product;
use App\Seo;

use Image;
use App\Asset;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        if ($name = $request->name) {
            $data = Product::where('name', 'LIKE', '%' . $name . '%')->paginate(25);
        } else {
            $data = Product::paginate(25);
        }
        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/products/index')
            ->with('title', 'Products')
            ->with('menu', 'products')
            ->with('keyword', $request->name)
            ->with('data', $data)
            ->with('pagination', $pagination);
    }

    public function create()
    {
        return view('admin/products/create')
            ->with('title', 'Create product')
            ->with('menu', 'products');
    }
    
    public function store(ProductRequest $request)
    {
        $input = $request->all();
        $product = Product::create($input);

        // $log = 'creates a new product "' . $product->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('adminProductsEdit', [$product->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/products/show')
            ->with('title', 'Show product')
            ->with('data', Product::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/products/view')
            ->with('title', 'View product')
            ->with('menu', 'products')
            ->with('data', Product::findOrFail($id));
    }
    
    public function edit($id)
    {
        $data = Product::findOrFail($id);
        $seo = $data->seo();

        return view('admin/products/edit')
            ->with('title', 'Edit product')
            ->with('menu', 'products')
            ->with('data', $data)
            ->with('seo', $seo);
    }

    public function update(ProductRequest $request, $id)
    {
        $input = $request->all();
        $product = Product::findOrFail($id);
        $product->update($input);

        // $log = 'edits a product "' . $product->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = Product::findOrFail($input['seoable_id']);
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

        $data = Product::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->name;
        }
        // $log = 'deletes a new product "' . implode(', ', $names) . '"';
        // Activity::create($log);

        Product::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminProducts')
        ];

        return response()->json($response);
    }
    
    public function crop_url(Request $request)
    {
        $input = $request->all();
        $response = [
            'redirect'=>route('adminProductsCropForm', [$input['id'], $input['column'], $input['asset_id']])
        ];

        return response()->json($response);
    }

    public function crop_form($id, $column, $asset_id)
    {
        $dimensions = ['width'=>300, 'height'=>300];

        return view('admin/products/crop')
            ->with('title', 'Crop Image')
            ->with('data', Product::findOrFail($id))
            ->with('column', $column)
            ->with('asset', Asset::findOrFail($asset_id))
            ->with('dimensions', $dimensions);
    }

    public function crop(Request $request, $id)
    {
        $input = $request->all();
        $asset = Asset::findOrFail($input['asset_id']);
        
        $filename = str_slug('product-' . $id . '-' . $input['column']);
        $image = Image::make($asset->path);
        $thumbnail = 'upload/thumbnails/' . $filename . '.' . $image->extension;
        $image->crop($input['crop_width'], $input['crop_height'], $input['x'], $input['y'])
            ->resize($input['target_width'], $input['target_height'])
            ->save($thumbnail, 100);

        $data = Product::findOrFail($id);
        $data->$input['column'] = $thumbnail;
        $data->save();

        $log = 'crops ' . $input['column'] . ' of product "' . $data->name . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Crop successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminProductsCropForm', [$data->id, $input['column'], $asset->id])
        ];

        return response()->json($response);
    }

/** Copy/paste these lines to app\Http\routes.web.php 
Route::get('admin/products', array('as'=>'adminProducts','uses'=>'Admin\ProductController@index'));
Route::get('admin/products/create', array('as'=>'adminProductsCreate','uses'=>'Admin\ProductController@create'));
Route::post('admin/products/', array('as'=>'adminProductsStore','uses'=>'Admin\ProductController@store'));
Route::get('admin/products/{id}/show', array('as'=>'adminProductsShow','uses'=>'Admin\ProductController@show'));
Route::get('admin/products/{id}/view', array('as'=>'adminProductsView','uses'=>'Admin\ProductController@view'));
Route::get('admin/products/{id}/edit', array('as'=>'adminProductsEdit','uses'=>'Admin\ProductController@edit'));
Route::patch('admin/products/{id}', array('as'=>'adminProductsUpdate','uses'=>'Admin\ProductController@update'));
Route::post('admin/products/seo', array('as'=>'adminProductsSeo','uses'=>'Admin\ProductController@seo'));
Route::delete('admin/products/destroy', array('as'=>'adminProductsDestroy','uses'=>'Admin\ProductController@destroy'));
Route::get('admin/products/crop/url', array('as'=>'adminProductsCropUrl','uses'=>'Admin\ProductController@crop_url'));
Route::get('admin/products/{id}/crop/{column}/{asset_id}', array('as'=>'adminProductsCropForm','uses'=>'Admin\ProductController@crop_form'));
Route::patch('admin/products/{id}/crop', array('as'=>'adminProductsCrop','uses'=>'Admin\ProductController@crop'));
*/
}
