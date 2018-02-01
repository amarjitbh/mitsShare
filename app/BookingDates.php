<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingDates extends Model
{
    protected $table = 'booking_dates';
    protected $fillable = ['booking_id', 'date'];
}
