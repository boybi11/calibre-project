@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li class="active">Profile</li>
</ol>
@stop

@section('content')
<div class="col-sm-7">
  <div class="widget">
    <div class="header">
      <i class="fa fa-table"></i>
      <div class="pull-right">
        <a class="btn-transparent btn-sm" href="{{route('adminProfileEdit')}}"><i class="fa fa-pencil"></i> Edit</a>
        <a class="btn-transparent btn-sm" href="{{route('adminProfilePasswordEdit')}}"><i class="fa fa-unlock-alt"></i> Change Password</a>
      </div>
    </div>
  </div>
  <table class='table table-striped table-bordered'>
  	<tr>
  		<th>Name</th>
  		<td>{{$user->name}}</td>
  	</tr>
  	<tr>
  		<th>Email</th>
  		<td>{{$user->email}}</td>
  	</tr>
  	<tr>
  		<th>Cms</th>
  		<td>{{$user->cms}}</td>
  	</tr>
  	<tr>
  		<th>Verified</th>
  		<td>{{$user->verified}}</td>
  	</tr>
  	<tr>
  		<th>Status</th>
  		<td>{{$user->status}}</td>
  	</tr>
  	<tr>
  		<th>Type</th>
  		<td>{{$user->type}}</td>
  	</tr>
  	<tr>
  		<th>Last login</th>
  		<td>{{$user->last_login}}</td>
  	</tr>
  	<tr>
  		<th>Last IP</th>
  		<td>{{$user->last_ip}}</td>
  	</tr>
  </table>
</div>
@stop
