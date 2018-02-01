@extends('layouts.admin_layout')
@section('content')
    <div class="container-fluid">
        @if(session()->has('status'))
            <div class="alert alert-success">
                {{ session()->get('status') }}
            </div>
        @endif
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('propertytype.index')}}" >Manage Property Type</a></li>
            <li class="breadcrumb-item"><a href="{{@url('propertytype').'/'.$propertypeid.'/edit'}}">Edit Property Type</a></li>
            <li class="breadcrumb-item active">Add New Property Type Fields</li>
        </ol>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <h4 class="title">All Listed Fields</h4>
                    </div>
                    <div class="content">
                        <div class="panel-group" id="accordion">
                            <div id="div_sortable" class="panel panel-default panel-collapse-custom">
                                <?php $i=1; ?>
                                @foreach($section_fields as $section_field)
                                    <div
                                            @if(!$section_field->field_identifier)
                                            class="drag"
                                            @else
                                            class="non-draggable"
                                            @endif
                                            >
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                                <a id="field_name_heading" data-toggle="collapse" class="field_{{$section_field->id}}" data-parent="#accordion" href="#collapse{{$i}}">{{$section_field->name}}</a>
                                                @if(!$section_field->field_identifier)
                                                    <a class="delete_button pull-right btn btn-danger btn-sm" href="{{route('PropertyTypeSectionFieldDestroy', ['id' => $section_field->id])}}">Delete</a>
                                                @endif
                                                <input type="hidden" name="section_field_id[]" value="{{$section_field->id}}" ></input>
                                            </h4>
                                        </div>
                                        <div id="collapse{{$i}}" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="print-error-msg" style="display:none">
                                                    <ul></ul>
                                                </div>
                                                <form  field_id = "{{$section_field->id}}" id="frm_id_{{$i}}" method="POST" action="{{route('PropertyTypeSectionFieldUpdate', ['id' => $section_field->id])}}">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="property_type_section_id" value="{{$propertysectionid}}" >
                                                    <div class="input_fields_container">
                                                        <ul id="unsortable" class="ui-sortable">
                                                            <li class="ui-sortable-handle">
                                                                <div class="form-group">
                                                                    <label for="">Field Name</label>
                                                                    <input id="field_name" class="form-control" value="{{$section_field->name}}" type="text" placeholder="Please enter a Field Name" name="property_type_section_field_name">
                                                                </div>
                                                            </li>
                                                            <li class="ui-sortable-handle"><div class="form-group">
                                                                    <label for="">Field Type</label>
                                                                    <select name="selected_field" onchange="field_types_list(this)" class="field_types_list form-control bootstrap-select">
                                                                        @foreach ($InputFieldTypes as $InputFieldType)
                                                                            <option value="{{$InputFieldType->id}}"
                                                                            @if($section_field->input_field_type_id == $InputFieldType->id)
                                                                                {{'selected'}}
                                                                                    @endif
                                                                                    >{{$InputFieldType->field_name}}</option>
                                                                        @endforeach
                                                                    </select>

                                                                </div></li>
                                                            <div class="form-group">
                                                                <li class="ui-sortable-handle">
                                                                    <span>Display To Filter</span>
                                                                    <input type="checkbox" name="display_to_filter" value="1"
                                                                           @if($section_field->display_to_filter == 1)
                                                                           checked
                                                                            @endif
                                                                            ></div>
                                                            </li>
                                                            <li class="ui-sortable-handle">
                                                                <div class="form-group">
                                                                    <label for="">Validations</label>
                                                                    <div>
                                                                        <?php
                                                                        $str = $section_field->validations;
                                                                        $os =  explode(",",$str);
                                                                        ?>

                                                                        @foreach ($Validations as $Validation)
                                                                            @if($Validation->validation_text != 'File Count')
                                                                                <div class="checkbox-inline">
                                                                                    <label class="label label-validation" for="checkbox-validation-{{$Validation->id}}">
                                                                                        <input <?php if($section_field->field_identifier=='basic_name' || $section_field->field_identifier=='basic_location' || $section_field->field_identifier=='basic_feature_image' || $section_field->field_identifier=='basic_price' || $section_field->field_identifier=='basic_description' ){?> class="disable-class-{{$Validation->id}}" <?php } ?> id="checkbox-validation-{{$Validation->id}}" type="checkbox" name="validations[]" value="{{$Validation->id}}" <?php
                                                                                                if(in_array($Validation->validation, $os))
                                                                                                    echo "checked";
                                                                                                ?> >{{$Validation->validation_text}}</label>
                                                                                </div>

                                                                            @elseif($Validation->validation_text == 'File Count' && $section_field->field_identifier == 'basic_feature_image')
                                                                                <label class="label label-validation" for="multipleImages">
                                                                                    <input type="checkbox" id="multipleImages" <?php
                                                                                            $val = explode(':',$Validation->validation);
                                                                                            $val2 = explode(':',end($os));
                                                                                            if($val[0] == $val2[0])
                                                                                                echo "checked";
                                                                                            ?>> Multiple Images <input type="hidden" id="hiddenFeildId" value="{{($val2[0] == 'upload_count') ? $val2[1] : '0'}}">
                                                                                </label>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </li>

                                                            <li class="ui-sortable-handle">
                                                                <h5 class="field_options_label3"
                                                                @if(($section_field->input_field_type_id != 2) && ($section_field->input_field_type_id != 3) && ($section_field->input_field_type_id != 11))
                                                                    {{"style=display:none"}}
                                                                        @endif

                                                                        >Add Field Options
                                                                    
                                                                    <button class="btn btn-xs btn-primary add_more_button3 pull-right"
                                                                    @if(($section_field->input_field_type_id != 2) && ($section_field->input_field_type_id != 3) && ($section_field->input_field_type_id != 11))
                                                                        {{"style=display:none"}}
                                                                            @endif

                                                                            >Add More</button>
                                                                </h5>




                                                            </li>



                                                        </ul>


                                                        <ul id="sortable3" class="ui-sortable3">
                                                            @if(($section_field->input_field_type_id == 2)||($section_field->input_field_type_id ==3) ||($section_field->input_field_type_id == 11))


                                                                <?php

                                                                $ordered_options = $section_field->propertytypesectionfieldoption->toArray();


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


                                                                    <li class="ui-sortable-handle">
                                                                        <div class="row">
                                                                            <div class="col-xs-8">
                                                                                <div class="input-group w-100p input-group-sm">
                                                                                            <span class="input-group-addon">
                                                                                                <span
                                                                                                        class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                                                                            </span>
                                                                                    <input class="form-control"
                                                                                           placeholder="Please Enter the Value"
                                                                                           type="text"
                                                                                           name="property_type_section_field_option_name[]"
                                                                                           value="{{ $section_field_option['display_value'] }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-xs-4 text-right">
                                                                                <a href="#" class="remove_field3 btn btn-danger btn-xs"
                                                                                        >Remove</a>
                                                                            </div>
                                                                        </div>




                                                                        <input name="field_option_id[]"
                                                                               type="hidden"
                                                                               value="{{$section_field_option['id']}}">
                                                                    </li>


                                                                @endforeach

                                                            @endif
                                                        </ul>



                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <button id="submit_{{$i}}" type="submit" class="ajax_field_button btn  btn-cta-shareair btn-fill pull-right mt-0 mb-10">Update Field</button>
                                                    </div>
                                                </form>





                                            </div>
                                        </div>
                                    </div>


                                    <?php $i++; ?>

                                @endforeach

                                @if(!count($section_fields))
                                    <div class="no-result">Sorry, no record found. Try again</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Add New Property Type Field</h4>

                    </div>
                    <div class="content">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="form-font-size" id="frm_id" method="POST" action="{{route('PropertyTypeSectionFieldStore')}}">

                            {{ csrf_field() }}

                            <input type="hidden" name="property_type_section_id" value="{{$propertysectionid}}" >

                            <div class="input_fields_container">

                                <ul id="unsortable" class="ui-sortable">
                                    <li class="ui-sortable-handle">
                                        <div class="form-group">
                                            <label for="">Field Name</label>
                                            <input type="text" class="form-control" placeholder="Please enter a Field Name" name="property_type_section_field_name" value="{{ old('property_type_section_field_name') }}">
                                        </div>

                                    </li>
                                    <li class="ui-sortable-handle">
                                        <div class="form-group">
                                            <label for="">Field Type</label>
                                            <select name="selected_field" onchange="field_types_list(this)" class="field_types_list form-control bootstrap-select">
                                                @foreach ($InputFieldTypes as $InputFieldType)

                                                    <option @if(old('selected_field') == $InputFieldType->id) selected
                                                            @endif value="{{$InputFieldType->id}}">{{$InputFieldType->field_name}}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                    </li>

                                    <li class="ui-sortable-handle">
                                        <div class="form-group">
                                            <span>Display To Filter</span>
                                            <input type="checkbox" name="display_to_filter" value="1"></div>
                                    </li>

                                    <li class="ui-sortable-handle">

                                        <label for="">Validations</label>
                                        <div>
                                            <?php

                                            $old_validation_selection_arr = Request::old('validations');

                                            $curentfield_types_list_val = Request::old('selected_field');



                                            if(!isset($old_validation_selection_arr))
                                            {
                                                $old_validation_selection_arr = array();
                                            }

                                            ?>


                                            @foreach ($Validations as $Validation)
                                                <div class="checkbox-inline">
                                                    <label class="label label-validation" for="checkbox-validation-{{$Validation->id}}">
                                                        <input type="checkbox"

                                                               @if(in_array($Validation->id, $old_validation_selection_arr))
                                                               {{'checked'}}
                                                               @endif
                                                               name="validations[]" id="checkbox-validation-{{$Validation->id}}" value="{{$Validation->id}}">{{$Validation->validation_text}}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                    </li>

                                    <li class="ui-sortable-handle">
                                        <h5 class="field_options_label"

                                        @if(isset($curentfield_types_list_val))
                                            @if(($curentfield_types_list_val == 2)||($curentfield_types_list_val == 3)||($curentfield_types_list_val == 11))
                                                {{'style=display:block'}}
                                                    @else
                                                {{'style=display:none'}}
                                                    @endif
                                                @else
                                            {{'style=display:none'}}
                                                @endif

                                                >Add Field Options
                                            <button class="btn btn-xs btn-primary  pull-right add_more_button2"

                                            @if(isset($curentfield_types_list_val))
                                                @if(($curentfield_types_list_val == 2)||($curentfield_types_list_val == 3)||($curentfield_types_list_val == 11))
                                                    {{'style=display:block'}}
                                                        @else
                                                    {{'style=display:none'}}
                                                        @endif
                                                    @else
                                                {{'style=display:none'}}
                                                    @endif

                                                    >Add Field Options</button>
                                        </h5>
                                    </li>

                                </ul>

                                <ul id="sortable2" class="ui-sortable">
                                    <?php
                                    $old_option_name_arr = Request::old('property_type_section_field_option_name');
                                    ?>
                                    @if(isset($old_option_name_arr))
                                        @foreach($old_option_name_arr as $value)

                                            <li class="ui-sortable-handle">
                                                <div class="row">
                                                    <div class="col-xs-8">
                                                        <div class="input-group w-100p input-group-sm">
                                                                                            <span class="input-group-addon">
                                                                                                <span
                                                                                                        class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                                                                            </span>
                                                            <input class="form-control"
                                                                   placeholder="Please Enter the Value"
                                                                   type="text"
                                                                   name="property_type_section_field_option_name[]"
                                                                   value="{{$value}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-4 text-right">
                                                        <a href="#" class="remove_field2 btn btn-danger btn-xs"
                                                                >Remove</a>
                                                    </div>
                                                    <input  name="field_option_id[]" type="hidden" value="">
                                                </div>
                                            </li>

                                        @endforeach
                                    @endif


                                </ul>

                            </div>
                            <hr>
                            <button id="submit" type="submit" class="btn btn-cta-shareair btn-fill pull-right mt-0 mb-10">Save and Add New</button>
                            <div class="clearfix"></div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <p>
    </p>
    <div class="print-error-msg" style="display:none">
        <ul></ul>
    </div>


















    <br/> <br/>



    <div id="response">
    </div>
