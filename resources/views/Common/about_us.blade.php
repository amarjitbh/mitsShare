@extends('layouts.after_login')

@section('content')
{{--About Us Section Start--}}
<div class="about-city-estate">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="car-detail-slider simple-slider">
                    <div id="carousel-custom" class="carousel slide" data-ride="carousel">
                        <div class="carousel-outer">
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img src="{{URL::asset('img/properties/properties-1.jpg')}}" class="img-preview" alt="properties-1">
                                </div>
                                <div class="item">
                                    <img src="{{URL::asset('img/properties/properties-2.jpg')}}" class="img-preview" alt="properties-2">
                                </div>
                                <div class="item">
                                    <img src="{{URL::asset('img/properties/properties-5.jpg')}}" class="img-preview" alt="properties-3">
                                </div>
                                <div class="item">
                                    <img src="{{URL::asset('img/properties/properties-8.jpg')}}" class="img-preview" alt="properties-8">
                                </div>
                                <div class="item">
                                    <img src="{{URL::asset('img/properties/properties-3.jpg')}}" class="img-preview" alt="properties-5">
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
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="about-text">
                    <h3>We are the Most Professional Property Company in America Right Now!!</h3>
                    <p>One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections. </p>
                    <ul class="clearfix">
                        <li>
                            <i class="fa fa-check-square"></i><span>Professional Variations</span>
                        </li>
                        <li>
                            <i class="fa fa-check-square"></i><span>Happy Clients</span>
                        </li>
                        <li>
                            <i class="fa fa-check-square"></i><span>Guaranteed</span>
                        </li>
                        <li>
                            <i class="fa fa-check-square"></i><span>Clean design</span>
                        </li>
                        <li>
                            <i class="fa fa-check-square"></i><span>Consulting</span>
                        </li>
                        <li>
                            <i class="fa fa-check-square"></i><span>Advertise</span>
                        </li>
                    </ul>
                    {{--<a href="#" class="btn button-md button-theme">Read More</a>--}}
                </div>
            </div>
        </div>
    </div>
</div>
{{--About Us Section End--}}


{{--Team Section End--}}
<div class="about-team-meet">
    <div class="container">
        <!-- Main title -->
        <div class="main-title">
            <h1>Our Agents</h1>
            <div class="border">
                <div class="border-inner"></div>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean ac tortor at tellus feugiat congue quis ut nunc. Semper ac dolor vitae accumsan. interdum hendrerit lacinia.</p>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 clearfix">
                <!-- About box start-->
                <div class="thumbnail about-box wow fadeInLeft delay-03s" style="visibility: visible; animation-name: fadeInLeft;">
                    <img src="{{URL::asset('img/team/team-1.png')}}" alt="team-1" class="img-responsive">
                    <!-- Detail -->
                    <div class="caption detail">
                        <h6>Owner / Co-invester</h6>
                        <h3><a href="agent-detail.html">John deo</a></h3>
                        <!-- contact -->
                        <div class="contact">
                            <p>
                                <i class="fa fa-envelope-o"></i>
                                <a href="mailto:info@shareair.io">info@shareair.io</a>
                            </p>
                            <p>
                                <i class="fa fa-mobile"></i><a href="tel:+55417-634-7071">+55 4XX-634-7071</a>
                            </p>
                        </div>
                        <!-- social List -->
                        <ul class="social-list clearfix">
                            <li>
                                <a href="#" class="facebook">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="twitter">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="linkedin">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="google">
                                    <i class="fa fa-google-plus"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="rss">
                                    <i class="fa fa-rss"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- About box end -->
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 clearfix">
                <!-- About box start -->
                <div class="thumbnail about-box wow fadeInUp delay-03s" style="visibility: visible; animation-name: fadeInUp;">
                    <img src="{{URL::asset('img/team/team-2.png')}}" alt="team-2" class="img-responsive">
                    <!-- Detail -->
                    <div class="caption detail">
                        <h6>Manager</h6>
                        <h3><a href="agent-detail.html">Peter Harold</a></h3>
                        <!-- contact -->
                        <div class="contact">
                            <p>
                                <i class="fa fa-envelope-o"></i>
                                <a href="mailto:info@shareair.io">info@shareair.io</a>
                            </p>
                            <p>
                                <i class="fa fa-mobile"></i><a href="tel:+55417-634-7071">+55 4XX-634-7071</a>
                            </p>
                        </div>
                        <!-- social List -->
                        <ul class="social-list clearfix">
                            <li>
                                <a href="#" class="facebook">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="twitter">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="linkedin">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="google">
                                    <i class="fa fa-google-plus"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="rss">
                                    <i class="fa fa-rss"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- About box end -->
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 clearfix">
                <!-- About box start -->
                <div class="thumbnail about-box wow fadeInRight delay-03s" style="visibility: visible; animation-name: fadeInRight;">
                    <img src="{{URL::asset('img/team/team-3.png')}}" alt="team-3" class="img-responsive">
                    <!-- Detail -->
                    <div class="caption detail">
                        <h6>Creative Director</h6>
                        <h3><a href="#">John Doe</a></h3>
                        <!-- contact -->
                        <div class="contact">
                            <p>
                                <i class="fa fa-envelope-o"></i>
                                <a href="mailto:info@shareair.io">info@shareair.io</a>
                            </p>
                            <p>
                                <i class="fa fa-mobile"></i><a href="tel:+55417-634-7071">+55 4XX-634-7071</a>
                            </p>
                        </div>
                        <!-- social List -->
                        <ul class="social-list clearfix">
                            <li>
                                <a href="#" class="facebook">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="twitter">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="linkedin">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="google">
                                    <i class="fa fa-google-plus"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="rss">
                                    <i class="fa fa-rss"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- About box start -->
            </div>
        </div>
    </div>
</div>
{{--Team Section End--}}


@endsection