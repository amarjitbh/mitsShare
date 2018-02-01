<?php

namespace App\Http\Requests\Seller;

use App\PropertyTypeSection;
use App\Validation;
use Illuminate\Support\MessageBag;
use \Validator;
use Illuminate\Foundation\Http\FormRequest;

class PropertiesFieldValues extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    private $attribute = [];
    private $messages = [];
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
            ->select('property_type_section_fields.id as property_type_section_fields_id','property_type_section_fields.name', 'validations','input_field_type_id')
            ->get()->toArray();
        $validations = [];
        foreach($propertyTypesSections as $index => $propertyTypesSection) {

            if(!empty($requestUrl['property_id']) && $propertyTypesSection['input_field_type_id']) {

                $explodeValidations = explode(',', $propertyTypesSection['validations']);
                $validations[$propertyTypesSection['property_type_section_fields_id'] . '_' . str_replace(' ', '', $propertyTypesSection['name'])] = ($propertyTypesSection['input_field_type_id'] == \Config::get('constants.ADMIN_DEFAULT_PROPERTY_FEILDS_TYPE_ID.3')) ? '' : str_replace(',', '|', ($propertyTypesSection['validations'] == 'numeric' ? 'nullable,numeric': $propertyTypesSection['validations']));

                if (!empty($propertyTypesSection['validations'])) {
                    foreach ($explodeValidations as $explodeValidation) {

                        $this->attribute[$propertyTypesSection['property_type_section_fields_id'] . '_' . $propertyTypesSection['name']] = $propertyTypesSection['name'];
                    }
                }
            }else{

                $explodeValidations = explode(',', $propertyTypesSection['validations']);
                $validations[$propertyTypesSection['property_type_section_fields_id'] . '_' . str_replace(' ', '', $propertyTypesSection['name'])] = str_replace(',', '|', ($propertyTypesSection['validations'] == 'numeric' ? 'nullable,numeric': $propertyTypesSection['validations']));
                if (!empty($propertyTypesSection['validations'])) {
                    foreach ($explodeValidations as $explodeValidation) {

                        $this->attribute[$propertyTypesSection['property_type_section_fields_id'] . '_' . $propertyTypesSection['name']] = $propertyTypesSection['name'];
                    }
                }
            }
        }
        //pr($this->attribute);
        //pr($validations,1);
        return $validations;
    }

    public function messages() {

        return $this->messages;
    }

    public function attributes(){

        return $this->attribute;
    }
}
