@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li><a href="{{route('adminOptions')}}">Options</a></li>
  <li><a href="{{route('adminOptionsEdit', [$data->id])}}">Edit</a></li>
  <li class="active">Crop</li>
</ol>
@stop

@section('content')
<div class="col-sm-12">
  <div class="widget">
    <div class="header">
      <i class="fa fa-crop"></i>
    </div>
  </div>
  {!! Form::open(['route'=>['adminOptionsCrop', $data->id], 'files' => true, 'method' => 'patch', 'class'=>'form form-parsley form-crop']) !!}
  <div class="form-group">
    <label for="name">Image</label>
    {!! Html::image($asset->path, '', ['id'=>'crop-target']) !!}
  </div>
  <div class="form-group">
    <label for="name">Current thumbnail</label>
    {!! Html::image($data->$column . '?exp=' . str_random(10), '') !!}
  </div>
  {!! Form::hidden('asset_id', $asset->id) !!}
  {!! Form::hidden('column', $column) !!}
  {!! Form::hidden('target_width', $dimensions['width']) !!}
  {!! Form::hidden('target_height', $dimensions['height']) !!}
  {!! Form::hidden('crop_width', null) !!}
  {!! Form::hidden('crop_height', null) !!}
  {!! Form::hidden('x', null) !!}
  {!! Form::hidden('y', null) !!}
  <button type="submit" class="btn btn-primary">Crop</button>
  {!! Form::close() !!}
</div>
@stop