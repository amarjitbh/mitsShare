<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('Propertytype.home');
});*/

Route::any('sendEmail','HomeController@sendEmail')->name('sendEmail');
Auth::routes();
Route::get( 'verify-useremail', 'CommonController@verifyUserEmail')->name('verify.useremail');
Route::post( 'user-register', 'CommonController@userRegister')->name('user.register');
Route::post( 'save-property-reviews', 'CommonController@savePropertyReview')->name('save-property-reviews');
Route::get('all-reviews-of-property','CommonController@allReviewsOfProperty')->name('all-reviews-of-property');
Route::post('/reset-password', 'CommonController@resetPasswordByLink')->name('reset.password.custom');
Route::get( '/reset-password-view', 'CommonController@changePasswordView')->name('reset.password');
Route::post('/reset-password-final-step', 'CommonController@resetPasswordFinalStep')->name('password.request.final.step');

Route::get('test', function () {
	return view('test');
});
Route::any('testval', 'CommonController@testval')->name('testval');

Route::get('', function () {
	return view('design.property_detail');
});

Route::get('/design/property-detail', function () {
	return view('design.property_detail');
});

Route::get('/design/my-properties', function () {
	return view('design.my_properties');
});

//Buyer routes
Route::get('buyer/my-profile', 'BuyerController@myProfile')->name('buyer-profile');
Route::get('buyer/change-password','BuyerController@changePassword')->name('buyer-change-password');
Route::get('buyer/upcoming-booking','BuyerController@upcomingBooking')->name('buyer-upcoming-booking');
Route::get('buyer/past-booking','BuyerController@pastBooking')->name('buyer-past-booking');


// Common Routes

Route::get('common/property-details', 'CommonController@index')->name('property-details');
Route::get('common/forgot-password', 'CommonController@forgotPassword')->name('forgot-password');
Route::get('common/about-us', 'CommonController@aboutUs')->name('about-us');
Route::get('common/contact-us', 'CommonController@contactUs')->name('contact-us');
Route::get('common/404', 'CommonController@notFound404')->name('404');
Route::get('cronjob', 'CronjobController@index')->name('cronjob');
Route::get('not-approved-property', 'CronjobController@maiToNotAprovedProperty')->name('not.approved.property');
Route::get('not-approved-properties', 'CronjobController@maiToNotAprovedPropertySecond')->name('not.approved.properties');
Route::get('approved-property-cancel', 'CronjobController@approvedPropertyMail')->name('approved.property.cancel');


Route::get('/', 'PropertyController@index')->name('home');
Route::get('/search-result', 'PropertyController@propertyIndex')->name('search.result');
Route::get('/search-result-ajax', 'PropertyController@propertyIndexAjax')->name('search.result.ajax');
Route::any('/property-detail', 'PropertyController@propertyDetail')->name('property.detail');
Route::Post('/book-property/', 'PropertyController@bookProperty')->name('book.property');
Route::get('/success/{token}', 'PropertyController@approvedBooking')->name('success');
Route::get('/thanks', 'PropertyController@thanks')->name('thanks');
Route::get('/seller-properties-at-detail-page', 'PropertyController@sellerProperties')->name('seller-properties-at-detail-page');
Route::any('seller-profile/', 'Seller\SellerProperty@sellerprofile')->name('seller.profile');

