@extends('layouts.after_login')

@section('content')

    {{--My Profile Page Start--}}
    <div class="my-profile">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-4">
                    <!-- My account box start -->
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <!-- My account box start -->
                        <div class="my-account-box">
                            <div class="item">
                                <h3 class="title">
                                    Manage Account
                                </h3>
                                <p>
                                    <a href="{{route('seller-profile')}}" class="active">
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
                                    <a href="{{route('buyer-upcoming-booking')}}">
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
                                    <a href="{{route('buyer-change-password')}}" >
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
                    <!-- My account box end -->
                </div>
                <div class="col-lg-6 col-md-6 col-sm-5">
                    <!-- My address start-->
                    <div class="my-address">
                        <h1>My Account</h1>

                        <form action="#">
                            <div class="form-group">
                                <label>Your Name</label>
                                <input type="text" class="input-text" name="your name" placeholder="John deo">
                            </div>
                            <div class="form-group">
                                <label>Your Title</label>
                                <input type="text" class="input-text" name="agent" placeholder="Your title">
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="input-text" name="phone" placeholder="+55 4XX-634-7071">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="input-text" name="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label>About Me</label>
                                <textarea class="input-text" name="message" placeholder="Etiam luctus malesuada quam eu aliquet. Donec eget mollis tortor. Donec pellentesque eros a nisl euismod, ut congue orci ultricies. Fusce aliquet metus non arcu varius ullamcorper a sit amet nunc. Donec in lacus neque. Vivamus ullamcorper sed ligula vitae "></textarea>
                            </div>
                            <a href="#" class="btn button-md button-theme">Save Changes</a>
                        </form>
                    </div>
                    <!-- My address end -->
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <!-- Avatar start -->
                    <div class="edit-profile-photo">
                        <img src="{{URL::asset('img/agent-1.jpg')}}" alt="agent-1" class="img-responsive">
                        <div class="change-photo-btn">
                            <div class="photoUpload">
                                <span><i class="fa fa-upload"></i> Upload Photo</span>
                                <input type="file" class="upload">
                            </div>
                        </div>
                    </div>
                    <!-- Avatar end -->
                </div>
            </div>
        </div>
    </div>

    {{--My Profile Page End--}}
@endsection