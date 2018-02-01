
<!DOCTYPE html>
<html lang="">
<head>
    <title>ShareAir</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/skins/default.css') }}"/>
    <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css"/>
    <!-- Favicon icon -->
    <link rel="shortcut icon" href="{{ URL::asset('img/favicon.ico') }}" type="image/x-icon" >
    <link rel="icon" type="image/png" href="{{ URL::asset('img/favicon-32x32.png') }}img-preview/" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ URL::asset('img/favicon-16x16.png') }}img-preview/" sizes="32x32" />

       <!-- Google fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800%7CPlayfair+Display:400,700%7CRoboto:100,300,400,400i,500,700">
    <script src="{{ URL::asset('js/ie8-responsive-file-warning.js') }}"></script>
    <script src="{{ URL::asset('js/jquery-2.2.0.min.js') }}"></script>
    <script src="{{ URL::asset('js/autocomplete.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwXnrdv0X99Sa6Zq-4lcjp6qUw1-cDgPg&libraries=places&callback=initAutocomplete"
            async defer></script>
    @yield('css')
  
        <style>
            [data-simplebar] {
                overflow: auto;
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
            @php $flag = 0; $role=0; @endphp
            @if(Auth::User())
                @php
                $flag = 1;
                $role = Auth::User()->role; @endphp
            @endif
                        <!-- Authentication Links -->

                    @if( $flag == 1)

                        @if (Auth::guest())
                            <li>   <a class="sign-in" href="{{ route('login') }}">Login</a></li>
                            <li>   <a class="sign-in" href="{{ route('register') }}">Register</a></li>
                        @else

                            @if(Auth::user()->role==2)
                                <li>
                                    <a href="{{route('home')}}" class="sign-in" >
                                        <i class="fa fa-user"></i> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('seller-properties')}}" class="sign-in" >
                                        My Account
                                    </a>
                                </li>
                            @endif
                                @if(Auth::user()->role==1)
                                    <li>
                                        <a class="sign-in" href="{{ route('propertytype.index') }}">
                                            Admin Dashboard
                                        </a>
                                    </li>
                                @endif

                            <li>
                                <a class="sign-in" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        @endif
                    @else
                     @if (Auth::guest())
                        <li>   <a class="sign-in" href="{{ route('login') }}">Login</a></li>
                        <li>   <a class="sign-in" href="{{ route('register') }}">Register</a></li>
                        @endif
                    @endif    
                                <!--<a href="{!! url('/login') !!}" class="sign-in"><i class="fa fa-user"></i> Log In / Register</a> -->

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
                    <li class="dropdown dropdown-menu-scroll-main">
                        <a tabindex="0" data-toggle="dropdown" data-submenu="" aria-expanded="false">
                            Properties<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-scroll">
                            @if(isset($propertyTypes))
                            @foreach($propertyTypes as $propertyType)
                                <li class="dropdown">
                                    <a class="properties-with-no-location" data-propertyID="{{$propertyType['id']}}"  href="{{route('search.result')}}?property_type_id={{$propertyType['id']}}" tabindex="0">{{$propertyType['name']}}</a>
                                </li>
                            @endforeach
                                @endif
                        </ul>
                    </li>
                     @if( ($flag == 1) && ($role==2))    

                        @if (Auth::guest())
                        <li>   <a class="sign-in visible-xs" href="{{ route('login') }}">Login</a></li>
                        <li>   <a class="sign-in visible-xs" href="{{ route('register') }}">Register</a></li>
                        @else

                        @if(Auth::user()->role==2)

                        <li class="visible-xs">
                            <a href="{{route('home')}}" class="sign-in" >
                                <i class="fa fa-user"></i> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                            </a>
                        </li>
                                <li class="visible-xs">
                                    <a href="{{route('seller-properties')}}" class="sign-in" >
                                        My Account
                                    </a>
                                </li>
                        @endif
                        <li class="visible-xs">
                            <a class="sign-in" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>

                        @endif
                    @else
                     @if (Auth::guest())
                        <li class="visible-xs" >  <a class="sign-in" href="{{ route('login') }}">Login</a></li>
                        <li class="visible-xs" >  <a class="sign-in" href="{{ route('register') }}">Register</a></li>
                        @endif

                    @endif 
                    {{--<li class="dropdown">
                        <a tabindex="0" data-toggle="dropdown" data-submenu="" aria-expanded="false">
                            Featured<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                <a tabindex="0">My Profile</a>
                                <ul class="dropdown-menu">
                                    <li><a href="my-profile.html">My Profile</a></li>
                                    <li><a href="my-bookmarks.html">My Bookmark</a></li>
                                    <li><a href="my-properties.html">My Property</a></li>
                                    <li><a href="change-password.html">Change Password</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a tabindex="0">Agents</a>
                                <ul class="dropdown-menu">
                                    <li><a href="agent-list.html">Agent List</a></li>
                                    <li><a href="agent-detail.html">Agent Details</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a tabindex="0">Blog</a>
                                <ul class="dropdown-menu">
                                    <li><a href="with-right-sidebar.html">With sidebar</a></li>
                                    <li><a href="fullwidth.html">Fullwidth</a></li>
                                    <li><a href="blog-single-sidebar.html">Single Sidebar</a></li>
                                    <li><a href="blog-single.html">Blog Single</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown active">
                        <a tabindex="0" data-toggle="dropdown" data-submenu="" aria-expanded="false">
                            Pages<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                <a tabindex="0">Extras</a>
                                <ul class="dropdown-menu">
                                    <li><a href="submit-property.html">Submit Property</a></li>
                                    <li><a href="typography.html">Typography</a></li>
                                    <li><a href="pricing-tables.html">Pricing Tables</a></li>
                                    <li><a href="elements.html">Elements</a></li>
                                    <li><a href="icon.html">icon</a></li>
                                </ul>
                            </li>
                            <li><a href="contact.html">contact</a></li>
                            <li><a href="about.html">About Us</a></li>
                            <li><a href="login.html">Login</a></li>
                            <li><a href="signup.html">Signup</a></li>
                            <li><a href="forgot-password.html">Forgot Password</a></li>
                            <li><a href="404.html">404</a></li>
                        </ul>
                    </li>--}}
                </ul>
            </div>

            <!-- /.navbar-collapse -->
            <!-- /.container -->
        </nav>
    </div>
