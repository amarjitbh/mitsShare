@extends('layouts.admin_layout')

@section('content')

    <div class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        {{--<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Add Property</a></li>
            <li class="breadcrumb-item active">Edit Property</li>
        </ol>--}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Add New Property Type</h4>

                    </div>
                    <div class="content">

                        @if (count($errors) > 0)
                            <?php
                            $error = $errors->toArray();
                                //pr($error);
                            ?>

                                    @if(!empty($error['property_type_section_name']))
                                    <div class="alert alert-danger">
                                        <ul>
                                        {{$error['property_type_section_name']['0']}}

                                        </ul>
                                    </div>
                                    @endif
                        @endif



                        <form id="frm_id" method="POST" action="{{route('propertytype.store')}}">

                            {{ csrf_field() }}
                            <div class="input_fields_container">
                                <div class="form-group">
                                    <label for="">Property Type Name</label>
                                    <input class="form-control" type="text" placeholder="Please Enter Property Type Field Name" value="{{ old('property_type_field_name') }}" name="property_type_field_name">
                                    {!! !empty($error['property_type_field_name']) ? '<div class="d-block small font-12 text-danger mt-5">'.$error['property_type_field_name']['0'].'</div>' : ''  !!}
                                </div>
                                <div class="mt-20 mb-10">
                                    <h4 class="title">Manage Section
                                        <button class="btn btn-sm btn-primary add_more_button pull-right">Add New Section</button>
                                    </h4>
                                    <p class="category">Manage Property Type Sections</p>
                                </div>
                                <div class="form-group">

                                    <input class="form-control"  type="text" placeholder="Please Enter Section Name" name="property_type_section_name[]" value="Basic Information" disabled>
                                </div>
                                <div class="row">
                                    <div class="col-xs-8">
                                        <div class="form-group">
                                            <input class="form-control"  type="text" placeholder="Please Enter Section Name" name="property_type_section_name[]" value="{{ old('property_type_section_name.0') }}">
                                            <?php
                                                if(!empty($error['property_type_section_name.0'])){

                                                    echo '<div class="d-block small font-12 text-danger mt-5">'.$error['property_type_section_name.0']['0'].'</div>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>


                                <?php


                                $old_section_name_arr = Request::old('property_type_section_name');


                                if(sizeof($old_section_name_arr)>0)
                                {
                                    array_shift($old_section_name_arr);
                                }
                                $index = 0;
                                ?>


                                @if(isset($old_section_name_arr))
                                    @foreach($old_section_name_arr as $value) <?php $index++ ?>
                                        <div class="row">
                                            <div class="col-xs-8">
                                                <div class="form-group"><input class="form-control" type="text"
                                                                               placeholder="Please Enter Section Name"
                                                                               name="property_type_section_name[]"
                                                                               value="{{$value}}">
                                                    <?php
                                                    if(!empty($error['property_type_section_name.'.$index])){

                                                        echo '<div class="d-block small font-12 text-danger mt-5">'.$error['property_type_section_name.'.$index]['0'].'</div>';
                                                    }else if(!empty($error['property_type_section_name.'.$index])){

                                                        echo '<div class="d-block small font-12 text-danger mt-5">'.$error['property_type_section_name']['0'].'</div>';
                                                    }
                                                    ?>
                                                </div>

                                                </div>
                                            <div class="col-xs-4"><a href="#" class="remove_field btn btn-danger">Remove</a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif


                            </div>
                            <hr>
                            <div class="form-group">
                                <button id="submit" type="submit" class="btn btn-cta-shareair btn-fill pull-right mt-0 mb-10">Save Property Types</button>
                            </div>
                            <div class="clearfix"></div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>





    <!-- <script
   src="https://code.jquery.com/jquery-3.2.1.js"
   integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
   crossorigin="anonymous"></script> -->




@endsection


<?php

//print_r(old('property_type_section_name'));

?>

@section('scripts')




    <script>
        $(document).ready(function() {
            var max_fields_limit      = 10; //set limit for maximum input fields
            var x = 1; //initialize counter for text box
            $('.add_more_button').click(function(e){ //click event on add more fields button having class add_more_button
                e.preventDefault();
                if(x < max_fields_limit){ //check conditions
                    x++; //counter increment
                    $('.input_fields_container').append('<div class="row"> <div class="col-xs-8">' +
                            '<div class="form-group">' +
                            '<input  class="input-text form-control"  placeholder="Please Enter Section Name" type="text" name="property_type_section_name[]"/></div></div>' +
                            ' <div class="col-xs-4"><a href="#" class="remove_field btn btn-danger">Remove</a></div></div>'); //add input field
                }
            });
            $('.input_fields_container').on("click",".remove_field", function(e){ //user click on remove text links
                e.preventDefault(); $(this).closest('.row').remove(); x--;
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



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
    <script>
       
       /*
        $.validator.setDefaults({
            submitHandler: function() {
                alert("submitted!");
            }
        });

        $().ready(function() {


            // validate signup form on keyup and submit
            $("#frm_id").validate({
                rules: {
                    property_type_field_name: "required",
                    'property_type_section_name[]': "required",
                },
                messages: {
                    property_type_field_name: "The Property Field is required",
                    'property_type_section_name[]': "The Section Field is Required",
                },
                errorElement: "div"
            });

        });
        
        */
    </script>
@endsection
