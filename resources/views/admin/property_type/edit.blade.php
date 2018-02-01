@extends('layouts.admin_layout')
@section('content')
    <?php $index = 1; ?>
    <div class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('propertytype.index')}}">Manage Property Type</a></li>
            <li class="breadcrumb-item active">Edit Property Type</li>
        </ol>
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="header">
                        <h4 class="title">Edit Property Type</h4>

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
                        <form id="frm_id" method="POST" action="{{route('propertytype.store').'/'.$PropertyType->id}}">

                            {{-- <form method="POST" action="{{route('propertytype.store')}}"> --}}
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="input_fields_container">
                                <div class="form-group">
                                    <label>Property Type</label>
                                    <input value="{{$PropertyType->name}}" class="form-control" type="text"
                                           placeholder="Please Enter Property Type Field Name"
                                           name="property_type_field_name">
                                    <input name="property_type_id" type="hidden" value="{{$PropertyType->id}}"/>
                                    {!! !empty($error['property_type_field_name']) ? '<div class="d-block small font-12 text-danger mt-5">'.$error['property_type_field_name']['0'].'</div>' : ''  !!}
                                </div>


                                {{--@if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif--}}
                                <div class="mt-20 mb-10">
                                    <h4 class="title">Manage Section
                                        <button class="btn btn-sm btn-primary add_more_button pull-right">Add More Sections</button>
                                    </h4>
                                    <p class="category">Manage Property Type features</p>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <ul id="sortable">
                                            @foreach ($PropertyTypeSections as $PropertyTypeSection) <?php $index++?>

                                                @if($PropertyTypeSection->name !="Basic Information")
                                                    <li>
                                                @else
                                                    <li class="non-draggable">
                                                        @endif

                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="input-group w-100p">
                                                                    @if($PropertyTypeSection->name !="Basic Information")
                                                                        <span class="input-group-addon">
                                                            <span class="ui-icon ui-icon-arrowthick-2-n-s"></span></span>
                                                                    @else

                                                                        <span class="input-group-addon">
                                                            <span class="ui-icon ui-icon-arrowthick-2-n-s"
                                                                  style="opacity: 0.4"></span></span>
                                                                    @endif
                                                                    <input value="{{$PropertyTypeSection->name}}"
                                                                           type="text"
                                                                           placeholder="Please Enter Section Name"
                                                                           class="form-control"
                                                                           name="property_type_section_name[]">
                                                                    <input name="property_type_section_id[]"
                                                                           type="hidden"
                                                                           value="{{$PropertyTypeSection->id}}"/>


                                                                </div>
                                                                <?php
                                                                if(!empty($error['property_type_section_name.'.$index])){

                                                                    echo '<div class="d-block small font-12 text-danger mt-5">'.$error['property_type_section_name.'.$index]['0'].'</div>';
                                                                }else if(!empty($error['property_type_section_name.'.$index])){

                                                                    echo '<div class="d-block small font-12 text-danger mt-5">'.$error['property_type_section_name']['0'].'</div>';
                                                                }
                                                                ?>


                                                            </div>
                                                            <div class="col-sm-6">

                                                                <a href="{{route('PropertyTypeSectionFieldCreate', ['id' => $PropertyTypeSection->id, 'property_type' => $PropertyType->id])}}"
                                                                   class="add_section_field btn btn-primary">Manage
                                                                    Fields</a>

                                                                @if($PropertyTypeSection->name !="Basic Information")

                                                                    <a href="#" data-url="{{route('PropertyTypeSectionDestroy', $PropertyTypeSection->id )}}" data-propertytypesectionid="{{$PropertyTypeSection->id}}" class="remove_field btn btn-danger">Remove</a>
                                                                    </span>
                                                            </div>

                                                            @endif


                                                        </div>

                                                    </li>
                                                    @endforeach
                                        </ul>
                                    </div>
                                </div>



                            </div>

                            <hr>
                            <button id="submit" type="submit" class="btn  btn-cta-shareair btn-fill pull-right mt-0 mb-10">Save Property
                                Types
                            </button>
                            <div class="clearfix"></div>
                        </form>
                        <form class="hide">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Company (disabled)</label>
                                        <input type="text" class="form-control" disabled="" placeholder="Company"
                                               value="Creative Code Inc.">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" class="form-control" placeholder="Username"
                                               value="michael23">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" placeholder="Company" value="Mike">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" placeholder="Last Name" value="Andrew">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" placeholder="Home Address"
                                               value="Bld Mihail Kogalniceanu, nr. 8 Bl 1, Sc 1, Ap 09">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" class="form-control" placeholder="City" value="Mike">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <input type="text" class="form-control" placeholder="Country" value="Andrew">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Postal Code</label>
                                        <input type="number" class="form-control" placeholder="ZIP Code">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>About Me</label>
                                        <textarea rows="5" class="form-control"
                                                  placeholder="Here can be your description">Lamborghini Mercy, Your chick she so thirsty, I'm in that two seat Lambo.</textarea>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-info btn-fill pull-right">Save Property Types</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>






    {{--
    <!--<script
      src="https://code.jquery.com/jquery-3.2.1.js"
      integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
      crossorigin="anonymous"></script>-->

    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    --}}


