@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Human Resource Department</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

		<ul class="nav nav-tabs">
@foreach( App\Model\Division::find(1)->hasmanydepartment()->whereNotIn('id', [22, 23, 24])->get() as $key)
			<li class="nav-item">
				<a class="nav-link {{ ($key->id == 3)? 'active' : 'disabled' }}" href="{{ route("$key->route.index") }}">{{ $key->department }}</a>
			</li>
@endforeach
		</ul>

		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link " href="{{ route('hrSettings.index') }}">Settings</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('staffManagement.index') }}">Staff Management</a>
			</li>
			<li class="nav-item">
				<a class="nav-link active" href="{{ route('leaveEditing.index') }}">Leave</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('tcms.index') }}">TCMS</a>
			</li>
		</ul>

		<div class="card">
			<div class="card-header">Leaves Management</div>
			<div class="card-body">
				{{ Form::model($staffLeaveHR, ['route' => ['staffLeaveHR.update', $staffLeaveHR->id], 'method' => 'PATCH', 'id' => 'form', 'class' => 'form-horizontal', 'autocomplete' => 'off', 'files' => true]) }}
					@include('generalAndAdministrative.hr.leave.leavelist._form_editHR')
				{{ Form::close() }}
			</div>
		</div>

	</div>
</div>
@endsection

@section('js')
<?php
// block holiday tgk dlm disable date in datetimepicker
$nodate = \App\Model\HolidayCalendar::orderBy('date_start')->get();
// block cuti sendiri
$nodate1 = $staffLeaveHR->belongtostaff->hasmanystaffleave()->where('id', '<>', $staffLeaveHR->id)->where('active', 1)->orwhere('active', 2)->whereRaw( '"'.date('Y').'" BETWEEN YEAR(date_time_start) AND YEAR(date_time_end)' )->get();
?>
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$("#rem").keyup(function() {
	tch(this);
});
// console.log( $('input:radio[name=leave_type]:checked').val() );

