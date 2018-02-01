<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Real House - Real Estate HTML Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">

    <!-- External CSS libraries -->
    
    <link type="text/css" href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
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
    <link type="text/css" href="{{ asset('/css/style(1).css') }}" rel="stylesheet">
    <link type="text/css" id="style_sheet" href="{{ asset('/css/default.css') }}" rel="stylesheet">
    
    

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="{{ asset('/img/favicon.ico') }}" type="image/x-icon" >

    <!-- Google fonts -->
<link type="text/css" href="{{ asset('/css/google_fonts.css') }}" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
   
     <link type="text/css" href="{{ asset('/css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet"> 
    
    
    

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script type="text/javascript" src="js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script type="text/javascript" src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="js/html5shiv.min.js"></script>
    <script type="text/javascript" src="js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="form-page-body">
<div class="page_loader"></div>
<!-- Option Panel -->
<div class="option-panel option-panel-collased">
    <h2>Change Color</h2>
    <div class="color-plate default-plate" data-color="default"></div>
    <div class="color-plate blue-plate" data-color="blue"></div>
    <div class="color-plate yellow-plate" data-color="yellow"></div>
    <div class="color-plate blue-light-plate" data-color="blue-light"></div>
    <div class="color-plate green-light-plate" data-color="green-light"></div>
    <div class="color-plate green-plate" data-color="green"></div>
    <div class="color-plate yellow-light-plate" data-color="yellow-light"></div>
    <div class="color-plate green-light-2-plate" data-color="green-light-2"></div>
    <div class="color-plate olive-plate" data-color="olive"></div>
    <div class="color-plate purple-plate" data-color="purple"></div>
    <div class="color-plate midnight-blue-plate" data-color="midnight-blue"></div>
    <div class="color-plate brown-plate" data-color="brown"></div>
    <div class="setting-button">
        <i class="fa fa-gear"></i>
    </div>
</div>
<!-- /Option Panel -->
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <!-- Form content box start -->
            <div class="form-content-box">
                <!-- details -->
                <div class="details">
                    <!-- Logo -->
                    <a href="index.html">
                        <img src="{{ asset('/img/black-logo.png') }}" class="cm-logo" alt="black-logo">
                        
                    </a>
                    <!-- Name -->
                    <h3>Forgot Password</h3>
                    <!-- Divider -->
                    <div class="divider">
                        <span class="or-text">OR</span>
                    </div>
                    
                    
                    
                    <!-- Form start -->
                    <form method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							
							
                            <input id="email" type="email" placeholder="Email Address" class="input-text" name="email" value="{{ old('email') }}" required>
                            
                            
                             @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            
                        </div>
                        <div class="form-group">
							
							<button type="submit" class="button-md button-theme btn-block">
                                    Send Me Email
                                </button>
                            
                        </div>
                    </form>
                    
                    
                    
                    
                    
                    
                    <!-- Form end -->
                </div>
                <!-- Footer -->
                <div class="footer">
                    <span>
					 I want to <a href='{!! url('/login'); !!}'>return to login</a>
                       </span>
                </div>
            </div>
            <!-- Form content box end -->
        </div>
    </div>
</div>




 
 

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
</body>
</html>
 
 
