<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Bất động sản Phía Tây</title>

    <meta name="author" content="themesflat.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="{{asset('phiatay/app/dist/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('phiatay/app/dist/app.css')}}">
    <link rel="stylesheet" href="{{asset('phiatay/app/dist/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('phiatay/app/dist/owl.css')}}">

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="{{asset('favicon.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('favicon.png')}}">

</head>

<body class="body">

    <div class="preload preload-container">
        <div class="boxes ">
            <div class="box">
                <div></div> <div></div> <div></div> <div></div>
            </div>
            <div class="box">
                <div></div> <div></div> <div></div> <div></div>
            </div>
            <div class="box">
                <div></div> <div></div> <div></div> <div></div>
            </div>
            <div class="box">
                <div></div> <div></div> <div></div> <div></div>
            </div>
        </div>
    </div>

    <!-- /preload -->

    <div id="wrapper">
        <div id="pagee" class="clearfix">

       
        @include('partials.header')
        @yield('content')
        @include('partials.footer')
        @section('scripts')
        @show
                  


           
</body>


</html>

