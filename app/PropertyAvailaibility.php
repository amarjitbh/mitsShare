<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyAvailaibility extends Model
{
	protected $table = 'property_availaibility';


	/*=====================================
		Get Property Booked dates lists
		Param 1 : Property Id
		Param 2 : Start Date
		Param 3 : End Date
	 ======================================*/
	public  function getBookedDates( $propertyId ){
		 $current_date = getServerUtcTime();
		return $this
			->join('property_availaibility_dates','property_availaibility.id','=','property_availaibility_dates.property_availaibility_id')
			->whereIn('property_availaibility.property_id', $propertyId)
			->where(array('property_availaibility_dates.is_booked'=> 1))
			->Where('property_availaibility_dates.date','>=', $current_date)
			->select(
				\DB::raw('group_concat(property_availaibility_dates.date) as date'),
				'property_availaibility.property_id')
			->groupBy('property_availaibility.property_id')
			->pluck('date', 'property_id')
			->toArray();
	}


	/*==========================================================================
		Get Property Available Date Based On Property id and (Start and EndDate)
		Param 1 : Property Id
		Param 2 : Start Date
		Param 3 : End Date
	 ============================================================================*/
	public function getPropertyAvailabilityBetweenDates( $propertyId, $startDate, $endDate ){
		return $this
			->join('property_availaibility_dates','property_availaibility.id','=','property_availaibility_dates.property_availaibility_id')
			->where(array('property_availaibility.property_id' => $propertyId))
			->where(array('property_availaibility_dates.is_booked'=> 0))
			->whereDate('property_availaibility_dates.date', '>=',$startDate)
			->whereDate('property_availaibility_dates.date', '<=', $endDate)
			->pluck('property_availaibility_dates.id')
			->toArray();
	}

	/*==========================================================================
		Get Property Available Date Based On Property id and (Start and EndDate)
		Param 1 : Property Id
		Param 2 : Start Date
		Param 3 : End Date
	 ============================================================================*/
	public function getIsRequestedDates( $propertyId, $startDate, $endDate ){
		return $this
			->join('property_availaibility_dates','property_availaibility.id','=','property_availaibility_dates.property_availaibility_id')
			->where(array('property_availaibility.property_id' => $propertyId,'property_availaibility_dates.is_requested'=> 0))
			->whereDate('property_availaibility_dates.date', '>=',$startDate)
			->whereDate('property_availaibility_dates.date', '<=', $endDate)
			->pluck('property_availaibility_dates.id')
			->toArray();
	}


/*================================================================================
		Get Property Available Date Based On Property id and (Start and EndDate) for approval
		Param 1 : Property Id
		Param 2 : Start Date
		Param 3 : End Date
	 ============================================================================*/
	public  function getPropertyAvailabilityBetweenDatesFree( $propertyId, $startDate, $endDate ){
		return $this
			->join('property_availaibility_dates','property_availaibility.id','=','property_availaibility_dates.property_availaibility_id')
			->where(array('property_availaibility.property_id' => $propertyId))
			->where(array('property_availaibility_dates.is_booked'=> 0))
			->where('property_availaibility_dates.date', '>=',$startDate)
			->where('property_availaibility_dates.date', '<=', $endDate)
			->pluck('property_availaibility_dates.id')
			->toArray();
	}

	
	/*==========================================================================
		Get Property Available Date Based On Property id and (Start and EndDate)
		Param 1 : Property Id
		Param 2 : Start Date
		Param 3 : End Date
	 ============================================================================*/
	 
	public  function cancelGetPropertyAvailabilityBetweenDates1( $propertyId, $startDate, $endDate ){

		return $this
			->join('property_availaibility_dates','property_availaibility.id','=','property_availaibility_dates.property_availaibility_id')
			->where(array('property_availaibility.property_id' => $propertyId))
			->where(array('property_availaibility_dates.is_requested'=> 1))
			->where('property_availaibility_dates.date', '>=',$startDate)
			->where('property_availaibility_dates.date', '<=', $endDate)
			->pluck('property_availaibility_dates.id')
			->toArray();
	}


	public  function cancelGetPropertyAvailabilityBetweenDates( $propertyId, $startDate, $endDate ){

		return $this
			->join('property_availaibility_dates','property_availaibility.id','=','property_availaibility_dates.property_availaibility_id')
			->where(array('property_availaibility.property_id' => $propertyId))
			->where(array('property_availaibility_dates.is_booked'=> 1))
			->where('property_availaibility_dates.date', '>=',$startDate)
			->where('property_availaibility_dates.date', '<=', $endDate)
			->pluck('property_availaibility_dates.id')
			->toArray();
	}

	/*====================================================
		Get Property Available Dates Based On Property id
		Param 1 : Property Id
	 =====================================================*/
	public function getPropertyAvailabilityDates( $propertyId ){
		$date = getServerUtcTime();
		return $this
			->join('property_availaibility_dates', 'property_availaibility.id','=','property_availaibility_dates.property_availaibility_id')
			->where(array('property_availaibility.property_id' => $propertyId, 'property_availaibility_dates.is_requested' => 0))
			->where('property_availaibility_dates.date','>=' ,$date)
			->pluck('property_availaibility_dates.date')
			->toArray();
	}
	/*====================================================
		Get Property Available Dates Based On Property id
		Param 1 : Property Id
	 =====================================================*/
	public function getPropertySelectedDatesAndDays( $propertyId ){

		return $this
			->join('property_availaibility_dates', 'property_availaibility.id','=','property_availaibility_dates.property_availaibility_id')
			->where(array('property_availaibility.property_id' => $propertyId))
			->select('property_availaibility_dates.date','property_availaibility.avalaibility_option','is_booked','is_requested','property_availaibility.is_blocked')
			->orderBy('property_availaibility_dates.date','ASC')
			->get()
			->toArray();
	}

	public function getPropertySelectedFilterWithDate( $propertyId,$date ){
		return $this
			->join('property_availaibility_dates', 'property_availaibility.id','=','property_availaibility_dates.property_availaibility_id')
			->where(['property_availaibility.property_id' => $propertyId])
			->whereDate('property_availaibility_dates.date','=',$date)
			->select('property_availaibility_dates.is_booked','property_availaibility_dates.is_requested','property_availaibility_dates.date','property_availaibility.avalaibility_option','property_availaibility.is_blocked')
			->first();
	}

	/*========================
      	Cancel booking Date
       	Param 1 : $propertyId
		Param 2 : $startDate
		Param 3 : $endDate
    ==========================*/
	public function getPropertyBookingDatesWithDates( $propertyId, $startDate, $endDate ){
		return $this
				->join('property_availaibility_dates','property_availaibility.id','=','property_availaibility_dates.property_availaibility_id')
				->where(array('property_availaibility.property_id'=>$propertyId))
				->where(array('property_availaibility_dates.is_booked'=> 1))
				->whereBetween('property_availaibility_dates.date', [$startDate,$endDate])
				->pluck('property_availaibility_dates.id')
				->toArray();
	}

	/*====================================================
		Get Property Available Dates Based On Property id
		Param 1 : $propertyId
		Param 2 : $startDate
		Param 3 : $endDate
	 =====================================================*/
	/*public function checkIfBookedOnDate( $propertyId, $startDate, $endDate ){
		return $this
			->join('property_availaibility_dates','property_availaibility.id','=','property_availaibility_dates.property_availaibility_id')
			->where(array('property_availaibility.property_id' => $propertyId))
			->whereBetween('property_availaibility_dates.date', [$startDate, $endDate])
			->Where(array('property_availaibility_dates.is_booked'=>0))
			->pluck('date')
			->toArray();
	}*/

	/*====================================================
		Get Property Available Dates Based On Property id
		Param 1 : $propertyId
		Param 2 : $startDate
		Param 3 : $endDate
	 =====================================================*/
	public function checkIfBookedOnDate( $propertyId, $startDate, $endDate ){
		return $this
			->join('property_availaibility_dates','property_availaibility.id','=','property_availaibility_dates.property_availaibility_id')
			->where(array('property_availaibility.property_id' => $propertyId))
			->whereDate('property_availaibility_dates.date', '>=',$startDate)
			->whereDate('property_availaibility_dates.date', '<=', $endDate)
			->Where(array('property_availaibility_dates.is_booked'=>0))
			->pluck('date')
			->toArray();
	}
}
