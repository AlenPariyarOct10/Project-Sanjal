<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{getSystemInfo("system_title", "ProjectSanjal")}} </title>
    @vite(['resources/css/auth.css', 'resources/js/auth.js'])
    @yield("css")

</head>
<body>
@yield("content")
</body>
@yield("js")
</html>
