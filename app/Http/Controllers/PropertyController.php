<?php
namespace App\Http\Controllers;
use App\Property;
use App\TemplateLog;
use Illuminate\Http\Request;
use App\PropertyType;
use App\PropertyTypeSection;
use App\PropertyTypeSectionFieldOption;
use App\PropertyTypeSectionField;
use App\PropertyFieldValue;
use App\Bookings;
use Carbon\Carbon;
use App\BookingDates;
use App\Http\Requests\StorePropertyTypeSectionField;
use App\Http\Requests\BookingPropertyRequest;
use App\PropertyAvailaibility;
use App\PropertyAvailaibilityDate;
use App\PropertyReviews;
use App\MessageToBeSend;
use App\CancellationPolicyType;
use App\User;
use DB;
use Auth;
use Session;
use Validator;
use Config;
use Request as AjaxRequest;

class PropertyController extends Controller
{

    public function index(Request $request){
        $Inputs = $request->all();
        $display = isset($Inputs['display']) ? $Inputs['display']  : 'grid';
        $order_by = isset($Inputs['filter_order_by']) ? $Inputs['filter_order_by'] : 1;
        $offset = isset($Inputs['offset']) ? $Inputs['offset'] :0;
        $offsetLimit=6;
        $propertyTypes = (new PropertyType())
            ->where(['deleted_at' => NULL])
            ->get(['name','id'])->toArray();
        $propertyTypesId = $request->input('property_type_id');
        $query  = Property::join('properties_field_values', 'properties_field_values.property_id', '=', 'properties.id')
            ->join('property_type_section_fields','property_type_section_fields.id','=', 'properties_field_values.property_type_section_field_id' )
            ->join('property_availaibility','property_availaibility.property_id','=', 'properties.id' )
            ->select('properties.id as propertyIds' ,'properties_field_values.property_type_section_field_value as price')
            ->where(array('property_type_section_fields.field_identifier' => 'basic_price', 'property_availaibility.is_blocked' => 1 ))
            ->whereExists(function ($query){
                $query->select(DB::raw(1))
                    ->from('property_availaibility')
                    ->join('property_availaibility_dates', 'property_availaibility_dates.property_availaibility_id', '=', 'property_availaibility.id')
                    ->whereRaw('property_availaibility.property_id = properties.id');
            });

        switch($order_by){
            case 2:
                $q = "CAST(price AS DECIMAL(10,2)) ASC";
                $allProperties = $query->orderByRaw($q)->skip($offset)->take($offsetLimit)->get()->toArray();
                break;
            case 3:
                $allProperties = $query->orderBy('properties.id', "DESC")->skip($offset)->take($offsetLimit)->get()->toArray();
                break;
            case 4:
                $allProperties = $query->orderBy('properties.id', "ASC")->skip($offset)->take($offsetLimit)->get()->toArray();
                break;
            default:
                $q = "CAST(price AS DECIMAL(10,2)) DESC";
                $allProperties = $query->orderByRaw($q)->skip($offset)->take($offsetLimit)->get()->toArray();
        }

        $propertyIDS = array();
        if(isset($allProperties)){
            foreach($allProperties as $value){
                $propertyIDS[] = $value["propertyIds"];
            }
        }
        if(count($propertyIDS)){
            $properties_data = (new Property())->getPropertyRelatedData($propertyIDS);
        }

        if(isset($properties_data)){
            $propertyArr = prepareDataForProperties($properties_data);
        } else {
            $propertyArr = 0;
        }
        if(AjaxRequest::ajax()) {
            $view = view( 'Propertytype.lazy_loading_home_page', compact( 'propertyTypes', 'propertyTypesId', 'propertyArr', 'display', 'allProperties',  'propertyTypesId', 'order_by' ))->render();
            if(!empty($propertyArr)){
                $result =[
                    'success' => 100,
                    'data' => $view,
                ];
            } else{
                $result =[
                    'success' => 50
                ];
            }
            return response()->json($result);
        } else {
            return view('Propertytype.property_index', compact('propertyTypes', 'propertyTypesId', 'propertyArr', 'display', 'allProperties', 'propertyTypesId', 'order_by'));
        }

    }