@endsection


@section('scripts')

    <script>
        $( document ).ready(function() {

            var hiddenFeildValue = $('#hiddenFeildId').val();
            setTimeout(function(){

                $('#multipleImagesLimit').val(hiddenFeildValue);
            },100);
            $('#div_sortable').on("click",".delete_button", function(e){ //user click on remove text links

                if (!confirm('Are you sure?')) {
                    e.preventDefault();
                }

            });
        });

        /*
         var y =1;
         $(".add_more_button3").on("click", "#frm_id_1.add_more_button3", function(e){

         e.preventDefault();
         if(y < max_fields_limit){ //check conditions
         y++; //counter increment
         //$('#sortable2').append('<li class="ui-sortable-handle"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><input style="width:429px" class="input-text"  placeholder="Please Enter the Value" type="text" name="property_type_section_name[]"/><a href="#" class="remove_field2" style="margin-left:10px;">Remove</a><input name="property_type_section_id[]" type="hidden" value=""></input></li>'); //add input field
         $(this).closest('.input_fields_container').find('#sortable3').append('<li class="ui-sortable-handle"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><input style="width:429px" class="input-text"  placeholder="Please Enter the Value" type="text" name="property_type_section_field_option_name[]"/><a href="#" class="remove_field2" style="margin-left:10px;">Remove</a><input name="field_option_id[]" type="hidden" value=""></input></li>');
         }


         });
         */

        var max_fields_limits = 50;

        var y =1;

        $(document).on('click', '.add_more_button3', function(e) {
            e.preventDefault();
            if(y < max_fields_limits){ //check conditions
                y++; //counter increment
                //$('#sortable2').append('<li class="ui-sortable-handle"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><input style="width:429px" class="input-text"  placeholder="Please Enter the Value" type="text" name="property_type_section_name[]"/><a href="#" class="remove_field2" style="margin-left:10px;">Remove</a><input name="property_type_section_id[]" type="hidden" value=""></input></li>'); //add input field

                var newz = $(this).closest('.input_fields_container').find('#sortable3').children().length;

                if(newz == 1)
                {
                    $(this).closest('.input_fields_container').find('#sortable3 > li > a').removeClass('hide');
                }

                /* html('<li class="ui-sortable-handle">'+
                 '<div class="row">' +
                 '<div class="col-sm-6">'+
                 '<div class="input-group w-100p">'+
                 '<span class="input-group-addon">' +
                 '<span class="ui-icon ui-icon-arrowthick-2-n-s"></span></span>' +
                 '<input  class="form-control"  placeholder="Please Enter the Value" type="text" name="property_type_section_field_option_name[]"/> </div></div>' +
                 '<div class="col-sm-6"><a href="#" class="remove_field2 hide">Remove</a></div>' +
                 '<input name="field_option_id[]" type="hidden" value=""></input></div>' +
                 '</li>');*/

                $(this).closest('.input_fields_container').find('#sortable3').append('<li class="ui-sortable-handle">'+
                        '<div class="row">' +
                        '<div class="col-xs-8">'+
                        '<div class="input-group w-100p input-group-sm">'+
                        '<span class="input-group-addon">' +
                        '<span class="ui-icon ui-icon-arrowthick-2-n-s"></span></span>' +
                        '<input  class="form-control"  placeholder="Please Enter the Value" type="text" name="property_type_section_field_option_name[]"/> </div></div>' +
                        '<div class="col-xs-4 text-right"><a href="#" class="remove_field2 btn btn-danger btn-xs">Remove</a></div>' +
                        '<input name="field_option_id[]" type="hidden" value=""></div>' +
                        '</li>');
            }
        });
        $(document).ready(function() {
            var max_fields_limit      = 50; //set limit for maximum input fields
            var x = 1; //initialize counter for text box
            $('.add_more_button2').click(function(e){ //click event on add more fields button having class add_more_button
                e.preventDefault();
                if(x < max_fields_limit){ //check conditions

                    if(x == 1)
                    {
                        $(this).closest('.input_fields_container').find('#sortable2 > li > a').removeClass('hide');
                    }
                    x++; //counter increment
                    //$('#sortable2').append('<li class="ui-sortable-handle"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><input style="width:429px" class="input-text"  placeholder="Please Enter the Value" type="text" name="property_type_section_name[]"/><a href="#" class="remove_field2" style="margin-left:10px;">Remove</a><input name="property_type_section_id[]" type="hidden" value=""></input></li>'); //add input field
                    $(this).closest('.input_fields_container').find('#sortable2').append('<li class="ui-sortable-handle">' +
                            '<div class="row">' +
                            '<div class="col-xs-8">'+
                            '<div class="input-group w-100p input-group-sm">'+
                            '<span class="input-group-addon">' +
                            '<span class="ui-icon ui-icon-arrowthick-2-n-s"></span></span>' +
                            '<input  class="form-control"  placeholder="Please Enter the Value" type="text" name="property_type_section_field_option_name[]"/> </div></div>' +
                            '<div class="col-xs-4 text-right"><a href="#" class="remove_field2 btn btn-danger btn-xs">Remove</a></div>' +
                            '<input name="field_option_id[]" type="hidden" value=""></div>' +
                            '</li>');
                }
            });


            $('.input_fields_container').on("click",".remove_field2", function(e){ //user click on remove text links
                e.preventDefault();


                if (confirm('Are you sure?')) {


                    x--;


                    if(x==1){
                        //alert(x);

                        $(this).closest('.input_fields_container').find('#sortable2 > li > a.remove_field2').addClass('hide');
                        $(this).closest('li').remove();
                    }
                    else{
                        $(this).closest('li').remove();
                    }




                    z--;
                }

            })








            $('.input_fields_container').on("click",".remove_field3", function(e){ //user click on remove text links
                e.preventDefault();


                if (confirm('Are you sure?')) {


                    var newz = $(this).closest('.input_fields_container').find('#sortable3').children().length;


                    newz--;


                    if(newz==1){
                        //alert(x);

                        $(this).closest('.input_fields_container').find('#sortable3 > li > a.remove_field3').addClass('hide');
                        $(this).closest('li').remove();
                    }
                    else{
                        $(this).closest('li').remove();
                    }





                }

            })



            /*
             var z=1;
             $('.add_more_button3').click(function(e){ //click event on add more fields button having class add_more_button
             e.preventDefault();
             if(z < max_fields_limit){ //check conditions
             z++; //counter increment
             //$('#sortable2').append('<li class="ui-sortable-handle"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><input style="width:429px" class="input-text"  placeholder="Please Enter the Value" type="text" name="property_type_section_name[]"/><a href="#" class="remove_field2" style="margin-left:10px;">Remove</a><input name="property_type_section_id[]" type="hidden" value=""></input></li>'); //add input field
             $(this).closest('.input_fields_container').find('#sortable3').append('<li class="ui-sortable-handle"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><input style="width:429px" class="input-text"  placeholder="Please Enter the Value" type="text" name="property_type_section_field_option_name[]"/><a href="#" class="remove_field2" style="margin-left:10px;">Remove</a><input name="field_option_id[]" type="hidden" value=""></input></li>');
             }
             });
             */












            $('.ajax_field_button').click(function(e){ //click event on add more fields button having class add_more_button
                e.preventDefault();


                var ajax_url = $(this).closest('form').attr('action');
                var ajax_form_id = $(this).closest('form').attr('id');
                //var form_id = $(this).closest('form').attr('id');
                var divpanel = $(this).closest('.panel-body');
                var field_id = $(this).closest('form').attr('field_id');
                var new_ajax_url = "{{ request()->getSchemeAndHttpHost()}}/PropertyTypeSectionField/singlefieldedit/"+ field_id;



                $.ajax({
                    context: this,
                    url: ajax_url,
                    type:'GET',
                    data:$(this).closest('form').serialize(),
                    success:function(result){


                        if($.isEmptyObject(result.error)){
                            var field_name = $(this).closest('form').find('#field_name').val();
                            // alert(field_name);
                            var successmessage = 'Property Type Field Updated successfully!';


                            $(this).closest('.drag').find('#field_name_heading').text(field_name);
                            printSuccessMsg(successmessage, this);

                        }


                        /*

                         success:function(result){

                         if($.isEmptyObject(result.error)){
                         var field_name = $(this).closest('form').find('#field_name').val();

                         var successmessage = 'Property Type Field Updated successfully!';
                         $(this).closest('#drag').find('#field_name_heading').text(field_name);
                         printSuccessMsg(successmessage, this);

                         }




                         else{
                         printErrorMsg(result.error, this);
                         }
                         $.ajax({
                         url: new_ajax_url,
                         type:'GET',
                         data:$(this).closest('form').serialize(),
                         success:function(result){

                         $new_result = $(result);
                         divpanel.html($new_result);

                         var newid = $new_result[0][2].class;

                         alert(newid);

                         //$new_result.find("form").css('background-color', 'red');
                         //$new_result.find("form#frm_id_1").attr('id', "frm_id_a");
                         var field_name = $new_result.find('frm_id_1').attr('input#field_name');
                         //alert(field_name);

                         // alert(field_name);


                         }

                         });

                         */

                    },
                    error: function(data)
                    {
                        //var errors = '';
                        /*
                         for(datos in data.responseJSON){
                         errors += data.responseJSON[datos];
                         }*/



                        printErrorMsg(data, this);
                    }

                });

            });


            function printErrorMsg(msg, refrencevar) {


                $(refrencevar).closest("div.panel-body").find("div.print-error-msg ul").removeClass('alert alert-success');
                $(refrencevar).closest("div.panel-body").find("div.print-error-msg ul").addClass('alert alert-danger');
                $(refrencevar).closest("div.panel-body").find("div.print-error-msg ul").html('');
                $(refrencevar).closest("div.panel-body").find("div.print-error-msg").css('display','block');

                for(datos in msg.responseJSON){
                    $(refrencevar).closest("div.panel-body").find("div.print-error-msg ul").append('<li>'+msg.responseJSON[datos]+'</li>');
                }

                /*
                 $.each( msg, function( key, value ) {
                 //$(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                 $(refrencevar).closest("div.panel-body").find("div.print-error-msg ul").append('<li>'+value+'</li>');

                 });
                 */


            }

            function printSuccessMsg(msg, refrencevar) {
                $(refrencevar).closest("div.panel-body").find("div.print-error-msg ul").removeClass('alert alert-danger');
                $(refrencevar).closest("div.panel-body").find("div.print-error-msg ul").addClass('alert alert-success');
                $(refrencevar).closest("div.panel-body").find("div.print-error-msg ul").html('');
                $(refrencevar).closest("div.panel-body").find("div.print-error-msg").css('display','block');
                $(refrencevar).closest("div.panel-body").find("div.print-error-msg ul").append('<li>'+msg+'</li>');

            }

        });
    </script>


    <script>
        $(document).ready(function(){

            /*$('.field_types_list').change(function() {
             alert('sadf');
             if ((this.value == '2') || (this.value == '3') || (this.value == '11'))
             //.....................^.......
             {

             $(this).closest('ul.ui-sortable').find('.add_more_button2').show();
             $(this).closest('.input_fields_container').find('#sortable2').show();
             $(this).closest('ul.ui-sortable').find('.field_options_label').show();


             $(this).closest('ul.ui-sortable').find('.add_more_button3').show();
             $(this).closest('.input_fields_container').find('#sortable3').show();
             $(this).closest('ul.ui-sortable').find('.field_options_label3').show();




             if ( $(this).closest('.input_fields_container').find('#sortable2').children().length == 0 ) {

             $(this).closest('.input_fields_container').find('#sortable2').html('<li class="ui-sortable-handle">' +
             '<div class="row">' +
             '<div class="col-xs-8">'+
             '<div class="input-group w-100p input-group-sm">'+
             '<span class="input-group-addon">' +
             '<span class="ui-icon ui-icon-arrowthick-2-n-s"></span></span>' +
             '<input  class="form-control"  placeholder="Please Enter the Value" type="text" name="property_type_section_field_option_name[]"/> </div></div>' +
             '<div class="col-xs-4 text-right"><a href="#" class="remove_field2 btn btn-danger btn-xs">Remove</a></div>' +
             '<input name="field_option_id[]" type="hidden" value=""></div>' +
             '</li>');
             }


             if ( $(this).closest('.input_fields_container').find('#sortable3').children().length == 0 ) {

             $(this).closest('.input_fields_container').find('#sortable3').html('<li class="ui-sortable-handle">'+
             '<div class="row">' +
             '<div class="col-xs-8">'+
             '<div class="input-group w-100p input-group-sm">'+
             '<span class="input-group-addon">' +
             '<span class="ui-icon ui-icon-arrowthick-2-n-s"></span></span>' +
             '<input  class="form-control"  placeholder="Please Enter the Value" type="text" name="property_type_section_field_option_name[]"/> </div></div>' +
             '<div class="col-xs-4 text-right"><a href="#" class="remove_field2 hide">Remove</a></div>' +
             '<input name="field_option_id[]" type="hidden" value=""></div>' +
             '</li>');
             }

             //$(this).closest('.input_fields_container').find('#sortable2').html('<li class="ui-sortable-handle"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><input style="width:429px" class="input-text"  placeholder="Please Enter the Value" type="text" name="property_type_section_field_option_name[]"/><a href="#" class="remove_field2" style="margin-left:10px;">Remove</a><input name="field_option_id[]" type="hidden" value=""></input></li>');


             }
             else
             {



             $(this).closest('ul.ui-sortable').find('.add_more_button2').hide();
             $(this).closest('.input_fields_container').find('#sortable2').html('');
             $(this).closest('ul.ui-sortable').find('.field_options_label').hide();





             $(this).closest('ul.ui-sortable').find('.add_more_button3').hide();
             $(this).closest('.input_fields_container').find('#sortable3').html('');
             $(this).closest('ul.ui-sortable').find('.field_options_label3').hide();


             }
             });*/

            if($('#multipleImages').is(':checked') == true){
                $('#multipleImages').parents('li').after('<li><input type="text" onkeypress="isNumberKey(this)" id="multipleImagesLimit" name="multipleImagesLimit" placeholder="Set File Limit"/></li>');
            }
            document.getElementById("multipleImages").disabled = true;
            $('.disable-class-1').attr('disabled', true);
        });

        function field_types_list(ths){

            if ((ths.value == '2') || (ths.value == '3') || (ths.value == '11')){

                $(ths).closest('ul.ui-sortable').find('.add_more_button2').show();
                $(ths).closest('.input_fields_container').find('#sortable2').show();
                $(ths).closest('ul.ui-sortable').find('.field_options_label').show();
                $(ths).closest('ul.ui-sortable').find('.add_more_button3').show();
                $(ths).closest('.input_fields_container').find('#sortable3').show();
                $(ths).closest('ul.ui-sortable').find('.field_options_label3').show();

                if ( $(ths).closest('.input_fields_container').find('#sortable2').children().length == 0 ) {

                    $(ths).closest('.input_fields_container').find('#sortable2').html('<li class="ui-sortable-handle">' +
                            '<div class="row">' +
                            '<div class="col-xs-8">'+
                            '<div class="input-group w-100p input-group-sm">'+
                            '<span class="input-group-addon">' +
                            '<span class="ui-icon ui-icon-arrowthick-2-n-s"></span></span>' +
                            '<input  class="form-control"  placeholder="Please Enter the Value" type="text" name="property_type_section_field_option_name[]"/> </div></div>' +
                            '<div class="col-xs-4 text-right"><a href="#" class="remove_field2 btn btn-danger btn-xs">Remove</a></div>' +
                            '<input name="field_option_id[]" type="hidden" value=""></div>' +
                            '</li>');
                }
                if ( $(ths).closest('.input_fields_container').find('#sortable3').children().length == 0 ) {

                    $(ths).closest('.input_fields_container').find('#sortable3').html('<li class="ui-sortable-handle">'+
                            '<div class="row">' +
                            '<div class="col-xs-8">'+
                            '<div class="input-group w-100p input-group-sm">'+
                            '<span class="input-group-addon">' +
                            '<span class="ui-icon ui-icon-arrowthick-2-n-s"></span></span>' +
                            '<input  class="form-control"  placeholder="Please Enter the Value" type="text" name="property_type_section_field_option_name[]"/> </div></div>' +
                            '<div class="col-xs-4 text-right"><a href="#" class="remove_field2 hide">Remove</a></div>' +
                            '<input name="field_option_id[]" type="hidden" value=""></div>' +
                            '</li>');
                }
                //$(this).closest('.input_fields_container').find('#sortable2').html('<li class="ui-sortable-handle"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><input style="width:429px" class="input-text"  placeholder="Please Enter the Value" type="text" name="property_type_section_field_option_name[]"/><a href="#" class="remove_field2" style="margin-left:10px;">Remove</a><input name="field_option_id[]" type="hidden" value=""></input></li>');
            }
            else {

                $(ths).closest('ul.ui-sortable').find('.add_more_button2').hide();
                $(ths).closest('.input_fields_container').find('#sortable2').html('');
                $(ths).closest('ul.ui-sortable').find('.field_options_label').hide();
                $(ths).closest('ul.ui-sortable').find('.add_more_button3').hide();
                $(ths).closest('.input_fields_container').find('#sortable3').html('');
                $(ths).closest('ul.ui-sortable').find('.field_options_label3').hide();
            }
        }

    </script>

@endsection
