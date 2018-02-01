@extends('layouts.after_login')

@section('content')

    {{--My Properties Page Start--}}
    <div class="my-propertiess">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-4">
                    <!-- My account box start -->
                    <div class="my-account-box">
                        <div class="item">
                            <h3 class="title">
                                Manage Account
                            </h3>
                            <p>
                                <a href="{{route('seller-profile')}}">
                                    <i class="flaticon-social"></i>My Profile
                                </a>
                            </p>
                            <p>
                                <a href="my-bookmarks.html">
                                    <i class="flaticon-shape"></i>Bookmarked Listings
                                </a>
                            </p>
                        </div>
                        <div class="item">
                            <h3 class="title">
                                Manage Booking
                            </h3>
                            <p>
                                <a href="{{route('buyer-upcoming-booking')}}" class="active">
                                    <i class="lnr lnr-calendar-full"></i>Upcoming Bookings
                                </a>
                            </p>
                            <p>
                                <a href="{{route('buyer-past-booking')}}">
                                    <i class="fa fa-clock-o"></i>Past Bookings
                                </a>
                            </p>
                        </div>
                        <div class="item">
                            <p>
                                <a href="{{route('buyer-change-password')}}">
                                    <i class="flaticon-security"></i>Change Password
                                </a>
                            </p>
                            <p>
                                <a href="{{route('logout')}}">
                                    <i class="flaticon-sign-out-option"></i>Log Out
                                </a>
                            </p>
                        </div>
                    </div>
                    <!-- My account box end -->
                </div>

                <div class="col-lg-9 col-md-9 col-sm-12">
                    <!-- Heading -->
                    <h1 class="heading">My Upcoming Bookings</h1>
                    <!-- My propertiess box start -->
                    <div class="my-properties-box wow fadeInUp delay-03s clearfix" style="visibility: visible; animation-name: fadeInUp;">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 col-pad my-propertie-theme">
                            <img src="{{URL::asset('img/properties/my-properties-1.jpg')}}" alt="my-properties-1" class="img-responsive">
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 col-pad">
                            <div class="detail">
                                <!-- Header -->
                                <header class="clearfix">
                                    <div class="pull-left">
                                        <h1 class="title">
                                            <a href="properties-details.html">Park avenue</a>
                                        </h1>
                                        <h3 class="location">
                                            <a href="#">
                                                <i class="fa fa-map-marker"></i>20-21 Kathal St. Tampa City, FL
                                            </a>
                                        </h3>
                                    </div>
                                    <!-- Btn -->
                                    <div class="pull-right">
                                        <a href="#" class="button-sm button-theme">Details</a>
                                    </div>
                                </header>
                                <hr>
                                <p> Morbi accumsan ipsum velit nam nec tellus a odio tincidunt auctor a ornare odio sed none stale mauris vitae erat consequat auctor eu in elit class ap</p>
                            </div>
                            <!-- footer -->
                            <div class="footer clearfix">
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <div class="price">
                                        $900 / monthly
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <div class="date">
                                        jun 30, 2016
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="listing-meta ">
                                    <span>
                                        <a href="#">
                                            <i class="fa fa-pencil"></i>Edit
                                        </a>
                                    </span>
                                    <span>
                                        <a href="#">
                                            <i class="fa fa-eye-slash"></i>Hide
                                        </a>
                                    </span>
                                    <span>
                                        <a href="#">
                                            <i class="fa fa-remove"></i>Delete
                                        </a>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="my-properties-box wow fadeInUp delay-03s clearfix" style="visibility: visible; animation-name: fadeInUp;">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 col-pad my-propertie-theme">
                            <img src="{{URL::asset('img/properties/my-properties-2.jpg')}}" alt="my-properties-2" class="img-responsive">
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 col-pad">
                            <div class="detail">
                                <!-- Header -->
                                <header class="clearfix">
                                    <div class="pull-left">
                                        <h1 class="title">
                                            <a href="properties-details.html">Park avenue</a>
                                        </h1>
                                        <h3 class="location">
                                            <a href="#">
                                                <i class="fa fa-map-marker"></i>20-21 Kathal St. Tampa City, FL
                                            </a>
                                        </h3>
                                    </div>
                                    <!-- Btn -->
                                    <div class="pull-right">
                                        <a href="#" class="button-sm button-theme">Details</a>
                                    </div>
                                </header>
                                <hr>
                                <p> Morbi accumsan ipsum velit nam nec tellus a odio tincidunt auctor a ornare odio sed none stale mauris vitae erat consequat auctor eu in elit class ap</p>
                            </div>
                            <!-- footer -->
                            <div class="footer clearfix">
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <div class="price">
                                        $900 / monthly
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <div class="date">
                                        jun 30, 2016
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="listing-meta ">
                                    <span>
                                        <a href="#">
                                            <i class="fa fa-pencil"></i>Edit
                                        </a>
                                    </span>
                                    <span>
                                        <a href="#">
                                            <i class="fa fa-eye-slash"></i>Hide
                                        </a>
                                    </span>
                                    <span>
                                        <a href="#">
                                            <i class="fa fa-remove"></i>Delete
                                        </a>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="my-properties-box wow fadeInUp delay-03s clearfix" style="visibility: hidden; animation-name: none;">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 col-pad my-propertie-theme">
                            <img src="{{URL::asset('img/properties/my-properties-3.jpg')}}" alt="my-properties-3" class="img-responsive">
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 col-pad">
                            <div class="detail">
                                <!-- Header -->
                                <header class="clearfix">
                                    <div class="pull-left">
                                        <h1 class="title">
                                            <a href="properties-details.html">Park avenue</a>
                                        </h1>
                                        <h3 class="location">
                                            <a href="#">
                                                <i class="fa fa-map-marker"></i>20-21 Kathal St. Tampa City, FL
                                            </a>
                                        </h3>
                                    </div>
                                    <!-- Btn -->
                                    <div class="pull-right">
                                        <a href="#" class="button-sm button-theme">Details</a>
                                    </div>
                                </header>
                                <hr>
                                <p> Morbi accumsan ipsum velit nam nec tellus a odio tincidunt auctor a ornare odio sed none stale mauris vitae erat consequat auctor eu in elit class ap</p>
                            </div>
                            <!-- footer -->
                            <div class="footer clearfix">
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <div class="price">
                                        $900 / monthly
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <div class="date">
                                        jun 30, 2016
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="listing-meta ">
                                    <span>
                                        <a href="#">
                                            <i class="fa fa-pencil"></i>Edit
                                        </a>
                                    </span>
                                    <span>
                                        <a href="#">
                                            <i class="fa fa-eye-slash"></i>Hide
                                        </a>
                                    </span>
                                    <span>
                                        <a href="#">
                                            <i class="fa fa-remove"></i>Delete
                                        </a>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="my-properties-box wow fadeInUp delay-03s clearfix" style="visibility: hidden; animation-name: none;">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 col-pad my-propertie-theme">
                            <img src="{{URL::asset('img/properties/my-properties-4.jpg')}}" alt="my-properties-4" class="img-responsive">
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 col-pad">
                            <div class="detail">
                                <!-- Header -->
                                <header class="clearfix">
                                    <div class="pull-left">
                                        <h1 class="title">
                                            <a href="properties-details.html">Park avenue</a>
                                        </h1>
                                        <h3 class="location">
                                            <a href="#">
                                                <i class="fa fa-map-marker"></i>20-21 Kathal St. Tampa City, FL
                                            </a>
                                        </h3>
                                    </div>
                                    <!-- Btn -->
                                    <div class="pull-right">
                                        <a href="#" class="button-sm button-theme">Details</a>
                                    </div>
                                </header>
                                <hr>
                                <p> Morbi accumsan ipsum velit nam nec tellus a odio tincidunt auctor a ornare odio sed none stale mauris vitae erat consequat auctor eu in elit class ap</p>
                            </div>
                            <!-- footer -->
                            <div class="footer clearfix">
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <div class="price">
                                        $900 / monthly
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <div class="date">
                                        jun 30, 2016
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="listing-meta ">
                                    <span>
                                        <a href="#">
                                            <i class="fa fa-pencil"></i>Edit
                                        </a>
                                    </span>
                                    <span>
                                        <a href="#">
                                            <i class="fa fa-eye-slash"></i>Hide
                                        </a>
                                    </span>
                                    <span>
                                        <a href="#">
                                            <i class="fa fa-remove"></i>Delete
                                        </a>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- My propertiess box end -->
                </div>
            </div>
        </div>
    </div>
    {{--My Properties Page End--}}
@endsection