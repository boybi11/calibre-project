@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li class="active">Dashboard</li>
</ol>
@stop

@section('content')
<div class="col-sm-8">
  <div class="widget">
    <div class="header">
      <i class="fa fa-table"></i> <!-- Title -->
    </div>
    <div class="table-responsive">
      <table class="table table-bordered table-hover table-striped">
        <tbody>
          @foreach ($data as $d)
          <tr>
            <td>{{$d->log}}</td>
            <td>{{$d->created_at->toDateTimeString()}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @if ($pagination)
      <div class="pagination-links text-right">
        {!! $pagination !!}
      </div>
      @endif
    </div>
  </div>
</div>
@stop