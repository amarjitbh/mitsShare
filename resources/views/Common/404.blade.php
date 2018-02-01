@extends('layouts.after_login')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <!-- Error404 content start -->
            <div class="error404-content">
                <h1>404</h1>
                <h2>Something is wrong</h2>
                <p>The page you are looking for was moved, removed, renamed or might never existed.</p>

                    <a href="{{route('home')}}" class="button-md button-theme">Go Home</a>

            </div>
            <!-- Error404 content end -->
        </div>
    </div>
</div>
    @endsection