    public function propertyIndex(Request $request){

        $filters = $request->input('property_filters');
        $Inputs = $request->all();
        /*$currentLocationLatitude = isset($Inputs['currentLocationLatitude']) ? $Inputs['currentLocationLatitude']:0 ;
        $currentLocationlongitude = isset($Inputs['currentLocationlongitude']) ? $Inputs['currentLocationlongitude'] : 0;
        Session()->put('lat', $currentLocationLatitude);
        Session()->put('lng', $currentLocationlongitude);*/
        //$limit = isset($Inputs['limit']) ? (int)$Inputs['limit'] : 2;
        $searchDistance = Config::get('constants.SEARCH_DISTANCE');
        $setData = isset($Inputs['setData']) ? (int)$Inputs['setData'] : 0;
        if($setData==1){
            $startDate = isset($Inputs['start_date']) ? date("Y-m-d", strtotime($Inputs['start_date']))  : '' ;
            $distance = isset($Inputs['distance']) ? (int)$Inputs['distance'] : 0;
        }else{
            $startDate = isset($Inputs['start_date']) ? date("Y-m-d", strtotime($Inputs['start_date']))  : date("Y-m-d") ;
            $distance = isset($Inputs['distance']) ? (int)$Inputs['distance'] : $searchDistance;
        }
        $offset = isset($Inputs['offset']) ? (int)$Inputs['offset'] : 0;
        $latitude = isset($Inputs['lat']) ? $Inputs['lat'] :0;
        $longitude = isset($Inputs['long']) ? $Inputs['long'] :0;
        /*$getLatSearchBar = isset($Inputs['getLatSearchBar']) ? $Inputs['getLatSearchBar'] :0;
        $getLongSearchBar = isset($Inputs['getLongSearchBar']) ? $Inputs['getLongSearchBar'] :0;
        Session()->put('lat', $getLatSearchBar);
        Session()->put('lng', $getLongSearchBar);*/
        $order_by = isset($Inputs['filter_order_by']) ? $Inputs['filter_order_by'] : 1;
        $display = isset($Inputs['display']) ? $Inputs['display']  : 'grid';
        $endDate = isset($Inputs['end_date']) ? date("Y-m-d", strtotime($Inputs['end_date']))  : null;
        $min_price = isset($Inputs['min_price']) ? $Inputs['min_price'] : 0;
        $max_price = isset($Inputs['max_price']) ? $Inputs['max_price'] : 0;
        $propertyTypes = (new PropertyType())
            ->where(['deleted_at' => NULL])
            ->get(['name','id'])->toArray();
        $propertyTypesId = $request->input('property_type_id');
        $location = isset($Inputs['location']) ? $Inputs['location'] : '';
        $query  = Property::join('properties_field_values', 'properties_field_values.property_id', '=', 'properties.id')
            ->join('property_type_section_fields','property_type_section_fields.id','=', 'properties_field_values.property_type_section_field_id' )
            ->join('property_availaibility','property_availaibility.property_id','=', 'properties.id' )
            ->select(\DB::raw("@id :=( 6371 * acos( cos( radians(" . $latitude . ") ) * cos( radians(lat) ) *
            cos( radians(lng) - radians(" . $longitude . ") ) + sin( radians(" . $latitude . ") ) *
            sin( radians(lat) ) ) ) AS distance"), 'properties.id as propertyIds', 'properties.created_at' ,'properties_field_values.property_type_section_field_value as price' )
            ->where(array('property_type_section_fields.field_identifier' => 'basic_price', 'property_availaibility.is_blocked' => 1))
            ->groupBy('properties.id')
            ->when($distance, function($q) use ($distance){
                if(!empty($distance)) {
                    return $q->havingRaw('distance<=' . $distance);
                }
            })
            ->whereExists(function ($query) use ($startDate,$endDate) {
                $query->select(DB::raw(1))
                    ->from('property_availaibility')
                    ->join('property_availaibility_dates', 'property_availaibility_dates.property_availaibility_id', '=', 'property_availaibility.id')
                    ->where(function($query2) use ($startDate,$endDate) {
                        if( (isset($startDate)) && (isset($endDate))){
                            /*$query2->whereBetween('property_availaibility_dates.date', [$startDate, $endDate])
                                ->Where('property_availaibility_dates.is_booked',0);*/
                            $query2->whereDate('property_availaibility_dates.date', '>=',$startDate)
                                ->whereDate('property_availaibility_dates.date', '<=', $endDate)
                                ->Where('property_availaibility_dates.is_booked',0);

                        }elseif(isset($startDate)){
                            $query2->Where('property_availaibility_dates.date','>=', $startDate)
                                ->Where('property_availaibility_dates.is_booked',0);
                        }elseif(isset($endDate)){
                            $current_date = date("Y-m-d");
                            $query2->whereBetween('property_availaibility_dates.date', [$current_date, $endDate])
                                ->Where('property_availaibility_dates.is_booked',0);
                        }
                    })
                    ->whereRaw('property_availaibility.property_id = properties.id');
            })
            ->where(array('properties.property_type_id' => $propertyTypesId));
        $query = $query->whereExists(function ($query) use ( $min_price, $max_price) {
            $query->select(DB::raw(1))
                ->from('properties_field_values')
                ->join('property_type_section_fields', 'property_type_section_fields.id', '=', 'properties_field_values.property_type_section_field_id')
                ->where(function($query) use ($min_price,$max_price) {
                    if( (isset($min_price)) && (isset($max_price)) && ($max_price>0) ) {
                        $query->where('field_identifier', '=', 'basic_price')->whereBetween('properties_field_values.property_type_section_field_value', [(int)$min_price, (int)$max_price]);
                    }
                })
                ->whereRaw('properties_field_values.property_id = properties.id');
        });
        $query = $query->whereExists(function ($query) use ($filters) {
            $query->select(DB::raw(1))
                ->from('properties_field_values')
                ->join('property_type_section_fields', 'property_type_section_fields.id', '=', 'properties_field_values.property_type_section_field_id')
                ->where(function($query) use ($filters) {
                    if(isset($filters) && count($filters)){

                        $query->whereIn('properties_field_values.property_type_section_field_value', $filters);
                    }
                })
                ->whereRaw('properties_field_values.property_id = properties.id');
        });
        $offsetLimit = Config::get('constants.OFFSET_LIMIT_PROPERTY_SEARCH');
        switch($order_by){
            case 2:
                $q = "CAST(price AS DECIMAL(10,2)) ASC";
                $allProperties=$query->orderByRaw($q)->skip($offset)->take($offsetLimit)->get()->toArray();
                break;
            case 3:
                $allProperties = $query->orderBy('properties.created_at', "DESC")->skip($offset)->take($offsetLimit)->get()->toArray(); // Newest
                break;
            case 4:
                $allProperties = $query->orderBy('properties.created_at', "ASC")->skip($offset)->take($offsetLimit)->get()->toArray(); // Oldest
                break;
            case 5:
                $allProperties = $query->orderBy('distance', "ASC")->skip($offset)->take($offsetLimit)->get()->toArray(); // Sort By Distance Ascending
                break;
            case 6:
                $allProperties = $query->orderBy('distance', "DESC")->skip($offset)->take($offsetLimit)->get()->toArray(); // Sort By Distance Descending
                break;
            default:
                $q = "CAST(price AS DECIMAL(10,2)) DESC"; // Price High to low
                $allProperties = $query->orderByRaw($q)->skip($offset)->take($offsetLimit)->get()->toArray();
        }

        $propertyIDS = array();
        if(isset($allProperties)){
            foreach($allProperties as $value){
                $propertyIDS[] = $value["propertyIds"];
            }
        }

        if(count($propertyIDS)){
            $properties_data = (new Property())->getPropertyRelatedData($propertyIDS);
        }
        if(isset($properties_data)){
            $propertyArr = prepareDataForProperties($properties_data); // Defined in Helper
        } else {
            $propertyArr = 0;
        }
        $property_filters = (new PropertyTypeSection())->getPropertyFilters( $propertyTypesId, $min_price, $max_price );
        $filter_array = array();
        foreach($property_filters as  $key => $value){
            $filter_array[$value['name']][$value['id']] = $value['display_value'];
        }
        $count = count($propertyArr);
        return view( 'Propertytype.property_filter_results', compact( 'propertyTypes', 'propertyTypesId', 'propertyArr', 'display', 'allProperties', 'property_filters', 'location', 'propertyTypesId', 'startDate', 'endDate', 'min_price', 'max_price', 'filters', 'order_by', 'latitude', 'longitude', 'distance', 'offset','count', 'setData','filter_array' ));
    }

