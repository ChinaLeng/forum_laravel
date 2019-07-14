<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'laravel')-{{ setting('site_name', 'Laravel 进阶教程') }}</title>
    <meta name="description" content="@yield('description', setting('seo_description', 'LaraBBS 爱好者社区。'))" />
    <meta name="keyword" content="@yield('keyword', setting('seo_keyword', 'LaraBBS,社区,论坛,开发者论坛'))" />
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
<div id="app" class="{{ route_class() }}-page">

    @include('index.layouts._header')

    <div class="container">

        @include('index.shared._messages')

        @yield('content')

    </div>

    @include('index.layouts._footer')
</div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
@yield('scripts')
</body>
<div id="app" class="{{ route_class() }}-page">
</html>