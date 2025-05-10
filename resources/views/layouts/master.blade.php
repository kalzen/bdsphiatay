<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Bất động sản Phía Tây</title>

    <meta name="author" content="12bytes.xyz">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Google Analytics -->
    @if(env('GOOGLE_ANALYTICS_ID'))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GOOGLE_ANALYTICS_ID') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ env('GOOGLE_ANALYTICS_ID') }}');
    </script>
    @endif
    
    <link rel="stylesheet" href="{{asset('phiatay/app/dist/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('phiatay/app/dist/app.css')}}">
    <link rel="stylesheet" href="{{asset('phiatay/app/dist/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('phiatay/app/dist/owl.css')}}">
    <link rel="stylesheet" href="{{asset('phiatay/app/dist/floating-social.css')}}">

    <!-- Favicon and Touch Icons  -->    <link rel="shortcut icon" href="{{asset('favicon.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('favicon.png')}}">
    
    @yield('styles')

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
        
        <!-- Floating Social Icons -->
        <div class="floating-social">
            <div class="floating-social-menu">
                <a href="tel:+840858050050" class="floating-social-item phone-item">
                    <i class="fa fa-phone"></i>
                </a>
                <a href="https://zalo.me/0858050050" target="_blank" class="floating-social-item zalo-item">
                    <i class="fa fa-comment"></i>
                </a>
                <a href="https://m.me/101266363070532" target="_blank" class="floating-social-item facebook-item">
                    <i class="fab fa-facebook-messenger"></i>
                </a>
            </div>
            <div class="floating-social-toggle">
                <i class="fa fa-plus"></i>
            </div>
        </div>
        
        @section('scripts')
        @show
    </div>
</div>           
</body>
</html>

