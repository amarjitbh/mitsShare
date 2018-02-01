<?php
use App\Property;
use App\Bookings;
    function pr($data, $exit = false){
        echo "<pre>";
        print_r($data);
        if ($exit) {
            die;
        }
    }
    function createThumb($name, $filename, $new_w, $new_h){
        $found = 0;
        $system = explode('.', $name);
        $echeck = strtolower(end($system));
        if (preg_match('/pdf|txt/', $echeck)) {
            $found = 0;
        }
        if (preg_match('/jpg|jpeg/', $echeck)) {
            $src_img = imagecreatefromjpeg($name);
            $found = 1;
        }
        if (preg_match('/png/', $echeck)) {
            $src_img = imagecreatefrompng($name);
            $found = 1;
        }
        if (preg_match('/gif/', $echeck)) {
            $src_img = imagecreatefromgif($name);
            $found = 1;
        }

        if ($found) {
            $old_x = imagesx($src_img);
            $old_y = imagesy($src_img);
            $ar = $old_x / $old_y;

            if ($old_x > 2000) {
                if ($new_w == $new_h) {
                    $thumb_w = $new_w;
                    $thumb_h = $new_h;
                } else {
                    $thumb_w = $new_w;
                    $thumb_h = (int)(($old_y / $old_x) * $new_w);
                }
            } else {
                $thumb_w = $old_x;
                $thumb_h = $old_y;
            }

            $dst_img = imagecreatetruecolor($thumb_w, $thumb_h);
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);

            if (preg_match("/png/", $echeck)) {
                imagepng($dst_img, $filename);
            } else if (preg_match('/jpg|jpeg/', $echeck)) {
                imagejpeg($dst_img, $filename, 100);
            } else if (preg_match("/gif/", $echeck)) {
                imagegif($dst_img, $filename);
            }
            imagedestroy($dst_img);
            imagedestroy($src_img);
        }

    }
    function isSeller(){
        return \Auth::user() && \Auth::user()->role == 2 ? true : false;
    }

    /*=======================================================
        Prepare Date When Displaying the details For Property
        Param 1 : $propertyDetails (Array)
        Used In : SellerController and PropertyController
    =========================================================*/
    // function prepareDataForPropertyDetail( $propertyDetails ){
    //     $section_array = array();
    //     foreach($propertyDetails as $propertyDetail){
    //         $section_array[$propertyDetail['id']]['section_name']=$propertyDetail['section'];
    //         $section_array[$propertyDetail['id']]['fields'][]= [
    //             'owner_id'          => $propertyDetail['seller_id'],
    //             'field_name'        => $propertyDetail['field_name'],
    //             'field_value'       => $propertyDetail['property_type_section_field_value'],
    //             'field_identifier'  => $propertyDetail['field_identifier'],
    //             'is_option'         => $propertyDetail['is_option'],
    //             'input_field_type_id' => $propertyDetail['input_field_type_id'],
    //             'is_approved_checked' => $propertyDetail['is_approved_checked']
    //         ];
    //     }
    //     return $section_array;
    // }

    function prepareDataForPropertyDetail( $propertyDetails ){
        $section_array = array();
        foreach($propertyDetails as $propertyDetail){
            if(!empty($propertyDetail['property_type_section_field_value'])){
                $section_array[$propertyDetail['id']]['section_name']=$propertyDetail['section'];
                $section_array[$propertyDetail['id']]['fields'][]= [
                    'owner_id'          => $propertyDetail['seller_id'],
                    'field_name'        => $propertyDetail['field_name'],
                    'field_value'       => $propertyDetail['property_type_section_field_value'],
                    'field_identifier'  => $propertyDetail['field_identifier'],
                    'is_option'         => $propertyDetail['is_option'],
                    'input_field_type_id' => $propertyDetail['input_field_type_id'],
                    'is_approved_checked' => $propertyDetail['is_approved_checked']
                ]; 
            }
            
        }
     
        return $section_array;
    }


    /*==================================================
        Prepare Date When Searching the Property By Id
        Param 1 : $properties_data (Array)
        Used In : SellerController and PropertyController
     =====================================================*/
    function prepareDataForProperties( $properties_data ){
        $propertyArr = [];
        foreach($properties_data as $key => $property){
            $propertyArr[$property['id']]['property_type_id'] = $property['property_type_id'];
            $propertyArr[$property['id']]['property_id'] = $property['id'];
            if($property['field_identifier'] == \Config::get('constants.INPUT_TYPE_FIELD_IDENTIFIER.1')){
                $propertyArr[$property['id']]['basic_name'] = $property['property_type_section_field_value'];
            }
            if($property['field_identifier'] == \Config::get('constants.INPUT_TYPE_FIELD_IDENTIFIER.2')){
                $propertyArr[$property['id']]['basic_location'] = $property['property_type_section_field_value'];
            }
            if($property['field_identifier'] == \Config::get('constants.INPUT_TYPE_FIELD_IDENTIFIER.3')){
                $propertyArr[$property['id']]['basic_feature_image'] = $property['property_type_section_field_value'];
            }
            if($property['field_identifier'] == \Config::get('constants.INPUT_TYPE_FIELD_IDENTIFIER.4')){
                $propertyArr[$property['id']]['basic_price'] = $property['property_type_section_field_value'];
            }
            if($property['field_identifier'] == \Config::get('constants.INPUT_TYPE_FIELD_IDENTIFIER.5')){
                $propertyArr[$property['id']]['basic_description'] = $property['property_type_section_field_value'];
            }
            if($property['created_at']){
                $propertyArr[$property['id']]['created_at'] = $property['created_at'];
            }
            if($property['first_name']){
                $propertyArr[$property['id']]['first_name'] = $property['first_name'];
            }
            if($property['last_name']){
                $propertyArr[$property['id']]['last_name'] = $property['last_name'];
            }
             if($property['seller_id']){
                $propertyArr[$property['id']]['seller_id'] = $property['seller_id'];
            }
        }
        return $propertyArr;
    }

    /*==================================================
            Prepare Date When Searching the Property By Id
            Param 1 : $properties_data (Array)
            Used In : SellerController and PropertyController
         =====================================================*/
    function prepareDataForSellerProperties( $properties_data ){
       
        $propertyArr = [];
        foreach($properties_data as $key => $property){
            $propertyArr[$property['id']]['property_type_id'] = $property['property_type_id'];
            $propertyArr[$property['id']]['property_id'] = $property['id'];
            if($property['field_identifier'] == \Config::get('constants.INPUT_TYPE_FIELD_IDENTIFIER.1')){
                $propertyArr[$property['id']]['basic_name'] = $property['property_type_section_field_value'];
            }
            if($property['field_identifier'] == \Config::get('constants.INPUT_TYPE_FIELD_IDENTIFIER.2')){
                $propertyArr[$property['id']]['basic_location'] = $property['property_type_section_field_value'];
            }
            if($property['field_identifier'] == \Config::get('constants.INPUT_TYPE_FIELD_IDENTIFIER.3')){
                $propertyArr[$property['id']]['basic_feature_image'] = $property['property_type_section_field_value'];
            }
            if($property['field_identifier'] == \Config::get('constants.INPUT_TYPE_FIELD_IDENTIFIER.4')){
                $propertyArr[$property['id']]['basic_price'] = $property['property_type_section_field_value'];
            }
            if($property['field_identifier'] == \Config::get('constants.INPUT_TYPE_FIELD_IDENTIFIER.5')){
                $propertyArr[$property['id']]['basic_description'] = $property['property_type_section_field_value'];
            }
            if($property['created_at']){
                $propertyArr[$property['id']]['created_at'] = $property['created_at'];
            }
            if($property['first_name']){
                $propertyArr[$property['id']]['first_name'] = $property['first_name'];
            }
            if($property['last_name']){
                $propertyArr[$property['id']]['last_name'] = $property['last_name'];
            }
            /*if($property['booking_id']){
                $propertyArr[$property['id']]['booking_id'] = $property['booking_id'];
            }*/
        }
        return $propertyArr;
    }


    /*====================================================
            Prepare Date When Searching the Property By Id
            Param 1 : $properties_data (Array)
            Used In : SellerController and PropertyController
     =======================================================*/
    function prepareDataForUpComingPastProperties( $properties_data ){
        $propertyArr = [];
        foreach($properties_data as $key => $property){
            $propertyArr[$property['booking_id']]['property_id'] = $property['id'];
            if($property['field_identifier'] == \Config::get('constants.INPUT_TYPE_FIELD_IDENTIFIER.1')){
                $propertyArr[$property['booking_id']]['basic_name'] = $property['property_type_section_field_value'];
            }
            if($property['field_identifier'] == \Config::get('constants.INPUT_TYPE_FIELD_IDENTIFIER.2')){
                $propertyArr[$property['booking_id']]['basic_location'] = $property['property_type_section_field_value'];
            }
            if($property['field_identifier'] == \Config::get('constants.INPUT_TYPE_FIELD_IDENTIFIER.3')){
                $propertyArr[$property['booking_id']]['basic_feature_image'] = $property['property_type_section_field_value'];
            }
            if($property['field_identifier'] == \Config::get('constants.INPUT_TYPE_FIELD_IDENTIFIER.4')){
                $propertyArr[$property['booking_id']]['basic_price'] = $property['property_type_section_field_value'];
            }
            if($property['field_identifier'] == \Config::get('constants.INPUT_TYPE_FIELD_IDENTIFIER.5')){
                $propertyArr[$property['booking_id']]['basic_description'] = $property['property_type_section_field_value'];
            }
            if($property['created_at']){
                $propertyArr[$property['booking_id']]['created_at'] = $property['created_at'];
            }
            if($property['upcoming_date']){
                $propertyArr[$property['booking_id']]['upcoming_date'][$property['booking_date_id']] = $property['upcoming_date'];
            }
            if($property['booking_id']){
                $propertyArr[$property['booking_id']]['booking_id'] = $property['booking_id'];
            }
            if($property['total_amount']){
                $propertyArr[$property['booking_id']]['total_amount'] = $property['total_amount'];
            }
            if($property['email']){
                $propertyArr[$property['booking_id']]['email'] = $property['email'];
            }
            if($property['mobile_number']){
                $propertyArr[$property['booking_id']]['mobile_number'] = $property['mobile_number'];
            }
            if($property['first_name']){
                $propertyArr[$property['booking_id']]['first_name'] = $property['first_name'];
            }
            if($property['last_name']){
                $propertyArr[$property['booking_id']]['last_name'] = $property['last_name'];
            }
            if($property['buyerId']){
                $propertyArr[$property['booking_id']]['buyerId'] = $property['buyerId'];
            }
            if($property['is_approved']){
                $propertyArr[$property['booking_id']]['is_approved'] = $property['is_approved'];
            }
            if($property['property_owner_id']){
                $propertyArr[$property['booking_id']]['property_owner_id'] = $property['property_owner_id'];
            }
            if($property['payment_status']){
                $propertyArr[$property['booking_id']]['payment_status'] = $property['payment_status'];
            }
        }
        return $propertyArr;
    }

    /*========================================
        check value match with associative array
        Param 1 : Array
        Param 2 : key
        Param 3 : value
     =========================================*/

    function is_in_array($array, $key, $key_value){
        $within_array = 'no';
        foreach( $array as $k=>$v ){
            if( is_array($v) ){
                $within_array = is_in_array($v, $key, $key_value);
                if( $within_array == 'yes' ){
                    break;
                }
            } else {
                if( $v == $key_value && $k == $key ){
                    $within_array = 'yes';
                    break;
                }
            }
        }
        return $within_array;
    }

    /*========================================
        Convert date format to as 08 Nov 2017
        Param 1 : Date
     =========================================*/
    function dateFormat($date){
        return date('d M Y', strtotime($date));
    }



    function getUtcTime($timezone){
        $carbon = new Carbon();
        $carbon->setTimezone($timezone);
        $currentTime= $carbon;           //output is  : DateTime | TimeZone
        $utcTime= $carbon->now();    // output is : DateTime | UTC
        return $datesArray = array('currentTime' =>$currentTime , 'utcTime' =>$utcTime);
    }

     /*======================
        GET SERVER UTC TIME
     ========================*/
    function getServerUtcTime(){
        $carbon = new Carbon();
        return $utcTime= $carbon->now();
    }

    /*============================================================
        GET DATE DIFF BETWEEN TWO DATES IN MINUTE HOURS AND DAYS
     =============================================================*/
    function dateDiff($start, $end) {
        $start_ts = strtotime($start);
        $end_ts = strtotime($end);
        $diff = $end_ts - $start_ts;
        $hourDiff = round((strtotime($end) - strtotime($start))/3600, 1);
        $daysDiff  = round($diff / 86400);
        $interval  = abs($diff);
        $minutes   = round($interval / 60);
        return $datesDiff = array('minutesDiff' =>$minutes,'hourDiff' =>$hourDiff , 'daysDiff' =>$daysDiff);
    }



    /*================================
        Convert local time to UTC Time
     ==================================*/
    function convertIntoUTC($localTime, $dateTimeType, $timeZone) {
        $dateFormat = 'Y-m-d';
        $timeFormat = 'H:i:s';
        $dateTimeTypeFormat = $dateFormat . ' ' . $timeFormat;
        $date = new \DateTime($localTime.' '.$dateTimeType, new DateTimeZone($timeZone));
        $date->setTimezone(new DateTimeZone('UTC'));
        return $date->format($dateTimeTypeFormat);
    }

    /*================================
        Convert UTC time to Local Time
        Param : Array of dates
     ==================================*/
    function convertUtcToLocal($available_dates , $timeZone) {
        $localDates =array();
        foreach($available_dates as $utc){
            $dt = new DateTime($utc);
            $tz = new DateTimeZone($timeZone); // or whatever zone you're after
            $dt->setTimezone($tz);
            $localDates[]=$dt->format('Y-m-d H:i:s');
        }
        return $localDates;
    }

    /*================================
    Convert local time to UTC Time
    Param : Array of dates
    ==================================*/
    function convertLocalToUTC($bookDates, $time, $timeZone) {
        $utcDates = array();
        foreach($bookDates as $Dates){
            $dateFormat = 'Y-m-d';
            $timeFormat = 'H:i:s';
            $dateTimeTypeFormat = $dateFormat . ' ' . $timeFormat;
            $date = new \DateTime($Dates.' '.$time, new DateTimeZone($timeZone));
            $date->setTimezone(new DateTimeZone('UTC'));
            $utcDates[] = $date->format($dateTimeTypeFormat);
        }
        return $utcDates;
    }

    function getSingleLable ($section_array){

        $arrayTemp = array();
        foreach($section_array as $sec=>$section_arr){
            foreach ($section_arr['fields'] as $key => $val) {
                if($val['is_option']==1){
                    $arrayTemp[$val['field_name']]['label_name'] =  $val['field_name'];
                    $arrayTemp[$val['field_name']]['is_option'] =  $val['is_option'];
                    $arrayTemp[$val['field_name']]['values'][] =  $val['field_value'];
                    $arrayTemp[$val['field_name']]['sectionId'] =  $sec;
                    $arrayTemp[$val['field_name']]['typeId']  = $val['input_field_type_id'];
                }
            }
        }
        return $arrayTemp;
    }
    
    function listCounting ($seller_id,$type){
        if($type=='myProperty'){
            $query = (new Property())->getProperties($seller_id);
            $allPropertiesData = $query->orderBy('properties.id', "ASC")->get()->toArray();
            $propertyIDS = array();
            if(isset($allPropertiesData)){
                foreach($allPropertiesData as $value){
                    $propertyIDS[] = $value["propertyIds"];
                }
            }
            if(count($propertyIDS)){
            $properties_data = (new Property())->getSellerPropertyRelatedData($propertyIDS);       
            }
            
            if(isset($properties_data)){
                $propertyArr = prepareDataForSellerProperties($properties_data); // Defined in Helper
                return count($propertyArr);
            }
        }
        elseif($type=='bookedUpcomingProperties'){
            $propertyOwnerId=$seller_id;
            $bookingsIds=getBookingIds($propertyOwnerId,'bookedUpcomingProperties');
            $properties_data = (new Property())->getBookedUpcomingBookingPropertyData( $bookingsIds, $propertyOwnerId );
            if(isset($properties_data)){
                $propertyArr = prepareDataForUpComingPastProperties($properties_data); // Defined in Helper
                return count($propertyArr);
            }
        }
        elseif($type=='bookedPendingBookingProperties'){
            $propertyOwnerId=$seller_id;
            $bookingsIds=getBookingIds($propertyOwnerId,'bookedPendingBookingProperties');
            $properties_data = (new Property())->getBookedPendingBookingPropertyData( $bookingsIds, $propertyOwnerId );
            if(isset($properties_data)){
                $propertyArr = prepareDataForUpComingPastProperties($properties_data); // Defined in Helper
                return count($propertyArr);
            }

        }
        elseif($type=='bookedApproveProperties'){
            $propertyOwnerId=$seller_id;
            $bookingsIds=getBookingIds($propertyOwnerId,'bookedApproveProperties');
            $properties_data = (new Property())->getBookedApproveBookingPropertyData( $bookingsIds, $propertyOwnerId );
            if(isset($properties_data)){
                $propertyArr = prepareDataForUpComingPastProperties($properties_data); // Defined in Helper
                return count($propertyArr);
            }
        }
        elseif($type=='bookedRejectedBookingProperties'){
            $propertyOwnerId=$seller_id;
            $bookingsIds=getBookingIds($propertyOwnerId,'bookedRejectedBookingProperties');
            $properties_data = (new Property())->getBookedRejectedBookingPropertyData( $bookingsIds, $propertyOwnerId );
            if(isset($properties_data)){
                $propertyArr = prepareDataForUpComingPastProperties($properties_data); // Defined in Helper
                return count($propertyArr);
            }
        }
        elseif($type=='bookedPastBookingProperties'){
            $propertyOwnerId=$seller_id;
            $bookingsIds=getBookingIds($propertyOwnerId,'bookedPastBookingProperties');
            $properties_data = (new Property())->getBookedPastBookingPropertyData( $bookingsIds, $propertyOwnerId );
            if(isset($properties_data)){
                $propertyArr = prepareDataForUpComingPastProperties($properties_data); // Defined in Helper
                return count($propertyArr);
            }
        }
        elseif($type=='upcomingProperties'){
            $propertyOwnerId=$seller_id;
            $bookingsIds=getBookingIds($propertyOwnerId,'upcomingProperties');
            $properties_data = (new Property())->getUpcomingBookingPropertyData( $bookingsIds, $propertyOwnerId );
            if(isset($properties_data)){
                $propertyArr = prepareDataForUpComingPastProperties($properties_data); // Defined in Helper
                return count($propertyArr);
            }
        }
        elseif($type=='pendingProperties'){
            $propertyOwnerId=$seller_id;
            $bookingsIds=getBookingIds($propertyOwnerId,'pendingProperties');
            $properties_data = (new Property())->getPendingBookingPropertyData( $bookingsIds, $propertyOwnerId );
            if(isset($properties_data)){
                $propertyArr = prepareDataForUpComingPastProperties($properties_data); // Defined in Helper
                return count($propertyArr);
            }
        }
        elseif($type=='approveProperties'){
            $propertyOwnerId=$seller_id;
            $bookingsIds=getBookingIds($propertyOwnerId,'approveProperties');
            $properties_data = (new Property())->getApproveBookingPropertyData( $bookingsIds, $propertyOwnerId );
            if(isset($properties_data)){
                $propertyArr = prepareDataForUpComingPastProperties($properties_data); // Defined in Helper
                return count($propertyArr);
            }
        }
        elseif($type=='rejectedBookingProperties'){
            $propertyOwnerId=$seller_id;
            $bookingsIds=getBookingIds($propertyOwnerId,'rejectedBookingProperties');
            $properties_data = (new Property())->getRejectedBookingPropertyData( $bookingsIds, $propertyOwnerId );
            if(isset($properties_data)){
                $propertyArr = prepareDataForUpComingPastProperties($properties_data); // Defined in Helper
                return count($propertyArr);
            }
        }
        elseif($type=='pastBookingProperties'){
            $propertyOwnerId=$seller_id;
            $bookingsIds=getBookingIds($propertyOwnerId,'pastBookingProperties');
            $properties_data = (new Property())->getPastBookingPropertyData( $bookingsIds, $propertyOwnerId );
            if(isset($properties_data)){
                $propertyArr = prepareDataForUpComingPastProperties($properties_data); // Defined in Helper
                return count($propertyArr);
            }
        }
       
       
        
       
    }

    function getBookingIds($propertyOwnerId,$type){
        $commentType = 2;
        if($type=='bookedUpcomingProperties'){
        $query = (new Bookings())->getBookedUpcomingProperties( $propertyOwnerId );
        }
        elseif($type=='bookedPendingBookingProperties'){
        $query = (new Bookings())->getBookedPendingProperties( $propertyOwnerId );
        }
        elseif($type=='bookedApproveProperties'){
        $query = (new Bookings())->getBookedApproveProperties( $propertyOwnerId );
        }
        elseif($type=='bookedRejectedBookingProperties'){
        $query = (new Bookings())->getBookedRejectedProperties( $propertyOwnerId );
        }
        elseif($type=='bookedPastBookingProperties'){
        $query = (new Bookings())->getBookedPastBookingProperties( $propertyOwnerId );
        }
        elseif($type=='upcomingProperties'){
        $query = (new Bookings())->getUpcomingProperties( $propertyOwnerId );
        }
        elseif($type=='pendingProperties'){
        $query = (new Bookings())->getPendingProperties( $propertyOwnerId );
        }
        elseif($type=='approveProperties'){
        $query = (new Bookings())->getApproveProperties( $propertyOwnerId );
        }
        elseif($type=='rejectedBookingProperties'){
        $query = (new Bookings())->getRejectedProperties( $propertyOwnerId );
        }
        elseif($type=='pastBookingProperties'){
        $query = (new Bookings())->getPastBookingProperties( $propertyOwnerId );
        }
        
        $allPropertiesData = $query->orderBy('bookings.property_id', "DESC")->get()->toArray();
        $PropertiesIds = array();
        $bookingsIds = array();
         if(isset($allPropertiesData)){
            foreach($allPropertiesData as $value){
                $PropertiesIds[] = $value["property_id"];
                $bookingsIds[] = $value["booking_id"];
            }
            
        }
        return $bookingsIds;

    }


   
