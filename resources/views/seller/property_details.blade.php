@extends('layouts.after_login')
@section('content')
    {{--Property Detail Page Start--}}
    <div class="properties-details-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="properties-details-section">
                        <!-- Header -->
                        <div class="heading-properties clearfix">
                            @foreach($section_array as $key=>$section_arr)
                                @foreach($section_arr['fields'] as $key=>$sections)
                                    @php $propertyOwner = $sections['owner_id']; @endphp
                                    <div id="{{$sections['field_identifier']}}" class="pull-left">
                                        @if($sections['field_identifier']==='basic_name')
                                            <h3>{{$sections['field_value']}}</h3>
                                            @php $propertyName = $sections['field_value']; @endphp
                                        @endif
                                        @if($sections['field_identifier']==='basic_location')
                                            <p id="{{$sections['field_identifier']}}">{{$sections['field_value']}}</p>
                                                @php $propertyLocation = $sections['field_value']; @endphp
                                        @endif
                                    </div>
                                    <div class="@if($sections['field_identifier']==='basic_price') pull-right @endif">
                                        @if($sections['field_identifier']==='basic_price')
                                           <h3>$ {{$sections['field_value']}}<br> <span class="small text-black font-14">Per day</span></h3>
                                            @php $price = $sections['field_value'] @endphp
                                        @endif
                                    </div>
                                    @if($sections['field_identifier']==='basic_feature_image')
                                        @php $jsonImages = json_decode($sections['field_value'], true ); @endphp
                                        @foreach($jsonImages as $jsonImg)
                                            @if($jsonImg['chk']==1)
                                                @php $slider_image = asset(config('constants.IMAGE_FOLDER_NAME').'/'.$jsonImg['image']); @endphp
                                                @php $url_img = asset(config('constants.IMAGE_FOLDER_NAME').'/'.$jsonImg['image']); @endphp
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                        <!-- Properties detail slider start -->
                        <div class="properties-detail-slider simple-slider mrg-btm-40 ">
                            <div id="carousel-custom" class="carousel slide" data-ride="carousel">
                                <div class="carousel-outer">
                                    <div class="carousel-inner">
                                        <?php
                                        if(!isset($jsonImages)){?>
                                        <div class="item active">
                                            <img src="@if(isset($url_img)) {{$url_img}} @else {{asset('img/placeholder/placeholder-product.jpg')}} @endif" class="thumb-preview" alt="Property Image">
                                        </div><?php
                                        }?>

                                        <?php
                                        $i = 0;
                                        if(isset($jsonImages)){
                                        foreach($jsonImages as $key => $carousel){?>
                                        <div class="item <?php if($i === 0){ echo 'active'; } ?>">
                                            <?php
                                            $img =  asset(config('constants.IMAGE_FOLDER_NAME').'/'.$carousel['image']);
                                            ?>
                                            <img src="<?php echo $img; ?>" alt="Chevrolet Impala">
                                        </div><?php
                                        $i++;
                                        }
                                        }
                                        ?>
                                    </div>
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
                        <!-- Properties detail slider end -->

                        <!-- Specifications start -->
                        <div class="sidebar specifications mrg-btm-30 clearfix hidden-lg hidden-md">
                            <div class="section-heading">
                                <div class="media">
                                    <div class="media-left">
                                        <i class="flaticon-apartment"></i>
                                    </div>
                                    <div class="media-body">
                                        <h4>Real Specifications</h4>
                                        <p>Check the Real specifications</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Reviews Box -->
                            <div class="reviews-box clearfix">
                                <ul class="reviews-star-list">
                                    <li>
                                        <i class="fa fa-star"></i>
                                    </li>
                                    <li>
                                        <i class="fa fa-star"></i>
                                    </li>
                                    <li>
                                        <i class="fa fa-star"></i>
                                    </li>
                                    <li>
                                        <i class="fa fa-star"></i>
                                    </li>
                                    <li>
                                        <i class="fa fa-star-o"></i>
                                    </li>
                                </ul>
                                <div class="reviews">156 reviews</div>
                                <a href="javascript:void(0);" class="add-review" data-toggle="modal" data-target="#modal-review">
                                    <i class="fa fa-plus-circle"></i>Add Review
                                </a>
                            </div>
                        </div>
                         @php $checked = "";  @endphp
                         @php $fieldsArray = getSingleLable($section_array);  @endphp

                         @foreach($section_array as $key=>$section_arry)
                         @php $checked = "";  
                         @endphp

                            <div class="properties-condition mrg-btm-20">
                                <h3 class="heading">{{$section_arry['section_name']}} </h3>
                                <div class="row">
                                        @foreach($section_arry['fields'] as $value)
                                            @if($value['field_identifier']=='basic_description')
                                                <div class="col-sm-12">
                                                    @php echo html_entity_decode($value['field_value']); @endphp</p>
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
                                                                <li>   <span class="font-600">{{$value['field_name']}} :</span><br>
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
                                                                <span class="font-600">{{$value['field_name']}} :</span><br>

                                                                @if(isset($value['field_value']))
                                                                    @if($value['field_value'])
                                                                        {{$value['field_value']}}
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </li>
                                                             
                                                            @else
                                                        @if($value['input_field_type_id']==3  )
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
                                                                <li> <span class="font-600 details_value">{{$value['field_name']}} :</span><br>
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
                    @if(isset($propertyReviews))
                        <div class="sidebar test sidebar-widget latest-reviews product-detail-latest-reviews">
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
                                                <p class="small font-12 mb-5">by <span class="text-black">{{$propertyReview['first_name']}}  {{$propertyReview['last_name']}}</span> on <span class="text-black"> {{ dateFormat($propertyReview['created_at']) }}</span></p>
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
                    @endif
                </div>
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="sidebar right">
                        <!-- Specifications start -->
                        <div class="sidebar sidebar-widget specifications clearfix hidden-xs hidden-sm">
                            <div class="section-heading">
                                <div class="media">
                                    <div class="media-body">
                                        <h4>$ @php echo $price @endphp</h4>
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
                                    <i class="fa fa-star fa-star-o"></i><i class="fa fa-star fa-star-o"></i><i class="fa fa-star fa-star-o"></i><i class="fa fa-star fa-star-o"></i><i class="fa fa-star fa-star-o"></i> 0 Review
                                @endif

                                @if($commentType==1 || $commentType==2 )
                                    @if( getServerUtcTime() > $endDateOfBooking['date'])
                                        @if(isset($displayAddReview) && $displayAddReview==1)
                                            <a href="javascript:void(0);" class="add-review" data-toggle="modal" data-target="#modal-review">
                                                <i class="fa fa-plus-circle"></i>Add Review
                                            </a>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div id="seller-property-data" class="properties-detail-slider simple-slider">
                            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                <div class="carousel-outer">
                                    <!-- Wrapper for slides -->
                                    <div id="seller-property-data" class="carousel-inner">
                                        <div class="item active sidebar-feature-prop-slider" style="background-image: url('@if(isset($slider_image)) {{$slider_image}} @else {{asset('img/placeholder/placeholder-product.jpg')}} @endif')">
                                            {{--<img src="@if(isset($slider_image)) {{$slider_image}} @else {{asset('img/placeholder/placeholder-product.jpg')}} @endif" class="img-preview" alt="Property Image">--}}
                                        </div>
                                    </div>
                                    <!-- Controls -->
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
                            <div class="recent-properties-box">
                                <div class="caption detail">
                                    <!-- Header -->
                                    <header class="clearfix">
                                        <div class="pull-left">
                                            <h1 class="title">
                                                <a href="{{route('seller-property-detail')}}?property_id={{$propertyId}}&commentType={{$commentType}}&bookingId={{$bookingId}}"><?php echo $propertyName ?></a>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--Property Detail Page End--}}
    <!-- Review Modal -->
    <div id="modal-review" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content modal-layout-common">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Review this Property</h4>
                </div>
                <div class="modal-body">
                    @include('seller/property/property_review_form')
                </div>
            </div>
        </div>
    </div>

    @include('seller/property/all_reviews_of_property_modal')


