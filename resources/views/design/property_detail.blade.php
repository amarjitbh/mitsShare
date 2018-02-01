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
                            <div class="pull-left">
                                <h3>4552 Lynn Avenue</h3>
                                <p>
                                    20-21 Kathal St. Tampa City, FL
                                </p>
                            </div>
                            <div class="pull-right">
                                <h3>$420,000</h3>
                                <p>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                </p>
                            </div>
                        </div>
                        <!-- Properties detail slider start -->
                        <div class="properties-detail-slider simple-slider mrg-btm-40 ">
                            <div id="carousel-custom" class="carousel slide" data-ride="carousel">
                                <div class="carousel-outer">
                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner">
                                        <div class="item">
                                            <img src="{{URL::asset('img/properties/properties-1.jpg')}}" class="thumb-preview" alt="Chevrolet Impala">
                                        </div>
                                        <div class="item">
                                            <img src="{{URL::asset('img/properties/properties-2.jpg')}}" class="thumb-preview" alt="Chevrolet Impala">
                                        </div>
                                        <div class="item">
                                            <img src="{{URL::asset('img/properties/properties-7.jpg')}}" class="thumb-preview" alt="Chevrolet Impala">
                                        </div>
                                        <div class="item active left">
                                            <img src="{{URL::asset('img/properties/properties-8.jpg')}}" class="thumb-preview" alt="Chevrolet Impala">
                                        </div>
                                        <div class="item next left">
                                            <img src="{{URL::asset('img/properties/properties-5.jpg')}}" class="thumb-preview" alt="Chevrolet Impala">
                                        </div>
                                        <div class="item">
                                            <img src="{{URL::asset('img/properties/properties-6.jpg')}}" class="thumb-preview" alt="Chevrolet Impala">
                                        </div>
                                        <div class="item">
                                            <img src="{{URL::asset('img/properties/properties-3.jpg')}}" class="thumb-preview" alt="Chevrolet Impala">
                                        </div>
                                    </div>
                                    <!-- Controls -->
                                    <a class="left carousel-control" href="#carousel-custom" role="button" data-slide="prev">
                                    <span class="slider-mover-left no-bg" aria-hidden="true">
                                        <img src="{{URL::asset('img/chevron-left.png')}}" alt="chevron-left">
                                    </span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control" href="#carousel-custom" role="button" data-slide="next">
                                    <span class="slider-mover-right no-bg" aria-hidden="true">
                                        <img src="{{URL::asset('img/chevron-right.png')}}" alt="chevron-right">
                                    </span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                                <!-- Indicators -->
                                <ol class="carousel-indicators thumbs visible-lg visible-md">
                                    <li data-target="#carousel-custom" data-slide-to="0" class=""><img src="{{URL::asset('img/properties/properties-small-1.jpg')}}" alt="Chevrolet Impala"></li>
                                    <li data-target="#carousel-custom" data-slide-to="1" class=""><img src="{{URL::asset('img/properties/properties-small-2.jpg')}}" alt="Chevrolet Impala"></li>
                                    <li data-target="#carousel-custom" data-slide-to="2" class=""><img src="{{URL::asset('img/properties/properties-small-7.jpg')}}" alt="Chevrolet Impala"></li>
                                    <li data-target="#carousel-custom" data-slide-to="3" class=""><img src="{{URL::asset('img/properties/properties-small-8.jpg')}}" alt="Chevrolet Impala"></li>
                                    <li data-target="#carousel-custom" data-slide-to="4" class="active"><img src="{{URL::asset('img/properties/properties-small-5.jpg')}}" alt="Chevrolet Impala"></li>
                                    <li data-target="#carousel-custom" data-slide-to="5" class=""><img src="{{URL::asset('img/properties/properties-small-6.jpg')}}" alt="Chevrolet Impala"></li>
                                    <li data-target="#carousel-custom" data-slide-to="6" class=""><img src="{{URL::asset('img/properties/properties-small-3.jpg')}}" alt="Chevrolet Impala"></li>
                                </ol>
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
                                <a href="#" class="add-review">
                                    <i class="fa fa-plus-circle"></i>Add Review
                                </a>
                            </div>
                            <p>Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui voluptatem sequi nesciunt.<br><br>
                                Neque porro quisqua. Sed ut perspiciatis unde omnis ste natus error sit voluptatem.</p>

                            <a href="#" class="wishlist-btn">
                            <span class="wishlist-btn-l">
                                <i class="fa fa-plus"></i>
                            </span>
                                <span class="wishlist-btn-r">Add to favorite list</span>
                                <div class="clear"></div>
                            </a>
                            <a href="#" class="book-btn">
                                <span class="book-btn-l"><i class="fa fa-check"></i></span>
                                <span class="book-btn-r">Add to favorite list</span>
                                <div class="clear"></div>
                            </a>
                        </div>
                        <!-- Specifications end -->

                        <!-- Properties description start -->
                        <div class="properties-description mrg-btm-40 ">
                            <h3 class="heading">
                                Description
                            </h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in pulvinar neque. Nulla finibus lobortis pulvinar. Donec a consectetur nulla. Nulla posuere sapien vitae lectus suscipit, et pulvinar nisi tincidunt. Aliquam erat volutpat. Curabitur convallis fringilla diam sed aliquam. Sed tempor iaculis massa faucibus feugiat. In fermentum facilisis massa, a consequat purus viverra a. Aliquam pellentesque nibh et nibh feugiat gravida. Maecenas ultricies, diam vitae semper placerat, velit risus accumsan nisl, eget tempor lacus est vel nunc. Proin accumsan elit sed neque euismod fringilla. Curabitur lobortis nunc velit, et fermentum urna dapibus non. Vivamus magna lorem, elementum id gravida ac, laoreet tristique augue. Maecenas dictum lacus eu nunc porttitor, ut hendrerit arcu efficitur.</p>
                            <p>Nam mattis lobortis felis eu blandit. Morbi tellus ligula, interdum sit amet ipsum et, viverra hendrerit lectus. Nunc efficitur sem vel est laoreet, sed bibendum eros viverra. Vestibulum finibus, ligula sed euismod tincidunt, lacus libero lobortis ligula, sit amet molestie ipsum purus ut tortor. Nunc varius, dui et sollicitudin facilisis, erat felis imperdiet felis, et iaculis dui magna vitae diam. Donec mattis diam nisl, quis ullamcorper enim malesuada non. Curabitur lobortis eu mauris nec vestibulum. Nam efficitur, ex ac semper malesuada nisi odio consequat dui, hendrerit vulputate odio dui vitae massa. Aliquam tortor urna, tincidunt </p>
                        </div>
                        <!-- Properties description end -->

                        <!-- Properties condition start -->
                        <div class="properties-condition mrg-btm-40 ">
                            <h3 class="heading">
                                Property Details
                            </h3>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <ul class="condition">
                                        <li>
                                            <i class="flaticon-bed"></i>2 Bedroom
                                        </li>
                                        <li>
                                            <i class="flaticon-holidays"></i>Bathroom
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <ul class="condition">
                                        <li>
                                            <i class="flaticon-square-layouting-with-black-square-in-east-area"></i>4800 sq ft
                                        </li>
                                        <li>
                                            <i class="flaticon-monitor"></i>TV Lounge
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <ul class="condition">
                                        <li>
                                            <i class="flaticon-vehicle"></i>1 Garage
                                        </li>
                                        <li>
                                            <i class="flaticon-building"></i>Balcony
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Properties condition end -->

                        <!-- Properties amenities start -->
                        <div class="properties-amenities mrg-btm-40 ">
                            <h3 class="heading">
                                Features
                            </h3>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <ul class="amenities">
                                        <li>
                                            <i class="flaticon-air-conditioner"></i>Air conditioning
                                        </li>
                                        <li>
                                            <i class="flaticon-bars"></i>Balcony
                                        </li>
                                        <li>
                                            <i class="flaticon-people-2"></i>Pool
                                        </li>
                                        <li>
                                            <i class="flaticon-monitor"></i>TV Lounge
                                        </li>
                                        <li>
                                            <i class="flaticon-weightlifting"></i>Gym
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <ul class="amenities">
                                        <li>
                                            <i class="flaticon-wifi"></i>Wifi
                                        </li>
                                        <li>
                                            <i class="flaticon-transport"></i>Parking
                                        </li>
                                        <li>
                                            <i class="flaticon-bed"></i>Double Bed
                                        </li>
                                        <li>
                                            <i class="flaticon-machine"></i>Iron
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <ul class="amenities">
                                        <li>
                                            <i class="flaticon-old-telephone-ringing"></i>Telephone
                                        </li>
                                        <li>
                                            <i class="flaticon-person-enjoying-jacuzzi-hot-water-bath"></i>Jacuzzi
                                        </li>
                                        <li>
                                            <i class="flaticon-clock"></i>Alarm
                                        </li>
                                        <li>
                                            <i class="flaticon-vehicle"></i>Garage
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Properties amenities end -->

                        <!-- Location start -->
                        <div class="sectionc location mrg-btm-40">
                            <div class="map">
                                <h3 class="heading">Location</h3>
                                <div id="map" class="contact-map" style="height: 552px; position: relative; overflow: hidden;"><div style="height: 100%; width: 100%; position: absolute; top: 0px; left: 0px; background-color: rgb(229, 227, 223);"><div class="gm-style" style="position: absolute; z-index: 0; left: 0px; top: 0px; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px;"><div tabindex="0" style="position: absolute; z-index: 0; left: 0px; top: 0px; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; cursor: url(&quot;https://maps.gstatic.com/mapfiles/openhand_8_8.cur&quot;) 8 8, default;"><div style="z-index: 1; position: absolute; top: 0px; left: 0px; width: 100%; transform-origin: 0px 0px 0px; transform: matrix(1, 0, 0, 1, 0, 0);"><div style="position: absolute; left: 0px; top: 0px; z-index: 100; width: 100%;"><div style="position: absolute; left: 0px; top: 0px; z-index: 0;"><div aria-hidden="true" style="position: absolute; left: 0px; top: 0px; z-index: 1; visibility: inherit;"><div style="width: 256px; height: 256px; position: absolute; left: 9px; top: 110px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 265px; top: 110px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 265px; top: -146px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 9px; top: -146px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 9px; top: 366px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 265px; top: 366px;"></div><div style="width: 256px; height: 256px; position: absolute; left: -247px; top: 110px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 521px; top: 110px;"></div><div style="width: 256px; height: 256px; position: absolute; left: -247px; top: 366px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 521px; top: -146px;"></div><div style="width: 256px; height: 256px; position: absolute; left: -247px; top: -146px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 521px; top: 366px;"></div></div></div></div><div style="position: absolute; left: 0px; top: 0px; z-index: 101; width: 100%;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 102; width: 100%;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 103; width: 100%;"><div style="position: absolute; left: 0px; top: 0px; z-index: -1;"><div aria-hidden="true" style="position: absolute; left: 0px; top: 0px; z-index: 1; visibility: inherit;"><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 9px; top: 110px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 265px; top: 110px;"><canvas draggable="false" height="256" width="256" style="user-select: none; position: absolute; left: 0px; top: 0px; height: 256px; width: 256px;"></canvas></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 265px; top: -146px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 9px; top: -146px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 9px; top: 366px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 265px; top: 366px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: -247px; top: 110px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 521px; top: 110px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: -247px; top: 366px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 521px; top: -146px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: -247px; top: -146px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 521px; top: 366px;"></div></div></div></div><div style="position: absolute; z-index: 0; left: 0px; top: 0px;"><div style="overflow: hidden;"></div></div><div style="position: absolute; left: 0px; top: 0px; z-index: 0;"><div aria-hidden="true" style="position: absolute; left: 0px; top: 0px; z-index: 1; visibility: inherit;"><div style="position: absolute; left: 9px; top: 366px; transition: opacity 200ms ease-out;"><img draggable="false" alt="" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i9646!3i12321!4i256!2m3!1e0!2sm!3i394091619!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjF8cy5lOmx8cC52Om9mZixzLnQ6NnxzLmU6bHxwLnY6b2ZmLHMudDozM3xwLnY6b2ZmLHMudDo0fHMuZTpsLml8cC52Om9mZg!4e0&amp;token=1151" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 265px; top: 366px; transition: opacity 200ms ease-out;"><img draggable="false" alt="" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i9647!3i12321!4i256!2m3!1e0!2sm!3i394091619!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjF8cy5lOmx8cC52Om9mZixzLnQ6NnxzLmU6bHxwLnY6b2ZmLHMudDozM3xwLnY6b2ZmLHMudDo0fHMuZTpsLml8cC52Om9mZg!4e0&amp;token=38875" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 521px; top: 366px; transition: opacity 200ms ease-out;"><img draggable="false" alt="" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i9648!3i12321!4i256!2m3!1e0!2sm!3i394091619!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjF8cy5lOmx8cC52Om9mZixzLnQ6NnxzLmU6bHxwLnY6b2ZmLHMudDozM3xwLnY6b2ZmLHMudDo0fHMuZTpsLml8cC52Om9mZg!4e0&amp;token=76599" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: -247px; top: 110px; transition: opacity 200ms ease-out;"><img draggable="false" alt="" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i9645!3i12320!4i256!2m3!1e0!2sm!3i394091631!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjF8cy5lOmx8cC52Om9mZixzLnQ6NnxzLmU6bHxwLnY6b2ZmLHMudDozM3xwLnY6b2ZmLHMudDo0fHMuZTpsLml8cC52Om9mZg!4e0&amp;token=38268" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 9px; top: 110px; transition: opacity 200ms ease-out;"><img draggable="false" alt="" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i9646!3i12320!4i256!2m3!1e0!2sm!3i394091643!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjF8cy5lOmx8cC52Om9mZixzLnQ6NnxzLmU6bHxwLnY6b2ZmLHMudDozM3xwLnY6b2ZmLHMudDo0fHMuZTpsLml8cC52Om9mZg!4e0&amp;token=540" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 265px; top: 110px; transition: opacity 200ms ease-out;"><img draggable="false" alt="" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i9647!3i12320!4i256!2m3!1e0!2sm!3i394091643!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjF8cy5lOmx8cC52Om9mZixzLnQ6NnxzLmU6bHxwLnY6b2ZmLHMudDozM3xwLnY6b2ZmLHMudDo0fHMuZTpsLml8cC52Om9mZg!4e0&amp;token=38264" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: -247px; top: -146px; transition: opacity 200ms ease-out;"><img draggable="false" alt="" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i9645!3i12319!4i256!2m3!1e0!2sm!3i394091631!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjF8cy5lOmx8cC52Om9mZixzLnQ6NnxzLmU6bHxwLnY6b2ZmLHMudDozM3xwLnY6b2ZmLHMudDo0fHMuZTpsLml8cC52Om9mZg!4e0&amp;token=17282" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: -247px; top: 366px; transition: opacity 200ms ease-out;"><img draggable="false" alt="" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i9645!3i12321!4i256!2m3!1e0!2sm!3i394091631!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjF8cy5lOmx8cC52Om9mZixzLnQ6NnxzLmU6bHxwLnY6b2ZmLHMudDozM3xwLnY6b2ZmLHMudDo0fHMuZTpsLml8cC52Om9mZg!4e0&amp;token=19534" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 9px; top: -146px; transition: opacity 200ms ease-out;"><img draggable="false" alt="" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i9646!3i12319!4i256!2m3!1e0!2sm!3i394091643!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjF8cy5lOmx8cC52Om9mZixzLnQ6NnxzLmU6bHxwLnY6b2ZmLHMudDozM3xwLnY6b2ZmLHMudDo0fHMuZTpsLml8cC52Om9mZg!4e0&amp;token=110625" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 265px; top: -146px; transition: opacity 200ms ease-out;"><img draggable="false" alt="" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i9647!3i12319!4i256!2m3!1e0!2sm!3i394091643!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjF8cy5lOmx8cC52Om9mZixzLnQ6NnxzLmU6bHxwLnY6b2ZmLHMudDozM3xwLnY6b2ZmLHMudDo0fHMuZTpsLml8cC52Om9mZg!4e0&amp;token=17278" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 521px; top: 110px; transition: opacity 200ms ease-out;"><img draggable="false" alt="" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i9648!3i12320!4i256!2m3!1e0!2sm!3i394091643!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjF8cy5lOmx8cC52Om9mZixzLnQ6NnxzLmU6bHxwLnY6b2ZmLHMudDozM3xwLnY6b2ZmLHMudDo0fHMuZTpsLml8cC52Om9mZg!4e0&amp;token=75988" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 521px; top: -146px; transition: opacity 200ms ease-out;"><img draggable="false" alt="" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i9648!3i12319!4i256!2m3!1e0!2sm!3i394091643!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjF8cy5lOmx8cC52Om9mZixzLnQ6NnxzLmU6bHxwLnY6b2ZmLHMudDozM3xwLnY6b2ZmLHMudDo0fHMuZTpsLml8cC52Om9mZg!4e0&amp;token=55002" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div></div></div></div><div class="gm-style-pbc" style="z-index: 2; position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px; opacity: 0;"><p class="gm-style-pbt"></p></div><div style="z-index: 3; position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px;"><div style="z-index: 1; position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px;"></div></div><div style="z-index: 4; position: absolute; top: 0px; left: 0px; width: 100%; transform-origin: 0px 0px 0px; transform: matrix(1, 0, 0, 1, 0, 0);"><div style="position: absolute; left: 0px; top: 0px; z-index: 104; width: 100%;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 105; width: 100%;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 106; width: 100%;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 107; width: 100%;"></div></div></div><div style="margin-left: 5px; margin-right: 5px; z-index: 1000000; position: absolute; left: 0px; bottom: 0px;"><a target="_blank" href="https://maps.google.com/maps?ll=40.711041,-74.011676&amp;z=15&amp;t=m&amp;hl=en-US&amp;gl=US&amp;mapclient=apiv3" title="Click to see this area on Google Maps" style="position: static; overflow: visible; float: none; display: inline;"><div style="width: 66px; height: 26px; cursor: pointer;"><img src="https://maps.gstatic.com/mapfiles/api-3/images/google_white5.png" draggable="false" style="position: absolute; left: 0px; top: 0px; width: 66px; height: 26px; user-select: none; border: 0px; padding: 0px; margin: 0px;"></div></a></div><div style="background-color: white; padding: 15px 21px; border: 1px solid rgb(171, 171, 171); font-family: Roboto, Arial, sans-serif; color: rgb(34, 34, 34); box-shadow: rgba(0, 0, 0, 0.2) 0px 4px 16px; z-index: 10000002; display: none; width: 256px; height: 148px; position: absolute; left: 190px; top: 110px;"><div style="padding: 0px 0px 10px; font-size: 16px;">Map Data</div><div style="font-size: 13px;">Map data ©2017 Google</div><div style="width: 13px; height: 13px; overflow: hidden; position: absolute; opacity: 0.7; right: 12px; top: 12px; z-index: 10000; cursor: pointer;"><img src="https://maps.gstatic.com/mapfiles/api-3/images/mapcnt6.png" draggable="false" style="position: absolute; left: -2px; top: -336px; width: 59px; height: 492px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div></div><div class="gmnoprint" style="z-index: 1000001; position: absolute; right: 166px; bottom: 0px; width: 121px;"><div draggable="false" class="gm-style-cc" style="user-select: none; height: 14px; line-height: 14px;"><div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;"><div style="width: 1px;"></div><div style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;"></div></div><div style="position: relative; padding-right: 6px; padding-left: 6px; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); white-space: nowrap; direction: ltr; text-align: right; vertical-align: middle; display: inline-block;"><a style="color: rgb(68, 68, 68); text-decoration: none; cursor: pointer; display: none;">Map Data</a><span style="">Map data ©2017 Google</span></div></div></div><div class="gmnoscreen" style="position: absolute; right: 0px; bottom: 0px;"><div style="font-family: Roboto, Arial, sans-serif; font-size: 11px; color: rgb(68, 68, 68); direction: ltr; text-align: right; background-color: rgb(245, 245, 245);">Map data ©2017 Google</div></div><div class="gmnoprint gm-style-cc" draggable="false" style="z-index: 1000001; user-select: none; height: 14px; line-height: 14px; position: absolute; right: 95px; bottom: 0px;"><div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;"><div style="width: 1px;"></div><div style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;"></div></div><div style="position: relative; padding-right: 6px; padding-left: 6px; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); white-space: nowrap; direction: ltr; text-align: right; vertical-align: middle; display: inline-block;"><a href="https://www.google.com/intl/en-US_US/help/terms_maps.html" target="_blank" style="text-decoration: none; cursor: pointer; color: rgb(68, 68, 68);">Terms of Use</a></div></div><div style="cursor: pointer; width: 25px; height: 25px; overflow: hidden; margin: 10px 14px; position: absolute; top: 0px; right: 0px;"><img src="https://maps.gstatic.com/mapfiles/api-3/images/sv9.png" draggable="false" class="gm-fullscreen-control" style="position: absolute; left: -52px; top: -86px; width: 164px; height: 175px; user-select: none; border: 0px; padding: 0px; margin: 0px;"></div><div draggable="false" class="gm-style-cc" style="user-select: none; height: 14px; line-height: 14px; position: absolute; right: 0px; bottom: 0px;"><div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;"><div style="width: 1px;"></div><div style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;"></div></div><div style="position: relative; padding-right: 6px; padding-left: 6px; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); white-space: nowrap; direction: ltr; text-align: right; vertical-align: middle; display: inline-block;"><a target="_new" title="Report errors in the road map or imagery to Google" href="https://www.google.com/maps/@40.7110411,-74.0116763,15z/data=!10m1!1e1!12b1?source=apiv3&amp;rapsrc=apiv3" style="font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); text-decoration: none; position: relative;">Report a map error</a></div></div><div class="gmnoprint gm-bundled-control gm-bundled-control-on-bottom" draggable="false" controlwidth="28" controlheight="93" style="margin: 10px; user-select: none; position: absolute; bottom: 107px; right: 28px;"><div class="gmnoprint" controlwidth="28" controlheight="55" style="position: absolute; left: 0px; top: 38px;"><div draggable="false" style="user-select: none; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius: 2px; cursor: pointer; background-color: rgb(255, 255, 255); width: 28px; height: 55px;"><div title="Zoom in" aria-label="Zoom in" tabindex="0" style="position: relative; width: 28px; height: 27px; left: 0px; top: 0px;"><div style="overflow: hidden; position: absolute; width: 15px; height: 15px; left: 7px; top: 6px;"><img src="https://maps.gstatic.com/mapfiles/api-3/images/tmapctrl.png" draggable="false" style="position: absolute; left: 0px; top: 0px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none; width: 120px; height: 54px;"></div></div><div style="position: relative; overflow: hidden; width: 67%; height: 1px; left: 16%; background-color: rgb(230, 230, 230); top: 0px;"></div><div title="Zoom out" aria-label="Zoom out" tabindex="0" style="position: relative; width: 28px; height: 27px; left: 0px; top: 0px;"><div style="overflow: hidden; position: absolute; width: 15px; height: 15px; left: 7px; top: 6px;"><img src="https://maps.gstatic.com/mapfiles/api-3/images/tmapctrl.png" draggable="false" style="position: absolute; left: 0px; top: -15px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none; width: 120px; height: 54px;"></div></div></div></div><div class="gm-svpc" controlwidth="28" controlheight="28" style="background-color: rgb(255, 255, 255); box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius: 2px; width: 28px; height: 28px; cursor: url(&quot;https://maps.gstatic.com/mapfiles/openhand_8_8.cur&quot;) 8 8, default; position: absolute; left: 0px; top: 0px;"><div style="position: absolute; left: 1px; top: 1px;"></div><div style="position: absolute; left: 1px; top: 1px;"><div aria-label="Street View Pegman Control" style="width: 26px; height: 26px; overflow: hidden; position: absolute; left: 0px; top: 0px;"><img src="https://maps.gstatic.com/mapfiles/api-3/images/cb_scout5.png" draggable="false" style="position: absolute; left: -147px; top: -26px; width: 215px; height: 835px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div aria-label="Pegman is on top of the Map" style="width: 26px; height: 26px; overflow: hidden; position: absolute; left: 0px; top: 0px; visibility: hidden;"><img src="https://maps.gstatic.com/mapfiles/api-3/images/cb_scout5.png" draggable="false" style="position: absolute; left: -147px; top: -52px; width: 215px; height: 835px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div aria-label="Street View Pegman Control" style="width: 26px; height: 26px; overflow: hidden; position: absolute; left: 0px; top: 0px; visibility: hidden;"><img src="https://maps.gstatic.com/mapfiles/api-3/images/cb_scout5.png" draggable="false" style="position: absolute; left: -147px; top: -78px; width: 215px; height: 835px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div></div></div><div class="gmnoprint" controlwidth="28" controlheight="0" style="display: none; position: absolute;"><div title="Rotate map 90 degrees" style="width: 28px; height: 28px; overflow: hidden; position: absolute; border-radius: 2px; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; cursor: pointer; background-color: rgb(255, 255, 255); display: none;"><img src="https://maps.gstatic.com/mapfiles/api-3/images/tmapctrl4.png" draggable="false" style="position: absolute; left: -141px; top: 6px; width: 170px; height: 54px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div class="gm-tilt" style="width: 28px; height: 28px; overflow: hidden; position: absolute; border-radius: 2px; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; top: 0px; cursor: pointer; background-color: rgb(255, 255, 255);"><img src="https://maps.gstatic.com/mapfiles/api-3/images/tmapctrl4.png" draggable="false" style="position: absolute; left: -141px; top: -13px; width: 170px; height: 54px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div></div></div><div class="gmnoprint" style="margin: 10px; z-index: 0; position: absolute; cursor: pointer; left: 0px; top: 0px;"><div class="gm-style-mtc" style="float: left;"><div draggable="false" title="Show street map" style="direction: ltr; overflow: hidden; text-align: center; position: relative; color: rgb(0, 0, 0); font-family: Roboto, Arial, sans-serif; user-select: none; font-size: 11px; background-color: rgb(255, 255, 255); padding: 8px; border-bottom-left-radius: 2px; border-top-left-radius: 2px; -webkit-background-clip: padding-box; background-clip: padding-box; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; min-width: 22px; font-weight: 500;">Map</div><div style="background-color: white; z-index: -1; padding: 2px; border-bottom-left-radius: 2px; border-bottom-right-radius: 2px; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; position: absolute; left: 0px; top: 29px; text-align: left; display: none;"><div draggable="false" title="Show street map with terrain" style="color: rgb(0, 0, 0); font-family: Roboto, Arial, sans-serif; user-select: none; font-size: 11px; background-color: rgb(255, 255, 255); padding: 6px 8px 6px 6px; direction: ltr; text-align: left; white-space: nowrap;"><span role="checkbox" style="box-sizing: border-box; position: relative; line-height: 0; font-size: 0px; margin: 0px 5px 0px 0px; display: inline-block; background-color: rgb(255, 255, 255); border: 1px solid rgb(198, 198, 198); border-radius: 1px; width: 13px; height: 13px; vertical-align: middle;"><div style="position: absolute; left: 1px; top: -2px; width: 13px; height: 11px; overflow: hidden; display: none;"><img src="https://maps.gstatic.com/mapfiles/mv/imgs8.png" draggable="false" style="position: absolute; left: -52px; top: -44px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none; width: 68px; height: 67px;"></div></span><label style="vertical-align: middle; cursor: pointer;">Terrain</label></div></div></div><div class="gm-style-mtc" style="float: left;"><div draggable="false" title="Show satellite imagery" style="direction: ltr; overflow: hidden; text-align: center; position: relative; color: rgb(86, 86, 86); font-family: Roboto, Arial, sans-serif; user-select: none; font-size: 11px; background-color: rgb(255, 255, 255); padding: 8px; border-bottom-right-radius: 2px; border-top-right-radius: 2px; -webkit-background-clip: padding-box; background-clip: padding-box; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-left: 0px; min-width: 40px;">Satellite</div><div style="background-color: white; z-index: -1; padding: 2px; border-bottom-left-radius: 2px; border-bottom-right-radius: 2px; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; position: absolute; right: 0px; top: 29px; text-align: left; display: none;"><div draggable="false" title="Show imagery with street names" style="color: rgb(0, 0, 0); font-family: Roboto, Arial, sans-serif; user-select: none; font-size: 11px; background-color: rgb(255, 255, 255); padding: 6px 8px 6px 6px; direction: ltr; text-align: left; white-space: nowrap;"><span role="checkbox" style="box-sizing: border-box; position: relative; line-height: 0; font-size: 0px; margin: 0px 5px 0px 0px; display: inline-block; background-color: rgb(255, 255, 255); border: 1px solid rgb(198, 198, 198); border-radius: 1px; width: 13px; height: 13px; vertical-align: middle;"><div style="position: absolute; left: 1px; top: -2px; width: 13px; height: 11px; overflow: hidden;"><img src="https://maps.gstatic.com/mapfiles/mv/imgs8.png" draggable="false" style="position: absolute; left: -52px; top: -44px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none; width: 68px; height: 67px;"></div></span><label style="vertical-align: middle; cursor: pointer;">Labels</label></div></div></div></div></div></div></div>
                            </div>
                        </div>
                        <!-- Location end -->
                    </div>

                    <div class="properties-details-section">
                        <!-- Properties comments start -->
                        <div class="properties-comments mrg-btm-40">
                            <h3 class="heading">
                                Comments Section
                            </h3>
                            <ul class="comments">
                                <li>
                                    <div class="comment">
                                        <div class="comment-author">
                                            <a href="#">
                                                <img src="{{URL::asset('img/avatar/avatar-5.png')}}" alt="avatar-5">
                                            </a>
                                        </div>
                                        <div class="comment-content">
                                            <div class="comment-meta">
                                                <div class="comment-meta-author">
                                                    Posted by <a href="#">admin</a>
                                                </div>
                                                <div class="comment-meta-reply">
                                                    <a href="#">Reply</a>
                                                </div>
                                                <div class="comment-meta-date">
                                                    <span class="hidden-xs">8:42 PM 1/28/2017</span>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="comment-body">
                                                <div class="comment-rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-o"></i>
                                                </div>
                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer
                                            </div>
                                        </div>
                                    </div>
                                    <ul>
                                        <li>
                                            <div class="comment">
                                                <div class="comment-author">
                                                    <a href="#">
                                                        <img src="{{URL::asset('img/avatar/avatar-5.png')}}" alt="avatar-5">
                                                    </a>
                                                </div>

                                                <div class="comment-content">
                                                    <div class="comment-meta">
                                                        <div class="comment-meta-author">
                                                            Posted by <a href="#">admin</a>
                                                        </div>
                                                        <div class="comment-meta-reply">
                                                            <a href="#">Reply</a>
                                                        </div>
                                                        <div class="comment-meta-date">
                                                            <span class="hidden-xs">3:54 PM 1/15/2018</span>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="comment-body">
                                                        <div class="comment-rating">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-half-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                        </div>
                                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <div class="comment">
                                        <div class="comment-author">
                                            <a href="#">
                                                <img src="{{URL::asset('img/avatar/avatar-5.png')}}" alt="avatar-5">
                                            </a>
                                        </div>
                                        <div class="comment-content">
                                            <div class="comment-meta">
                                                <div class="comment-meta-author">
                                                    Posted by <a href="#">admin</a>
                                                </div>
                                                <div class="comment-meta-reply">
                                                    <a href="#">Reply</a>
                                                </div>
                                                <div class="comment-meta-date">
                                                    <span class="hidden-xs">8:42 PM 1/28/2017</span>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="comment-body">
                                                <div class="comment-rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-o"></i>
                                                </div>
                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer
                                            </div>
                                        </div>
                                    </div>
                                    <ul>
                                        <li>
                                            <div class="comment">
                                                <div class="comment-author">
                                                    <a href="#">
                                                        <img src="{{URL::asset('img/avatar/avatar-5.png')}}" alt="avatar-5">
                                                    </a>
                                                </div>

                                                <div class="comment-content">
                                                    <div class="comment-meta">
                                                        <div class="comment-meta-author">
                                                            Posted by <a href="#">admin</a>
                                                        </div>
                                                        <div class="comment-meta-reply">
                                                            <a href="#">Reply</a>
                                                        </div>
                                                        <div class="comment-meta-date">
                                                            <span class="hidden-xs">3:54 PM 1/15/2018</span>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="comment-body">
                                                        <div class="comment-rating">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-half-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                        </div>
                                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!-- Properties comments end -->

                        <!-- Contact form start -->
                        <div class="contact-form">
                            <h2 class="comments-title">Contact with us</h2>
                            <form id="contact_form" action="index.html" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group fullname">
                                            <input type="text" name="full-name" class="input-text" placeholder="Full Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group enter-email">
                                            <input type="email" name="email" class="input-text" placeholder="Enter email">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group subject">
                                            <input type="text" name="subject" class="input-text" placeholder="Subject">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group number">
                                            <input type="text" name="phone" class="input-text" placeholder="Phone Number">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group message">
                                            <textarea class="input-text" name="message" placeholder="Write message"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group send-btn mrg-btn-0">
                                            <button type="submit" class="button-md button-theme">Send Message</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Contact form end -->
                    </div>

                </div>
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="sidebar right">
                        <!-- Specifications start -->
                        <div class="sidebar sidebar-widget specifications clearfix hidden-xs hidden-sm">
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
                                <a href="#" class="add-review">
                                    <i class="fa fa-plus-circle"></i>Add Review
                                </a>
                            </div>
                            <p>Voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui voluptatem sequi nesciunt.<br><br>
                                Neque porro quisqua. Sed ut perspiciatis unde omnis ste natus error sit voluptatem.</p>

                            <a href="#" class="wishlist-btn">
                            <span class="wishlist-btn-l">
                                <i class="fa fa-plus"></i>
                            </span>
                                <span class="wishlist-btn-r">Add to favorite list</span>
                                <div class="clear"></div>
                            </a>
                            <a href="#" class="book-btn">
                                <span class="book-btn-l"><i class="fa fa-check"></i></span>
                                <span class="book-btn-r">Add to favorite list</span>
                                <div class="clear"></div>
                            </a>
                        </div>
                        <!-- Specifications end -->

                        <!-- Print section start -->
                        <div class="print-section">
                            <a class="widget-link"><i class="flaticon-technology-2"></i> Print</a>
                            <a class="widget-link" data-save-title="Save" data-saved-title="Saved"><i class="flaticon-shape"></i>Bookmark</a>
                        </div>
                        <!-- print-section end -->

                        <!-- Agent widget start -->
                        <div class="sidebar sidebar-widget contact-form agent-widget">
                            <h3>
                                <a href="#">John Doe</a>
                            </h3>
                            <h4>
                                <i class="fa fa-phone"></i>
                                <span>+55 4XX-634-7071</span>
                            </h4>
                            <form id="agent_form" action="index.html" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group enter-email">
                                            <input type="email" name="email" class="input-text" placeholder="Your Email">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group number">
                                            <input type="text" name="phone" class="input-text" placeholder="Your Phone">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group message">
                                            <textarea class="input-text" name="message" placeholder="I'm interested in this property [ID 123456] and I'd like to know more details."></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" class="button-md button-theme btn-block">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Agent widget end -->

                        <!-- Featured property box start -->
                        <h3 class="heading">
                            Featured Property
                        </h3>
                        <div class="thumbnail recent-properties-box">
                            <img src="{{URL::asset('img/properties/properties-5.jpg')}}" alt="properties-5" class="img-responsive">
                            <!-- Detail -->
                            <div class="caption detail">
                                <!-- Header -->
                                <header class="clearfix">
                                    <div class="pull-left">
                                        <h1 class="title">
                                            <a href="#">4552 Lynn Avenue</a>
                                        </h1>
                                    </div>
                                    <!-- Price -->
                                    <div class="price">
                                        $2153.00
                                    </div>
                                </header>
                                <!-- Location -->
                                <h3 class="location">
                                    <a href="#">
                                        <i class="fa fa-map-marker"></i>20-21 Kathal St. Tampa City, FL
                                    </a>
                                </h3>
                                <!-- Facilities List -->
                                <ul class="facilities-list clearfix">
                                    <li class="bordered-right">
                                        <i class="flaticon-square-layouting-with-black-square-in-east-area"></i>
                                        <span>4800 sq ft</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-bed"></i>
                                        <span>2 Bedroom</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-monitor"></i>
                                        <span>1 TV Lounge</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-holidays"></i>
                                        <span>3 Bathroom</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-vehicle"></i>
                                        <span>1 Garage</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-building"></i>
                                        <span> 3 Balcony</span>
                                    </li>
                                </ul>
                                <!-- Footer -->
                                <div class="footer">
                                    <a href="#">
                                        <i class="fa fa-user"></i> Jhon Doe
                                    </a>
                                <span>
                                        <i class="fa fa-calendar-o"></i> 1 day ago
                                    </span>
                                </div>
                            </div>
                            <!-- Tag -->
                        <span class="tag-f">
                                <a href="properties-details.html">Featured</a>
                            </span>
                        <span class="tag-s">
                                <a href="properties-details.html">For Sale</a>
                            </span>
                        </div>
                        <!-- Featured property box end -->
                        <div class="clearfix"></div>

                        <div class="clearfix"></div>
                        <!-- Helping center start -->
                        <div class="sidebar sidebar-widget helping-center">
                            <h3 class="title">Helping Center</h3>
                            <p>Vivamus eget nibh. Etiam cursus leo vel metus. Nulla facilisi. Aenean nec eros.</p>
                            <ul class="contact-link">
                                <li>
                                    <i class="fa fa-map-marker"></i>
                                    Aenean vulputate porttitor
                                </li>
                                <li>
                                    <i class="fa fa-phone"></i>
                                    <a href="tel:+55-417-634-7071">
                                        +55 417 634 7071
                                    </a>
                                </li>
                                <li>
                                    <i class="fa fa-envelope-o"></i>
                                    <a href="mailto:info@themevessel.com">
                                        info@themevessel.com
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- Helping center end -->

                        <!-- Social media box start -->
                        <div class="blog-share social-media-box sidebar-widget sidebar">
                            <h3 class="title">Social Media</h3>
                            <ul class="social-list">
                                <li>
                                    <a href="#" class="facebook-bg">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="twitter-bg">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="google-bg">
                                        <i class="fa fa-google"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="linkedin-bg">
                                        <i class="fa fa-linkedin"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="pinterest-bg">
                                        <i class="fa fa-pinterest"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- Social media box end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--Property Detail Page End--}}
@endsection