<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>
            @yield('page_title') | {{ config('app.name', 'eFellowUP') }}
        </title>
        <meta name="description" content="Login">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
        <!-- Call App Mode on ios devices -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no">
        <!-- base css -->
        <link rel="stylesheet" media="screen, print" href="{{ URL::to('css/vendors.bundle.css') }}">
        <link rel="stylesheet" media="screen, print" href="{{ URL::to('css/app.bundle.css') }}">
        <link id="myskin" rel="stylesheet" media="screen, print" href="{{ URL::to('css/skins/skin-master.css') }}">
        <!-- Place favicon.ico in the root directory -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ URL::to('img/favicon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::to('img/favicon/favicon-32x32.png') }}">
        <link rel="mask-icon" href="{{ URL::to('img/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
        <!-- Optional: page related CSS-->
        <link rel="stylesheet" media="screen, print" href="{{ URL::to('css/fa-brands.css') }}">
        <link rel="stylesheet" media="screen, print" href="{{ URL::to('css/page-login-alt.css') }}">
    </head>
    <body style="background: url({{ URL::to('img/svg/pattern-1.svg') }}) no-repeat center bottom fixed; background-size: cover;">
        {{--  <div class="page-wrapper">
            <div class="page-inner bg-brand-gradient">
                <div class="page-content-wrapper bg-transparent m-0">
                    
                    <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-white">
                        {{ date('Y') }} © {{config('app.name')}} by&nbsp;<a href='https://keensoen.ng' class='text-white opacity-40 fw-500' title='KeennessSolutions' target='_blank'>KeennessSolutions</a>
                    </div>
                </div>
            </div>
        </div>  --}}
        @yield('auth-content')
        <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-white">
            {{ date('Y') }} © {{config('app.name')}} by&nbsp;<a href='https://keensoen.ng' class='text-white opacity-40 fw-500' title='KeennessSolutions' target='_blank'>KeennessSolutions</a>
        </div>
        <video poster="img/backgrounds/clouds.png" id="bgvid" playsinline autoplay muted loop>
            <source src="media/video/cc.webm" type="video/webm">
            <source src="media/video/cc.mp4" type="video/mp4">
        </video>
        
        <script src="{{ URL::to('js/vendors.bundle.js') }}"></script>
        <script src="{{ URL::to('js/app.bundle.js') }}"></script>
    </body>
</html>
