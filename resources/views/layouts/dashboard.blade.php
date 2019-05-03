<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/chart.css') }}">
    <style type="text/css">
        body{
            background-color: #f2f2f2;
        }

        .wrapper{
            margin-right: 400px;
            padding-left: 400px;
            position: absolute;
            float: right;
            top: 61px;
            width: 100%;
            height: 100%;
            padding-top: 61px;
            margin-top: -61px;
        }
    </style>
    @yield('css')

    <title>Web Empleado | @yield('title')</title>
  </head>
  <body>
    
    @include('partials.navbar')
    @include('partials.sidebar')
    <div class="wrapper">
        @yield('content')
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/chart.js') }}"></script>
    @yield('scripts')
  </body>
</html>