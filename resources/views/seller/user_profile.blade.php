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
                        <h1>{{$userInformation['first_name']}} {{$userInformation['last_name']}}</h1>
                        @foreach($userInformation as $key=>$value)
                            @if($key=='user_reviews')
                                <div class="sidebar sidebar-widget latest-reviews product-detail-latest-reviews">
                                    <h3 class="title">Reviews</h3>
                                    <div id="flux" class="product-detail-latest-reviews-list">
                                        @foreach( $userInformation['user_reviews'] as $propertyReview )
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
                    </div>
                    <!-- My address end -->
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <div class="edit-profile-photo">
                        <?php
                        $image=$userInformation['image'];
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
            var userId = {{$userInformation['id']}}
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

