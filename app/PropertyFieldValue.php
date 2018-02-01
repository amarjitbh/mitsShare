<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyFieldValue extends Model
{
    protected $table = 'properties_field_values';

    protected $fillable = [
            'property_id','property_type_section_field_id','property_type_section_field_value','is_option', 'updated_at'
    ];

    /*=====================================================================
		Get Property Details Property id
		Param 1 : Property Id
        Join With  : property_type_section_fields, property_type_sections
    ======================================================================*/
    public function getPropertyDetail( $propertyId ){
        return $this
            ->join('property_type_section_fields', 'properties_field_values.property_type_section_field_id' ,'=','property_type_section_fields.id')
            ->join('property_type_sections', 'property_type_section_fields.property_type_section_id','=','property_type_sections.id')
            ->join('properties', 'properties.id', '=', 'properties_field_values.property_id')
            ->where(array('properties_field_values.property_id' => $propertyId,'property_type_sections.deleted_at' => null,'property_type_section_fields.deleted_at' => null))
            ->select('properties.seller_id','properties_field_values.is_option','properties_field_values.property_type_section_field_value',
                'property_type_section_fields.name as field_name','property_type_sections.name as section',
                'property_type_sections.id','property_type_section_fields.order_id', 'property_type_sections.order_id as orderId',
                'property_type_section_fields.field_identifier', 'property_type_section_fields.input_field_type_id', 'properties.is_approved_checked'
            )
           ->orderBy( 'orderId', 'ASC')
            ->orderBy('property_type_section_fields.order_id',"ASC")
            ->orderBy('orderId',"ASC")
            ->get()
            ->toArray();
    }
}
