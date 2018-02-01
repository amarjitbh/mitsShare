@extends('layouts.after_login')

@section('content')

    {{--My Properties Page Start--}}
    <div class="my-propertiess">
        <div class="container">
            <div class="row">
               @include('seller/sidebar')
                <div class="col-lg-9 col-md-9 col-sm-8">
                    <!-- Heading -->
                    @if(session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if(session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}
                        </div>
                    @endif
                    <h1 class="heading">My Properties Listings</h1>
                    <!-- My propertiess box start -->
                    @if(empty($propertyArr))
                        <p>Sorry No Properties Found</p>
                    @endif

                    @if(!empty($propertyArr))
                        @foreach($propertyArr as $property)
                            <div class="my-properties-box wow fadeInUp delay-03s clearfix d-flex row mlr-0 no-flex-sm" style="visibility: visible; animation-name: fadeInUp;">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-pad my-propertie-theme">
                                    @if(isset($property['basic_feature_image']))
                                        @php $jsonImages = json_decode($property['basic_feature_image'], true ); @endphp
                                        @if(!empty($jsonImages) && is_array($jsonImages))
                                        @foreach($jsonImages as $jsonImg)
                                            @if($jsonImg['chk']==1)
                                                @php $url_img = asset(config('constants.IMAGE_FOLDER_NAME').'/'.$jsonImg['image']); @endphp
                                            @endif
                                        @endforeach
                                        @endif
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
                                                <h3 class="location">
                                                    <a href="#" class="truncate-para" title="{{$property['basic_location']}}">
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
                                        <div class="font-12 mb-0 truncate-para description_ckeditor">@if(isset($property['basic_description'])) @php echo html_entity_decode($property['basic_description']) @endphp @else ''@endif</div>
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
                                                <td width="1%" valign="top">
                                                    <div class="listing-meta ">
                                                        <div class="listing-meta wow slideInUp delay-02s" style="visibility: visible; animation-name: slideInUp;" data-wow-offset="0">
                                                            <div class="btn-group btn-group-sm btn-group-action pull-right" role="group" aria-label="btn-group-action">
                                                                <div class="btn-group" role="group">
                                                                    <span>
                                                                        <a class="btn  btn-sm btn-outline-action "
                                                                           href="{{route('property.edit',$property['property_id'])}}?property_type_id={{$property['property_type_id']}}">
                                                                            <i class="fa fa-pencil"></i>Edit
                                                                        </a>
                                                                    </span>
                                                                </div>
                                                            </div>
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
                            {{ $allPropertiesData->links() }}
                </div>
            </div>
        </div>
    </div>
    {{--My Properties Page End--}}
@endsection