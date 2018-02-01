<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Schema;

use App\PropertyTypeSection;
use Illuminate\Support\Facades\View;
use App\PropertyType;
use Illuminate\Support\Facades\Input;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        app('view')->composer('layouts.nav', function ($view) {
        $action = app('request')->route()->getAction();
        $controller = class_basename($action['controller']);
        //$url = app('request')->url();
        list($controller, $action) = explode('@', $controller);
        if(($controller == "PropertyTypeSectionFieldController") && ($action == "create"))
        {
        
        $paramater = app('request')->route()->parameters();
        $propertysectionid = $paramater["propertysectionid"];
        $PropertyTypeSection     = PropertyTypeSection::find($propertysectionid);
        $propertytype_id   = $PropertyTypeSection->propertytype()->first();

//print_r($propertytype_id);
        
        
        
	}
        $view->with(compact('controller', 'action', 'propertytype_id'));
    
    
    
    }
        );
    
    
    
    
    
    Validator::extend('unique_custom', function ($attribute, $value, $parameters)
    {
        // Get the parameters passed to the rule


        //unique_custom:property_type_section_fields,id,'. $id_value.',name,property_type_section_id,' . $arr_propertytypesectionid

        $new_parameters = $parameters;

        unset($new_parameters[0]);
        unset($new_parameters[1]);
        unset($new_parameters[2]);
        unset($new_parameters[3]);
        unset($new_parameters[4]);


        $table = $parameters[0];
        $ignore_field = $parameters[1];
        $ignore_id = $parameters[2];
        $field1 = $parameters[3];
        $field2 = $parameters[4];



        //list($table, $field1, $field2) = $parameters;





        // Check the table and return true only if there are no entries matching
        // both the first field name and the user input value as well as
        // the second field name and the second field value
        $table= "property_type_section_fields";
        $query = \DB::table($table)->select();

        $query->where($field1, $value);

        //return DB::table($table)

        /*
        foreach($values as $value)
        {
        $query->where($field1, $value);
        }
        */




        if($ignore_field != "NULL")
        {
      $query->where($ignore_field, '<>', $ignore_id);
        }

      $query->whereIn($field2, $new_parameters);


       return $query->count() == 0;
    });
    
    
    Validator::extend('not_contains', function($attribute, $value, $parameters)
    {
        // Banned words
        $words = array('Basic Information', 'basic information');
        foreach ($words as $word)
        {

            $word = strtolower(str_replace(' ', '', $word));
            $value = strtolower(str_replace(' ', '', $value));

            if($value == $word)
            {
            return false;
        }
        }
        return true;
    });



    
    Validator::extend('custom_distinct', function($attribute, $value, $parameters, $validator) {

        $inputs = $validator->getData();
        $sections = $inputs['property_type_section_name'];
        $counter = 0;
        foreach($sections as $section_value){

            $sections[$counter] = strtolower(str_replace(' ', '', $section_value));
            $counter++;
        }

        if(count($sections) != count(array_unique($sections)))
        {
              return false;
        }
        else
        {
              return true;
        }
    });

    \Validator::extend('alpha_spaces', function ($attribute, $value) {
        if(!empty($value) && is_array($value) == false){

            return preg_match('/^[\pL\s-.]+$/u', $value);
        }else {
            return true;
        }
    });
    \Validator::extend('alpha_space_numeric', function($attribute, $value){ //pr(is_array($value),1);
        if(!empty($value) && is_array($value) == false){

            return preg_match('/^[a-z0-9 .\-]+$/i', $value);
        }else{
            return true;
        }
    });
    /* Files Number Limit */
   \Validator::extend('upload_count', function($attribute, $value, $parameters) {
       $countedValue = count($value);

       return ($countedValue > $parameters[0]) ? false : true;
        //$files = Input::file($parameters[0]);pr($files,1);
        //return (count($files) <= $parameters[1]) ? true : false;
    });

       $propertyTypes = PropertyType::where(['deleted_at' => NULL])
            ->get(['name','id'])->toArray();
       View::share('propertyTypes',$propertyTypes );



    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
