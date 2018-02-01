<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyAvailaibilityDate extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [ 'is_booked' ];

    /*========================
		Book Property Date
		Param 1 : Property Id
	 ==========================*/
    public function dateBook( $ids ){
         return $this
                ->whereIn( 'id', $ids )
                ->where( array( 'is_booked' => 0 ) )
                ->update( array( 'is_booked' => 1 ) );
    }

    /*======================================================
		Set Is Requested Field = 1 When request For Booking
		Param 1 : Primary keys of property_availaibility_dates
	 =======================================================*/
    public function setIsRequested( $ids ){
        return $this
            ->whereIn( 'id', $ids )
            ->where( array( 'is_requested' => 0 ) )
            ->update( array( 'is_requested' => 1 ) );
    }

    /*========================
		Cancel booking Date
		Param 1 : property_availaibility_dates Id
	 ==========================*/
    public function cancelDates( $ids ){
        return $this
            ->whereIn( 'id', $ids )
            ->update( array( 'is_booked' => 0,'is_requested' => 0  ) );
    }

}
