@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li><a href="{{route('admin{$ROUTE}')}}">{$TITLE}</a></li>
  <li><a href="{{route('admin{$ROUTE}Edit', [$data->id])}}">Edit</a></li>
  <li class="active">Crop</li>
</ol>
@stop

@section('content')
<div class="col-sm-12">
  <div class="widget">
    <div class="header">
      <i class="fa fa-crop"></i> Form
    </div>
  </div>
  {!! Form::open(['route'=>['admin{$ROUTE}Crop', $data->id], 'files' => true, 'method' => 'patch', 'class'=>'form form-parsley form-crop']) !!}
  <div class="form-group">
    <strong>Instructions:</strong> Click and drag your mouse in the image.
  </div>
  <div class="form-group">
    <label for="name">Image</label>
    {!! Html::image($asset->path, '', ['id'=>'crop-target']) !!}
  </div>
  <div class="form-group">
    <label for="name">Current thumbnail</label>
    @if ($data->$column)
    {!! Html::image($data->$column . '?exp=' . str_random(10), '') !!}
    @else
    <p>No thumbnail</p>
    @endif
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