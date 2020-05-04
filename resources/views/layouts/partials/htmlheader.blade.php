<head>
    <meta charset="utf-8">
    <title>
        @yield('page_title') | {{ config('app.name'), 'iFollowUP' }}
    </title>
    <meta name="description" content="Analytics Dashboard">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- base css -->
    <link rel="stylesheet" media="screen, print" href="{{ URL::to('css/vendors.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ URL::to('css/app.bundle.css') }}">
    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ URL::to('img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::to('img/favicon/favicon-32x32.png') }}">
    <link rel="mask-icon" href="{{ URL::to('img/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    
    @stack('css')
</head>