<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <title>@yield('title-block')</title>

    <!-- Fonts -->
    <!-- Styles -->
    <link rel="stylesheet" href="/css/bootstrap.css">
{{--    <link rel="stylesheet" href="/css/app.css">--}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


{{--    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />--}}


</head>
<body class="antialiased">

@include('inc.header')
<main role="main" class="main">
    @include('inc.messages')
    @yield('content')
</main>
@include('inc.footer')


<script src="/js/app.js"></script>

</body>
</html>
