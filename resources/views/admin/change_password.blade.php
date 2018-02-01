@extends('layouts.after_login')

@section('content')

    {{--Change Password Page Start--}}
    <div class="change-password">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-3 col-lg-6 col-md-6 col-sm-5">
                    <!-- My address start -->
                    <div class="my-address">
                        <h1>Change Password</h1>
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
                        {!! Form::open(['url'=> route('change-password')]) !!}
                            <div class="form-group">
                                {{ Form::label('old_password', 'Current Password: ') }}
                                {{ Form::password('old_password',['class' => 'input-text','maxlength' => '30','placeholder'=>'Current Password']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('password', 'Current Password: ') }}
                                {{ Form::password('password',['class' => 'input-text','placeholder'=>'New Password']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('password_confirmation', 'Confirm New Password: ') }}
                                {{ Form::password('password_confirmation',['class' => 'input-text','placeholder'=>'Confirm New Password']) }}
                            </div>
                                {{Form::submit('Save Changes',['class'=>'btn button-md button-theme'])}}
                        {!! Form::close() !!}
                    </div>
                    <!-- My address end -->
                </div>

                {{--<div class="col-lg-3 col-md-3 col-sm-3">
                   
                    <div class="txat">
                        <p>Your password should be at least 12 random characters long to be safe</p>
                    </div>
                </div>--}}
            </div>
        </div>
    </div>

    {{--Change Password Page End--}}
@endsection