@extends('layouts.after_login')
@section('content')
	<style>
		.fc-day-number{
			width: 84%;
			display: inline-flex;
			height: 76px;
		}
		.disable-click-event {
			pointer-events: none;
		}
		.mits{

			background: #1ECA8D !important;
			color: #fff;
		}
		.booked{

			background: #FF8C00 !important;
		}
		.disabled {
			pointer-events: none;

			/* for "disabled" effect */
			opacity: 0.5;
			background: #CCC;
		}
		.date-color{
			color : #fff;
		}
		td.fc-other-month {
			visibility: hidden;
		}
		.select-style {
			border: 1px solid #ccc;
			width: 100%;
			overflow: hidden;
			height:40px;
			background: #fafafa url('{{URL::asset("img/drop-down-arrow .png")}}') no-repeat 97% 50%;
			-webkit-appearance:none;
			-moz-appearance:none;
			-ms-appearance: none;
			-o-appearance: none;
			appearance: none;
			background-size: 20px;
		}

		.select-style select {
			padding: 5px 8px;
			width: 130%;
			border: none;
			box-shadow: none;
			background: transparent;
			background-image: none;
			-webkit-appearance: none;
		}

		.select-style select:focus {
			outline: none;
		}
		.select-style option {

			padding: 10px;
			font-weight: bold;
			font-size: 12px;
			outline: none;
			border: 0px !important;
			color: #d20023;
			background-color: transparent !important;
			box-shadow: none !important;
			line-height: 1.42857143;
		}
	</style>
	<script type="text/javascript">
		var bookedDates = [];
		var dataAry = '{{$data}}';
		/*$('table td .fc-day-number').filter(function(){

		 alert($(this).attr('class'))
		 $('table td .fc-day-number').addClass('disable-click-event');
		 });*/
		var lastDateOfSelectedMonth = '{{$endDate}}';
		console.log(lastDateOfSelectedMonth);
		var bookedDatesArray = '{{$bookedDates}}';
		var propertyIsBlocked	= '{{$isBlocked}}';
		dataAry = JSON.parse(dataAry.replace(/&quot;/g,'"'));
		bookedDatesArray = JSON.parse(bookedDatesArray.replace(/&quot;/g,'"'));
		if(!$.isEmptyObject(bookedDatesArray)){

			$.each(bookedDatesArray ,function(index,value){

				bookedDates.push(value.start_date);
			})
		}
		var removedDates = [];
		var selectedSingleDates = [];
		var newSelectedDates = [];

		$(document).ajaxStart(function () {
			$('#loading').show();  // show loading indicator
		});
		$(document).ajaxStop(function() {
			$('#loading').hide();  // hide loading indicator
		});
		var dateStartDate = '{{!empty($startDate) ? $startDate : ''}}';console.log(dateStartDate);
		var AleradySelectedDate = '{{!empty($endDate) ? $endDate : ''}}';
		var selectedMonthDate = '{{!empty($endDate) ? $endDate : date('Y-m-d')}}';

		var default_date = (dateStartDate != '') ? new Date(dateStartDate) : new Date();
		default_date.setFullYear(default_date.getFullYear()+1);

		$(document).ready(function(){

			value = $('#max_days_notice').val();

			if(value == 90){

				months = 3;
			}else if(value == 180){

				months = 6;
			}else if(value == 270){

				months = 9;
			}else if(value == 365){

				months = 12;
			}else {

				months = 0;
			}
			var todayDate = '{{date('Y-m-d')}}';
			var d = new Date(todayDate);
			d.setMonth(d.getMonth() + months);

			selectedMonthDate = (AleradySelectedDate != '') ? AleradySelectedDate : moment(d).format('YYYY-MM-DD');
		});
		function getSelectedMonth(ths) {
			//alert('asdf');
			if(ths.value == 90){

				months = 3;
			}else if(ths.value == 180){

				months = 6;
			}else if(ths.value == 270){

				months = 9;
			}else if(ths.value == 365){

				months = 12;
			}else {

				months = 0;
			}
			removedDates = [];
			var todayDate = '{{date('Y-m-d')}}';
			var d = new Date(todayDate);
			d.setMonth(d.getMonth() + months);
			selectedMonthDate = moment(d).format('YYYY-MM-DD');
			dateStartDate = '{{date('Y-m-d')}}';
			dataAry = [];
			/*var now = new Date();
			 var lastDateOfSelectedMonth = now.setMonth(now.getMonth() + 1, 1);
			 alert(lastDateOfSelectedMonth);*/
			/*var date = new Date(year, month, day);
			 date.setMonth(date.getMonth() + months);
			 alert(date);*/
			var lastDateOfSelectedMonth = moment().add(months, 'month').subtract(1, 'day').format('YYYY-MM-DD');
		}
		var minDate = get_today_date();
		var maxDate = convert_date(default_date);
		var current_date = new Date();
		var firstDayOfCurrentMonth = new Date(current_date.getFullYear(), current_date.getMonth(), 1);
		var valid_start = convert_date(firstDayOfCurrentMonth);
		var valid_end = maxDate;
		function arr_diff(a1, a2) {
			for(var i=0; i < a2.length; i++) {
				removeArrayElement(a1, a2[i])
			}
		};

		function convert_date(newdate){

			var new_date = new Date(newdate);
			var dd = ("0" + (new_date.getDate())).slice(-2);
			var mm = ("0" + (new_date.getMonth() + 1)).slice(-2); //January is 0!
			var yyyy = new_date.getFullYear();
			var mydate = yyyy +"-" + mm + "-" + dd;
			return mydate;
		}



		function get_today_date(){

			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();
			var mydate = yyyy +"-" + mm + "-" + dd;
			return mydate;
		}


		function CheckArrValueExists(arr, arr_value){

			var elem_index = arr.indexOf(arr_value);
			if(elem_index !== -1){
				return true;
			} else {
				return false;
			}
		}


		function removeArrayElement(arr, arr_value){
			var elem_index = arr.indexOf(arr_value);
			if(elem_index !== -1){
				arr.splice(elem_index, 1);
			}
		}

		function getDaysInMonth(month, year) {
			// Since no month has fewer than 28 days
			var date = new Date(year, month, 1);
			var days = [];
			//console.log('month', month, 'date.getMonth()', date.getMonth())
			while (date.getMonth() === month) {
				days.push(new Date(date));
				date.setDate(date.getDate() + 1);
			}
			return days;
		}

		$(document).ready(function(){
			var disabled_dates = new Array();
			var enabled_dates = new Array();
			function isDate(dateArg) {
				var t = (dateArg instanceof Date) ? dateArg : (new Date(dateArg));
				return !isNaN(t.valueOf());
			}

			function isValidRange(minDate, maxDate) {
				return (new Date(minDate) <= new Date(maxDate));
			}

			function betweenDate(startDt, endDt) {
				var error = ((isDate(endDt)) && (isDate(startDt)) && isValidRange(startDt, endDt)) ? false : true;
				var between = [];
				if (error) console.log('error occured!!!... Please Enter Valid Dates');
				else {
					var currentDate = new Date(startDt),
							end = new Date(endDt);
					while (currentDate <= end) {
						between.push(convert_date(new Date(currentDate)));
						currentDate.setDate(currentDate.getDate() + 1);
					}
				}
				return between;
			}

			function printSuccessMsg(msg, refrencevar) {
				$(refrencevar).closest("div.panel-body").find("div.print-error-msg ul").removeClass('alert alert-danger');
				$(refrencevar).closest("div.panel-body").find("div.print-error-msg ul").addClass('alert alert-success');
				$(refrencevar).closest("div.panel-body").find("div.print-error-msg ul").html('');
				$(refrencevar).closest("div.panel-body").find("div.print-error-msg").css('display','block');
				$(refrencevar).closest("div.panel-body").find("div.print-error-msg ul").append('<li>'+msg+'</li>');
			}

			$("#update").click(function(e) {

				//var start = (!$.isEmptyObject() || dateStartDate != '') ? new Date(dateStartDate) : new Date(minDate);

				start = new Date(dateStartDate);
				end = new Date(selectedMonthDate);
				if(start == 'Invalid Date'){

					$.each(removedDates,function (ind,val){
						selectedSingleDates.push(new Date(val));
					});
					var maxDate=new Date(Math.max.apply(null,selectedSingleDates));
					var minDate=new Date(Math.min.apply(null,selectedSingleDates));
					start = moment(maxDate).format('YYYY-MM-DD');
					end = moment(minDate).format('YYYY-MM-DD');

					var between = removedDates;
				}else{

					var between = betweenDate(start, end);
					arr_diff(between, removedDates);
					console.log(newSelectedDates);
					between = between.concat(newSelectedDates);

				}
				e.preventDefault();
				var avalaibility_option = $("select#max_days_notice" ).val();
				var property_id = parseInt({{$propertyTypesId}});
				/*console.log('b > '+between);
				 console.log('R > '+removedDates);
				 return false;*/
				$.ajax({
					type:'POST',
					context: this,
					data:{"avalaibility_option":avalaibility_option,"property_id":property_id,"dates":between, "_token": "{{ csrf_token() }}"},
					dataType: 'JSON',
					url:"{{route('store.property.availaibility.data')}}",
					success: function(data) {
						if(data.success){

							window.location = '{{route('seller-properties')}}';
						}
						if(data.warning){

							window.location = '{{route('seller-properties')}}';
						}
					},
					error: function(data) {

						$('#errorClass').show();
					},
				});

			});


			$( "#max_days_notice" ).change(function() {
				var minDate = get_today_date();
				var days = parseInt($(this).val());
				var full_calendar_max_date_arr = minDate.split("-");
				full_calendar_max_date = new Date(full_calendar_max_date_arr[0], full_calendar_max_date_arr[1]-1, full_calendar_max_date_arr[2]);
				full_calendar_max_date.setDate(full_calendar_max_date.getDate() + days);
				var mymaxDate = convert_date(full_calendar_max_date);
				maxDate = mymaxDate;
				$('#calendar').fullCalendar('option', {
					minDate: minDate,
					maxDate: maxDate
				});
			});


			$block = 1;

			$(".block_dates").click(function(){
				var my_current_date = get_today_date();
				if($block == 1) {
					$(".fc-day-grid.fc-unselectable").find("td.fc-day").each(function(index, element) {
						if(!($(this).hasClass("fc-disabled-day"))) {
							$(this).addClass("fc-disabled-day");
							disabled_dates.push($(this).attr("data-date"));
							removeArrayElement(enabled_dates, $(this).attr("data-date"));
						}
					});
				}else if($block == 0){
					my_str_current_date = my_current_date.toString();
					var full_cal_current_date = my_current_date.split("-");
					var full_calendar_current_date = new Date(full_cal_current_date[0], full_cal_current_date[1], full_cal_current_date[2]);
					$(".fc-day-grid.fc-unselectable").find("td.fc-day").each(function(index, element) {
						var current_element_date = $(this).attr("data-date");
						if(current_element_date) {
							current_element_date = current_element_date.toString();
							var full_cal_element_date = current_element_date.split("-");
							var current_element_date = new Date(full_cal_element_date[0], full_cal_element_date[1], full_cal_element_date[2]);
						}
						if($(this).attr("data-date")) {
							if(current_element_date > full_calendar_current_date) {
								if($(this).hasClass("fc-disabled-day")) {
									$(this).removeClass("fc-disabled-day");
									enabled_dates.push($(this).attr("data-date"));
									removeArrayElement(disabled_dates, $(this).attr("data-date"));
								}
							}
						}
					});
				}
				if($block== 1) {
					$(".block_dates").text("Unblock All Dates");
					$block= 0;
				}else if($block == 0){
					$(".block_dates").text("Block All Dates");
					$block= 1;
				}
			});

			function dateHasEvent(date) {

				var property_id = parseInt({{$propertyTypesId}});
				var data = '';
				$.ajax({
					url : '{{route('calendar.events')}}/'+property_id,
					type : 'get',
					dataType : 'json',
					success : function(result){
						date(result);
					}
				});
			}
			var a = 0;
			//console.log(dataAry);
			var todayDate = '{{date('Y-m-d')}}';
			$('#calendar').fullCalendar({

				header: {
					left: 'prev,next today',

					right: 'title'

				},
				navLinks: true,

				dayRender: function (date, cell , dt) {

					$(cell).filter(function () {

						var content = this;
						selectedMonthDateCheck = selectedMonthDate.replace('-','');
						selectedMonthDateCheck = selectedMonthDateCheck.replace('-','');
						LastDate = moment(date).format('YYYY-MM-DD').replace('-','');
						LastDate = LastDate.replace('-','');

						if(!$.isEmptyObject(dataAry)){
							$.each(dataAry, function (ind, val) {

								if (val.isBlocked == 0) {

									$(content).addClass(' fc-disabled-day');

								} else{

									if (val.success == '100') {
										if (val.start == moment(date).format('YYYY-MM-DD')) {

											if ($(content).attr('data-date') != 'undefined' && $(content).attr('data-date') == val.start && val.booked == 0) {

												$(content).addClass('mits');
												$('.fc-day-top').filter(function(){

													if($(this).attr('data-date') == val.start){
														$(this).find('a').addClass('date-color');
													}
												});
											} else if ($(content).attr('data-date') != 'undefined' && $(content).attr('data-date') == val.start && val.booked == 1) {

												$(content).addClass('booked');
											}
										} else if (moment(date).format('YYYY-MM-DD') != val.start) {

											LastDate = moment(date).format('YYYYMMDD');
											todayDate = todayDate.replace('-', '');
											todayDate = todayDate.replace('-', '');
											lastDateOfSelectedMonth = lastDateOfSelectedMonth.replace('-', '');
											lastDateOfSelectedMonth = lastDateOfSelectedMonth.replace('-', '');
											//console.log(LastDate+'>>'+todayDate+'last<<'+lastDateOfSelectedMonth+'...'+CheckArrValueExists(removedDates, moment(date).format('YYYY-MM-DD')));
											setTimeout(function () {
												if (CheckArrValueExists(removedDates, moment(date).format('YYYY-MM-DD')) == false
														&& moment(date).format('YYYYMMDD') > todayDate
														&& $(content).hasClass('mits') == false
														&& lastDateOfSelectedMonth > moment(date).format('YYYYMMDD')
												) {
													removedDates.push(moment(date).format('YYYY-MM-DD'));
													//console.log(removedDates);
												}
											}, 100);
										}
									} else {console.log(newSelectedDates);
										todayDate = todayDate.replace('-', '');
										todayDate = todayDate.replace('-', '');
										//if (LastDate >= todayDate && selectedMonthDateCheck >= LastDate && CheckArrValueExists(removedDates,moment(date).format('YYYY-MM-DD')) == true) {
										if (LastDate >= todayDate && CheckArrValueExists(newSelectedDates,moment(date).format('YYYY-MM-DD')) == true) {

											$(content).addClass('mits');
											$('.fc-day-top').filter(function(){
												fcDataDate = $(this).attr('data-date');
												fcDataDate2 = $(this).attr('data-date');
												fcDataDate = fcDataDate.replace('-', '');
												fcDataDate = fcDataDate.replace('-', '');

												if(fcDataDate >= todayDate && selectedMonthDateCheck >=fcDataDate && CheckArrValueExists(removedDates,fcDataDate2) == true){
													//alert($(this).find('a').html());
													$(this).find('a').addClass('date-color');
												}
											});
										}

									}
								}
							});
						}else {
							//console.log(moment(date).format('YYYY-MM-DD')+'=='+bookedDates);
							todayDate = todayDate.replace('-','');
							todayDate = todayDate.replace('-','');
							//alert(LastDate+'=='+todayDate+'<><>'+selectedMonthDateCheck);
							if(!$.isEmptyObject(bookedDates)){
								if(jQuery.inArray(moment(date).format('YYYY-MM-DD'), bookedDates) !== -1){

									$(content).addClass('booked');
								}

							}/*if(!$.isEmptyObject(newSelectedDates)){
								if(jQuery.inArray(moment(date).format('YYYY-MM-DD'), newSelectedDates) !== -1){

									$(content).addClass('mits');
								}

							}*/
							if(LastDate >= todayDate && selectedMonthDateCheck >= LastDate && CheckArrValueExists(removedDates,moment(date).format('YYYY-MM-DD')) == false){
								if($('#max_days_notice').val() != 0) {
									$(content).addClass('mits');
									$('.fc-day-top').filter(function () {
										fcDataDate = $(this).attr('data-date');
										fcDataDate2 = $(this).attr('data-date');
										fcDataDate = fcDataDate.replace('-', '');
										fcDataDate = fcDataDate.replace('-', '');

										if (fcDataDate >= todayDate && selectedMonthDateCheck >= fcDataDate && CheckArrValueExists(removedDates, fcDataDate2) == false) {
											//alert($(this).find('a').html());
											$(this).find('a').addClass('date-color');
										}
									});
								}
							}
						}
					});

					a++;
				},
				navLinkDayClick: function(date, jsEvent, view) {
					$('#warning').fadeOut('slow');
					var property_id = parseInt({{$propertyTypesId}});
					var mydata = null;

					$.ajax({
						url: '{{route('calendar.events.date')}}/' + property_id + '/' + moment(date).format('YYYY-MM') + '-' + $(jsEvent.target).html(),
						type: 'get',
						dataType: 'text',
						success: function (result) {
							mydata = result;
							mydata = JSON.parse(mydata);
							if(mydata.success == 100 && mydata.isBlocked !=0) {

								var mydate = $("#calendar").fullCalendar('getDate');
								var mymonth = moment(mydate).format('MM-YYYY');
								var current_clicked_date = moment(date).format('YYYY-MM-DD');
								if ((moment(current_clicked_date, "YYYY-MM-DD") >= moment(minDate, "YYYY-MM-DD")) && mydata.date == moment(date).format('YYYY-MM-DD') && mydata.is_booked == '0') {


									if($(jsEvent.target).hasClass('date-color') == false){
										$(jsEvent.target).addClass('date-color');
									}else{

										$(jsEvent.target).removeClass('date-color');
									}

									var todayDate = '{{date('Y-m-d')}}';
									var clickedDate = moment(date).format('YYYY-MM-DD');
									if(CheckArrValueExists(removedDates,clickedDate) == false) {

										removedDates.push(clickedDate);
									}else{

										removeArrayElement(removedDates, clickedDate);
									}
									v= 0;
									$(jsEvent.target).closest('div').prev().find('td').filter(function () {


										//console.log($(this).attr('data-date') + '==' + clickedDate);
										if ($(this).attr('data-date') == clickedDate) {
											$(this).toggleClass('mits');
										}
									});
								}else if(mydata.is_booked == '1'){

									$('#warning').fadeIn('slow');
								}


								if(CheckArrValueExists(newSelectedDates,clickedDate) == false && moment(date).format('YYYYMMDD') >= chktodayDate) {

									newSelectedDates.push(clickedDate);

									if(!$.isEmptyObject(dataAry[0])) {
										newObjectArray = {
											success: dataAry[0].success,
											"title": dataAry[0].title,
											"start": clickedDate,
											"start_date": dataAry[0].start_date,
											"last_date": dataAry[0].last_date,
											"booked": '0',
											"isBlocked": dataAry[0].isBlocked
										},

											console.log(newObjectArray);
												dataAry.push(newObjectArray);
									}
									//$(jsEvent.target).addClass('date-color');


								}else{

									//removeArrayElement(newSelectedDates, clickedDate);
									dataAry = dataAry.filter(function(el) {

										return el.start !== clickedDate;
									});
									//$(jsEvent.target).removeClass('date-color');

								}
								console.log(newSelectedDates);

							}else if(mydata.success == 0 && propertyIsBlocked != 0){

								var todayDate = '{{date('Y-m-d')}}';
								var chktodayDate = '{{date('Ymd')}}';
								var clickedDate = moment(date).format('YYYY-MM-DD');

								if(CheckArrValueExists(removedDates,clickedDate) == false) {

									//removedDates.push(clickedDate);
									//if($('#max_days_notice').val() == 0){

										//removeArrayElement(removedDates, clickedDate);
										removedDates.push(clickedDate);
									/*}else{

										removeArrayElement(removedDates, clickedDate);
									}*/

								}else{

									removeArrayElement(removedDates, clickedDate);
								}

								if($(jsEvent.target).hasClass('date-color') == false){
									$(jsEvent.target).addClass('date-color');
								}else{

									$(jsEvent.target).removeClass('date-color');
								}

								if(CheckArrValueExists(newSelectedDates,clickedDate) == false && moment(date).format('YYYYMMDD') >= chktodayDate) {

									newSelectedDates.push(clickedDate);

									if(!$.isEmptyObject(dataAry[0])) {

										newObjectArray = {
											success: dataAry[0].success,
											"title": dataAry[0].title,
											"start": clickedDate,
											"start_date": dataAry[0].start_date,
											"last_date": dataAry[0].last_date,
											"booked": '0',
											"isBlocked": dataAry[0].isBlocked
										},

											//console.log(newObjectArray);
												dataAry.push(newObjectArray);
									}

								}else{

									removeArrayElement(newSelectedDates, clickedDate);
									dataAry = dataAry.filter(function(el) {

										return el.start !== clickedDate;
									});
								}
								console.log(removedDates);
								v= 0;
								$(jsEvent.target).closest('div').prev().find('td').filter(function () {

									if ($(this).attr('data-date') == clickedDate && clickedDate >= todayDate) {

										$(this).toggleClass('mits');
									}
								});

							}else{

								var todayDate = '{{date('Y-m-d')}}';
								var clickedDate = moment(date).format('YYYY-MM-DD');

								if(CheckArrValueExists(removedDates,clickedDate) == false) {

									removedDates.push(clickedDate);


								}else{

									removeArrayElement(removedDates, clickedDate);
								}if(CheckArrValueExists(newSelectedDates,clickedDate) == false) {

									newSelectedDates.push(clickedDate);
									//$(jsEvent.target).addClass('date-color');


								}else{

									removeArrayElement(newSelectedDates, clickedDate);
									//$(jsEvent.target).removeClass('date-color');
								}
								v= 0;
								$(jsEvent.target).closest('div').prev().find('td').filter(function () {

									if ($(this).attr('data-date') == clickedDate && clickedDate >= todayDate) {
										//alert($(this).hasClass('mits'));
										if($(this).hasClass('mits') == true){
											$(this).removeClass('mits');
											$(jsEvent.target).removeClass('date-color');
										}else{
											$(this).addClass('mits');
											$(jsEvent.target).addClass('date-color');
										}

									}
								});
								console.log(removedDates);
							}
						}
					});
				},
				validRange: {
					start: valid_start,
					end: valid_end
				},
				fixedWeekCount: false,
				showNonCurrentDates: true,
			});
			function prependClass(sel, strClass) {
				var $el = jQuery(sel);
				/* prepend class */
				var classes = $el.attr('class');
				classes = strClass +' ' +classes;
				$el.attr('class', classes);
			}

			function checkMitsClass(){

				$('.mits').filter(function(){
					var mitsThis = this;
					$('.fc-day-top').filter(function(){
						if($(this).attr('data-date') == $(mitsThis).attr('data-date')){
							$(this).find('a').addClass('date-color');
						}
					});
				});
			}
			checkMitsClass();


			/*$('.block_dates').click(function(){
			 var property_id = parseInt({{$propertyTypesId}});
			 $.ajax({

			 url : '',
			 type : 'POST',
			 data : {'property_id' : property_id},
			 success : functio
			 });
			 });*/
		});
		$('#errorCloseButton').click(function(){

			$('#errorClass').hide();
		});

	</script>
	<div class="sub-banner">
		<div class="overlay">
			<div class="container">
				<div class="breadcrumb-area">
					<div class="top">
						<h1>Submit Property</h1>
					</div>
					<ul class="breadcrumbs">
						<li><a href="{{route('home')}}">Home</a></li>
						<li class="active">Submit Property</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="properties-section-body content-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-8 col-xs-12">
					<div class="properties-details-section mrg-btm-40">
						{{--Header Start--}}
						<div class="heading-properties clearfix">
							<div>
								<div class="submit-address">
									<h1>Property Availability
										@if($isBlocked == '0')
											<a href="{{route('block-unblock-dates',['id' => $propertyTypesId,'is_blocked' => 1])}}" class="block_dates button-sm button-theme pull-right" type="button">Unblock All dates</a>
										@else
											<a href="{{route('block-unblock-dates',['id' => $propertyTypesId,'is_blocked' => 0])}}" class="block_dates button-sm button-theme pull-right" type="button">Block All dates</a>
										@endif
									</h1>
								</div>
								<div class="alert alert-danger" id="errorClass" style="display:none">
									Please select dates
									<a href="javascript:void(0);" id="errorCloseButton" style="float : right">
										<i class="fa fa-times" aria-hidden="true"></i>
									</a>
								</div>
							</div>

						</div>
						{{--Header End--}}
						<div class="row">
							<div class="col-sm-12">

							</div>
							<div class="col-sm-12">
								<div class="print-error-msg" style="display:none">
									<ul></ul>
								</div>
							</div>



							<div class="col-sm-12">
								<div class="row">
									<div class="col-xs-4">

									</div>
								</div>

								<div class="row">
									<div class="col-sm-12">
										<div class="card-calendar">
											<div id='calendar'></div>
										</div>

									</div>
									<div class="col-sm-12">

										<div class="alert alert-warning" id="warning" style="display:none">
											sorry date are already booked.
										</div>

										<button class="btn button-md button-theme margin-top-40"  name="Update" id="update" value="Update" >Update</button>
									</div>
								</div>

								<div style="display: none" id="loading"><img style="width: 50px; height: 50px;" src="http://gifimage.net/wp-content/uploads/2017/08/spinner-gif-13.gif"></div>







							</div>
						</div>
					</div>


				</div>
				<div class="col-lg-4 col-md-4 col-xs-12">

					{{--Go back Start--}}
					<div class="print-section">
						<a href="{{route('property_information', ['property_type_id' => 'Select%20Property%20Type'])}}" class="widget-link"><i class="fa fa-chevron-left"></i>Go Back to Add Properties</a>
					</div>
					{{--Go back End--}}

					<div class="sidebar sidebar-widget">
						{{--Filter Section Start--}}
						<h3 class="title">Availability Options</h3>
						<form>
							<div class="form-group">
								@php
								$maxDaysNotice = \Config::get('constants.MAX_DAYS_NOTIES');
								{{--@pr($propertyAvailablityDates);--}}
								@endphp
								<select id="max_days_notice" onchange="getSelectedMonth(this)" name="max_days_notice" class="_4nlkxxs select-style ">
									{{--<option value="365">Any Time</option>--}}
									@foreach($maxDaysNotice as $key => $dayMAxNoties)
										<option {{ (!empty($propertyAvailablityDates[0]['avalaibility_option'])) ?   ($propertyAvailablityDates[0]['avalaibility_option'] == $key) ? "selected=selected"  : '' : ($key == 0) ?  "selected=selected" : ''}} value="{{$key}}">{{$dayMAxNoties}}</option>
										{{--<option value="90">3 months</option>
                                        <option value="180">6 months</option>
                                        <option value="270">9 months</option>
                                        <option value="365">1 year</option>
                                        <option value="0">Dates unavailable by default</option>--}}
									@endforeach
								</select>
							</div>


						</form>
						{{--Filter Section End--}}



					</div>
					<div class="sidebar sidebar-widget">
						@foreach($propertyData as $ind => $propertyDt)
							@if($propertyData[$ind]['fields'][0]['field_identifier'] == 'basic_name')
						{{--Property Info Start--}}
						<h3 class="title">
							Basic Details
						</h3>
						<div class="thumbnail recent-properties-box">
							@foreach($propertyDt['fields'] as $fields)
								@if($fields['field_identifier'] == 'basic_feature_image')
								<?php
									$imageData = json_decode($fields['field_value'],true);
								?>
									@foreach($imageData as $banner)
										@if($banner['chk'] == '1')
											<img src="{{URL::asset('images/'.$banner['image'])}}" alt="properties-5" class="img-responsive">
											<?php break; ?>
										@endif
									@endforeach
								@endif
							@endforeach
								<!-- Detail -->
							<div class="caption detail">
								<!-- Header -->
								<header class="clearfix">
									<div class="pull-left">
										<h1 class="title">

											@foreach($propertyDt['fields'] as $fields)
												@if($fields['field_identifier'] == 'basic_name')
													<a href="#">{{$fields['field_value']}}</a>
												@endif
											@endforeach
										</h1>
									</div>
									<!-- Price -->
									<div class="price">
										@foreach($propertyDt['fields'] as $fields)
											@if($fields['field_identifier'] == 'basic_price')
												{{'$'.$fields['field_value']}}
											@endif
										@endforeach
									</div>
								</header>
								<!-- Location -->
								<h3 class="location truncate-title">

									@foreach($propertyDt['fields'] as $fields)
										@if($fields['field_identifier'] == 'basic_location')
											<a href="javascript:void(0);">
												<i class="fa fa-map-marker"></i> {{$fields['field_value']}}
											</a>
										@endif
									@endforeach
								</h3>
								<!-- Facilities List -->
								{{--<ul class="facilities-list clearfix">
									<li class="bordered-right">
										<i class="flaticon-square-layouting-with-black-square-in-east-area"></i>
										<span>4800 sq ft</span>
									</li>
									<li>
										<i class="flaticon-bed"></i>
										<span>2 Bedroom</span>
									</li>
									<li>
										<i class="flaticon-monitor"></i>
										<span>1 TV Lounge</span>
									</li>
									<li>
										<i class="flaticon-holidays"></i>
										<span>3 Bathroom</span>
									</li>
									<li>
										<i class="flaticon-vehicle"></i>
										<span>1 Garage</span>
									</li>
									<li>
										<i class="flaticon-building"></i>
										<span> 3 Balcony</span>
									</li>
								</ul>--}}

							</div>
							<!-- Tag -->
                        {{--<span class="tag-f">
                                <a href="properties-details.html">Featured</a>
                            </span>
                        <span class="tag-s">
                                <a href="properties-details.html">For Sale</a>
                            </span>
						</div>--}}
							<?php break; ?>
							@endif
						@endforeach
						{{--Property Info End--}}

					</div>
				</div>

			</div>
		</div>
	</div>




@endsection