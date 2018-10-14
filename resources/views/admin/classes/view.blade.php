@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="{{route('adminDashboard')}}">Dashboard</a></li>
  <li><a href="{{route('adminSamples')}}">Samples</a></li>
  <li class="active">View</li>
</ol>
@stop

@section('content')
<div class="col-md-8">
	<table class='table table-striped table-bordered table-view'>
		<tr>
			<th>ID</th>
			<td>{{$data->id}}</td>
		</tr>
		<tr>
			<th>Name</th>
			<td>{{$data->name}}</td>
		</tr>
		<tr>
			<th>Range</th>
			<td>{{$data->range}}</td>
		</tr>
		<tr>
			<th>Runes</th>
			<td>{{$data->runes}}</td>
		</tr>
		<tr>
			<th>Embedded Rune</th>
			<td>{{$data->embedded_rune}}</td>
		</tr>
		<tr>
			<th>Evaluation</th>
			<td>{!!$data->evaluation!!}</td>
		</tr>
		<tr>
			<th>Image</th>
			<td>
				<div class="sumo-asset-display" data-id="{{$data->id}}" data-url="{{route('adminAssetsGet')}}"></div>
			</td>
		</tr>
		<tr>
			<th>Created At</th>
			<td>
				@if ($data->created_at)
				<?php $created_at = new Carbon($data->created_at); ?>
				{{$created_at->toFormattedDateString() . ' ' . $created_at->toTimeString()}}
				@endif
			</td>
		</tr>
		<tr>
			<th>Updated At</th>
			<td>
				@if ($data->updated_at)
				<?php $updated_at = new Carbon($data->updated_at); ?>
				{{$updated_at->toFormattedDateString() . ' ' . $updated_at->toTimeString()}}
				@endif
			</td>
		</tr>
		<tr>
			<th>Deleted At</th>
			<td>
				@if ($data->deleted_at)
				<?php $deleted_at = new Carbon($data->deleted_at); ?>
				{{$deleted_at->toFormattedDateString() . ' ' . $deleted_at->toTimeString()}}
				@endif
			</td>
		</tr>
	</table>
	<div class="form-group clearfix">
		<a href="{{route('adminSamples')}}" class="btn btn-default">Back</a>
		<a href="{{route('adminSamplesEdit', [$data->id])}}" class="btn btn-primary pull-right">
			<i class="fa fa-edit" aria-hidden="true"></i>
			Edit
		</a>
	</div>
</div>
@if ($seo)
<div class="col-md-4">
	<h4>SEO</h4>
	<table class="table table-striped table-bordered table-view">
		<tr>
			<th>Title</th>
			<td>{{$seo->title}}</td>
		</tr>
		<tr>
			<th>Description</th>
			<td>{{$seo->description}}</td>
		</tr>
		<tr>
			<th>Image</th>
			<td><div class="sumo-asset-display" data-id="{{$seo->image}}" data-url="{{route('adminAssetsGet')}}"></div></td>
		</tr>
	</table>
</div>
@endif
@stop