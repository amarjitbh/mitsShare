@extends('layouts.without_header')
@section('title')
    Reset Password
@endsection
@section('content')
<div class="page_loader"></div>
<!-- Option Panel -->
<div class="option-panel option-panel-collased">
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
   <!--  <div class="setting-button">
        <i class="fa fa-gear"></i>
    </div> -->
</div>
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
                        <img src="{{ asset('/img/logo.png') }}" class="cm-logo" alt="black-logo">
                        
                    </a>
                    <!-- Name -->
                    <h3>Forgot Password</h3>
                    <!-- Divider -->
                   {{-- <div class="divider">
                        <span class="or-text">OR</span>
                    </div>--}}
                    
                    
                    
                    <!-- Form start -->
                    @if(session()->has('linkExists'))
                        <div class="alert alert-danger">
                            {{ session()->get('linkExists') }}
                        </div>
                    @endif
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('reset.password.custom') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input id="email" type="email" placeholder="Email Address" class="input-text" name="email" value="{{ old('email') }}" required>
                             @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="form-group">
							<button type="submit" class="button-md button-theme btn-block">
                                    Send Me Email
                                </button>
                        </div>
                    </form>
                    <!-- Form end -->
                </div>
                <!-- Footer -->
                <div class="footer">
                    <span>
					 I want to <a href='{!! url('/login'); !!}'>return to login</a>
                       </span>
                </div>
            </div>
            <!-- Form content box end -->
        </div>
    </div>
</div>
@endsection
 
 
