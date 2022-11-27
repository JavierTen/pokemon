<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}" lang="en-US" itemscope="itemscope" itemtype="http://schema.org/WebPage">

@php
$favicon = config('app.favicon');
@endphp

<head>

    <title>Pokemon @yield('title')</title>

    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index,follow">
    <meta name="rating" content="RTA-5042-1996-1400-1577-RTA" />

    <meta charset="UTF-8" />

    <link rel="apple-touch-icon" href="/apple-touch-icon.png" sizes="180x180" />
    <link rel="mask-icon" href="/favicon.svg" color="#FFFFFF" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/app.css">
    <meta name="theme-color" content="#ffffff" />
    <meta name="msapplication-TileColor" content="#232326" />
    <meta name="theme-color" content="#ffffff" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    @stack('css')


</head>

<body>

    <div id="app">
        @yield('content')
    </div>

    <script src="{{ mix('/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


</body>

</html>
