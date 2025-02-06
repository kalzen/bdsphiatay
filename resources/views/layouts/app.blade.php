<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('partials.head')
    <body>
        @include('partials.header')
        @yield('content')
        @include('partials.footer')
        @section('scripts')
        @show
    </body>
</html>
