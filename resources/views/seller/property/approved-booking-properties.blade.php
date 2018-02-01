@extends('layouts.after_login')
@section('content')

   {{--My Properties Page Start--}}
   <div class="my-propertiess">
      <div class="container">
         <div class="row">
            @include('seller/sidebar')
            <div class="col-lg-9 col-md-9 col-sm-8">
               <!-- Heading -->
               <h1 class="heading">Confirmed Bookings</h1>
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
                              @if(!empty($jsonImages) && is_array($jsonImages))
                                 @foreach($jsonImages as $jsonImg)
                                    @if($jsonImg['chk']==1)
                                       @php $url_img = asset(config('constants.IMAGE_FOLDER_NAME').'/'.$jsonImg['image']); @endphp
                                    @endif
                                 @endforeach
                              @endif
                              <a href="{{route('seller-property-detail')}}?property_id={{$property['property_id']}}&commentType={{$commentType}}&bookingId={{$property['booking_id']}}">
                                 <div class="product-image-list-container" style="background-image: url('@if(isset($url_img)) {{$url_img}} @endif')"></div>
                              </a>
                           @else
                              <a href="{{route('seller-property-detail')}}?property_id={{$property['property_id']}}&commentType={{$commentType}}&bookingId={{$property['booking_id']}}">
                                 <div class="product-image-list-container" style="background-image: url('{{URL::asset('img/placeholder/placeholder-product.jpg')}}')"></div>
                              </a>
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
                                    <h3 class="location" >
                                       <a href="#" class="truncate-para" title="{{$property['basic_location']}}">
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
                              <div class="font-12 mb-0 truncate-para description_ckeditor"> @if(isset($property['basic_description'])) @php echo html_entity_decode($property['basic_description']) @endphp @else ''@endif </div>
                           </div>
                           <!-- footer -->
                           <div class="footer clearfix">
                              {{--Error Message--}}
                              <?php
                              $count='';
                              if (isset($bookedDates[$property['property_id']])) {
                                 $booksDates = $bookedDates[$property['property_id']];
                                 $array= explode(",",$booksDates);
                                 $count=0;
                                 foreach ($array as $key => $value) {
                                    if (in_array($value, $property['upcoming_date'])) {
                                       $count++;
                                    }
                                 }
                              }

                              ?>

                              @php
                              $upcomingArr=$property['upcoming_date'];
                              $start_date = current($property['upcoming_date']);


                              @endphp
                              @php $current_date = date('Y-m-d H:i:s'); @endphp
                              @if( !$current_date < $start_date && $count > 0)
                                 <span class="d-block small font-12 text-danger mt-5 label label-danger" style="float: right; position: absolute; white-space: nowrap; font-weight: 400; top: -28px; right: 10px; padding: 4px 8px; font-size: 11px ! important;"><span class="fa fa-exclamation-circle"></span> Property not available on this date.</span>
                              @endif
                                 {{--Error Message End--}}
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
                                             
                                          <?php
                                          $count='';
                                          if (isset($bookedDates[$property['property_id']])) {
                                             $booksDates = $bookedDates[$property['property_id']];
                                             $array= explode(",",$booksDates);
                                             $count=0;
                                             foreach ($array as $key => $value) {
                                                if (in_array($value, $property['upcoming_date'])) {
                                                   $count++;
                                                   }
                                              }
                                            }
                                           
                                          ?>

                                             @php
                                             $upcomingArr=$property['upcoming_date'];
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
                                          @php $current_date = date('Y-m-d H:i:s'); @endphp
                                          @if( !$current_date < $start_date)
                                          <div class="btn-group btn-group-sm btn-group-action pull-right text-nowrap" role="group" aria-label="btn-group-action">
                                             <div class="btn-group text-nowrap no-float" role="group">
                                                           <a class="btn cancel-booking btn-sm btn-outline-action" style="margin-bottom: 0;"
                                                              data-url="{{route('cancel-booking', $property['booking_id'] )}}"
                                                              href="#" data-bookingId="{{$property['booking_id']}}"
                                                              data-propertyId="{{$property['property_id']}}"
                                                              data-startDate="{{$start_date}}"
                                                              data-endDate="{{$end_date}}">
                                                              <i class="fa fa-times-circle-o font-14 "></i>Cancel
                                                              Booking
                                                           </a>
                                             </div>

                                             @if($propertyOwnerId != $property['property_owner_id'])
                                                   @if(isset($property['payment_status']))
                                                      <div class="btn-group text-nowrap no-float" role="group">
                                                      <a class="btn btn-sm btn-outline-action" disabled="disabled">
                                                        <i class="fa fa-check"></i>   Booked 
                                                      </a>
                                                      </div>
                                                   @elseif($count > 0)
                                           <div class="btn-group text-nowrap no-float" role="group">
                                                      <a class="btn btn-sm btn-outline-action" disabled="disabled">
                                                        <i class="fa fa-check"></i> Booked
                                                      </a>
                                                      </div>
                                                      {{--<span class="d-block small font-12 text-danger mt-5 hide" style="float:right;">Property not available on this date.</span>--}}
                                                     

                                                   
                                                   @else  
                                                      <div class="btn-group no-float" role="group">
                                                         <a class="btn btn-sm btn-outline-action" href="{{route('property.detail')}}?property_id={{$property['property_id']}}&commentType={{$commentType}}&bookingId={{$property['booking_id']}}">
                                                            <i class="fa fa-check"></i> Book Now
                                                         </a>
                                                      </div>
                                                   @endif   
                                             @endif
                                          </div>
                                          @endif

                                       </div>
                                    </td>
                                 </tr>
                              </table>



                           </div>
                        </div>
                     </div>
                  @endforeach
               @endif
             {{ !empty($allPropertiesData->links()) ? $allPropertiesData->links() : '' }}
            </div>
         </div>
      </div>
   </div>
   {{--My Properties Page End--}}
