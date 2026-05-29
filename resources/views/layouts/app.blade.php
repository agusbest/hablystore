<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hably Store') }}</title>

    <!-- CSS -->
    <link rel="stylesheet"
          href="{{ asset('assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet"
          href="{{ asset('assets/css/adminlte.min.css') }}">

    <link rel="stylesheet"
          href="{{ asset('assets/fontawesome/css/all.min.css') }}">

 </head>

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

    {{-- Navbar --}}
    @include('layouts.navbar')

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Content --}}
    <div class="content-wrapper p-3">

        @isset($header)

            <div class="content-header">

                {{ $header }}

            </div>

        @endisset

        <section class="content">

            {{ $slot }}

        </section>

    </div>

</div>

<!-- JS -->
<script src="{{ asset('assets/plugins/jquery.min.js') }}"></script>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/js/adminlte.min.js') }}"></script>



<script>
$(document).ready(function () {
    $('[data-widget="pushmenu"]').PushMenu('init');
});
</script>



</body>
</html>