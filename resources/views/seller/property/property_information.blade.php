@extends('layouts.before_login_seller')
@section('content')
        <style>
            .mandatory {

                color : red;
            }
        </style>
        <!-- Sub banner start -->
<div class="sub-banner" xmlns="http://www.w3.org/1999/html">
    <div class="overlay">
        <div class="container">
            <div class="breadcrumb-area">
                <div class="top">
                    <h1>Submit Property</h1>
                </div>
                <ul class="breadcrumbs">
                    <li><a href="{{route('home')}}">Home</a></li>
                    <li class="active">Submit Property</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Sub Banner end -->
<!-- end .flash-message -->
<!-- Submit Property start -->
<div class="submit-property">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(session('warning'))
                    <div class="alert alert-danger">
                        {{ session('warning') }}
                    </div>
                @endif
            </div>
            <div class="col-md-12">
                <div class="alert alert-danger-custom hide" id="errorMessage"></div>
                <div class="submit-address">
                    <form method="POST" id="form_submit" action="{{route('store.property.type.data')}}"
                          enctype="multipart/form-data" novalidate>
                        {{ csrf_field() }}



                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Property Type</label>
                                <select originalid="V1_I1_T6" class="selectpicker search-fields" id="propertyType">
                                    <option value="0">Select Property Type</option>
                                    @foreach($propertyTypes as $propertyType)
                                        <option value="{{$propertyType['id']}}" {{$propertyType['id'] == $propertyTypesId ? 'selected' : ''}}>{{$propertyType['name']}}</option>
                                    @endforeach
                                </select>
                                <span id="property_error"
                                      style=" color:red; display:none;">Please select property type</span>
                            </div>
                            <input type="hidden" name="property_types_id" value="{{$propertyTypesId}}">
                        </div>
                        <div class="clearfix"></div>
                        @foreach($propertyTypeSectionData as $ind => $propertyTypeSectionName)
                            <h1>{{$propertyTypeSectionName['section_name']}}</h1>
                            <?php $count = 1; ?>
                            @foreach($propertyTypeSectionName['fields'] as $fieldName)
                                <?php $validation = explode(",", $fieldName['validations']); ?>
                                <div class="search-contents-sidebar">
                                    <div class="{{ $fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.3')  || $fieldName['field_identifier'] == 'basic_description' || $fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.2') ? 'col-sm-12' : 'col-sm-4 col-md-3'  }}">
                                        <div class="form-group">
                                            <label>{{$fieldName['name']}} {!! in_array('required', $validation)  ? '<span class="mandatory">*</span>' : ''!!}</label><br>

                                            @if($fieldName['field_identifier'] == \Config::get('constants.INPUT_TYPE_FIELD_IDENTIFIER.1'))
                                                <input id="basic-name" type="text"
                                                       class="input-text
                                                            {{ in_array('required', $validation)  ? 'requiredClass' : ''}}
                                                       {{ in_array('date', $validation)  ? 'dateClass' : ''}}
                                                       {{ in_array('email', $validation)  ? 'emailClass' : ''}}
                                                       {{ in_array('url', $validation)  ? 'urlClass' : ''}}
                                                               "
                                                       value="{{ old($fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name']))}}"
                                                       name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                       placeholder="{{$fieldName['name']}}"
                                                       {{ in_array('required', $validation)  ? 'required' : ''}}
                                                       <?php if(in_array('numeric', $validation)){ ?>
                                                       onkeypress="return isNumberKey(event,this)"
                                                       <?php } if(in_array('alpha_space_numeric', $validation)){ ?>
                                                       onkeypress="return isAlphaNumeric(event,this)"
                                                       <?php } if(in_array('date', $validation)){ ?>
                                                       onblur="validatedate(this)"
                                                       <?php } if(in_array('alpha_spaces', $validation)){ ?>
                                                       onkeypress="return onlyAlphabets(event,this);"
                                                       <?php }  if(in_array('email', $validation)){ ?>
                                                       onblur="emailValidate(this)"
                                                       <?php }  if(in_array('url', $validation)){ ?>
                                                       onblur="urlValidate(this)"
                                                <?php } ?>
                                                        >
                                            @elseif($fieldName['field_identifier'] == \Config::get('constants.INPUT_TYPE_FIELD_IDENTIFIER.3'))

                                                @php
                                                $lastVal = end($validation);
                                                $field_id = $fieldName['id'];
                                                @endphp
                                                @php $field_name = str_replace(' ', '', $fieldName['name']);
                                                preg_match_all('!\d+!', $lastVal, $lastVal);
                                                if(!empty($lastVal[0][0])){
                                                $countedVal = $lastVal[0][0]-1;
                                                }
                                                @endphp


                                                <div class="property-image-upload-box">
                                                    <span class="image-upload-action-btns">
                                                    <span>
                                                        <a href="javascript:void(0);" title="Show list"
                                                           class="expand-more-btn btn-link hide"
                                                           data-target="#js-add-more-upload-files"
                                                           data-toggle="collapse"><i class="fa fa-list"></i></a>
                                                    </span>
                                                        @if(isset($countedVal))
                                                            <span>
                                                     <button type="button" title="Add more images" value="Add More Images"
                                                             id="add-images" class="add-more-images btn-link"><i
                                                                 class="fa fa-plus-circle"></i></button>
                                                    </span>@endif
                                                </span>

                                                    <div id="images">
                                                        <div class="form-group custom-file-upload-field">

                                                            <input type="file" class="file file-custom-field"
                                                                   value=""
                                                                   name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}[]"
                                                                   placeholder="{{$fieldName['name']}}"
                                                                    >

                                                            <div class="input-group col-xs-12">
                                                                <span class="input-group-addon radio-set-default"
                                                                      data-trigger="hover" data-toggle="tooltip"
                                                                      data-placement="left" title="Set as default"
                                                                      data-container="body">
                                                                     @if(isset($countedVal))
                                                                        <input type="radio" id="0" value="0" checked
                                                                               name="main_image"/>
                                                                        <label for="0"></label>
                                                                    @endif
                                                                </span>

                                                                <input type="text" class="input-text mb-0
                                                            {{ in_array('required', $validation)  ? 'requiredfileClass' : ''}}"
                                                                       disabled
                                                                       name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                                       placeholder="Upload Image">
                                                          <span class="input-group-btn edit-input-group-action-btn">
                                                              <button class="browse btn btn-default font-12"
                                                                      type="button"><i class="fa fa-upload"></i>
                                                              </button>
                                                          </span>
                                                            </div>


                                                        </div>

                                                        <div class="add-more-upload-files collapse"
                                                             aria-expanded="false"
                                                             id="js-add-more-upload-files"></div>

                                                    </div>
                                                </div>




                                        {{--<label class="custom-file">
                                            <input type="file" id="file2" class="custom-file-input">
                                            <span class="custom-file-control"></span>
                                        </label>--}}
                                        {{-- <input type="file" class="input-text" value="{{ old($fieldName['id'])}}" name="{{$fieldName['id']}}" placeholder="{{$fieldName['name']}}" {{ in_array('required', $validation)  ? 'required' : ''}}>--}}
                                        @elseif($fieldName['field_identifier'] == \Config::get('constants.INPUT_TYPE_FIELD_IDENTIFIER.2'))
                                            <input id="getLocationInput" onFocus="geolocate()" type="text"
                                                   class="input-text
                                                        {{ in_array('required', $validation)  ? 'requiredClass' : ''}}
                                                           "
                                                   value="{{ old($fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name']))}}"
                                                   name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                   placeholder="{{$fieldName['name']}}"
                                                   {{ in_array('required', $validation)  ? 'required' : ''}}
                                                   <?php  if(in_array('alpha_space_numeric', $validation)){ ?>
                                                   onkeypress="return isAlphaNumeric(event,this)"
                                                   <?php } if(in_array('alpha_spaces', $validation)){ ?>
                                                   onkeypress="return onlyAlphabets(event,this);"
                                                   <?php }  ?>
                                                    >
                                            <input type="hidden" id="getLat" name="lat"/>
                                            <input type="hidden" id="getLong" name="long"/>


                                        @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.1'))
                                            <input type="text" class="input-text
                                                        {{ in_array('required', $validation)  ? 'requiredClass' : ''}}
                                            {{ in_array('date', $validation)  ? 'dateClass' : ''}}
                                            {{ in_array('email', $validation)  ? 'emailClass' : ''}}
                                            {{ in_array('url', $validation)  ? 'urlClass' : ''}}
                                                    "
                                                   value="{{ old($fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name']))}}"
                                                   name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                   placeholder="{{$fieldName['name']}}"
                                                   {{ in_array('required', $validation)  ? 'required' : ''}}
                                                   {{--{{ in_array('numeric', $validation)  ? 'onkeypress= return isNumberKey(event)' : ''}}--}}
                                                   <?php if(in_array('numeric', $validation)){ ?>
                                                   onkeypress="return isNumberKey(event,this)"
                                                   <?php } if(in_array('alpha_space_numeric', $validation)){ ?>
                                                   onkeypress="return isAlphaNumeric(event,this)"
                                                   <?php } if(in_array('date', $validation)){ ?>
                                                   onblur="validatedate(this)"
                                                   <?php } if(in_array('alpha_spaces', $validation)){ ?>
                                                   onkeypress="return onlyAlphabets(event,this);"
                                                   <?php }  if(in_array('email', $validation)){ ?>
                                                   onblur="emailValidate(this)"
                                                   <?php }  if(in_array('url', $validation)){ ?>
                                                   onblur="urlValidate(this)"
                                            <?php } ?>
                                                    >



                                        @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.2'))
                                            <div class="row">
                                                @foreach($fieldName['options'] as $optionValue)
                                                    <div class="col-lg-4 col-md-4 col-sm-4 mt-15 mb-15">
                                                        <input id="R{{$optionValue['id']}}"
                                                               type="radio"
                                                               class=" {{ in_array('required', $validation)  ? 'requiredClass' : ''}} radio"
                                                               value="{{$optionValue['id']}}"
                                                               name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}[]"
                                                                {{old($fieldName['id'])  ? 'checked' : ''}}
                                                                {{in_array('required', $validation)  ? 'required' : ''}}
                                                                {{ !empty(old($fieldName['id'].'_'.str_replace(' ', '', $fieldName['name']))) ? ( old($fieldName['id'].'_'.str_replace(' ', '', $fieldName['name'])) == $optionValue['id']) ? 'checked' : '' : ''}}
                                                                >
                                                        <label for="R{{$optionValue['id']}}">{{$optionValue['display_value']}}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.3'))

                                            <div class="row">
                                                @foreach($fieldName['options'] as $optionValue)
                                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                                        <div class="checkbox checkbox-theme checkbox-circle">

                                                            <input id="{{$optionValue['id'].'_'.$fieldName['name']}}"
                                                                   type="checkbox"
                                                                   class="checkbox property-checkbox  {{ in_array('required', $validation)  ? 'requiredClass' : ''}}"
                                                                   name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}[]"
                                                                   value="{{$optionValue['id']}}"
                                                                    {{in_array('required', $validation)  ? 'required' : ''}}
                                                                    {{ !empty(old($fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name']))) ? in_array($optionValue['id'], old($fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name']))) ? 'checked' : '' : ''}}
                                                                    >
                                                            <label class="check "
                                                                   for="{{$optionValue['id'].'_'.$fieldName['name']}}"> {{$optionValue['display_value']}}</label>
                                                        </div>
                                                    </div>

                                                @endforeach
                                            </div>
                                        @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.4'))
                                            <input type="date"
                                                   class="input-text
                                                        {{ in_array('required', $validation)  ? 'requiredClass' : ''}}
                                                   {{ in_array('date', $validation)  ? 'dateClass' : ''}}
                                                           "
                                                   name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                   value="{{ old($fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name']))}}"
                                                   placeholder="{{$fieldName['name']}}"
                                                   {{in_array('required', $validation)  ? 'required' : ''}}
                                                   <?php  if(in_array('date', $validation)){ ?>
                                                   onblur="validatedate(this)"
                                                   <?php } ?>
                                                    >
                                        @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.5'))
                                            <input type="datetime"
                                                   class="input-text dateTimeClass
                                                        {{ in_array('required', $validation)  ? 'requiredClass' : ''}}
                                                           "
                                                   name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                   value="{{ old($fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name']))}}"
                                                   placeholder="{{$fieldName['name']}}"
                                                   {{in_array('required', $validation)  ? 'required' : ''}}
                                                    >
                                        @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.6'))

                                            <input type="email" class="input-text emailClass
                                                    {{ in_array('required', $validation)  ? 'requiredClass' : ''}}
                                                    {{ in_array('email', $validation)  ? 'emailClass' : ''}}
                                                    "
                                                   name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                   value="{{ old($fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name']))}}"
                                                   placeholder="{{$fieldName['name']}}"
                                                   {{in_array('required', $validation)  ? 'required' : ''}}
                                                   <?php  if(in_array('email', $validation)){ ?>
                                                   onblur="emailValidate(this)"
                                                   <?php } ?>
                                                    >
                                        @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.7'))
                                            <input type="number"
                                                   min="0"
                                                   class="input-text typeNumber
                                                   {{ in_array('required', $validation)  ? 'requiredClass' : ''}}
                                                           "
                                                   onkeypress="return isNumberKey(event,this)"
                                                   name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                   value="{{ old($fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name']))}}"
                                                   placeholder="{{$fieldName['name']}}"
                                                   {{in_array('required', $validation)  ? 'required' : ''}}
                                                    >
                                        @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.8'))
                                            <input type="time"
                                                   class="input-text
                                                    {{ in_array('required', $validation)  ? 'requiredClass' : ''}}
                                                   {{ in_array('date', $validation)  ? 'dateClass' : ''}}
                                                           "
                                                   name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                   value="{{ old($fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name']))}}"
                                                   placeholder="{{$fieldName['name']}}"
                                                   {{in_array('required', $validation)  ? 'required' : ''}}

                                                    >
                                        @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.9'))
                                            <input type="url"
                                                   class="input-text urlClass
                                                   {{ in_array('required', $validation)  ? 'requiredClass' : ''}}
                                                   {{ in_array('url', $validation)  ? 'urlClass' : ''}}

                                                           "
                                                   name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                   value="{{ old($fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name']))}}"
                                                   placeholder="{{$fieldName['name']}}"
                                                   {{in_array('required', $validation)  ? 'required' : ''}}
                                                   <?php   if(in_array('url', $validation)){ ?>
                                                   onblur="urlValidate(this)"
                                            <?php } ?>
                                                    >
                                        @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.10'))
                                            <input type="password"
                                                   class="input-text
                                                   {{ in_array('required', $validation)  ? 'requiredClass' : ''}}
                                                           "
                                                   name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                   value="{{ old($fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name']))}}"
                                                   placeholder="{{$fieldName['name']}}"
                                                   {{in_array('required', $validation)  ? 'required' : ''}}
                                                   <?php if(in_array('numeric', $validation)){ ?>
                                                   onkeypress="return isNumberKey(event,this)"
                                                   <?php } if(in_array('alpha_num', $validation)){ ?>
                                                   onkeypress="return isAlphaNumeric(event,this)"
                                                   <?php } if(in_array('alpha_spaces', $validation)){ ?>
                                                   onkeypress="return onlyAlphabets(event,this);"
                                                   <?php }  ?>
                                                    >
                                        @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.12'))
                                            <div class="form-group custom-file-upload-field">
                                                <input type="file"
                                                       class="file file-custom-field"
                                                       value="{{ old($fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name']))}}"
                                                       name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                       placeholder="{{$fieldName['name']}}"
                                                        >

                                                <div class="input-group col-xs-12">
                                                    <span class="input-group-addon"><i
                                                                class="glyphicon glyphicon-picture"></i></span>
                                                    <input type="text" class="input-text
                                                            {{ in_array('required', $validation)  ? 'requiredfileClass' : ''}}"
                                                           disabled
                                                           value="{{ old($fieldName['id'])}}"
                                                           name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                           placeholder="Upload Image">
                                                      <span class="input-group-btn edit-input-group-action-btn">
                                                        <button class="browse btn btn-default" type="button"><i class="fa fa-upload"></i>
                                                        </button>
                                                      </span>
                                                </div>
                                            </div>
                                        @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.13'))
                                            <textarea
                                                    class="input-text textareaCls
                                                    {{ in_array('required', $validation)  ? 'requiredClass' : ''}}
                                                    {{ in_array('date', $validation)  ? 'dateClass' : ''}}
                                                    {{ in_array('email', $validation)  ? 'emailClass' : ''}}
                                                    {{ in_array('url', $validation)  ? 'urlClass' : ''}}
                                                            "
                                                    name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                    value="{{ old($fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name']))}}"
                                                    placeholder="{{$fieldName['name']}}"
                                                    {{in_array('required', $validation)  ? 'required' : ''}}
                                                    <?php if(in_array('numeric', $validation)){ ?>
                                                    onkeypress="return isNumberKey(event,this)"
                                                    <?php } if(in_array('alpha_space_numeric', $validation)){ ?>
                                                    onkeypress="return isAlphaNumeric(event,this)"
                                                    <?php } if(in_array('date', $validation)){ ?>
                                                    onblur="validatedate(this)"
                                                    <?php } if(in_array('alpha_spaces', $validation)){ ?>
                                                    onkeypress="return onlyAlphabets(event,this);"
                                                    <?php }  if(in_array('email', $validation)){ ?>
                                                    onblur="emailValidate(this)"
                                                    <?php }  if(in_array('url', $validation)){ ?>
                                                    onblur="urlValidate(this)"
                                            <?php } ?>
                                                    >{{old($fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name']))}}</textarea>
                                        @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.11'))
                                            <select
                                                    name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}[]"
                                                    class="selectpicker search-fields  {{ in_array('required', $validation)  ? 'requiredClass' : ''}}"
                                                    {{in_array('required', $validation)  ? 'required' : ''}}>
                                                <option value="">Please Select List</option>
                                                @foreach($fieldName['options'] as $optionValue)
                                                    <option value="{{$optionValue['id']}}"
                                                            {{!empty(old($fieldName['id'].'_'.$fieldName['name'])) ? ( old($fieldName['id'].'_'.$fieldName['name']) == $optionValue['id']) ? 'selected' : '' : ''}}>{{$optionValue['display_value']}}</option>
                                                @endforeach
                                            </select>
                                        @endif

                                    </div>


                                    <span class="d-block small font-12 text-danger mt-5">{{$errors->first($fieldName['id'].'_'.str_replace(' ', '', $fieldName['name']))}}</span>
                                    </div>
                                    </div>
                                @if($count%4 == 0)
                                    <div class="clearfix"></div>
                                @endif
                                <?php $count++; ?>
                            @endforeach
                            <div class="clearfix"></div>
                        @endforeach

                        @if(isset($_GET['property_type_id']))

                         <div class="col-md-12">
                             <hr>
                            <div class="checkbox checkbox-theme checkbox-circle">
                                <input id="is_approved_checked" name="is_approved_checked" type="checkbox" value="1" >
                                <label for="is_approved_checked">
                                    Approval Required
                                </label>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cancellation policy <span class="mandatory">*</span></label>
                                <select class="selectpicker search-fields requiredClass" id="policyType" name="policyType">
                                    <option value="">Select Policy</option>
                                    @foreach($policyTypes as $policyType)
                                        <option value="{{$policyType['id']}}">{{$policyType['policy_name']}}</option>
                                    @endforeach
                                </select>
                                <span id="property_error"
                                      style=" color:red; display:none;">Please select property type</span>
                            </div>
                            
                        </div>

                        <div class="clearfix"></div>
                         @endif

                        <div class="col-sm-12 mt-15">
                            <input type="submit" class="btn button-md button-theme testing-class" name="submit"
                                   id="submitProperty" value ="submit">
                        </div>
                        <div class="clearfix"></div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Submit Property end -->
    @endsection

    @section('scripts')
        @include('js-helper.property_information_validation_js')
        <script src="{{ asset( 'js/toastr.min.js' ) }}"></script>
        <script>
            var nameLength = $('#basic-name').length;
            $(function () {
                const eleBody = $('body');
                var nomore = 0;
                var uploasFilesList = $(".add-more-upload-files");
                uploasFilesList.niceScroll({
                    zindex: 99,
                    horizrailenabled: false

                });

                $('[data-toggle="tooltip"]').tooltip();

                $(document).on('click', function (e) {

                    $('[data-toggle="collapse"]').each(function () {

                        //the 'is' for buttons that trigger popups
                        //the 'has' for icons within a button that triggers a popup

                        /* console.log($(this).is(e.target));
                         console.log($(this).has(e.target).length);
                         console.log($('.collapse').has(e.target).length);
                         console.log($('#add-images').has(e.target).length);*/

                        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.collapse').has(e.target).length === 0) {
                            eleBody.find('#js-add-more-upload-files').collapse('hide'); // fix for BS 3.3.6
                        }

                    });
                });
                eleBody.on('click', '#add-images', function (e) {
                    e.preventDefault();

                    var fieldId = '<?php if(isset($field_id)){echo $field_id;} ?>'
                    var countedVal = '<?php if(isset($countedVal)){ echo $countedVal;} ?>'
                    var field_name = '<?php if(isset($field_name)){echo $field_name;} ?>'

                    /*Check if input file has value*/
                    var checkInputVal = false;
                    eleBody.find('.add-more-upload-files .custom-file-upload-field').each(function (index, element) {
                        if ($(element).find('input.input-text').val() == '') {
                            checkInputVal = !checkInputVal;
                        }
                    });

                    eleBody.on('change', '.file-custom-field', function () {

                        if ($(this).val() !== "") {
                            $(this).parent().find('.feature-radio-disabled').addClass('hide');
                            $(this).parent().find('input[type="radio"]').removeAttr('disabled');
                            $(this).parent().find('[data-toggle="tooltip"]').tooltip();
                        }

                    });

                    if ($('#images').find('.custom-file-upload-field input.input-text').val() == '' || checkInputVal) {
                        var errorMsgDiv = $('.toast-error').length;
                        if(errorMsgDiv==0) {
                            toastr.error('Please select the image','',{timeOut: 100});
                        }
                        return false;
                    }

                    uploasFilesList.getNiceScroll().resize();
                    $('.expand-more-btn').removeClass('hide');


                    eleBody.find('#js-add-more-upload-files').collapse('show');
                    e.stopPropagation();


                    if (nomore < countedVal) {
                        nomore++;

                        $('#js-add-more-upload-files').append('<div class="form-group custom-file-upload-field">' +
                                '<input type="file" class="file file-custom-field" name="' + fieldId + '_' + field_name + '[]' + '"/>' +
                                '<div class="input-group col-xs-12  input-group-sm">' +
                                '<span class="input-group-addon radio-set-default" data-toggle="tooltip" data-placement="left" data-trigger="hover" title="Set as default" data-container="body"><span class="feature-radio-disabled"></span><input disabled type="radio" id="' + nomore + '" value="' + nomore + '" name="main_image"/>' +
                                '<label for="' + nomore + '"></label></span>' +
                                '<input class="input-text requiredfileClass mb-0" disabled="" name=" ' + fieldId + '_' + field_name + ' " placeholder="Upload Image" type="text">' +
                                '<span class="input-group-btn edit-input-group-action-btn">' +
                                '<button class="browse btn btn-default font-12" type="button"><i class="fa fa-upload"></i>' +
                                '</button></span>' +
                                '</div>' +
                                '</div>');
                        $('[data-toggle="tooltip"]').tooltip('hide');

                    } else {
                        var errorMsgDiv = $('.toast-error').length;
                        if(errorMsgDiv==0){
                            toastr.error('You can not add more images','Sorry',{timeOut: 600});
                        }
                        return false;
                    }

                });



                var propertyTypeId = $("#propertyType option:selected").val();
                $('#submitProperty').hide();
                function checkPropertyOption() {
                    if(propertyTypeId == 0) {
                        $('#submitProperty').hide();
                    } else {
                        $('#submitProperty').show();
                    }
                }


                $('#propertyType').on('change', function (e) {
                    var propertyTypeId = $("#propertyType option:selected").val();
                    //  checkPropertyOption();
                    if (propertyTypeId !== 0) {
                        var url = '{{ route('property_information') }}?property_type_id=' + propertyTypeId
                        //  alert(url);
                        window.location = url;
                    }
                });
                checkPropertyOption();


                $(document).on('click', '.browse', function () {
                    var file = $(this).parent().parent().parent().find('.file');
                    file.trigger('click');
                });
                $(document).on('change', '.file', function () {
                    $(this).parent().find('.input-text').val($(this).val().replace(/C:\\fakepath\\/i, ''));
                });
                /*$('#submitProperty').click(function(){


                });*/
                if(nameLength==0){
                    $('select[originalid=V1_I1_T6]').val("0");
                    //$('#propertyType option:selected').val(0);
                    //alert($('#propertyType').val());
                   /* $("#propertyType").filter(function() {

                        return $(this).val('0');
                    }).prop('selected', true);*/
                    $('#submitProperty').hide();
                }

            });

          /*  jQuery(document).ready(function($) {

                if (window.history && window.history.pushState) {

                    $(window).on('popstate', function() {
                        var hashLocation = location.hash;
                        var hashSplit = hashLocation.split("#!/");
                        var hashName = hashSplit[1];

                        if (hashName !== '') {
                            var hash = window.location.hash;
                            if (hash === '') {
                                alert('Back button was pressed.');
                                //window.location.reload();
                            }
                        }
                    });

                    window.history.pushState('forward', null, './#forward');
                }

            });*/

            window.onload = function () {
                if (typeof history.pushState === "function") {
                    history.pushState("jibberish", null, null);
                    window.onpopstate = function () {
                        path = '{{route("seller-properties")}}';
                        window.location.href=path;
                        //history.pushState('newjibberish', null, null);
                    };
                }
                else {
                    var ignoreHashChange = true;
                    window.onhashchange = function () {
                        if (!ignoreHashChange) {
                            ignoreHashChange = true;
                            window.location.hash = Math.random();
                            //alert('2');
                            // Detect and redirect change here
                            // Works in older FF and IE9
                            // * it does mess with your hash symbol (anchor?) pound sign
                            // delimiter on the end of the URL
                        }
                        else {
                            ignoreHashChange = false;
                        }
                    };
                }
            }

        </script>

@endsection
