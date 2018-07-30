@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li><a href="{{route('adminUsers')}}">Users</a></li>
  <li class="active">View</li>
</ol>
@stop

@section('content')
<div class="col-md-8">
	<table class='table table-striped table-bordered table-view'>
		<tr>
			<th>Id</th>
			<td>{!!$data->id!!}</td>
		</tr>
		<tr>
			<th>Name</th>
			<td>{!!$data->name!!}</td>
		</tr>
		<tr>
			<th>Email</th>
			<td>{!!$data->email!!}</td>
		</tr>
		<tr>
			<th>Password</th>
			<td>{!!$data->password!!}</td>
		</tr>
		<tr>
			<th>Cms</th>
			<td>{!!$data->cms!!}</td>
		</tr>
		<tr>
			<th>Verified</th>
			<td>{!!$data->verified!!}</td>
		</tr>
		<tr>
			<th>Status</th>
			<td>{!!$data->status!!}</td>
		</tr>
		<tr>
			<th>Type</th>
			<td>{!!$data->type!!}</td>
		</tr>
		<tr>
			<th>Last login</th>
			<td>{!!$data->last_login!!}</td>
		</tr>
		<tr>
			<th>Last ip</th>
			<td>{!!$data->last_ip!!}</td>
		</tr>
		<tr>
			<th>Remember token</th>
			<td>{!!$data->remember_token!!}</td>
		</tr>
		<tr>
			<th>Created at</th>
			<td>
				@if ($data->created_at)
				<?php $created_at = new Carbon($data->created_at); ?>
				{{$created_at->toFormattedDateString() . ' ' . $created_at->toTimeString()}}
				@endif
			</td>
		</tr>
		<tr>
			<th>Updated at</th>
			<td>
				@if ($data->updated_at)
				<?php $created_at = new Carbon($data->updated_at); ?>
				{{$created_at->toFormattedDateString() . ' ' . $created_at->toTimeString()}}
				@endif
			</td>
		</tr>
	</table>
</div>
@stop