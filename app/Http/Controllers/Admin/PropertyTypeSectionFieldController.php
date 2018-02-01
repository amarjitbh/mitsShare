<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $PropertyTypes = PropertyType::Paginate(10);
        return view('Propertytype.index', compact('PropertyTypes'));
    }


    public function order(Request $request) {
        $custom_query_part1 = "";
        $custom_query_part2 = implode(",",$request->section_field_id);
        $order_id_counter = 1;
        foreach($request->section_field_id as $value)  {
            $custom_query_part1 .= " WHEN id = $value THEN $order_id_counter ";
            $order_id_counter++;
            }
            $main_query =  "UPDATE `property_type_section_fields` SET `order_id` = CASE 
                $custom_query_part1 
                    ELSE `order_id`
                     END
            WHERE id  in ($custom_query_part2)";
            DB::update($main_query);
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($propertysectionid, $propertypeid) {
        $section_fields = PropertyTypeSectionField::with(['propertytypesectionfieldoption' => function ($query) {
                            }])
                        ->where('property_type_section_id', $propertysectionid)->orderBy('order_id', 'asc')->get();
        $InputFieldTypes = InputFieldType::all();
        $Validations = Validation::all();//pr($Validations->toArray(),1);
        return view('admin/property_type_section_field.create', compact('InputFieldTypes', 'Validations', 'propertysectionid', 'section_fields','propertypeid'));
    }
    
    
    
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     
    public function store(Request $request) {
        try {
            $PropertyTypeSection_data = PropertyTypeSection::find($request->property_type_section_id);
            $PropertyTypeSection_data = PropertyTypeSection::find($request->property_type_section_id);
            $propertytypesection_id_arr = PropertyTypeSection::where('property_type_id', $PropertyTypeSection_data->property_type_id)->get();
            $arr_propertytypesectionid = array();
            foreach ($propertytypesection_id_arr as $value) {
                $arr_propertytypesectionid[] = $value->id;
            }

            $arr_propertytypesectionid = implode(",", $arr_propertytypesectionid);
            $rules = [
                // 'property_type_section_field_name' =>"required|unique:property_type_section_fields,name,NULL,id,property_type_section_id," . $request->property_type_section_id,
                //'validations' => 'required',
                //'property_type_section_field_name' => 'unique_custom:property_type_section_fields,property_type_section_id,name,, ,
                //unique_custom:property_type_section_fields,NULL,NULL,name,property_type_section_id,' . $arr_propertytypesectionid,
                'property_type_section_field_name' => 'required',
                'property_type_section_field_option_name.*' => 'required',
                'selected_field' => 'required',
            ];

            $customMessages = [
                'property_type_section_field_name.required' => 'The Field Name is required',
                //'validations.required' => 'Please select atleast 1 of the field validations',
                'property_type_section_field_option_name.*required' => 'The Section Field Option is Required',
                'selected_field.required' => 'The Field Type is Required',
                'property_type_section_field_name.unique_custom' => 'The Field Name must be unique, you have already defined the field with same name',
            ];

            $this->validate($request, $rules, $customMessages);

            $property_type_section_field_name = $request->property_type_section_field_name;

            $selected_field = $request->selected_field;
            $validations = $request->validations;
            $InputFieldTypes = InputFieldType::all();
            $Validations = Validation::all()->toArray();

            if (sizeof($Validations)) {
                foreach ($Validations as $value) {
                    $newvalidations[$value["id"]] = $value["validation"];
                }
            }

            if (!$validations) {
                $validations = array();
            }

            $validations = array_flip($validations);
            $result = array_intersect_key($newvalidations, $validations);
            $validation_string = implode(",", $result);
            //echo "validation string is " . $validation_string;
            //$validation_string = array_intersect_key($a1,$a2);
                $PropertyTypeSectionField = new PropertyTypeSectionField;
                $PropertyTypeSectionField->property_type_section_id = $request->property_type_section_id;
                $PropertyTypeSectionField->name = $request->property_type_section_field_name;
                $PropertyTypeSectionField->display_to_filter = isset($request->display_to_filter) ? 1 : 0;
                $PropertyTypeSectionField->input_field_type_id = $request->selected_field;
                $PropertyTypeSectionField->validations = $validation_string;
                if ($PropertyTypeSectionField->save()) {
                    if (sizeof($request->property_type_section_field_option_name) > 0) {
                        $option_counter = 1;
                        foreach ($request->property_type_section_field_option_name as $field_option_value) {
                            if ($field_option_value) {
                                $PropertyTypeSectionFieldOption = new PropertyTypeSectionFieldOption;
                                $PropertyTypeSectionFieldOption->property_type_section_field_id = $PropertyTypeSectionField->id;
                                $PropertyTypeSectionFieldOption->display_value = $field_option_value;
                                $PropertyTypeSectionFieldOption->order_id = $option_counter;
                                $PropertyTypeSectionFieldOption->save();
                            }
                            $option_counter++;
                        }
                   }
                }
            if(!empty($PropertyTypeSection_data->property_type_id)) {
                (new PropertyType())->where(['id' => $PropertyTypeSection_data->property_type_id])->update(['updated_at' => date('Y-m-d H:i:s')]);
            }
            //return view('home');
            //return with a success message
            //return redirect('/propertytype/')->with('status', 'Property Type Saved successfully');
            return redirect()->back()->with('status', 'Section Field Added successfully');
        } catch(Exception $e){
            //pr($e->getMessage(),1);
        }
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        $PropertyTypeSection_data = PropertyTypeSection::find($request->property_type_section_id);
        $propertyTypeSectionIds = PropertyTypeSection::where('property_type_id', $PropertyTypeSection_data->property_type_id)->pluck('id')->toArray();
        $propertyTypeSectionIds = implode(",",$propertyTypeSectionIds);
        $rules = [
            //'property_type_section_field_name' => 'unique_custom:property_type_section_fields,name,id,'. $id_value.',property_type_section_id,' . $propertyTypeSectionIds,
            'property_type_section_field_name' => 'unique_custom:property_type_section_fields,id,'. $id.',name,property_type_section_id,' . $propertyTypeSectionIds,
            //'validations' => 'required',
            'property_type_section_field_option_name.*' => 'required',
            'selected_field' => 'required',
        ];

        $customMessages = [
            'property_type_section_field_name.required' => 'The Field Name is required',
            //'validations.required' => 'Please select atleast 1 of the field validations',
            'property_type_section_field_option_name.*required' => 'The Section Field Option is Required',
            'selected_field.required' => 'The Field Type is Required',
            'property_type_section_field_name.unique_custom' => 'The Field Name must be unique, you have already defined the field with same name',
        ];
        $this->validate($request, $rules, $customMessages);
        $propertyTypeSectionFieldOptionsIds = PropertyTypeSectionFieldOption::where('property_type_section_field_id', $id)->pluck('id')->toArray(); // vikas
        if(isset($request->field_option_id)){
            $arr_PropertyTypeSectionFieldOption_diff = array_diff($propertyTypeSectionFieldOptionsIds ,$request->field_option_id);
        }else if(!isset($request->field_option_id)){
            $empty_arr = array();
            $arr_PropertyTypeSectionFieldOption_diff = array_diff($propertyTypeSectionFieldOptionsIds , $empty_arr);
        }

       if(sizeof($arr_PropertyTypeSectionFieldOption_diff) >0 ) {
			PropertyTypeSectionFieldOption::whereIn('id', $arr_PropertyTypeSectionFieldOption_diff)->delete();
       }
        $inputs = $request->all();

        if($request->input('property_type_section_field_name') == 'Feature Image'){

            $rules = [
                'multipleImagesLimit' => 'required|numeric|min:1',
            ];

            $customMessages = [
                'multipleImagesLimit.required' => 'Please Set File Limit',
                'multipleImagesLimit.numeric' => 'Please enter the numeric value',
                'multipleImagesLimit.min' => 'Please enter minimum 1 value',
            ];

            $this->validate($request, $rules, $customMessages);
        }

        $property_type_section_field_name = $request->property_type_section_field_name;
		$selected_field = $request->selected_field;
		$validations = $request->validations;
       // pr($validations,1);
		$InputFieldTypes = InputFieldType::all();
        //pr($request->all(),1);
		$Validations = Validation::all()->toArray();
        if(sizeof($Validations)) {
            foreach($Validations as $value){
                $newvalidations[$value["id"]] = $value["validation"];
            }
	    }

		if(!isset($validations)) {
            $validations = array();
        }
        $fileLimitsString = '';
		$validations = array_flip($validations);
		$result = array_intersect_key($newvalidations,$validations);
		$validation_string = implode(",",$result);
        $validation_string = str_replace("upload_count","",$validation_string);
        if(!empty($validations) && !empty($request->multipleImagesLimit)){

            $fileLimits = $request->multipleImagesLimit;
            $fileLimitsString = ',upload_count:'.$fileLimits;
        }else if(empty($validations) && !empty($request->multipleImagesLimit)){

            $fileLimits = $request->multipleImagesLimit;
            $fileLimitsString = 'upload_count:'.$fileLimits;
        }
        $validation_string = $validation_string.''.$fileLimitsString;
		$PropertyTypeSectionField = PropertyTypeSectionField::find($id);
		$PropertyTypeSectionField->property_type_section_id = $request->property_type_section_id;
		$PropertyTypeSectionField->name = $request->property_type_section_field_name;
        $PropertyTypeSectionField->input_field_type_id = $request->selected_field;
		$PropertyTypeSectionField->display_to_filter = isset($request->display_to_filter) ? 1 : 0;
		$PropertyTypeSectionField->validations = $validation_string;
		if($PropertyTypeSectionField->save()) {
		    $counter = 0;
            $PropertyTypeSectionFieldOptionCounter = 1;
            if(sizeof($request->property_type_section_field_option_name) > 0) {
                 $custom_query_part1 = "";
                 $custom_query_part2 = "";
                foreach($request->property_type_section_field_option_name as $value) {
		    		if($request->field_option_id[$counter] && $value){
                        $option_id = $request->field_option_id[$counter];
                        $custom_query_part1 .= " WHEN id = $option_id THEN $PropertyTypeSectionFieldOptionCounter ";
                        $custom_query_part2 .= " WHEN id = $option_id THEN " . "'" .$value . "'";
                        $existingOptionid_arr[] = $request->field_option_id[$counter];
                    } else if(!$request->field_option_id[$counter] && $value) {
		                    $PropertyTypeSectionFieldOption = new PropertyTypeSectionFieldOption;
                            $PropertyTypeSectionFieldOption->display_value = $value;
                            $PropertyTypeSectionFieldOption->order_id = $PropertyTypeSectionFieldOptionCounter;
                            $PropertyTypeSectionFieldOption->property_type_section_field_id = $id;
                            $PropertyTypeSectionFieldOption->save();
                    }
                    $counter++;
                    $PropertyTypeSectionFieldOptionCounter++;
			    }
                    if(isset($existingOptionid_arr)) {
                        $custom_query_part3 = implode(",", $existingOptionid_arr);
                        $main_query = "UPDATE property_type_section_field_options
                            SET order_id = CASE
                            $custom_query_part1
                            ELSE order_id END,
                            display_value = CASE
                            $custom_query_part2
                            ELSE display_value
                            END
                            WHERE id IN ($custom_query_part3);";
                        //pr($main_query,1);
                        DB::update($main_query);
                    }

            }
            if(!empty($PropertyTypeSection_data->property_type_id)) {
                (new PropertyType())->where(['id' => $PropertyTypeSection_data->property_type_id])->update(['updated_at' => date('Y-m-d H:i:s')]);
            }

        }
        //return with a success message
        //return redirect('/propertytype/')->with('status', 'Property Type Field Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPropertySection($id) {
        $propertyTypeSection = PropertyTypeSection::find($id)->delete();
        if($propertyTypeSection){
            return response()->json(['success'=>true]);
        } else{
            return response()->json(['success'=>false]);
        }

    }

    public function destroyPropertyTypeSectionField($id) {
        $PropertyTypeSectionField = PropertyTypeSectionField::find($id);
        if(!$PropertyTypeSectionField->field_identifier){
            if($PropertyTypeSectionField->input_field_type_id == (2||3)) {
                $deletedRows = PropertyTypeSectionFieldOption::where('property_type_section_field_id', $id)->delete();
            }
            $PropertyTypeSectionField->delete();
            return redirect()->back()->with('status', 'Section Field Deleted successfully');
        } else{
            return redirect()->back()->with('status', 'Thats a permanent field, you Are Not Allowed to Delete');
        }
    }


    public function checkSectionBeforeRemove(Request $request, $id){

        $data = (new PropertyTypeSectionField())
            ->join('properties_field_values','properties_field_values.property_type_section_field_id','=','property_type_section_fields.id')
            ->where(['property_type_section_fields.property_type_section_id' => $id])
            ->get(['property_type_section_id','property_id'])->toArray();
        if(!empty($data)){

            $ary = [

                'success'   => '100',
                'data'      => count($data),
            ];
        }else{
            $ary  = [
                'success'   => '0',
                'data'      => '0',
            ];
        }
        return $ary;
    }
}
