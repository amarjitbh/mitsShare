@extends('layouts.after_login')

@section('content')

    {{--My Profile Page Start--}}
    <div class="my-profile">
        <div class="container">
            <div class="row">
                @include('seller/sidebar')
                <div class="col-lg-6 col-md-6 col-sm-5">
                    <!-- My address start-->
                    <div class="my-address">
                        <h1>{{$buyerUserInformation['first_name']}} {{$buyerUserInformation['last_name']}}</h1>
                        @foreach($sellerUserInformation as $key=>$value)
                            @if($key=='user_reviews')
                                <div class="sidebar sidebar-widget latest-reviews product-detail-latest-reviews">
                                    <h3 class="title">Reviews As a Seller</h3>
                                    <div id="flux" class="product-detail-latest-reviews-list">
                                        @foreach( $sellerUserInformation['user_reviews'] as $propertyReview )
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
                                                    <p class="small font-12 mb-5">by <span class="text-black">{{$propertyReview['first_name']}} {{$propertyReview['last_name']}}</span> on <span class="text-black"> {{ dateFormat($propertyReview['created_at']) }}</span></p>
                                                    <p>{{$propertyReview['comments']}}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        @foreach($buyerUserInformation as $key=>$value)
                            @if($key=='user_reviews')
                                <div class="sidebar sidebar-widget latest-reviews product-detail-latest-reviews">
                                    <h3 class="title">Reviews As a Buyer</h3>
                                    <div id="flux" class="product-detail-latest-reviews-list">
                                        @foreach( $buyerUserInformation['user_reviews'] as $propertyReview )
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
                                                    <p class="small font-12 mb-5">by <span class="text-black">{{$propertyReview['first_name']}} {{$propertyReview['last_name']}}</span> on <span class="text-black"> {{ dateFormat($propertyReview['created_at']) }}</span></p>
                                                    <p>{{$propertyReview['comments']}}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach


                          @if(!empty($propertyArr))
                        @foreach($propertyArr as $property)
                            <div class="my-properties-box wow fadeInUp delay-03s clearfix d-flex row mlr-0 no-flex-sm" style="visibility: visible; animation-name: fadeInUp;">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-pad my-propertie-theme">
                                    @if(isset($property['basic_feature_image']))
                                        @php $jsonImages = json_decode($property['basic_feature_image'], true ); @endphp
                                        @foreach($jsonImages as $jsonImg)
                                            @if($jsonImg['chk']==1)
                                                @php $url_img = asset(config('constants.IMAGE_FOLDER_NAME').'/'.$jsonImg['image']); @endphp
                                            @endif
                                        @endforeach
                                        <a href="{{route('seller-property-detail')}}?property_id={{$property['property_id']}}&commentType=3&bookingId=-1">
                                            <div class="product-image-list-container" style="background-image: url('@if(isset($url_img)) {{$url_img}} @endif')"></div>
                                        </a>
                                    @else
                                        <a href="{{route('seller-property-detail')}}?property_id={{$property['property_id']}}&commentType=3&bookingId=-1">
                                            <div class="product-image-list-container" style="background-image: url('{{URL::asset('img/placeholder/placeholder-product.jpg')}}')"></div>
                                        </a>
                                    @endif
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 col-pad more-info">
                                    <div class="detail">
                                        <!-- Header -->
                                        <header class="clearfix">
                                            <div class="pull-left mb-15">
                                                <h1 class="title">
                                                    <a href="{{route('seller-property-detail')}}?property_id={{$property['property_id']}}&commentType=3&bookingId=-1">{{$property['basic_name']}}</a>
                                                </h1>
                                                <h3 class="location" title="{{$property['basic_location']}}">
                                                    <a href="#" class="truncate-para">
                                                        <i class="fa fa-map-marker"></i>{{$property['basic_location']}}
                                                    </a>
                                                </h3>
                                            </div>
                                            <!-- Btn -->
                                            <div class="pull-right">
                                                <a href="{{route('seller-property-detail')}}?property_id={{$property['property_id']}}&commentType=3&bookingId=-1" class="button-sm button-theme">Details</a>
                                            </div>
                                        </header>
                                        <hr class="mt-0">
                                        <div class="font-12 mb-0 truncate-para description_ckeditor"> @if(isset($property['basic_description'])) @php echo html_entity_decode($property['basic_description']) @endphp @else ''@endif</div>
                                    </div>
                                    <!-- footer -->
                                    <div class="footer clearfix">
                                        <table>
                                            <tr>
                                                <td width="1%" valign="top">
                                                    <div class="wow slideInUp delay-02s" style="visibility: visible; animation-name: slideInUp;" data-wow-offset="0">
                                                        <div class="text-muted font-11">Price</div>
                                                        <div class="price">
                                                            ${{$property['basic_price']}} / Day
                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="1%" valign="top">
                                                    <div class="wow slideInUp delay-02s" style="visibility: visible; animation-name: slideInUp;" data-wow-offset="0">
                                                        <div class="text-muted font-11">Posted on</div>
                                                        <div class="date">
                                                            @php
                                                            echo date('M d, Y', strtotime($property['created_at']));
                                                            @endphp
                                                        </div>
                                                    </div>
                                                </td>
                                               
                                            </tr>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            {!! $allPropertiesData->appends(\Input::except('page'))->render() !!}
                            

                    </div>
                    <!-- My address end -->
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <div class="edit-profile-photo">
                        <?php
                        $image=$buyerUserInformation['image'];
                        if( $image==null ) {
                            $url_img_placeholder = asset(config('constants.IMAGE_ASSET_FOLDER_NAME').'/'.'placeholder/placeholder-person.jpg');
                        } else {
                            $url_img = asset(config('constants.IMAGE_FOLDER_NAME').'/'.$image);
                        }
                        ?>
                        <div class="user-profile-image">
                            <img width="150" height="150" src="{{($image==null)? $url_img_placeholder:$url_img }}" class="img-responsive preview" alt="User Image"/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{--My Profile Page End--}}

