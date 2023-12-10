<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    @yield('head_content')
</head>

<body>
    @yield('body')
</body>

</html>
