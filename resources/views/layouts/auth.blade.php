<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{config('base.name')}} | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{asset('vendor/base/css/app.css')}}">
  <style>
    html{
      background: url({{asset('vendor/base/img/login-bg.jpg')}});
      background-position: center;
      background-size: cover;
      background-repeat: no-repeat;
    }

    body{
      background: transparent;
    }

    .login-logo{
      margin:0;
    }

    .dark{
      background: #444444 !important;
      background-color: #444444 !important;
      color: white !important;
    }

    .dark a{
      color: white;
    }
  </style>
  @yield('head')
</head>
<body class="hold-transition">

<div class="app-content">
  @yield('content')
</div>

<script src="{{asset('vendor/base/js/app.js')}}"></script>
@yield('body')
</body>
</html>
