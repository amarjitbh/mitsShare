@extends('layouts.masterdraggable')

@section('content')
    
        <h1 class="text-center">Edit Property Type</h1>
        <hr><br/>

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

{{--
<!--<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>-->
  
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
--}}
<script>
		
    $(document).ready(function() {
    var max_fields_limit      = 50; //set limit for maximum input fields
    var x = 1; //initialize counter for text box
    $('.add_more_button').click(function(e){ //click event on add more fields button having class add_more_button
        e.preventDefault();
        if(x < max_fields_limit){ //check conditions
            x++; //counter increment
            $('#sortable').append('<li class="ui-sortable-handle"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><input style="width:429px" class="input-text"  placeholder="Please Enter Section Name" type="text" name="property_type_section_name[]"/><a href="#" class="remove_field" style="margin-left:10px;">Remove</a><input name="property_type_section_id[]" type="hidden" value=""></input></li>'); //add input field
        }
    });  
    $('.input_fields_container').on("click",".remove_field", function(e){ //user click on remove text links
        e.preventDefault(); 
        
        if (confirm('Are you sure?')) {
       $(this).parent('li').remove(); 
        x--;
    }
      
    })
});
</script>





<script>
		
    $(document).ready(function() {
    var max_fields_limit      = 50; //set limit for maximum input fields
    var x = 1; //initialize counter for text box
    $('.add_more_button2').click(function(e){ //click event on add more fields button having class add_more_button
        e.preventDefault();
        if(x < max_fields_limit){ //check conditions
            x++; //counter increment
            $('#sortable2').append('<li class="ui-sortable-handle"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><input style="width:429px" class="input-text"  placeholder="Please Enter Option Label Name" type="text" name="property_type_section_name[]"/><a href="#" class="remove_field2" style="margin-left:10px;">Remove</a><input name="property_type_section_id[]" type="hidden" value=""></input></li>'); //add input field
        }
    });  
    $('.input_fields_container').on("click",".remove_field2", function(e){ //user click on remove text links
        e.preventDefault(); 
        
        if (confirm('Are you sure?')) {
       $(this).parent('li').remove(); 
        x--;
    }
      
    })
});
</script>




<script>

$( document ).ready(function() {
    
/*
$("#submit").on("click", function(e){
	
e.preventDefault();
    var form_data = $('#frm_id').serialize();
    $.ajax({
        type: "POST",
        url: "http://127.0.0.1:8000/propertytype/",
        data: form_data,
        dataType: "json",
        success: function(response){
            console.log(response);
            
		},
        error: function(jqXHR, textStatus, errorThrown)
        {

        }
	
    });

});
*/

});
</script>



<div>
           <button class="btn btn-sm btn-primary add_more_button">Add More Sections</button>
      </div>

<form id="frm_id" method="POST" action="{{route('propertytype.store').'/'.$PropertyType->id}}">
	
	{{-- <form method="POST" action="{{route('propertytype.store')}}"> --}}
    {{ csrf_field() }}
    {{ method_field('PUT') }}
<div class="input_fields_container">
      <div><input value="{{$PropertyType->name}}" style="width:429px" type="text" placeholder="Please Enter Property Type Field Name" name="property_type_field_name">
      <input name="property_type_id" type="hidden" value="{{$PropertyType->id}}"></input>
      </div>
      
      {{--  @foreach ($PropertyTypeSections as $PropertyTypeSection)
      <div><input value = "{{$PropertyTypeSection->name}}" style="width:429px" type="text" placeholder="Please Enter Section Name" name="property_type_section_name[]">
           <button class="btn btn-sm btn-primary add_more_button">Add More Sections</button>
           <input name="property_type_section_id[]" type="hidden" value="{{$PropertyTypeSection->id}}"></input>
      </div>
      @endforeach --}}
      
      
      <ul id="sortable">
       @foreach ($PropertyTypeSections as $PropertyTypeSection)
      <li>
		  <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
		  <input value = "{{$PropertyTypeSection->name}}" style="width:429px" type="text" placeholder="Please Enter Section Name" name="property_type_section_name[]">
		  <a href="#" class="add_section_field" style="margin-left:10px;">Add Fields |</a>
		  <a href="#" class="remove_field" >Remove</a>
           {{--<button class="btn btn-sm btn-primary add_more_button">Add More Sections</button>--}}
           <input name="property_type_section_id[]" type="hidden" value="{{$PropertyTypeSection->id}}"></input>
           
           
           
        
      </li>
      @endforeach
      </ul>
      
      
      
      
      
      
      
      
    
    </div>
    <div class="form-group">
    <button id="submit" type="submit" class="button-md button-theme btn-block">Save Property Types</button>
    </div>
    </form>
    
    
    <p>
  <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Link with href
  </a>
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Button with data-target
  </button>
</p>
<div class="collapse" id="collapseExample">
  <form id="frm_id" method="POST" action="http://localhost:8000/propertytype/50">


      {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT">
<div class="input_fields_container">
      
      
      
      
      
      <ul id="sortable" class="ui-sortable">
             <li class="ui-sortable-handle">
		  <span class="">Field Name1</span>
		  <input value="" style="width:429px" type="text" placeholder="Please enter a Field Name1" name="property_type_section_name[]">
		  
		  
           
           <input name="property_type_section_id[]" type="hidden" value="36">
           
           
           
        
      </li>
            <li class="ui-sortable-handle">
		  <span>Field Type 
</span>




		  <select>
			  
	@foreach ($InputFieldTypes as $InputFieldType)		  
			  
  <option value="{{$InputFieldType->id}}">{{$InputFieldType->field_name}}</option>
  
  @endforeach
  
  
</select>
		  
		  
		  
		  
		  
		  
		  
           
           <input name="property_type_section_id[]" type="hidden" value="37">
           
           
           
        
      </li>
            <li class="ui-sortable-handle">
		  <span>Validations</span>
		  
		    @foreach ($Validations as $Validation)	
		    <input type="checkbox" name="validations" value="{{$Validation->id}}">{{$Validation->validation_text}} &nbsp;&nbsp;
			@endforeach
		  
		  
           
           <input name="property_type_section_id[]" type="hidden" value="38">
           
           
           
        
      </li>
            <li class="ui-sortable-handle">
		  <span>Please Enter Field Options</span>
		  
		  
		  
		  
		  
		  
		  
           
           <input name="property_type_section_id[]" type="hidden" value="39">
           
           
           
        
      </li>
            <li class="ui-sortable-handle">
		 
           <button class="btn btn-sm btn-primary add_more_button2">Add Field Options</button>
      
		  
        
      </li>
      
      
      
      
      
            </ul>
            
            
            
            
            
            <ul id="sortable2" class="ui-sortable">
            
            </ul>
      
      
      
      
      
      
      
      
    
    </div>
    <div class="form-group">
    <button id="submit" type="submit" class="button-md button-theme btn-block">Save Field</button>
    </div>
    </form>
</div>


 
@endsection   
