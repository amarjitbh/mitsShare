
<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>ShareAir</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/skins/default.css') }}"/>
    <!-- Favicon icon -->
    <link rel="shortcut icon" href="{{ URL::asset('img/favicon.ico') }}" type="image/x-icon" >
    <link rel="icon" type="image/png" href="{{ URL::asset('img/favicon-32x32.png') }}img-preview/" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ URL::asset('img/favicon-16x16.png') }}img-preview/" sizes="32x32" />

    <!-- Google fonts -->
    {{--<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800%7CPlayfair+Display:400,700%7CRoboto:100,300,400,400i,500,700">--}}
    <script src="{{ URL::asset('js/ie8-responsive-file-warning.js') }}"></script>
    <script src="{{ URL::asset('js/jquery-2.2.0.min.js') }}"></script>
    <script src="{{ URL::asset('js/autocomplete.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwXnrdv0X99Sa6Zq-4lcjp6qUw1-cDgPg&libraries=places&callback=initAutocomplete"
        async defer></script>
     @yield('css')
    <style>
        .alert-danger-custom {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
        }
        .top-header .sign-in {
            margin-left: 8px!important;
        }
         .details_value {
                margin-bottom: 3px;
                color: #868686;
                font-size: 13px;
            }
            .space{
                height: 5px;
               
               
            }

        .sidebar-feature-prop-slider {
            min-height: 250px;
            background-size: contain;
            background-color: #eaeaea;
            background-repeat: no-repeat;
            background-position: 50% 50%;
        }
        .description_ckeditor *{
            margin : 0;
        }
        .image-preview-list-view-link {
            padding-right: 45px;
            position: relative;
        }
        .image-preview-list-view {
            width: 30px;
            height: 30px;
            background-size: cover;
            background-position: 50% 50%;
            background-color: #eee;
            background-repeat: no-repeat;
            position: absolute;
            right: 0;
            top: -5px;
        }
    </style>
</head>
<body>
<div class="page_loader"></div>

<!-- Top header start -->
<header class="top-header hidden-xs" id="top">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="list-inline">
                    {{--<a href="tel:1-800-666-8888"><i class="fa fa-phone"></i>Need Support? 1-800-666-8888</a>--}}
                    {{--<a href="#"><i class="fa fa-envelope"></i>support@shareair.io</a>--}}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <ul class="top-social-media pull-right">


                    <li>

                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <a class="sign-in" href="{{ route('login') }}">Login / </a>
                            <a class="sign-in" href="{{ route('register') }}">Register</a>
                        @else
                            @if(Auth::user()->role==2)

                                <a href="{{route('home')}}" class="sign-in" >
                                    <i class="fa fa-user"></i>  {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                </a>
                                <a href="{{route('seller-properties')}}" class="sign-in" >
                                    My Account
                                </a>
                            @endif
                            <a class="sign-in" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        @endif
                        <!--<a href="{!! url('/login') !!}" class="sign-in"><i class="fa fa-user"></i> Log In / Register</a> -->
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<!-- Top header end -->

<!-- Main header start -->
<header class="main-header">
    <div class="container">
        <nav class="navbar navbar-default">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navigation" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="{{route('home')}}" class="logo">
                    <img src="{{URL::asset('img/logo.png')}}" alt="logo">
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="navbar-collapse collapse" role="navigation" aria-expanded="true" id="app-navigation">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{{route('home')}}"  aria-expanded="false">
                            Home
                        </a>
                    </li>
                    <li class="dropdown">
                        <a tabindex="0" data-toggle="dropdown" data-submenu="" aria-expanded="false">
                            Properties <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-scroll" >
                            @foreach($propertyTypes as $propertyType)
                                <li class="dropdown">
                                    <a class="properties-with-no-location" data-propertyID="{{$propertyType['id']}}" href="{{route('search.result')}}?property_type_id={{$propertyType['id']}}" tabindex="0">{{$propertyType['name']}}</a>
                                </li>
                            @endforeach

                        </ul>
                    </li>
                     <li class="visible-xs">

                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <a class="sign-in" href="{{ route('login') }}">Login / </a>
                            <a class="sign-in" href="{{ route('register') }}">Register</a>
                        @else
                            @if(Auth::user()->role==2)

                                <a href="{{route('home')}}" class="sign-in" >
                                    <i class="fa fa-user"></i>  {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                </a>
                                <a href="{{route('seller-properties')}}" class="sign-in" >
                                    My Account
                                </a>
                            @endif
                            <a class="sign-in" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        @endif
                        <!--<a href="{!! url('/login') !!}" class="sign-in"><i class="fa fa-user"></i> Log In / Register</a> -->
                    </li>
                </ul>
            </div>

            <!-- /.navbar-collapse -->
            <!-- /.container -->
        </nav>
    </div>
</header>
<!-- Main header end -->

@yield('content')
<!-- Footer start -->
<footer class="main-footer clearfix">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6 footer-item clearfix">
                <div class="footer-item-content">
                    <a href="{{route('home')}}" class="footer-logo">
                        <img src="{{URL::asset('img/footer-logo.png')}}" alt="footer-logo">
                    </a>
                    <div class="clearfix"></div>
                    <!-- paragraph -->

                </div>
            </div>

            <div class="col-md-4 col-sm-6 footer-item clearfix">
                <div class="footer-item-content">
                    <h2 class="title">Address</h2>
                    <!-- Contact Info -->
                    <ul class="contact-info">
                        {{--<li class="clearfix">
                            <i class="fa fa-map-marker fa-lg"></i>
                            <label>108 Villa Precy Subdivision Kumintang Ilaya Batangas, Philippines</label>
                        </li>
                        <li class="clearfix">
                            <i class="fa fa-mobile fa-lg"></i>
                            <label>+55 417-634-7071</label>
                        </li>--}}
                        <li class="clearfix">
                            <i class="fa fa-envelope-o fa-lg"></i>
                            <label>
                                <a href="#">info@shareair.io</a>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>

 
            <div class="col-md-4 col-sm-6 footer-item clearfix">
                <div class="footer-item-content">
                    <h2 class="title">Helpful Links</h2>
                   <ul class="links">
                        @if (Auth::guest())
                        <li>
                            <a href="{{ route('login') }}">Login</a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}">Register</a>
                        </li>
                        @else
                        <li>
                        <a class="sign-in" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                Logout
                        </a>
                        </li>
                        <li>
                            <a href="{{route('seller-properties')}}">My Account</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

           <!--  <div class="col-md-3 col-sm-6 footer-item clearfix">
                <div class="footer-item-content">
                    <div class="newsletter">
                        <h2 class="title">Newsletter</h2>
                        {{--<div class="f-text">
                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </div>--}}


                       {{-- <form action="#" method="post">--}}
                            <p>
                                <input class="nsu-field btn-block" id="nsu-email-0" type="text" name="useremail" placeholder="Enter your Email Address">
                            </p>

                            <p>
                                <button class="button-sm button-theme btn-block">Signup</button>

                            </p>
                        {{--</form>--}}
                       
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</footer>
<!-- Footer end -->

<!-- Sub footer start -->
<div class="sub-footer">
    <div class="container">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="copy-right">
                © @php echo date('Y'); @endphp <a href="{{route('home')}}" >ShareAir </a>‐ All Rights Reserved
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="social-list">

            </div>
        </div>
    </div>
</div>
<!-- Sub footer end -->

<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap-submenu.js') }}"></script>
<script src="{{ URL::asset('js/rangeslider.js') }}"></script>
<script src="{{ URL::asset('js/jquery.mb.YTPlayer.js') }}"></script>
<script src="{{ URL::asset('js/wow.min.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ URL::asset('js/jquery.easing.1.3.js') }}"></script>
<script src="{{ URL::asset('js/jquery.scrollUp.js') }}"></script>
<script src="{{ URL::asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ URL::asset('js/moment.min.js') }}"></script>
<script src="{{ URL::asset('js/fullcalendar.min.js') }}"></script>
<script src="{{ URL::asset('js/leaflet.js') }}"></script>
<script src="{{ URL::asset('js/leaflet-providers.js') }}"></script>
<script src="{{ URL::asset('js/leaflet.markercluster.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap-datetimepicker.js') }}"></script>
<script src="{{ URL::asset('js/dropzone.js') }}"></script>
<script src="{{ URL::asset('js/magnific-popup.js') }}"></script>
<script src="{{ URL::asset('js/nicescroll.js') }}"></script>
<script src="{{ URL::asset('js/maps.js') }}"></script>
@yield('scripts')
<script src="{{ URL::asset('js/app2.js') }}"></script>
<script src="{{ URL::asset('js/ie10-viewport-bug-workaround.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function(){
        setTimeout(function() {
            $('.alert-success').fadeOut('slow');
        }, 3000);

        setTimeout(function() {
            $('.alert-danger').fadeOut('slow');
        }, 3000);

        var nicelist = $(".dropdown-menu-scroll").niceScroll({
            zindex: 9999
        });
        var dropmenuMain = $('.dropdown-menu-scroll-main');
        dropmenuMain.hover(function () {
            $('a[data-toggle="dropdown"]', this).trigger('click');
        }, function () {
            $('a[data-toggle="dropdown"]', this).trigger('click');

        });
        dropmenuMain.on("shown.bs.dropdown", function (e) {
            nicelist.show().resize();
        });

        $(".dropdown-menu-scroll-main ").on("hide.bs.dropdown", function (e) {
            nicelist.hide();
        });



        $(document).on('click','.properties-with-no-location', function(e) {
            // var lat = $('#getLatSearchBar').val();
            //var lng = $('#getLongSearchBar').val();
            var propertyId = $(this).attr("data-propertyid");
            $(this).prop("href", "{{route('search.result')}}?property_type_id="+propertyId+"&setData=1");
        });

    });
</script>

<!-- Custom javascript -->
</body>
</html>
