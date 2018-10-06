@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Human Resource Department</h1></div>
	<div class="card-body">

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
$("#username").keyup(function() {
	uch(this);
});

<?php
if($staffLeaveHR->half_day == 1) {
	echo '$(".removehalfleave").remove();';
}
?>
/////////////////////////////////////////////////////////////////////////////////////////
// date time
$('#dts').datetimepicker({
	format: 'YYYY-MM-DD',
	useCurrent: false,
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

	var minDate = $('#dts').val();
	$('#dte').datetimepicker('minDate', minDate);

	var data1 = $.ajax({
		url: "{{ route('workinghour.dts') }}",
		type: "POST",
		data: {
					dts: minDate,
					dte: $('#dte').val(),
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
	if( $('#dts').val() !== $('#dte').val() ) {
		$('.removehalfleave').remove();
	}


});

$('#dte').datetimepicker({
	format: 'YYYY-MM-DD',
	useCurrent: false,
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

	var maxDate = $('#dte').val();
	$('#dts').datetimepicker('maxDate', maxDate);

	var data1 = $.ajax({
		url: "{{ route('workinghour.dte') }}",
		type: "POST",
		data: {
					dts: $('#dts').val(),
					dte: maxDate,
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
	if($('#dts').val() !== $('#dte').val()) {
		$('.removehalfleave').remove();
	}

});

/////////////////////////////////////////////////////////////////////////////////////////
// enable radio
$(document).on('change', '#appendleavehalf :radio', function () {
	if (this.checked) {
		var daynow = moment($('#from').val(), 'YYYY-MM-DD').format('dddd');
		var datenow =$('#dts').val();

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

		var data11 = $.ajax({
			url: "{{ route('workinghour.dte') }}",
			type: "POST",
			data: {
						dts: $('#dts').val(),
						dte: $('#dte').val(),
						leave_type: 2,
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
		var obj1 = $.parseJSON( data11 );

		$('#per').val(obj1.period);
		$('#perday').val(obj1.period);

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

$(document).on('change', '#removeleavehalf :radio', function () {
//$('#removeleavehalf :radio').change(function() {
	if (this.checked) {
		$('.removetest').remove();
	}
		$('#per').val(1);
		$('#perday').val(1);
});

/////////////////////////////////////////////////////////////////////////////////////////
		var daynow = moment($('#from').val(), 'YYYY-MM-DD').format('dddd');
		var datenow =$('#dts').val();
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

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

