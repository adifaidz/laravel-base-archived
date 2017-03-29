<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{config('base.name')}} | @yield('title')</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{asset('css/app.css') }}"/>
  <style>
    .sidebar-mini.sidebar-collapse .main-header .logo > .logo-mini{
      height:100%;
      display: flex;
      justify-content: center;
      align-items: center;
    }
  </style>
  <script>
    window.Laravel = { csrfToken: '{{ csrf_token() }}' };
  </script>
  @yield('head')
</head>

<body class="sidebar-mini sidebar-collapse skin-blue">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="{{route('admin.home')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">{!!config('base.logo')!!}</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>{{config('base.name')}}</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <!--<img src="dist/img/user2-160x160.jpg" class="user-image hidden" alt="User Image">-->
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs">{{ $loggedUser_profile->first_name or $loggedUser->email }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <!--<img src="dist/img/user2-160x160.jpg" class="img-circle hidden" alt="User Image">-->

                <p>
                  {{ $loggedUser_profile->first_name or $loggedUser->email }}
                  <small>Member since {{ $loggedUser->created_at}}</small>
                  <small>Last login at {{ $loggedUser->last_login_at}}</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ route('admin.userprofile.show', $loggedUser_profile) }}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out</a>
                  <form id="logout-form" class="hidden" action="{{route('admin.logout')}}" method="post">
                    {{csrf_field()}}
                  </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <!--<img src="dist/img/user2-160x160.jpg" class="img-circle hidden" alt="User Image">-->
        </div>
        <div class="pull-left info hidden">
          <p>{{ $loggedUser_profile->first_name or $loggedUser->email }}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      @include('base::layouts.menu')
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @if (count($errors) > 0)
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif
    @if(session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
    @elseif(session('error'))
      <div class="alert alert-danger">
          {{ session('error') }}
      </div>
    @endif
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @yield('page-header')
        <small>@yield('page-desc')</small>
      </h1>
      <ol class="breadcrumb">
        @yield('breadcrumb')
      </ol>
    </section>

    <!-- Main content -->
    <section class="content app-content">
      @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      <b>PRISM</b>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2016 <a href="#">Landasan Teknologi</a>.</strong> All rights reserved.
  </footer>

</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('body')
</body>
</html>
