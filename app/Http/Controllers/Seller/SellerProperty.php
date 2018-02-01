<?php

namespace App\Http\Controllers\Seller;

use App\Http\Requests\Seller\PropertiesFieldValues;
use App\PropertyType;
use App\TemplateLog;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Testing\HttpException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Property;
use App\PropertyTypeSectionFieldOption;
use App\PropertyFieldValue;
use App\PropertyTypeSection;
use App\PropertyTypeSectionField;
use App\PropertyAvailaibility;
use App\PropertyAvailaibilityDate;
use App\BookingDates;
use App\Bookings;
use App\PropertyReviews;
use App\MessageToBeSend;
use App\CancellationPolicyType;
use App\ProertiesPolicyUpdation;
use App\User;
use Carbon\Carbon;
use DB;
use Auth;
use Request as AjaxRequest;
use Illuminate\Validation\ValidationException;
use Mockery\CountValidator\Exception;
use Session;
use Illuminate\Support\MessageBag;
use \Validator;

//use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Config;

class SellerProperty extends Controller
{
    /*==========================
        Load After Seller Login
    =============================*/
    private $attribute = [];
    private $messages = [];
    private $rule = [];
    private $validator1= '';

    public function index(Request $request){
        $seller_id=Auth::user()->id;
        $query = (new Property())->getProperties($seller_id);
        $allPropertiesData = $query->orderBy('properties.id', "ASC")->paginate(4);
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
        }
        $active = 'myProperty';
        return view('seller.my_properties',compact('propertyArr', 'allPropertiesData', 'active' ));
    }

    /*================================
        Load View For Property Submit
    ==================================*/
    public function propertyInformation(Request $request){
        $propertyTypesId = $request->input('property_type_id');
        $propertyTypes = (new PropertyType())
            ->where(['deleted_at' => NULL])
            ->get(['name','id'])->toArray();
        $policyTypes = (new CancellationPolicyType())
            ->get(['policy_name','id'])->toArray();

        $propertyTypesSection = (new PropertyTypeSection())
            ->leftjoin('property_type_section_fields', 'property_type_section_fields.property_type_section_id','=', 'property_type_sections.id')
            ->where('property_type_sections.property_type_id' , $request->input('property_type_id'))
            ->select(\DB::raw('group_concat(property_type_section_fields.id) as property_type_section_fields_id'), 'property_type_sections.name', 'property_type_sections.id')
            ->groupBy('property_type_sections.id')
            ->orderBy('property_type_sections.order_id',"ASC")
            ->get()->toArray();

        $propertyTypesSectionFieldId = explode(',', implode(',', array_filter(array_column($propertyTypesSection, 'property_type_section_fields_id'))));

        $inputsFields = (new PropertyTypeSectionField())

            ->with(['propertyTypeSectionFieldValue' => function ($query) {
                $query->select('display_value', 'property_type_section_field_id','id');
            }])
            ->join('input_field_types', 'input_field_types.id','=', 'property_type_section_fields.input_field_type_id')
            ->whereIn('property_type_section_fields.id' , $propertyTypesSectionFieldId)
            ->select('property_type_section_fields.name','property_type_section_fields.validations','property_type_section_fields.field_identifier','property_type_section_fields.property_type_section_id','property_type_section_fields.id','input_field_types.field_name')
            ->orderBy('property_type_section_fields.order_id',"ASC")
            ->get()->toArray();

        $propertyTypeSectionData = [];
        foreach($propertyTypesSection as $ind => $propertyTypeFieldName){
            foreach($inputsFields as $index => $inputsField) {
                if ($inputsField['property_type_section_id'] == $propertyTypeFieldName['id']) {
                    $propertyTypeSectionData[$inputsField['property_type_section_id']]['section_name'] = $propertyTypeFieldName['name'];
                    $propertyTypeSectionData[$inputsField['property_type_section_id']]['section_id'] = $inputsField['property_type_section_id'];
                    $propertyTypeSectionData[$inputsField['property_type_section_id']]['fields'][$inputsField['id']]['type'] = $inputsField['field_name'];
                    $propertyTypeSectionData[$inputsField['property_type_section_id']]['fields'][$inputsField['id']]['id'] = $inputsField['id'];
                    $propertyTypeSectionData[$inputsField['property_type_section_id']]['fields'][$inputsField['id']]['name'] = $inputsField['name'];
                    $propertyTypeSectionData[$inputsField['property_type_section_id']]['fields'][$inputsField['id']]['validations'] = $inputsField['validations'];
                    $propertyTypeSectionData[$inputsField['property_type_section_id']]['fields'][$inputsField['id']]['field_identifier'] = $inputsField['field_identifier'];
                    $propertyTypeSectionData[$inputsField['property_type_section_id']]['fields'][$inputsField['id']]['options'] = $inputsField['property_type_section_field_value'];
                }
            }

        }

        //return view('Propertytype.property_information',compact('propertyTypes','propertyTypeSectionData','propertyTypesId'));
        return view('seller/property.property_information',compact('policyTypes','propertyTypes','propertyTypeSectionData','propertyTypesId'));
    }

    function change_key( $array, $old_key, $new_key ) {

        if( ! array_key_exists( $old_key, $array ) )
            return $array;
        $keys = array_keys( $array );
        $keys[ array_search( $old_key, $keys ) ] = $new_key;

        return array_combine( $keys, $array );
    }

    /*==============================
        Store Property Field Values
    ================================*/
    public function storePropertyTypeData(PropertiesFieldValues $request){

        DB::beginTransaction();
        try{
           
            $inputsValues = $request->all();
            $savePropertyFieldValue = [];
            $propertyTypesId = $inputsValues['property_types_id'];
            $inputs = [];
            $i=0;
            foreach($inputsValues as $key => $newInput){
                if($i >= 2) {
                    $newKey = substr($key, 0, strpos($key, "_"));
                    if(!empty($newKey) && is_numeric($newKey)) {
                        $inputs[$newKey] = $newInput;
                    }
                }$i++;
            }
            $data['property_type_id'] = $propertyTypesId;
            $data['seller_id'] = Auth::user()->id;
            $data['lat'] = isset($inputsValues['lat'])?$inputsValues['lat']:0;
            $data['lng'] = isset($inputsValues['long'])?$inputsValues['long']:0;
            $latitude = $data['lat'];
            $longitude = $data['lng'];
            $key= \Config::get('TIMEZONE_API_KEY');
            $time = time();
            $url = "https://maps.googleapis.com/maps/api/timezone/json?location=$latitude,$longitude&timestamp=$time&key=$key";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            if(curl_exec($ch) === false)
            {
                pr(curl_error($ch));
                exit;
            }
            $responseJson = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($responseJson);
            $timezone_name='';
            $asiaTimezone = Config::get('constants.ASIA_TIMEZONE');// constants.ASIA_TIMEZONE;
            if($response->timeZoneId==$asiaTimezone){
            $timezone_name = str_replace("Calcutta","Kolkata",$response->timeZoneId);
            }else{
            $timezone_name  = $response->timeZoneId;
            }
            $data['timezone_name'] = $timezone_name;
            $data['is_approved_checked'] = isset($inputsValues['is_approved_checked']) ? $inputsValues['is_approved_checked'] : 0;
            $data['policy_types_id'] = $inputsValues['policyType'];
            $propertyTypeObj = new Property($data);
            try {
                if ($propertyTypeObj->save()) {
                    $propertyId = $propertyTypeObj->id;
                    $fileName = (new PropertyTypeSection())
                        ->join('property_type_section_fields', 'property_type_section_fields.property_type_section_id', '=', 'property_type_sections.id')
                        ->where(['property_type_sections.property_type_id' => $propertyTypesId, 'property_type_section_fields.input_field_type_id' => \Config::get('constants.ADMIN_DEFAULT_PROPERTY_FEILDS_TYPE_ID.3')])
                        ->select('property_type_section_fields.id')
                        ->get()->toArray();
                    $imageAry = $request->file();
                    $image = [];
                    $newImageAry = [];
                    if (!empty($imageAry)) {
                        foreach ($imageAry as $key => $imgArray) {

                            $imageAryKey = $key;
                            $newImageKey = substr($imageAryKey, 0, strpos($imageAryKey, "_"));
                            $newImageAry[$newImageKey] = $imgArray;
                        }
                    }
                    if (!empty($newImageAry) && !empty($fileName)) {
                        foreach ($fileName as $fileId) {
                            $newImageAryKey = array_keys($newImageAry);
                            if (in_array($fileId['id'], $newImageAryKey)) {
                                $images[$fileId['id']] = $newImageAry[$fileId['id']];
                            }
                        }
                    }

                    $input['image_name'] = [];
                    $imageFileName  = [];
                    if (!empty($images)) {
                        foreach ($images as $key => $imagees) {
                            if(is_array($imagees)){
                                foreach ($imagees as $imgKey=>$image) {
                                    $input['image_name'] = time() . str_shuffle('addProperty67890').rand(0, 9) . '.' . $image->getClientOriginalExtension();
                                    $destinationPath = public_path(\Config::get('constants.IMAGE_FOLDER_NAME'));
                                    $image->move($destinationPath, $input['image_name']);
                                    $filePath = $destinationPath . '/' . 'thumb_' . $input['image_name'];
                                    $newPath = public_path(\Config::get('constants.IMAGE_FOLDER_NAME') . '/' . $input['image_name']);
                                    createThumb($newPath, $filePath, 150, 200);
                                    $imageFileName[$imgKey]['id'] = $imgKey;
                                    $imageFileName[$imgKey]['image'] = $input['image_name'];
                                    if(isset($inputsValues['main_image'])){
                                        if($inputsValues['main_image']==$imgKey){
                                            $imageFileName[$imgKey]['chk'] = 1 ;
                                        } else{
                                            $imageFileName[$imgKey]['chk'] = 0 ;
                                        }
                                    } else{
                                        $imageFileName[$imgKey]['chk'] = 1;
                                    }
                                }
                                $inputs[$key] = json_encode($imageFileName);
                            }else{
                                $input['image_name'] = time() . str_shuffle('addExtraFeature12345').rand(0, 9) . '.' . $imagees->getClientOriginalExtension();
                                $destinationPath = public_path(\Config::get('constants.IMAGE_FOLDER_NAME'));
                                $imagees->move($destinationPath, $input['image_name']);
                                $filePath = $destinationPath . '/' . 'thumb_' . $input['image_name'];
                                $newPath = public_path(\Config::get('constants.IMAGE_FOLDER_NAME') . '/' . $input['image_name']);
                                createThumb($newPath, $filePath, 150, 200);
                                $inputs[$key] = $input['image_name'];
                            }

                        }
                    }

                    foreach ($inputs as $ind => $inputVal) {
                        if (is_numeric($ind)) {
                            if (is_array($inputVal)) {
                                foreach ($inputVal as $key => $value) {
                                    $savePropertyFieldValue[] = [
                                        'property_id' => $propertyId,
                                        'property_type_section_field_id' => $ind,
                                        'property_type_section_field_value' => $value,
                                        'is_option' => '1',
                                        'created_at' => date('Y-m-d h:i:s'),
                                    ];
                                }
                            } else {
                                $savePropertyFieldValue[] = [
                                    'property_id' => $propertyId,
                                    'property_type_section_field_id' => $ind,
                                    'property_type_section_field_value' => $inputVal,
                                    'is_option' => '0',
                                    'created_at' => date('Y-m-d h:i:s'),
                                ];

                            }
                        }
                    }
                   // pr($savePropertyFieldValue,1);
                    \DB::table('properties_field_values')->insert(
                        $savePropertyFieldValue
                    );

                    DB::commit();
                    return redirect()->route('show.property.availaibility', ['propertyTypesId' => $propertyId]);
                }
            }catch (Exception $e){
                DB::rollback();
                //pr($e->getMessage(),1);
                return redirect('/property/information')->with('warning', $e->getMessage());
            }
        }catch(\Exception $e){
            DB::rollback();
            //pr($e->getMessage(),1);
            return redirect('/property/information')->with('warning', $e->getMessage());
        }
    }

    /*========================================
        Load View For Display Booking Calendar
    ===========================================*/

    public function showPropertyAvailability(Request $request, $propertyTypesId){

        try {
            $isBlocked = '';
            $propertyAvailablityDates = (new PropertyAvailaibility())->getPropertySelectedDatesAndDays($propertyTypesId);
            //pr($propertyAvailablityDates,1);
            $data = [];
            $startDate = reset($propertyAvailablityDates);
            $endDate = end($propertyAvailablityDates);
            $startDate = $startDate['date'];
            $endDate = $endDate['date'];
            $bookedDates = [];
            if (!empty($propertyAvailablityDates)) {
                $isBlocked = array_column($propertyAvailablityDates,'is_blocked');
                $isBlocked = $isBlocked[0];
                foreach ($propertyAvailablityDates as $dates) {

                    $data[] = [
                            'success' => '100',
                            'title' => 'booked',
                            'start' => date('Y-m-d',strtotime($dates['date'])),
                            'start_date' => date('Y-m-d',strtotime($startDate)),
                            'last_date' => date('Y-m-d',strtotime($endDate)),
                            //'booked' => $dates['is_booked'],
                            'booked' => $dates['is_requested'],
                            'isBlocked' => $dates['is_blocked'],
                    ];

                    if ($dates['is_booked'] == '1') {

                        $bookedDates[] = [

                                'start_date' => $dates['date'],
                                //'booked' => $dates['is_booked'],
                                'booked' => $dates['is_requested'],
                        ];
                    }
                }
            } else {

                $data = ['success' => '0'];
            }
            //pr($data,1);
            $data = json_encode($data);
            $bookedDates = json_encode($bookedDates);
            $propertyData = (new PropertyFieldValue())->getPropertyDetail( $propertyTypesId );
            $propertyData = prepareDataForPropertyDetail($propertyData);
            //pr($propertyData,1);
            return view('seller.property.property_availaibility', compact('propertyTypesId', 'propertyAvailablityDates', 'data', 'startDate', 'endDate', 'bookedDates','isBlocked','propertyData'));
        } catch (Exception $e){

        }
    }

    public function blockunblockdates(Request $request, $id,$isBlocked){

        $ary = [

                'is_blocked'    => $isBlocked,
                'updated_at'    => date('Y-m-d H:i:s')
        ];

        (new PropertyAvailaibility())->where(['property_id' => $id])->update($ary);
        if($isBlocked == 1){

            Session::flash('message', 'all date are unblock successfully');
        }else{

            Session::flash('message', 'all date are blocked successfully');
        }
        return redirect()->route('seller-properties');
    }

    public function getCalenderEvents(Request $request,$id){
        /*$inputs = $request->all();
        $id = $inputs['id'];*/
        try {
            $propertyAvailablityDates = (new PropertyAvailaibility())->getPropertySelectedDatesAndDays($id);
            $startDate = reset($propertyAvailablityDates);
            $endDate = end($propertyAvailablityDates);
            if (!empty($propertyAvailablityDates)) {
                foreach ($propertyAvailablityDates as $dates) {

                    $data[] = [

                            'success' => '100',
                            'title' => 'booked',
                            'start' => date('Y-m-d',strtotime($dates['date'])),
                            'start_date' => date('Y-m-d',strtotime($startDate['date'])),
                            'last_date' => date('Y-m-d',strtotime($endDate['date'])),
                            'isBlocked' => $dates['is_blocked']
                    ];
                }
            } else {

                $data = [

                        'success' => '0',
                ];
            }
            return json_encode($data);
        }catch (Exception $e){

        }
    }

    public function getCalenderEventsDates(Request $request,$id,$dates){
        try {
            $inputs = $request->all();

            $propertyAvailablityDates = (new PropertyAvailaibility())->getPropertySelectedFilterWithDate($id, $dates);
            if (count($propertyAvailablityDates) > 0) {

                $propertyAvailablityDates = $propertyAvailablityDates->toArray();
            } else {
                $propertyAvailablityDates = '';
            }
            if (!empty($propertyAvailablityDates)) {

                $data = $propertyAvailablityDates['date'];
                $data = [
                        'success' => '100',
                        'date' => date('Y-m-d',strtotime($propertyAvailablityDates['date'])),
                        'is_booked' => $propertyAvailablityDates['is_requested'],
                        'isBlocked' => $propertyAvailablityDates['is_blocked']
                ];
                return $data;
            } else {
                /****  data not found  ****/
                return [
                        'success' => '0',
                ];
            }
        }catch (Exception $e){

        }
    }

    /*================================================
        Store Dates into  property_availaibility_dates
    ===================================================*/
    public function storePropertyAvailabilityData(Request $request) {
        //echo $request->property_id;

        try {
            $time = Config::get('constants.START_TIME');// constants.UTC_START_TIME;
            $PropertyAvailaibility_already_exists = PropertyAvailaibility::where('property_id', '=', $request->property_id)->first();
            $timeZone = Property::where(array('id' => $request->property_id))->value('timezone_name');

            //pr($PropertyAvailaibility_already_exists,1);
            $bookedDates = [];
            $bookedDatesArray = [];
            $dateArray = [];
           // $currentTime = date('Y-m-d H:i:s');
         //   echo $timeZone;
          //  exit;
//echo convertToLocalTimeZone($currentTime, 'Asia/Kolkata');
      //      exit;
            if (count($PropertyAvailaibility_already_exists) > 0) {
                $bookedDates = PropertyAvailaibilityDate::where(['property_availaibility_id' => $PropertyAvailaibility_already_exists->id, 'is_requested' => 1])->get();
                foreach ($bookedDates->toArray() as $bookdates) {
                    $bookedDatesArray[] = $bookdates['date'];
                }
                $requestDateArray = $request->dates;
                $lastBookedDate = end($bookedDatesArray);
                $lastRequestedDate = end($requestDateArray);
                if ($lastBookedDate <= $lastRequestedDate) {
                    (new PropertyAvailaibilityDate())->where(['property_availaibility_id' => $PropertyAvailaibility_already_exists->id, 'is_requested' => '0'])->delete();
                    if (!empty($bookedDates) && count($bookedDates) > 0) {
                        $newDatesArray = array_diff($request->dates, $bookedDatesArray);
                        if (!empty($newDatesArray)) {
                            foreach ($newDatesArray as $dates) {
                                $array[] = [
                                        'property_availaibility_id' => $PropertyAvailaibility_already_exists->id,
                                        'date' => convertIntoUTC($dates, $time, $timeZone),
                                        'is_booked' => '0',
                                        'is_requested' => '0',
                                ];
                            }
                        }
                    } else {
                        foreach ($request->dates as $value) {
                            $array[] = [
                                    'property_availaibility_id' => $PropertyAvailaibility_already_exists->id,
                                    'date' => convertIntoUTC($value, $time, $timeZone),
                                    'is_booked' => '0',
                                    'is_requested' => '0',
                            ];
                        }
                    }
                    if(!empty($array)) {
                        (new PropertyAvailaibilityDate())->insert($array);
                    }

                    $update = [
                            'property_id'           => $request->property_id,
                            'avalaibility_option'   => $request->avalaibility_option,
                            'updated_at'            => date('Y-m-d'),
                    ];
                    (new PropertyAvailaibility())->where(['property_id' =>  $request->property_id])->update($update);


                    Session::flash('message', 'Property updated successfully');
                    return response()->json(['success'=>true] );

                }else{

                    Session::flash('warning', 'Sorry some property have already book');
                    return response()->json(['warning'=>true] );
                }
            } else {


                $PropertyAvailaibility = new PropertyAvailaibility;
                $propertyArray = [

                        'property_id' => $request->property_id,
                        'avalaibility_option' => $request->avalaibility_option,
                        'is_blocked'            => '1',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                ];
                $insertId = $PropertyAvailaibility->insertGetId($propertyArray);

                foreach ($request->dates as $value) {
                    $array[] = [
                            'property_availaibility_id' => $insertId,
                            'date' => convertIntoUTC($value,$time,$timeZone),
                            'is_booked' => '0',
                    ];
                }

                (new PropertyAvailaibilityDate())->insert($array);
                Session::flash('message', 'Property added successfully');
                return response()->json(['success'=>true] );
            }
        } catch (Exception $e){

            Session::flash('message', $e->getMessage());
            return response()->json(['success'=>false]);
        }
    }

    /*===========================================
        Function For Getting My property Details
    ==============================================*/
    public function propertyDetail(Request $request){
        $input = $request->all();
        $commentType = $input['commentType'];
        $bookingId = $input['bookingId'];
        $userId = Auth::user()->id;
        $propertyId = $input['property_id'];
        $propertyDetails = (new PropertyFieldValue())->getPropertyDetail( $propertyId );
        foreach($propertyDetails as $propertyDetail){
            if($propertyDetail['is_option']==1){
                $ids[] = $propertyDetail['property_type_section_field_value'];
            }
        }
        if((isset($ids)) && (count($ids))){
            $display_values = (new PropertyTypeSectionFieldOption())->getDisplayValues( $ids );
        } else {
            $display_values[]=0;
        }
        $section_array = prepareDataForPropertyDetail( $propertyDetails ); //Defined In Helper
        if($commentType==1){
            $bookingDates = Bookings::join('booking_dates', 'bookings.booking_id', '=', 'booking_dates.booking_id')
                ->where(array('bookings.user_id'=> Auth::user()->id, 'bookings.property_id' => $propertyId, 'bookings.booking_id' => $bookingId ))
                ->select('booking_dates.date','booking_dates.booking_date_id')
                ->get()
                ->toArray();
            $endDateOfBooking = end($bookingDates);
            //$propertyReviews = (new PropertyReviews())->getReviewOfSeller( $propertyId );
            $propertyReviews = (new PropertyReviews())->getReviewOfBuyer( $propertyId );
            $idReviewOfBuyer = (new PropertyReviews())->getBookingId( $propertyId , $userId, $bookingId );
            if($idReviewOfBuyer){
                $displayAddReview = 0;
            } else{
                $displayAddReview = 1;
            }

        }
        if( $commentType==2 || $commentType==3 ){
           /* echo 'propertyId--->>'.$propertyId.'<br>';
            echo 'Auth::user()->id--->>'.Auth::user()->id;
            echo 'bookingId--->>'.$bookingId;*/
            $bookingDates = Bookings::join('booking_dates', 'bookings.booking_id', '=', 'booking_dates.booking_id')
                ->where(array('bookings.property_owner_id'=> Auth::user()->id, 'bookings.property_id' => $propertyId, 'bookings.booking_id' => $bookingId ))
                ->select('booking_dates.date','booking_dates.booking_date_id')
                ->get()
                ->toArray();
            $endDateOfBooking = end($bookingDates);
            $propertyReviews = (new PropertyReviews())->getReviewOfBuyer( $propertyId );
            $idReviewOfSeller = (new PropertyReviews())->getIdReviewOfSeller( $propertyId , $userId, $bookingId );
            if($idReviewOfSeller){
                $displayAddReview = 0;
            } else{
                $displayAddReview = 1;
            }
            //echo $displayAddReview;
        }
        $totalReviewOfBuyer = (new PropertyReviews())->getTotalReviewOfBuyer( $propertyId );
        return view('seller.property_details',compact( 'section_array', 'display_values', 'propertyId', 'commentType', 'endDateOfBooking', 'propertyReviews', 'displayAddReview', 'bookingId', 'totalReviewOfBuyer' ));
    }

    /*=========================================================================
       Function For Getting Upcoming Properties That Are Booked By Other Seller owner
   ============================================================================*/

    public function bookedUpcomingProperties(){
        $propertyOwnerId=Auth::user()->id;
        $commentType = 2;
        $query = (new Bookings())->getBookedUpcomingProperties( $propertyOwnerId );
        $allPropertiesData = $query->orderBy('bookings.property_id', "DESC")->paginate(4);
        $PropertiesIds = array();
        $bookingsIds = array();
        if(isset($allPropertiesData)){
            foreach($allPropertiesData as $value){
                $PropertiesIds[] = $value["property_id"];
                $bookingsIds[] = $value["booking_id"];
            }
            
        }
        $properties_data = (new Property())->getBookedUpcomingBookingPropertyData( $bookingsIds, $propertyOwnerId );
        if(isset($properties_data)){
            $propertyArr = prepareDataForUpComingPastProperties($properties_data); // Defined in Helper
        }
        $active = 'bookedUpcomingProperties';
        //pr($propertyArr,1);
        return view('seller.property.upcoming_properties',compact( 'propertyArr', 'allPropertiesData', 'active', 'commentType' ) );
    }


    /*=========================================================================
       Function For Getting Pending Properties That Are Booked By Other Seller
   ============================================================================*/

    public function bookedPendingBookingProperties(){
        $propertyOwnerId=Auth::user()->id;
        $commentType = 2;
        $query = (new Bookings())->getBookedPendingProperties( $propertyOwnerId );
        $allPropertiesData = $query->orderBy('bookings.property_id', "DESC")->paginate(4);
        $PropertiesIds = array();
        $bookingsIds = array();
         if(isset($allPropertiesData)){
            foreach($allPropertiesData as $value){
                $PropertiesIds[] = $value["property_id"];
                 $bookingsIds[] = $value["booking_id"];
            }
            
        }

        $properties_data = (new Property())->getBookedPendingBookingPropertyData( $bookingsIds, $propertyOwnerId );
        if(isset($properties_data)){
            $propertyArr = prepareDataForUpComingPastProperties($properties_data); // Defined in Helper
        }
        $active = 'bookedPendingBookingProperties';
        return view('seller.property.pending_booking',compact( 'propertyArr', 'allPropertiesData', 'active', 'commentType' ) );
    }
    

    /*=========================================================================
       Function For Getting Rejected Properties That Are Booked By Other Seller
   ============================================================================*/

    public function bookedRejectedBookingProperties(){
        $propertyOwnerId=Auth::user()->id;
        $commentType = 2;
        $query = (new Bookings())->getBookedRejectedProperties( $propertyOwnerId );
        $allPropertiesData = $query->orderBy('bookings.property_id', "DESC")->paginate(4);
        $PropertiesIds = array();
        $bookingsIds = array();
         if(isset($allPropertiesData)){
            foreach($allPropertiesData as $value){
                $PropertiesIds[] = $value["property_id"];
                 $bookingsIds[] = $value["booking_id"];
            }
            
        }
        $properties_data = (new Property())->getBookedRejectedBookingPropertyData( $bookingsIds, $propertyOwnerId );
        if(isset($properties_data)){
            $propertyArr = prepareDataForUpComingPastProperties($properties_data); // Defined in Helper
        }
        $active = 'bookedRejectedBookingProperties';
        return view('seller.property.rejected_booking',compact( 'propertyArr', 'allPropertiesData', 'active', 'commentType' ) );
    }
    
    /*===============================================================================
       Function For Getting Rejected Properties That Are Booked By Other Seller Guest
    ==================================================================================*/

    public function rejectedBookingProperties(){
        $userId=Auth::user()->id;
        $commentType = 2;
        $query = (new Bookings())->getRejectedProperties( $userId );
        $allPropertiesData = $query->orderBy('bookings.property_id', "DESC")->paginate(4);
        $PropertiesIds = array();
        $bookingsIds = array();
         if(isset($allPropertiesData)){
            foreach($allPropertiesData as $value){
                $PropertiesIds[] = $value["property_id"];
                 $bookingsIds[] = $value["booking_id"];
            }
        }
        $properties_data = (new Property())->getRejectedBookingPropertyData( $bookingsIds, $userId );
        if(isset($properties_data)){
            $propertyArr = prepareDataForUpComingPastProperties($properties_data); // Defined in Helper
        }
        $active = 'rejectedBookingProperties';
        return view('seller.property.rejected_booking',compact( 'propertyArr', 'allPropertiesData', 'active', 'commentType' ) );
    }

    /*================================================
        Function For Getting Upcoming Properties guest
    ==================================================*/
    public function upcomingProperties(){
        $userId=Auth::user()->id;
        $commentType = 1;
        $query = (new Bookings())->getUpcomingProperties( $userId );
        $allPropertiesData = $query->orderBy('bookings.property_id', "DESC")->paginate(4);
        $PropertiesIds = array();
        $bookingsIds = array();
        if(isset($allPropertiesData)){
            foreach($allPropertiesData as $value){
                $PropertiesIds[] = $value["property_id"];
                 $bookingsIds[] = $value["booking_id"];
            }
        }
        $properties_data = (new Property())->getUpcomingBookingPropertyData( $bookingsIds, $userId );
        if(isset($properties_data)){
            $propertyArr = prepareDataForUpComingPastProperties($properties_data); // Defined in Helper
        }
       
        $active = 'upcomingProperties';
        return view('seller.property.upcoming_properties',compact( 'propertyArr', 'allPropertiesData', 'active', 'commentType' ) );
    }

  /*================================================================================
       Function For Getting Approve Properties That Are Booked By Other Seller owner
   =================================================================================*/

    public function bookedApproveProperties($bookingId = null){
       // $bookingId = '38';
        $allPropertiesData = [];
        $propertyOwnerId=Auth::user()->id;
        $commentType = 2;
        $query = (new Bookings())->getBookedApproveProperties( $propertyOwnerId,$bookingId);
            $allPropertiesData = $query->orderBy('bookings.property_id', "DESC");
        $allPropertiesData = (!empty($bookingId) || $bookingId == null) ? $allPropertiesData->paginate(1) : $allPropertiesData->paginate(4);
            //pr($allPropertiesData->toArray(),1);
        $PropertiesIds = array();
        $bookingsIds = array();
         if(isset($allPropertiesData)){
            foreach($allPropertiesData as $value){
                $PropertiesIds[] = $value["property_id"];
                 $bookingsIds[] = $value["booking_id"];
            }
        }
        $properties_data = (new Property())->getBookedApproveBookingPropertyData( $bookingsIds, $propertyOwnerId );
        //pr($properties_data,1);
        if(isset($properties_data)){
            $propertyArr = prepareDataForUpComingPastProperties($properties_data); // Defined in Helper
        }
            //pr($propertyArr,1);
        $active = 'bookedApproveProperties';
        return view('seller.property.approved-booking-properties',compact('propertyOwnerId', 'propertyArr', 'allPropertiesData', 'active', 'commentType' ) );
    }


    /*===============================================================================
       Function For Getting Approve Properties That Are Booked By Other Seller guest
    =================================================================================*/

    public function approveProperties(){
        $useId=Auth::user()->id;
        $propertyOwnerId=Auth::user()->id;
        $commentType = 1;
        $query = (new Bookings())->getApproveProperties( $useId );
        $allPropertiesData = $query->orderBy('bookings.property_id', "DESC")->paginate(4);
        $propertiesIds = array();
        $bookingsIds = array();
         if(isset($allPropertiesData)){
            foreach($allPropertiesData as $value){
                $propertiesIds[] = $value["property_id"];
                 $bookingsIds[] = $value["booking_id"];
            }
        }
        
        $bookedDates =(new PropertyAvailaibility())->getBookedDates( $propertiesIds );
        
       
        $properties_data = (new Property())->getApproveBookingPropertyData( $bookingsIds, $useId );
        if(isset($properties_data)){
            $propertyArr = prepareDataForUpComingPastProperties($properties_data); // Defined in Helper
        }
        $active = 'approveProperties';
        return view('seller.property.approved-booking-properties',compact('bookedDates','propertyOwnerId','propertyArr', 'allPropertiesData', 'active', 'commentType' ) );
    }


     /*==============================================
        Function For Getting Pending Properties guest
      ===============================================*/
    public function pendingProperties(){
        $useId=Auth::user()->id;
        $commentType = 1;
        $query = (new Bookings())->getPendingProperties( $useId );
        $allPropertiesData = $query->orderBy('bookings.property_id', "DESC")->paginate(4);
        $PropertiesIds = array();
        $bookingsIds = array();
        if(isset($allPropertiesData)){
            foreach($allPropertiesData as $value){
                $PropertiesIds[] = $value["property_id"];
                 $bookingsIds[] = $value["booking_id"];
            }
        }
        $properties_data = (new Property())->getPendingBookingPropertyData( $bookingsIds, $useId );
        if(isset($properties_data)){
            $propertyArr = prepareDataForUpComingPastProperties($properties_data); // Defined in Helper
        }
        $active = 'pendingProperties';
        return view('seller.property.user_pending_properties',compact( 'propertyArr', 'allPropertiesData', 'active', 'commentType' ) );
    }


    /*==============================================
        Function For Getting Past Booking Properties Owner
    ================================================*/
    
    public function bookedPastBookingProperties(){
        $propertyOwnerId=Auth::user()->id;
        $commentType = 2;
        $query = (new Bookings())->getBookedPastBookingProperties( $propertyOwnerId );
        $allPropertiesData = $query->orderBy('bookings.property_id', "DESC")->paginate(4);
        $bookingsIds = array();
        $PropertiesIds = array();
        if(isset($allPropertiesData)){
            foreach($allPropertiesData as $value){
                $PropertiesIds[] = $value["property_id"];
                 $bookingsIds[] = $value["booking_id"];
            }
        }
        $properties_data = (new Property())->getBookedPastBookingPropertyData( $bookingsIds, $propertyOwnerId );
        if(isset($properties_data)){
            $propertyArr = prepareDataForUpComingPastProperties($properties_data); // Defined in Helper
        }
        $active = 'bookedPastBookingProperties';
        return view('seller.property.past_booking_properties', compact( 'propertyArr', 'allPropertiesData', 'active', 'commentType' ));
    }

    /*=====================================================
        Function For Getting Past Booking Properties guest
    ========================================================*/
    public function pastBookingProperties(){
        $useId=Auth::user()->id;
        $commentType = 1;
        $query = (new Bookings())->getPastBookingProperties( $useId );
        $allPropertiesData = $query->orderBy('bookings.property_id', "DESC")->paginate(4);
        $PropertiesIds = array();
        $bookingsIds = array();
        if(isset($allPropertiesData)){
            foreach($allPropertiesData as $value){
                $PropertiesIds[] = $value["property_id"];
                 $bookingsIds[] = $value["booking_id"];
            }
        }
        $properties_data = (new Property())->getPastBookingPropertyData( $bookingsIds, $useId );
        if(isset($properties_data)){
            $propertyArr = prepareDataForUpComingPastProperties($properties_data); // Defined in Helper
        }
        $active = 'pastBookingProperties';
        return view('seller.property.past_booking_properties', compact( 'propertyArr', 'allPropertiesData', 'active', 'commentType' ));
    }


    /*==============================================
        Function For cancel booking
    ================================================*/

    public function cancelBooking(Request $request){
        try{
            $propertyOwnerId=Auth::user()->id;
            $inputs = $request->all();
            $availability_dates_ids = ( new PropertyAvailaibility() )->getPropertyBookingDatesWithDates( $inputs['propertyId'], $inputs['startDate'], $inputs['endDate'] );

            $bookingId = $inputs['bookingID'];
            $bookingData = (new Bookings())->getPolicyRecord( $bookingId );
            $bookingDates = (new Bookings())->getBookingDatesByBookingID( $bookingId );
            $property_id   = $bookingData['property_id'];
            $property_status  = (new Property())->getApprovedStatus($inputs['propertyId']);
            $propertyTimezone= $property_status['timezone_name'];
            $dateResult = getUtcTime($propertyTimezone);
            $currentDateTime=$dateResult['currentTime']; // current time according to time zone
            $utcDateTime=$dateResult['utcTime'];         // UTC time according to time zone

            $property_owner_id   = $bookingData['property_owner_id'];
            $cancelDuration   = $bookingData['duration'];
            $bookingStartdate = $bookingDates[0]['date'];
            $policyDuratonHours = \Config::get('constants.CANCELLATION_POLICY_DURATION_IN_MINUTES');
            $bookingPolicyDuration='';
            if($propertyOwnerId==$property_owner_id){
                $bookingPolicyDuration = $policyDuratonHours['owner'];
            } else{
                $bookingPolicyDuration = $policyDuratonHours[$cancelDuration];
            }
            $bookingDuration=dateDiff($utcDateTime,$bookingStartdate);
            $bookingMinutesDiff= $bookingDuration['minutesDiff'];
            if($bookingPolicyDuration < $bookingMinutesDiff) {
                $cancelPolicyId= $bookingData['policy_id'];
                if(Bookings::where( 'booking_id', $inputs['bookingID'] )->update( array( 'is_approved'=> 3))){
                    $availabilityIds = (new PropertyAvailaibility())->cancelGetPropertyAvailabilityBetweenDates1( $inputs['propertyId'], $inputs['startDate'], $inputs['endDate'] );
                    (new PropertyAvailaibilityDate())->cancelDates( $availabilityIds );
                    return response()->json(['success'=>true]);
                }
            } else {
                return response()->json(['success'=>false,'limitEexceed'=>'yes']);
            }
        }
         catch(\Exception $e){ pr($e->getMessage(),1);
             return $e->getMessage();
        }
    }

    /*==============================================
        Function For Approve and reject booking
    ================================================*/

    public function approveBooking(Request $request){
        try{
            $current_date = getServerUtcTime();
            $inputs = $request->all();
            $bookingId=$inputs['bookingID'];
            $checkedAvailability = (new PropertyAvailaibility())->getPropertyAvailabilityBetweenDatesFree( $inputs['propertyId'], $inputs['startDate'], $inputs['endDate'] );
            $bookingDate = (new Bookings())->getBookingDatesByBookingID( $bookingId );
            $ary = [
                    'is_approved' => $inputs['status'],
                    'updated_at'  => date('Y-m-d H:i:s')
            ];
            if($inputs['status']==1){
                if($inputs['startDate'] >= $current_date){
                    if(count($checkedAvailability) == count($bookingDate)){

                        if($this->messageToBeSend($ary,$inputs['bookingID'],$inputs['email'],$inputs['mobileno'],$inputs['status'],$inputs['propertyId'])){
                            return response()->json(['success'=>true,'is_approved'  => $inputs['status']]);
                        }
                    } else {
                        return response()->json(['success'=>false,'availaibility'  => 0]);
                    }
                } else {
                    return response()->json(['success'=>false,'expaired'  => 1]);
                }
            } else if($inputs['status']==2){
                if($this->messageToBeSend($ary,$inputs['bookingID'],$inputs['email'],$inputs['mobileno'],$inputs['status'],$inputs['propertyId'],$inputs['startDate'],$inputs['endDate'])){

                    $availabilityIds = (new PropertyAvailaibility())->cancelGetPropertyAvailabilityBetweenDates1( $inputs['propertyId'], $inputs['startDate'], $inputs['endDate'] );

                    (new PropertyAvailaibilityDate())->cancelDates( $availabilityIds );
                    return response()->json(['success'=>true,'is_approved'  => $inputs['status']]);

                }else{
                    return response()->json(['success'=>false,'is_approved'  => $inputs['status']]);
                }
            } else {
                return response()->json(['success'=>false,'is_approved'  => $inputs['status']]);
            }
        } catch(\Exception $e){
            return $e->getMessage();
            //return redirect('/seller/upcoming-properties')->with('warning', $e->getMessage());
        }
    }

    /*===========================================================
        Function For Displaying The Profile of Buyer From seller
    ============================================================*/
    public function buyerDetail(Request $request){
        $inputs = $request->all();
        $buyerID = $inputs['buyerId'];
        $offSet = isset($inputs['offset']) ? $inputs['offset'] : 0;
        $userInformation = User::with(array('userReviews' => function ($q) use ($buyerID, $offSet) {
            $q->join('users', 'property_reviews.rating_from_user', '=', 'users.id');
            $q->where(array('comment_type' => 2))
                ->select(['property_reviews.*', 'users.id as user_id', 'users.first_name', 'users.last_name', 'users.image'])
                ->take(4)
                ->skip($offSet);
        }))
            ->where(array('users.id' => $buyerID))->first()->toArray();
        if (AjaxRequest::ajax()) {
            return response()->json($userInformation);
        } else {
            return view('seller/user_profile',compact('userInformation'));
        }
    }


