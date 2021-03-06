@extends('layouts.admin')

@section('content')
<div class="col-sm-12">
  <div class="widget">
    <div class="header">
      <i class="fa fa-table"></i> Samples
      <div class="pull-right">
        <a class="btn-transparent btn-sm" href="{{route('adminSamplesCreate')}}"><i class="fa fa-plus-circle"></i> Create</a>
        <a class="btn-transparent btn-sm" href="#"><i class="fa fa-minus-circle"></i> Delete</a>
      </div>
    </div>
    <div class="table-responsive">
      {!! Form::open(['route'=>'adminSamplesDestroy', 'method' => 'delete', 'class'=>'form form-parsley form-delete']) !!}
      <table class="table table-bordered table-hover table-striped datatable">
        <thead>
          <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Runes</th>
            <th>Embedded Rune</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $d)
          <tr>
            <td>
              <label>
                <input type="checkbox" name="ids[]" value="{{$d->id}}">
                <i class="fa fa-square input-unchecked"></i>
                <i class="fa fa-check-square input-checked"></i>
              </label>
            </td>
            <td>{{$d->id}}</td>
            <td>{{$d->name}}</td>
            <td>{{$d->runes}}</td>
            <td>{{$d->embedded_rune}}</td>
            <td>
              <button type="button" class="btn btn-primary btn-xs" role="button" data-toggle="popover" 
                data-trigger="focus" title="{{$d->name}}" data-placement="left" data-html="true"
                data-content="@include('admin.samples.show', ['sample' => $d])">
                VIEW
              </button>
              <a href="{{route('adminSamplesEdit', [$d->id])}}" class="btn btn-primary btn-xs">EDIT</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {!! Form::close() !!}
    </div>
  </div>
</div>
@stop