@extends('layouts.after_login')

@section('content')

    {{--Change Password Page Start--}}
    <div class="change-password">
        <div class="container">
            <div class="row">

                   @include('seller/sidebar')


                <div class="col-lg-6 col-md-6 col-sm-5">
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
                        <form method="post" action="{{route('change-seller-password')}}">
                       {{ csrf_field() }}
                            <div class="form-group">
                                <label>Current Password</label>
                                <input type="password" class="input-text" name="old_password" placeholder="Current Password">
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" class="input-text" name="password" placeholder="New Password">
                            </div>
                            <div class="form-group">
                                <label>Confirm New Password</label>
                                <input type="password" class="input-text" name="password_confirmation" placeholder="Confirm New Password">
                            </div>
                            <button class="btn button-md button-theme">Save Changes</button>
                        </form>
                    </div>
                    <!-- My address end -->
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3">
                  
                    <div class="txat">
                        <p>Your password should be at least 12 random characters long to be safe</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--Change Password Page End--}}
@endsection