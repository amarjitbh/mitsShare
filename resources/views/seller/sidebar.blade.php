 <!-- My account box start -->
<div class="col-lg-3 col-md-3 col-sm-4">
    <div class="my-account-box ">


        <div class="item">
            <h3 class="title">
                My Properties as Owner
            </h3>
            <p>
                <a href="{{route('seller-properties')}}" class="@if(isset($active) && $active == 'myProperty') active @endif">
                    <i class="fi flaticon-apartment"></i>My Properties @if(listCounting(Auth::user()->id,'myProperty')>0)<span class="badge">{{listCounting(Auth::user()->id,'myProperty')}}</span>@endif
                </a>
            </p>
            <p>
                <a href="{{route('property_information')}}">
                    <i class="fa fa-plus"></i>Submit New Property
                </a>
            </p>
            <p>
                <a href="{{route('booked-upcoming-properties')}}" class="@if(isset($active) && $active == 'bookedUpcomingProperties') active @endif">
                    <i class="fa fa-calendar"></i>Upcoming Bookings @if(listCounting(Auth::user()->id,'bookedUpcomingProperties')>0)<span class="badge">{{listCounting(Auth::user()->id,'bookedUpcomingProperties')}}</span>@endif
                </a>
            </p>
            <p>
                <a href="{{route('pending-approval-booking-properties')}}" class="@if(isset($active) && $active == 'bookedPendingBookingProperties') active @endif">
                    <i class="fa fa-clock-o"></i>Unconfirmed Bookings @if(listCounting(Auth::user()->id,'bookedPendingBookingProperties')>0)<span class="badge">{{listCounting(Auth::user()->id,'bookedPendingBookingProperties')}}</span>@endif
                </a>
            </p>

            <p>
                <a href="{{route('approved-booking-properties')}}" class="@if(isset($active) && $active == 'bookedApproveProperties') active @endif">
                    <i class="fa fa-calendar-check-o"></i>Confirmed Bookings @if(listCounting(Auth::user()->id,'bookedApproveProperties')>0)<span class="badge">{{listCounting(Auth::user()->id,'bookedApproveProperties')}}</span>@endif
                </a>
            </p>
            <p>
                <a href="{{route('rejected-approval-booking-properties')}}" class="@if(isset($active) && $active == 'bookedRejectedBookingProperties') active @endif">
                    <i class="fa fa-calendar-times-o"></i>Rejected Booking  @if(listCounting(Auth::user()->id,'bookedRejectedBookingProperties')>0)<span class="badge">{{listCounting(Auth::user()->id,'bookedRejectedBookingProperties')}}</span>@endif
                </a>
            </p>
            <p>
                <a href="{{route('booked-past-booking-properties')}}" class="@if(isset($active) && $active == 'bookedPastBookingProperties') active @endif">
                    <i class="fa fa-history"></i>Past Bookings @if(listCounting(Auth::user()->id,'bookedPastBookingProperties')>0)<span class="badge">{{listCounting(Auth::user()->id,'bookedPastBookingProperties')}}</span>@endif
                </a>
            </p>


        </div>
        <div class="item">
            <h3 class="title">
                My Properties as Guest
            </h3>
            <p>
                <a href="{{route('upcoming-properties')}}" class="@if(isset($active) && $active == 'upcomingProperties') active @endif">
                    <i class="fa fa-calendar"></i>Upcoming Bookings @if(listCounting(Auth::user()->id,'upcomingProperties')>0)<span class="badge">{{listCounting(Auth::user()->id,'upcomingProperties')}}</span>@endif
                </a>
            </p>
             <p>
                <a href="{{route('pending-properties')}}" class="@if(isset($active) && $active == 'pendingProperties') active @endif">
                    <i class="fa fa-clock-o"></i>Unconfirmed Bookings @if(listCounting(Auth::user()->id,'pendingProperties')>0)<span class="badge">{{listCounting(Auth::user()->id,'pendingProperties')}}</span>@endif
                </a>
            </p>

            <p>
                <a href="{{route('approved-properties')}}" class="@if(isset($active) && $active == 'approveProperties') active @endif">
                    <i class="fa fa-calendar-check-o"></i>Confirmed Bookings @if(listCounting(Auth::user()->id,'approveProperties')>0)<span class="badge">{{listCounting(Auth::user()->id,'approveProperties')}}</span>@endif
                </a>
            </p>
              <p>
                <a href="{{route('rejected-booking-properties')}}" class="@if(isset($active) && $active == 'rejectedBookingProperties') active @endif">
                    <i class="fa fa-calendar-times-o"></i>Rejected Bookings @if(listCounting(Auth::user()->id,'rejectedBookingProperties')>0)<span class="badge">{{listCounting(Auth::user()->id,'rejectedBookingProperties')}}</span>@endif
                </a>
            </p>


            <p>
                <a href="{{route('past-booking-properties')}}" class="@if(isset($active) && $active == 'pastBookingProperties') active @endif">
                    <i class="fa fa-history"></i>Past Bookings @if(listCounting(Auth::user()->id,'pastBookingProperties')>0)<span class="badge">{{listCounting(Auth::user()->id,'pastBookingProperties')}}</span> @endif
                </a>
            </p>

        </div>
        <div class="item">
            <h3 class="title">
                Manage Account
            </h3>
            <p >

                <a href="{{route('seller-profile')}}" class="@if(isset($active) && $active == 'myProfile') active @endif">
                    <i class="fi fi flaticon-social"></i>My Profile
                </a>
            </p>
            <p>
                <a href="{{route('seller-change-password-view')}}" class="@if(isset($active) && $active == 'changePassword') active @endif">
                    <i class="fi flaticon-security"></i>Change Password
                </a>
            </p>
            <p>
                <a href="{{route('review-from-seller')}}" class="@if(isset($active) && $active == 'reviewFromSeller') active @endif">
                    <i class="fa fa-star-o"></i>Review From Seller
                </a>
            </p>

            <p>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="fi flaticon-sign-out-option"></i> Logout
                </a>
            </p>
        </div>
        <div class="item">
            {{--<p>
                <a href="{{route('seller-change-password-view')}}" class="@if(isset($active) && $active == 'changePassword') active @endif">
                    <i class="fi flaticon-security"></i>Change Password
                </a>
            </p>
            <p>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                <i class="fi flaticon-sign-out-option"></i> Logout
            </a>
            </p>--}}
        </div>
    </div>
</div>
<!-- My account box end -->