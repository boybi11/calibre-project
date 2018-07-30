@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li><a href="{{route('adminProfile')}}">Profile</a></li>
  <li class="active">Change Password</li>
</ol>
@stop

@section('content')
<div class="col-sm-8">
  <div class="widget">
    <div class="header">
      <i class="fa fa-file"></i> Form
    </div>
  </div>
  {!! Form::model($user, ['route'=>['adminProfilePasswordUpdate'], 'method' => 'patch', 'class'=>'form form-parsley']) !!}
  <div class="form-group">
  	<label for="current">Current</label>
  	{!! Form::password('current', ['class'=>'form-control', 'id'=>'current', 'placeholder'=>'', 'required']) !!}
  </div>
  <div class="form-group">
  	<label for="new">New</label>
  	{!! Form::password('new', ['class'=>'form-control', 'id'=>'new', 'placeholder'=>'', 'required', 'data-parsley-minlength'=>'6']) !!}
  </div>
  <div class="form-group">
  	<label for="new_confirmation">Re-type new</label>
  	{!! Form::password('new_confirmation', ['class'=>'form-control', 'id'=>'new_confirmation', 'placeholder'=>'', 'required', 'data-parsley-equalto'=>'#new', 'data-parsley-minlength'=>'6']) !!}
  </div>
  <div class="form-group clearfix">
    <a href="{{route('adminProfile')}}" class="btn btn-default">Back</a>
    <button type="submit" class="btn btn-primary pull-right">
      <i class="fa fa-check" aria-hidden="true"></i>
      Save
    </button>
  </div>
  {!! Form::close() !!}
</div>
@stop