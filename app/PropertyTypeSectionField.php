<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyTypeSectionField extends Model
{
     use SoftDeletes;
	
    protected $dates = ['deleted_at'];



     public function propertytypesectionfieldoption()
    {
        return $this->hasMany('App\PropertyTypeSectionFieldOption', 'property_type_section_field_id', 'id');
    }
    

      public function propertytypesection()
    {
        return $this->belongsTo('App\PropertyTypeSection', 'property_type_section_id', 'id');
    }
    public function propertyTypeSectionFieldValue()
    {

        return (new PropertyTypeSectionField())->hasMany(PropertyTypeSectionFieldOption::class,  'property_type_section_field_id', 'id');
    }

}
