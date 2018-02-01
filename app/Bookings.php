<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Bookings extends Model {
    protected $table = 'bookings';
    protected $fillable = ['utc_time','through_approval','policy_id','is_approved','booking_id', 'property_id', 'user_id', 'total_amount', 'payment_status', 'property_owner_id'];

    /*===============================================
		Get Property Booking Dates Using Property id
		Param 1 : Property Id
        Join With  : booking_dates
    ===================================================*/
    public function getBookingDates( $propertyId ){
        return $this
            ->join('booking_dates', 'bookings.booking_id','=','booking_dates.booking_id')
            ->where(array('bookings.property_id' => $propertyId))
            ->select('booking_dates.date')
            ->get()
            ->toArray();
    }



  /*===============================================
        Get Property Booking Dates Using booking id
        Param 1 : Property Id
        Join With  : booking_dates
    ===================================================*/
    public function getBookingDatesByBookingID( $bookingId ){
        return $this
            ->join('booking_dates', 'bookings.booking_id','=','booking_dates.booking_id')
            ->where(array('bookings.booking_id' => $bookingId))
            ->select('booking_dates.date')
            ->get()
            ->toArray();
    }


 /*===============================================
        Get Property Booking policy  Using booking id
        Param 1 : booking Id
        Join With  : properties
    ===================================================*/
    public function getPolicyRecord( $bookingId ){
       return $this
            ->leftjoin('cancellation_policy', 'bookings.policy_id','=','cancellation_policy.id')
           // ->join('booking_dates', 'bookings.booking_id','=','booking_dates.booking_id')
            ->where(array('bookings.booking_id' => $bookingId))
            ->select('bookings.property_owner_id','bookings.policy_id','cancellation_policy.id','cancellation_policy.duration','bookings.is_approved','bookings.property_id')
             ->first()
            ->toArray();
    }
    

   
    
    /*==============================
		Get UpComing Properties
		Param 1 : User Id
        Join With  : booking_dates
    ================================*/
    public function getUpcomingProperties( $userId ){
        $current_date = getServerUtcTime();
        return $this
               ->join( 'booking_dates', 'bookings.booking_id', '=','booking_dates.booking_id' )
               ->where( array( 'bookings.user_id' =>$userId ,'bookings.is_approved' => 1,'bookings.payment_status' => 1) )
               ->Where('booking_dates.date','>=', $current_date)
               ->select( 'bookings.booking_id', 'bookings.property_id' )
               ->groupBy('bookings.booking_id');

    }

    /*==============================
        Get Apporove Properties for user
        Param 1 : User Id
        Join With  : booking_dates
    ================================*/
    public function getApproveProperties( $useId ){
         $current_date = getServerUtcTime();
        return $this
               ->join( 'booking_dates', 'bookings.booking_id', '=','booking_dates.booking_id' )
               ->where( array( 'bookings.user_id' =>$useId ,'bookings.is_approved' => 1,'bookings.through_approval' => 1) )
               ->Where('booking_dates.date','>=', $current_date)
               ->select( 'bookings.booking_id', 'bookings.property_id' )
               ->groupBy('bookings.booking_id');

    }


    /*==============================
		Get UpComing Properties
		Param 1 : User Id
        Join With  : booking_dates
    ================================*/
    public function getBookedUpcomingProperties( $useId ){
        $current_date = getServerUtcTime();
        return $this
            ->join( 'booking_dates', 'bookings.booking_id', '=','booking_dates.booking_id'  )
            ->where( array( 'bookings.property_owner_id' =>$useId ,'bookings.is_approved' => 1,'bookings.payment_status' => 1 ) )
            ->Where('booking_dates.date','>=', $current_date)
            ->select( 'bookings.booking_id', 'bookings.property_id' )
            ->groupBy('bookings.booking_id');

    }

     /*==============================
        Get Approve Properties
        Param 1 : User Id
        Join With  : booking_dates
    ================================*/
    public function getBookedApproveProperties( $useId,$bookingId = null){
        $current_date = getServerUtcTime();
        return $this
            ->join( 'booking_dates', 'bookings.booking_id', '=','booking_dates.booking_id'  )
            ->where( array( 'bookings.property_owner_id' =>$useId ,
                'bookings.is_approved' => 1,'bookings.through_approval' => 1 ) )
            ->where(function($q) use ($bookingId){
                if(!empty($bookingId)) {

                    $q->where(['bookings.booking_id' => $bookingId]);
                }
            })
            ->Where('booking_dates.date','>=', $current_date)
            ->select( 'bookings.booking_id', 'bookings.property_id' )
            ->groupBy('bookings.booking_id');

    }


    /*==============================
        Get Pending Properties
        Param 1 : User Id
        Join With  : booking_dates
    ================================*/
    public function getBookedPendingProperties( $userId ){
         $current_date = getServerUtcTime();
        return $this
            ->join( 'booking_dates', 'bookings.booking_id', '=','booking_dates.booking_id'  )
            ->where( array( 'bookings.property_owner_id' =>$userId ,'bookings.is_approved' => 0,'bookings.through_approval' => 1 ) )
           // ->Where('booking_dates.date','>=', $current_date)
            ->select( 'bookings.booking_id', 'bookings.property_id' )
            ->groupBy('bookings.booking_id');

    }
   /*==============================
        Get Pending Properties
        Param 1 : User Id
        Join With  : booking_dates
    ================================*/
    public function getPendingProperties( $useId ){
        $current_date = getServerUtcTime();
        return $this
                ->join( 'booking_dates', 'bookings.booking_id', '=','booking_dates.booking_id' )
               ->where( array( 'bookings.user_id' =>$useId ,'bookings.is_approved' => 0,'bookings.through_approval' => 1 ) )
               //->Where('booking_dates.date','>=', $current_date)
               ->select( 'bookings.booking_id', 'bookings.property_id' )
               ->groupBy('bookings.booking_id');

    }

    /*==============================
        Get Rejected Booking
        Param 1 : User Id
        Join With  : booking_dates
    ================================*/
    public function getBookedRejectedProperties( $useId ){
        return $this
            ->join( 'booking_dates', 'bookings.booking_id', '=','booking_dates.booking_id'  )
            ->where( array( 'bookings.property_owner_id' =>$useId ,'bookings.is_approved' => 2,'bookings.through_approval' => 1 ) )
            ->select( 'bookings.booking_id', 'bookings.property_id' )
            ->groupBy('bookings.booking_id');

    }

 public function getRejectedProperties( $useId ){
        return $this
            ->join( 'booking_dates', 'bookings.booking_id', '=','booking_dates.booking_id'  )
            ->where( array( 'bookings.user_id' =>$useId ,'bookings.is_approved' => 2,'bookings.through_approval' => 1 ) )
            ->select( 'bookings.booking_id', 'bookings.property_id' )
            ->groupBy('bookings.booking_id');

    }

    /*==============================
		Get UpComing Properties
		Param 1 : "User Id
        Join With  : booking_dates
    ================================*/
    public function getPastBookingProperties( $useId ){
        $current_date = getServerUtcTime();
        return $this
            ->join( 'booking_dates', 'bookings.booking_id', '=','booking_dates.booking_id' )
            ->where( array( 'bookings.user_id' =>$useId,'bookings.payment_status' => 1 ) )
            ->Where('booking_dates.date','<', $current_date)
            ->select( 'bookings.booking_id', 'bookings.property_id' )
            ->groupBy('bookings.booking_id');
    }

    /*==============================
		Get UpComing Properties
		Param 1 : "User Id
        Join With  : booking_dates
    ================================*/
    public function getBookedPastBookingProperties( $useId ){
        $current_date = getServerUtcTime();
        return $this
            ->join( 'booking_dates', 'bookings.booking_id', '=','booking_dates.booking_id' )
            ->where( array( 'bookings.property_owner_id' =>$useId,'bookings.payment_status' => 1 ) )
            ->Where('booking_dates.date','<', $current_date)
            ->select( 'bookings.booking_id', 'bookings.property_id' )
            ->groupBy('bookings.booking_id');
    }

    /*public function getUpcomingProperties( $useId ){
        $current_date = getServerUtcTime();
        return $this
            ->join( 'booking_dates', 'bookings.booking_id', '=','booking_dates.booking_id' )
            ->where( array( 'bookings.user_id' =>$useId ) )
            ->Where('booking_dates.date','>=', $current_date)
            ->select( 'bookings.booking_id', 'bookings.property_id', 'booking_dates.date' )
            ->groupBy('bookings.booking_id');

    }*/

    

}
