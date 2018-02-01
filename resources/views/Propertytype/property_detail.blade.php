@extends('layouts.before_login_seller')
@section('content')
    {{--Property Detail Page Start--}}
    @php $propertyOwner = ''; @endphp
    <div class="properties-details-page">
        <div class="container">
            <div class="row">
                @php $price = 0;  @endphp
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="properties-details-section">
                        <!-- Header -->
                        <div class="heading-properties clearfix">
                            @foreach($section_array as $key=>$section_arr)
                                @foreach($section_arr['fields'] as $key2=>$sections)
                                    <div id="{{$sections['field_identifier']}}" class="pull-left">
                                        @php $propertyOwner = $sections['owner_id']; @endphp
                                        @if($sections['field_identifier']==='basic_name')
                                            <h3>{{$sections['field_value']}}</h3>
                                            @php $approved_checked = $sections['is_approved_checked'];
                                                $propertyName = $sections['field_value'];
                                            @endphp
                                        @endif
                                        @if($sections['field_identifier']==='basic_location')
                                            <p id="{{$sections['field_identifier']}}">{{$sections['field_value']}}</p>
                                            @php $propertyLocation = $sections['field_value']; @endphp
                                        @endif
                                    </div>
                                    <div class="@if($sections['field_identifier']==='basic_price') pull-right @endif">
                                        @if($sections['field_identifier']==='basic_price')
                                                <h3 style="line-height: 0.9;" class="text-right">$ {{$sections['field_value']}}<br> <span class="small text-black font-14">Per day</span></h3>
                                            @php $price = $sections['field_value'] @endphp
                                        @endif
                                    </div>
                                        @if($sections['field_identifier']==='basic_feature_image')
                                            @php $jsonImages = json_decode($sections['field_value'], true ); @endphp
                                          @if(!empty($jsonImages) && is_array($jsonImages))
                                            @foreach($jsonImages as $jsonImg)
                                                @if($jsonImg['chk']==1)
                                                    @php
                                                    $slider_image = asset(config('constants.IMAGE_FOLDER_NAME').'/'.$jsonImg['image']);
                                                    $url_img = asset(config('constants.IMAGE_FOLDER_NAME').'/'.$jsonImg['image']); @endphp
                                                @endif
                                            @endforeach
                                        @endif

                                        @endif
                                @endforeach
                            @endforeach
                        </div>
                        <div class="properties-detail-slider simple-slider mrg-btm-40 ">
                            <div id="carousel-custom" class="carousel slide" data-ride="carousel">
                                <div class="carousel-outer">

                                    <div class="carousel-inner">
                                        <?php
                                        if(!isset($jsonImages)){?>
                                        <div class="item active">
                                            <a href="@if(isset($url_img)) {{$url_img}} @else {{asset('img/placeholder/placeholder-product.jpg')}} @endif">
                                                <img src="@if(isset($url_img)) {{$url_img}} @else {{asset('img/placeholder/placeholder-product.jpg')}} @endif" class="" alt="Property Image">
                                            </a>
                                        </div><?php
                                        }?>

                                        <?php
                                         $i = 0;
                                            if(isset($jsonImages)){
                                                foreach($jsonImages as $key => $carousel){?>
                                                <div class="item <?php if($i === 0){ echo 'active'; } ?>">
                                                    <?php
                                                    $img = asset(config('constants.IMAGE_FOLDER_NAME').'/'.$carousel['image']);
                                                    ?>
                                                        <a href="<?php echo $img; ?>">
                                                    <img src="<?php echo $img; ?>" class="" alt="Chevrolet Impala">
                                                        </a>
                                                </div><?php
                                                $i++;
                                                }
                                            }
                                         ?>

                                    </div>
                                    <!-- Controls -->
                                    @if(isset($jsonImages))
                                        <a class="left carousel-control" href="#carousel-custom" role="button" data-slide="prev">
                                        <span class="slider-mover-left no-bg" aria-hidden="true">
                                            <img src="img/chevron-left.png" alt="chevron-left">
                                        </span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="right carousel-control" href="#carousel-custom" role="button" data-slide="next">
                                        <span class="slider-mover-right no-bg" aria-hidden="true">
                                            <img src="img/chevron-right.png" alt="chevron-right">
                                        </span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    @endif
                                </div>
                                <?php
                                if(isset($jsonImages)){?>
                                <ol class="carousel-indicators thumbs visible-lg visible-md">
                                        <?php
                                        foreach($jsonImages as $key => $ImgIcons){
                                        $icon =  asset(config('constants.IMAGE_FOLDER_NAME').'/'.$ImgIcons['image']); ?>
                                        <li data-target="#carousel-custom" data-slide-to="<?php echo $key;?>" class="">
                                            <div>
                                                <img src="<?php echo $icon; ?>" alt="Chevrolet Impala">
                                            </div>
                                        </li><?php
                                        }?>
                                </ol><?php
                                }?>

                            </div>
                        </div>
                          @php $checked = "";  @endphp
                         @php $fieldsArray = getSingleLable($section_array);  @endphp


                        @foreach($section_array as $key=>$section_arr)
                         @php $checked = "";  @endphp
                                <div class="properties-condition mrg-btm-20">
                                    <h3 class="heading">{{$section_arr['section_name']}}</h3>
                                    <div class="row">

                          @foreach($section_arr['fields'] as $value)



                                            @if($value['field_identifier']=='basic_description')
                                                <div class="col-sm-12">
                                                  <p>@php echo html_entity_decode($value['field_value']); @endphp</p>
                                                </div>
                                            @endif
                                            @if(!$value['field_identifier'])
                                             @if($value['is_option']==1 )

                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                @elseif($value['input_field_type_id']==13)
                                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                                 @elseif($value['input_field_type_id']==12)
                                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                                @else
                                                 <div class="col-md-4 col-sm-4 col-xs-12">
                                             @endif
                                                    <ul class="condition">
                                                        @if($value['input_field_type_id']==12)
                                                            @php
                                                                $info = new SplFileInfo($value['field_value']);
                                                                $fileExtension = $info->getExtension();
                                                            @endphp
                                                            @if($fileExtension=='pdf' || $fileExtension=='txt')
                                                          <li>      <span class="font-600">{{$value['field_name']}} :</span></br>
                                                                @php $fileName = asset(config('constants.IMAGE_FOLDER_NAME').'/'.$value['field_value']); @endphp
                                                                <a data-toggle="tooltip" data-title="Download attachment" data-placement="bottom" data-trigger="hover" href="<?php echo $fileName;?>" download><span class="fa fa-download"></span></a>
                                                          </li>
                                                            @else
                                                                <li>
                                                                  <span class="list-item-with-img ">
                                                                     <span class="font-600 image-preview-list-view-link">{{$value['field_name']}} :
                                                                    @php $img = asset(config('constants.IMAGE_FOLDER_NAME').'/'.'thumb_'.$value['field_value']); @endphp
                                                                    <a  href="<?php echo $img; ?>" >
                                                                       <span class="image-preview-list-view" style="background-image:url('<?php echo $img; ?>')"></span>
                                                                    <img src="<?php echo $img; ?>" class="hide">
                                                                    </a>
                                                                    </span>
                                                                </span>
                                                                </li>
                                                            @endif
                                                        @else
                                                            @if($value['is_option']==0)

                                                                <li>
                                                                @if(isset($value['field_value']))
                                                                <span class="font-600 details_value">{{$value['field_name']}} :</span><br>
                                                                @if($value['field_value'])
                                                                    {{$value['field_value']}}
                                                                @else
                                                                    N/A
                                                                @endif
                                                                </li>
                                                            
                                                            @else
                                                                N/A
                                                            @endif
                                                            <div class="clearfix"> </div>
                                                                     <div class="space"> </div>
                                                        @else
                                                              @if($value['input_field_type_id']==3 )
                                                                    @if($checked== "")
                                                                    @foreach($fieldsArray as $result) 
                                                                    
                                                                    @php $checked="1"; @endphp
                                                                    @if($key==$result['sectionId'] )
                                                                        @if($result['is_option'] == 1 && $result['typeId'] == 3)
                                                                            
                                                                               <span class="font-600 details_value space">{{$result['label_name']}} :</span></br>
                                                                              <div class="row">
                                                                            @foreach($result['values'] as $keyw => $val)
                                                                                @if(isset($display_values[$val]))
                                                                                <div class="col-md-4 details_value col-sm-4 col-xs-12 ">                                                                              
                                                                                    {{$display_values[$val]}}
                                                                                </div>
                                                                                @endif
                                                                             @endforeach
                                                                         </div>
                                                                             <div class="clearfix"> </div>
                                                                        <div class="space"> </div>
                                                                        
                                                                        @endif

                                                                    @endif
                                                                   

                                                                    @endforeach
                                                                    <div class="clearfix"> </div>
                                                                    
                                                                       @endif    
                                                                    @else

                                                                <li><span class="font-600 details_value">{{$value['field_name']}} :</span><br>
                                                                    @if(isset($display_values[$value['field_value']]))
                                                                        @if($value['field_name'])
                                                                            {{$display_values[$value['field_value']]}}
                                                                        @else
                                                                            N/A
                                                                        @endif
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                    <div class="clearfix"> </div>
                                                                    <div class="space"> </div>
                                                                </li>
                                                                 
                                                                @endif
                                                            @endif
                                                        @endif
                                                </ul>
                                            </div>
                                        @endif

                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="">
                        <div class="sidebar sidebar-widget latest-reviews product-detail-latest-reviews">
                            <h3 class="title">Latest Reviews</h3>
                            <div class="product-detail-latest-reviews-list">
                                @if(count($propertyReviews))
                                    @php $i=0; @endphp
                                    @foreach( $propertyReviews as $propertyReview )
                                        <?php if($i==5) break; ?>
                                        <div class="media">
                                            <div class="media-left">
                                                @php $url_img = $propertyReview['image'] ? asset(config('constants.IMAGE_FOLDER_NAME').'/'.$propertyReview['image']) : asset('img/placeholder/avatar-5.png'); @endphp
                                                <a href="javascript:void(0);">
                                                    <img class="media-object" src="{{$url_img}}" alt="Image Placeholder">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h3 class="media-heading"><a href="#">{{$propertyReview['reason_for_rating']}}</a></h3>
                                                <div class="rating mb-5">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa @php echo ($propertyReview['rating'] >= 2)? 'fa-star': 'fa-star-o' @endphp"></i>
                                                    <i class="fa @php echo ($propertyReview['rating'] >= 3)? 'fa-star': 'fa-star-o' @endphp "></i>
                                                    <i class="fa @php echo ($propertyReview['rating'] >= 4)? 'fa-star': 'fa-star-o' @endphp "></i>
                                                    <i class="fa @php echo ($propertyReview['rating'] == 5)? 'fa-star': 'fa-star-o' @endphp "></i>
                                                </div>
                                                <p class="small font-12 mb-5">by <span class="text-black"><a href="{{route('buyer.detail').'?buyerId='.$propertyReview['user_id']}}">{{$propertyReview['first_name'].' '.$propertyReview['last_name']}}</a></span> on <span class="text-black"> {{ dateFormat($propertyReview['created_at']) }}</span></p>
                                                <p>{{$propertyReview['comments']}}
                                                </p>
                                            </div>
                                        </div>
                                        <?php $i++; ?>
                                    @endforeach

                                @else
                                    No Review
                                @endif

                            </div>
                            @if(count($propertyReviews))
                                @if(count($propertyReviews)>5)
                                    <div class="form-group mt-15">
                                        <a id="get-all-reviews" class="all-review-property button-theme button-md btn-block text-center  font-12">
                                            View More Reviews
                                        </a>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="sidebar right">
                        <!-- Specifications start -->
                        <div class="sidebar sidebar-widget specifications clearfix hidden-xs hidden-sm">
                            <div class="section-heading mb-15">
                                <div class="media">

                                    <div class="media-body">
                                        <h4>
                                            $ <input class="form-input-price" value="@php echo $price @endphp" type="text" readonly name="total_amount" id="total-amount" width="1%"/><span class="small d-block text-capitalize text-muted">Total</span>
                                        </h4>

                                    </div>
                                </div>
                            </div>
                            <!-- Reviews Box -->
                            <div class="reviews-box clearfix">
                                @if(count($totalReviewOfBuyer))
                                    @foreach($totalReviewOfBuyer as $value)
                                        @php  $totalRating[] = $value['rating']; @endphp
                                    @endforeach
                                        <ul class="reviews-star-list">
                                            <li>
                                                <i class="fa fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa @php echo (array_sum($totalRating)/count($propertyReviews) >= 2)? 'fa-star': 'fa-star-o' @endphp"></i>
                                            </li>
                                            <li>
                                                <i class="fa @php echo (array_sum($totalRating)/count($propertyReviews) >= 3)? 'fa-star': 'fa-star-o' @endphp"></i>
                                            </li>
                                            <li>
                                                <i class="fa @php echo (array_sum($totalRating)/count($propertyReviews) >= 4)? 'fa-star': 'fa-star-o' @endphp"></i>
                                            </li>
                                            <li>
                                                <i class="fa @php echo (array_sum($totalRating)/count($propertyReviews) == 5)? 'fa-star': 'fa-star-o' @endphp"></i>
                                            </li>
                                        </ul>
                                        <div class="reviews">
                                            @php
                                            echo count($totalReviewOfBuyer)
                                            @endphp reviews
                                        </div>
                                @else
                                    No Review and Rating
                                @endif
                            </div>
                            @php $flag = 0; $userId=0; @endphp
                            @if(Auth::User())
                                @php
                                $flag = 1;
                                $userId = Auth::User()->id; @endphp
                            @endif

                            @if( ($flag == 1) && ($userId==$propertyOwner))
                            @else
                                <form id="booking" method="post">
                                    <div class="form-group">
                                        @if(Session::has('message'))
                                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                                        @endif
                                        <input type="hidden" id="price" value="@php echo $price @endphp "/>
                                        <input type="hidden" id="proertyowner" value="@php echo $propertyOwner @endphp "/>
                                        <input type="hidden" id="approval-required" name="approval_required" value="@php echo $approved_checked @endphp "/>
                                        @if(($checked_requied==1)&&($approvedBooking==1))
                                            <div class="input-group input-group-noaddon input-daterange-1 ">
                                                <input  name="start_date" id="start-date" type="text" class="form-control search-fields" value="@if($startDate != '' ) {{$startDate}} @else '' @endif" placeholder="Start Date"  disabled>
                                                <span class="input-group-addon hide-addon"></span>
                                                <input name="end_date" id="end-date" type="text" class="form-control search-fields" value="@if($endDate != '' ) {{$endDate}} @else '' @endif" placeholder="End Date" >
                                                <input type="hidden" class="days-here">
                                            </div>
                                        @else
                                            <div class="input-group input-group-noaddon input-daterange-1">
                                                <input  name="start_date" id="start-date" type="text" class="form-control search-fields" value="" placeholder="Start Date" autocomplete="off">
                                                <span class="input-group-addon hide-addon"></span>
                                                <input name="end_date" id="end-date" type="text" class="form-control search-fields" value="" placeholder="End Date" autocomplete="off">
                                                <input type="hidden" class="days-here">
                                            </div>
                                        @endif
                                        <label class="help-block"></label>
                                    </div>
                                    @php
                                    Session::put('property_id',  $propertyId );
                                    @endphp
                                    <div class="form-group mt-30">
                                        @if(Auth::check())
                                            @if(($checked_requied==1)&&($approvedBooking==''))
                                                <input type="submit" id="bookproperty" value="Request for booking" class="button-md button-theme btn-block"/>
                                            @elseif(($checked_requied==1)&&($approvedBooking==1))
                                                <input type="hidden" id="approvedBooking" name="approvedBooking" value="{{$approvedBooking}}"/>
                                                <input type="hidden" id="bookingId" name="bookingId" value="{{$bookingId}}"/>

                                                <input type="submit" id="bookproperty" value="Confirm Booking" class="button-md button-theme btn-block"/>
                                            @else
                                                <input type="submit" id="bookproperty" value="Book Now" class="button-md button-theme btn-block"/>
                                            @endif
                                        @else
                                            <input type="button" id="not-login" value="Book Now" class="button-md button-theme btn-block"/>
                                        @endif
                                    </div>
                                </form>
                            @endif
                        </div>
                        <!-- Specification end -->

                        <!-- Display All properties of seller in slider -->
                        <div id="seller-property-data" class="properties-detail-slider simple-slider">
                            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                <div class="carousel-outer">
                                    <!-- Wrapper for slides -->
                                        <div id="seller-property-data" class="carousel-inner">
                                            <div class="item active sidebar-feature-prop-slider" style="background-image: url('@if(isset($slider_image)) {{$slider_image}} @else {{asset('img/placeholder/placeholder-product.jpg')}} @endif')">
                                               {{-- <img src="@if(isset($slider_image)) {{$slider_image}} @else {{asset('img/placeholder/placeholder-product.jpg')}} @endif" class="img-preview" alt="Property Image">--}}
                                            </div>
                                        </div>
                                    <!-- Controls -->
                                    <div class="arrows">
                                        <a id="left-button" data-propertyId="{{$propertyId}}" class="left carousel-control" href="#" role="button" data-slide="prev">
                                        <span class="slider-mover-left no-bg" aria-hidden="true">
                                            <img src="img/chevron-left.png" alt="chevron-left">
                                        </span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a id="right-button" data-propertyId="{{$propertyId}}" class="right carousel-control" href="#" role="button" data-slide="next">
                                        <span class="slider-mover-right no-bg" aria-hidden="true">
                                            <img src="img/chevron-right.png" alt="chevron-right">
                                        </span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="recent-properties-box">
                                <div class="caption detail">
                                    <!-- Header -->
                                    <header class="clearfix">
                                        <div class="pull-left">
                                            <h1 class="title">
                                                <a href="{{route('property.detail')}}?property_id={{$propertyId}}"><?php echo $propertyName ?></a>
                                            </h1>
                                        </div>
                                        <!-- Price -->
                                        <div class="price">
                                            $<?php echo $price; ?>
                                        </div>
                                    </header>
                                    <!-- Location -->
                                    <h3 class="location">
                                        <a href="#">
                                            <i class="fa fa-map-marker"></i> <?php echo $propertyLocation; ?>
                                        </a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!-- Display All properties of seller in slider end -->

                    </div>
                </div>
            </div>

        </div>

    </div>

    {{--Property Detail Page End--}}

    @include('Propertytype/guest_all_reviews_of_property_modal')
