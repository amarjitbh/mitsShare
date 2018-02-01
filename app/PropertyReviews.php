<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyReviews extends Model
{
    protected $table = 'property_reviews';

    protected $fillable = [
        'property_id', 'rating_from_user', 'rating_to_user', 'rating', 'reason_for_rating', 'comments', 'comment_type', 'booking_id'
    ];


    /*===========================================
		Get Property Review With user information
		Param 1 : Property Id
        Join : User
     =============================================*/
    public  function getReviewOfBuyer( $propertyId ){
        return $this
            ->leftjoin('users', 'users.id', 'property_reviews.rating_from_user' )
            ->where(array('property_reviews.property_id' => $propertyId, 'property_reviews.comment_type' => 1 ))
            ->select( 'property_reviews.comments', 'property_reviews.rating', 'property_reviews.reason_for_rating', 'property_reviews.created_at', 'users.id as user_id','users.first_name', 'users.last_name', 'users.image')
            ->orderBy('property_reviews.created_at', 'DESC')
            ->take(6)
            ->get()
            ->toArray();
    }

    /*===========================================
		Get Property Review With user information
		Param 1 : Property Id
        Join : User
     =============================================*/
    public  function getTotalReviewOfBuyer( $propertyId ){
        return $this
            ->where(array('property_reviews.property_id' => $propertyId, 'property_reviews.comment_type' => 1 ))
            ->select( 'property_reviews.rating')
            ->get()
            ->toArray();
    }

    /*===========================================
		Get Booking id of Buyer
        Param 1 : $propertyId , $userId, $bookingId
     =============================================*/
    public  function getBookingId( $propertyId , $userId, $bookingId ){
        return $this
            ->where(array('property_reviews.property_id' => $propertyId, 'property_reviews.comment_type' => 1, 'property_reviews.rating_from_user'=>$userId, 'property_reviews.booking_id'=>$bookingId ))
            ->value('booking_id');
    }

    /*===========================================
		Get Booking id of Buyer
        Param 1 : $propertyId , $userId, $bookingId
     =============================================*/
    public  function getIdReviewOfSeller( $propertyId , $userId, $bookingId ){
        return $this
            ->where(array('property_reviews.property_id' => $propertyId, 'property_reviews.comment_type' => 2, 'property_reviews.rating_from_user'=>$userId, 'property_reviews.booking_id'=>$bookingId ))
            ->value('booking_id');
    }



    /*===========================================
		Get Property Review With user information
		Param 1 : Property Id
        Join : User
     =============================================*/
    public  function getReviewOfSeller( $propertyId ){
        return $this
            ->leftjoin('users', 'users.id', 'property_reviews.rating_from_user' )
            ->where(array('property_reviews.property_id' => $propertyId, 'property_reviews.comment_type' => 2 ))
            ->select( 'property_reviews.comments', 'property_reviews.rating', 'property_reviews.reason_for_rating', 'property_reviews.created_at', 'users.first_name', 'users.last_name', 'users.image')
            ->orderBy('property_reviews.created_at', 'DESC')
            ->get()
            ->toArray();
    }

    /*===========================================
		Get Property Review With user information
		Param 1 : Property Id
        Join : User
     =============================================*/
    public  function getReviewOfSellerToBuyer( $userId, $offSet ){
        return $this
            ->leftjoin('users', 'users.id', 'property_reviews.rating_from_user' )
            ->where(array('property_reviews.rating_to_user'=>$userId, 'comment_type'=>2))
            ->select('property_reviews.rating','property_reviews.reason_for_rating','property_reviews.comments','property_reviews.created_at','users.first_name','users.last_name', 'users.image')
            ->take(4)
            ->skip($offSet)
            ->get()
            ->toArray();
    }

    /*===========================================
		Get Property Review With user information
		Param 1 : Property Id
        Join : User
     =============================================*/
    public  function ajaxGetReviewOfBuyer( $propertyId, $offset ){
        return $this
            ->leftjoin('users', 'users.id', 'property_reviews.rating_from_user' )
            ->where(array('property_reviews.property_id' => $propertyId, 'property_reviews.comment_type' => 1 ))
            ->select( 'property_reviews.comments', 'property_reviews.rating', 'property_reviews.reason_for_rating', 'property_reviews.created_at', 'users.first_name', 'users.last_name', 'users.image')
            ->orderBy('property_reviews.created_at', 'DESC')
            ->skip($offset)
            ->take(2)
            ->get()
            ->toArray();
    }

}
