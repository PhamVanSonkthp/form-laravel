<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    @yield('title')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Pham Son" name="author">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ optional(\App\Models\Logo::first())->image_path }}">

    @yield('css')

</head>

<body>


@include('user.components.header')


@yield('content')


@include('user.components.footer')

<!-- JAVASCRIPT -->

@yield('js')

</body>


</html>
