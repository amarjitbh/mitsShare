@extends('layouts.without_header')
@section('title')
    Login
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
                    <!-- Logo -->
                    <a href="{{route('home')}}">
                        <img src="{{URL::asset('img/logo.png')}}" class="cm-logo" alt="black-logo">
                    </a>
                    <!-- Name -->
                    @if(session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    {{--@if($errors->has('verify_link'))
                        <div class="alert alert-danger">
                            {{ $errors->first('verify_link') }}
                        </div>
                    @endif--}}
                    @if(!empty(Session::get('verify_link')))
                        <div class="alert alert-danger">
                            {{ Session::get('verify_link') }}
                        </div>
                    @endif
                    <h3>Login</h3>
   <form class="form-group" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        
                        
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input id="email" type="email" class="input-text" name="email" value="{{Cookie::get('email')}}"  placeholder="Email Address" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>
                        
                         
                        
                        
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input id="password" type="password" class="input-text" value="{{Cookie::get('pass')}}" name="password" placeholder="Password" required>
                             @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>
                        
                        
                        <div class="checkbox">
                            <div class="ez-checkbox pull-left">
                                <label>
                              
                            
                                  <input type="checkbox" class="ez-hide" name="remember" @if (Cookie::get('remembered') == 'remembered') checked="checked" @endif > Remember Me
                             
                                 
                                    </label>
                            </div>
                            <a class="link-not-important pull-right" href="{{ route('password.request') }}">Forgot Password</a>
                            <div class="clearfix"></div>
                        </div>
                        
                        
                        
                        <div class="form-group">
                            <button type="submit" class="button-md button-theme btn-block">login</button>
                        </div>
                    </form>
                    <!-- Form end -->
                    
                                      
                    
                </div>
                <!-- Footer -->
                <div class="footer">
                    <span>
                        New to ShareAir? <a href="{!! url('/register'); !!}">Sign up now</a>
                    </span>
                </div>
            </div>
            <!-- Form content box end -->
        </div>
    </div>
</div>
@endsection


