<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
    <title>Employee</title>
</head>

<body>
    <div id="app"></div>
</body>
<script src="{{ asset('js/app.js') }}"></script>

</html>