    public function propertyIndexAjax(Request $request){
        $filters = $request->input('property_filters');
        $Inputs = $request->all();
        //$limit = isset($Inputs['limit']) ? (int)$Inputs['limit'] : 2;
       /* $currentLocationLatitude = isset($Inputs['currentLocationLatitude']) ? $Inputs['currentLocationLatitude']:'' ;
        $currentLocationlongitude = isset($Inputs['currentLocationlongitude']) ? $Inputs['currentLocationlongitude'] : '';*/
        $searchDistance = Config::get('constants.SEARCH_DISTANCE');
        $setData = isset($Inputs['setData']) ? (int)$Inputs['setData'] : 0;
        if($setData==1){
            $startDate = isset($Inputs['start_date']) ? date("Y-m-d", strtotime($Inputs['start_date']))  : '' ;
            $distance = isset($Inputs['distance']) ? (int)$Inputs['distance'] : 0;
        }else{
            $startDate = isset($Inputs['start_date']) ? date("Y-m-d", strtotime($Inputs['start_date']))  : date("Y-m-d") ;
            $distance = isset($Inputs['distance']) ? (int)$Inputs['distance'] : $searchDistance;
        }

        $offset = isset($Inputs['offset']) ? (int)$Inputs['offset'] : 0;
        $latitude = isset($Inputs['lat']) ? $Inputs['lat'] :0;
        $longitude = isset($Inputs['long']) ? $Inputs['long'] : 0;
        $order_by = isset($Inputs['filter_order_by']) ? $Inputs['filter_order_by'] : 1;
        $display = isset($Inputs['display']) ? $Inputs['display']  : 'grid';

        $endDate = isset($Inputs['end_date']) ? date("Y-m-d", strtotime($Inputs['end_date']))  : null;
        $min_price = isset($Inputs['min_price']) ? $Inputs['min_price'] : 0;
        $max_price = isset($Inputs['max_price']) ? $Inputs['max_price'] : 0;
        $propertyTypes = (new PropertyType())
            ->where(['deleted_at' => NULL])
            ->get(['name','id'])->toArray();
        $propertyTypesId = $request->input('property_type_id');
        $location=$Inputs['location'];

        $query  = Property::join('properties_field_values', 'properties_field_values.property_id', '=', 'properties.id')
            ->join('property_type_section_fields','property_type_section_fields.id','=', 'properties_field_values.property_type_section_field_id' )
            ->join('property_availaibility','property_availaibility.property_id','=', 'properties.id' )
            ->select(\DB::raw("@id :=( 6371 * acos( cos( radians(" . $latitude . ") ) * cos( radians(lat) ) *
            cos( radians(lng) - radians(" . $longitude . ") ) + sin( radians(" . $latitude . ") ) *
            sin( radians(lat) ) ) ) AS distance"), 'properties.id as propertyIds' ,'properties_field_values.property_type_section_field_value as price' )
            ->where(array('property_type_section_fields.field_identifier' => 'basic_price', 'property_availaibility.is_blocked' => 1 ))
            ->groupBy('properties.id')
            ->when($distance, function($q) use ($distance){
                if(!empty($distance)) {
                    return $q->havingRaw('distance<=' . $distance);
                }
            })
            ->whereExists(function ($query) use ($startDate,$endDate) {
                $query->select(DB::raw(1))
                    ->from('property_availaibility')
                    ->join('property_availaibility_dates', 'property_availaibility_dates.property_availaibility_id', '=', 'property_availaibility.id')
                    ->where(function($query2) use ($startDate,$endDate) {
                        if( (isset($startDate)) && (isset($endDate))){
                            $query2->whereDate('property_availaibility_dates.date', '>=',$startDate)
                                ->whereDate('property_availaibility_dates.date', '<=', $endDate)
                                ->Where('property_availaibility_dates.is_booked',0);

                        }elseif(isset($startDate)){
                            $query2->Where('property_availaibility_dates.date','>=', $startDate)
                                ->Where('property_availaibility_dates.is_booked',0);
                        }elseif(isset($endDate)){
                            $current_date = date("Y-m-d");
                            $query2->whereBetween('property_availaibility_dates.date', [$current_date, $endDate])
                                ->Where('property_availaibility_dates.is_booked',0);
                        }
                    })
                    ->whereRaw('property_availaibility.property_id = properties.id');
            })
            ->where(array('properties.property_type_id' => $propertyTypesId));
        $query = $query->whereExists(function ($query) use ( $min_price, $max_price) {
            $query->select(DB::raw(1))
                ->from('properties_field_values')
                ->join('property_type_section_fields', 'property_type_section_fields.id', '=', 'properties_field_values.property_type_section_field_id')
                ->where(function($query) use ($min_price,$max_price) {
                    if( (isset($min_price)) && (isset($max_price)) && ($max_price>0) ) {
                        $query->where('field_identifier', '=', 'basic_price')->whereBetween('properties_field_values.property_type_section_field_value', [(int)$min_price, (int)$max_price]);
                    }
                })
                ->whereRaw('properties_field_values.property_id = properties.id');
        });
        $query = $query->whereExists(function ($query) use ($filters) {
            $query->select(DB::raw(1))
                ->from('properties_field_values')
                ->join('property_type_section_fields', 'property_type_section_fields.id', '=', 'properties_field_values.property_type_section_field_id')
                ->where(function($query) use ($filters) {
                    if(isset($filters) && count($filters)){
                        $query->whereIn('properties_field_values.property_type_section_field_value', $filters);
                    }
                })
                ->whereRaw('properties_field_values.property_id = properties.id');
        });
        $offsetLimit = Config::get('constants.OFFSET_LIMIT_PROPERTY_SEARCH');
       // echo $offsetLimit;
        switch($order_by){
            case 2:
                $q = "CAST(price AS DECIMAL(10,2)) ASC";
                //$allProperties = $query->orderByRaw($q)->paginate(4);
                //$allProperties = $query->orderByRaw($q)->offset($offset)->limit($limit)->get()->toArray();
                $allProperties=$query->orderByRaw($q)->skip($offset)->take($offsetLimit)->get()->toArray();
                break;
            case 3:
                $allProperties = $query->orderBy('properties.id', "DESC")->skip($offset)->take($offsetLimit)->get()->toArray();
                break;
            case 4:
                $allProperties = $query->orderBy('properties.id', "ASC")->skip($offset)->take($offsetLimit)->get()->toArray();
                break;
            case 5:
                $allProperties = $query->orderBy('distance', "ASC")->skip($offset)->take($offsetLimit)->get()->toArray(); // Sort By Distance Ascending
                break;
            case 6:
                $allProperties = $query->orderBy('distance', "DESC")->skip($offset)->take($offsetLimit)->get()->toArray(); // Sort By Distance Descending
                break;
            default:
                $q = "CAST(price AS DECIMAL(10,2)) DESC";
                $allProperties = $query->orderByRaw($q)->skip($offset)->take($offsetLimit)->get()->toArray();
        }
        $propertyIDS = array();
        if(isset($allProperties)){
            foreach($allProperties as $value){
                $propertyIDS[] = $value["propertyIds"];
            }
        }//pr($propertyIDS);
        if(count($propertyIDS)){
            $properties_data = (new Property())->getPropertyRelatedData($propertyIDS);
        }
        if(isset($properties_data)){
            $propertyArr = prepareDataForProperties($properties_data); // Defined in Helper
        } else {
            $propertyArr = 0;
        }//pr($propertyArr,1);
        $property_filters = (new PropertyTypeSection())->getPropertyFilters( $propertyTypesId, $min_price, $max_price );
        $view = view( 'Propertytype.property_filter_result_data', compact( 'propertyTypes', 'propertyTypesId', 'propertyArr', 'display', 'allProperties', 'property_filters', 'location', 'propertyTypesId', 'startDate', 'endDate', 'min_price', 'max_price', 'filters', 'order_by', 'latitude', 'longitude', 'distance', 'limit', 'offset' ))->render();

        if(!empty($propertyArr)){
            $result =[
                'success' => 100,
                'data' => $view,
            ];
        } else{
            $result =[
                'success' => 50
            ];
        }
        return response()->json($result);
    }