@endsection





@section('scripts')
    <script src="{{ asset( 'js/toastr.min.js' ) }}"></script>
    <script src="{{ asset( 'js/bootbox.min.js' ) }}"></script>
    {{--
<!--<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>-->

<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
--}}
    <script>

        $(document).ready(function () {
            var max_fields_limit = 50; //set limit for maximum input fields
            var x = 1; //initialize counter for text box
            $('.add_more_button').click(function (e) { //click event on add more fields button having class add_more_button
                e.preventDefault();
                if (x < max_fields_limit) { //check conditions
                    x++; //counter increment
                    $('#sortable').append('<li class="ui-sortable-handle">' +
                            '<div class="row">' +
                            '<div class="col-sm-6">' +
                            '<div class="input-group w-100p">' +
                            '<span class="input-group-addon"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></span>' +
                            '<input  class="form-control"  placeholder="Please Enter Section Name" type="text" name="property_type_section_name[]"/>' +
                            '</div></div>' +
                            '<div class="col-sm-6">' +
                            '<a href="#" class="remove_field btn btn-danger" >Remove</a>' +
                            '<input name="property_type_section_id[]" type="hidden" value=""/>' +
                            '</li>'); //add input field
                }
            });
            $('.input_fields_container').on("click", ".remove_field", function (e) {
                e.preventDefault();
                var propertytypesectionid = $(this).data('propertytypesectionid');
                var token ="{{csrf_token()}}";
                //var confrimMessage = '';
                var url = $(this).data('url');
                var targetBlock = $(this);
                $.ajax({
                    url: '{{route("checkSectionBeforeRemove")}}/'+propertytypesectionid,
                    type: "POST",
                    data: {id: propertytypesectionid, _token: token},
                    success: function (response) {
                        if(response.success == '100'){
                            confrimMessage = 'This section use in '+response.data+' properties . Are you sure you want to remove this section ?';
                        }else{
                            confrimMessage = 'Are you sure you want to remove this section ?';
                        }
                        removeSection(confrimMessage,propertytypesectionid,url,targetBlock);
                    },
                    error : function(res){

                        toastr.error('Something Went wrong.', 'Sorry!')
                    }
                });
            });

        });
        /* Remove Section after confrim message */
        function removeSection(confrimMessage,propertytypesectionid,url,targetBlock){

            var token ="{{csrf_token()}}";
            bootbox.confirm({

                message: confrimMessage,
                buttons: {

                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if(url){
                        if( result ){
                            $.ajax({
                                url:url,
                                type: "get",
                                data: {id: propertytypesectionid,_token:token},
                                success  : function(response) {
                                    if( response.success == true ){
                                        toastr.success('Section is removed successfully.', {timeOut: 100})
                                        targetBlock.closest('li').slideUp('slow', function(){
                                            targetBlock.remove()
                                        });
                                    }
                                    if( response.success == false ){
                                        toastr.error('Something Went wrong.', 'Sorry!')
                                    }
                                },
                            });
                        }
                    }else{
                        toastr.success('Section is removed successfully.', {timeOut: 100})
                        targetBlock.closest('li').slideUp('slow', function(){
                            targetBlock.remove()
                        });
                    }
                }
            });
        }
    </script>





    <script>

        $(document).ready(function () {
            var max_fields_limit = 50; //set limit for maximum input fields
            var x = 1; //initialize counter for text box
            $('.add_more_button2').click(function (e) { //click event on add more fields button having class add_more_button
                e.preventDefault();
                if (x < max_fields_limit) { //check conditions
                    x++; //counter increment
                    $('#sortable2').append('<li class="ui-sortable-handle"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><input style="width:429px" class="input-text"  placeholder="Please Enter Option Label Name" type="text" name="property_type_section_name[]"/><a href="#" class="remove_field2" style="margin-left:10px;">Remove</a><input name="property_type_section_id[]" type="hidden" value=""/></li>'); //add input field
                }
            });
            $('.input_fields_container').on("click", ".remove_field2", function (e) { //user click on remove text links
                e.preventDefault();

                if (confirm('Are you sure?')) {
                    $(this).closest('li').remove();
                    x--;
                }

            })
        });


    </script>
@endsection