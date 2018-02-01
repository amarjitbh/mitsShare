<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ShareAir |@yield('title')</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    
    
    
    <!-- Template style start -->
    
    
    <!-- External CSS libraries -->
    
{{--    <link type="text/css" href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('/css/animate.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('/css/bootstrap-submenu.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('/css/leaflet.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('/css/map.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('/css/flaticon.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('/css/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('/css/dropzone.css') }}" rel="stylesheet">

    <!-- Custom stylesheet -->
    <link type="text/css" href="{{ asset('/css/style(1).css') }}" rel="stylesheet">--}}
    <link type="text/css" href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link type="text/css" id="style_sheet" href="{{ asset('/css/skins/default.css') }}" rel="stylesheet">
    

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="{{ asset('/img/favicon.ico') }}" type="image/x-icon" >

    <!-- Google fonts -->
{{--<link type="text/css" href="{{ asset('/css/google_fonts.css') }}" rel="stylesheet">--}}

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
   
    {{-- <link type="text/css" href="{{ asset('/css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">--}}
    
    <!-- Template style end -->
    
    
    
    
</head>
<body class="form-page-body">
   
        

        @yield('content')
   

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    
     <!-- Javascript Start -->
    
    
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script type="text/javascript" src="js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script type="text/javascript" src="{{ asset('js/ie-emulation-modes-warning.js') }}"> </script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="js/html5shiv.min.js"></script>
    <script type="text/javascript" src="js/respond.min.js"></script>
    <![endif]-->
    
    
    
    <script type="text/javascript" src="{{ asset('/js/jquery-2.2.0.min.js') }}"> </script>
<script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}" > </script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-submenu.js') }}" > </script>
<script type="text/javascript" src="{{ asset('/js/rangeslider.js') }}" > </script>
<script type="text/javascript" src="{{ asset('/js/jquery.mb.YTPlayer.js') }}" > </script>
<script type="text/javascript" src="{{ asset('/js/wow.min.js') }}" > </script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-select.min.js') }}" > </script>
<script type="text/javascript" src="{{ asset('/js/jquery.easing.1.3.js') }}" > </script>
<script type="text/javascript" src="{{ asset('/js/jquery.scrollUp.js') }}" > </script>
<script type="text/javascript" src="{{ asset('/js/jquery.mCustomScrollbar.concat.min.js') }}" > </script>
<script type="text/javascript" src="{{ asset('/js/leaflet.js') }}" > </script>
<script type="text/javascript" src="{{ asset('/js/leaflet-providers.js') }}" > </script>
<script type="text/javascript" src="{{ asset('/js/leaflet.markercluster.js') }}" > </script>
<script type="text/javascript" src="{{ asset('/js/dropzone.js') }}" > </script>
<script type="text/javascript" src="{{ asset('/js/maps.js') }}" > </script>
<script type="text/javascript" src="{{ asset('/js/app2.js') }}"> </script>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script type="text/javascript" src="{{ asset('/js/ie10-viewport-bug-workaround.js') }}" > </script>
<!-- Custom javascript -->

<script>
     (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                 (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
             m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
     })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
     ga('create', 'UA-89110077-3', 'auto');
     ga('send', 'pageview');
  </script>
  
<!-- Javascript End -->
        <script type="text/javascript">
            $(document).ready(function(){
                setTimeout(function() {
                    $('.alert-success').fadeOut('slow');
                }, 3000);

                setTimeout(function() {
                    $('.alert-danger').fadeOut('slow');
                }, 3000);

            });
        </script>
    
</body>
</html>