    /*======================
        Get Property Detail
    ========================*/
    public function propertyDetail(Request $request){
        $inputs = $request->all();
        $propertyId = $inputs['property_id'];
        $startDate ='';
        $endDate ='';
        $approvedBooking ='';
        $bookingId ='';
        if(isset($inputs['bookingId'])){
            $bookingId = $inputs['bookingId'];
            $bookingDate = (new Bookings())->getBookingDatesByBookingID( $bookingId );
            $startDate = $bookingDate[0]['date'];
            $endDate = $bookingDate[count($bookingDate) - 1]['date'];
            $bookingData = Bookings::where('booking_id', $bookingId)->first();
            $approvedBooking= $bookingData->is_approved;
        }
        $propertyDetails = (new PropertyFieldValue())->getPropertyDetail( $propertyId );
        $properties = Property::where('id', $propertyId)->first();
        $checked_requied=$properties['is_approved_checked'];
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
        $localDates = (new PropertyAvailaibility())->getPropertyAvailabilityDates( $propertyId );
        $available_dates= convertUtcToLocal($localDates, $properties->timezone_name); // Convert dates to local dates
        $propertyReviews = (new PropertyReviews())->getReviewOfBuyer( $propertyId );
        $totalReviewOfBuyer = (new PropertyReviews())->getTotalReviewOfBuyer( $propertyId );
        $section_array =   prepareDataForPropertyDetail( $propertyDetails );
        return view('Propertytype.property_detail',compact('bookingId','approvedBooking','startDate','endDate','checked_requied','section_array','available_dates', 'propertyId','display_values', 'propertyReviews', 'totalReviewOfBuyer'));
    }

