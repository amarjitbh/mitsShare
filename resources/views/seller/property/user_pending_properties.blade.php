@extends('layouts.after_login')
@section('content')

   {{--My Properties Page Start--}}
   <div class="my-propertiess">
      <div class="container">
         <div class="row">
            @include('seller/sidebar')
            <div class="col-lg-9 col-md-9 col-sm-8">
               <!-- Heading -->
               <h1 class="heading">Unconfirmed Bookings</h1>
               @if(session('message'))
                  <div class="alert alert-success">
                     {{ session('message') }}
                  </div>
               @endif
               @if(session('warning'))
                  <div class="alert alert-danger">
                     {{ session('warning') }}
                  </div>
               @endif
               @if(empty($propertyArr))
                  <p>Sorry No Properties Found</p>
               @endif

               @if(!empty($propertyArr))
               

                  @foreach($propertyArr as $property)

                     <div class="my-properties-box wow fadeInUp delay-03s clearfix d-flex row mlr-0 no-flex-sm" style="visibility: visible; animation-name: fadeInUp;">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-pad my-propertie-theme">
                           @if(isset($property['basic_feature_image']))
                              @php $jsonImages = json_decode($property['basic_feature_image'], true ); @endphp
                              @foreach($jsonImages as $jsonImg)
                                 @if($jsonImg['chk']==1)
                                    @php $url_img = asset(config('constants.IMAGE_FOLDER_NAME').'/'.$jsonImg['image']); @endphp
                                 @endif
                              @endforeach
                              <div class="product-image-list-container" style="background-image: url('@if(isset($url_img)) {{$url_img}} @endif')">

                              </div>
                           @else
                              <div class="product-image-list-container" style="background-image: url('{{URL::asset('img/placeholder/placeholder-product.jpg')}}')">

                              </div>
                           @endif
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 col-pad more-info">
                           <div class="detail">
                              <!-- Header -->
                              <header class="clearfix">
                                 <div class="pull-left mb-15">
                                    <h1 class="title">
                                       <a href="{{route('seller-property-detail')}}?property_id={{$property['property_id']}}&commentType={{$commentType}}&bookingId={{$property['booking_id']}}">{{$property['basic_name']}}</a>
                                    </h1>
                                    <h3 class="location">
                                       <a href="#" class="truncate-para">
                                          <i class="fa fa-map-marker"></i>{{$property['basic_location']}}
                                       </a>
                                    </h3>
                                 </div>
                                 <!-- Btn -->
                                 <div class="pull-right">
                                    <a href="{{route('seller-property-detail')}}?property_id={{$property['property_id']}}&commentType={{$commentType}}&bookingId={{$property['booking_id']}}" class="button-sm button-theme">Details</a>
                                 </div>
                              </header>
                              <hr class="mt-0">
                              <div class="font-12 mb-0 truncate-para description_ckeditor">@if(isset($property['basic_description'])) @php echo html_entity_decode($property['basic_description']) @endphp @else ''@endif</div>
                           </div>
                           <!-- footer -->
                           <div class="footer clearfix">
                              <table>
                                 <tr>
                                    <td width="1%" valign="top">
                                       <div class="wow slideInUp delay-02s" style="visibility: visible; animation-name: slideInUp;" data-wow-offset="0">
                                          <div class="text-muted font-11">Price</div>
                                          <div class="price">
                                             ${{$property['total_amount']}}
                                          </div>
                                       </div>
                                    </td>
                                    <td width="1%" valign="top">
                                           <div class="wow slideInUp delay-02s" style="visibility: visible; animation-name: slideInUp;" data-wow-offset="0">
                                               <div class="text-muted font-11">Booking Dates</div>
                                               <div class="date text-nowrap">
                                                   @php
                                                   $start_date = current($property['upcoming_date']);
                                                   echo date('M d, Y', strtotime($start_date));
                                                   echo " - ";
                                                   $end_date = end($property['upcoming_date']);
                                                   echo date('M d, Y', strtotime($end_date));
                                                   @endphp
                                               </div>
                                           </div>
                                       </td>
                                    <td width="1%" valign="top">
                                           <div class="wow slideInUp delay-02s" style="visibility: visible; animation-name: slideInUp;" data-wow-offset="0">
                                               <div class="text-muted font-11">@if(Auth::user()->id==$property['property_owner_id']) Buyer  @else  Seller @endif</div>
                                               <div class="date text-nowrap">
                                                   <a title="{{$property['first_name']}} {{$property['last_name']}}" class="truncate-title d-inline-block" style="max-width: 75%;" href="{{route('buyer.detail')}}?buyerId={{$property['buyerId']}}">{{$property['first_name']}} {{$property['last_name']}}</a>
                                               </div>
                                           </div>
                                       </td>
                                    <td width="1%" valign="top">
                                       <div class="listing-meta wow slideInUp delay-02s" style="visibility: visible; animation-name: slideInUp;" data-wow-offset="0">

                                          {{--<div class="btn-group btn-group-sm btn-group-action pull-right" role="group" aria-label="btn-group-action">
                                             @php $current_date = date("Y-m-d"); @endphp
                                             @if( $current_date < $start_date)
                                                <div class="btn-group" role="group">
                                                   <a class="btn cancel-booking btn-sm btn-outline-action"  data-url="{{route('cancel-booking', $property['booking_id'] )}}" href="#" data-bookingId="{{$property['booking_id']}}" data-propertyId="{{$property['property_id']}}" data-startDate= "{{$start_date}}" data-endDate="{{$end_date}}">
                                                      <i class="fa fa-times-circle-o font-14 "></i>Cancel Booking
                                                   </a>
                                                </div>
                                             @endif

                                          </div>--}}

                                       </div>
                                    </td>
                                 </tr>
                              </table>

                           </div>
                        </div>
                     </div>
                  @endforeach
               @endif
               {{ $allPropertiesData->links() }}
            </div>
         </div>
      </div>
   </div>
   {{--My Properties Page End--}}
@endsection
@section('scripts')
<script src="{{ asset( 'js/toastr.min.js' ) }}"></script>
<script src="{{ asset( 'js/bootbox.min.js' ) }}"></script>


@endsection