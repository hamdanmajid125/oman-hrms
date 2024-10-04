<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    @stack('css')
    @include('includes.css')
    @stack('post-css')
</head>
<body>
    @yield('content')

    @stack('js')
    @include('includes.script')
    @stack('post-js')

    
</body>
</html>