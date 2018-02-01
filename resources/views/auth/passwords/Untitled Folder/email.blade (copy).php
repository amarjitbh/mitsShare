@extends('layouts.app')

@section('content')


 <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
 <link href="{{ asset('/css/animate.min.css') }}" rel="stylesheet">
 <link href="{{ asset('/css/bootstrap-submenu.css') }}" rel="stylesheet">
 <link href="{{ asset('/css/bootstrap-select.min.css') }}" rel="stylesheet">
 <link href="{{ asset('/css/leaflet.css') }}" rel="stylesheet">
 <link href="{{ asset('/css/map.css') }}" rel="stylesheet">
 <link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet">
 <link href="{{ asset('/css/flaticon.css') }}" rel="stylesheet">
 <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
 <link href="{{ asset('/css/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
 <link href="{{ asset('/css/dropzone.css') }}" rel="stylesheet">
 <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
 <link href="{{ asset('/css/default.css') }}" rel="stylesheet">
 <link href="{{ asset('/css/google_fonts.css') }}" rel="stylesheet">
 <link href="{{ asset('/css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">
 
 
 
 <link href="{{ asset('/js/ie-emulation-modes-warning.js') }}" rel="stylesheet">
 <link href="{{ asset('/js/jquery-2.2.0.min.js') }}" rel="stylesheet">
 <link href="{{ asset('/js/bootstrap.min.js') }}" rel="stylesheet">
 <link href="{{ asset('/js/bootstrap-submenu.js') }}" rel="stylesheet">
 <link href="{{ asset('/js/rangeslider.js') }}" rel="stylesheet">
 <link href="{{ asset('/js/jquery.mb.YTPlayer.js') }}" rel="stylesheet">
 <link href="{{ asset('/js/wow.min.js') }}" rel="stylesheet">
 <link href="{{ asset('/js/bootstrap-select.min.js') }}" rel="stylesheet">
 <link href="{{ asset('/js/jquery.easing.1.3.js') }}" rel="stylesheet">
 <link href="{{ asset('/js/jquery.scrollUp.js') }}" rel="stylesheet">
 <link href="{{ asset('/js/jquery.mCustomScrollbar.concat.min.js') }}" rel="stylesheet">
 <link href="{{ asset('/js/leaflet.js') }}" rel="stylesheet">
 <link href="{{ asset('/js/leaflet-providers.js') }}" rel="stylesheet">
 <link href="{{ asset('/js/leaflet.markercluster.js') }}" rel="stylesheet">
 <link href="{{ asset('/js/dropzone.js') }}" rel="stylesheet">
 <link href="{{ asset('/js/maps.js') }}" rel="stylesheet">
 <link href="{{ asset('/js/ie10-viewport-bug-workaround.js') }}" rel="stylesheet">
 
 
 
 
 
 
 
<div class="page_loader" style="display: none;"></div>
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
						
                        <img src="{{ asset('/images/black-logo.png') }}" class="cm-logo" alt="black-logo">
                    </a>
                    <!-- Name -->
                    <h3>Forgot Password</h3>
                    <!-- Divider -->
                    <div class="divider">
                        <span class="or-text">OR</span>
                    </div>
                    <!-- Form start -->
                    <form action="index.html">
                        <div class="form-group">
                            <input type="text" name="email" class="input-text" placeholder="Email Address">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="button-md button-theme btn-block">Send Me Email</button>
                        </div>
                    </form>
                    <!-- Form end -->
                </div>
                <!-- Footer -->
                <div class="footer">
                    <span>
                       I want to <a href="login.html">return to login</a>
                    </span>
                </div>
            </div>
            <!-- Form content box end -->
        </div>
    </div>
</div>

<script type="text/javascript" src="js/jquery-2.2.0.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-submenu.js"></script>
<script type="text/javascript" src="js/rangeslider.js"></script>
<script type="text/javascript" src="js/jquery.mb.YTPlayer.js"></script>
<script type="text/javascript" src="js/wow.min.js"></script>
<script type="text/javascript" src="js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.scrollUp.js"></script>
<script type="text/javascript" src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="js/leaflet.js"></script>
<script type="text/javascript" src="js/leaflet-providers.js"></script>
<script type="text/javascript" src="js/leaflet.markercluster.js"></script>
<script type="text/javascript" src="js/dropzone.js"></script>
<script type="text/javascript" src="js/maps.js"></script>
<script type="text/javascript" src="js/app.js"></script>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script type="text/javascript" src="js/ie10-viewport-bug-workaround.js"></script>
<!-- Custom javascript -->
<script type="text/javascript" src="js/ie10-viewport-bug-workaround.js"></script>
<script>
     (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                 (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
             m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
     })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
     ga('create', 'UA-89110077-3', 'auto');
     ga('send', 'pageview');
  </script>

<a id="page_scroller" href="#top" style="display: none; position: fixed; z-index: 2147483647;"><i class="fa fa-chevron-up"></i></a>
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