    /*=================
         Book Property
     ===================*/
    public function bookProperty(BookingPropertyRequest $request){
        $inputs = $request->all();
        if(isset($inputs['approvedBooking'])){
            $bookingId = $inputs['bookingId'];
            $approvedBooking = $inputs['approvedBooking'];
            $availabilityIds = (new PropertyAvailaibility())->getPropertyAvailabilityBetweenDates( $inputs['property_id'], $inputs['start_date'], $inputs['end_date'] );
            $bookingDate = (new Bookings())->getBookingDatesByBookingID( $bookingId );
            if(count($availabilityIds) == count($bookingDate)){

                $booked = (new PropertyAvailaibilityDate())->dateBook( $availabilityIds );
                if($booked){
                    if( Bookings::where('booking_id', $bookingId)->update(array('payment_status' => 1))){

                        $this->sendConfrimedBookingEmail($inputs['property_id'],$inputs['start_date'], $inputs['end_date'],$inputs['ownerID']);
                        return response()->json(['success'=>true,'message'=>'Your Booking is done successfully'] );
                    } else {


                        return response()->json(['success'=>false,'message'=>'These dates are not available'] );
                    }
                }
            }else {
                return response()->json(['success'=>false,'message'=>'These dates are not available'] );
            }

        } else {

            $time = Config::get('constants.START_TIME');
            $approval_required = $inputs['approval_required'];
            $available  = (new PropertyAvailaibility())->checkIfBookedOnDate($inputs['property_id'],$inputs['start_date'], $inputs['end_date']);
            $propertydata = Property::where('id', $inputs['property_id'])->first();
            $cancelPolicyId= $propertydata['policy_types_id'];
            $bookDates = $inputs['bookFor'];
            $booking_dates = convertLocalToUTC($bookDates, $time, $propertydata->timezone_name); // Convert local to UTC dates
            $result = array_diff($booking_dates,$available);
            if(count($result)){
                return response()->json(['success'=>false,'message'=>'These dates are not available']);
            }
            if(Auth::user()->id == $inputs['ownerID'] ){
                return response()->json(['success'=>false,'message'=>'Can not book your own property']);
            }
            $property_status= $this->getPropertyStatus($inputs['property_id']);
            $propertyTimezone= $property_status['timezone_name'];
            $dateResult = getUtcTime($propertyTimezone);
            $currentDateTime=$dateResult['currentTime'];
            $utcDateTime=$dateResult['utcTime'];
            $statusvalue = $property_status->is_approved_checked;
            $data['property_id'] = $inputs['property_id'];
            $data['user_id'] = Auth::user()->id;
            $data['property_owner_id'] = $inputs['ownerID'];
            $data['total_amount'] = $inputs['total_amount'];
            $data['policy_id'] = $cancelPolicyId;
            $data['utc_time'] = $utcDateTime;
            $data['payment_status'] = 0;
            if($statusvalue==1){
                $data['is_approved'] = 0;
                $data['payment_status'] = 0;
                $data['through_approval'] = 1;
            } else {
                $data['is_approved'] = 1;
                $data['payment_status'] = 1;
                $data['through_approval'] = 0;
            }
            $bookObj = new Bookings($data);
            if( $bookObj->save() ){
                $propertyName = (new PropertyFieldValue())->getPropertyDetail($inputs['property_id']);
                $propertyFullName = '';
                $routefunction = '<a href="'.route('pending-approval-booking-properties').'">Click here</a>';
                foreach($propertyName as $property){
                    if($property['field_name'] == 'Name'){
                        $propertyFullName = $property['property_type_section_field_value'];
                    }
                }
                $property_owner_details = User::where('id', $inputs['ownerID'])->first();
                $buyerDetail = User::where('id', $data['user_id'])->first();
                $book['booking_id']=$bookObj->id;

                $userName   = $property_owner_details['first_name'].' '.$property_owner_details['Last_name'];
                $buyer = $buyerDetail['first_name'].' '.$buyerDetail['last_name'];
                $templateLog = (new TemplateLog())->where(['template_log_id' => '3'])->first();
                $userTaskDes = array("#user_name#","#buyer_name#","#property_name#","#from_date#",'#end_date#',"#click_here#");
                $userTaskRep   = array($userName,$buyer,$propertyFullName,$inputs['start_date'],$inputs['end_date'],$routefunction);
                $messages = $templateLog->message;
                $newTaskDes = str_replace($userTaskDes,$userTaskRep,$messages);
                $messageBody = $newTaskDes;
                if($statusvalue==1){

                    $message['bookingId'] = $bookObj->id;
                    $message['approved_token'] = md5(time());
                    $message['email'] = $property_owner_details['email'];
                    $message['subject'] = "Property Approval";
                    $message['mobile_no'] = $property_owner_details['mobile_number'];
                    $message['is_send'] = "1";
                    $message['body'] = $messageBody;
                    $message['url'] = "/success";
                    $message['type'] = 1;
                    $sendObj = new MessageToBeSend($message);
                    $sendObj->save();
                }
                if($statusvalue == 0){

                    $this->sendConfrimedBookingEmail($inputs['property_id'],$inputs['start_date'], $inputs['end_date'],$inputs['ownerID']);
                }
                foreach($booking_dates as $values){
                    $book['date'] = $values;
                    $bookDatesObj = new BookingDates($book);
                    $bookDatesObj->save();
                }
                //$availabilityIds = (new PropertyAvailaibility())->getPropertyAvailabilityBetweenDates( $inputs['property_id'], $inputs['start_date'], $inputs['end_date'] );
                $availabilityIds = (new PropertyAvailaibility())->getIsRequestedDates( $inputs['property_id'], $inputs['start_date'], $inputs['end_date'] );
                 (new PropertyAvailaibilityDate())->setIsRequested( $availabilityIds ); // set IsRequested = 1
                if($approval_required==0){ // 0 => Automatically booked no approval of seller is required.
                    (new PropertyAvailaibilityDate())->dateBook( $availabilityIds ); // Set is_booked key to 1
                }
                return response()->json(['is_approved'=>$statusvalue,'success'=>true,'message'=>'Your Booking is done successfully'] );
            } else {
                return response()->json(['success'=>false,'message'=>'Something went wrong'] );
            }
        }
    }

