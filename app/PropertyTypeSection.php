<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class PropertyTypeSection extends Model
{
    use SoftDeletes;
	
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'property_type_id', 'name','order_id'
    ];
    
    public function propertytypesectionfield(){
        return $this->hasMany('App\PropertyTypeSectionField', 'property_type_section_id', 'id');
    }
    
    public function propertytype() {
        return $this->belongsTo('App\PropertyType', 'property_type_id', 'id');
    }

    /*=====================================================================
		Get Property Filters Using Property id
		Param 1 : Property type Id
        Join With  : property_type_section_fields, properties_field_values
    ========================================================================*/
    /*public function getPropertyFilters( $propertyTypesId, $min_price, $max_price ){
        return $this
            ->join( 'property_type_section_fields', 'property_type_sections.id', '=', 'property_type_section_fields.property_type_section_id' )
            ->join( 'properties_field_values', 'properties_field_values.property_type_section_field_id', '=', 'property_type_section_fields.id' )
            ->where( array( 'property_type_sections.property_type_id' => $propertyTypesId, 'property_type_section_fields.display_to_filter' => 1 ) )
           // ->select( 'property_type_section_fields.id', 'property_type_section_fields.name','property_type_section_fields.property_type_section_id')
            ->pluck( 'property_type_section_fields.id')
            ->toArray();
    }*/
    /*public function getPropertyFilters( $propertyTypesId, $min_price, $max_price ){
        return $this
            ->join( 'property_type_section_fields', 'property_type_sections.id', '=', 'property_type_section_fields.property_type_section_id' )
            ->join( 'properties_field_values', 'properties_field_values.property_type_section_field_id', '=', 'property_type_section_fields.id' )
            ->join( 'property_type_section_field_options', 'properties_field_values.property_type_section_field_id', '=', 'property_type_section_field_options.property_type_section_field_id' )
            ->where( array( 'property_type_sections.property_type_id' => $propertyTypesId, 'property_type_section_fields.display_to_filter' => 1 ) )
            ->whereIn( 'property_type_section_fields.input_field_type_id',[2,3,11] )
            ->select( 'property_type_section_field_options.display_value', 'properties_field_values.id', 'property_type_section_fields.name', 'properties_field_values.property_type_section_field_value','field_identifier' )
            ->distinct()
            ->get()
            ->toArray();
    }*/
    public function getPropertyFilters( $propertyTypesId, $min_price, $max_price ){
        return $this
            ->leftjoin( 'property_type_section_fields', 'property_type_sections.id', '=', 'property_type_section_fields.property_type_section_id' )
            ->join( 'property_type_section_field_options', 'property_type_section_fields.id', '=', 'property_type_section_field_options.property_type_section_field_id' )
            //->join( 'properties_field_values', 'properties_field_values.property_type_section_field_id', '=', 'property_type_section_fields.id' )
           // ->join( 'property_type_section_field_options', 'properties_field_values.property_type_section_field_id', '=', 'property_type_section_field_options.property_type_section_field_id' )
            ->where( array( 'property_type_sections.property_type_id' => $propertyTypesId, 'property_type_section_fields.display_to_filter' => 1 ) )
            ->whereIn( 'property_type_section_fields.input_field_type_id',[2,3,11] )
            ->select( 'property_type_section_field_options.id','property_type_section_field_options.display_value', 'property_type_section_fields.name' )
           // ->groupBy('properties_field_values.property_type_section_field_value')
            ->get()
            ->toArray();
    }
    /*public function getPropertyFilters( $propertyTypesId, $min_price, $max_price ){
        return $this
            ->join( 'property_type_section_fields', function($join) {
                $join->on('property_type_sections.id', '=', 'property_type_section_fields.property_type_section_id')
                    ->where('field_identifier', '=', 'basic_price');
            })
            ->join( 'properties_field_values', 'properties_field_values.property_type_section_field_id', '=', 'property_type_section_fields.id' )
            ->where( array( 'property_type_sections.property_type_id' => $propertyTypesId, 'property_type_section_fields.display_to_filter' => 0 ) )
             ->where(function($query) use ($min_price,$max_price) {
                 if( (isset($min_price)) && (isset($max_price)))  {
                     $query->where('field_identifier', '=', 'basic_price')->whereBetween('properties_field_values.property_type_section_field_value', [(int)$min_price, (int)$max_price]);
                 }
             })
            // ->whereBetween('properties_field_values.property_type_section_field_value', [(int)$min_price, (int)$max_price])
            ->select( 'properties_field_values.id', 'property_type_section_fields.name', 'properties_field_values.property_type_section_field_value', 'field_identifier' )
            ->get()
            ->toArray();
    }*/
}
