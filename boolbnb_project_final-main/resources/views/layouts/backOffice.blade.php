<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>boolBNB - @yield('title')</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/back.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    {{-- Includo l'header --}}
    @include('partials.header')

    {{-- Qui vengono caricate le pagine del backOffice --}}
    <main class="py-4">
        @yield('content')
    </main>

    {{-- Includo il footer --}}
    @include('partials.footer')

    {{-- Includo lo script scoped --}}
    <script src="{{ asset('js/back.js') }}"></script>
    @yield('script')
</body>
</html>
