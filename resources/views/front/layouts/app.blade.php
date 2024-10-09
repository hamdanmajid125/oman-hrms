<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{--  <link rel="icon" href="{{ asset($favicon) }}">  --}}

    <title>{{ config('app.name') }}</title>
    @include('front.layouts.components.css')
    @stack('css')
</head>

<body class="theme-3">

    {{--  @include('front.layouts.components.header')  --}}
    @yield('content')
    {{--  @include('front.layouts.components.footer')  --}}


    @include('front.layouts.components.script')
    @stack('js')





</body>

</html>
