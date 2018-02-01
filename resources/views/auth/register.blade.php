@extends('layouts.without_header')
@section('title')
    Sign Up
@endsection
@section('content')
<div class="page_loader"></div>
<!-- Option Panel -->
{{--<div class="option-panel option-panel-collased">
    <h2>Change Color</h2>
    <div class="color-plate default-plate" data-color="default"></div>
    <div class="color-plate blue-plate" data-color="blue"></div>
    <div class="color-plate yellow-plate" data-color="yellow"></div>
    <div class="color-plate blue-light-plate" data-color="blue-light"></div>
    <div class="color-plate green-light-plate" data-color="green-light"></div>
    <div class="color-plate green-plate" data-color="green"></div>
    <div class="color-plate yellow-light-plate" data-color="yellow-light"></div>
    <div class="color-plate green-light-2-plate" data-color="green-light-2"></div>
    <div class="color-plate olive-plate" data-color="olive"></div>
    <div class="color-plate purple-plate" data-color="purple"></div>
    <div class="color-plate midnight-blue-plate" data-color="midnight-blue"></div>
    <div class="color-plate brown-plate" data-color="brown"></div>
    <div class="setting-button">
        <i class="fa fa-gear"></i>
    </div>
</div>--}}
<!-- /Option Panel -->

<div class="container">
        <div class="row">
        <div class="col-lg-12">
            <!-- Form content box start -->
            <div class="form-content-box">
                <!-- details -->
                <div class="details">
                    <!-- Logo-->
                    <a href="{{route('home')}}">
                        <img src="{{URL::asset('img/logo.png')}}" class="cm-logo" alt="black-logo">
                    </a>
                    <!-- Name -->
                    <h3>Signup</h3>
                    <!-- Divider -->
                   {{-- <div class="divider">
                        <span class="or-text">OR</span>
                    </div>--}}
                    <!-- Form start-->
						<form method="POST" action="{{ route('user.register') }}">
                        {{ csrf_field() }}
                        
                        
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <input id="first_name" type="text" class="input-text" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required autofocus>
                        @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                        </div>



                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <input id="last_name" type="text" class="input-text" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required autofocus>
                        @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                        </div>
                        

                        {{--
                         <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                            <input id="dob" type="text" class="input-text" name="dob" value="{{ old('dob') }}" placeholder="Date Of Birth" required autofocus>
                        @if ($errors->has('dob'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dob') }}</strong>
                                    </span>
                                @endif
                        </div>
                        --}}


                        
                        
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input id="email" type="email" class="input-text" name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus>
                        @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('mobile_number') ? ' has-error' : '' }}">
                            <input id="mobile-number" type="text" class="input-text" name="mobile_number" value="{{ old('mobile_number') }}" placeholder="Mobile Number" required autofocus>
                            @if($errors->has('mobile_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobile_number') }}</strong>
                                    </span>
                            @endif
                        </div>             
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input id="password" type="password" class="input-text" name="password" placeholder="Password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="form-group">
                            <input id="password-confirm" type="password" class="input-text" name="password_confirmation" placeholder="Confirm Password" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="button-md button-theme btn-block">Signup</button>
                        </div>
                    </form>
                    <!-- Form end-->
                </div>
                <!-- Footer -->
                <div class="footer">
                    <span>
                        I want to <a href="{!! url('/login'); !!}">return to login</a>
                    </span>
                </div>
            </div>
            <!-- Form content box end -->
        </div>
    </div>
    </div>
@endsection
