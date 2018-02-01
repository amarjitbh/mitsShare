@extends('layouts.before_login_seller')
@section('content')

        <!-- Banner start -->
<div class="banner text-center">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="img/banner/banner-slider-1.jpg" alt="banner-slider-1">
                <div class="container">
                    <div class="carousel-caption banner-slider-inner banner-top-align">
                        <div>
                            <h1 data-animation="animated fadeInDown delay-05s"><span>Welcome to</span> ShareAir</h1>
                            <p data-animation="animated fadeInUp delay-05s">ShareAir is a peer to peer marketplace and escrow smart contract designed for renters and owners.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <img src="img/banner/banner-slider-2.jpg" alt="banner-slider-2">
                <div class="carousel-caption banner-slider-inner banner-top-align">
                    <div>
                        <h1 data-animation="animated fadeInDown delay-05s"><span>Welcome to</span> ShareAir</h1>
                        <p data-animation="animated fadeInUp delay-05s">ShareAir leverages Ethereum to cut out the middlemen associated with the transaction, the end result is cheaper rates for renters and higher margins for owners.</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <img src="img/banner/banner-slider-2.jpg" alt="banner-slider-2">
                <div class="carousel-caption banner-slider-inner banner-top-align">
                    <div>
                        <h1 data-animation="animated fadeInDown delay-05s"><span>Welcome to</span> ShareAir</h1>
                        <p data-animation="animated fadeInUp delay-05s">Renters and Owners use the ShareAir app to access all the benefits of Ethereum this includes authentic reputation and identity systems.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="slider-mover-left" aria-hidden="true">
                <img src="img/chevron-left.png" alt="chevron-left">
            </span>
            <span class="sr-only">Previous</span>
        </a>

        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="slider-mover-right" aria-hidden="true">
                <img src="img/chevron-right.png" alt="chevron-right">
            </span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="search-area search-section-default-view hidden-xs">
        <div class="search-area-inner">
            <div class="search-contents show-search-area animated fadeInUp">
                <div class="my-address property-search-filter">
                    <form method="get" id="home-search-form" class="home-search-form web"  action="{{route('search.result')}}">
                        <input type="hidden" name="display" value="{{$display}}"/>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                <div class="form-group">
                                    <select name="property_type_id" class="selectpicker search-fields" id="propertyType">
                                        <option selected value="">Property Type</option>
                                        <?php isset($propertyTypes) && $propertyTypes != '' ?>
                                        @foreach($propertyTypes as $propertyType)
                                            <option value="{{$propertyType['id']}}"  {{$propertyType['id'] == $propertyTypesId ? 'selected' : ''}}>{{$propertyType['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                <div class="form-group">
                                    <input name="location" id="getLocationInput" onFocus="geolocate()" type="text" class="getLocationInput input-text validate-location mt-0 mb-0"  placeholder="Location" autocomplete="off">
                                    <input type="hidden" class="getLat" id="getLat"  name="lat"/>
                                    <input type="hidden" class="getLong" id="getLong"  name="long"/>
                                    <?php
                                    //$sessionLat =  Session::get('lat');
                                    //$sessionLng = Session::get('lng');
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="input-group input-group-noaddon input-daterange-1">
                                        <input name="start_date" id="start-date" type="text" class="start-date input-text search-date" placeholder="Start Date" autocomplete="off">
                                        <span class="input-group-addon hide-addon"></span>
                                        <input name="end_date" id="end-date" type="text" class="end-date input-text search-date" placeholder="End Date" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-8 col-xs-offset-2 col-lg-2 col-md-2 col-sm-6 col-sm-offset-0">
                                <div class="form-group">
                                    <button id="search-result" type="button" class="search-button">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @if($errors->has('property_type_id'))
                        <div class="alert alert-danger">
                            {{ $errors->first('property_type_id') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner end -->
<div class="clearfix"></div>

<!-- Search Section start -->
<div class="search-section search-section-mobile-view hidden-sm hidden-md hidden-lg">
    <div class="container">
        <div class="search-section-area">
            <div class="search-area-inner">
                <div class="search-contents show-search-area animated fadeInUp">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Search Section end -->

   <!-- Search banner start -->

<!-- Search banner end -->

<!-- Properties section body start -->
<div class="properties-section-body content-area">
    <div class="container">
        <div class="row">
            <div  @if($display=="list")
                    class="col-lg-12"
                    @elseif($display=="grid")
                    class = "col-lg-12 col-md-12 col-xs-12"
                    @endif
                    >
                <!-- Option bar Start -->
                <div class="option-bar">
                    <div class="row">
                       <div class="col-lg-6 col-md-5 col-sm-5 col-xs-2">
                           <h4>
                                <span class="heading-icon">
                                    <i class="fa fa-th-large
                                    @if(($display == "grid")||(!isset($display)))
									    fa fa-th-large
									@elseif($display == "list")
									    fa fa-th-list
									@endif
                                    "></i>
                                </span>
                                <span class="hidden-xs">

								    @if($display == 'grid')
                                        Properties Grid
									@endif
                                    @if($display == 'list')
                                        Properties List
                                    @endif
                                </span>
                            </h4>
                        </div>
                        <div class="col-lg-6 col-md-7 col-sm-7 col-xs-10 cod-pad">
                            <div class="sorting-options">
                                <form method="get" id="hidden-form-values" class="d-inline-block w-100p" action="{{route('home')}}">
                                <select id="filter-order-by" name="filter_order_by" class="sorting">
                                   <option @if($order_by == 1) selected @endif value="1">Price High to Low</option>
                                   <option @if($order_by == 2) selected @endif value="2">Price: Low to High</option>
                                   <option @if($order_by == 3) selected @endif value="3">Newest Properties</option>
                                   <option @if($order_by == 4) selected @endif value="4">Oldest Properties</option>
                                </select>
                                    <input name="display" type="hidden" id="display" value="@if(isset($display)){{$display}} @endif">
                                    <input name="offset" type="hidden" value="0">

                                    <a href="{{route('home')}}?display=list" id="list_button" class="change-view-btn
                                    @if($display == "list")
									    active-view-btn
									@endif
                                "><i class="fa fa-th-list"></i></a>
                                <a href="{{route('home')}}?display=grid" id="grid_button" class="change-view-btn
                                 @if(($display == "grid")||(!isset($display)))
									active-view-btn
									@endif
                                "><i class="fa fa-th-large"></i></a>
                                </form>
                           </div>
                       </div>
                   </div>
               </div>
               <!-- Option bar end -->
                <div class="clearfix"></div>
                <!-- grid properties start -->
                <div class="newAppendData">
                    <div @if($display=="list")
                         class=""
                         @elseif($display=="grid")
                         class = "row"
                            @endif>

                        <div class="col-sm-12">
                            @if(empty($propertyArr))
                                <p>Sorry No Properties Found</p>
                            @endif
                        </div>@php $row_counter = 1;
                                $main_counter = 1;
                                $property_arr_size = sizeof($propertyArr); @endphp

                        @if(!empty($propertyArr))
                            @foreach($propertyArr as $property) {{-- Display as List start--}}
                                @if((isset($display))&& ($display == "list"))
                                    <div  class="listing-properties-box wow fadeInUp delay-03s row  d-flex row mlr-0 no-flex-sm" style="width: 100%; visibility: visible; animation-name: fadeInUp;">
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 listing-propertie-theme">
                                            @if(isset($property['basic_feature_image']))
                                                @php $jsonImages = json_decode($property['basic_feature_image'], true ); @endphp
                                                @foreach($jsonImages as $jsonImg)
                                                    @if($jsonImg['chk']==1)
                                                        @php $url_img = asset(config('constants.IMAGE_FOLDER_NAME').'/'.$jsonImg['image']); @endphp
                                                    @endif
                                                @endforeach
                                            @else
                                                @php $url_img = asset('img/placeholder/placeholder-product.jpg');@endphp
                                            @endif
                                            <a href="{{route('property.detail')}}?property_id={{$property['property_id']}}">
                                                <div class="product-image-list-container" style="background-image: url('{{$url_img}}')"></div>
                                            </a>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 detail">
                                            <!-- Header -->
                                            <header class="clearfix">
                                                <div class="pull-left">
                                                    <h1 class="title">
                                                        <a href="{{route('property.detail')}}?property_id={{$property['property_id']}}">{{isset($property['basic_name']) ? $property['basic_name'] : ''}}</a>
                                                    </h1>
                                                    <h3 class="location">
                                                        <a href="#" class="truncate-para">
                                                            <i class="fa fa-map-marker"></i>{{isset($property['basic_location']) ? $property['basic_location'] : '' }}
                                                        </a>
                                                    </h3>
                                                </div>
                                                <!-- Btn -->
                                                <div class="pull-right">
                                                    <a href="{{route('property.detail')}}?property_id={{$property['property_id']}}" class="button-sm button-theme">Details</a>
                                                </div>
                                            </header>
                                            <div class="font-12 mb-0 truncate-para description_ckeditor">@if(isset($property['basic_description'])) @php echo html_entity_decode($property['basic_description']) @endphp @else ''@endif</div>
                                            <div class="footer mt-15">
                                                <span class="text-capitalize">
                                                        <i class="fa fa-calendar-o"></i>
                                                    @php
                                                    $created = new Carbon($property['created_at']);
                                                    $now = Carbon::now();
                                                    echo $difference = ($created->diff($now)->days < 0)
                                                                ? 'Today' :$created->diffForHumans();
                                                    @endphp
                                                </span>

                                                <span class="mr-5">
                                                    <i class="fa fa-user"></i> {{isset($property['first_name']) ? $property['first_name'] : '' }} {{isset($property['last_name']) ? $property['last_name'] : '' }}
                                                </span>

                                                <a href="#" class="price">
                                                    $ {{$property['basic_price']}} / Day
                                                </a>
                                            </div>
                                        </div>
                                    </div>{{-- Display as List end--}}
                                @else {{-- Display as Grid --}}
                                    @if($row_counter > 3)
                                        @php $row_counter = 1; @endphp
                                    @endif
                                    @if($row_counter == 1)
                                        <div style="display: inline-block; width:100%;">
                                    @endif
                                        <div class="col-lg-4 col-md-4 col-sm-6 wow fadeInUp delay-03s" >
                                            <div class="thumbnail recent-properties-box">
                                                @if(isset($property['basic_feature_image']))
                                                    @php $jsonImages = json_decode($property['basic_feature_image'], true ); @endphp
                                                    @if(!empty($jsonImages) && is_array($jsonImages))
                                                        @foreach($jsonImages as $jsonImg)
                                                            @if($jsonImg['chk']==1)
                                                                @php $url_img = asset(config('constants.IMAGE_FOLDER_NAME').'/'.$jsonImg['image']); @endphp
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @else
                                                    @php $url_img = asset('img/placeholder/placeholder-product.jpg');@endphp
                                                @endif
                                                <a href="{{route('property.detail')}}?property_id={{$property['property_id']}}">
                                                    <div class="product-image-container" style="background-image:url('{{$url_img}}')"></div>
                                                </a>
                                                <div class="caption detail"><!-- Detail -->
                                                    <header class="clearfix"> <!-- Header -->
                                                        <div class="pull-left truncate-section">
                                                            <h1 class="title">
                                                                <a href="{{route('property.detail')}}?property_id={{$property['property_id']}}">{{isset($property['basic_name']) ? $property['basic_name'] : ''}}</a>
                                                            </h1>
                                                        </div>
                                                        <div class="price">
                                                            $ {{isset($property['basic_price']) ? $property['basic_price'] : ''}}
                                                        </div>
                                                    </header>
                                                    <h3 class="location truncate-title">
                                                        <a href="#">
                                                            <i class="fa fa-map-marker"></i>{{isset($property['basic_location']) ? $property['basic_location'] : '' }}
                                                        </a>
                                                    </h3>
                                                    <div class="font-12 mb-0 truncate-para description_ckeditor">@if(isset($property['basic_description'])) @php echo html_entity_decode($property['basic_description']) @endphp @else ''@endif</div>
                                                        <div class="footer">
                                                            <i class="fa fa-user"></i>
                                                             @if (Auth::check())
                                                                <a href="{{route('seller.detail')}}?sellerId={{$property['seller_id']}}">
                                                            @else
                                                                <a href="{{route('seller.profile')}}?sellerId={{$property['seller_id']}}">
                                                            @endif

                                                             {{isset($property['first_name']) ? $property['first_name'] : '' }} {{isset($property['last_name']) ? $property['last_name'] : '' }}
                                                            </a>

                                                            <span class="text-capitalize">
                                                                <i class="fa fa-calendar-o"></i>
                                                                @php
                                                                    $created = new Carbon($property['created_at']);
                                                                    $now = Carbon::now();
                                                                    echo $difference = ($created->diff($now)->days < 0)
                                                                        ? 'Today' :$created->diffForHumans();
                                                                @endphp
                                                            </span>
                                                        </div>
                                                    </div>
                                                 </div>
                                             </div>
                                            @if(($row_counter == 3) || ($main_counter == $property_arr_size))
                                        </div>
                                        @endif
                                @endif
                                @php
                                    $row_counter++;
                                    $main_counter++;
                                @endphp
                            @endforeach
                        @endif
                    </div>
                </div><!-- End Ajax Result -->
            </div>
        </div>
    </div>
</div>
<!-- Properties section body end -->
@endsection

@section('scripts')

    <script src="{{ asset( 'js/toastr.min.js' ) }}"></script>
    <script src="{{ asset( 'js/jquery.validate.min.js' ) }}"></script>
    {{--<script>
        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(
                    function(position){
                        //alert((position.coords.latitude));
                        $('#getLatSearchBar').val(position.coords.latitude);
                        $('#getLongSearchBar').val(position.coords.longitude);
                    },
                    function(error){
                      //  alert(error.message);
                    }

            );
        } else{
            console.log("Sorry, your browser does not support HTML5 geolocation.");
        }
    </script>--}}
    <script>
            var flag = 0;
            var ajaxOffset=0;
            $( document ).ready(function() {
                $(window).on('load', function() {
                   $('#getLat').val('0');
                   $('#getLong').val('0');
               });

            $("#home-search-form").validate({
                rules: {
                    location: "required",
                    property_type_id: "required"
                },
                messages: {
                    location: "Please specify the  location",
                    property_type_id: "Please select the property to be search"
                },
                errorElement: 'span',
                errorClass: 'text-danger',
                errorPlacement: function(error, element) {
                    if(element.parent('.input-group').length || element.parent('.btn-group').length) {
                        error.insertAfter(element.parent()).addClass('mt-5 font-12 text-danger d-inline-block');
                    }
                    else {
                        error.insertAfter(element).addClass('mt-5 font-12 text-danger d-inline-block');
                    }
                },

            });

            $('.validate-location').keypress(function(e) {
                var keycode = (e.keyCode ? e.keyCode : e.which);
                if (keycode == '13') {
                    setTimeout(function(){
                        if($('#getLat').val() != '' && $('#getLat').val() != '0'){
                            $('#search-result').trigger('click');
                        }
                    },50);
                }
            });


           var startDate = $('.start-date');
           var endDate = $('.end-date');
            // Web
           $('.search-button').click(function(){
               if($("#home-search-form").valid() == false){
                   return false;
               }else{
                   if( startDate.val() && endDate.val() ){
                       if(endDate.val()<startDate.val()){
                           var errorMsgDiv = $('.toast-error').length;
                           if(errorMsgDiv==0) {
                               toastr.error('Sorry,  End date must be greater than start date',' ', {timeOut: 600});
                           }
                           return false;
                       }
                   }
                   $("#home-search-form").submit();
               }
           });

            // Mob
            $('.search-button').click(function(){
                if($("#home-search-form-web").valid() == false){
                    return false;
                }else{
                    if( startDate.val() && endDate.val() ){
                        if(endDate.val()<startDate.val()){
                            var errorMsgDiv = $('.toast-error').length;
                            if(errorMsgDiv==0) {
                                toastr.error('Sorry,  End date must be greater than start date',' ', {timeOut: 600});
                            }
                            return false;
                        }
                    }
                    $("#home-search-form-web").submit();
                }
            });

           $('#propertyType').on('change', function (e) {
               $('#search-result').prop('disabled', false);
           });

           $('#filter-order-by').on('change', function() {
               $("#hidden-form-values").submit();
           });

           startDate.datetimepicker({
               format:'YYYY-MM-DD',
              // minDate:new Date(),
               minDate: moment().startOf('d')
               //useCurrent: false,
           }).on("keydown", function(e){
               if (e.which == 13) {
                   $('#search-result').trigger('click');
               }
           });
           endDate.datetimepicker({
               format:'YYYY-MM-DD',
               minDate: moment().startOf('d')
           }).on("keydown", function(e){
               if (e.which == 13) {
                   $('#search-result').trigger('click');
               }
           });

            $(document).on('click','.properties-with-no-location', function(e) {
                var propertyId = $(this).attr("data-propertyid");
                $(this).prop("href", "{{route('search.result')}}?property_type_id="+propertyId+"&setData=1");
            });

            // Send Ajax On scroll
            $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() == $(document).height()) {
                    ajaxOffset = ajaxOffset*1 + 6;
                    var display = $('#display').val();
                    var orderBy = $('#filter-order-by').val()
                    if(flag==0){
                        $.ajax({
                            type : 'get',
                            url  : "{{route('home')}}",
                            data : {display:display, offset:ajaxOffset, filter_order_by:orderBy },
                            dataType : 'JSON',
                            success : function(response){
                                if(response.success==100){
                                    $('.newAppendData').append(response.data);
                                } else{
                                    flag = 1; // Stop Ajax
                                }
                            },
                        });
                    }
                }
            });

                $(window).on('resize load', function() {
                    let getWindowWidth = $(window).width();
                    //console.log(getWindowWidth)
                    const getSearchContainerDefaultSection = $('body').find('.search-section-default-view');
                    const getSearchContainerMobileMenu = $('body').find('.search-section-mobile-view');


                    if(getWindowWidth < 767) {
                        let detachSearchSection = getSearchContainerDefaultSection.find('.property-search-filter').detach();
                        $('body').find('.search-section-mobile-view .search-contents').append(detachSearchSection);
                    }
                    else {
                        if(getSearchContainerMobileMenu.find('.search-contents').html() !== '') {
                            let detachSearchSection = getSearchContainerMobileMenu.find('.property-search-filter').detach();
                            getSearchContainerDefaultSection.find('.search-contents').append(detachSearchSection);
                        }
                    }
                });

        });
    </script>

@endsection

