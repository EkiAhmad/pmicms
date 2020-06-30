<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? '' }}</title>
        <!-- Favicon -->
        <link href="{{ asset('assets') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Icons -->
        <link href="{{ asset('assets') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('assets') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- Argon CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
          
        <link type="text/css" href="{{ asset('assets') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets') }}/css/custom.css" rel="stylesheet">
    </head>
    <body class="{{ $class ?? '' }}">
        {{-- swal2 --}}
        
        {{-- end swal 2 --}}
        {{-- BLOCK UI --}}
        <div id="loading" style="display: none;">
            <div class="lds-ripple">
                <div></div>
                <div></div>
            </div>
            <br/>
            <span style="color: #C0B6AC;">Loading...</span>
        </div>
        {{-- end block ui  --}}
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @include('admin.layouts.navbars.sidebar')
        @endauth
        
        <div class="main-content">
            @include('admin.layouts.navbars.navbar')
            @yield('content')
        </div>

        @guest()
            @include('admin.layouts.footers.guest')
        @endguest
        @include('sweetalert::alert')

        <script src="{{ asset('assets') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('assets') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        
        
        @stack('js')
        <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

        <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
        <!-- ARGON JS -->
        <script src="{{ asset('assets') }}/js/argon.js?v=1.0.0"></script>
    </body>
</html>