/////////////////////////////////////////////////////////////////////////////////////////
// date time start
$('#dts').datetimepicker({
	format: 'YYYY-MM-DD',
	useCurrent: false,
	maxDate: $('#dte').val(),
			daysOfWeekDisabled: [0],
			disabledDates: 
					[
						<?php
						// block holiday tgk dlm disable date in datetimepicker
							foreach ($nodate as $nda) {
								$period = \Carbon\CarbonPeriod::create($nda->date_start, '1 days', $nda->date_end);
								foreach ($period as $key) {
									echo 'moment("'.$key->format('Y-m-d').'"),';
									// $holiday[] = $key->format('Y-m-d');
								}
							}
							// block cuti sendiri
							foreach ($nodate1 as $key) {
								$period1 = \Carbon\CarbonPeriod::create($key->date_time_start, '1 days', $key->date_time_end);
								foreach ($period1 as $key1) {
									echo 'moment("'.$key1->format('Y-m-d').'"),';
									// $holiday[] = $key1->format('Y-m-d');
								}
							}
						?>
					],
})
.on('dp.change dp.show dp.update', function(e){
	// remove before all the var been caught
	if( $('#dts').val() !== $('#dte').val() ) {
		$('.removehalfleave').remove();
	}

	$('#form').bootstrapValidator('revalidateField', 'date_time_start');

	var minDate = $('#dts').val();
	$('#dte').datetimepicker('minDate', minDate);

	// getting the period
	var data1 = $.ajax({
		url: "{{ route('workinghour.dts') }}",
		type: "POST",
		data: {
					dts: minDate,
					dte: $('#dte').val(),
					leave_type: $('input:radio[name=leave_type]:checked').val(),
					_token: '{!! csrf_token() !!}'
			},
		dataType: 'json',
		global: false,
		async:false,
		success: function (response) {
			// you will get response from your php page (what you echo or print)
			return response;
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	}).responseText;
	// convert data1 into json
	var obj = $.parseJSON( data1 );

	$('#per').val(obj.period);
	$('#perday').val(obj.period);
	update_period();
	// end of getting period

	// inserting half leave
	if($('#dts').val() === $('#dte').val()) {
		if( $('.removehalfleave').length === 0) {
			$('#wrapperday').append(
					'{{ Form::label('lt', 'Jenis Cuti : ', ['class' => 'col-sm-2 col-form-label removehalfleave']) }}' +
					'<div class="col-sm-10 removehalfleave" id="halfleave">' +
						'<div class="pretty p-default p-curve form-check removehalfleave" id="removeleavehalf">' +
							'<input type="radio" name="leave_type" value="1" class="removehalfleave" id="radio1" {{ ($staffLeaveHR->half_day != 2)?'checked="checked"':'' }} >' +
							'<div class="state p-success removehalfleave">' +
								'{{ Form::label('radio1', 'Cuti Penuh', ['class' => 'form-check-label removehalfleave']) }}' +
							'</div>' +
						'</div>' +
						'<div class="pretty p-default p-curve form-check removehalfleave" id="appendleavehalf">' +
							'<input type="radio" name="leave_type" value="2" class="removehalfleave" id="radio2" {{ ($staffLeaveHR->half_day == 2)?'checked="checked"':'' }} >' +
							'<div class="state p-success removehalfleave">' +
								'{{ Form::label('radio2', 'Cuti Separuh', ['class' => 'form-check-label removehalfleave']) }}' +
							'</div>' +
						'</div>' +
					'</div>' +
					'<div class="form-group row col-sm-10 offset-sm-2 {{ $errors->has('leave_half') ? 'has-error' : '' }} removehalfleave"  id="wrappertest">' +
					'</div>'
			);
		}
	}
});

/////////////////////////////////////////////////////////////////////////////////////////
// date time end
$('#dte').datetimepicker({
	format: 'YYYY-MM-DD',
	useCurrent: false,
	minDate: $('#dts').val(),
			daysOfWeekDisabled: [0],
			disabledDates: 
					[
						<?php
						// block holiday tgk dlm disable date in datetimepicker
							foreach ($nodate as $nda) {
								$period = \Carbon\CarbonPeriod::create($nda->date_start, '1 days', $nda->date_end);
								foreach ($period as $key) {
									echo 'moment("'.$key->format('Y-m-d').'"),';
									// $holiday[] = $key->format('Y-m-d');
								}
							}
							// block cuti sendiri
							foreach ($nodate1 as $key) {
								$period1 = \Carbon\CarbonPeriod::create($key->date_time_start, '1 days', $key->date_time_end);
								foreach ($period1 as $key1) {
									echo 'moment("'.$key1->format('Y-m-d').'"),';
									// $holiday[] = $key1->format('Y-m-d');
								}
							}
						?>
					],

})
.on('dp.change dp.show dp.update', function(e){
	// remove all the variables before been caught
	if($('#dts').val() !== $('#dte').val()) {
		$('.removehalfleave').remove();
	}

	$('#form').bootstrapValidator('revalidateField', 'date_time_end');

	var maxDate = $('#dte').val();
	$('#dts').datetimepicker('maxDate', maxDate);

	// getting the period
	var data1 = $.ajax({
		url: "{{ route('workinghour.dte') }}",
		type: "POST",
		data: {
					dts: $('#dts').val(),
					dte: maxDate,
					leave_type: $('input:radio[name=leave_type]:checked').val(),
					_token: '{!! csrf_token() !!}'
			},
		dataType: 'json',
		global: false,
		async:false,
		success: function (response) {
			// you will get response from your php page (what you echo or print)
			return response;
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	}).responseText;

	// convert data1 into json
	var obj = $.parseJSON( data1 );

	$('#per').val(obj.period);
	$('#perday').val(obj.period);
	update_period();
	// end of getting period

	// inserting half leave
	if($('#dts').val() === $('#dte').val()) {
		if( $('.removehalfleave').length === 0) {
			$('#wrapperday').append(
					'{{ Form::label('lt', 'Jenis Cuti : ', ['class' => 'col-sm-2 col-form-label removehalfleave']) }}' +
					'<div class="col-sm-10 removehalfleave" id="halfleave">' +
						'<div class="pretty p-default p-curve form-check removehalfleave" id="removeleavehalf">' +
							'<input type="radio" name="leave_type" value="1" class="removehalfleave" id="radio1" {{ ($staffLeaveHR->half_day != 2)?'checked="checked"':'' }} >' +
							'<div class="state p-success removehalfleave">' +
								'{{ Form::label('radio1', 'Cuti Penuh', ['class' => 'form-check-label removehalfleave']) }}' +
							'</div>' +
						'</div>' +
						'<div class="pretty p-default p-curve form-check removehalfleave" id="appendleavehalf">' +
							'<input type="radio" name="leave_type" value="2" class="removehalfleave" id="radio2" {{ ($staffLeaveHR->half_day == 2)?'checked="checked"':'' }} >' +
							'<div class="state p-success removehalfleave">' +
								'{{ Form::label('radio2', 'Cuti Separuh', ['class' => 'form-check-label removehalfleave']) }}' +
							'</div>' +
						'</div>' +
					'</div>' +
					'<div class="form-group row col-sm-10 offset-sm-2 {{ $errors->has('leave_half') ? 'has-error' : '' }} removehalfleave"  id="wrappertest">' +
					'</div>'
			);
		}
	}
});

/////////////////////////////////////////////////////////////////////////////////////////
// enable radio
// $(document).on('change', '#appendleavehalf :radio', function () {
$(document).on('change', '#wrapperday :radio', function () {
	if (this.checked) {
		var daynow = moment($('#from').val(), 'YYYY-MM-DD').format('dddd');
		var datenow =$('#dts').val();

		// get time start and end//
		var data1 = $.ajax({
			url: "{{ route('workinghour.workingtime') }}",
			type: "POST",
			data: {date: datenow, _token: '{!! csrf_token() !!}'},
			dataType: 'json',
			global: false,
			async:false,
			success: function (response) {
				// you will get response from your php page (what you echo or print)
				return response;
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(textStatus, errorThrown);
			}
		}).responseText;
		var obj = jQuery.parseJSON( data1 );
		// end get time //

		///////////////////////////////////////////////////////////////////////////////
		// get the period
		var data11 = $.ajax({
			url: "{{ route('workinghour.dte') }}",
			type: "POST",
			data: {
						dts: $('#dts').val(),
						dte: $('#dte').val(),
						leave_type: $('input:radio[name=leave_type]:checked').val(),
						_token: '{!! csrf_token() !!}'
				},
			dataType: 'json',
			global: false,
			async:false,
			success: function (response) {
				// you will get response from your php page (what you echo or print)
				return response;
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(textStatus, errorThrown);
			}
		}).responseText;
		var obj1 = $.parseJSON( data11 );

		$('#per').val(obj1.period);
		$('#perday').val(obj1.period);
		update_period();
		// end get the period

		// checking so there is no double
		if( $('.removetest').length == 0 ) {
			$('#wrappertest').append(
				'<div class="pretty p-default p-curve form-check removetest">' +
					'<input type="radio" name="leave_half" value="' + obj.start_am + '/' + obj.end_am + '" id="am" checked="checked">' +
					'<div class="state p-primary">' +
						'<label for="am" class="form-check-label">' + moment(obj.start_am, 'HH:mm:ss').format('h:mm a') + ' to ' + moment(obj.end_am, 'HH:mm:ss').format('h:mm a') + '</label> ' +
					'</div>' +
				'</div>' +
				'<div class="pretty p-default p-curve form-check removetest">' +
					'<input type="radio" name="leave_half" value="' + obj.start_pm + '/' + obj.end_pm + '" id="pm">' +
					'<div class="state p-primary">' +
						'<label for="pm" class="form-check-label">' + moment(obj.start_pm, 'HH:mm:ss').format('h:mm a') + ' to ' + moment(obj.end_pm, 'HH:mm:ss').format('h:mm a') + '</label> ' +
					'</div>' +
				'</div>'
			);
		}
	}
});

/////////////////////////////////////////////////////////////////////////////////////////
// checking on the changes of half day leave
$(document).on('change', '#removeleavehalf :radio', function () {
	if (this.checked) {
		$('.removetest').remove();
	}
		$('#per').val(1);
		$('#perday').val(1);
		update_period();
});

$(document).on('load change', '#radio2', function() {
	if(this.checked) {
		update_period();
	}
});

/////////////////////////////////////////////////////////////////////////////////////////
// time for half day
@if( $staffLeaveHR->leave_id != 9 )
	var daynow = moment($('#from').val(), 'YYYY-MM-DD').format('dddd');
	var datenow = $('#dts').val();
	var data1 = $.ajax({
		url: "{{ route('workinghour.workingtime') }}",
		type: "POST",
		data: {date: datenow, _token: '{!! csrf_token() !!}'},
		dataType: 'json',
		global: false,
		async:false,
		success: function (response) {
			// you will get response from your php page (what you echo or print)
			return response;
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	}).responseText;
	
	// convert data1 into json
	var obj = jQuery.parseJSON( data1 );
	
	$('#am').val( obj.start_am + '/' + obj.end_am );
	$('#pm').val( obj.start_pm + '/' + obj.end_pm );
	
	$('label.am1').text(moment(obj.start_am, 'HH:mm:ss').format('h:mm a') + ' to ' + moment(obj.end_am, 'HH:mm:ss').format('h:mm a'));
	$('label.pm1').text(moment(obj.start_pm, 'HH:mm:ss').format('h:mm a') + ' to ' + moment(obj.end_pm, 'HH:mm:ss').format('h:mm a'));
@endif

/////////////////////////////////////////////////////////////////////////////////////////
// function update the period after changes
// period initialize
function update_period() {

		// get the volatile period
		var per = $('#per').val();0.5
		console.log(per + ' => volatile period');

		// get the initialize balance
		var ibal = $('#albi').text();
		console.log(ibal + ' => initial balance');

		var iper = {{ $staffLeaveHR->period }};
		console.log(iper + ' => initial period');1

@if( $staffLeaveHR->leave_id == 1 || $staffLeaveHR->leave_id == 5 || $staffLeaveHR->leave_id == 2 || $staffLeaveHR->leave_id == 7 || $staffLeaveHR->leave_id == 4)

		var cbal = (ibal*1000 - ((per*1000) - (iper*1000)))/1000;	// for annual leave
		// console.log(cbal + ' => change balance');

		if( cbal < 0 ) {
			$('#albc').text(cbal.toFixed(1)).css({"color": "red", 'font-weight': 'bold'});
			$(':input[type="submit"]').prop('disabled', true);
			if( $('#danger1').length <= 0 ) {
				$('#danger').append(
					'<div class="alert alert-danger" id="danger1">' +
						'<h4 class="text-danger">Warning! Exceeding Balance Leave</h4>' +
						'<p>Please don\'t proceed with this value. Adjust your date so that the <b>Balance Change</b> is <b>GREEN</b>.</p>' +
					'</div>'
				);
				//		swal.fire({
				//			type: 'error',
				//			title: 'Warning! Exceeding Balance Leave',
				//			html: 'Please don\'t proceed with this value. Adjust your date so that the <b>Balance Change</b> is <b>GREEN</b>. Now, i\'ll refresh the page. Please wait.',
				//		})
				//		.then(function(){
				//			window.location.reload(true);
				//		});
			}

		} else if( cbal >= 0 ){
			$('#albc').text(cbal.toFixed(1)).css({"color": "green", 'font-weight': 'bold'});
			$('#balance').val(cbal.toFixed(1));
			$('#danger1').remove();
			$(':input[type="submit"]').prop('disabled', false);
		}
@endif
@if( $staffLeaveHR->leave_id == 3 || $staffLeaveHR->leave_id == 6 || $staffLeaveHR->leave_id == 11 )
		var cbalupl = (ibal*100 + (per*100 - iper*100))/100;	// for unpaid leave
		$('#albca').text( cbalupl ).css({"color": "green", 'font-weight': 'bold'});
		
@endif
@if( $staffLeaveHR->leave_id == 2 )

@endif
};

/////////////////////////////////////////////////////////////////////////////////////////
// date for tf
$('#dtstf').datetimepicker({
	format: 'YYYY-MM-DD',
	useCurrent: false,
	minDate: $('#dts').val(),
	daysOfWeekDisabled: [0],
	disabledDates: 
					[
						<?php
						// block holiday tgk dlm disable date in datetimepicker
							foreach ($nodate as $nda) {
								$period = \Carbon\CarbonPeriod::create($nda->date_start, '1 days', $nda->date_end);
								foreach ($period as $key) {
									echo 'moment("'.$key->format('Y-m-d').'"),';
									// $holiday[] = $key->format('Y-m-d');
								}
							}
							// block cuti sendiri
							foreach ($nodate1 as $key) {
								$period1 = \Carbon\CarbonPeriod::create($key->date_time_start, '1 days', $key->date_time_end);
								foreach ($period1 as $key1) {
									echo 'moment("'.$key1->format('Y-m-d').'"),';
									// $holiday[] = $key1->format('Y-m-d');
								}
							}
						?>
					],
})
.on('dp.change dp.show dp.update', function(e){});
;

// time start
$('#ts').datetimepicker({
	useCurrent: false,
	format: 'h:mm A',
	enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
})
.on('dp.change dp.show dp.update', function(e){
//	$('#form').bootstrapValidator('revalidateField', 'time_start');

	//		var startTime = $('#ts').val();
	//		var endTime = $('#te').val();
	//		var hours = moment.duration( moment( endTime, 'h:mm A' ).diff( moment(startTime, 'h:mm A') ) ).asMinutes();
	//		console.log(hours);

	var data2 = $.ajax({
		url: "{{ route('workinghour.tftimeperiod') }}",
		type: "POST",
		data: {
				date_time_start: $('#dtstf').val(),
				time_start: $('#ts').val(),
				time_end: $('#te').val(),
				_token: '{!! csrf_token() !!}'
			},
		dataType: 'json',
		global: false,
		async:false,
		success: function (response) {
			// you will get response from your php page (what you echo or print)
			return response;
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	}).responseText;
	
	// convert data1 into json
	var obj2 = jQuery.parseJSON( data2 );

	$('#per').val( obj2.hours );
	$('#perday').val( obj2.period );
});

$('#te').datetimepicker({
	useCurrent: false,
	format: 'h:mm A',
	enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
})
.on('dp.change dp.show dp.update', function(e){
//	$('#form').bootstrapValidator('revalidateField', 'time_end');

	//		var startTime = $('#ts').val();
	//		var endTime = $('#te').val();
	//		var hours = moment.duration( moment( endTime, 'h:mm A' ).diff( moment(startTime, 'h:mm A') ) ).asMinutes();
	//		console.log(hours);

	var data2 = $.ajax({
		url: "{{ route('workinghour.tftimeperiod') }}",
		type: "POST",
		data: {
				date_time_start: $('#dtstf').val(),
				time_start: $('#ts').val(),
				time_end: $('#te').val(),
				_token: '{!! csrf_token() !!}'
			},
		dataType: 'json',
		global: false,
		async:false,
		success: function (response) {
			// you will get response from your php page (what you echo or print)
			return response;
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	}).responseText;
	
	// convert data1 into json
	var obj2 = jQuery.parseJSON( data2 );

	$('#per').val( obj2.hours );
	$('#perday').val( obj2.period );
});


/////////////////////////////////////////////////////////////////////////////////////////
// bootstrap validator
$('#form').bootstrapValidator({
	feedbackIcons: {
		valid: '',
		invalid: '',
		validating: ''
	},
	fields: {
		date_time_start: {
			validators: {
				notEmpty: {
					message: 'Please choose user. '
				},
				date: {
					format: 'YYYY-MM-DD',
					message: 'Invalid date format. '
				}
			}
		},
		date_time_end: {
			validators: {
				notEmpty: {
					message: 'Please choose user. '
				},
				date: {
					format: 'YYYY-MM-DD',
					message: 'Invalid date format. '
				}
			}
		},
		period: {
			validators: {
				notEmpty: {
					message: 'Please insert a value. ',
				},
				digit: {
					message: 'Input is invalid. ',
				}
			}
		},
		remarks: {
			validators: {
				notEmpty: {
					message: 'Please insert remarks. '
				}
			}
		},
	}
})
	// .find('[name="reason"]')
	// .ckeditor()
	// .editor
	//	.on('change', function() {
	//		// Revalidate the bio field
	//	$('#form').bootstrapValidator('revalidateField', 'reason');
	//	// console.log($('#reason').val());
	//})
	//;

/////////////////////////////////////////////////////////////////////////////////////////
// remove half leave if date not equal
// date variables
var dts1 = $('#dts').val();
var dte1 = $('#dte').val();

if(dts1 != dte1) {
	$(".removehalfleave").remove();
}

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

