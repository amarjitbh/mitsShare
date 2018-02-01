@extends('layouts.before_login_seller')
@section('content')
    <style>
        .mandatory {

            color : red;
        }
    </style>

        <!-- Sub banner start -->
<div class="sub-banner">
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
                <div class="submit-address">
                    <form method="POST" action="{{route('property.update')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Property Type</label>
                                <select disabled class="selectpicker search-fields" id="propertyTypeEdit">
                                    <option>Select Property Type</option>
                                    @if(!empty($propertyTypeSectionData))
                                        @foreach($propertyTypes as $propertyType)
                                            <option value="{{$propertyType['id']}}" {{$propertyType['id'] == $propertyTypesId ? 'selected' : ''}}>{{$propertyType['name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <input type="hidden" name="property_types_id" value="{{$propertyTypesId}}">
                            <input type="hidden" name="property_id" value="{{$propertyId}}">

                            @foreach($propertyEditArr as $property)
                                <input type="hidden" name="property_field_value_id[]"
                                       value="{{$property['property_id']}}">
                            @endforeach

                        </div>
                        <div class="clearfix">&nbsp;</div>
                        @if(!empty($propertyTypeSectionData))
                            @foreach($propertyTypeSectionData as $ind => $propertyTypeSectionName)
                                <h1>{{$propertyTypeSectionName['section_name']}}</h1>
                                <?php $count = 1;?>
                                @foreach($propertyTypeSectionName['fields'] as  $fieldName)
                                    <?php $validation = explode(",", $fieldName['validations']); ?>
                                    <div class="search-contents-sidebar">
                                        <div class="{{ $fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.3') || $fieldName['field_identifier'] == 'basic_description'
                                        || $fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.2') ? 'col-sm-12' : 'col-sm-3'  }}">
                                            <div class="form-group">
                                                <label>{{$fieldName['name']}} {!! in_array('required', $validation)  ? '<span class="mandatory">*</span>' : ''!!}</label><br>

                                                @if($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.1'))

                                                    <input type="text"
                                                           class="input-text
                                                        {{ in_array('required', $validation)  ? 'requiredClass' : ''}}
                                                           {{ in_array('date', $validation)  ? 'dateClass' : ''}}
                                                           {{ in_array('email', $validation)  ? 'emailClass' : ''}}
                                                           {{ in_array('url', $validation)  ? 'urlClass' : ''}}
                                                                   "
                                                           value="{{isset($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']) ? $propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0'] : '' }}"
                                                           name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                           @if($fieldName['name'] == 'Location')
                                                           id="getLocationInput" onFocus="geolocate()" @endif
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
                                                    @if( $fieldName['name'] == 'Location' )
                                                        <input type="hidden" id="getLat"
                                                               value="{{isset($propertyEditArr[$fieldName['id']]['lat']) ? $propertyEditArr[$fieldName['id']]['lat'] : '' }}"
                                                               name="lat"/>
                                                        <input type="hidden" id="getLong"
                                                               value="{{isset($propertyEditArr[$fieldName['id']]['lng']) ? $propertyEditArr[$fieldName['id']]['lng'] : '' }}"
                                                               name="long"/>
                                                    @endif
                                                @elseif($fieldName['field_identifier'] == \Config::get('constants.INPUT_TYPE_FIELD_IDENTIFIER.1'))
                                                    <input type="text"
                                                           @if($fieldName['name'] == 'Location')  id="autocomplete"
                                                           onFocus="geolocate()" @endif
                                                           class="input-text
                                                       @if($fieldName['name'] == 'Location')
                                                    {{ in_array('required', $validation)  ? 'requiredClass' : ''}}
                                                    @else
                                                    {{ in_array('required', $validation)  ? 'requiredClass' : ''}}
                                                    {{ in_array('date', $validation)  ? 'dateClass' : ''}}
                                                    {{ in_array('email', $validation)  ? 'emailClass' : ''}}
                                                    {{ in_array('url', $validation)  ? 'urlClass' : ''}}
                                                    @endif
                                                            "
                                                           value="{{ old($fieldName['id'])}}"
                                                           name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                           placeholder="{{$fieldName['name']}}"
                                                            {{ in_array('required', $validation)  ? 'required' : ''}}>
                                                @elseif($fieldName['field_identifier'] == \Config::get('constants.INPUT_TYPE_FIELD_IDENTIFIER.3'))
                                                    @php
                                                    $lastVal = end($validation);
                                                    $field_id = $fieldName['id'];
                                                    @endphp
                                                    @php
                                                    $field_name = str_replace(' ', '', $fieldName['name']);
                                                    preg_match_all('!\d+!', $lastVal, $lastVal);
                                                    if(!empty($lastVal[0][0])){
                                                    $countedVal = $lastVal[0][0];
                                                    }
                                                    @endphp
                                                    @php $multipleImages =
                                                    json_decode($propertyEditArr[$fieldName['id']]['property_type_section_field_value'][0],
                                                    true);
                                                    $uploadedImg = count($multipleImages);
                                                    @endphp
                                                    @if(!empty($multipleImages) && is_array($multipleImages))
                                                        @foreach($multipleImages as $multipleImage)
                                                            @if($multipleImage['chk']==1)
                                                                @php $url = $multipleImage['image']; @endphp
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    @if(isset($countedVal))
                                                        <div class="property-image-upload-box">
                                                    <span class="image-upload-action-btns">
                                                    <span id="span-add-more-button-insert-after">
                                                        <a href="javascript:void(0);" title="Show list"
                                                           class="expand-more-btn btn-link"
                                                           data-target="#js-add-more-upload-files"
                                                           data-toggle="collapse"><i class="fa fa-list"></i></a>
                                                    </span>

                                                        @if(isset($countedVal))
                                                            @if($countedVal!=$uploadedImg)
                                                                <span id="span-add-more-button">
                                                                    <button type="button" title="Add more images"
                                                                            value="Add More Images" id="add-images"
                                                                            class="add-more-images btn-link"><i
                                                                                class="fa fa-plus-circle"></i></button>
                                                                </span>
                                                            @endif
                                                        @endif
                                                </span>

                                                            <div class="hide uploaded-images-list">
                                                                <div class="placeholder-image"
                                                                     data-placeholderupload="{{URL::to('/img/edit-placeholder-product.jpg')}}"></div>
                                                                @if(!empty($multipleImages) && is_array($multipleImages))
                                                                @foreach($multipleImages as $key => $multipleImage)
                                                                    <div class="form-group custom-file-upload-field edit-custom-file-upload-field">
                                                                        <input type="file"
                                                                               class="file file-custom-field"
                                                                               name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}[]"
                                                                               placeholder="{{$fieldName['name']}}" {{ empty($multipleImage['image']) ?  in_array('required', $validation)  ? 'required' : '' : ''}}
                                                                        >

                                                                        <div class="input-group col-xs-12">
                                                                         <span class="input-group-addon radio-set-default"
                                                                               data-toggle="tooltip"
                                                                               data-placement="left"
                                                                               data-trigger="hover"
                                                                               data-title="Set as default"
                                                                               data-container="body">
                                                                             <input type="radio"
                                                                                    data-default="@if($multipleImage['chk']==1) 1 @else 0 @endif"
                                                                                    id="@php echo $key @endphp"
                                                                                    value="@php echo $key @endphp"
                                                                                    @if($multipleImage['chk']==1)
                                                                                    checked
                                                                                    @endif name="main_image"/>
                                                                                 <label for="@php echo $key @endphp"></label>

                                                                         </span>
                                                                        <span class="input-group-addon input-group-preview-image"
                                                                              data-toggle="tooltip"
                                                                              data-placement="top"
                                                                              data-trigger="hover"
                                                                              data-title="View image"
                                                                              data-container="body">
                                                                             <a data-original="{{URL::to('/images/'.$multipleImage['image'])}}"
                                                                                style="background-image: url('{{URL::to('/images/'.$multipleImage['image'])}}')"
                                                                                href="{{URL::to('/images/'.$multipleImage['image'])}}"
                                                                                class="small btn-link">
                                                                                 &nbsp;
                                                                             </a>
                                                                            <span class="clear-temp-preview hide"><span
                                                                                        class="d-inline-block"><i
                                                                                            class="fa fa-close"></i></span></span>
                                                                        </span>
                                                                            <input type="text" class="input-text mb-0
                                                                            {{empty($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']) ?
                                                                                        in_array('required', $validation)  ? 'requiredClass' : ''
                                                                                  : ''
                                                                            }}
                                                                                    "
                                                                                   disabled
                                                                                   value="{{old($fieldName['id'])}}"
                                                                                   name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                                                   placeholder="Upload Image"
                                                                            >
                                                                      <span class="input-group-btn edit-input-group-action-btn">
                                                                          <button type="button" class="browse btn btn-default font-12"
                                                                                   title="Upload Image"><i
                                                                                      class="fa fa-upload"></i>
                                                                          </button>
                                                                      </span>
                                                                        <span class="input-group-btn edit-input-group-action-btn">
                                                                          <button type="button" class="remove-image btn btn-default" title="Remove Image"
                                                                                  data-value="{{$key}}"><i
                                                                                      class="fa fa-trash-o"></i>
                                                                          </button>
                                                                      </span>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                                    @endif

                                                            </div>
                                                            <div id="after-remove" class="hide"></div>
                                                            <div id="images">

                                                                <div class="add-more-upload-files collapse"
                                                                     aria-expanded="false"
                                                                     id="js-add-more-upload-files">
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="form-group edit-custom-file-upload-field custom-file-upload-field mb-0">

                                                            <input type="file" class="file file-custom-field"
                                                                   value=""
                                                                   name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}[]"
                                                                   placeholder="{{$fieldName['name']}}" {{ empty($multipleImage['image']) ?  in_array('required', $validation)  ? 'required' : '' : ''}}
                                                            >

                                                            <div class="input-group col-xs-12">
                                                                <span class="input-group-addon input-group-preview-image"
                                                                      data-toggle="tooltip"
                                                                      data-placement="top"
                                                                      data-trigger="hover"
                                                                      data-title="View image"
                                                                      data-container="body">

                                                                             <a data-original="{{URL::to('/images/'.$multipleImage['image'])}}"
                                                                                style="background-image: url('{{URL::to('/images/'.$multipleImage['image'])}}')"
                                                                                href="{{URL::to('/images/'.$multipleImage['image'])}}"
                                                                                class="small btn-link">
                                                                                 &nbsp;
                                                                             </a>
                                                                            <span class="clear-temp-preview hide"><span
                                                                                        class="d-inline-block"><i
                                                                                            class="fa fa-close"></i></span></span>
                                                                        </span>
                                                                <input type="text" class="input-text

                                                                    {{empty($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']) ?
                                                                                in_array('required', $validation)  ? 'requiredClass' : ''
                                                                          : ''
                                                                    }}
                                                                        "
                                                                       disabled
                                                                       value="{{old($fieldName['id'])}}"
                                                                       name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                                       placeholder="Upload Image"
                                                                >
                                                                      <span class="input-group-btn">
                                                                        <button class="browse btn btn-primary"
                                                                                type="button"><i
                                                                                    class="glyphicon glyphicon-search"></i>
                                                                            Browse
                                                                        </button>
                                                                      </span>


                                                            </div>
                                                            {{--@if(!empty($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']))
                                                                <div class="preview-thumbnail mt-5">
                                                                    @php $jsonImages = json_decode($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0'], true ); @endphp
                                                                    @foreach($jsonImages as $jsonImg)
                                                                        @if($jsonImg['chk']==1)
                                                                            @php $img_url = $jsonImg['image']; @endphp
                                                                        @endif
                                                                    @endforeach

                                                                    <a href="{{URL::to('/images/thumb_'.$img_url)}}" title="Current Image" class="small btn-link">
                                                                        <i class="fa fa-file-image-o"></i> View default image
                                                                    </a>
                                                                </div>
                                                            @endif--}}
                                                        </div>
                                                    @endif



                                                @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD_IDENTIFIER.2'))
                                                    <input type="text"
                                                           class="input-text

                                                       {{ in_array('required', $validation)  ? 'requiredClass' : ''}}
                                                           {{ in_array('date', $validation)  ? 'dateClass' : ''}}
                                                           {{ in_array('email', $validation)  ? 'emailClass' : ''}}
                                                           {{ in_array('url', $validation)  ? 'urlClass' : ''}}
                                                                   "
                                                           value="{{$propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']}}"
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
                                                @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.2'))
                                                    <div class="row">
                                                        @foreach($fieldName['options'] as $optionValue)
                                                            <div class="col-lg-4 col-md-4 col-sm-4 mt-15 mb-15">
                                                                <input id="{{$optionValue['id']}}"
                                                                       type="radio"
                                                                       class="input-text radio

                                                                    {{ in_array('required', $validation)  ? 'requiredClass' : ''}}
                                                                               "
                                                                       value="{{$optionValue['id']}}"
                                                                       name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}[]"
                                                                        {{isset($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']) && $propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0'] ==  $optionValue['id']? 'checked' : ''}}
                                                                        {{in_array('required', $validation)  ? 'required' : ''}}>
                                                                <label for="{{$optionValue['id']}}">{{$optionValue['display_value']}}</label>
                                                            </div>

                                                        @endforeach
                                                    </div>


                                                @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.3'))
                                                    <div class="row"> {{--@php @pr($propertyEditArr[$fieldName['id']]['property_type_section_field_value']); @endphp--}}
                                                        @foreach($fieldName['options'] as $optionValue)
                                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                                <div class="checkbox checkbox-theme checkbox-circle">
                                                                    <input id="{{$optionValue['id']}}"
                                                                           type="checkbox"
                                                                           class="property-checkbox

                                                                    {{ in_array('required', $validation)  ? 'requiredClass' : ''}}
                                                                                   "
                                                                           name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}[]"
                                                                           value="{{$optionValue['id']}}"
                                                                            {{isset($propertyEditArr[$fieldName['id']]['property_type_section_field_value']) ?  in_array($optionValue['id'],$propertyEditArr[$fieldName['id']]['property_type_section_field_value'])  ? 'checked' : '' : ''}}
                                                                            {{in_array('required', $validation)  ? '' : ''}}>
                                                                    <label class="check"
                                                                           for="{{$optionValue['id']}}"> {{$optionValue['display_value'] }}</label>
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
                                                           value="{{isset($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']) ? $propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0'] : ''}}"
                                                           placeholder="{{$fieldName['name']}}"
                                                           {{in_array('required', $validation)  ? 'required' : ''}}

                                                           <?php if(in_array('date', $validation)){ ?>
                                                           onblur="validatedate(this)"
                                                    <?php } ?>
                                                    >
                                                @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.5'))
                                                    <input type="datetime" class="input-text"
                                                           name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                           value="{{isset($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']) ? $propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0'] : ''}}"
                                                           placeholder="{{$fieldName['name']}}" {{in_array('required', $validation)  ? 'required' : ''}}>
                                                @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.6'))


                                                    <input type="email"
                                                           class="input-text

                                                            {{ in_array('required', $validation)  ? 'requiredClass' : ''}}
                                                           {{ in_array('email', $validation)  ? 'emailClass' : ''}}
                                                                   "
                                                           name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                           value="{{isset($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']) ? $propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0'] : ''}}"
                                                           placeholder="{{$fieldName['name']}}"
                                                           {{in_array('required', $validation)  ? 'required' : ''}}

                                                           <?php if(in_array('email', $validation)){ ?>
                                                           onblur="emailValidate(this)"
                                                    <?php } ?>
                                                    >
                                                @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.7'))
                                                    <input type="number"
                                                           class="input-text typeNumber
                                                            {{ in_array('required', $validation)  ? 'requiredClass' : ''}}
                                                                   "
                                                           onkeypress="return isNumberKey(event,this)"
                                                           name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                           value="{{isset($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']) ? $propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0'] : ''}}"
                                                           placeholder="{{$fieldName['name']}}"
                                                            {{in_array('required', $validation)  ? 'required' : ''}}>
                                                @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.8'))
                                                    <input type="time"
                                                           class="input-text
                                                            {{ in_array('required', $validation)  ? 'requiredClass' : ''}}
                                                           {{ in_array('date', $validation)  ? 'dateClass' : ''}}

                                                                   "
                                                           name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                           value="{{isset($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']) ? $propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0'] : ''}}"
                                                           placeholder="{{$fieldName['name']}}"
                                                            {{in_array('required', $validation)  ? 'required' : ''}}

                                                    >
                                                @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.9'))
                                                    <input type="url"
                                                           class="input-text urlClass
                                                       {{ in_array('url', $validation)  ? 'urlClass' : ''}}
                                                                   "
                                                           name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                           value="{{isset($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']) ? $propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0'] : ''}}"
                                                           placeholder="{{$fieldName['name']}}"
                                                           {{in_array('required', $validation)  ? 'required' : ''}}

                                                           <?php if(in_array('url', $validation)){ ?>
                                                           onblur="urlValidate(this)"
                                                    <?php } ?>
                                                    >
                                                @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.10'))
                                                    <input type="password"
                                                           class="input-text
                                                        {{ in_array('required', $validation)  ? 'requiredClass' : ''}}
                                                                   "
                                                           name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                           value="{{isset($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']) ? $propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0'] : ''}}"
                                                           placeholder="{{$fieldName['name']}}"
                                                           {{in_array('required', $validation)  ? 'required' : ''}}
                                                           <?php if(in_array('numeric', $validation)){ ?>
                                                           onkeypress="return isNumberKey(event,this)"
                                                           <?php } if(in_array('alpha_space_numeric', $validation)){ ?>
                                                           onkeypress="return isAlphaNumeric(event,this)"
                                                           <?php } if(in_array('alpha_spaces', $validation)){ ?>
                                                           onkeypress="return onlyAlphabets(event,this);"
                                                    <?php } ?>
                                                    >
                                                @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.12'))

                                                    <div class="form-group custom-file-upload-field edit-custom-file-upload-field mb-0">
                                                        <input type="file" data-extra="{{isset($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']) ? $propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0'] : ''}}"
                                                               class="file file-custom-field extra-field-value"
                                                               value="{{isset($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']) ? $propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0'] : ''}}"
                                                               name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                               placeholder="{{$fieldName['name']}}" {{ empty($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']) ?  in_array('required', $validation)  ? 'required' : '' : ''}}
                                                        >
                                                        <div class="input-group col-xs-12">
                                                            <span class="input-group-addon edit-custom-file-upload-field input-group-preview-image">

                                                                @if(!empty($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']))
                                                                <a data-original="{{URL::to('/images/'.$propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0'])}}" style="background-image: url('{{URL::to('/images/thumb_'.$propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0'])}}')" href="{{URL::to('/images/thumb_'.$propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0'])}}"
                                                                   title="View image" class="small btn-link"> &nbsp; </a>
                                                                    <span class="clear-extra-temp-preview hide"><span
                                                                                class="d-inline-block" style="position:relative; top: 30px;"><i
                                                                                    class="fa fa-close"></i></span></span>
                                                                @endif
                                                            </span>
                                                                <input type="text"
                                                                       class="input-text
                                                                     {{empty($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']) ?
                                                                                in_array('required', $validation)  ? 'requiredClass' : ''
                                                                          : ''
                                                                     }}"
                                                                       disabled
                                                                       value="{{isset($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']) ? $propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0'] : ''}}"
                                                                       name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}"
                                                                       placeholder="Upload Image"
                                                                >

                                                            <span class="input-group-btn edit-input-group-action-btn">
                                                                <button class="browse btn btn-default font-12" type="button"><i
                                                                            class="fa fa-upload"></i>
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
                                                            value="{{isset($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']) ?$propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']:''}}"
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
                                                            value="{{isset($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']) ? $propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0'] : '' }}"
                                                    >
                                                    {{isset($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']) ? $propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0'] : '' }}
                                                </textarea>

                                                @elseif($fieldName['type'] == \Config::get('constants.INPUT_TYPE_FIELD.11'))
                                                    <select name="{{$fieldName['id'].'_'.$string = str_replace(' ', '', $fieldName['name'])}}[]"
                                                            class="selectpicker search-fields
                                                        {{ in_array('required', $validation)  ? 'requiredClass' : ''}}
                                                                    "
                                                            {{in_array('required', $validation)  ? 'required' : ''}}>
                                                        <option value="">Please Select List</option>
                                                        @foreach($fieldName['options'] as $optionValue)
                                                            <option value="{{$optionValue['id']}}" {{isset($propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0']) && $propertyEditArr[$fieldName['id']]['property_type_section_field_value']['0'] ==  $optionValue['id']? 'selected' : ''}}>{{$optionValue['display_value']}}</option>
                                                        @endforeach
                                                    </select>
                                                @endif

                                            </div>
                                             <span class="d-block small font-12 text-danger mt-5">
                                                {{$errors->first($fieldName['id'].'_'.$fieldName['name'])}}
                                            </span>
                                        </div>

                                    </div>

                                    @if($count%4 == 0)
                                        <div class="clearfix"></div>

                                    @endif

                                    <?php $count++; ?>
                                @endforeach
                                <div class="clearfix"></div>
                            @endforeach
                        @endif

                         <div class="col-md-12">
                             <hr>
                             <div class="row">

                                 <div class="col-md-4">
                                     <div class="form-group mb-10">
                                         <label>Select cancellation policy <span class="mandatory">*</span></label>
                                         <select class="selectpicker search-fields requiredClass"  name="policyTypeID">
                                             <option value="">Select Policy</option>
                                             @foreach($policyTypes as $policyType)
                                                 <option value="{{$policyType['id']}}" {{$policyType['id'] == $policyTypesID ? 'selected' : ''}}>{{$policyType['policy_name']}}</option>
                                             @endforeach
                                         </select>
                                <span id="property_error"
                                      style=" color:red; display:none;">Please select property type</span>
                                     </div>
                                 </div>
                                 <div class="clearfix"></div>
                                     <div class="col-md-2">
                                         <div class="checkbox checkbox-theme checkbox-circle">
                                             <input id="is_approved_checked" name="is_approved_checked" type="checkbox" @if($checkedRequied==1) checked  @endif value="1"  >
                                             <label for="is_approved_checked">
                                                 Approval Required
                                             </label>
                                         </div>
                                     </div>
                             </div>
                        </div>
                        <div class="col-sm-12 mt-15">
                            <button class="btn button-md button-theme" type="button" name="submit" id="updateProperty"
                                    value="Submit">Submit
                            </button>
                        </div>
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
        var nomore;
        $('textarea').each(function(){
                $(this).val($(this).val().trim());
            }
        );
        $(function () {
            const eleBody = $('body');
            $('[data-toggle="tooltip"]').tooltip();

            nomore = '<?php if(isset($uploadedImg)){echo $uploadedImg;} ?>';
            var uploasFilesList = $(".add-more-upload-files");
            var fieldId = '<?php if(isset($field_id)){echo $field_id;} ?>'
            var countedVal = '<?php if(isset($countedVal)){ echo $countedVal;} ?>'
            var field_name = '<?php if(isset($field_name)){echo $field_name;} ?>'

            uploasFilesList.niceScroll({
                zindex: 99,
                horizrailenabled: false

            });

            /*Fetaures images setting*/
            const getFirstListItem = $('.uploaded-images-list .custom-file-upload-field');
            getFirstListItem.each(function (index, element) {
                if (index == 0) {
                    eleBody.find('#images').prepend($(element).detach());
                }
                else {
                    $(element).find('.input-group').addClass('input-group-sm');
                    eleBody.find('#js-add-more-upload-files').append($(element).detach());
                }
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $(input).closest('.edit-custom-file-upload-field').find('.input-group-preview-image a').css('background-image', 'url(' + e.target.result + ')');
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            eleBody.on('change', '.file-custom-field', function () {
                // var test = $(this).parent().find('.file-custom-field .input-group-preview-image a').css('background-image');
                //console.log('test');
                readURL(this);
                $(this).parent().find('.clear-temp-preview').removeClass('hide');
                $(this).parent().find('.clear-extra-temp-preview').removeClass('hide');

            });

            eleBody.on('click', '.clear-temp-preview > span', function (e) {
                $(this).parent().addClass('hide');
                $(this).closest('.edit-custom-file-upload-field').find(".file-custom-field").val("");
                $(this).closest('.edit-custom-file-upload-field').find("input.input-text").val("");
                var getOrgUrl = $(this).parent().parent().find('a').attr('data-original');
                $(this).parent().parent().find('a').css('background-image', 'url(' + getOrgUrl + ')');

            });

           /* eleBody.on('click', '.clear-extra-temp-preview > span', function (e) {
                var getOrginalValue = $(this).closest('.custom-file-upload-field').find(".extra-field-value").attr('data-extra');
                $(this).closest('.input-group').find("input.input-text").val(getOrginalValue);
                $(this).closest('.custom-file-upload-field').find("input.extra-field-value").val(getOrginalValue);
                var getOrgUrl = $(this).closest('.input-group-preview-image').find('a.small').attr('data-original');
                $(this).closest('.input-group-preview-image').find('a').css('background-image', 'url(' + getOrgUrl + ')');
                $(this).closest('.clear-extra-temp-preview').addClass('hide');
            });*/
            eleBody.on('click', '.clear-extra-temp-preview > span', function (e) {
                var getOrginalValue = $(this).closest('.custom-file-upload-field').find(".extra-field-value").attr('data-extra');
                $(this).closest('.input-group').find("input.input-text").val(getOrginalValue);
                var getOrgUrl = $(this).closest('.input-group-preview-image').find('a').attr('data-original');
                $(this).closest('.input-group-preview-image').find('a').css('background-image', 'url(' + getOrgUrl + ')');
                $(this).closest('.clear-extra-temp-preview').addClass('hide');
            });

            /*$( ".clear-temp-preview").closest('.edit-custom-file-upload-field').find('.input-group-preview-image').on('inserted.bs.tooltip', function () {
             console.log('ok')
             });*/
            function checkTooltipStaus() {
                $('.input-group-preview-image').on('inserted.bs.tooltip', function () {
                    if (!$(this).find('.clear-temp-preview').hasClass('hide')) {
                        eleBody.find('.tooltip').hide();
                    }
                    else {
                        eleBody.find('.tooltip').show();
                    }
                });
            }

            checkTooltipStaus();


            $(document).on('click', function (e) {
                $('[data-toggle="collapse"]').each(function () {

                    if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.collapse').has(e.target).length === 0) {
                        eleBody.find('#js-add-more-upload-files').collapse('hide'); // fix for BS 3.3.6
                    }

                });
            });
            // Add Images
            $('body').on('click', '#add-images', function (e) {
                e.preventDefault();
                const getPlaceholderImg = $('.placeholder-image').attr('data-placeholderupload');

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

                uploasFilesList.getNiceScroll().resize();
                $('.expand-more-btn').removeClass('hide');
                $('body').find('#js-add-more-upload-files').collapse('show');
                e.stopPropagation();

                if (nomore < countedVal) {
                    $('#js-add-more-upload-files').append('<div class="form-group custom-file-upload-field edit-custom-file-upload-field">' +
                            '<input type="file" class="file file-custom-field" name="' + fieldId + '_' + field_name + '[]' + '"/>' +
                            '<div class="input-group col-xs-12  input-group-sm">' +
                            '<span class="input-group-addon radio-set-default" data-toggle="tooltip" data-placement="left" data-trigger="hover" title="Set as default" data-container="body"><span class="feature-radio-disabled"></span><input disabled type="radio" id="' + nomore + '" value="' + nomore + '" name="main_image"/><label for="' + nomore + '"></label></span>' +
                            '<span class="input-group-addon input-group-preview-image"> <a data-original = "' + getPlaceholderImg + '" style="background-image:' + 'url(' + getPlaceholderImg + ')"  href="javascript:void(0);"  class="small btn-link">&nbsp;</a>' +
                            '<span class="clear-temp-preview hide"><span class="d-inline-block"><i class="fa fa-close"></i></span></span></span>' +
                            '<input class="input-text mb-0" disabled="" name="' + fieldId + '_' + field_name + '" placeholder="Upload Image" type="text">' +
                            '<span class="input-group-btn edit-input-group-action-btn">' +
                            '<button type="button" class="browse btn btn-default font-12" title="Upload Image" type="button"><i class="fa fa-upload"></i>' +
                            '</button></span>' +
                            '</div>' +
                            '</div>');
                    nomore++;

                } else {
                    var errorMsgDiv = $('.toast-error').length;
                    if(errorMsgDiv==0){
                        toastr.error('You can not add more images','Sorry',{timeOut: 600});
                    }
                    return false;
                }
            });

                // Remove Images
            $('body').on('click', '.remove-image', function (e) {
                var base_url = "{{asset('/images/')}}";
                e.preventDefault();
                var removeImgId = $(this).attr('data-value');
                var defaultImg = $(this).closest('.input-group').find('.input-group-addon').find('input[name=main_image]').attr('data-default');
                if (defaultImg == 1) {
                    var errorMsgDiv = $('.toast-error').length;
                    if(errorMsgDiv==0) {
                        toastr.error('Sorry,  Default Image can not be deleted',' ', {timeOut: 600});
                    }
                    return false;
                } else {
                    $.ajax({
                        type: 'post',
                        url: '{{route('update-images')}}',
                        dataType: 'JSON',
                        data: {
                            'removeImgId': removeImgId,
                            'property_id': "{{$propertyId}}",
                            'property_types_id': {{$propertyType['id']}},
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function (responce) {
                            var result = $.parseJSON(responce.data);
                            var remainingImages = result.length;
                            //var checkedRadio;
                            nomore = remainingImages;
                            $('#images').empty();
                            $.each(result, function (key, item) {
                                $('#after-remove').append('<div class="form-group custom-file-upload-field edit-custom-file-upload-field">' +
                                        '<input type="file" class="file file-custom-field" value="" name="' + fieldId + '_' + field_name + '[]' + '"/>' +
                                        '<div class="input-group col-xs-12"><span class="input-group-addon radio-set-default" data-toggle="tooltip" data-placement="left"' +
                                        'data-trigger="hover" data-title="Set as default" data-container="body">' +
                                        '<input type="radio" data-default="' + item.chk + '" id="' + key + '"' +
                                        'value="' + key + '" '+
                                        (item.chk == 1 ? 'checked': '')+
                                        ' name="main_image"/>' +
                                        '<label for="' + key + '"></label></span><span class="input-group-addon input-group-preview-image" data-toggle="tooltip"' +
                                        'data-placement="top" data-trigger="hover" data-title="View image" data-container="body">' +
                                        '<a data-original = "' + base_url + '/' + item.image + '" style="background-image: url(' + base_url + '/' + item.image + ')" href="' + base_url + '/' + item.image + '" class="small btn-link">&nbsp;</a><span class="clear-temp-preview hide"><span class="d-inline-block">' +
                                        '<i class="fa fa-close"></i></span></span></span><input type="text" class="input-text mb-0" disabled name="' + fieldId + '_' + field_name + '[]' + '"' +
                                        'placeholder="Upload Image"><span class="input-group-btn edit-input-group-action-btn"><button class="browse btn btn-default font-12" type="button" title="Upload Image"><i class="fa fa-upload"></i></button>' +
                                        '</span><span class="input-group-btn edit-input-group-action-btn" data-toggle="tooltip" data-placement="right">' +
                                        '<button class="remove-image btn btn-default" title="Remove Image" data-value="' + key + '"><i class="fa fa-trash-o"></i></button></span></div></div>');
                                });

                            $('#after-remove .edit-custom-file-upload-field').each(function (index, element) {
                                if (index == 0) {
                                    console.log(index + "Inner")
                                    $('body').find('#images').append('<div class="add-more-upload-files collapse" aria-expanded="false" id="js-add-more-upload-files"></div>');
                                    $('body').find('#images').prepend($(element));
                                }
                                else {
                                    $('#js-add-more-upload-files').append($(element));
                                }
                            });


                            $('.input-group-preview-image a').magnificPopup({
                                type: 'image',
                                mainClass: 'mfp-with-zoom'
                            });
                            if (countedVal != remainingImages) {
                                var buttonLength = $('#add-images').length;
                                if (buttonLength == 0) {
                                    $('#span-add-more-button-insert-after').after('<button title="Add more images" value="Add More Images" id="add-images" class="add-more-images btn-link"><i class="fa fa-plus-circle"></i></button>')
                                }
                            }

                            //console.log(responce);

                        }
                    });
                }

            });


            $('#propertyTypeEdit').on('change', function (e) {
                var propertyTypeId = $("#propertyTypeEdit option:selected").val();

                if (propertyTypeId != '') {
                    var url = '{{route('property.edit','2')}}?property_type_id=' + propertyTypeId
                    // alert(url);
                    window.location = url;
                }

            });


            $('#submit').click(function () {
                if ($('input.property-checkbox').is(':checked')) {
                    $("input.property-checkbox").removeAttr("required");
                }
                else {
                    $("input.property-checkbox").attr("required");
                }
            });

            $(document).on('click', '.browse', function () {
                var file = $(this).parent().parent().parent().find('.file');
                file.trigger('click');
            });
            $(document).on('change', '.file', function () {
                $(this).parent().find('.input-text').val($(this).val().replace(/C:\\fakepath\\/i, ''));
            });

            $('.input-group-preview-image a').magnificPopup({
                type: 'image',
                mainClass: 'mfp-with-zoom'
            });
        })

    </script>

@endsection