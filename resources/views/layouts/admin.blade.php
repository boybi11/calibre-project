<!DOCTYPE html>
<html>
<head>
  <title>Admin</title>
  <meta name="viewport" content="width=device-width">
  {!! Html::style('css/admin-plugins.css') !!}
  {!! Html::style('css/admin.css') !!}
</head>
<body>
  <div id="page-loader" class="loader hide">
    <div class="display-table">
      <div class="display-cell">
        <div class="spinner"></div>
      </div>
    </div>
  </div>
  <nav class="navbar navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">
          {{ HTML::image('img/admin/logo.png') }}
        </a>
      </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="{{route('adminProfile')}}"><i class="fa fa-user"></i></a></li>
          <li><a href="{{route('adminLogout')}}"><i class="fa fa-sign-out"></i></a></li>
          <li><a href="#" class="menu-btn"><i class="fa fa-bars"></i></a></li>
        </ul>
      </div>
    </div>
  </nav>
  <aside>
    <ul>
      <!-- <li class="has-list">
        <a href="#">
          <i class="fa fa-bolt"></i>
          Stuffs
          <span class="collapse-icon">
            <i class="fa fa-plus-square-o p"></i>
            <i class="fa fa-minus-square-o n"></i>
          </span>
        </a>
        <ul>
          <li>
            <a href="#">Analytics</a>
          </li>
          <li>
            <a href="#">Reports</a>
          </li>
        </ul>
      </li> -->
      <li class="{{Menu::active('dashboard', @$menu)}}"><a href="{{route('adminDashboard')}}"><i class="fa fa-home"></i>Dashboard</a></li>
      <li class="{{Menu::active('dashboard', @$menu)}}"><a href="{{route('adminClasses')}}"><i class="fa fa-stack-overflow" aria-hidden="true"></i>Classes</a></li>
      <li class="{{Menu::active('users-gm', @$menu)}}"><a href="{{route('adminUsers', ['category'=>'gm'])}}"><i class="fa fa-user"></i>Game Masters</a></li>
      <li class="{{Menu::active('users-pl', @$menu)}}"><a href="{{route('adminUsers', ['category'=>'pl'])}}"><i class="fa fa-user"></i>Players</a></li>
      <li class="{{Menu::active('options', @$menu)}}"><a href="{{route('adminOptions')}}"><i class="fa fa-cog"></i>Options</a></li>
      <li class="{{Menu::active('samples', @$menu)}}"><a href="{{route('adminSamples')}}"><i class="fa fa-user-secret"></i>Samples</a></li>
    </ul>
  </aside>
  <main>
    @yield('breadcrumbs')
    <div id="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <div class="page-header">
              <h1>{{$title}}</h1>
            </div>
          </div>
        </div>
        <div class="row">
          @yield('content')
        </div>
      </div>
    </div>
  </main>
  @include('admin.modals.assets')
  @include('admin.modals.delete')
  {!! Html::script('js/admin.js') !!}
</body>
</html>