@endsection
@section('scripts')
<script src="{{ asset( 'js/toastr.min.js' ) }}"></script>
<script src="{{ asset( 'js/bootbox.min.js' ) }}"></script>
<script type="text/javascript">
   $(document).on("click", ".cancel-booking", function (e) {
      e.preventDefault();
      var propertiesbox= $(this).closest('.my-properties-box');
      var startDate = $(this).data('startdate');
      var endDate = $(this).data('enddate');
      var propertyId = $(this).data('propertyid');
      var bookingID = $(this).data('bookingid');
      var token ="{{csrf_token()}}";
      var url = $(this).data('url');
      bootbox.confirm({
         title: 'Cancel Booking',
         size: 'small',
         message: "Are you sure you want to cancel this booking ?",
         buttons: {
            confirm: {
               label: 'Yes',
               className: 'btn-success'
            },
            cancel: {
               label: 'No',
               className: 'btn-danger'
            }
         },
         callback: function (result) {
            if( result ){
               $.ajax({
                  url:url,
                  type: "get",
                  data: {startDate: startDate, endDate: endDate, bookingID:bookingID, propertyId: propertyId, _token:token },
                  success  : function(response) {

                     if( response.success == true ){
                        toastr.success('Booking is Cancelled Successfully.', {timeOut: 100})
                        bootbox.hideAll();
                        propertiesbox.slideUp('slow', function(){
                           propertiesbox.remove()
                        });
                        setTimeout(function(){
                        window.location.reload(1);
                        }, 3000);

                     }
                     else if( response.limitEexceed == 'yes' ){
                     toastr.error('According to policy you cannot cancel  booking .', 'Sorry!')

                     }
                     else{
                        toastr.error('Something Went wrong.', 'Sorry!')
                     }
                  },
               });
            }
         }
      });
   });


</script>
@endsection