@extends('layouts.without_header')
@section('title')
    Reset Password
@endsection
@section('content')
    <div class="page_loader"></div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Form content box start -->
                <div class="form-content-box">
                    <!-- details -->
                    <div class="details">
                        <!-- Logo -->
                        <a href="#">
                            <img src="{{URL::asset('img/black-logo.png')}}" class="cm-logo" alt="black-logo">
                        </a>
                        <!-- Name -->
                        <h3>Reset Password</h3>
                        <!-- Divider -->
                        <!-- Form start -->
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <form class="form-horizontal" method="POST" action="{{ route('password.request.final.step') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <input id="password" type="password" placeholder="Password" class="input-text" name="password">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <input id="password-confirm" type="password" placeholder="Confirm Password" class="input-text" name="password_confirmation" >
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            <div class="form-group">
                                <button type="submit" class="button-md button-theme btn-block"> Reset Password </button>
                            </div>
                        </form>
                        <!-- Form end -->
                    </div>
                    <!-- Footer -->

                </div>
                <!-- Form content box end -->
            </div>
        </div>
    </div>
@endsection
