@if(empty($propertyArr))
    <div class="col-sm-12">
        <p id="property-not-found"></p>
    </div>
@endif
<?php $row_counter = 1;
$main_counter = 1;
$property_arr_size = sizeof($propertyArr);
//pr($propertyArr);
?>

@if(!empty($propertyArr))
    @foreach($propertyArr as $property)
        {{-- Display as List start--}}
        @if((isset($display))&& ($display == "list"))
            <div  class="listing-properties-box wow fadeInUp delay-03s row  d-flex row mlr-0 no-flex-sm" style="visibility: visible; animation-name: fadeInUp;">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 listing-propertie-theme">
                    <!-- Tag -->
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
                <div >
                    @endif
                    <div class="col-lg-6 col-md-6 col-sm-6 wow fadeInUp delay-03s" >
                        <div class="thumbnail recent-properties-box">
                            @if(isset($property['basic_feature_image']))
                                @php $jsonImages = json_decode($property['basic_feature_image'], true ); @endphp
                                @foreach($jsonImages as $jsonImg)
                                    @if($jsonImg['chk']==1)
                                        @php $url_img = asset(config('constants.IMAGE_FOLDER_NAME').'/'.$jsonImg['image']); @endphp
                                    @endif
                                @endforeach
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


