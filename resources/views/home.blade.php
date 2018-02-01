@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
    var max_fields_limit      = 10; //set limit for maximum input fields
    var x = 1; //initialize counter for text box
    $('.add_more_button').click(function(e){ //click event on add more fields button having class add_more_button
        e.preventDefault();
        if(x < max_fields_limit){ //check conditions
            x++; //counter increment
            $('.input_fields_container').append('<div><input style="width:429px" class="input-text"  placeholder="Please Enter Section Name" type="text" name="property_type_section_name[]"/><a href="#" class="remove_field" style="margin-left:10px;">Remove</a></div>'); //add input field
        }
    });  
    $('.input_fields_container').on("click",".remove_field", function(e){ //user click on remove text links
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
</script>

<script>

$( document ).ready(function() {
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

});
</script>

<form id="frm_id" method="POST" >
	{{-- <form method="POST" action="{{ route('register') }}"> --}}
	{{ csrf_field() }}

    <div class="input_fields_container">
    <div><input style="width:429px" type="text" placeholder="Please Enter Property Type Field Name" name="property_type_field_name">
    </div>
    <div><input style="width:429px" type="text" placeholder="Please Enter Section Name" name="property_type_section_name[]">
    <button class="btn btn-sm btn-primary add_more_button">Add More Sections</button>
    </div>
    </div>
    <div class="form-group">
    <button id="submit" type="submit" class="button-md button-theme btn-block">Save Property Types</button>
    </div>
    </form>
    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
