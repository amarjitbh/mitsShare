<?php
$i=1;       
 ?>   
         
        <form id="frm_id_{{$i}}" method="POST" action="{{route('PropertyTypeSectionFieldUpdate', ['id' => $section_field['id']])}}">
	

	
    {{ csrf_field() }}
    
    
    
    <input type="hidden" name="property_type_section_id" value="{{'$propertysectionid'}}" >
    
    
    
<div class="input_fields_container">
      
            
      <ul id="sortable" class="ui-sortable">
             <li class="ui-sortable-handle">
		  <span class="">Field Name</span>
		  <input value="{{$section_field['name']}}" style="width:429px" type="text" placeholder="Please enter a Field Name" name="property_type_section_field_name">
		  		    
           
        
      </li>
            <li class="ui-sortable-handle">
		  <span>Field Type 
</span>




		  <select name="selected_field" class="field_types_list">
			  
	@foreach ($InputFieldTypes as $InputFieldType)	
	
		  
			  
  <option value="{{$InputFieldType->id}}" 
  @if($section_field['input_field_type_id'] == $InputFieldType->id)
  {{'selected'}}  
  @endif 
  >{{$InputFieldType->field_name}}</option>
  
  @endforeach
  
  
</select>
               
		  
	    
        
      </li>
            <li class="ui-sortable-handle">
		  <span>Validations</span>
		  
		  
		  <?php
		  //print_r($Validations->toArray());
		  
		  //die("ashu");
		  
		  ?>
		  
		  
		  
	<?php	  
$str = $section_field['validations'];
$os =  explode(",",$str);


?>
		  
		  

		  
		    @foreach ($Validations as $Validation)	
		    
		    	    
		    <input type="checkbox" name="validations[]" value="{{$Validation->id}}" <?php 
		    if(in_array($Validation->validation, $os)) 
			echo "checked";
			?> >{{$Validation->validation_text}} &nbsp;&nbsp;
			@endforeach
		
		    
        
      </li>
      
            <li class="ui-sortable-handle">
		  <span class="field_options_label3" 
		  @if(($section_field['input_field_type_id'] != 2) && ($section_field['input_field_type_id'] != 3))
           {{"style=display:none"}}
           @endif
		  
		 >Please Enter Field Options</span>
		  
		  
        
      </li>
            <li class="ui-sortable-handle">
		 
           <button class="btn btn-sm btn-primary add_more_button3"  
           @if(($section_field['input_field_type_id'] != 2) && ($section_field['input_field_type_id'] != 3))
           {{"style=display:none"}}
           @endif
           
           >Add Field Options</button>
      
		  
        
      </li>
      
      
            </ul>
            
           
           <ul id="sortable3" class="ui-sortable3">
           @if(($section_field['input_field_type_id'] == 2)||($section_field['input_field_type_id'] ==3))


               <?php

               
                   $ordered_options = $section_field['propertytypesectionfieldoption'];


                   //$section_field->propertytypesectionfieldoption as $section_field_option

/*

                   function date_compare($a, $b)
                   {
                   $t1 = strtotime($a['datetime']);
                   $t2 = strtotime($b['datetime']);
                   return $t1 - $t2;
                   }
                   usort($array, 'date_compare');
*/






                   usort($ordered_options, function ($a, $b)
                   {
                   return $a["order_id"] - $b["order_id"];
                   });




                 ?>

               @foreach($ordered_options as $section_field_option)
           
           
            <li class="ui-sortable-handle"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
            <input style="width:429px"  class="input-text" placeholder="Please Enter Option Label Name" type="text" name="property_type_section_field_option_name[]" value="{{ $section_field_option['display_value'] }}">
            <a href="#" class="remove_field2" style="margin-left:10px;">Remove</a>
            <input name="field_option_id[]" type="hidden" value="{{$section_field_option['id']}}"></li>
               
		
		@endforeach
            
            @endif
             </ul>
      
      
    
    </div>
    <div class="form-group">
    <button id="submit_{{$i}}" type="submit" class="ajax_field_button">Save Field</button>
    </div>
    
    </form>
    
    
    
        
   
        
    
    
    <?php $i++; ?>
     
    
    
  
