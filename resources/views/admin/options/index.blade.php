@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li class="active">Options</li>
</ol>
@stop

@section('content')
<div class="col-sm-12">
  <div class="widget">
    <div class="header">
      <i class="fa fa-table"></i> Table
      <div class="pull-right">
        <a class="btn-transparent btn-sm" href="{{route('adminOptions')}}"><i class="fa fa-eye"></i> Show All</a>
        <a class="btn-transparent btn-sm" href="{{route('adminOptionsCreate')}}"><i class="fa fa-plus-circle"></i> Create</a>
        <a class="btn-transparent btn-sm" href="#" data-toggle="modal" data-target="#delete-modal"><i class="fa fa-minus-circle"></i> Delete</a>
      </div>
    </div>
    <div class="filters">
      {!! Form::open(['route'=>'adminOptions', 'method' => 'get']) !!}
      <label>
        Search: {!! Form::text('name', null, ['class'=>'form-control input-sm', 'placeholder'=>'', 'required']) !!}
        <button><i class="fa fa-search"></i></button>
      </label>
      {!! Form::close() !!}
    </div>
    <div class="table-responsive">
      {!! Form::open(['route'=>'adminOptionsDestroy', 'method' => 'delete', 'class'=>'form form-parsley form-delete']) !!}
      <table class="table table-bordered table-hover table-striped">
        <thead>
          <tr>
            <th width="30px">
              <label>
                <input type="checkbox" name="delete-all" class="toggle-delete-all">
                <i class="fa fa-square input-unchecked"></i>
                <i class="fa fa-check-square input-checked"></i>
              </label>
            </th>
            <th>ID</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Type</th>
            <th>Value</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $d)
          <tr>
            <td>
              @unless ($d->permanent)
              <label>
                <input type="checkbox" name="ids[]" value="{{$d->id}}">
                <i class="fa fa-square input-unchecked"></i>
                <i class="fa fa-check-square input-checked"></i>
              </label>
              @endunless
            </td>
            <td>{{$d->id}}</td>
            <td>{{$d->name}}</td>
            <td>{{$d->slug}}</td>
            <td>{{$d->type}}</td>
            <td>
              @if ($d->type == 'text')
              {{$d->value}}
              @else
              <div class="sumo-asset-display" data-id="{{$d->asset}}" data-url="{{route('adminAssetsGet')}}"></div>
              @endif
            </td>
            <td width="110px" class="text-center">
              <a href="{{route('adminOptionsView', [$d->id])}}" class="btn btn-primary btn-xs">VIEW</a>
              <a href="{{route('adminOptionsEdit', [$d->id])}}" class="btn btn-primary btn-xs">EDIT</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {!! Form::close() !!}
      @if ($pagination)
      <div class="pagination-links text-right">
        {!! $pagination !!}
      </div>
      @endif
    </div>
  </div>
</div>
@stop