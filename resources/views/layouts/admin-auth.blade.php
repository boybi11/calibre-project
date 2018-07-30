<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <meta name="viewport" content="width=device-width">
  {!! Html::style('css/admin.css') !!}
</head>
<body>
  <div id="login">
    @if ($error = $errors->first('message'))
    <div class="alert alert-danger text-center" role="alert">
      {{$error}}
    </div>
    @endif
    @if (session('status'))
    <div class="alert alert-success text-center" role="alert">
      {{ session('status') }}
    </div>
    @endif
    <div class="container">
      @yield('content')
    </div>
  </div>
</body>
</html>