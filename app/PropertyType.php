<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
 
class PropertyType extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
 
protected $table = 'property_types';
 
    protected $fillable = [
        'name', 'deleted_at'
    ];
 
 
    public  function getPropertyTypeInformation(){
        return $this
            ->join('property_type_sections','property_type_sections.property_type_id','=','property_types.id')
            ->join('property_type_section_fields','property_type_section_fields.property_type_section_id','=','property_type_sections.id')
            ->join('property_type_section_field_options','property_type_section_field_options.property_type_section_field_id','=','property_type_section_fields.id')
            ->where(['property_type_sections.deleted_at' => NULL,'property_types.deleted_at' => NULL])
            ->select('property_type_sections.name','property_type_sections.order_id as property_type_section_order_id','property_types.name as property_type_name','property_type_section_fields.name','property_type_section_fields.input_field_type_id','property_type_section_fields.validations','property_type_section_fields.order_id','property_type_section_field_options.display_value','property_type_section_field_options.order_id as property_type_section_field_options_order_id')
            ->get();
    }
    
    public function propertytypesection()
    {
        return $this->hasMany('App\PropertyTypeSection', 'property_type_id', 'id');
 
    }
    
    
   /* 
    protected static function boot() {
    parent::boot();
 
    static::deleting(function($propertytypes) {
        $propertytypes->propertytypesection()->delete();
    });
}
*/
 
 
}
