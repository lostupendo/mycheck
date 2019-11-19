<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>@hasSection('title')@yield('title') - @endif{{ config('app.name', 'MyCheck') }}</title>

    {{-- Styles --}}
    <link rel="stylesheet" href="{{ asset('css/fa-5.8.2-all.css') }}" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- Head scripts --}}
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/bootstrap-4.1.3.min.js') }}" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body class="app">
    <div id="app" class="app-body">
        @yield('content')
    </div>
</body>
</html>
