<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Demo Pusher JWT</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <link href="{{ asset('sass/app.sass') }}" />
    <!-- Styles -->
</head>
<body>
<div id="app">

</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>