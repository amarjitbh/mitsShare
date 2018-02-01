<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\PropertyTypeSection;


class StorePropertyTypeSectionField extends FormRequest
{
   // private $messages = [];
    private $attribute = [];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $requestUrl = \Request::all();

        $id = $requestUrl['property_types_id'];

        $propertyTypesSections = (new PropertyTypeSection())
            ->rightjoin('property_type_section_fields', 'property_type_section_fields.property_type_section_id','=', 'property_type_sections.id')
            ->where('property_type_sections.property_type_id' , $id)
            ->select('property_type_section_fields.id as property_type_section_fields_id','property_type_section_fields.name', 'validations')
            ->get()->toArray();

        $validations = [];
        foreach($propertyTypesSections as $index => $propertyTypesSection) {
            $explodeValidations = explode(',', $propertyTypesSection['validations']);
            $validations[$propertyTypesSection['property_type_section_fields_id']] = str_replace(',', '|', $propertyTypesSection['validations']);



            foreach($explodeValidations as $explodeValidation) {
              //  $this->messages[$propertyTypesSection['property_type_section_fields_id'].'.'.$explodeValidation] = ':attribute '.$propertyTypesSection['name'];
                $this->attribute[$propertyTypesSection['property_type_section_fields_id']] = $propertyTypesSection['name'];
            }
        }
       //pr($propertyTypesSections);
        //pr($validations);
       //die;

     return $validations;
    }


    public function attributes()
    {

       pr($this->attribute);
      //  die;
       return $this->attribute;

    }

}
