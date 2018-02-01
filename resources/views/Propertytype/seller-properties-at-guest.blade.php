<div id="seller-property-data"  class="properties-detail-slider simple-slider">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-outer">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                @if(count($properties))
                    @php $jsonImages = json_decode($properties['basic_feature_image'], true ); @endphp
                    @if(!empty($jsonImages) && is_array($jsonImages))
                        @foreach($jsonImages as $jsonImg)
                            @if($jsonImg['chk']==1)
                                @php $url_img = asset(config('constants.IMAGE_FOLDER_NAME').'/'.$jsonImg['image']); @endphp
                            @endif
                        @endforeach
                    @endif

                @endif
                    <div class="item active sidebar-feature-prop-slider" style="background-image: url('@if(isset($url_img)) {{$url_img}} @else {{asset('img/placeholder/placeholder-product.jpg')}} @endif')">
                </div>
            </div>
            <!-- Controls -->
            <a id="left-button" data-propertyId="{{$properties['property_id']}}" class="left carousel-control" href="#" role="button" data-slide="prev">
                <span class="slider-mover-left no-bg" aria-hidden="true">
                    <img src="img/chevron-left.png" alt="chevron-left">
                </span>
                <span class="sr-only">Previous</span>
            </a>
            <a id="right-button" data-propertyId="{{$properties['property_id']}}" class="right carousel-control" href="#" role="button" data-slide="next">
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
                        <a href="{{route('property.detail')}}?property_id={{$properties['property_id']}}"><?php echo $properties['basic_name']; ?></a>
                    </h1>
                </div>
                <!-- Price -->
                <div class="price">
                    $<?php echo $properties['basic_price']; ?>
                </div>
            </header>
            <!-- Location -->
            <h3 class="location">
                <a href="#">
                    <i class="fa fa-map-marker"></i> <?php echo $properties['basic_location']; ?>
                </a>
            </h3>
        </div>
    </div>

</div>