    function sendConfrimedBookingEmail($propertyId,$startDate,$endDate,$ownerId){

        $propertyName = (new PropertyFieldValue())->getPropertyDetail($propertyId);
        $propertyFullName = '';
        $routefunction = '<a href="'.route('pending-approval-booking-properties').'">Click here</a>';
        foreach($propertyName as $property){
            if($property['field_name'] == 'Name'){

                $propertyFullName = $property['property_type_section_field_value'];
            }
        }
        $property_owner_details = User::where('id', $ownerId)->first();
        $buyerDetail = User::where('id', Auth::user()->id)->first();
        $userName   = $property_owner_details['first_name'].' '.$property_owner_details['Last_name'];
        $buyer = $buyerDetail['first_name'].' '.$buyerDetail['last_name'];
        $templateLog = (new TemplateLog())->where(['template_log_id' => '5'])->first();
        $userTaskDes = array("#user_name#","#buyer_name#","#property_name#","#from_date#",'#end_date#');
        $userTaskRep   = array($userName,$buyer,$propertyFullName,$startDate,$endDate);
        $messages = $templateLog->message;
        $newTaskDes = str_replace($userTaskDes,$userTaskRep,$messages);
        $messageBody = $newTaskDes;

        $messageData = [

            'type'      => '1',
            'subject'   => 'Property Booked',
            'body'      => $messageBody,
            'email'     => $property_owner_details['email'],
            'mobile_no' => $property_owner_details['mobile_number'],
            'is_send'   => "1",
            'status'    => '0',
            'url'       => "/success",
        ];
        (new MessageToBeSend())->insert($messageData);

        $templateLog = (new TemplateLog())->where(['template_log_id' => '6'])->first();
        $userTaskDes = array("#user_name#","#property_name#","#from_date#",'#end_date#');
        $userTaskRep   = array($buyer,$propertyFullName,$startDate,$endDate);
        $messages = $templateLog->message;
        $newTaskDes = str_replace($userTaskDes,$userTaskRep,$messages);
        $messageBody = $newTaskDes;

        $messageData = [

            'type'      => '1',
            'subject'   => 'Booking Confirmation',
            'body'      => $messageBody,
            'email'     => $buyerDetail['email'],
            'mobile_no' => $buyerDetail['mobile_number'],
            'is_send'   => "1",
            'status'    => '0',
            'url'       => "/success",
        ];
        (new MessageToBeSend())->insert($messageData);
    }

