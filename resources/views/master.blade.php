<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('bootstrap-4.3.1/css/bootstrap.css') }}">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{ asset('fontawesome-5.7.2/css/all.css') }}">
    <!-- Datatables CSS -->
    <link rel="stylesheet" href="{{ asset('datatables-1.10.19/dataTables.bootstrap4.min.css') }}">
    <!-- Sweetalert v2 CSS -->
    <link rel="stylesheet" href="{{ asset('sweetalert2-8.3.0/sweetalert2.css') }}">

    <link rel="stylesheet" href="{{ asset('gijgo-datepicker-1.9.1.13/css/gijgo.css') }}">



    <link rel="stylesheet" href="{{ asset('offcanvas.css') }}">
    <link rel="stylesheet" href="{{ asset('custom.css') }}">
    <link rel="stylesheet" href="{{ asset('customcolors.css') }}">

    @stack('css')

    <title>@yield('title')</title>
</head>
<body class="bg-light">

  @include('navbar')

  <!-- Contenido -->
  <main role="main" class="container">

    <!-- Contenido centrado de manera horizontal -->
    <div class="row justify-content-center">
      @yield('content')
    </div>
    <!-- Contenido centrado de manera horizontal -->

  </main>
  <!-- Contenido -->

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="{{asset('jquery-3.4.1/jquery.js')}}"></script>
  <script src="{{asset('popper-1.15.0/popper.min.js')}}"></script>
  <script src="{{asset('bootstrap-4.3.1/js/bootstrap.js')}}"></script>
  <script src="{{ asset('datatables-1.10.19/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('datatables-1.10.19/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('sweetalert2-8.3.0/sweetalert-v8.3.0.js') }}"></script>
  <script src="{{ asset('globalFunctions.js') }}"></script>
  <!-- Script globales para la aplicacion -->
  <script>
  var urlRoot = "{{Request::root()}}";
  $(function () {
      'use strict'
          $('[data-toggle="offcanvas"]').on('click', function () {
            $('.offcanvas-collapse').toggleClass('open')
          })
      });
  </script>
  <!-- Script globales para la aplicacion -->
  @stack('scripts')
</body>
</html>
