<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Property extends Model
{
    protected $table = 'properties';

    protected $fillable = [
        'timezone_name','property_type_id', 'seller_id', 'lng', 'lat' , 'is_approved_checked', 'policy_types_id'
    ];


    //public function test( $propertyTypesId, $startdate, $enddate, $location, $min_price, $max_price, $filters ){

    /*=====================================================================================================
		Search Property based on property id, Location, Start Date ,End Date, Max Price, Min Price, Filters
        Param 1 : Array($searchData)
        Join : properties_field_values, property_type_section_fields,
   	 ======================================================================================================*/
    public function searchProperties( $searchData ){
        return $this
            ->join('properties_field_values', 'properties_field_values.property_id', '=', 'properties.id')
            ->join('property_type_section_fields','property_type_section_fields.id','=', 'properties_field_values.property_type_section_field_id' )
            ->select('properties.id as propertyIds' ,'properties_field_values.property_type_section_field_value as price')
            ->where(array('property_type_section_fields.field_identifier' => 'basic_price'))
            ->whereExists(function ($query) use ($searchData) {
                $query->select(DB::raw(1))
                    ->from('property_availaibility')
                    ->join('property_availaibility_dates', 'property_availaibility_dates.property_availaibility_id', '=', 'property_availaibility.id')
                    ->where(function($query2) use ( $searchData ) {
                        if( (isset($searchData['startDate'])) && (isset( $searchData['endDate'] ))){
                            $query2->whereBetween('property_availaibility_dates.date', [$searchData['startDate'], $searchData['endDate'] ])
                                ->Where('property_availaibility_dates.is_booked',0);

                        }elseif(isset($searchData['startDate'])){
                            $query2->Where('property_availaibility_dates.date','>=', $searchData['startDate'])
                                ->Where('property_availaibility_dates.is_booked',0);
                        }elseif(isset($searchData['endDate'])){
                            $current_date = getServerUtcTime();
                            $query2->whereBetween('property_availaibility_dates.date', [$current_date, $searchData['endDate'] ])
                                ->Where('property_availaibility_dates.is_booked',0);
                        }
                    })
                    ->whereRaw('property_availaibility.property_id = properties.id');
            })
            ->where(array('properties.property_type_id' => $searchData['propertyTypesId']))
            ->whereExists(function ($query) use ($searchData) {
                $query->select(DB::raw(1))
                ->from('properties_field_values')
                ->join('property_type_section_fields', 'property_type_section_fields.id', '=', 'properties_field_values.property_type_section_field_id')
                ->where(function($query) use ($searchData) {
                    if( (isset($searchData['location']) && (!empty($searchData['location'])) )) {
                        //$array = explode(',', $searchData['location']);
                        /*echo "<pre>";
                        print_r($array);
                        die('here');*/
                        $query->where('field_identifier', '=', 'basic_location')->where('properties_field_values.property_type_section_field_value', 'LIKE', '%'.$searchData['location'].'%');
                    }
                })
                ->where(function($query) use ($searchData) {
                    if( (isset($searchData['minPrice'])) && (isset($searchData['maxPrice'])) && ($searchData['maxPrice']>0) ) {
                        $query->where('field_identifier', '=', 'basic_price')->whereBetween('properties_field_values.property_type_section_field_value', [$searchData['minPrice'], $searchData['maxPrice']]);
                    }
                })
                ->where(function($query) use ($searchData) {
                    if( isset($searchData['filters']) && count($searchData['filters'])) {
                        $query->whereIn('properties_field_values.id', $searchData['filters']);
                    }
                })
                ->whereRaw('properties_field_values.property_id = properties.id');
        });
    }

    /*===================================================
		Get Property of Particular User based on User id
        Param 1 : SellerId
   	=======================================================*/
    public function getProperties($seller_id) {
        return $this->select('properties.id as propertyIds', 'properties.created_at')
                ->where(array('properties.seller_id' => $seller_id));
    }

    /*===================================================
		Get Property of Particular User based on User id
        Param 1 : SellerId
   	=======================================================*/
    public function getPropertyWithPropertyIdAndSellerId($seller_id,$propertyId,$button) {
        return  $this->select('properties.id as propertyIds', 'properties.created_at')
            ->when($button, function($q) use ($seller_id,$propertyId,$button){
                if($button=='next') {
                    $q->where(array('properties.seller_id' => $seller_id))
                        ->where('properties.id', '>', $propertyId);

                }
                if($button=='previous') {
                    return $q->where(array('properties.seller_id' => $seller_id))
                        ->where('properties.id', '<', $propertyId);
                }
            })->first();

    }

    /*====================================================================================================
		Get Property of Particular Property based on User id, This function is executed if no item found
        Param 1 : SellerId
   	========================================================================================================*/
    public function getFirstPropertyWithPropertyIdAndSellerId($seller_id,$propertyId,$button) {
        return  $this->select('properties.id as propertyIds', 'properties.created_at')
            ->when($button, function($q) use ($seller_id,$propertyId,$button){
                if($button=='next') {
                    $q->where(array('properties.seller_id' => $seller_id))
                        ->where('properties.id', '<', $propertyId);

                }
                if($button=='previous') {
                    return $q->where(array('properties.seller_id' => $seller_id))
                        ->where('properties.id', '>', $propertyId);
                }
            })->first();

    }

    /*=============================================================================================
		Get Property Data E.Q. Name, Location, Price, Property Description Based On Property ids
        Param 1 : PropertiesIds (Array)
        Join : properties_field_values, property_type_section_fields,
   	 ==============================================================================================*/
    public function getSellerPropertyRelatedData( $PropertiesIds ){
        return $this
            ->rightjoin('properties_field_values', 'properties_field_values.property_id','=', 'properties.id')
            ->rightjoin('property_type_section_fields', 'property_type_section_fields.id','=', 'properties_field_values.property_type_section_field_id')
            //->join('bookings', 'bookings.property_id','=', 'properties.id')
            ->join('users', 'properties.seller_id', '=', 'users.id')
            ->where(function($q) use($PropertiesIds){
                $q->whereIn('properties_field_values.property_id' , $PropertiesIds);
            })
            ->select('properties.property_type_id','properties.property_type_id','property_type_section_fields.name','properties_field_values.property_type_section_field_value','property_type_section_fields.field_identifier','property_type_section_fields.id as property_type_section_field_id','properties.id','properties_field_values.id as property_filed_value_id','properties_field_values.created_at as created_at', 'users.first_name', 'users.last_name')
           // ->select('properties.property_type_id','property_type_section_fields.name','properties_field_values.property_type_section_field_value','property_type_section_fields.field_identifier','property_type_section_fields.id as property_type_section_field_id','properties.id','properties_field_values.id as property_filed_value_id','properties_field_values.created_at as created_at', 'users.first_name', 'users.last_name', 'bookings.booking_id' )
            ->get()
            ->toArray();


    }

    /*public function testgetSellerPropertyRelatedData( $PropertiesIds ){
        return $this
            ->rightjoin('properties_field_values', 'properties_field_values.property_id','=', 'properties.id')
            ->rightjoin('property_type_section_fields', 'property_type_section_fields.id','=', 'properties_field_values.property_type_section_field_id')
            //->join('bookings', 'bookings.property_id','=', 'properties.id')
            ->join('users', 'properties.seller_id', '=', 'users.id')
            ->where(function($q) use($PropertiesIds){
                $q->where('properties_field_values.property_id' , $PropertiesIds);
            })
            ->select('properties.property_type_id','properties.property_type_id','property_type_section_fields.name','properties_field_values.property_type_section_field_value','property_type_section_fields.field_identifier','property_type_section_fields.id as property_type_section_field_id','properties.id','properties_field_values.id as property_filed_value_id','properties_field_values.created_at as created_at', 'users.first_name', 'users.last_name')
            // ->select('properties.property_type_id','property_type_section_fields.name','properties_field_values.property_type_section_field_value','property_type_section_fields.field_identifier','property_type_section_fields.id as property_type_section_field_id','properties.id','properties_field_values.id as property_filed_value_id','properties_field_values.created_at as created_at', 'users.first_name', 'users.last_name', 'bookings.booking_id' )
            ->get()
            ->toArray();


    }*/


    /*=============================================================================================
		Get Property Data E.Q. Name, Location, Price, Property Description Based On Property ids
        Param 1 : PropertiesIds (Array)
        Join : properties_field_values, property_type_section_fields,
   	 ==============================================================================================*/

    public function getPropertyRelatedData( $PropertiesIds ){
        $placeholders = implode(',',array_fill(0, count($PropertiesIds), '?'));
        return $this
            ->rightjoin('properties_field_values', 'properties_field_values.property_id','=', 'properties.id')
            ->rightjoin('property_type_section_fields', 'property_type_section_fields.id','=', 'properties_field_values.property_type_section_field_id')
            ->join('users', 'properties.seller_id', '=', 'users.id')
            ->whereIn('properties_field_values.property_id' , $PropertiesIds)->orderByRaw("field(properties_field_values.property_id,{$placeholders})", $PropertiesIds)
            ->select('properties.seller_id','properties.property_type_id','property_type_section_fields.name','properties_field_values.property_type_section_field_value','property_type_section_fields.field_identifier','property_type_section_fields.id as property_type_section_field_id','properties.id','properties_field_values.id as property_filed_value_id', 'properties.created_at as created_at', 'users.first_name', 'users.last_name' )
            ->get()
            ->toArray();
    }


    /*===========================================================================================================
		Get Property Data E.Q. Name, Location, Price, Property Description, Booking Dates  Based On Property ids
        Param 1 : PropertiesIds (Array), UserId
        Join : properties_field_values, property_type_section_fields, bookings, booking_dates
   	 =============================================================================================================*/
    public function getPastBookingPropertyData( $bookingsIds, $userId ){
        $current_date = getServerUtcTime();
        return $this
            ->rightjoin('properties_field_values', 'properties_field_values.property_id','=', 'properties.id')
            ->rightjoin('property_type_section_fields', 'property_type_section_fields.id','=', 'properties_field_values.property_type_section_field_id')
            ->join('bookings', 'bookings.property_id','=', 'properties.id')
            ->join('users', 'bookings.property_owner_id','=', 'users.id')
            ->join('booking_dates', 'bookings.booking_id','=', 'booking_dates.booking_id')
            ->where(array('bookings.user_id' => $userId ))
            ->Where('booking_dates.date','<', $current_date)
           ->where(function($q) use($bookingsIds){
                $q->whereIn('bookings.booking_id' , $bookingsIds);
                $q->where('property_type_section_fields.field_identifier','!=', null);
            })
        ->select('bookings.payment_status','bookings.property_owner_id','bookings.is_approved','users.email','users.mobile_number','users.id as buyerId','users.first_name','users.last_name','property_type_section_fields.name','properties_field_values.property_type_section_field_value','property_type_section_fields.field_identifier','property_type_section_fields.id as property_type_section_field_id','properties.id','properties_field_values.id as property_filed_value_id','properties_field_values.created_at as created_at', 'booking_dates.date as upcoming_date', 'booking_dates.booking_date_id', 'bookings.booking_id', 'bookings.total_amount' )
        ->get()
        ->toArray();
    }

    /*===========================================================================================================
		Get Property Data E.Q. Name, Location, Price, Property Description, Booking Dates  Based On Property ids
        Param 1 : PropertiesIds (Array), UserId
        Join : properties_field_values, property_type_section_fields, bookings, booking_dates
   	 =============================================================================================================*/
    public function getBookedPastBookingPropertyData( $bookingsIds, $userId ){
        $current_date = getServerUtcTime();
        return $this
            ->rightjoin('properties_field_values', 'properties_field_values.property_id','=', 'properties.id')
            ->rightjoin('property_type_section_fields', 'property_type_section_fields.id','=', 'properties_field_values.property_type_section_field_id')
            ->join('bookings', 'bookings.property_id','=', 'properties.id')
            ->join('booking_dates', 'bookings.booking_id','=', 'booking_dates.booking_id')
            ->join('users', 'bookings.user_id','=', 'users.id')
            ->where(array('bookings.property_owner_id' => $userId ))
            ->Where('booking_dates.date','<', $current_date)
           ->where(function($q) use($bookingsIds){
                $q->whereIn('bookings.booking_id' , $bookingsIds);
                $q->where('property_type_section_fields.field_identifier','!=', null);
            })
            ->select('bookings.payment_status','bookings.property_owner_id','bookings.is_approved','users.email','users.mobile_number','users.id as buyerId','users.first_name','users.last_name','property_type_section_fields.name','properties_field_values.property_type_section_field_value','property_type_section_fields.field_identifier','property_type_section_fields.id as property_type_section_field_id','properties.id','properties_field_values.id as property_filed_value_id','properties_field_values.created_at as created_at', 'booking_dates.date as upcoming_date', 'booking_dates.booking_date_id', 'bookings.booking_id', 'bookings.total_amount' )
            ->get()
            ->toArray();
    }

    /*==========================================================================================================
		Get Property Data E.Q. Name, Location, Price, Property Description, Booking Dates Based On Property ids
        Param 1 : PropertiesIds (Array) , userId
        Join : properties_field_values, property_type_section_fields, bookings, booking_dates
   	 ===========================================================================================================*/
    public function getUpcomingBookingPropertyData( $bookingsIds, $userId ){
        $current_date = getServerUtcTime();
        return $this
            ->rightjoin('properties_field_values', 'properties_field_values.property_id','=', 'properties.id')
            ->rightjoin('property_type_section_fields', 'property_type_section_fields.id','=', 'properties_field_values.property_type_section_field_id')
            ->join('bookings', 'bookings.property_id','=', 'properties.id')
            ->join('booking_dates', 'bookings.booking_id','=', 'booking_dates.booking_id')
            ->join('users', 'bookings.property_owner_id','=', 'users.id')
            ->where(array('bookings.user_id' => $userId,'bookings.is_approved' => 1,'bookings.payment_status' => 1 ))
            ->Where('booking_dates.date','>=', $current_date)
            ->where(function($q) use($bookingsIds){
                $q->whereIn('bookings.booking_id' , $bookingsIds);
                $q->where('property_type_section_fields.field_identifier','!=', null);
            })
            ->select('bookings.payment_status','bookings.property_owner_id','users.email','users.mobile_number','users.id as buyerId','users.first_name','users.last_name','property_type_section_fields.name','properties_field_values.property_type_section_field_value','property_type_section_fields.field_identifier','property_type_section_fields.id as property_type_section_field_id','properties.id','properties_field_values.id as property_filed_value_id','properties_field_values.created_at as created_at', 'booking_dates.date as upcoming_date', 'booking_dates.booking_date_id', 'bookings.booking_id', 'bookings.total_amount' ,'bookings.is_approved')
            ->get()
            ->toArray();
    }


    /*==========================================================================================================
        Get Property Data E.Q. Name, Location, Price, Property Description, Booking Dates Based On Property ids
        Param 1 : PropertiesIds (Array) , userId
        Join : properties_field_values, property_type_section_fields, bookings, booking_dates
     ===========================================================================================================*/
    public function getApproveBookingPropertyData( $bookingsIds, $userId ){
        $current_date = getServerUtcTime();
        return $this
            ->rightjoin('properties_field_values', 'properties_field_values.property_id','=', 'properties.id')
            ->rightjoin('property_type_section_fields', 'property_type_section_fields.id','=', 'properties_field_values.property_type_section_field_id')
            ->join('bookings', 'bookings.property_id','=', 'properties.id')
            ->join('booking_dates', 'bookings.booking_id','=', 'booking_dates.booking_id')
            ->join('users', 'bookings.property_owner_id','=', 'users.id')
            ->where(array('bookings.user_id' => $userId ,'bookings.is_approved' => 1,'bookings.through_approval' => 1,'bookings.payment_status' => 0))
            ->Where('booking_dates.date','>=', $current_date)
            ->where(function($q) use($bookingsIds){
                $q->whereIn('bookings.booking_id' , $bookingsIds);
                $q->where('property_type_section_fields.field_identifier','!=', null);
            })
            ->select('bookings.payment_status','bookings.property_owner_id','users.email','users.mobile_number', 'users.id as buyerId','users.first_name','users.last_name', 'property_type_section_fields.name','properties_field_values.property_type_section_field_value','property_type_section_fields.field_identifier','property_type_section_fields.id as property_type_section_field_id','properties.id','properties_field_values.id as property_filed_value_id','properties_field_values.created_at as created_at', 'booking_dates.date as upcoming_date', 'booking_dates.booking_date_id', 'bookings.booking_id', 'bookings.total_amount' ,'bookings.is_approved')
            ->get()
            ->toArray();
    }
    /*==========================================================================================================
		Get Property Data E.Q. Name, Location, Price, Property Description, Booking Dates Based On Property ids
        Param 1 : PropertiesIds (Array) , userId
        Join : properties_field_values, property_type_section_fields, bookings, booking_dates
   	 ===========================================================================================================*/
    public function getBookedUpcomingBookingPropertyData( $bookingsIds, $userId ){
        $current_date = getServerUtcTime();
        return $this
            ->rightjoin('properties_field_values', 'properties_field_values.property_id','=', 'properties.id')
            ->rightjoin('property_type_section_fields', 'property_type_section_fields.id','=', 'properties_field_values.property_type_section_field_id')
            ->join('bookings', 'bookings.property_id','=', 'properties.id')
            ->join('booking_dates', 'bookings.booking_id','=', 'booking_dates.booking_id')
            ->join('users', 'bookings.user_id','=', 'users.id')
            ->where(array('bookings.property_owner_id' => $userId ,'bookings.is_approved' => 1,'bookings.payment_status' => 1 ))
            ->Where('booking_dates.date','>=', $current_date)
            ->where(function($q) use($bookingsIds){
                $q->whereIn('bookings.booking_id' , $bookingsIds);
                $q->where('property_type_section_fields.field_identifier','!=', null);
            })
            ->select('bookings.payment_status','bookings.property_owner_id','users.email','users.mobile_number','users.id as buyerId','users.first_name','users.last_name','property_type_section_fields.name','properties_field_values.property_type_section_field_value','property_type_section_fields.field_identifier','property_type_section_fields.id as property_type_section_field_id','properties.id','properties_field_values.id as property_filed_value_id','properties_field_values.created_at as created_at', 'booking_dates.date as upcoming_date', 'booking_dates.booking_date_id', 'bookings.booking_id','bookings.is_approved', 'bookings.total_amount' )
            ->get()
            ->toArray();
    }

    /*==========================================================================================================
        Get Property Data E.Q. Name, Location, Price, Property Description, Booking Dates Based On Property ids
        Param 1 : PropertiesIds (Array) , userId
        Join : properties_field_values, property_type_section_fields, bookings, booking_dates
     ===========================================================================================================*/
    public function getBookedApproveBookingPropertyData( $bookingsIds, $userId ){
        $current_date = getServerUtcTime();
        return $this
            ->rightjoin('properties_field_values', 'properties_field_values.property_id','=', 'properties.id')
            ->rightjoin('property_type_section_fields', 'property_type_section_fields.id','=', 'properties_field_values.property_type_section_field_id')
            ->join('bookings', 'bookings.property_id','=', 'properties.id')
            ->join('users', 'bookings.user_id','=', 'users.id')
            ->join('booking_dates', 'bookings.booking_id','=', 'booking_dates.booking_id')
            ->where(array('bookings.property_owner_id' => $userId ,'bookings.is_approved' => 1,'bookings.through_approval' => 1,'bookings.payment_status' => 0))
            ->Where('booking_dates.date','>=', $current_date)
            ->where(function($q) use($bookingsIds){
                $q->whereIn('bookings.booking_id' , $bookingsIds);
                $q->where('property_type_section_fields.field_identifier','!=', null);
            })
            ->select('bookings.payment_status','bookings.property_owner_id','users.email','users.mobile_number','users.id as buyerId','users.first_name','users.last_name','property_type_section_fields.name','properties_field_values.property_type_section_field_value','property_type_section_fields.field_identifier','property_type_section_fields.id as property_type_section_field_id','properties.id','properties_field_values.id as property_filed_value_id','properties_field_values.created_at as created_at', 'booking_dates.date as upcoming_date', 'booking_dates.booking_date_id', 'bookings.booking_id','bookings.is_approved', 'bookings.total_amount' )
            ->get()
            ->toArray();
    }

   

    public function getBookedPendingBookingPropertyData( $bookingsIds, $propertyOwnerId ){
      
        $current_date = getServerUtcTime();
        return $this
            ->rightjoin('properties_field_values', 'properties_field_values.property_id','=', 'properties.id')
            ->rightjoin('property_type_section_fields', 'property_type_section_fields.id','=', 'properties_field_values.property_type_section_field_id')
            ->join('bookings', 'bookings.property_id','=', 'properties.id')
            ->join('booking_dates', 'bookings.booking_id','=', 'booking_dates.booking_id')
            ->join('users', 'bookings.user_id','=', 'users.id')
            ->where(array('bookings.property_owner_id' => $propertyOwnerId ,'bookings.is_approved' => 0,'bookings.through_approval' => 1))
            //->Where('booking_dates.date','>=', $current_date)
            ->where(function($q) use($bookingsIds){
                $q->whereIn('bookings.booking_id' , $bookingsIds);
                $q->where('property_type_section_fields.field_identifier','!=', null);
            })
            ->select('bookings.payment_status','bookings.property_owner_id','users.email','users.mobile_number','users.id as buyerId','users.first_name','users.last_name','property_type_section_fields.name','properties_field_values.property_type_section_field_value','property_type_section_fields.field_identifier','property_type_section_fields.id as property_type_section_field_id','properties.id','properties_field_values.id as property_filed_value_id','properties_field_values.created_at as created_at', 'booking_dates.date as upcoming_date', 'booking_dates.booking_date_id', 'bookings.booking_id','bookings.is_approved', 'bookings.total_amount' )
            ->get()
            ->toArray();
    }

     public function getPendingBookingPropertyData( $bookingsIds, $userId ){
       $current_date = getServerUtcTime();
        return $this
            ->rightjoin('properties_field_values', 'properties_field_values.property_id','=', 'properties.id')
            ->rightjoin('property_type_section_fields', 'property_type_section_fields.id','=', 'properties_field_values.property_type_section_field_id')
            ->join('bookings', 'bookings.property_id','=', 'properties.id')
            ->join('booking_dates', 'bookings.booking_id','=', 'booking_dates.booking_id')
            ->join('users', 'bookings.property_owner_id','=', 'users.id')
            ->where(array('bookings.user_id' => $userId ,'bookings.is_approved' => 0,'bookings.through_approval' => 1))
            //->Where('booking_dates.date','>=', $current_date)
            ->where(function($q) use($bookingsIds){
                $q->whereIn('bookings.booking_id' , $bookingsIds);
                $q->where('property_type_section_fields.field_identifier','!=', null);
            })
            ->select('bookings.payment_status','bookings.property_owner_id','users.email','users.mobile_number','users.id as buyerId','users.first_name','users.last_name', 'property_type_section_fields.name','properties_field_values.property_type_section_field_value','property_type_section_fields.field_identifier','property_type_section_fields.id as property_type_section_field_id','properties.id','properties_field_values.id as property_filed_value_id','properties_field_values.created_at as created_at', 'booking_dates.date as upcoming_date', 'booking_dates.booking_date_id', 'bookings.booking_id','bookings.is_approved', 'bookings.total_amount' )
            ->get()
            ->toArray();
    }

     public function getBookedRejectedBookingPropertyData( $bookingsIds, $userId ){
        //$current_date = getServerUtcTime();
        return $this
            ->rightjoin('properties_field_values', 'properties_field_values.property_id','=', 'properties.id')
            ->rightjoin('property_type_section_fields', 'property_type_section_fields.id','=', 'properties_field_values.property_type_section_field_id')
            ->join('bookings', 'bookings.property_id','=', 'properties.id')
            ->join('booking_dates', 'bookings.booking_id','=', 'booking_dates.booking_id')
            ->join('users', 'bookings.user_id','=', 'users.id')
            ->where(array('bookings.property_owner_id' => $userId ,'bookings.is_approved' => 2,'bookings.through_approval' => 1))
            //->Where('booking_dates.date','>=', $current_date)
            ->where(function($q) use($bookingsIds){
                $q->whereIn('bookings.booking_id' , $bookingsIds);
                $q->where('property_type_section_fields.field_identifier','!=', null);
            })
            ->select('bookings.payment_status','bookings.property_owner_id','users.email','users.mobile_number','users.id as buyerId','users.first_name','users.last_name','property_type_section_fields.name','properties_field_values.property_type_section_field_value','property_type_section_fields.field_identifier','property_type_section_fields.id as property_type_section_field_id','properties.id','properties_field_values.id as property_filed_value_id','properties_field_values.created_at as created_at', 'booking_dates.date as upcoming_date', 'booking_dates.booking_date_id', 'bookings.booking_id','bookings.is_approved', 'bookings.total_amount' )
            ->get()
            ->toArray();
    }



 public function getRejectedBookingPropertyData( $bookingsIds, $userId ){

        //$current_date = getServerUtcTime();
        return $this
            ->rightjoin('properties_field_values', 'properties_field_values.property_id','=', 'properties.id')
            ->rightjoin('property_type_section_fields', 'property_type_section_fields.id','=', 'properties_field_values.property_type_section_field_id')
            ->join('bookings', 'bookings.property_id','=', 'properties.id')
            ->join('booking_dates', 'bookings.booking_id','=', 'booking_dates.booking_id')
            ->join('users', 'bookings.property_owner_id','=', 'users.id')
            ->where(array('bookings.user_id' => $userId ,'bookings.is_approved' => 2,'bookings.through_approval' => 1))
            //->Where('booking_dates.date','>=', $current_date)
            ->where(function($q) use($bookingsIds){
                $q->whereIn('bookings.booking_id' , $bookingsIds);
                $q->where('property_type_section_fields.field_identifier','!=', null);
            })
            ->select('bookings.payment_status','bookings.property_owner_id','users.email','users.mobile_number', 'users.id as buyerId','users.first_name','users.last_name', 'property_type_section_fields.name','properties_field_values.property_type_section_field_value','property_type_section_fields.field_identifier','property_type_section_fields.id as property_type_section_field_id','properties.id','properties_field_values.id as property_filed_value_id','properties_field_values.created_at as created_at', 'booking_dates.date as upcoming_date', 'booking_dates.booking_date_id', 'bookings.booking_id','bookings.is_approved', 'bookings.total_amount' )
            ->get()
            ->toArray();
    }

    

    public function getOwnProperty( $propertyId, $userId ){
        return $this
            ->where(array('properties.id'=> $propertyId, 'properties.seller_id' => $userId ))
            ->first();

    }



   /* public function getByDistance($lat, $lng, $distance){
        $results = DB::select(DB::raw('SELECT id,lat,lng, ( 6371 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat .') ) * sin( radians(lat) ) ) ) AS distance FROM properties HAVING distance <= ' . $distance . ' ORDER BY distance') );
        //->select(\DB::raw("((ACOS( SIN( " . $latitude . "  PI( ) /180 )  SIN( latitude * PI( ) /180 ) + COS( " . $latitude . "  PI( ) /180 )  COS( latitude  PI( ) /180 ) COS( ( " . $longitude . " - longitude ) * PI( ) /180 )) *180 / PI( )) 60  1.1515 * 1.609344) AS distance"),'pharmacy_detail_id', 'pocket_clinic_users.my_channel');
        return $results;
    }*/

    /*public function getByDistance($lat, $lng, $distance){
        return $this
            ->select(\DB::raw("( 6371 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat .') ) * sin( radians(lat) ) ) ) AS distance"),'properties.id', 'lat','lng' )
            //->having('distance', '<=', $distance)
            ->get()
            ->toArray();
    }*/

    public function getByDistance($lat, $lng, $distance){
        return $this
            ->select(\DB::raw("( 6371 * acos( cos( radians(" . $lat . ") ) * cos( radians(lat) ) *
            cos( radians(lng) - radians(" . $lng . ") ) + sin( radians(" . $lat . ") ) *
            sin( radians(lat) ) ) ) AS distance"))
            ->when($distance, function($query) use ($distance){
                return $query->having('distance', '<=', $distance);
            })
            ->get()
            ->toArray();
    }

/******************** Get property approve status *******************/

     public function getApprovedStatus( $propertyId ){
        return $this
            ->where(array('id' => $propertyId))
            ->select('*')
             ->first();
            
    }

    public function getSellerId($propertyId){
        return $this
            ->where(array('id' => $propertyId))
            ->value('seller_id');
    }


}