</header>
<!-- Main header end -->

@yield('content')
        <!-- Partners block start -->
<!-- Partners block end -->

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
                   {{-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>--}}
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
                    @if( ($flag == 1) && ($role==2))
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

                        @else
                <ul class="links">
                    @if (Auth::guest())
                        <li>
                            <a href="{{ route('login') }}">Login</a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}">Register</a>
                        </li>
                    @endif
                </ul>
                
            @endif

            <!-- <div class="col-md-3 col-sm-6 footer-item clearfix">
                <div class="footer-item-content">
                    <div class="newsletter">
                        <h2 class="title">Newsletter</h2>
                       {{-- <div class="f-text">
                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </div>--}}

                        <form action="#" method="post">
                            <p>
                                <input class="nsu-field btn-block" id="nsu-email-0" type="text" name="useremail" placeholder="Enter your Email Address">
                            </p>

                            <p>
                                <button class="button-sm button-theme btn-block">Signup</button>

                       </form>
                        
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
                © <?php echo date("Y");?> <a href="{{route('home')}}"> ShareAir </a>‐ All Rights Reserved
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="social-list">
            </div>
        </div>
    </div>
</div>
<!-- Sub footer end -->
<div class="modal modal-metamask-addon" tabindex="-1" role="dialog" id="modalMetamaskAddon" aria-labelledby="modalMetamaskAddon" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <table>
                    <tr>
                        <td colspan="2" class=" pb-3">
                            <div class="alert alert-info mb-0 addon-alert-msg">
                                <div class="text-center"><i class="fa fa-exclamation-circle "></i> ShareAir requires the <strong>MetaMask add on</strong> or <strong>Mist</strong> to access the app <br> Currently MetaMask is only available with the Chrome and Firefox Browser.</div>

                            </div>

                        </td>
                    </tr>
                    <tr>

                        <td width="1%" valign="top">
                            <img class="img-fluid img-thumbnail img-metamask float-left" src="{{URL::asset('img/metamask.png')}}" alt="Metamask">
                        </td>
                        <td style="padding-left: 10px;">
                            <h5 class="modal-title title-metamask mb-3">
                                <strong>MetaMask</strong>
                                <small class="d-block">Ethereum Browser Extension</small>
                            </h5>

                            <p class="text-muted">MetaMask is an extension for accessing Ethereum enabled distributed applications, or "Dapps" in your normal browser!</p>

                            <p class="text-muted mb-0">The extension injects the Ethereum web3 API into every website's javascript context, so that dapps can read from the blockchain.</p>

                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <a href="" target="_blank" id="install-addon-btn" class="btn btn-primary btn-sm">Install Now</a>
                <a href="javascript:void(0);"  class="btn btn-secondary btn-sm" onclick="location.reload()">Refresh Page</a>
            </div>
        </div>
    </div>
