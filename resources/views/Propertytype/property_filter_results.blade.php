@extends('layouts.before_login_seller')


@section('css')
    <style>
        #field, label {
            float: none;
        }
    </style>
@endsection
@section('content')
    <div class="page_loader"></div>
    <!-- Sub banner start -->
    <div class="sub-banner">
        <div class="overlay">
            <div class="container">
                <div class="breadcrumb-area">
                    {{--<div class="top">
                        <h1>Properties Grid Leftside</h1>
                    </div>
                    <ul class="breadcrumbs">
                        <li><a href="{{route('home')}}">Home</a></li>
                        <li class="active">Properties Grid Leftside</li>
                    </ul>--}}
                </div>
            </div>
        </div>
    </div>
    <!-- Sub Banner end -->

    <!-- Properties section body start -->
    <div class="properties-section-body content-area">
        <div class="container">
            <div class="row-not">
                <div class="right-sidebar col-lg-8 col-md-8 col-xs-12 col-md-push-4">

                    <!-- Option bar start -->
                    <div class="option-bar">
                        <div class="row">
                            <div class="col-lg-6 col-md-5 col-sm-5 col-xs-2">
                                <h4>
                                <span class="heading-icon">
                                    <i class="fa @if($display === 'grid')
                                            fa-th-large
                                        @else
                                            fa-th-list
                                        @endif
                                            "></i>
                                </span>
                                <span class="hidden-xs">
                                	@if($display === 'grid')
                                        Properties Grid
                                    @else
                                        Properties List
                                    @endif
                                </span>
                                </h4>
                            </div>
                            <div class="col-lg-6 col-md-7 col-sm-7 col-xs-10 cod-pad">
                                <div class="sorting-options">
                                    <form method="get" id="hidden-form-values" class="d-inline-block w-100p" action="{{route('search.result')}}">
                                        <input name="location" type="hidden" value="@if(isset($location)){{$location}} @endif">
                                        <input name="start_date" value="@if(isset($startDate)){{$startDate}}@endif" type="hidden">
                                        <input name="end_date" type="hidden" value="@if(isset($endDate)){{$endDate}} @endif">
                                        <input name="property_type_id" type="hidden" value="@if(isset($propertyTypesId)){{$propertyTypesId}} @endif">
                                        <input name="min_price" type="hidden" value="@if(isset($min_price)){{$min_price}} @endif">
                                        <input name="max_price" type="hidden" value="@if(isset($max_price)){{$max_price}} @endif">
                                        <input name="display" type="hidden" value="@if(isset($display)){{$display}} @endif">
                                        <input type="hidden" id="hidden-form-offset" name="offset" value="0">
                                        <input type="hidden" id="getLat"  value="@if(isset($latitude)){{$latitude}} @endif" name="lat"/>
                                        <input type="hidden" id="getLong"  value="@if(isset($longitude)){{$longitude}} @endif" name="long"/>
                                        <input type="hidden" name="distance"  value="@if(isset($distance)){{$distance}}@endif">
                                        @if(isset($filters))
                                            @foreach($filters as $filter)
                                                <input type="hidden" value="{{$filter}}" name="property_filters[]" >
                                            @endforeach
                                        @endif
                                        <select id="filter-order-by" name="filter_order_by" class="sorting">
                                            <option @if ($order_by == 1) selected @endif value="1">Price High to Low</option>
                                            <option @if ($order_by == 2 ) selected @endif  value="2">Price: Low to High</option>
                                            <option @if ($order_by == 3 ) selected @endif  value="3">Newest Properties</option>
                                            <option @if ($order_by == 4 ) selected @endif value="4">Oldest Properties</option>
                                            @if($setData==0)
                                                <option @if ($order_by == 5 ) selected @endif value="5">Sort By Ascending (Distance)</option>
                                                <option @if ($order_by == 6 ) selected @endif value="6">Sort By Descending (Distance)</option>
                                            @endif
                                        </select>
                                        <a id="list" href="{{route('search.result')}}?property_type_id={{$propertyTypesId}}&location={{$location}}&start_date={{$startDate}}&end_date={{$endDate}}&min_price={{$min_price}}&max_price={{$max_price}}&display=list&filter_order_by={{$order_by}}&distance={{$distance}}&lat={{$latitude}}&long={{$longitude}}" class="change-view-btn @if($display === 'list') active-view-btn @endif"><i class="fa fa-th-list"></i>
                                        </a>
                                        <a id="grid" href="{{route('search.result')}}?property_type_id={{$propertyTypesId}}&location={{$location}}&start_date={{$startDate}}&end_date={{$endDate}}&min_price={{$min_price}}&max_price={{$max_price}}&display=grid&filter_order_by={{$order_by}}&distance={{$distance}}&lat={{$latitude}}&long={{$longitude}}" class="change-view-btn @if($display === 'grid') active-view-btn @endif"><i class="fa fa-th-large"></i></a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Option bar end -->
                    <div class="clearfix"></div>
                    <div class="row-not newAppendData">
                        @if(empty($propertyArr))
                            <div class="col-sm-12">
                                <p>Sorry No Properties Found</p>
                            </div>
                        @endif
                        <?php $row_counter = 1;
                        $main_counter = 1;
                        $property_arr_size = sizeof($propertyArr);
                        ?>

                        @if(!empty($propertyArr))
                            @foreach($propertyArr as $property)
                                {{-- Display as List start--}}
                                @if((isset($display))&& ($display == "list"))

                                    <div class="listing-properties-box wow fadeInUp delay-03s row  d-flex row mlr-0 no-flex-sm" style="visibility: visible; animation-name: fadeInUp;">
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 listing-propertie-theme">
                                            <!-- Tag -->
                                            @if(isset($property['basic_feature_image']))
                                                @php $jsonImages = json_decode($property['basic_feature_image'], true ); @endphp
                                                @foreach($jsonImages as $jsonImg)
                                                    @if($jsonImg['chk']==1)
                                                        @php $url_img = asset(config('constants.IMAGE_FOLDER_NAME').'/'.$jsonImg['image']); @endphp
                                                    @endif
                                                @endforeach
                                                <a href="{{route('property.detail')}}?property_id={{$property['property_id']}}">
                                                    <div class="product-image-list-container" style="background-image: url('@if(isset($url_img)) {{$url_img}} @endif')"></div>
                                                </a>
                                            @else
                                                <a href="{{route('property.detail')}}?property_id={{$property['property_id']}}">
                                                    <div class="product-image-list-container" style="background-image: url('{{URL::asset('img/placeholder/placeholder-product.jpg')}}')"></div>
                                                </a>
                                            @endif
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 detail detail-custom-section">
                                            <!-- Header -->
                                            <header class="clearfix">
                                                <div class="pull-left truncate-section">
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
                                                    <a class="button-sm button-theme" href="{{route('property.detail')}}?property_id={{$property['property_id']}}">Details</a>
                                                </div>
                                            </header>
                                            <!-- start footer -->
                                            <div class="font-12  truncate-para description_ckeditor">@if(isset($property['basic_description'])) @php echo html_entity_decode($property['basic_description']) @endphp @else ''@endif</div>
                                            <div class="footer clearfix">
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
                                            <!-- end footer -->
                                        </div>
                                    </div>

                                    {{-- Display as List end--}}
                                @elseif(!isset($display) || (isset($display)&&($display == "grid")))
                                    {{-- Display as Grid --}}
                                    <?php
                                    if($row_counter > 3){
                                        $row_counter = 1;
                                    }
                                    ?>
                                    @if($row_counter == 1)
                                        <div class="test">
                                            @endif
                                            <div class="filterData"></div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 wow fadeInUp delay-03s" >
                                                <div class="thumbnail recent-properties-box ">
                                                    @if(isset($property['basic_feature_image']))
                                                        @php $jsonImages = json_decode($property['basic_feature_image'], true ); @endphp
                                                        @if(!empty($jsonImages) && is_array($jsonImages))
                                                        @foreach($jsonImages as $jsonImg)
                                                            @if($jsonImg['chk']==1)
                                                                @php $url_img = asset(config('constants.IMAGE_FOLDER_NAME').'/'.$jsonImg['image']); @endphp
                                                            @endif
                                                        @endforeach
                                                        @endif
                                                        <a href="{{route('property.detail')}}?property_id={{$property['property_id']}}">
                                                            <div class="product-image-container" style="background-image: url('@if(isset($url_img)) {{$url_img}} @endif')"></div>
                                                        </a>
                                                    @else
                                                        <a href="{{route('property.detail')}}?property_id={{$property['property_id']}}">
                                                            <div class="product-image-container" style="background-image: url('{{URL::asset('img/placeholder/placeholder-product.jpg')}}')"></div>
                                                        </a>
                                                        @endif

                                                                <!-- Detail -->
                                                        <div class="caption detail">
                                                            <!-- Header -->
                                                            <header class="clearfix">
                                                                <div class="pull-left">
                                                                    <h1 class="title">
                                                                        <a href="{{route('property.detail')}}?property_id={{$property['property_id']}}">{{isset($property['basic_name']) ? $property['basic_name'] : ''}}</a>
                                                                    </h1>
                                                                </div>
                                                                <!-- Price -->
                                                                <div class="price">
                                                                    $ {{isset($property['basic_price']) ? $property['basic_price'] : ''}}
                                                                </div>
                                                            </header>
                                                            <div class="pull-right">
                                                                <a href="{{route('property.detail')}}?property_id={{$property['property_id']}}" class="button-sm button-theme">Details</a>
                                                            </div>
                                                            <!-- Location -->
                                                            <h3 class="location truncate-title">
                                                                <a href="#">
                                                                    <i class="fa fa-map-marker"></i>{{isset($property['basic_location']) ? $property['basic_location'] : '' }}
                                                                </a>
                                                            </h3>

                                                            <div class="font-12 mb-0 truncate-para description_ckeditor">@if(isset($property['basic_description'])) @php echo html_entity_decode($property['basic_description']) @endphp @else ''@endif</div>
                                                            <!-- Location -->

                                                            <div class="footer">
                                                                <i class="fa fa-user"></i> {{isset($property['first_name']) ? $property['first_name'] : '' }} {{isset($property['last_name']) ? $property['last_name'] : '' }}
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

                                                        <!-- Tag -->
                                                </div>
                                            </div>
                                            @if(($row_counter == 3) || ($main_counter == $property_arr_size))
                                        </div>
                                    @endif
                                @endif
                                <?php
                                $row_counter++;
                                $main_counter++;
                                ?>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="left-sidebar col-lg-4 col-md-4 col-xs-12 col-md-pull-8">
                <!-- Search contents sidebar start -->
                <div class="sidebar sidebar-widget">
                    <h3 class="title">Find your Property</h3>
                    <form method="get" id="search-filters" action="{{route('search.result')}}">
                        <input type="hidden" name="setData" id="setData" value="{{$setData}}" name="long"/>
                        <div class="form-group">
                            <input name="location" id="getLocationInput" onfocus="geolocate()" type="text" class="form-control validate-location search-fields" value="{{$location}}"  placeholder="Enter Address eg. Street,City" autocomplete="off">
                            <input type="hidden" id="getLatFilter"  value="@if(isset($latitude)){{$latitude}}@endif" name="lat"/>
                            <input type="hidden" id="getLongFilter"  value="@if(isset($longitude)){{$longitude}}@endif" name="long"/>
                        </div>
                        <div class="form-group">

                            <div class="input-group input-group-noaddon input-daterange-1">
                                <label for="start-date" class="sr-only">Start Date</label>
                                <input placeholder="Start Date" name="start_date" id="start-date" value="{{$startDate}}" type="text" class="form-control search-fields">
                                <span class="input-group-addon hide-addon"></span>
                                <label for="end-date" class="sr-only">End Date</label>
                                <input placeholder="End Date"  name="end_date" id="end-date" type="text" value="{{$endDate}}" class="form-control search-fields">
                            </div>

                        </div>
                        <div class="form-group">
                            <select name="property_type_id" class="selectpicker search-fields" id="propertyType">
                                <?php isset($propertyTypes) && $propertyTypes != '' ?>
                                @foreach($propertyTypes as $propertyType)
                                    <option  @if ($propertyTypesId == $propertyType['id']) selected @endif value="{{$propertyType['id']}}">{{$propertyType['name']}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="clearfix"></div>
                        <div class="range-slider">
                            <label for="amount">Price range:</label>
                            <input type="text" id="amount" readonly class="mt-0 mr-0 font-13 range-value text-right pull-right">
                            <div class="clearfix"></div>
                            <div id="slider-range"></div>
                        </div>
                        <input type="hidden" name="min_price" value="@if(isset($min_price)){{$min_price}}@endif" id="min-price">
                        <input type="hidden" name="max_price" value="@if(isset($max_price)){{$max_price}}@endif" id="max-price">
                        <input type="hidden" name="display" value="@if(isset($display)){{$display}} @endif">
                        <input type="hidden" name="filter_order_by" value="@if(isset($order_by)){{$order_by}} @endif">
                        <div class="range-slider">
                            <label for="distance">Distance (in KM):</label>
                            <input type="text" id="distance" readonly class="mt-0 mr-0 font-13 range-value text-right pull-right">
                            <div class="clearfix"></div>
                            <div id="distance-range"></div>
                        </div>
                        <input type="hidden" name="distance" id="sliderdistance" value="@if(isset($distance)){{$distance}}@endif">
                        <input type="hidden" id="offset" name="offset" value="0">
                        @if(count($filter_array))
                            <a class="show-more-options" data-toggle="collapse" data-target="#options-content">
                                <i class="fa fa-plus-circle"></i> Show More Filters
                            </a>
                            <div id="options-content" class="collapse">
                                @foreach ($filter_array as $key => $filtersOrg)
                                    <label>{{$key}}</label>
                                    @foreach ($filtersOrg as $filterKey => $value)
                                        <div class="checkbox checkbox-theme checkbox-circle">
                                            <input class="filters" type="checkbox" id="{{$filterKey}}" name="property_filters[]"
                                                   @if(isset($filters))
                                                   @foreach($filters as $filterChk)
                                                       @if($filterChk==$filterKey)
                                                        checked="checked"
                                                       @endif
                                                   @endforeach
                                                   @endif


                                                   value="{{ $filterKey }}"> <label class="no-float" for="{{$filterKey}}">
                                                {{ $value }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        @endif
                        <div class="form-group">
                            <button type="button" id="search-button" class="search-button">Search</button>
                        </div>
                    </form>
                </div>
                <!-- Search contents sidebar end -->
            </div>
        </div>
    </div>
    </div>
    {{--<div class="filterData"></div>--}}
    <!-- Properties section body end -->


@endsection

@section('scripts')
    <script src="{{ URL::asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset( 'js/toastr.min.js' ) }}"></script>
    <script src="{{ asset( 'js/jquery.validate.min.js' ) }}"></script>

    <script>

        $(document).ready(function(){
            $(window).on('load', function(){
                $('#offset').val(4);
            });

            var minconst = {{$min_price}};
            var maxcost = {{$max_price}};
            var distance = {{$distance}};
            var flag = 0;
            if(maxcost == 0) {
                maxcost = 100000
            }
            // Price Slider
            $( "#slider-range" ).slider({
                range: true,
                min: 0,
                max: 100000,
                step: 1000,
                values: [ minconst, maxcost ],
                classes: {"ui-slider-range": "ui-slider-theme-bg"},
                slide: function( event, ui ) {
                    $( "#min-price" ).val( ui.values[ 0 ] );
                    $( "#max-price" ).val( ui.values[ 1 ] );
                    $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
                },
                change: function(event, ui) {
                    $('#offset').val(0);
                    $('#setData').val(0);
                    $("#search-filters").submit();
                }
            });
            $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
                    " - $" + $( "#slider-range" ).slider( "values", 1 ) );

            // Distance Slider
            $( "#distance-range" ).slider({
                range: "min",
                min: 0,
                max: 200,
                value: [distance],
                step: 1,
                //values: [ distance, 5000 ],
                classes: {"ui-slider-range": "ui-slider-theme-bg"},
                slide: function( event, ui ) {
                    $( "#distance" ).val( ui.value );
                    $( "#sliderdistance" ).val( ui.value );

                },
                change: function(event, ui) {
                    $('#offset').val(0);
                    $('#setData').val(0);
                    $("#search-filters").submit();
                }
            });
            $( "#distance" ).val($( "#distance-range" ).slider( "value" ) );


            $("#search-filters").validate({
                rules: {
                    location: "required"
                },
                messages: {
                    location: "Please specify the location"

                }
            });

            $('#search-button').click(function() {
                if($("#search-filters").valid() == false){
                    return false;
                }else{
                    $('#offset').val(0);
                    $('#setData').val(0);
                    if( startDate.val() && endDate.val() ){
                        if(endDate.val()<startDate.val()){
                            var errorMsgDiv = $('.toast-error').length;
                            if(errorMsgDiv==0) {
                                toastr.error('Sorry,  End date must be greater than start date',' ', {timeOut: 600});
                            }
                            return false;
                        }
                    }
                    $("#search-filters").submit();
                }
            });



            var startDate = $('.input-daterange-1 #start-date');
            var endDate = $('.input-daterange-1 #end-date');
            if(startDate.val()){
                var dateParts = startDate.val().split('-');
                var startDatePart = new Date(dateParts[0],dateParts[1]-1,dateParts[2]);
                var startDateHours = new Date(startDatePart);
                startDateHours.setHours(0, 0, 0, 0);
                var today = new Date();
                today.setHours(0, 0, 0, 0);
                if(startDateHours > today){
                    var setMinDate = new Date();
                } else {
                    var setMinDate = startDate.val();
                }
            } else{
                var setMinDate = new Date();
            }

            startDate.datetimepicker({
                format:'YYYY-MM-DD',
                minDate:setMinDate,
                //minDate: new Date()
                useCurrent: false,
            }).on("keydown", function(e){
                if (e.which == 13) {
                    $('#search-button').trigger('click');
                }
            });
            endDate.datetimepicker({
                format:'YYYY-MM-DD',
                minDate: moment().startOf('d')
                //useCurrent: false,
            }).on("keydown", function(e){
                if (e.which == 13) {
                    $('#search-button').trigger('click');
                }
            });
            startDate.on("dp.change", function (e) {
                endDate.data("DateTimePicker").minDate(e.date);
            });

            $('#filter-order-by').on('change', function() {
                $("#hidden-form-values").submit();
            });

            $('.filters').on('change', function() {
                $("#search-filters").submit();
            });

            $('#search-button').click(function(){
                if( startDate.val() && endDate.val() ){
                    if(endDate.val()<startDate.val()){
                        toastr.error('End date must be greater than start date');
                        return false;
                    }
                }
            });

            // Send Ajax On scroll
            $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() == $(document).height()) {
                    var formData = $('#search-filters').serialize();
                    var offset=$('#offset').val();
                    var test = offset*1 + 4;

                    // $('#limit').val($('#limit').val()*2);
                   // $('#offset').val(( offset*1 + 2));
                    $('#offset').val(test);
                    if(flag==0){
                        $.ajax({
                            type : 'get',
                            url  : "{{route('search.result.ajax')}}",
                            data : formData,
                            dataType : 'JSON',
                            success : function(response){
                                //var obj = JSON.stringify(response);
                                //console.log(response.success);
                                //alert(response.success);
                                if(response.success==100){
                                    $('.newAppendData').append(response.data);
                                } else{
                                    /*$('.right-sidebar').append('<div class="clarfix"></div><div class="col-sm-12">No More Result Found</div>');*/
                                    flag = 1;
                                }


                            },
                        });
                    }
                }
            });

            // On Clicking enter key trigger click event of search buttton
            $('.validate-location').keypress(function(e) {
                var keycode = (e.keyCode ? e.keyCode : e.which);
                if (keycode == '13') { //return false;
                    /*setTimeout(function(){
                        $('#search-button').trigger('click');
                    },50);*/
                }
            });
        });

        $(document).on('click','.properties-with-no-location', function(e) {
            var propertyId = $(this).attr("data-propertyid");
            $(this).prop("href", "{{route('search.result')}}?property_type_id="+propertyId+"&setData=1");
        });
        $(document).on('click','.filters', function(e) {
            $('#offset').val(0);
            $('#setData').val(0);
        });

    </script>
@endsection