/*================================================================
        Function For Displaying The Profile of seller after login
    ============================================================*/
    public function sellerDetail(Request $request){
        $inputs = $request->all();
        $sellerID = $inputs['sellerId'];
        $offSet = isset($inputs['offset']) ? $inputs['offset'] : 0;
        $sellerUserInformation = $this->reviewsAsSeller($sellerID, $offSet);
        $buyerUserInformation  = $this->reviewsAsBuyer($sellerID, $offSet);
        $arr           = $this->getProperties($sellerID);
        $propertyArr = $arr['0'];
        $allPropertiesData = $arr['1'];
        $active = 'myProperty';
        return view('seller/seller_profile',compact('sellerUserInformation','buyerUserInformation','propertyArr', 'allPropertiesData', 'active'));
        
    }
    /*================================================================
        Function For Displaying The Profile of seller before login
    ==================================================================*/

    public function sellerprofile(Request $request){
        $inputs = $request->all();
        $sellerID = $inputs['sellerId'];
        $offSet = isset($inputs['offset']) ? $inputs['offset'] : 0;
        $sellerUserInformation = $this->reviewsAsSeller($sellerID, $offSet);
        $buyerUserInformation  = $this->reviewsAsBuyer($sellerID, $offSet);
        $arr           = $this->getProperties($sellerID);
        $propertyArr = $arr['0'];
        $allPropertiesData = $arr['1'];
        $active = 'myProperty';
        return view('seller/before_login_seller_profile',compact('sellerUserInformation','buyerUserInformation','propertyArr', 'allPropertiesData', 'active'));
        
    }

    /*=====================================
        Function For Get reviews As Buyer
    =======================================*/

   function reviewsAsBuyer($sellerID, $offSet){
    return $buyerUserInformation = User::with(array('userReviews' => function ($q) use ($sellerID, $offSet) {
            $q->join('users', 'property_reviews.rating_from_user', '=', 'users.id');
            $q->where(array('comment_type' => 2))
                ->select(['property_reviews.*', 'users.id as user_id', 'users.first_name', 'users.last_name', 'users.image'])
                ->take(4)
                ->skip($offSet);
        }))
            ->where(array('users.id' => $sellerID))->first()->toArray();
    }

    /*=====================================
        Function For Get reviews As Seller
    =======================================*/

    function reviewsAsSeller($sellerID, $offSet){
       return $sellerUserInformation = User::with(array('userReviews' => function ($q) use ($sellerID, $offSet) {
            $q->join('users', 'property_reviews.rating_to_user', '=', 'users.id');
            $q->where(array('comment_type' => 1))
                ->select(['property_reviews.*', 'users.id as user_id', 'users.first_name', 'users.last_name', 'users.image'])
                ->take(4)
                ->skip($offSet);
        }))
            ->where(array('users.id' => $sellerID))->first()->toArray();

    }
     /*=====================================
        Function For Get Seller Properties
    =======================================*/

   function getProperties($sellerID){
    $query = (new Property())->getProperties($sellerID);
        $allPropertiesData = $query->orderBy('properties.id', "ASC")->paginate(4);

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
        }
        return array($propertyArr, $allPropertiesData);
    }

    /*========================================================================
        Function For Sending Message During Approving ,Rejection, Cancellation
    =========================================================================*/
    function messageToBeSend($ary,$bookingId,$email,$mobile_no,$status,$propertyId,$startDate=null,$endDate=null){

        $propertyName = (new PropertyFieldValue())->getPropertyDetail($propertyId);
        $propertyFullName = '';
        //$routefunction = route('property.detail').'?property_id='.$propertyId.'&commentType=1&bookingId='.$bookingId;
        $routefunction = route('approved-properties');

        foreach($propertyName as $property){
            if($property['field_name'] == 'Name'){

                $propertyFullName = $property['property_type_section_field_value'];
            }
        }
        if($status==1){

            $subjects = "Property Approved";
            $booking = "Your request for the booking of '".$propertyFullName."' has been approved by the Owner,  please click on the following link.
                        <a href='".$routefunction."'>Click Here </a> to pay.";
        }else{
            $subjects = "Property Rejected";
            $booking = "Your request for the booking of '".$propertyFullName."' has been rejected by the Owner from ".date('Y-m-d',strtotime($startDate))." to ".date('Y-m-d',strtotime($endDate))." ";
        }
        $user = (new User())->where(['mobile_number' => $mobile_no])->first();
        $userName = $user->first_name.' '.$user->last_name;
        $templateLog = (new TemplateLog())->where(['template_log_id' => '4 '])->first();
        $userTaskDes = array("#user_name#",'#messages#');
        $userTaskRep   = array($userName,$booking);
        $messages = $templateLog->message;
        $newTaskDes = str_replace($userTaskDes,$userTaskRep,$messages);
        $messageBody = $newTaskDes;

        if((new Bookings())->where(['booking_id' => $bookingId])->update($ary)){
            $message['bookingId'] = $bookingId;
            $message['approved_token'] = md5(time());
            $message['email'] = $email;
            $message['subject'] = $subjects;
            $message['mobile_no'] = $mobile_no;
            $message['is_send'] = "1";
            $message['body']    = $messageBody;
            $message['url'] = "/success";
            $message['type'] = 1;
            $sendObj = new MessageToBeSend($message);
            if($sendObj->save()){
                return true;
            }else{
                return false;
            }
        }
    }

    /*=====================================================================
        Function For Getting the Review Of Seller that are Giving To Buyer
    ========================================================================*/
    public function reviewFromSeller(Request $request){
        $inputs = $request->all();
        $offSet = isset($inputs['offset']) ? $inputs['offset'] : 0;
        $userId=Auth::user()->id;
        $sellerReviews = (new PropertyReviews())->getReviewOfSellerToBuyer($userId,$offSet);
        if(AjaxRequest::ajax()) {
            return response()->json($sellerReviews);
        } else {
            $active = 'reviewFromSeller';
            return view('seller/seller_reviews_to_buyer',compact('sellerReviews','active'));
        }
    }

    /*================================================
        Function For Loading View For Updating Values
    ==================================================*/
    public function propertyEdit(Request $request,$id=null){
        $propertyId = is_numeric($id) ? $id : '';
        $properties = Property::where('id', $propertyId)->first();
        $policyTypes = (new CancellationPolicyType())
            ->get(['policy_name','id'])->toArray();
        $checkedRequied=$properties['is_approved_checked'];
        $policyTypesID=$properties['policy_types_id'];
        $propertyTypesId = $request->input('property_type_id');
        $propertyTypes = (new PropertyType())
            ->where(['deleted_at' => NULL])
            ->get(['name','id'])->toArray();
        $propertyTypesSection = (new PropertyTypeSection())
            ->leftjoin('property_type_section_fields', 'property_type_section_fields.property_type_section_id','=', 'property_type_sections.id')
            ->where('property_type_sections.property_type_id' , $propertyTypesId)
            ->select(\DB::raw('group_concat(property_type_section_fields.id) as property_type_section_fields_id'), 'property_type_sections.name', 'property_type_sections.id')
            ->groupBy('property_type_sections.id')
            ->orderBy('property_type_sections.order_id',"ASC")
            ->get()->toArray();
        $propertyTypesSectionFieldId = explode(',', implode(',', array_filter(array_column($propertyTypesSection, 'property_type_section_fields_id'))));
        $inputsFields = (new PropertyTypeSectionField())
            ->with(['propertyTypeSectionFieldValue' => function ($query) {
                $query->select('display_value', 'property_type_section_field_id','id');
            }])
            ->join('input_field_types', 'input_field_types.id','=', 'property_type_section_fields.input_field_type_id')
            ->whereIn('property_type_section_fields.id' , $propertyTypesSectionFieldId)
            ->select('property_type_section_fields.name','property_type_section_fields.validations','property_type_section_fields.field_identifier','property_type_section_fields.property_type_section_id','property_type_section_fields.id','input_field_types.field_name')
            ->orderBy('property_type_section_fields.order_id',"ASC")
            ->get()->toArray();
        $propertyTypeSectionData = [];
        foreach($propertyTypesSection as $ind => $propertyTypeFieldName){
            foreach($inputsFields as $index => $inputsField) {
                if ($inputsField['property_type_section_id'] == $propertyTypeFieldName['id']) {
                    $propertyTypeSectionData[$inputsField['property_type_section_id']]['section_name'] = $propertyTypeFieldName['name'];
                    $propertyTypeSectionData[$inputsField['property_type_section_id']]['section_id'] = $inputsField['property_type_section_id'];
                    $propertyTypeSectionData[$inputsField['property_type_section_id']]['fields'][$inputsField['id']]['type'] = $inputsField['field_name'];
                    $propertyTypeSectionData[$inputsField['property_type_section_id']]['fields'][$inputsField['id']]['id'] = $inputsField['id'];
                    $propertyTypeSectionData[$inputsField['property_type_section_id']]['fields'][$inputsField['id']]['name'] = $inputsField['name'];
                    $propertyTypeSectionData[$inputsField['property_type_section_id']]['fields'][$inputsField['id']]['validations'] = $inputsField['validations'];
                    $propertyTypeSectionData[$inputsField['property_type_section_id']]['fields'][$inputsField['id']]['field_identifier'] = $inputsField['field_identifier'];
                    $propertyTypeSectionData[$inputsField['property_type_section_id']]['fields'][$inputsField['id']]['options'] = $inputsField['property_type_section_field_value'];
                }
            }
        }
        $properties = (new Property())
            ->rightjoin('properties_field_values', 'properties_field_values.property_id','=', 'properties.id')
            ->rightjoin('property_type_section_fields', 'property_type_section_fields.id','=', 'properties_field_values.property_type_section_field_id')
            ->join('input_field_types', 'input_field_types.id','=', 'property_type_section_fields.input_field_type_id')
            ->where(function($query) use ($propertyTypesId) {
                if ($propertyTypesId != '') {
                    $query->where('properties.property_type_id', $propertyTypesId);
                }
            })
            ->select('properties.lat', 'properties.lng','property_type_section_fields.name','property_type_section_fields.validations','input_field_types.field_name','properties_field_values.property_type_section_field_value','property_type_section_fields.field_identifier','property_type_section_fields.id as property_type_section_field_id','properties.id','properties_field_values.id as property_filed_value_id')
            ->groupBy('properties_field_values.id')
            ->get()->toArray();
        $propertyEditArr = [];
        foreach($properties as $key => $property) {
            if ($property['id'] == $id) {
                $propertyEditArr[$property['property_type_section_field_id']]['property_id'] = $property['property_type_section_field_id'];
                $propertyEditArr[$property['property_type_section_field_id']]['property_type_section_field_value'][] = $property['property_type_section_field_value'];
                $propertyEditArr[$property['property_type_section_field_id']]['lat'] = $property['lat'];
                $propertyEditArr[$property['property_type_section_field_id']]['lng'] = $property['lng'];
            }
        }
        return view('seller/property.edit_property_information',compact('policyTypes','policyTypesID','checkedRequied','propertyTypes','propertyTypeSectionData','propertyTypesId','propertyEditArr','propertyId'));
    }


    /*==============================
        Function For Updating Values $multipleImages
    ================================*/
    public function propertyUpdate(PropertiesFieldValues $request) {
        $inputsValues = $request->all();
        $propertyId = $inputsValues['property_id'];
        $property = Property::where( array( 'id' => $propertyId ) )->first();
        $data['lat']=trim($inputsValues['lat']);
        $data['lng']=trim($inputsValues['long']);
        $data['policy_types_id'] = trim($inputsValues['policyTypeID']);
        $latitude = $data['lat'];
        $longitude = $data['lng'];
        $key= \Config::get('TIMEZONE_API_KEY');
        $time = time();
        $url =  "https://maps.googleapis.com/maps/api/timezone/json?location=$latitude,$longitude&timestamp=$time&key=$key";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if(curl_exec($ch) === false) {
            pr(curl_error($ch));
            exit;
        }
        $responseJson = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($responseJson);
        $timezone_name='';
        $asiaTimezone = Config::get('constants.ASIA_TIMEZONE');//  constants.ASIA_TIMEZONE;
        if($response->timeZoneId==$asiaTimezone){
            $timezone_name =  str_replace("Calcutta","Kolkata",$response->timeZoneId);
        }else{
            $timezone_name  = $response->timeZoneId;
        }
        $data['timezone_name'] = $timezone_name;
        $data['is_approved_checked'] =  isset($inputsValues['is_approved_checked']) ?  $inputsValues['is_approved_checked'] : 0;
        if($property->policy_types_id!=$inputsValues['policyTypeID']){
            $this->policyUpdationRecord($inputsValues['policyTypeID'],$propertyId);
        }
        $property->update( $data );
        $propertyTypeId = $inputsValues['property_types_id'];
        $inputs = [];
        $i=0;
        foreach($inputsValues as $key => $newInput){
            if($i >= 2) {
                $newKey = substr($key, 0, strpos($key, "_"));
                if(!empty($newKey) && is_numeric($newKey)) {
                    $inputs[$newKey] = $newInput;
                }
            }$i++;
        }
        $properties = (new Property())
            ->rightjoin('properties_field_values',  'properties_field_values.property_id', '=', 'properties.id')
            ->rightjoin('property_type_section_fields',  'property_type_section_fields.id', '=',  'properties_field_values.property_type_section_field_id')
            ->join('input_field_types', 'input_field_types.id', '=',  'property_type_section_fields.input_field_type_id')
            ->where('properties_field_values.property_id', $propertyId)
            ->select('property_type_section_fields.name',  'property_type_section_fields.validations',  'input_field_types.field_name',  'properties_field_values.property_type_section_field_value',  'property_type_section_fields.field_identifier',  'property_type_section_fields.id as property_type_section_field_id',  'properties.id', 'properties_field_values.id as  property_filed_value_id')
            ->groupBy('properties_field_values.id')
            ->get()->toArray();

        $updatePropertyFieldValue = [];
        $insertPropertyFieldValue = [];
        $insertMultipleFieldValue = [];
        $insertAbleIds = [];
        $fileName = (new PropertyTypeSection())
            ->join('property_type_section_fields',  'property_type_section_fields.property_type_section_id','=',  'property_type_sections.id')
            ->where(['property_type_sections.property_type_id' =>  $propertyTypeId,'property_type_section_fields.input_field_type_id' =>  \Config::get('constants.ADMIN_DEFAULT_PROPERTY_FEILDS_TYPE_ID.3')])
            ->select('property_type_section_fields.id')
            ->get()->toArray();
        $imageName = (new Property())
            ->join('properties_field_values',  'properties_field_values.property_id','=', 'properties.id')
            ->join('property_type_section_fields',  'property_type_section_fields.id','=',  'properties_field_values.property_type_section_field_id')
            ->where(['properties_field_values.property_id' =>  $propertyId,'property_type_section_fields.input_field_type_id' =>  \Config::get('constants.ADMIN_DEFAULT_PROPERTY_FEILDS_TYPE_ID.3')])
            ->where('properties_field_values.property_id',$propertyId)
            ->select('properties_field_values.property_type_section_field_value')
            ->get()->toArray();

        $imageAry = $request->file();
        $newImageAry = [];

        //pr($imageName);
        if(!empty($imageAry)){
            foreach($imageAry as $key => $imgArray) {
                $imageAryKey = $key;
                $newImageKey = substr($imageAryKey, 0,  strpos($imageAryKey, "_"));
                $newImageAry[$newImageKey] = $imgArray;
            }
        }
        $images = [];
        $imageNameDone = [];
        $i = 0;
        if(!empty($newImageAry) && !empty($fileName)){
            foreach($fileName as $fileId){
                $newImageAryKey = array_keys($newImageAry);
                if(in_array($fileId['id'],$newImageAryKey)) {
                    $images[$fileId['id']] = $newImageAry[$fileId['id']];
                }
                if(!empty($imageName[$i])){
                    $imageNameDone[$fileId['id']] = $imageName[$i];
                }
                $i++;
            }
        }

        $input['image_name'] = '';
        $k= 0;

        // When only Change default image
        /*if(!count($images) && (isset($inputsValues['main_image'])) ){
            $uploadedImages =  json_decode($imageName[0]['property_type_section_field_value'], true);

            foreach($uploadedImages as $key => $value) {
                if($uploadedImages[$key]['id']==$inputsValues['main_image']){
                    $uploadedImages[$key]['chk'] = 1;
                }else{
                    $uploadedImages[$key]['chk'] = 0;
                }
            }
            $index = $fileName[0]['id'];
            $inputs[$index] = json_encode($uploadedImages);
        }*/

        foreach($images as $key => $image) {
            if (!empty($image) && !empty($imageName) &&  !empty($imageName[$key])) {

                if  (file_exists(public_path(\Config::get('constants.IMAGE_FOLDER_NAME') .  '/' . $imageName[$key]['property_type_section_field_value']))) {
                    unlink(public_path(\Config::get('constants.IMAGE_FOLDER_NAME') . '/' .  $imageName[$key]['property_type_section_field_value']));
                    unlink(public_path(\Config::get('constants.IMAGE_FOLDER_NAME') . '/' .  'thumb_' . $imageName[$key]['property_type_section_field_value']));
                    $input['image_name'] = time() . rand(0, 9) . '.'  . $image->getClientOriginalExtension();
                    $destinationPath =  public_path(\Config::get('constants.IMAGE_FOLDER_NAME'));
                    $image->move($destinationPath, $input['image_name']);
                    $filePath = $destinationPath . '/' . 'thumb_' .  $input['image_name'];
                    $newPath =  public_path(\Config::get('constants.IMAGE_FOLDER_NAME') . '/' .  $input['image_name']);
                    createThumb($newPath, $filePath, 150, 200);
                } else {
                    $input['image_name'] = time() . rand(0, 9) . '.'  . $image->getClientOriginalExtension();
                    $destinationPath =  public_path(\Config::get('constants.IMAGE_FOLDER_NAME'));
                    $image->move($destinationPath, $input['image_name']);
                    $filePath = $destinationPath . '/' . 'thumb_' .  $input['image_name'];
                    $newPath =  public_path(\Config::get('constants.IMAGE_FOLDER_NAME') . '/' .  $input['image_name']);
                    createThumb($newPath, $filePath, 150, 200);
                }
                $imagesKeys = array_keys($images);
                $inputs[$imagesKeys[$k]] = $input['image_name'];
            } else if (!empty($image)) {

                if(is_array($image)){
                    $uploadedImages =  json_decode($imageName[0]['property_type_section_field_value'], true);

                    foreach ($image as $imgKey=>$img) {
                        $input['image_name'] = time() .  str_shuffle('editProperty12345').rand(0, 9) . '.' .  $img->getClientOriginalExtension();
                        $destinationPath =  public_path(\Config::get('constants.IMAGE_FOLDER_NAME'));
                        $img->move($destinationPath, $input['image_name']);
                        $filePath = $destinationPath . '/' . 'thumb_'  . $input['image_name'];
                        $newPath =  public_path(\Config::get('constants.IMAGE_FOLDER_NAME') . '/' .  $input['image_name']);
                        createThumb($newPath, $filePath, 150, 200);
                        $imageFileName[$imgKey]['id'] = $imgKey;
                        $imageFileName[$imgKey]['image'] =  $input['image_name'];
                        if(isset($inputsValues['main_image'])){
                            if($inputsValues['main_image']==$imgKey){
                                $imageFileName[$imgKey]['chk'] = 1 ;
                                if(!empty($uploadedImages)) {
                                    foreach ($uploadedImages as $key => $value) {
                                        //$uploadedImages[$key]['chk'] = 0;
                                        if ($uploadedImages[$key]['id'] == $imgKey) { // Replace default image
                                            $flag = 1;
                                            if (file_exists(public_path(\Config::get('constants.IMAGE_FOLDER_NAME') . '/' . $uploadedImages[$key]['image']))) {
                                                unlink(public_path(\Config::get('constants.IMAGE_FOLDER_NAME') . '/' . $uploadedImages[$key]['image']));
                                                unlink(public_path(\Config::get('constants.IMAGE_FOLDER_NAME') . '/' . 'thumb_' . $uploadedImages[$key]['image']));
                                            }

                                        }
                                    }
                                }
                                if(!empty($uploadedImages)) {
                                    if (isset($flag) && ($flag) == 1) {
                                        $imageFileName = array_replace($uploadedImages, $imageFileName);
                                    } else {
                                        $imageFileName = array_merge($uploadedImages, $imageFileName);
                                    }
                                }

                            } else{
                                // All Images replacement expect default
                                foreach($uploadedImages as $key =>  $uploadedIma){
                                    if($uploadedImages[$key]['id']==$imgKey){
                                        if  (file_exists(public_path(\Config::get('constants.IMAGE_FOLDER_NAME') .  '/' . $uploadedImages[$key]['image']))) {
                                            unlink(public_path(\Config::get('constants.IMAGE_FOLDER_NAME') . '/' .  $uploadedImages[$key]['image']));
                                            unlink(public_path(\Config::get('constants.IMAGE_FOLDER_NAME') . '/' .  'thumb_' . $uploadedImages[$key]['image']));
                                        }
                                    }
                                }
                                $imageFileName[$imgKey]['chk'] = 0 ;
                                $imageFileName =  array_replace($uploadedImages,$imageFileName);

                            }
                            //$imageFileName =  array_merge($uploadedImages,$imageFileName);
                        } else{
                            $imageFileName[$imgKey]['chk'] = 1;
                        }
                    }
                    $inputs[$fileName[$k]['id']] =  json_encode($imageFileName);

                }else{
                    $input['image_name'] = time() .  str_shuffle('editExtraFeature67890'). rand(0, 9) . '.' .  $image->getClientOriginalExtension();
                    $destinationPath =  public_path(\Config::get('constants.IMAGE_FOLDER_NAME'));
                    $image->move($destinationPath, $input['image_name']);
                    $filePath = $destinationPath . '/' . 'thumb_' .  $input['image_name'];
                    $newPath =  public_path(\Config::get('constants.IMAGE_FOLDER_NAME') . '/' .  $input['image_name']);
                    createThumb($newPath, $filePath, 150, 200);
                    $inputs[$key] = $input['image_name'];
                }
            } else {
                unset($fileName[$key]['id']);
            }
            $k++;
        }
       // pr($inputs,1);
        foreach ($inputs as $postInputFieldKey => $inputVal) {

            if(is_array($inputVal)){

                (new PropertyFieldValue())->where(['property_type_section_field_id' => $postInputFieldKey,'property_id' => $propertyId])->delete();
                $insertAbleIds[] = $postInputFieldKey;
            }
            $isAvailable = false;
            foreach ($properties as $GetProkey => $property) {
                if ($property['property_type_section_field_id'] ==  $postInputFieldKey) {
                    $isAvailable = true;
                    break;
                }
            }
            if ($isAvailable) {
                if (is_numeric($postInputFieldKey)) {
                    if (is_array($inputVal)) {
                        foreach ($inputVal as $key => $value) {
                            $updatePropertyFieldValue[] = [
                                'property_id' => $propertyId,
                                'property_type_section_field_id' =>  $postInputFieldKey,
                                'property_type_section_field_value' => $value,
                                'is_option' => '1',
                                'created_at' => date('Y-m-d h:i:s'),
                            ];
                        }

                    }else {
                        $updatePropertyFieldValue[] = [
                            'property_id' => $propertyId,

                            'property_type_section_field_id' =>  $postInputFieldKey,
                            'property_type_section_field_value' =>  "'$inputVal'",

                            'is_option' => '0',
                            'created_at' => date('Y-m-d h:i:s'),
                        ];
                    }
                }

            } else {
                if (is_numeric($postInputFieldKey)) {
                    $insertAbleIds[] = $postInputFieldKey;
                }
            }
        }

        if(!empty($insertAbleIds)){
            $insertAbleIds = array_unique($insertAbleIds);
        }
        //$insertAbleIds[$fileName->id] = $input['image_name'];
        if(!empty($insertAbleIds)) {
            foreach ($insertAbleIds as $ind => $insertAbleId) {

                if (is_array($inputs[$insertAbleId])) {
                    foreach ($inputs[$insertAbleId] as $key => $value) {
                        $insertPropertyFieldValue[] = [
                            'property_id' => $propertyId,
                            'property_type_section_field_id' => $insertAbleId,
                            'property_type_section_field_value' => $value,
                            'is_option' => '1',
                            'created_at' => date('Y-m-d h:i:s'),
                        ];
                    }
                } else {
                    $insertPropertyFieldValue[] = [
                        'property_id' => $propertyId,
                        'property_type_section_field_id' => $insertAbleId,
                        'property_type_section_field_value' => $inputs[$insertAbleId],
                        'is_option' => '0',
                        'created_at' => date('Y-m-d h:i:s'),
                    ];
                }


            }
        }
        //pr($updatePropertyFieldValue,1);
        //$propertyFieldValueIds = PropertyFieldValue::where(array('property_id' =>$propertyId))->pluck('property_type_section_field_id')->toArray();
        //pr($propertyFieldValueIds,1);
        $property_type_section_field_id =  array_column($updatePropertyFieldValue,  'property_type_section_field_id');
        //pr($property_type_section_field_id);
        if (isset($property_type_section_field_id) &&  $property_type_section_field_id != '') {

            $property_field_value_id = implode(",", $property_type_section_field_id);
            //pr($property_field_value_id,1);
            $property_type_section_field_value = "";
            foreach ($updatePropertyFieldValue as $ind => $updatePropertyValue) { //pr($updatePropertyValue);
                $propertyValues = !empty($updatePropertyValue['property_type_section_field_value']) ? $updatePropertyValue['property_type_section_field_value'] : " '' ";
                $property_type_section_field_value .= "WHEN property_type_section_field_id =  " . $updatePropertyValue['property_type_section_field_id'] . "  THEN " . $propertyValues . " ";
                $ids[] = $updatePropertyValue['property_type_section_field_id'];
            }
            if (!empty($ids)){
                $ids = implode(",", $ids);
            }
            $id = $propertyId;
            //pr($property_type_section_field_value);
            $sqlQuery = "UPDATE `properties_field_values` SET  `property_type_section_field_value`= CASE " .  $property_type_section_field_value . " END
            WHERE properties_field_values.property_type_section_field_id  in  ($ids) AND property_id=$id";
            //pr($sqlQuery,1);

            \DB::update($sqlQuery);
            if(!empty($insertMultipleFieldValue)){

                (new PropertyFieldValue())
                    ->where(['property_id' =>  $insertMultipleFieldValue['property_id'],'property_type_section_field_id' =>  $insertMultipleFieldValue['property_type_section_field_id']])
                    ->forceDelete();
                foreach($insertMultipleFieldValue['property_type_section_field_value']  as $propertyTypeSections){

                    $insertPropertyFieldValue[] = [

                        'property_id' =>  $insertMultipleFieldValue['property_id'],
                        'property_type_section_field_id' =>  $insertMultipleFieldValue['property_type_section_field_id'],
                        'property_type_section_field_value' =>  $propertyTypeSections,
                        'is_option' => '1',
                        'created_at' => date('Y-m-d h:i:s'),
                    ];
                }
            }
        }//pr($insertPropertyFieldValue,1);
        \DB::table('properties_field_values')->insert(
            $insertPropertyFieldValue
        );
        //return redirect()->route('seller-properties');
        return redirect()->route('show.property.availaibility',  ['propertyTypesId' => $propertyId]);

    }

    /*==============================
       Function For Updating Policy
    ================================*/
    public function policyUpdationRecord($policyId , $propertyID){
        $property = ProertiesPolicyUpdation::where( array( 'property_id' => $propertyID ,'policy_id' => $policyId) )->get();
        $data['policy_id'] = $policyId;
        $data['property_id'] = $propertyID;
        $data['created_at']=date('Y-m-d H:i:s');
        $data['updated_at']=date('Y-m-d H:i:s');
        $propertyPolicyObj = new ProertiesPolicyUpdation($data);
        $propertyPolicyObj->save();
    }

    /*================================
        Function For Removing Images
    ==================================*/
    public function updateImage(Request $request){
        $inputsValues = $request->all();
        $removeImgId = isset($inputsValues['removeImgId'])?$inputsValues['removeImgId']:'';
        $propertyId = $inputsValues['property_id'];
        $properties = (new PropertyFieldValue())
            ->rightjoin('property_type_section_fields', 'property_type_section_fields.id', '=', 'properties_field_values.property_type_section_field_id')
            ->where('properties_field_values.property_id', $propertyId)
            ->where('property_type_section_fields.field_identifier', 'basic_feature_image')
            ->select( 'properties_field_values.id', 'properties_field_values.property_type_section_field_value', 'property_type_section_fields.field_identifier')
            ->groupBy('properties_field_values.id')
            ->first();
        if( isset($removeImgId) ){
            $uploadedImages = json_decode($properties->property_type_section_field_value, true);
            if(file_exists(public_path(\Config::get('constants.IMAGE_FOLDER_NAME') . '/' . $uploadedImages[$removeImgId]['image']))) {
                unlink(public_path(\Config::get('constants.IMAGE_FOLDER_NAME') . '/' . $uploadedImages[$removeImgId]['image']));
                unlink(public_path(\Config::get('constants.IMAGE_FOLDER_NAME') . '/' . 'thumb_' . $uploadedImages[$removeImgId]['image']));
            }
            unset($uploadedImages[$removeImgId]);
            $uploadedImages = array_values($uploadedImages);
            foreach($uploadedImages as $key => $value) {
                $uploadedImages[$key]['id'] = $key;
            }
            $uploadedImages;
            $data['property_type_section_field_value'] = json_encode($uploadedImages);
            $updateQuery = (new PropertyFieldValue())
                ->where('properties_field_values.id', json_decode($properties->id, true))
                ->update($data);
            return response()->json(['success'=>true,'message'=>'Image is removed successfully', 'data' => json_encode($uploadedImages) ] );
        }
    }

}