@endsection
@section('scripts')

    <script>
        var i=0;
        var j=0;
        var offset;
        var page;
        $(document).ready( function(){
            var userId = {{$buyerUserInformation['id']}}
            var base_url = "{{asset('/images/')}}";
            var placeHolder = "{{asset('/img/placeholder')}}";
            var imgUrl;
            var flag=0;
            var resultLength;
            $('#flux').bind('scroll', function() {
                if($(this).scrollTop() + $(this).innerHeight()>=$(this)[0].scrollHeight) {
                    offset = i+=4;
                    page = j+=1;
                    if(flag==0){
                        $.ajax({
                            type:'get',
                            data:{ buyerId : userId, offset: offset, page:page, _token: "{{ csrf_token() }}" },
                            dataType: 'JSON',
                            url:"{{route('buyer.detail')}}",
                            success:function(response){
                                resultLength =  response.user_reviews.length;
                                if(resultLength>0){
                                    $.each(response.user_reviews, function (key, item) {
                                        if(!item.image){
                                            imgUrl = placeHolder+'/'+'avatar-5.png';
                                        }else{
                                            imgUrl = base_url+'/'+item.image;
                                        }
                                        $('#flux').append('<div class="media"><div class="media-left">'+
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
                                                '<p class="small font-12 mb-5">by <span class="text-black">'+item.first_name+' '+item.last_name+'</span>On<span class="text-black">'+item.created_at+'</span></p>'+
                                                '<p id="commentsModal">'+item.comments+'</p>'+
                                                '</div>'+
                                                '</div>');


                                    });
                                }else{
                                    $('#flux').append('No More Result Found')
                                    flag = 1;
                                }

                            },
                        });
                    }

                }
            });

        });
    </script>
@endsection

