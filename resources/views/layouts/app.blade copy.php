<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hably Store') }}</title>

    <!-- Manifest -->
    <link rel="manifest" href="{{ asset('favicons/manifest.json') }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/hablystore.ico') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/hablystore.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    <!-- CSS (PINDAH KE PUBLIC ASSETS) -->
    <!-- <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/adminlte.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/adminlte.min.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Contoh tambahan kalau kamu pakai Bootstrap / plugin -->
     <style>
        @media (max-width:768px){

            .content-wrapper{
                overflow-x:hidden;
            }

            .small-box h3{
                font-size:28px !important;
            }

            .card-body{
                overflow-x:auto;
            }

            canvas{
                width:100% !important;
                height:auto !important;
            }

            .table-responsive{
                overflow-x:auto;
            }
        }
        </style>
   
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrappe">

        <!-- @include('layouts.navigation') -->

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

    </div>
</body>
</html>