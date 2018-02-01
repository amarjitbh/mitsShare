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
                        @if($sellerReviews)
                            <div id="flux" style="overflow:auto;max-height: 250px;">
                                <h3 class="title">Reviews</h3>
                                @foreach($sellerReviews as $key=>$propertyReview)
                                    <div class="sidebar sidebar-widget latest-reviews product-detail-latest-reviews">
                                        <div class="product-detail-latest-reviews-list">
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
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        @else
                            No Review Yet
                        @endif
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
///
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
                            data:{ offset: offset, _token: "{{ csrf_token() }}" },
                            dataType: 'JSON',
                            url:"{{route('review-from-seller')}}",
                            success:function(response){
                                resultLength =  response.length;
                                if(resultLength>0){
                                    $.each(response, function (key, item) {
                                        if(!item.image){
                                            imgUrl = placeHolder+'/'+'avatar-5.png';
                                        }else{
                                            imgUrl = base_url+'/'+item.image;
                                        }
                                        $('#flux').append('<div class="sidebar sidebar-widget latest-reviews product-detail-latest-reviews"><div class="product-detail-latest-reviews-list"><div class="media"><div class="media-left">'+
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
                                                '</div>'+
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

