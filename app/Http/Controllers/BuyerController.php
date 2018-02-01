<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BuyerController extends Controller
{
    /***==== MY PROFILE ====***/
    public function myProfile() {
        return view('Buyer.my_profile');
    }

    /***==== CHANGE PASSWORD ====***/
    public function changePassword() {
        return view('Buyer.change_password');
    }

    /***==== UPCOMING BOOKING ====***/
    public function upcomingBooking() {
        return view('Buyer.upcoming_bookings');
    }

    /***==== PAST BOOKING ====***/
    public function pastBooking() {
        return view('Buyer.past_bookings');
    }
}
