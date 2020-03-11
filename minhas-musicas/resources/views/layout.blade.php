<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    @include('head')

</head>

<body>

<!-- Navigation -->
@include('nav')


<div class="main-section text-center text-white">
    <div class="main-section-content">
        @yield('content')
    </div>
</div>


<!-- Footer -->
@include('footer')

</body>

</html>