</div>
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
<script src="{{ URL::asset('js/magnific-popup.js') }}"></script>
<script src="{{ URL::asset('js/dropzone.js') }}"></script>
<script src="{{ URL::asset('js/maps.js') }}"></script>
<script src="{{ URL::asset('js/nicescroll.js') }}"></script>
<script src="{{ URL::asset('js/app2.js') }}"></script>
@yield('scripts')
<script src="{{ URL::asset('js/ie10-viewport-bug-workaround.js') }}"></script>
<script src="{{ URL::asset('ckeditor/ckeditor.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function(){
        setTimeout(function() {
            $('.alert-success').fadeOut('slow');
        }, 3000);

        setTimeout(function() {
            $('.alert-danger').fadeOut('slow');
        }, 3000);
        CKEDITOR.replaceClass = 'textareaCls';


        var nicelist = $(".dropdown-menu-scroll").niceScroll({
            zindex: 9999
        });
        /*nicelist.mouseover(function() {
            nicelist.getNiceScroll().resize();
        });*/
        var dropmenuMain = $('.dropdown-menu-scroll-main');


        dropmenuMain.hover(function (e) {
            $(this).find('.dropdown a')

            $('a[data-toggle="dropdown"]', this).trigger('click');
        }, function () {
            $('a[data-toggle="dropdown"]', this).trigger('click');

        });
        dropmenuMain.on("shown.bs.dropdown", function (e) {
            nicelist.show().resize();
        });

        $(".dropdown-menu-scroll-main ").on("hidden.bs.dropdown", function (e) {
            nicelist.hide();
        });


    });
</script>
<script>
    $(function(){
        /*MetaMask Browser Addon Notification*/
        window.addEventListener('load', function() {
            var installAddonBtn = $('#install-addon-btn');
            // Checking if Web3 has been injected by the browser (Mist/MetaMask)
            function noAddonAvailable() {
                $('.modal-footer').remove();
                $('.addon-alert-msg').append('<p class="text-center small mt-2 mb-0  no-addon-note">ShareAir requires the <strong>MetaMask add on</strong> or <strong>Mist</strong> to access the app <br> Currently MetaMask is only available with the Chrome and Firefox Browser.</p>')
            }

            if (typeof web3 !== 'undefined') {
                // Use Mist/MetaMask's provider
                window.web3 = new Web3(web3.currentProvider);

            } else {
                console.log('No web3? You should consider trying MetaMask!')
                var metaMaskModal = $('#modalMetamaskAddon');
                metaMaskModal.modal('show');
                // fallback - use your fallback strategy (local node / hosted node + in-dapp id mgmt / fail)
                // window.web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:8545"));
                /**
                 * Detect OS & browsers
                 */
                /* Add class for mac */
                if(navigator.appVersion.indexOf("Win")!=-1) {
                    $('body').addClass('window-os');
                }
                if(navigator.platform.toUpperCase().indexOf('MAC')>=0) {
                    $('body').addClass('mac-os');
                }
                if(navigator.appVersion.indexOf("Linux")!=-1) {
                    $('body').addClass('linux-os');
                }
                /* Add class for all ie version */
                var trident = !!navigator.userAgent.match(/Trident\/7.0/);
                var net = !!navigator.userAgent.match(/.NET4.0E/);
                var IE11 = trident && net;
                var IEold = ( navigator.userAgent.match(/MSIE/i) ? true : false );
                if(IE11 || IEold){
                    $('body').addClass('ie');
                    noAddonAvailable();
                }
                var ua = navigator.userAgent.toLowerCase();
                if (ua.indexOf('safari') != -1) {
                    if (ua.indexOf('chrome') > -1) {
                        $('body').addClass('chrome');
                        installAddonBtn.attr('href','https://chrome.google.com/webstore/detail/metamask/nkbihfbeogaeaoehlefnkodbefgpgknn?hl=en');
                        $()
                    } else {
                        $('body').addClass('safari');
                        noAddonAvailable();
                    }
                }
                var FF = !(window.mozInnerScreenX == null);
                if(FF) {
                    $('body').addClass('fire-fox');
                    installAddonBtn.attr('href','https://addons.mozilla.org/en-US/firefox/addon/ether-metamask/');
                } else {
                    //$('body').addClass('not-fire-fox');
                }
                /* End */
            }

            // Now you can start your app & access web3 freely:
        });
    });
</script>

<!-- Custom javascript -->
</body>
</html>
