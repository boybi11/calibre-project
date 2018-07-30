<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Asset;

class AssetController extends Controller
{
  private $upload_path = './upload/assets';
	private $redactor_path = './upload/redactor';

  public function upload(Request $request)
  {
    $input = $request->all();
    if ($request->hasFile('photo')) {
      $photo = $request->file('photo');
      $filename = str_random(50) . '.' . $photo->getClientOriginalExtension();
      $photo->move($this->upload_path, $filename);
      $filepath = 'upload/assets/' . $filename;

      $asset = new Asset;
      $asset->path = $filepath;
      $asset->save();

      if ($input['type'] == 'image') {
        $filepath = url($filepath);
      } else {
        $filepath = url('img/admin/file-' . $input['type'] . '.png');
      }

      $response = [
        'id'=>$asset->id,
        'filepath'=>url($filepath)
      ];
      return response()->json($response);
    }
  }

  public function redactor(Request $request)
  {
    if ($request->hasFile('file')) {
      $photo = $request->file('file');
      $filename = str_random(50) . '.' . $photo->getClientOriginalExtension();
      $photo->move($this->redactor_path, $filename);
      $filepath = $this->redactor_path . '/' . $filename;

      $response = [
        'url'=>url($filepath),
        'filelink' => url($filepath),
        'path' => $this->redactor_path
      ];
      return response()->json($response);
    }
  }

  public function all(Request $request)
  {
    $batch = 10;
    $assets = Asset::skip($request['count'])->take($batch)->get();
    foreach ($assets as $a) {
      $mimetype = \GuzzleHttp\Psr7\mimetype_from_filename($a->path);
      $mime = explode('/', $mimetype);
      if ($mime[0] == 'image') {
        $a->mime_path = $a->path;
      } else {
        if ($mime[0] == 'audio' || $mime[0] == 'video') {
          $a->mime_path = 'img/admin/file-' . $mime[0] . '.png';
        } else {
          $a->mime_path = 'img/admin/file-file.png';
        }
      }
    }

    $view = view('admin/modals/assets-list')
      ->with('assets', $assets)
      ->render();
    $next = Asset::skip($request['count'] + $batch)->take($batch)->get();

    $response = [
    'view'=>$view,
    'next'=>count($next)
    ];
    return response($response);
  }

  public function get(Request $request) 
  {
    $input = $request->all();
    $asset = Asset::find($input['id']);

    $mimetype = \GuzzleHttp\Psr7\mimetype_from_filename($asset->path);
    $mime = explode('/', $mimetype);
    if ($mime[0] == 'image') {
      $asset->absolute_path = url($asset->path);
    } else {
      if ($mime[0] == 'audio' || $mime[0] == 'video') {
        $asset->absolute_path = url('img/admin/file-' . $mime[0] . '.png');
      } else {
        $asset->absolute_path = url('img/admin/file-file.png');
      }
    }
    return response()->json($asset);
  }

  public function download(Request $request)
  {
    $input = $request->all();
    $asset = Asset::find($input['id']);
    return response()->download($asset->path);
  }

  public function update(Request $request) 
  {
    $input = $request->all();
    $asset = Asset::findOrFail($input['id']);
    $asset->name = $input['name'];
    $asset->caption = $input['caption'];
    $asset->alt = $input['alt'];
    $asset->save();

    $response = [
      'notifTitle'=>'Save successful.',
    ];
    return response()->json($response);
  }

  public function destroy(Request $request)
  {
    $input = $request->all();
    Asset::findOrFail($input['id'])->delete();
    $response = [
      'notifTitle'=>'Delete successful.',
    ];
    return response()->json($response);
  }
}
