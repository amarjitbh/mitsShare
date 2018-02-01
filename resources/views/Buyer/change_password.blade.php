@extends('layouts.after_login')

@section('content')

    {{--Change Password Page Start--}}
    <div class="change-password">
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
                                <a href="{{route('buyer-change-password')}}" class="active">
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

                <div class="col-lg-6 col-md-6 col-sm-5">
                    <!-- My address start -->
                    <div class="my-address">
                        <h1>Change Password</h1>

                        <form action="index.html">
                            <div class="form-group">
                                <label>Current Password</label>
                                <input type="password" class="input-text" name="current password" placeholder="Current Password">
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" class="input-text" name="new-password" placeholder="New Password">
                            </div>
                            <div class="form-group">
                                <label>Confirm New Password</label>
                                <input type="password" class="input-text" name="confirm-new-password" placeholder="Confirm New Password">
                            </div>
                            <a href="submit-property.html" class="btn button-md button-theme">Save Changes</a>
                        </form>
                    </div>
                    <!-- My address end -->
                </div>
<!-- 
                <div class="col-lg-3 col-md-3 col-sm-3">
                   
                    <div class="txat">
                        <p>Your password should be at least 12 random characters long to be safe</p>
                    </div>
                </div> -->
            </div>
        </div>
    </div>

    {{--Change Password Page End--}}
@endsection