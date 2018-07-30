@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li><a href="{{route('adminUsers')}}">Users</a></li>
  <li class="active">Edit</li>
</ol>
@stop

@section('content')
<div class="col-sm-8">
  <div class="widget">
    <div class="header">
      <i class="fa fa-file"></i> Form
    </div>
  </div>
  {!! Form::model($user, ['route'=>['adminUsersUpdate', $user->id], 'method' => 'patch', 'class'=>'form form-parsley']) !!}
  @include('admin.users.form')
  {!! Form::close() !!}
</div>
@stop