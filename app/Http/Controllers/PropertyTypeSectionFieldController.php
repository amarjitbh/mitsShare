<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\PropertyType;
use App\PropertyTypeSection;
use App\InputFieldType;
use App\Validation;
use App\User;
use App\PropertyTypeSectionField;
use App\PropertyTypeSectionFieldOption;
use Mockery\CountValidator\Exception;
use Validator;
use Illuminate\Support\Facades\DB;

class PropertyTypeSectionFieldController extends Controller
{


    public function singlefieldedit($field_id){
        $InputFieldTypes = InputFieldType::all();
        $Validations = Validation::all();
        $section_field = PropertyTypeSectionField::with(['propertytypesectionfieldoption' => function ($query) {
        }])->where('id', $field_id)->get();
        $section_field = $section_field->toArray();
        $section_field = $section_field[0];
        return view('PropertyTypeSectionField.singlefieldedit', compact('InputFieldTypes', 'section_field', 'Validations'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $PropertyType = new PropertyType;
        $PropertyTypeSection = new PropertyTypeSection;
        //Get all the information associated with given ID
        $PropertyType = PropertyType::find($id);
        $PropertyTypeSections = PropertyTypeSection::where('property_type_id', $id)->orderBy('order_id', 'asc')->get();
        $InputFieldTypes = InputFieldType::all();
        $Validations = Validation::all();
        //And return to  edit.blade.php view file.
        return view('Propertytype.edit', compact('PropertyType', 'PropertyTypeSections', 'InputFieldTypes', 'Validations'));
    }
}