    /*======================================================
        Function for getting the Approval Status of Property
    ========================================================*/
    public function getPropertyStatus($property_id){
        return $propertyResult  = (new Property())->getApprovedStatus($property_id);
    }

    /*==================================
        Function for Approve the Booking
    =====================================*/
    public function approvedBooking($approved_token){

        $MessageToBeSend = MessageToBeSend::where( array( 'approved_token' => $approved_token ) )->first();
        if(Bookings::where('booking_id', $MessageToBeSend->bookingId)->update(array('is_approved' => 1)) ){
            return redirect('/thanks')->with('message', 'Ï.');
        } else {
            return redirect('/thanks')->with('message', 'Something went wrong.');
        }
    }

    /*==================================
        Pending for comment
    =====================================*/
    public function thanks(){
        return view('thanks');
    }

    /*===============================================
        Function for Getting the Properties of seller
    ==================================================*/
    public function sellerProperties(Request $request){
        $inputs = $request->all();
        $propertyId = $inputs['propertyId'];
        $sellerId = $inputs['sellerId'];
        $button = $inputs['button'];
        $query = (new Property())->getPropertyWithPropertyIdAndSellerId($sellerId,$propertyId,$button);
        if(count($query) == 0) {
            $query = (new Property())->getFirstPropertyWithPropertyIdAndSellerId($sellerId,$propertyId,$button);
        }
        $allPropertiesData = $query->toArray();
        $propertyIDS = array();
        if(isset($allPropertiesData)){
            $propertyIDS[] = $allPropertiesData["propertyIds"];
        }

        if(count($propertyIDS)){
            $properties_data = (new Property())->getSellerPropertyRelatedData($propertyIDS);
        }
        //pr($properties_data,1);
        if(isset($properties_data)){
            $properties = prepareDataForSellerProperties($properties_data); // Defined in Helper
        }
        //pr($properties,1);
        $array_key = key($properties);
        $sellerPropertyData =  view('Propertytype.seller-properties-at-guest')->with('properties',$properties[$array_key])->render();
        if(!empty($properties)){

            $ary = [
                'success' => '100',
                'data'    => $sellerPropertyData
            ];
        }else{

            $ary = [
                'success' => 50
            ];
        }
        return response()->json($ary);
        //return response(json_encode($ary));
    }

}
