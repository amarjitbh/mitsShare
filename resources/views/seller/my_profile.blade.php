@extends('layouts.after_login')

@section('content')

    {{--My Profile Page Start--}}
    <div class="my-profile">
        <div class="container">
            <div class="row">
                @include('seller/sidebar')
                <div class="col-lg-6 col-md-6 col-sm-5">
                    <!-- My address start-->
                    <div class="my-address">
                        @if (session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <h1>My Account</h1>

                            {{ Form::model($user = new App\User,['url'=> route('edit-profile') ,'files'=>'true','id'=>'form_sample_1']) }}
                            <div class="form-group">
                                {{ Form::label('first_name', 'First Name ') }} <span class="text-danger">*</span>
                                {{ Form::text('first_name',Auth::user()->first_name,['class' => 'input-text','maxlength' => '30']) }}
                            </div>

                        <div class="form-group">
                            {{ Form::label('last_name', 'Last Name ') }} <span class="text-danger">*</span>
                            {{ Form::text('last_name',Auth::user()->last_name,['class' => 'input-text','maxlength' => '30',  'placeholder'=>'Last Name']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('mobile_number', 'Mobile Number ') }} <span class="text-danger">*</span>
                            {{ Form::text('mobile_number',Auth::user()->mobile_number,['class' => 'input-text','maxlength' => '30',  'placeholder'=>'Mobile Number']) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('email', 'Email ') }} <span class="text-danger">*</span>
                            {{ Form::email('email',Auth::user()->email,['class' => 'input-text','maxlength' => '30', 'readonly'=>true, 'placeholder'=>'Email']) }}
                        </div>
                            <div class="form-group">
                                {{ Form::label('about_me', 'About Me ') }}
                                {{ Form::textarea('about_me',Auth::user()->about_me,['class' => 'input-text textarea-no-resize','maxlength' => '500',  'placeholder'=>'About Me']) }}
                            </div>
                            {{ Form::submit('Save Changes', ['class' => 'btn button-md button-theme']) }}

                    </div>
                    <!-- My address end -->
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <div class="edit-profile-photo">
                        <?php
                        $image=Auth::user()->image;
                        if( $image==null ) {
                            $url_img_placeholder = asset(config('constants.IMAGE_ASSET_FOLDER_NAME').'/'.'placeholder/placeholder-person.jpg');
                        } else {
                            $url_img = asset(config('constants.IMAGE_FOLDER_NAME').'/'.$image);

                        }
                        ?>
                            <div class="user-profile-image">
                                <img width="150" height="150" src="{{($image==null)? $url_img_placeholder:$url_img }}" class="img-responsive preview" alt="User Image"/>

                            </div>
                            <a href="javascript:void(0);" id="clear-preview" class="clear-preview" style="display:none"><i class="fa fa-close"></i></a>
                        <div class="change-photo-btn">

                            <div class="photoUpload">

                                <span><i class="fa fa-upload"></i> Upload Photo</span>
                                {{ Form::file( 'pic', $attributes = array( 'class' => 'upload', 'id' =>'pic' )) }}
                            </div>
                        </div>
                    </div>
                </div>


                {{Form::Close()}}
            </div>
        </div>
    </div>
    {{--My Profile Page End--}}

@endsection
@section('scripts')

    <script>
        $(document).ready( function(){
            var baseImageUrl = '{{!empty($url_img) ? $url_img : $url_img_placeholder}}';
            //alert(baseImageUrl);
            function readURL( input ) {
                if ( input.files && input.files[0] ) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                    $( '.user-profile-image .preview' ).attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $( "#pic" ).change(function(){

                readURL(this);
                $('#clear-preview').show();
            });

            $( "#clear-preview" ).click(function(e){
                $(this).hide();
                $('#pic').val("");
                $('.preview').attr("src",baseImageUrl);
            });
        });
    </script>
@endsection