@endsection
@section('scripts')
    <script src="{{ asset( 'js/toastr.min.js' ) }}"></script>
    <script src="{{ asset( 'js/jquery.validate.min.js' ) }}"></script>
    <script>
        var commentType;
        var i=0;

        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            $('#review-modal-top').hide();
            commentType = {{$commentType}};
            if( commentType==1 || commentType==2){
                var booking_id = <?php if( isset($bookingId) ) {echo $bookingId;}?>;
            }
            $("#basic_name").append($('#basic_location'));
            $( "#add-property-reviews" ).validate({
                rules: {
                    rating: {
                        required: true
                    },
                    reason_for_rating: {
                        required: true
                    },
                    comments: {
                        required: true,
                        maxlength: 150
                    }
                },
                messages: {
                    rating: {
                        required: "<i class='fa fa-exclamation-circle'></i> Please select rating"
                    },
                    reason_for_rating: {
                        required: "<i class='fa fa-exclamation-circle'></i> Please select reason"
                    },
                    comments: {
                        required: "<i class='fa fa-exclamation-circle'></i> Please enter your comment",
                        maxlength: "<i class='fa fa-exclamation-circle'></i> Comment can not be more than 150 character long",

                    }
                },
                errorElement: 'div',
                errorPlacement: function(error, element) {
                    if(element.parent('.input-group').length) {
                        error.insertAfter(element.parent()).addClass('mt-5 font-12 text-danger d-inline-block');
                    }
                    else if(element.closest('.bootstrap-select').length) {
                        error.insertAfter(element.closest('.bootstrap-select')).addClass('mt-5 font-12 text-danger d-block');
                    }
                    else {
                        error.insertAfter(element).addClass('error mt-5 font-12 text-danger d-block');
                    }
                },
                submitHandler: function(form) {
                    var propertyid = {{$propertyId}};
                    var reason = $("#select-rating-reason option:selected").val();
                    var comments = $('#comments').val();
                    var rating = $('input[name=rating]:checked', '#add-property-reviews').val()
                    toastr.options.onHidden = function() {
                        window.location = 'seller-property-detail?property_id={{$propertyId}}&commentType={{$commentType}}&bookingId={{$bookingId}}';
                    }
                    $.ajax({
                        type:'POST',
                        data:{ propertyid : propertyid, reason_for_rating:reason,comments:comments, rating: rating, commentType: commentType, booking_id: booking_id, _token: "{{ csrf_token() }}" },
                        dataType: 'JSON',
                        url:"{{route('save-property-reviews')}}",
                        success:function(response){
                            if(response.success){
                                toastr.success('Review is submitted successfully', 'Congratulation', {timeOut: 1000})
                            }
                            else{
                                toastr.error('Something Went Wrong.', 'Sorry!')
                            }
                        },
                        error: function(xhr) {
                            $(".help-block").hide();
                            $.each(xhr.responseJSON, function(i, obj) {
                                $('input[name="'+i+'"]').closest('.form-group').addClass('has-error');
                                $('input[name="'+i+'"]').closest('.form-group').find('label.help-block').slideDown(400).html(obj);
                                $('textarea[name="'+i+'"]').closest('.form-group').addClass('has-error');
                                $('textarea[name="'+i+'"]').closest('.form-group').find('label.help-block').slideDown(400).html(obj);
                                if( i=='reason_for_rating' ){
                                    $('.reason_for_rating').addClass('has-error');
                                    $('.reason_for_rating' ).find('label.help-block').slideDown(400).html(obj);
                                }
                                if( i=='rating' ){
                                    $('.rating').addClass('has-error');
                                    $('.rating' ).find('label.help-block').slideDown(400).html(obj);
                                }

                            });
                        }
                    });
                }
            });

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
                    },
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