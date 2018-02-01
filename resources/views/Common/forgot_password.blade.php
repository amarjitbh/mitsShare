@extends('layouts.without_header')

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
       <!--  <i class="fa fa-gear"></i> -->
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
                    <a href="#">
                        <img src="{{URL::asset('img/black-logo.png')}}" class="cm-logo" alt="black-logo">
                    </a>
                    <!-- Name -->
                    <h3>Forgot Password</h3>
                    <!-- Divider -->
                    <div class="divider">
                        <span class="or-text">OR</span>
                    </div>
                    <!-- Form start -->
                    <form action="#">
                        <div class="form-group">
                            <input type="text" name="email" class="input-text" placeholder="Email Address">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="button-md button-theme btn-block">Send Me Email</button>
                        </div>
                    </form>
                    <!-- Form end -->
                </div>
                <!-- Footer -->
                <div class="footer">
                    <span>
                       I want to <a href="{{route('login')}}">return to login</a>
                    </span>
                </div>
            </div>
            <!-- Form content box end -->
        </div>
    </div>
</div>
@endsection