Route::group(['middleware' => 'auth'], function() {
	Route::group(['middleware' => 'admin'], function()
	{
		Route::resource('propertytype', 'Admin\PropertyTypeController');
		Route::get('/change-password', 'Admin\AdminProfile@changePasswordView')->name('change-password-view');
		Route::post('/change-password', 'Admin\AdminProfile@ChangeAdminPassword')->name('change-password');
		Route::get('/PropertyTypeSectionField/create/{propertysectionid}/propertytype{propertypeid}', 'Admin\PropertyTypeSectionFieldController@create')->name('PropertyTypeSectionFieldCreate');
		Route::Post('/PropertyTypeSectionField/store/', 'Admin\PropertyTypeSectionFieldController@store')->middleware('web')->name('PropertyTypeSectionFieldStore');
		Route::get('PropertyTypeSectionField/destroyPropertySection/{id}', 'Admin\PropertyTypeSectionFieldController@destroyPropertySection')->name('PropertyTypeSectionDestroy');
		Route::get('PropertyTypeSectionField/destroyPropertyTypeSectionField/{id}', 'Admin\PropertyTypeSectionFieldController@destroyPropertyTypeSectionField')->name('PropertyTypeSectionFieldDestroy');
		Route::get('PropertyTypeSectionField/update/{id}', 'Admin\PropertyTypeSectionFieldController@update')->name('PropertyTypeSectionFieldUpdate');
		Route::get('PropertyTypeSectionField/singlefieldedit/{field_id}', 'PropertyTypeSectionFieldController@singlefieldedit')->name('PropertyTypeSectionFieldSinglefieldedit');
		Route::get('PropertyTypeSectionField/order/', 'Admin\PropertyTypeSectionFieldController@order')->name('PropertyTypeSectionFieldOrder');
		Route::post('checkSectionBeforeRemove/{id?}', 'Admin\PropertyTypeSectionFieldController@checkSectionBeforeRemove')->name('checkSectionBeforeRemove');
	});

	//Seller routes
	Route::group(['middleware' => 'seller'], function()
	{
		Route::get('seller/my-properties', 'Seller\SellerProperty@index')->name('seller-properties');
		Route::get('seller-property-detail','Seller\SellerProperty@propertyDetail')->name('seller-property-detail');

		Route::get('seller/my-profile', 'Seller\SellerProfile@myProfile')->name('seller-profile');
		Route::post('seller/edit-profile','Seller\SellerProfile@editProfile')->name('edit-profile');

		Route::get('seller/change-password-view','Seller\SellerProfile@changePasswordView')->name('seller-change-password-view');
		Route::post('seller/change-password','Seller\SellerProfile@changeSellerPassword')->name('change-seller-password');

		Route::get('seller/upcoming-properties','Seller\SellerProperty@upcomingProperties')->name('upcoming-properties');
		
		Route::get('seller/booked-upcoming-properties','Seller\SellerProperty@bookedUpcomingProperties')->name('booked-upcoming-properties');
		Route::get('seller/past-booking-properties','Seller\SellerProperty@pastBookingProperties')->name('past-booking-properties');
		Route::get('seller/booked-past-booking-properties','Seller\SellerProperty@bookedPastBookingProperties')->name('booked-past-booking-properties');
		
		/********************** Pending Booking **************/

		Route::get('seller/pending-approval-booking-properties','Seller\SellerProperty@bookedPendingBookingProperties')->name('pending-approval-booking-properties');
		Route::get('seller/pending-properties','Seller\SellerProperty@pendingProperties')->name('pending-properties');
		
		/********************** Pending Booking **************/

		Route::get('seller/rejected-approval-booking-properties','Seller\SellerProperty@bookedRejectedBookingProperties')->name('rejected-approval-booking-properties');
		Route::get('seller/approved-booking-properties/{id?}','Seller\SellerProperty@bookedApproveProperties')->name('approved-booking-properties');
		Route::get('seller/approved-properties','Seller\SellerProperty@approveProperties')->name('approved-properties');
		
		Route::get('seller/rejected-booking-properties','Seller\SellerProperty@rejectedBookingProperties')->name('rejected-booking-properties');
		
		Route::get('seller/cancel-booking/','Seller\SellerProperty@cancelBooking')->name('cancel-booking');
		Route::get('seller/cancel-booking/{id}','Seller\SellerProperty@cancelBooking')->name('cancel-booking');

		Route::get('seller/approve-booking/','Seller\SellerProperty@approveBooking')->name('approve-booking');
		Route::get('seller/approve-booking/{id}','Seller\SellerProperty@approveBooking')->name('approve-booking');


		Route::get('/property/information/{property_type_id?}', 'Seller\SellerProperty@propertyInformation')->name('property_information');
		Route::post('/property/information/store', 'Seller\SellerProperty@storePropertyTypeData')->name('store.property.type.data');
		Route::get('/property/availaibility/show/{propertyTypesId}', 'Seller\SellerProperty@showPropertyAvailability')->name('show.property.availaibility');
		Route::post('/property/availaibility/store', 'Seller\SellerProperty@storePropertyAvailabilityData')->name('store.property.availaibility.data');

		Route::match(['get', 'post'],'/property/index/{property_type_id?}', 'PropertyController@propertyIndex')->name('property.index');
		Route::get('/property/{property_id?}/edit', 'Seller\SellerProperty@propertyEdit')->name('property.edit');
		Route::post('/property/update', 'Seller\SellerProperty@propertyUpdate')->name('property.update');
		Route::any('calendar-events/{id?}', 'Seller\SellerProperty@getCalenderEvents')->name('calendar.events');
		Route::any('calendar-events-date/{id?}/{date?}', 'Seller\SellerProperty@getCalenderEventsDates')->name('calendar.events.date');
		Route::any('block-unblock-dates/{id?}{is_blocked}/', 'Seller\SellerProperty@blockunblockdates')->name('block-unblock-dates');
		Route::any('update-images', 'Seller\SellerProperty@updateImage')->name('update-images');
        Route::any('seller-detail/', 'Seller\SellerProperty@sellerDetail')->name('seller.detail');
		Route::any('buyer-detail', 'Seller\SellerProperty@buyerDetail')->name('buyer.detail');
		Route::get('seller/review-from-seller', 'Seller\SellerProperty@reviewFromSeller')->name('review-from-seller');



	});
});



//Route::get('PropertyTypeSectionField/singlefieldedit/{field_id}', 'PropertyTypeSectionFieldController@singlefieldedit')->name('PropertyTypeSectionFieldSinglefieldedit');
 
//Route::get('PropertyTypeSectionField/order/', 'PropertyTypeSectionFieldController@order')->name('PropertyTypeSectionFieldOrder');
//Route::get('PropertyTypeSectionField/order/', 'PropertyTypeSectionFieldController@order')->name('PropertyTypeSectionFieldOrder');

