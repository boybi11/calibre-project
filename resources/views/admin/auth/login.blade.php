@extends('layouts.admin-auth')

@section('content')
<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <div class="panel">
      <div class="panel-heading text-center">Admin Login</div>
      <div class="panel-body">
        {!! Form::open(['route'=>'adminAuthenticate', 'class'=>'form']) !!}
        <div class="form-group">
          <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="{{ old('email') }}">
        </div>
        <div class="form-group">
          <input type="password" name="password" class="form-control" id="password" placeholder="Password">
        </div>
        <div class="form-group text-center">
          <button type="submit" class="btn btn-primary btn-block">Login</button>
        </div>
        <div class="form-group text-center">
          <a href="#">Forgot password?</a>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
@stop