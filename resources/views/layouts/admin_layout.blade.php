<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>ShareAir</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- External CSS libraries -->
    {{--<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/jquery-ui.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/jquery-ui-theme.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/animate.min.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/pe-icon-7-stroke.css') }}"/>--}}

    <link rel="stylesheet" href="{{ URL::asset('admin/css/admin.css') }}"/>
    <!-- Favicon icon -->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" >
    @yield('css')
            <!-- Google fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800%7CPlayfair+Display:400,700%7CRoboto:100,300,400,400i,500,700">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    {{--<link rel="stylesheet" href="{{ URL::asset('css/ie10-viewport-bug-workaround.css') }}"/>--}}
    <script src="{{ URL::asset('js/ie8-responsive-file-warning.js') }}"></script>
</head>
<body>
<div class="page_loader"></div>
<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="assets/img/sidebar-5.jpg">
        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="http://www.shareair.io" class="simple-text">
                    <img src="{{URL::asset('img/Shareairlogo1.png')}}" alt="ShareAir">
                </a>
            </div>

            <ul class="nav">
                <li class="active">
                    <a href="{{route('propertytype.index')}}">
                        <i class="pe-7s-note2"></i>
                        <p>Manage Property Type</p>
                    </a>
                </li>           
            </ul>
        </div>
    </div>

    <div class="main-panel">
        <!-- Top header start -->
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ route('propertytype.index') }}">Dashboard</a>
                </div>
                <div class="collapse navbar-collapse">
                    {{--<ul class="nav navbar-nav navbar-left hide">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-dashboard"></i>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-globe"></i>
                                <b class="caret"></b>
                                <span class="notification">5</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Notification 1</a></li>
                                <li><a href="#">Notification 2</a></li>
                                <li><a href="#">Notification 3</a></li>
                                <li><a href="#">Notification 4</a></li>
                                <li><a href="#">Another notification</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="">
                                <i class="fa fa-search"></i>
                            </a>
                        </li>
                    </ul>--}}

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <!-- Authentication Links -->

                            @if(!Auth::guest())

                                {{--
                                <a href="#"  >
                                    {{ Auth::user()->name }}
                                </a>
                                --}}

                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>


                                @endif
                                        <!--
                            <a href="#">
                                Log out
                            </a>
                        -->
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Top header end -->

        <div class="content">
            @yield('content')
                    <!-- Footer start -->

        </div>

        <!-- Footer start -->
        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left hide">
                    <ul>
                        <li>
                            <a href="#">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Company
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Portfolio
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Blog
                            </a>
                        </li>
                    </ul>
                </nav>
                <p class="copyright pull-right">
                    &copy; 2017 <a href="http://www.shareair.com">ShareAir</a> All rights reserved
                </p>
            </div>
        </footer>
        <!-- Footer end -->
    </div>
</div>

<script src="{{ URL::asset('js/jquery-2.2.0.min.js') }}"></script>
<script src="{{ URL::asset('js/jquery-ui.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('js/moment.min.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap-submenu.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap-checkbox-radio-switch.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap-notify.js') }}"></script>
<script src="{{ URL::asset('js/chartist.min.js') }}"></script>
{{--<script src="{{ URL::asset('js/rangeslider.js') }}"></script>--}}
<script src="{{ URL::asset('js/jquery.mb.YTPlayer.js') }}"></script>
<script src="{{ URL::asset('js/wow.min.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ URL::asset('js/jquery.easing.1.3.js') }}"></script>
<script src="{{ URL::asset('js/jquery.scrollUp.js') }}"></script>
<script src="{{ URL::asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ URL::asset('js/leaflet-providers.js') }}"></script>
<script src="{{ URL::asset('js/leaflet.markercluster.js') }}"></script>
<script src="{{ URL::asset('js/dropzone.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap-datetimepicker.js') }}"></script>
<script src="{{ URL::asset('js/maps.js') }}"></script>
<script src="{{ URL::asset('js/app2.js') }}"></script>
<script src="{{ URL::asset('admin/js/admin.js') }}"></script>
<script src="{{ URL::asset('js/ie10-viewport-bug-workaround.js') }}"></script>
<script>
    function sortupdate(){
        var new_ajax_url =  "{{route('PropertyTypeSectionFieldOrder')}}";
        $.ajax({
            url: new_ajax_url,
            type:'GET',
            data: $("input[name='section_field_id[]']").serialize(),
            success:function(result){
            }
        });
    }
    $( function() {
        setTimeout(function() {
            $('.alert-success').fadeOut('slow');
        }, 3000);

        setTimeout(function() {
            $('.alert-danger').fadeOut('slow');
        }, 3000);

        $('#sortable').sortable({
            items: "li:not(.non-draggable)"
        });
        $( "#sortable" ).disableSelection();

        $( "#sortable2" ).sortable();
        $( "#sortable2" ).disableSelection();

        $( ".ui-sortable3" ).sortable();
        $( ".ui-sortable3" ).disableSelection();

        // $( "#div_sortable" ).sortable();


        $('#div_sortable').sortable({
                    // items: "div:not(.non-draggable)",

                cancel: '.non-draggable, .form-group input, .form-group select, .input-group input',
                start: function (event, ui) {
            $(ui.item).data("startindex", ui.item.index());

        },
            stop: function (event, ui)
            {
                var startIndex = ui.item.data("startindex");
                var stopindex = ui.item.index();
                var prev_element_index = stopindex;
                          // var prev_element_classname = $("#div_sortable").find('div:nth-child('+prev_element_index+')').attr('class');

                //alert("previous element index is" + prev_element_index);

                var prev_element = $('div#div_sortable>div:nth-child('+ prev_element_index + ')');

                //var prev_element = $("#div_sortable").children(prev_element_index);
                //alert(prev_element);


                if (prev_element.hasClass( "non-draggable" ))
                {
                    $(this).sortable('cancel');
                }
                else
                {
                    sortupdate();
                }
            }
        });

        //$("#div_sortable").disableSelection();
        // $('#div_sortable').sortable({ cancel: '.non-draggable' });
        //$("#div_sortable").enableSelection();


    } );
    $('form.d-inline-block').on("click",".btn-danger", function(e){ //user click on remove text links
        
        if (!confirm('Are you sure? You want to delete.')) {
        e.preventDefault();
    }
      
    });  
</script>

<!-- Custom javascript -->
@yield('scripts')

</body>
</html>