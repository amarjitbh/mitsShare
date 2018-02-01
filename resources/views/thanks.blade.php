@extends('layouts.before_login_seller')
@section('content')
  
    <div class="properties-details-page">
        <div class="container">
            <div class="row">
               
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="properties-details-section">
                      @if (session('message'))
                        <h3><center>{{ session('message') }}</center></h3>
                        @else
                         <h3><center>Something went wrong.</center></h3>
                     @endif
                    </div>
                </div>
               
            </div>
        </div>
    </div>
 


@endsection
