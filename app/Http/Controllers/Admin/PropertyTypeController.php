<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PropertyType;
use App\PropertyTypeSection;
use App\InputFieldType;
use App\Validation;
use App\User;
use App\PropertyTypeSectionField;
use App\PropertyTypeSectionFieldOption;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
class PropertyTypeController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        return view('admin/property_type.create');
        //return view('Propertytype.create');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $PropertyTypes = PropertyType::orderBy('id', 'desc')->Paginate(10); 
        return view('admin/property_type.index', compact('PropertyTypes'));
        //return view('Propertytype.index', compact('PropertyTypes'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $rules = [
            'property_type_field_name' => 'required',
            'property_type_section_name.*' => 'required|not_contains',
            'property_type_section_name' => 'custom_distinct',
        ];
        $customMessages = [
            'property_type_field_name.required' => 'The Property Field is required',
            'property_type_section_name.*required' => 'The Section Field is Required',
            'property_type_section_name.*not_contains' => 'Sorry the Field name is already in Use',
            'property_type_section_name.*distinct' => 'Please Donot Use duplicate section names',
            'property_type_section_name.custom_distinct' => 'Please Donot Use duplicate section names',
        ];
        $this->validate($request, $rules, $customMessages);
        $PropertyType = new PropertyType;
        $PropertyType->name = $request->property_type_field_name;

        if($PropertyType->name) {
            $PropertyType->save();
            $property_type_id = $PropertyType->id;
            $PropertyTypeSection = new PropertyTypeSection;
            $PropertyTypeSection->name = "Basic Information";
            $PropertyTypeSection->property_type_id = $PropertyType->id;
            $PropertyTypeSection->order_id = 1;
            $PropertyTypeSection->save();
            $property_section_field_constants = array(

                0=>array(
                   "field_name" => "Name", 
                   "field_identifier"=>"basic_name", 
                   "input_field_type_id"=> Config::get('constants.ADMIN_DEFAULT_PROPERTY_FEILDS_TYPE_ID.1'),
                   "validation_string" => "required",
                ),
                1=>array(
                   "field_name" => "Location", 
                   "field_identifier"=>"basic_location", 
                   "input_field_type_id"=> Config::get('constants.ADMIN_DEFAULT_PROPERTY_FEILDS_TYPE_ID.2'),
                   "validation_string" => "required",
                ),
                2=>array(
                   "field_name" => "Feature Image", 
                   "field_identifier"=>"basic_feature_image", 
                   "input_field_type_id"=>  Config::get('constants.ADMIN_DEFAULT_PROPERTY_FEILDS_TYPE_ID.3'),
                   "validation_string" => "",
                ),
                3=>array(
                   "field_name" => "Price", 
                   "field_identifier"=>"basic_price", 
                   "input_field_type_id"=>  Config::get('constants.ADMIN_DEFAULT_PROPERTY_FEILDS_TYPE_ID.4'),
                   "validation_string" => "required",
                ),
                4=>array(
                    "field_name" => "Description",
                    "field_identifier"=>"basic_description",
                    "input_field_type_id"=>  Config::get('constants.ADMIN_DEFAULT_PROPERTY_FEILDS_TYPE_ID.5'),
                    "validation_string" => "required",
                )
            );

            $property_section_field_constants_counter = 1;
            foreach($property_section_field_constants as $field){
                $validationString = '';
                if($field["field_identifier"] == 'basic_feature_image' && empty($field["validation_string"])){
                    $validationString = 'required,upload_count:5';
                }else if($field["field_identifier"] == 'basic_feature_image' && !empty($field["validation_string"])){
                    $validationString = $field["validation_string"].'required,upload_count:5';
                }else{
                    $validationString = $field["validation_string"];
                }

                $PropertyTypeSectionField = new PropertyTypeSectionField;
                $PropertyTypeSectionField->property_type_section_id = $PropertyTypeSection->id;
                $PropertyTypeSectionField->name = $field["field_name"];
                $PropertyTypeSectionField->input_field_type_id = $field["input_field_type_id"];
                $PropertyTypeSectionField->field_identifier = $field["field_identifier"];
                $PropertyTypeSectionField->validations =  $validationString;
                $PropertyTypeSectionField->order_id = $property_section_field_constants_counter;
                $PropertyTypeSectionField->save();
                $property_section_field_constants_counter++;
            }
            $property_type_section_counter =1;
            foreach($request->property_type_section_name as $value) {
                $PropertyTypeSection = new PropertyTypeSection;
                $PropertyTypeSection->name = $value;
                $PropertyTypeSection->property_type_id = $PropertyType->id;
                $PropertyTypeSection->order_id = $property_type_section_counter;
                if($PropertyTypeSection->name){
                    $PropertyTypeSection->save();
                }
                $property_type_section_counter++;
            }
        }
        return redirect()->route('propertytype.edit', $property_type_id)->with('status', 'Property Type Saved successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
       /*$PropertyType = new PropertyType;
       $PropertyTypeSection = new PropertyTypeSection;*/
        //Get all the information associated with given ID 
       $PropertyType = PropertyType::find($id);
       $PropertyTypeSections = PropertyTypeSection::where('property_type_id', $id)->orderBy('order_id', 'asc')->get();
       $InputFieldTypes = InputFieldType::all();
       $Validations = Validation::all();
        //And return to  edit.blade.php view file. 
       return view('admin/property_type.edit', compact('PropertyType', 'PropertyTypeSections', 'InputFieldTypes', 'Validations'));
       //return view('Propertytype.edit', compact('PropertyType', 'PropertyTypeSections', 'InputFieldTypes', 'Validations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $rules = [
            'property_type_field_name' => 'required',
            'property_type_section_name.*' => 'required|distinct',
        ];

        $customMessages = [
            'property_type_field_name.required' => 'The Property Field is required',
            'property_type_section_name.*required' => 'The Section Field is Required',
            'property_type_section_name.*distinct' => 'Please Donot Use duplicate section names',
        ];
        $customMessages = array_unique($customMessages);
        $this->validate($request, $rules, $customMessages);
        $arr_PropertyTypeSections = PropertyTypeSection::select('id')->where('property_type_id', $request->property_type_id)->get()->toArray();
        foreach($arr_PropertyTypeSections as $value){
           $arr_PropertyTypeSections_ids[] = $value["id"];
        }

        $PropertyTypeSections_diff = array_diff($arr_PropertyTypeSections_ids ,$request->property_type_section_id);

        if(sizeof($PropertyTypeSections_diff) >0 ){
            PropertyTypeSection::whereIn('id', $PropertyTypeSections_diff)->delete();
        }

        if($request->property_type_id && $request->property_type_field_name){
            //store
            $PropertyType = PropertyType::find($request->property_type_id);
            $PropertyType->name = $request->property_type_field_name;

            $PropertyType->save();
            print_r($request->property_type_id);
            print_r($request->property_type_section_name);
            $custom_query_part1 = "";
            $custom_query_part2 = "";
            $counter = 0;
            $PropertyTypeSectionCounter = 1;
            foreach($request->property_type_section_name as $value) {
        		// update information
                    if($request->property_type_section_id[$counter] && $value){            
                    $section_id = $request->property_type_section_id[$counter];
                    $custom_query_part1 .= " WHEN id = $section_id THEN $PropertyTypeSectionCounter ";            
                    $custom_query_part2 .= " WHEN id = $section_id THEN " . "'" .$value . "'";
                    $existingOptionid_arr[] = $request->property_type_section_id[$counter];
                } else if(!$request->property_type_section_id[$counter] && $value) {
                    $PropertyTypeSection = new PropertyTypeSection;
                    $PropertyTypeSection->name = $value;
                    $PropertyTypeSection->order_id = $PropertyTypeSectionCounter;
                    $PropertyTypeSection->property_type_id = $request->property_type_id;
                    $PropertyTypeSection->save();
                }
                $counter++;
                $PropertyTypeSectionCounter++;
            }
            $custom_query_part3 = implode(",", $existingOptionid_arr);
            $main_query = "UPDATE property_type_sections
            SET order_id = CASE  
            $custom_query_part1
            ELSE order_id END,
            name = CASE  
            $custom_query_part2
            ELSE name
            END
            WHERE id IN ($custom_query_part3);";
            DB::update($main_query);


            if(!empty($id)) {
                (new PropertyType())->where(['id' => $id])->update(['updated_at' => date('Y-m-d H:i:s')]);
            }
        }

        return redirect()->back()->with('status', 'Property Type Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $PropertyType = PropertyType::find($id);
        
        $PropertyType->delete();
        
        //$deletedRows = PropertyTypeSection::where('property_type_id', $id)->delete();
        
        
        //reture to index.blade.php with a success method.
        //return redirect('/propertytype/')->with('status', 'Property Type Deleted successfully!');
        return redirect()->back()->with('status', 'Property Type Deleted successfully!');
    }
}