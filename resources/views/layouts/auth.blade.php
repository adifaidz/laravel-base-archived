<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{config('base.name')}} | Log in</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <style>
    html{
      background: url({{asset('images/login-bg.jpg')}});
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
  <script>
    window.Laravel = { csrfToken: '{{ csrf_token() }}' };
  </script>
  @yield('head')
</head>
<body class="hold-transition">

<div class="app-content">
  @yield('content')
</div>

<script src="{{asset('js/app.js')}}"></script>
@yield('body')
</body>
</html>