@endsection

@section('scripts')
    <script src="{{ asset( 'js/bootbox.min.js' ) }}"></script>
    <script src="{{ asset( 'js/toastr.min.js' ) }}"></script>
    <script src="{{ asset( 'js/jquery.validate.min.js' ) }}"></script>
    <script>
        var i=0;
        var sellerId;
        today = new Date();
        var currentDate=today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            $('#review-modal-top').hide();
            $(window).on('load', function(){
                $('#total-amount').val({{$price}});
            });
            $("#end-date").attr("disabled", true);
            var total_price;
            $("#basic_name").append($('#basic_location'));
            $('#not-login').click(function(){
                window.location = "{{url('/login')}}";
            });
            var useCurrentDynamic;
            var allDates=[];
            var startDate1 = $('.input-daterange-1 #start-date');
            var endDate1 = $('.input-daterange-1 #end-date');
            var available_date=[];
            var dates = <?php echo json_encode($available_dates)?>;
            Object.keys(dates).forEach(function(key) {
                allDates.push(moment(dates[key]).format('YYYY-MM-DD'));
                available_date.push(dates[key]);
            });

            var dateExist = allDates.includes(currentDate); // Check if current date exist in array
            if(dateExist){
                useCurrentDynamic = true; // Can select current date
            }else{
                useCurrentDynamic = false; // Can not select current date
            }
            startDate1.datetimepicker({
                format: 'YYYY-MM-DD',
                minDate: moment().startOf('d'),
                useCurrent: useCurrentDynamic,
                enabledDates:available_date
            }).on("dp.change", function (e) {
                $("#end-date").attr("disabled", false);
                endDate1.data("DateTimePicker").minDate(e.date);
                if(dayDifference()>=1){
                    total_price = dayDifference()*$('#price').val();
                    $('#total-amount').val(total_price);
                }

            });


            endDate1.datetimepicker({
                format:'YYYY-MM-DD',
               // minDate: new Date().setHours(0,0,0,0),
               // minDate:new Date(),
                minDate: moment().startOf('d'),
                //minDate: moment().millisecond(0).second(0).minute(0).hour(0),
                useCurrent: false,//Important! See issue #1075
                enabledDates:available_date,
            }).on("dp.change", function (e) {
               // alert(dayDifference())
                total_price = dayDifference()*$('#price').val();
                $('#total-amount').val(total_price);
            });


            function dayDifference() {
                var start = $("#start-date").val();
                var startD = new Date(start);
                var end = $("#end-date").val();
                var endD = new Date(end);
                //alert("startD--->"+startD)
                //alert("endD--->"+endD)
                var diff = parseInt((endD.getTime()-startD.getTime())/(24*3600*1000));
                if(diff==0){
                    return diff+1;
                }else{
                    return diff;
                }
            }

            $( "#booking" ).validate({
                rules: {
                    start_date: {
                        required: true
                    },
                    end_date: {
                        required: true
                    }
                },
                messages: {
                    start_date: {
                        required: "<i class='fa fa-exclamation-circle'></i> Please select Start Date"
                    },
                    end_date: {
                        required: "<i class='fa fa-exclamation-circle'></i> Please select End Date"
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    if(element.parent('.input-group').length) {
                        error.insertAfter(element.parent()).addClass('mt-5 font-12 text-danger d-inline-block');
                    }
                    else {
                        error.insertAfter(element)
                    }
                },
                submitHandler: function(form) {
                    var start = startDate1.data("DateTimePicker").date();
                    var endDate = endDate1.data("DateTimePicker").date();
                    var errorMsgDiv = $('.toast-error').length;
                    if(start>endDate){
                        if(errorMsgDiv==0) {
                            toastr.error('End date must be greater than start date');
                        }
                        return false;
                    }

                    var  between = [];
                    var currentDate = new Date(start);
                    while (currentDate <= endDate) {
                        var dd = currentDate.getDate();
                        if(dd<10){dd='0'+dd}
                        between.push(currentDate.getFullYear()+'-'+(currentDate.getMonth()+1)+'-'+dd);
                        currentDate.setDate(currentDate.getDate() + 1);
                    }

                    toastr.options.onHidden = function() {
                        window.location = 'property-detail?property_id={{$propertyId}}';
                    }
                    $.ajax({
                        type:'POST',
                        data:{"bookFor":between, "start_date":$('#start-date').val(),"end_date":$('#end-date').val(),"total_amount":$('#total-amount').val(), "property_id":{{$propertyId}}, "ownerID": $('#proertyowner').val(), "approvedBooking": $('#approvedBooking').val(), "bookingId": $('#bookingId').val(), "approval_required": $('#approval-required').val(),  "_token": "{{ csrf_token() }}"},
                        dataType: 'JSON',
                        url:"{{route('book.property')}}",
                        success:function(response){
                          if(response.is_approved==1){
                             if(response.success){
                                toastr.success('Your booking request sent successfully.', 'Congratulation', {timeOut: 1500})
                            }
                            else{
                                toastr.error(response.message, 'Sorry!' )
                            }
                          }
                          else{

                            if(response.success){
                                toastr.success('Your booking is done successfully.', 'Congratulation', {timeOut: 1500})
                            }
                            else{
                                toastr.error(response.message, 'Sorry!' )
                            }
                        }
                        },
                        error: function(response){
                            if( response.status === 422 ) {
                                $errors = response.responseJSON;
                                $.each( $errors, function( key, value ) {
                                    $( '[name='+key+']' ).closest( '.form-group').addClass('has-error').find('label.help-block').html(value);
                                });
                            }
                        }
                    });
                }
            });

            /*Rewview Section nicescroll init*/
            var latestReview = $(".product-detail-latest-reviews-list")
            latestReview.niceScroll({
                zindex: 99,
                mousescrollstep: 3
            }).onscrollstart = function (data) {
                console.log(data.end, this)
                if (data.end.y <= 0) {
                    // at top
                    //console.log('top', this);
                    latestReview.parent().find('h3.title').removeClass('add-review-list-title-boxshadow');
                } else {
                    latestReview.parent().find('h3.title').addClass('add-review-list-title-boxshadow');
                }
            };

            $('.carousel-inner .item a, .list-item-with-img a').magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                closeBtnInside: false,
                fixedContentPos: true,
                mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
                image: {
                    verticalFit: true
                },
                zoom: {
                    enabled: true,
                    duration: 300 // don't foget to change the duration also in CSS
                }
            });


            // Get All Review

            $(document).on('click', '#get-all-reviews', function(event) {
                event.preventDefault();
                var propertyId = {{$propertyId}};
                var base_url = "{{asset('/images/')}}";
                var placeHolder = "{{asset('/img/placeholder')}}";
                var imgUrl;
                $.ajax({
                    type:'get',
                    data:{ propertyId : propertyId, _token: "{{ csrf_token() }}" },
                    dataType: 'JSON',
                    url:"{{route('all-reviews-of-property')}}",
                    success:function(response){
                        $('#ajax-reviews').empty();
                        $.each(response, function (key, item) {
                            if(!item.image){
                                imgUrl = placeHolder+'/'+'avatar-5.png';
                            }else{
                                imgUrl = base_url+'/'+item.image;
                            }
                            $('#ajax-reviews').append('<div class="media"><div class="media-left">'+
                                    '<a href="javascript:void(0);">'+
                                    '<img class="media-object" src="'+imgUrl+'" alt="Image">'+
                                    '</a></div>'+
                                    '<div class="media-body">'+
                                    '<h3 id="reason_for_rating" class="media-heading"><a href="#">'+item.reason_for_rating+'</a></h3>'+
                                    '<div class="rating mb-5">'+
                                    '<i class="fa fa-star"></i>'+
                                    '<i class="fa '+
                                    (item.rating>= 2 ? 'fa-star': ' fa-star-o')+
                                    '"></i>'+
                                    '<i class="fa '+
                                    (item.rating>= 3 ? 'fa-star': ' fa-star-o')+
                                    '"></i>'+
                                    '<i class="fa '+
                                    (item.rating>= 4 ? 'fa-star': ' fa-star-o')+
                                    '"></i>'+
                                    '<i class="fa '+
                                    (item.rating== 5 ? 'fa-star': ' fa-star-o')+
                                    '"></i>'+
                                    '</div>'+
                                    '<p class="small font-12 mb-5">by <span class="text-black">'+item.first_name+' '+item.last_name+'</span> on <span class="text-black">'+item.created_at+'</span></p>'+
                                    '<p id="commentsModal">'+item.comments+'</p>'+
                                    '</div>'+
                                    '</div>');
                        });
                        $('#review-modal-top').show();
                        $('#reviewModal').modal('show');

                    },
                });
            });

            $(document).on('click', '#close-modal', function() {
                $('#review-modal-top').hide();
            });

            $(document).on('click', '#load-more', function() {
                var propertyId = {{$propertyId}};
                var base_url = "{{asset('/images/')}}";
                var placeHolder = "{{asset('/img/placeholder')}}";
                var imgUrl;
                offset = i+=2;
                $.ajax({
                    type:'get',
                    data:{ propertyId : propertyId, offset: offset, _token: "{{ csrf_token() }}" },
                    dataType: 'JSON',
                    url:"{{route('all-reviews-of-property')}}",
                    success:function(response){
                        $.each(response, function (key, item) {
                            if(!item.image){
                                imgUrl = placeHolder+'/'+'avatar-5.png';
                            }else{
                                imgUrl = base_url+'/'+item.image;
                            }
                            $('#ajax-reviews').append('<div class="media"><div class="media-left">'+
                                    '<a href="javascript:void(0);">'+
                                    '<img class="media-object" src="'+imgUrl+'" alt="Image Placeholder">'+
                                    '</a></div>'+
                                    '<div class="media-body">'+
                                    '<h3 id="reason_for_rating" class="media-heading"><a href="#">'+item.reason_for_rating+'</a></h3>'+
                                    '<div class="rating mb-5">'+
                                    '<i class="fa fa-star"></i>'+
                                    '<i class="fa '+
                                    (item.rating>= 2 ? 'fa-star': ' fa-star-o')+
                                    '"></i>'+
                                    '<i class="fa '+
                                    (item.rating>= 3 ? 'fa-star': ' fa-star-o')+
                                    '"></i>'+
                                    '<i class="fa '+
                                    (item.rating>= 4 ? 'fa-star': ' fa-star-o')+
                                    '"></i>'+
                                    '<i class="fa '+
                                    (item.rating== 5 ? 'fa-star': ' fa-star-o')+
                                    '"></i>'+
                                    '</div>'+
                                    '<p class="small font-12 mb-5">by <span class="text-black">'+item.first_name+' '+item.last_name+'</span>On<span class="text-black">'+item.created_at+'</span></p>'+
                                    '<p id="commentsModal">'+item.comments+'</p>'+
                                    '</div>'+
                                    '</div>');
                        });
                        $('#reviewModal').modal('show');
                        if(response.length==0){
                            $('#load-more').hide();
                        }
                    }
                });
            })


            // Right Button Click
            $(document).on('click','#right-button', function(event) {
                event.preventDefault();
                var sellerId ={{$propertyOwner}};
                var propertyId = $(this).attr('data-propertyid');
                $.ajax({
                    type:'get',
                    data:{ sellerId : sellerId, button: 'next', propertyId: propertyId, _token: "{{ csrf_token() }}" },
                    dataType: 'json',
                    url:"{{route('seller-properties-at-detail-page')}}",
                    success:function(response){
                        if(response.success==100){
                            $('#seller-property-data').html(' ');
                            $('#seller-property-data').html(response.data)
                        }

                    },
                });
            });

            // Left Button Click
            $(document).on('click','#left-button', function(event) {
                event.preventDefault();
                var sellerId ={{$propertyOwner}};
                var propertyId = $(this).attr('data-propertyid');
                $.ajax({
                    type:'get',
                    data:{ sellerId : sellerId, button: 'previous', propertyId: propertyId, _token: "{{ csrf_token() }}" },
                    dataType: 'json',
                    url:"{{route('seller-properties-at-detail-page')}}",
                    success:function(response){
                        if(response.success==100){
                            $('#seller-property-data').html(' ');
                            $('#seller-property-data').html(response.data)
                        }

                    },
                });
            });
        });
    </script>
@endsection