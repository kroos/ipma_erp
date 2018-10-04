@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Leave Form</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

		<dl class="row">
			<dt class="col-sm-3"><h5 class="text-danger text-r">Perhatian :</h5></dt>
			<dd class="col-sm-9">
				<p class="lead">Permohonan Cuti Mestilah Sekurang-kurangnya <span class="font-weight-bold">TIGA (3)</span> Hari Lebih Awal dari Tarikh Bercuti Bagi "Annual Leave (Cuti Tahunan)" dan juga "Cuti Tanpa Gaji (Unpaid Leave)".</p>
				<p class="lead">Time-Off akan dikira sebagai <strong>Cuti</strong> sekiranya tempoh keluar <strong>Melebihi Dari 2jam</strong>.</p>
				<p class="lead">Permohonan Cuti Sakit (Medical Leave) atau Unpaid Medical Leave (MC-UPL) hanya akan dikira sah dan layak jika sijil sakit dikeluarkan oleh hospital/klinik kerajaan atau klinik panel yang <strong>BERDAFTAR</strong> sahaja.</p>
			</dd>
		</dl>

{!! Form::open(['route' => ['staffLeave.store'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true,  'data-toggle' => 'validator']) !!}
	@include('leave._form')
{{ Form::close() }}
		
	</div>
</div>
@endsection

@section('js')

<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// use for backup in append html and ajax.
$usergroup = \Auth::user()->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
$userloc = \Auth::user()->belongtostaff->location_id;
// echo $userloc.'<-- location_id<br />';
$userneedbackup = \Auth::user()->belongtostaff->leave_need_backup;

// this is the strategy
// 1. pull from their department
$lm = $usergroup->department_id;

// find all personnel from that department
$user = \App\Model\Staff::where('active', 1)->get();
foreach ($user as $ey) {
	echo $ey->belongtomanyposition()->wherePivot('main', 1)->get();
}


// BACKUP
// justify for those who doesnt have department
//	if( empty($usergroup->department_id) && $usergroup->category_id == 1 ) {
//		$rt = \App\Model\Position::where('division_id', $usergroup->division_id)->Where('group_id', '<>', 1)->where('category_id', $usergroup->category_id);
//	} else {
//		$rt = \App\Model\Position::where('department_id', $usergroup->department_id)->Where('group_id', '<>', 1)->where('category_id', $usergroup->category_id);
//	}
//	
//	foreach ($rt->get() as $key) {
//		// echo $key->position.' <-- position id<br />';
//		$ft = \App\Model\StaffPosition::where('position_id', $key->id)->get();
//		foreach($ft as $val) {
//			// must checking on same location, active user, almost same level.
//			if (\Auth::user()->belongtostaff->id != $val->belongtostaff->id && \Auth::user()->belongtostaff->location_id == $val->belongtostaff->location_id && $val->belongtostaff->active == 1 && $val->belongtostaff->leave_need_backup == 1 ) {
//				// echo $val->belongtostaff->name.' <-- name staff<br />';
//				$sel[$val->belongtostaff->id] = $val->belongtostaff->name;
//			}
//		}
//	}
//	if (empty($sel)) {
		$sel = array();
//	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// block holiday tgk dlm disable date in datetimepicker
$nodate = \App\Model\HolidayCalendar::orderBy('date_start')->get();
// block cuti sendiri
$nodate1 = \Auth::user()->belongtostaff->hasmanystaffleave()->where(['active' => 1, 'active' => 2])->whereRaw( '"'.date('Y').'" BETWEEN YEAR(date_time_start) AND YEAR(date_time_end)' )->get();
?>
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$('#leave_id').on('change', function() {
	$selection = $(this).find(':selected');
	// $('#opt_value').val($selection.val());
	// $('#opt_price').val($selection.data('price'));

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// annual leave
	if ($selection.val() == '1' || $selection.val() == '3') {

		$('#form').bootstrapValidator('removeField', $('.datetime').find('[name="date_time_start"]'));
		$('#form').bootstrapValidator('removeField', $('.datetime').find('[name="date_time_end"]'));
		$('#form').bootstrapValidator('removeField', $('.time').find('[name="time_start"]'));
		$('#form').bootstrapValidator('removeField', $('.time').find('[name="time_end"]'));
		$('#form').bootstrapValidator('removeField', $('.backup').find('[name="staff_id"]'));
		$('#form').bootstrapValidator('removeField', $('.supportdoc').find('[name="document"]'));
		$('#form').bootstrapValidator('removeField', $('.suppdoc').find('[name="documentsupport"]'));

		$('#remove').remove();
		$('#wrapper').append(

			'<div id="remove">' +
				<!-- annual leave -->

				'<div class="form-group row {{ $errors->has('date_time_start') ? 'has-error' : '' }}">' +
					'{{ Form::label('from', 'From : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10 datetime">' +
						'{{ Form::text('date_time_start', @$value, ['class' => 'form-control', 'id' => 'from', 'placeholder' => 'From : ', 'autocomplete' => 'off']) }}' +
					'</div>' +
				'</div>' +

				'<div class="form-group row {{ $errors->has('date_time_end') ? 'has-error' : '' }}">' +
					'{{ Form::label('to', 'To : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10 datetime">' +
						'{{ Form::text('date_time_end', @$value, ['class' => 'form-control', 'id' => 'to', 'placeholder' => 'To : ', 'autocomplete' => 'off']) }}' +
					'</div>' +
				'</div>' +

				'<div class="form-group row {{ $errors->has('leave_type') ? 'has-error' : '' }}" id="wrapperday">' +
					'{{ Form::label('leave_type', 'Jenis Cuti : ', ['class' => 'col-sm-2 col-form-label removehalfleave']) }}' +
					'<div class="col-sm-10 removehalfleave" id="halfleave">' +
						'<div class="pretty p-default p-curve form-check removehalfleave" id="removeleavehalf">' +
							'{{ Form::radio('leave_type', '1', true, ['id' => 'radio1', 'class' => ' removehalfleave']) }}' +
							'<div class="state p-success removehalfleave">' +
								'{{ Form::label('radio1', 'Cuti Penuh', ['class' => 'form-check-label removehalfleave']) }}' +
							'</div>' +
						'</div>' +
						'<div class="pretty p-default p-curve form-check removehalfleave" id="appendleavehalf">' +
							'{{ Form::radio('leave_type', '2', NULL, ['id' => 'radio2', 'class' => ' removehalfleave']) }}' +
							'<div class="state p-success removehalfleave">' +
								'{{ Form::label('radio2', 'Cuti Separuh', ['class' => 'form-check-label removehalfleave']) }}' +
							'</div>' +
						'</div>' +
					'</div>' +
					'<div class="form-group row col-sm-10 offset-sm-2 {{ $errors->has('leave_half') ? 'has-error' : '' }} removehalfleave"  id="wrappertest">' +
					'</div>' +
				'</div>' +

@if(( $usergroup->category_id == 1 && $usergroup->group_id != 1 || $usergroup->group_id == 5 && $usergroup->department_id != 10 || $usergroup->group_id == 6 && $usergroup->department != 10 ))
				'<div class="form-group row {{ $errors->has('staff_id') ? 'has-error' : '' }}">' +
					'{{ Form::label('backupperson', 'Backup Person : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10 backup">' +
						'{{ Form::select('staff_id', $sel, @$value, ['class' => 'form-control', 'id' => 'backupperson', 'placeholder' => 'Please Choose', 'autocomplete' => 'off']) }}' +
					'</div>' +
				'</div>' +
@endif
			'</div>'
			);
		/////////////////////////////////////////////////////////////////////////////////////////
		// add more option
		//add bootstrapvalidator
		$('#form').bootstrapValidator('addField', $('.datetime').find('[name="date_time_start"]'));
		$('#form').bootstrapValidator('addField', $('.datetime').find('[name="date_time_end"]'));
@if(( $usergroup->category_id == 1 && $usergroup->group_id != 1 || $usergroup->group_id == 5 && $usergroup->department_id != 10 || $usergroup->group_id == 6 && $usergroup->department != 10 ))
		$('#form').bootstrapValidator('addField', $('.backup').find('[name="staff_id"]'));
@endif

		/////////////////////////////////////////////////////////////////////////////////////////
		//enable select 2 for backup
		$('#backupperson').select2({
			placeholder: 'Please Choose',
			width: '100%',
		});
				//$.post("{{ route('workinghour.blockholidaysandleave') }}",
				//	{
				//		_token: '{{ csrf_token() }}'
				//	},
				//	function(response){
				//		var t = JSON.stringify(response);
				//		console.log(t);
				//		//var arr = [];
				//		//for(var i in t)
				//		//	arr.push(t[i]);
				//		//console.log(arr);
				//		//return arr;
				//	});

		/////////////////////////////////////////////////////////////////////////////////////////
		// enable datetime for the 1st one
		// $('#datetimepicker').data("DateTimePicker").OPTION()
		// $('#datetimepicker').data('DateTimePicker').daysOfWeekDisabled([1, 2]);
		$('#from').datetimepicker({
			format:'YYYY-MM-DD',
			// format:'LT',
			// viewMode: 'years',
			useCurrent: false,
			daysOfWeekDisabled: [0],
			minDate: moment().add(3, 'days').format('YYYY-MM-DD'),
			disabledDates: 
						//	function(){
						//		$.post("{{ route('workinghour.blockholidaysandleave') }}",
						//			{
						//				_token: '{{ csrf_token() }}'
						//			},
						//			function(response){
						//				var t = JSON.strigify(response);
						//				//console.log(t);
						//				var arr = [];
						//				for(var i in t)
						//					arr.push(t[i]);
						//				//console.log(arr);
						//				return arr;
						//			});
						//	},
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
		.on('dp.change dp.show dp.update', function(e) {
			$('#form').bootstrapValidator('revalidateField', 'date_time_start');
			var minDate = $('#from').val();
			$('#to').datetimepicker('minDate', minDate);
			if($('#from').val() === $('#to').val()) {
				if( $('.removehalfleave').length === 0) {
					$('#wrapperday').append(
							'{{ Form::label('leave_type', 'Jenis Cuti : ', ['class' => 'col-sm-2 col-form-label removehalfleave']) }}' +
							'<div class="col-sm-10 removehalfleave" id="halfleave">' +
								'<div class="pretty p-default p-curve form-check removehalfleave" id="removeleavehalf">' +
									'{{ Form::radio('leave_type', '1', true, ['id' => 'radio1', 'class' => ' removehalfleave']) }}' +
									'<div class="state p-success removehalfleave">' +
										'{{ Form::label('radio1', 'Cuti Penuh', ['class' => 'form-check-label removehalfleave']) }}' +
									'</div>' +
								'</div>' +
								'<div class="pretty p-default p-curve form-check removehalfleave" id="appendleavehalf">' +
									'{{ Form::radio('leave_type', '0', NULL, ['id' => 'radio2', 'class' => ' removehalfleave']) }}' +
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
			if($('#from').val() !== $('#to').val()) {
				$('.removehalfleave').remove();
			}
		});
		
		$('#to').datetimepicker({
			useCurrent: false,
			format:'YYYY-MM-DD',
			daysOfWeekDisabled: [0],
			minDate: moment().add(3, 'days').format('YYYY-MM-DD'),
			disabledDates:[
<?php
// block holiday tgk dlm disable date in datetimepicker
foreach ($nodate as $nda) {
	$period = \Carbon\CarbonPeriod::create($nda->date_start, '1 days', $nda->date_end);
	foreach ($period as $key) {
		echo 'moment("'.$key->format('Y-m-d').'"),';
	}
}
// block cuti sendiri
foreach ($nodate1 as $key) {
		// echo $key->date_time_start.' datetime start';
		// echo $key->date_time_end.' datetime end';
		$period1 = \Carbon\CarbonPeriod::create($key->date_time_start, '1 days', $key->date_time_end);
		foreach ($period1 as $key1) {
			echo 'moment("'.$key1->format('Y-m-d').'"),';
		}
	}
?>
							],
		})
		.on('dp.change dp.show dp.update', function(e) {
			$('#form').bootstrapValidator('revalidateField', 'date_time_end');
			var maxDate = $('#to').val();
			$('#from').datetimepicker('maxDate', maxDate);
			if($('#from').val() === $('#to').val()) {
				if( $('.removehalfleave').length === 0) {
					$('#wrapperday').append(
							'{{ Form::label('leave_type', 'Jenis Cuti : ', ['class' => 'col-sm-2 col-form-label removehalfleave']) }}' +
							'<div class="col-sm-10 removehalfleave" id="halfleave">' +
								'<div class="pretty p-default p-curve form-check removehalfleave" id="removeleavehalf">' +
									'{{ Form::radio('leave_type', '1', true, ['id' => 'radio1', 'class' => ' removehalfleave']) }}' +
									'<div class="state p-success removehalfleave">' +
										'{{ Form::label('radio1', 'Cuti Penuh', ['class' => 'form-check-label removehalfleave']) }}' +
									'</div>' +
								'</div>' +
								'<div class="pretty p-default p-curve form-check removehalfleave" id="appendleavehalf">' +
									'{{ Form::radio('leave_type', '0', NULL, ['id' => 'radio2', 'class' => ' removehalfleave']) }}' +
									'<div class="state p-success removehalfleave">' +
										'{{ Form::label('radio2', 'Cuti Separuh Hari', ['class' => 'form-check-label removehalfleave']) }}' +
									'</div>' +
								'</div>' +
							'</div>' +
							'<div class="form-group row col-sm-10 offset-sm-2 {{ $errors->has('leave_half') ? 'has-error' : '' }} removehalfleave"  id="wrappertest">' +
							'</div>'
					);
				}
			}
			if($('#from').val() !== $('#to').val()) {
				$('.removehalfleave').remove();
			}
		});
		
		/////////////////////////////////////////////////////////////////////////////////////////
		// enable radio
		$(document).on('change', '#appendleavehalf :radio', function () {
			if (this.checked) {
				var daynow = moment($('#from').val(), 'YYYY-MM-DD').format('dddd');
				var datenow =$('#from').val();
		
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
				var obj = $.parseJSON( data1 );

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
		});
		
		/////////////////////////////////////////////////////////////////////////////////////////
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($selection.val() == '2') {

		$('#form').bootstrapValidator('removeField', $('.datetime').find('[name="date_time_start"]'));
		$('#form').bootstrapValidator('removeField', $('.datetime').find('[name="date_time_end"]'));
		$('#form').bootstrapValidator('removeField', $('.time').find('[name="time_start"]'));
		$('#form').bootstrapValidator('removeField', $('.time').find('[name="time_end"]'));
		$('#form').bootstrapValidator('removeField', $('.backup').find('[name="staff_id"]'));
		$('#form').bootstrapValidator('removeField', $('.supportdoc').find('[name="document"]'));
		$('#form').bootstrapValidator('removeField', $('.suppdoc').find('[name="documentsupport"]'));

		$('#remove').remove();
		$('#wrapper').append(
			'<div id="remove">' +
				<!-- mc leave -->
				'<div class="form-group row {{ $errors->has('date_time_start') ? 'has-error' : '' }}">' +
					'{{ Form::label('from', 'From : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10 datetime">' +
						'{{ Form::text('date_time_start', @$value, ['class' => 'form-control', 'id' => 'from', 'placeholder' => 'From : ', 'autocomplete' => 'off']) }}' +
					'</div>' +
				'</div>' +

				'<div class="form-group row {{ $errors->has('date_time_end') ? 'has-error' : '' }}">' +
					'{{ Form::label('to', 'To : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10 datetime">' +
						'{{ Form::text('date_time_end', @$value, ['class' => 'form-control', 'id' => 'to', 'placeholder' => 'To : ', 'autocomplete' => 'off']) }}' +
					'</div>' +
				'</div>' +


				'<div class="form-group row {{ $errors->has('document') ? 'has-error' : '' }}">' +
					'{{ Form::label( 'doc', 'Supporting Document : ', ['class' => 'col-sm-2 col-form-label'] ) }}' +
					'<div class="col-sm-10 supportdoc">' +
						'{{ Form::file( 'document', ['class' => 'form-control form-control-file', 'id' => 'doc', 'placeholder' => 'Supporting Document']) }}' +
					'</div>' +
				'</div>' +

				'<div class="form-group row {{ $errors->has('akuan') ? 'has-error' : '' }}">' +
					'{{ Form::label('suppdoc', 'Surat Sokongan : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10 form-check suppdoc">' +
						'{{ Form::checkbox('documentsupport', 1, @$value, ['class' => 'form-check-input bg-warning rounded', 'id' => 'suppdoc']) }}' +
						'<label for="suppdoc" class="form-check-label p-3 mb-2 bg-warning text-danger rounded">Sila Pastikan anda menghantar <strong>Surat Sokongan</strong> dalam tempoh <strong>3 Hari</strong> selepas tarikh cuti.</label>' +
					'</div>' +
				'</div>' +

			'</div>'
		);

		//add bootstrapvalidator
		$('#form').bootstrapValidator('addField', $('.datetime').find('[name="date_time_start"]'));
		$('#form').bootstrapValidator('addField', $('.datetime').find('[name="date_time_end"]'));
		$('#form').bootstrapValidator('addField', $('.supportdoc').find('[name="document"]'));
		$('#form').bootstrapValidator('addField', $('.suppdoc').find('[name="documentsupport"]'));

		/////////////////////////////////////////////////////////////////////////////////////////
		// enable datetime for the 1st one
		$('#from').datetimepicker({
			format:'YYYY-MM-DD',
			useCurrent: false,
			daysOfWeekDisabled: [0],
			disabledDates:[
<?php
// block holiday tgk dlm disable date in datetimepicker
foreach ($nodate as $nda) {
	$period = \Carbon\CarbonPeriod::create($nda->date_start, '1 days', $nda->date_end);
	foreach ($period as $key) {
		echo 'moment("'.$key->format('Y-m-d').'"),';
	}
}
// block cuti sendiri
foreach ($nodate1 as $key) {
		// echo $key->date_time_start.' datetime start';
		// echo $key->date_time_end.' datetime end';
		$period1 = \Carbon\CarbonPeriod::create($key->date_time_start, '1 days', $key->date_time_end);
		foreach ($period1 as $key1) {
			echo 'moment("'.$key1->format('Y-m-d').'"),';
		}
	}
?>
							],
		})
		.on('dp.change dp.show dp.update', function(e) {
			$('#form').bootstrapValidator('revalidateField', 'date_time_start');
			var minDate = $('#from').val();
			$('#to').datetimepicker('minDate', minDate);
		});
		
		$('#to').datetimepicker({
			useCurrent: false,
			format:'YYYY-MM-DD',
			useCurrent: false,
			daysOfWeekDisabled: [0],
			disabledDates:[
<?php
// block holiday tgk dlm disable date in datetimepicker
foreach ($nodate as $nda) {
	$period = \Carbon\CarbonPeriod::create($nda->date_start, '1 days', $nda->date_end);
	foreach ($period as $key) {
		echo 'moment("'.$key->format('Y-m-d').'"),';
	}
}
// block cuti sendiri
foreach ($nodate1 as $key) {
		// echo $key->date_time_start.' datetime start';
		// echo $key->date_time_end.' datetime end';
		$period1 = \Carbon\CarbonPeriod::create($key->date_time_start, '1 days', $key->date_time_end);
		foreach ($period1 as $key1) {
			echo 'moment("'.$key1->format('Y-m-d').'"),';
		}
	}
?>
							],
		})
		.on('dp.change dp.show dp.update', function(e) {
			$('#form').bootstrapValidator('revalidateField', 'date_time_end');
			var maxDate = $('#to').val();
			$('#from').datetimepicker('maxDate', maxDate);
		});

		/////////////////////////////////////////////////////////////////////////////////////////
	}

	// if ($selection.val() == '3') {
	// 	$('#remove').remove();
	// 	$('#wrapper').append(
	// 		'<div id="remove">' +
	// 			<!-- unpaid leave -->
	// 		'</div>'
	// 	);
	// }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($selection.val() == '4') {

		$('#form').bootstrapValidator('removeField', $('.datetime').find('[name="date_time_start"]'));
		$('#form').bootstrapValidator('removeField', $('.datetime').find('[name="date_time_end"]'));
		$('#form').bootstrapValidator('removeField', $('.time').find('[name="time_start"]'));
		$('#form').bootstrapValidator('removeField', $('.time').find('[name="time_end"]'));
		$('#form').bootstrapValidator('removeField', $('.backup').find('[name="staff_id"]'));
		$('#form').bootstrapValidator('removeField', $('.supportdoc').find('[name="document"]'));
		$('#form').bootstrapValidator('removeField', $('.suppdoc').find('[name="documentsupport"]'));

		$('#remove').remove();
		$('#wrapper').append(
			'<div id="remove">' +
				<!-- replacement leave -->
<?php
$oi = \Auth::user()->belongtostaff->hasmanystaffleavereplacement()->where('leave_balance', '<>', 0)->get();
?>
				'<div class="form-group row {{ $errors->has('staff_leave_replacement_id') ? 'has-error' : '' }}">' +
					'{{ Form::label('nrla', 'Please Choose Your Replacement Leave : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10 nrl">' +
						'<p>Total Non Replacement Leave = {{ $oi->sum('leave_balance') }} days</p>' +
						'<select name="staff_leave_replacement_id" id="nrla" class="form-control">' +
							'<option value="">Please select</option>' +
@foreach( $oi as $po )
							'<option value="{{ $po->id }}" data-nrlbalance="{{ $po->leave_balance }}">On ' + moment( '{{ $po->working_date }}', 'YYYY-MM-DD' ).format('ddd Do MMM YYYY') + ', your leave balance = {{ $po->leave_balance }} day</option>' +
@endforeach
						'</select>' +
					'</div>' +
				'</div>' +

				'<div class="form-group row {{ $errors->has('date_time_start') ? 'has-error' : '' }}">' +
					'{{ Form::label('from', 'From : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10 datetime">' +
						'{{ Form::text('date_time_start', @$value, ['class' => 'form-control', 'id' => 'from', 'placeholder' => 'From : ', 'autocomplete' => 'off']) }}' +
					'</div>' +
				'</div>' +
				'<div class="form-group row {{ $errors->has('date_time_end') ? 'has-error' : '' }}">' +
					'{{ Form::label('to', 'To : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10 datetime">' +
						'{{ Form::text('date_time_end', @$value, ['class' => 'form-control', 'id' => 'to', 'placeholder' => 'To : ', 'autocomplete' => 'off']) }}' +
					'</div>' +
				'</div>' +

				'<div class="form-group row {{ $errors->has('leave_type') ? 'has-error' : '' }}" id="wrapperday">' +
					'{{ Form::label('leave_type', 'Jenis Cuti : ', ['class' => 'col-sm-2 col-form-label removehalfleave']) }}' +
					'<div class="col-sm-10 removehalfleave" id="halfleave">' +
						'<div class="pretty p-default p-curve form-check removehalfleave" id="removeleavehalf">' +
							'{{ Form::radio('leave_type', '1', true, ['id' => 'radio1', 'class' => ' removehalfleave']) }}' +
							'<div class="state p-success removehalfleave">' +
								'{{ Form::label('radio1', 'Cuti Penuh', ['class' => 'form-check-label removehalfleave']) }}' +
							'</div>' +
						'</div>' +
						'<div class="pretty p-default p-curve form-check removehalfleave" id="appendleavehalf">' +
							'{{ Form::radio('leave_type', '2', NULL, ['id' => 'radio2', 'class' => ' removehalfleave']) }}' +
							'<div class="state p-success removehalfleave">' +
								'{{ Form::label('radio2', 'Cuti Separuh', ['class' => 'form-check-label removehalfleave']) }}' +
							'</div>' +
						'</div>' +
					'</div>' +
					'<div class="form-group row col-sm-10 offset-sm-2 {{ $errors->has('leave_half') ? 'has-error' : '' }} removehalfleave"  id="wrappertest">' +
					'</div>' +
				'</div>' +
			'</div>'
		);

		/////////////////////////////////////////////////////////////////////////////////////////
		// more option
		$('#form').bootstrapValidator('addField', $('.datetime').find('[name="date_time_start"]'));
		$('#form').bootstrapValidator('addField', $('.datetime').find('[name="date_time_end"]'));
		$('#form').bootstrapValidator('addField', $('.nrl').find('[name="staff_leave_replacement_id"]'));

		/////////////////////////////////////////////////////////////////////////////////////////
		// enable select2
		$('#nrla').select2({ placeholder: 'Please select', 	width: '100%',
		});

		/////////////////////////////////////////////////////////////////////////////////////////
		// enable datetime for the 1st one
		$('#from').datetimepicker({
			format:'YYYY-MM-DD',
			useCurrent: false,
			daysOfWeekDisabled: [0],
			disabledDates:[
<?php
// block holiday tgk dlm disable date in datetimepicker
foreach ($nodate as $nda) {
	$period = \Carbon\CarbonPeriod::create($nda->date_start, '1 days', $nda->date_end);
	foreach ($period as $key) {
		echo 'moment("'.$key->format('Y-m-d').'"),';
	}
}
// block cuti sendiri
foreach ($nodate1 as $key) {
		// echo $key->date_time_start.' datetime start';
		// echo $key->date_time_end.' datetime end';
		$period1 = \Carbon\CarbonPeriod::create($key->date_time_start, '1 days', $key->date_time_end);
		foreach ($period1 as $key1) {
			echo 'moment("'.$key1->format('Y-m-d').'"),';
		}
	}
?>
							],
		})
		.on('dp.change dp.show dp.update', function(e) {
			$('#form').bootstrapValidator('revalidateField', 'date_time_start');
			var minDate = $('#from').val();
			$('#to').datetimepicker('minDate', minDate);
			if($('#from').val() === $('#to').val()) {
				if( $('.removehalfleave').length === 0) {
					$('#wrapperday').append(
						'{{ Form::label('leave_type', 'Jenis Cuti : ', ['class' => 'col-sm-2 col-form-label removehalfleave']) }}' +
						'<div class="col-sm-10 removehalfleave" id="halfleave">' +
							'<div class="pretty p-default p-curve form-check removehalfleave" id="removeleavehalf">' +
								'{{ Form::radio('leave_type', '1', true, ['id' => 'radio1', 'class' => ' removehalfleave']) }}' +
								'<div class="state p-success removehalfleave">' +
									'{{ Form::label('radio1', 'Cuti Penuh', ['class' => 'form-check-label removehalfleave']) }}' +
								'</div>' +
							'</div>' +
							'<div class="pretty p-default p-curve form-check removehalfleave" id="appendleavehalf">' +
								'{{ Form::radio('leave_type', '0', NULL, ['id' => 'radio2', 'class' => ' removehalfleave']) }}' +
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
			if($('#from').val() !== $('#to').val()) {
				// $('.removehalfleave').remove();
				$('#to').val( $('#from').val() );
			}
		});
		
		$('#to').datetimepicker({
			useCurrent: false,
			format:'YYYY-MM-DD',
			daysOfWeekDisabled: [0],
			disabledDates:[
<?php
// block holiday tgk dlm disable date in datetimepicker
foreach ($nodate as $nda) {
	$period = \Carbon\CarbonPeriod::create($nda->date_start, '1 days', $nda->date_end);
	foreach ($period as $key) {
		echo 'moment("'.$key->format('Y-m-d').'"),';
	}
}
// block cuti sendiri
foreach ($nodate1 as $key) {
		// echo $key->date_time_start.' datetime start';
		// echo $key->date_time_end.' datetime end';
		$period1 = \Carbon\CarbonPeriod::create($key->date_time_start, '1 days', $key->date_time_end);
		foreach ($period1 as $key1) {
			echo 'moment("'.$key1->format('Y-m-d').'"),';
		}
	}
?>
							],
		})
		.on('dp.change dp.show dp.update', function(e) {
			$('#form').bootstrapValidator('revalidateField', 'date_time_end');
			var maxDate = $('#to').val();
			$('#from').datetimepicker('maxDate', maxDate);
			if($('#from').val() === $('#to').val()) {
				if( $('.removehalfleave').length === 0) {
					$('#wrapperday').append(
						'{{ Form::label('leave_type', 'Jenis Cuti : ', ['class' => 'col-sm-2 col-form-label removehalfleave']) }}' +
						'<div class="col-sm-10 removehalfleave" id="halfleave">' +
							'<div class="pretty p-default p-curve form-check removehalfleave" id="removeleavehalf">' +
								'{{ Form::radio('leave_type', '1', true, ['id' => 'radio1', 'class' => ' removehalfleave']) }}' +
								'<div class="state p-success removehalfleave">' +
									'{{ Form::label('radio1', 'Cuti Penuh', ['class' => 'form-check-label removehalfleave']) }}' +
								'</div>' +
							'</div>' +
							'<div class="pretty p-default p-curve form-check removehalfleave" id="appendleavehalf">' +
								'{{ Form::radio('leave_type', '0', NULL, ['id' => 'radio2', 'class' => ' removehalfleave']) }}' +
								'<div class="state p-success removehalfleave">' +
									'{{ Form::label('radio2', 'Cuti Separuh Hari', ['class' => 'form-check-label removehalfleave']) }}' +
								'</div>' +
							'</div>' +
						'</div>' +
						'<div class="form-group row col-sm-10 offset-sm-2 {{ $errors->has('leave_half') ? 'has-error' : '' }} removehalfleave"  id="wrappertest">' +
						'</div>'
					);
				}
			}
			if($('#from').val() !== $('#to').val()) {
				// $('.removehalfleave').remove();
				$('#from').val( $('#to').val() );
			}
		});
		
		/////////////////////////////////////////////////////////////////////////////////////////
		// enable radio
		$(document).on('change', '#appendleavehalf :radio', function () {
			if (this.checked) {
				var daynow = moment($('#from').val(), 'YYYY-MM-DD').format('dddd');
				var datenow =$('#from').val();
		
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
		
		//$(document).on('change', '#removeleavehalf :radio', function () {
		$('#removeleavehalf :radio').change(function() {
			if (this.checked) {

				// console.log( $('#nrla option:selected').data('nrlbalance') );
				if( $('#nrla option:selected').data('nrlbalance') == 0.5 ) {

					// especially for select 2, if no select2, remove change()
					$('#nrla option:selected').prop('selected', false).change();
					// $('#nrla').val('').change();
				}
				$('.removetest').remove();
			}
		});

		/////////////////////////////////////////////////////////////////////////////////////////
		// checking for half day click but select for 1 full day
		$('#nrla').change(function() {

			selectedOption = $('option:selected', this);

			$('#form').bootstrapValidator('revalidateField', 'staff_leave_replacement_id');

			var nrlbal = selectedOption.data('nrlbalance');

			if (nrlbal == 0.5) {
				$('#radio2').prop('checked', true);
				// checking so there is no double

				var daynow = moment($('#from').val(), 'YYYY-MM-DD').format('dddd');
				var datenow =$('#from').val();
		
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

			} else {
				if( nrlbal != 0.5 ) {
					$('#radio1').prop('checked', true);
					$('.removetest').remove();
				}
			}
		});

		/////////////////////////////////////////////////////////////////////////////////////////
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($selection.val() == '7') {

		$('#form').bootstrapValidator('removeField', $('.datetime').find('[name="date_time_start"]'));
		$('#form').bootstrapValidator('removeField', $('.datetime').find('[name="date_time_end"]'));
		$('#form').bootstrapValidator('removeField', $('.time').find('[name="time_start"]'));
		$('#form').bootstrapValidator('removeField', $('.time').find('[name="time_end"]'));
		$('#form').bootstrapValidator('removeField', $('.backup').find('[name="staff_id"]'));
		$('#form').bootstrapValidator('removeField', $('.supportdoc').find('[name="document"]'));
		$('#form').bootstrapValidator('removeField', $('.suppdoc').find('[name="documentsupport"]'));

		$('#remove').remove();
		$('#wrapper').append(
			'<div id="remove">' +
				<!-- maternity leave -->
				'<div class="form-group row {{ $errors->has('date_time_start') ? 'has-error' : '' }}">' +
					'{{ Form::label('from', 'From : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10 datetime">' +
						'{{ Form::text('date_time_start', @$value, ['class' => 'form-control', 'id' => 'from', 'placeholder' => 'From : ', 'autocomplete' => 'off']) }}' +
					'</div>' +
				'</div>' +

				'<div class="form-group row {{ $errors->has('date_time_end') ? 'has-error' : '' }}">' +
					'{{ Form::label('to', 'To : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10 datetime">' +
						'{{ Form::text('date_time_end', @$value, ['class' => 'form-control', 'id' => 'to', 'placeholder' => 'To : ', 'autocomplete' => 'off']) }}' +
					'</div>' +
				'</div>' +
@if(( $usergroup->category_id == 1 && $usergroup->group_id != 1 || $usergroup->group_id == 5 && $usergroup->department_id != 10 || $usergroup->group_id == 6 && $usergroup->department != 10 ))
				'<div class="form-group row {{ $errors->has('staff_id') ? 'has-error' : '' }}">' +
					'{{ Form::label('backupperson', 'Backup Person : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10 backup">' +
						'{{ Form::select('staff_id', $sel, NULL, ['class' => 'form-control', 'id' => 'backupperson', 'placeholder' => 'Please Choose', 'autocomplete' => 'off']) }}' +
					'</div>' +
				'</div>' +
@endif
			'</div>'
		);
		/////////////////////////////////////////////////////////////////////////////////////////
		// more option
		//add bootstrapvalidator
		$('#form').bootstrapValidator('addField', $('.datetime').find('[name="date_time_start"]'));
		$('#form').bootstrapValidator('addField', $('.datetime').find('[name="date_time_end"]'));
@if(( $usergroup->category_id == 1 && $usergroup->group_id != 1 || $usergroup->group_id == 5 && $usergroup->department_id != 10 || $usergroup->group_id == 6 && $usergroup->department != 10 ))
		$('#form').bootstrapValidator('addField', $('.backup').find('[name="staff_id"]'));
@endif

		/////////////////////////////////////////////////////////////////////////////////////////
		//enable select 2 for backup
		$('#backupperson').select2({
			placeholder: 'Please Choose',
			width: '100%',
		});

		/////////////////////////////////////////////////////////////////////////////////////////
		// enable datetime for the 1st one
		$('#from').datetimepicker({
			format:'YYYY-MM-DD',
			daysOfWeekDisabled: [0],
			disabledDates:[
<?php
// block holiday tgk dlm disable date in datetimepicker
foreach ($nodate as $nda) {
	$period = \Carbon\CarbonPeriod::create($nda->date_start, '1 days', $nda->date_end);
	foreach ($period as $key) {
		echo 'moment("'.$key->format('Y-m-d').'"),';
	}
}
// block cuti sendiri
foreach ($nodate1 as $key) {
		// echo $key->date_time_start.' datetime start';
		// echo $key->date_time_end.' datetime end';
		$period1 = \Carbon\CarbonPeriod::create($key->date_time_start, '1 days', $key->date_time_end);
		foreach ($period1 as $key1) {
			echo 'moment("'.$key1->format('Y-m-d').'"),';
		}
	}
?>
							],
		})
		.on('dp.change dp.show dp.update', function(e) {
			$('#form').bootstrapValidator('revalidateField', 'date_time_start');
			var minDate = $('#from').val();
			$('#to').datetimepicker('minDate', moment( minDate, 'YYYY-MM-DD').add(59, 'days').format('YYYY-MM-DD') );

			$('#to').val( moment( minDate, 'YYYY-MM-DD').add(59, 'days').format('YYYY-MM-DD') );
		});
		
		$('#to').datetimepicker({
			useCurrent: false,
			format:'YYYY-MM-DD',
			daysOfWeekDisabled: [0],
			disabledDates:[
<?php
// block holiday tgk dlm disable date in datetimepicker
foreach ($nodate as $nda) {
	$period = \Carbon\CarbonPeriod::create($nda->date_start, '1 days', $nda->date_end);
	foreach ($period as $key) {
		echo 'moment("'.$key->format('Y-m-d').'"),';
	}
}
// block cuti sendiri
foreach ($nodate1 as $key) {
		// echo $key->date_time_start.' datetime start';
		// echo $key->date_time_end.' datetime end';
		$period1 = \Carbon\CarbonPeriod::create($key->date_time_start, '1 days', $key->date_time_end);
		foreach ($period1 as $key1) {
			echo 'moment("'.$key1->format('Y-m-d').'"),';
		}
	}
?>
							],
		})
		.on('dp.change dp.show dp.update', function(e) {
			$('#form').bootstrapValidator('revalidateField', 'date_time_end');
			var maxDate = $('#to').val();

			$('#from').datetimepicker('maxDate', moment( maxDate, 'YYYY-MM-DD').subtract(59, 'days').format('YYYY-MM-DD'));
			$('#from').val( moment( maxDate, 'YYYY-MM-DD').subtract(59, 'days').format('YYYY-MM-DD') );
		});
		
		/////////////////////////////////////////////////////////////////////////////////////////
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($selection.val() == '8') {

		$('#form').bootstrapValidator('removeField', $('.datetime').find('[name="date_time_start"]'));
		$('#form').bootstrapValidator('removeField', $('.datetime').find('[name="date_time_end"]'));
		$('#form').bootstrapValidator('removeField', $('.time').find('[name="time_start"]'));
		$('#form').bootstrapValidator('removeField', $('.time').find('[name="time_end"]'));
		$('#form').bootstrapValidator('removeField', $('.backup').find('[name="staff_id"]'));
		$('#form').bootstrapValidator('removeField', $('.supportdoc').find('[name="document"]'));
		$('#form').bootstrapValidator('removeField', $('.suppdoc').find('[name="documentsupport"]'));

		$('#remove').remove();
		$('#wrapper').append(
			'<div id="remove">' +
				<!-- emergency leave -->

				'<div class="form-group row {{ $errors->has('date_time_start') ? 'has-error' : '' }}">' +
					'{{ Form::label('from', 'From : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10 datetime">' +
						'{{ Form::text('date_time_start', @$value, ['class' => 'form-control', 'id' => 'from', 'placeholder' => 'From : ', 'autocomplete' => 'off']) }}' +
					'</div>' +
				'</div>' +

				'<div class="form-group row {{ $errors->has('date_time_end') ? 'has-error' : '' }}">' +
					'{{ Form::label('to', 'To : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10 datetime">' +
						'{{ Form::text('date_time_end', @$value, ['class' => 'form-control', 'id' => 'to', 'placeholder' => 'To : ', 'autocomplete' => 'off']) }}' +
					'</div>' +
				'</div>' +

				'<div class="form-group row {{ $errors->has('leave_type') ? 'has-error' : '' }}" id="wrapperday">' +
					'{{ Form::label('leave_type', 'Jenis Cuti : ', ['class' => 'col-sm-2 col-form-label removehalfleave']) }}' +
					'<div class="col-sm-10 removehalfleave" id="halfleave">' +
						'<div class="pretty p-default p-curve form-check removehalfleave" id="removeleavehalf">' +
							'{{ Form::radio('leave_type', '1', true, ['id' => 'radio1', 'class' => ' removehalfleave']) }}' +
							'<div class="state p-success removehalfleave">' +
								'{{ Form::label('radio1', 'Cuti Penuh', ['class' => 'form-check-label removehalfleave']) }}' +
							'</div>' +
						'</div>' +
						'<div class="pretty p-default p-curve form-check removehalfleave" id="appendleavehalf">' +
							'{{ Form::radio('leave_type', '2', NULL, ['id' => 'radio2', 'class' => ' removehalfleave']) }}' +
							'<div class="state p-success removehalfleave">' +
								'{{ Form::label('radio2', 'Cuti Separuh', ['class' => 'form-check-label removehalfleave']) }}' +
							'</div>' +
						'</div>' +
					'</div>' +
					'<div class="form-group row col-sm-10 offset-sm-2 {{ $errors->has('leave_half') ? 'has-error' : '' }} removehalfleave"  id="wrappertest">' +
					'</div>' +

				'</div>' +
@if(( $usergroup->category_id == 1 && $usergroup->group_id != 1 || $usergroup->group_id == 5 && $usergroup->department_id != 10 || $usergroup->group_id == 6 && $usergroup->department != 10 ))
				'<div id="rembackup">' +
				'</div>' +
@endif

				'<div class="form-group row {{ $errors->has('document') ? 'has-error' : '' }}">' +
					'{{ Form::label( 'doc', 'Supporting Document : ', ['class' => 'col-sm-2 col-form-label'] ) }}' +
					'<div class="col-sm-10 supportdoc">' +
						'{{ Form::file( 'document', ['class' => 'form-control form-control-file', 'id' => 'doc', 'placeholder' => 'Supporting Document']) }}' +
					'</div>' +
				'</div>' +

				'<div class="form-group row {{ $errors->has('akuan') ? 'has-error' : '' }}">' +
					'{{ Form::label('suppdoc', 'Surat Sokongan : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10 form-check suppdoc">' +
						'{{ Form::checkbox('documentsupport', 1, @$value, ['class' => 'form-check-input bg-warning rounded', 'id' => 'suppdoc']) }}' +
						'<label for="suppdoc" class="form-check-label p-3 mb-2 bg-warning text-danger rounded">Sila Pastikan anda menghantar <strong>Surat Sokongan</strong> dalam tempoh <strong>3 Hari</strong> selepas tarikh cuti.</label>' +
					'</div>' +
				'</div>' +

			'</div>'
		);
		/////////////////////////////////////////////////////////////////////////////////////////
		//add bootstrapvalidator
		$('#form').bootstrapValidator('addField', $('.datetime').find('[name="date_time_start"]'));
		$('#form').bootstrapValidator('addField', $('.datetime').find('[name="date_time_end"]'));
		$('#form').bootstrapValidator('addField', $('.supportdoc').find('[name="document"]'));
		$('#form').bootstrapValidator('addField', $('.suppdoc').find('[name="documentsupport"]'));

		/////////////////////////////////////////////////////////////////////////////////////////
		//enable select 2 for backup
		$('#backupperson').select2({
			placeholder: 'Please Choose',
			width: '100%',
		});

		/////////////////////////////////////////////////////////////////////////////////////////
		// enable datetime for the 1st one
		$('#from').datetimepicker({
			format:'YYYY-MM-DD',
			daysOfWeekDisabled: [0],
			disabledDates:[
<?php
// block holiday tgk dlm disable date in datetimepicker
foreach ($nodate as $nda) {
	$period = \Carbon\CarbonPeriod::create($nda->date_start, '1 days', $nda->date_end);
	foreach ($period as $key) {
		echo 'moment("'.$key->format('Y-m-d').'"),';
	}
}
// block cuti sendiri
foreach ($nodate1 as $key) {
		// echo $key->date_time_start.' datetime start';
		// echo $key->date_time_end.' datetime end';
		$period1 = \Carbon\CarbonPeriod::create($key->date_time_start, '1 days', $key->date_time_end);
		foreach ($period1 as $key1) {
			echo 'moment("'.$key1->format('Y-m-d').'"),';
		}
	}
?>
							],
		})
		.on('dp.change dp.show dp.update', function(e) {
			$('#form').bootstrapValidator('revalidateField', 'date_time_start');
			var minDate = $('#from').val();
			$('#to').datetimepicker('minDate', minDate);
			if($('#from').val() === $('#to').val()) {
				if( $('.removehalfleave').length === 0) {
					$('#wrapperday').append(
						'{{ Form::label('leave_type', 'Jenis Cuti : ', ['class' => 'col-sm-2 col-form-label removehalfleave']) }}' +
						'<div class="col-sm-10 removehalfleave" id="halfleave">' +
							'<div class="pretty p-default p-curve form-check removehalfleave" id="removeleavehalf">' +
								'{{ Form::radio('leave_type', '1', true, ['id' => 'radio1', 'class' => ' removehalfleave']) }}' +
								'<div class="state p-success removehalfleave">' +
									'{{ Form::label('radio1', 'Cuti Penuh', ['class' => 'form-check-label removehalfleave']) }}' +
								'</div>' +
							'</div>' +
							'<div class="pretty p-default p-curve form-check removehalfleave" id="appendleavehalf">' +
								'{{ Form::radio('leave_type', '0', NULL, ['id' => 'radio2', 'class' => ' removehalfleave']) }}' +
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
			if( $('#from').val() !== $('#to').val() ) {
				$('.removehalfleave').remove();
			}

			// enable backup if date from is greater than today.
			//cari date now dulu

			if( $('#from').val() >= moment().add(1, 'days').format('YYYY-MM-DD') ) {

			// console.log( moment().add(1, 'days').format('YYYY-MM-DD') );
			// console.log($( '#rembackup').children().length + ' <= rembackup length' );

			if( $('#rembackup').children().length == 0 ) {
				$('#rembackup').append(
					'<div class="form-group row {{ $errors->has('staff_id') ? 'has-error' : '' }}">' +
						'{{ Form::label('backupperson', 'Backup Person : ', ['class' => 'col-sm-2 col-form-label']) }}' +
						'<div class="col-sm-10 backup">' +
							'{{ Form::select('staff_id', $sel, NULL, ['class' => 'form-control', 'id' => 'backupperson', 'placeholder' => 'Please Choose', 'autocomplete' => 'off']) }}' +
						'</div>' +
					'</div>'
				);
			}

@if(( $usergroup->category_id == 1 && $usergroup->group_id != 1 || $usergroup->group_id == 5 && $usergroup->department_id != 10 || $usergroup->group_id == 6 && $usergroup->department != 10 ))
				$('#form').bootstrapValidator('addField', $('.backup').find('[name="staff_id"]'));
@endif
				$('#backupperson').select2({ placeholder: 'Please Choose', width: '100%',
				});
			} else {
				$('#form').bootstrapValidator('removeField', $('.backup').find('[name="staff_id"]') );
				$('#rembackup').children().remove();
			}
		});
		
		$('#to').datetimepicker({
			useCurrent: false,
			format:'YYYY-MM-DD',
			daysOfWeekDisabled: [0],
			disabledDates:[
<?php
// block holiday tgk dlm disable date in datetimepicker
foreach ($nodate as $nda) {
	$period = \Carbon\CarbonPeriod::create($nda->date_start, '1 days', $nda->date_end);
	foreach ($period as $key) {
		echo 'moment("'.$key->format('Y-m-d').'"),';
	}
}
// block cuti sendiri
foreach ($nodate1 as $key) {
		// echo $key->date_time_start.' datetime start';
		// echo $key->date_time_end.' datetime end';
		$period1 = \Carbon\CarbonPeriod::create($key->date_time_start, '1 days', $key->date_time_end);
		foreach ($period1 as $key1) {
			echo 'moment("'.$key1->format('Y-m-d').'"),';
		}
	}
?>
							],
		})
		.on('dp.change dp.show dp.update', function(e) {
			$('#form').bootstrapValidator('revalidateField', 'date_time_end');
			var maxDate = $('#to').val();
			$('#from').datetimepicker('maxDate', maxDate);
			if($('#from').val() === $('#to').val()) {
				if( $('.removehalfleave').length === 0) {
					$('#wrapperday').append(
						'{{ Form::label('leave_type', 'Jenis Cuti : ', ['class' => 'col-sm-2 col-form-label removehalfleave']) }}' +
						'<div class="col-sm-10 removehalfleave" id="halfleave">' +
							'<div class="pretty p-default p-curve form-check removehalfleave" id="removeleavehalf">' +
								'{{ Form::radio('leave_type', '1', true, ['id' => 'radio1', 'class' => ' removehalfleave']) }}' +
								'<div class="state p-success removehalfleave">' +
									'{{ Form::label('radio1', 'Cuti Penuh', ['class' => 'form-check-label removehalfleave']) }}' +
								'</div>' +
							'</div>' +
							'<div class="pretty p-default p-curve form-check removehalfleave" id="appendleavehalf">' +
								'{{ Form::radio('leave_type', '0', NULL, ['id' => 'radio2', 'class' => ' removehalfleave']) }}' +
								'<div class="state p-success removehalfleave">' +
									'{{ Form::label('radio2', 'Cuti Separuh Hari', ['class' => 'form-check-label removehalfleave']) }}' +
								'</div>' +
							'</div>' +
						'</div>' +
						'<div class="form-group row col-sm-10 offset-sm-2 {{ $errors->has('leave_half') ? 'has-error' : '' }} removehalfleave"  id="wrappertest">' +
						'</div>'
					);
				}
			}
			if($('#from').val() !== $('#to').val()) {
				$('.removehalfleave').remove();
			}
		});
		
		/////////////////////////////////////////////////////////////////////////////////////////
		// enable radio
		$(document).on('change', '#appendleavehalf :radio', function () {
			if (this.checked) {
				var daynow = moment($('#from').val(), 'YYYY-MM-DD').format('dddd');
				var datenow =$('#from').val();
		
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
		});
		
		/////////////////////////////////////////////////////////////////////////////////////////

	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($selection.val() == '9') { // time off

		$('#form').bootstrapValidator('removeField', $('.datetime').find('[name="date_time_start"]'));
		$('#form').bootstrapValidator('removeField', $('.datetime').find('[name="date_time_end"]'));
		$('#form').bootstrapValidator('removeField', $('.time').find('[name="time_start"]'));
		$('#form').bootstrapValidator('removeField', $('.time').find('[name="time_end"]'));
		$('#form').bootstrapValidator('removeField', $('.backup').find('[name="staff_id"]'));
		$('#form').bootstrapValidator('removeField', $('.supportdoc').find('[name="document"]'));
		$('#form').bootstrapValidator('removeField', $('.suppdoc').find('[name="documentsupport"]'));

		$('#remove').remove();
		$('#wrapper').append(
			'<div id="remove">' +
				<!-- time off -->
				'<div class="form-group row {{ $errors->has('date_time_start') ? 'has-error' : '' }}">' +
					'{{ Form::label('from', 'Date : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10 datetime">' +
						'{{ Form::text('date_time_start', @$value, ['class' => 'form-control', 'id' => 'from', 'placeholder' => 'From : ', 'autocomplete' => 'off']) }}' +
					'</div>' +
				'</div>' +

				'<div class="form-group row {{ $errors->has('date_time_end') ? 'has-error' : '' }}">' +
					'{{ Form::label('to', 'Time : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10">' +
						'<div class="container">' +
							'<div class="row time">' +
									'{{ Form::text('time_start', @$value, ['class' => 'form-control col-6', 'id' => 'start', 'placeholder' => 'From : ', 'autocomplete' => 'off']) }}' +
									'{{ Form::text('time_end', @$value, ['class' => 'form-control col-6', 'id' => 'end', 'placeholder' => 'To : ', 'autocomplete' => 'off']) }}' +
							'</div>' +
						'</div>' +
					'</div>' +
				'</div>' +
@if(( $usergroup->category_id == 1 && $usergroup->group_id != 1 || $usergroup->group_id == 5 && $usergroup->department_id != 10 || $usergroup->group_id == 6 && $usergroup->department != 10 ))
				'<div class="form-group row {{ $errors->has('staff_id') ? 'has-error' : '' }}">' +
					'{{ Form::label('backupperson', 'Backup Person : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10 backup">' +
						'{{ Form::select('staff_id', $sel, NULL, ['class' => 'form-control', 'id' => 'backupperson', 'placeholder' => 'Please Choose', 'autocomplete' => 'off']) }}' +
					'</div>' +
				'</div>' +
@endif
				'<div class="form-group row {{ $errors->has('document') ? 'has-error' : '' }}">' +
					'{{ Form::label( 'doc', 'Supporting Document : ', ['class' => 'col-sm-2 col-form-label'] ) }}' +
					'<div class="col-sm-10 supportdoc">' +
						'{{ Form::file( 'document', ['class' => 'form-control form-control-file', 'id' => 'doc', 'placeholder' => 'Supporting Document']) }}' +
					'</div>' +
				'</div>' +

				'<div class="form-group row {{ $errors->has('akuan') ? 'has-error' : '' }}">' +
					'{{ Form::label('suppdoc', 'Surat Sokongan : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10 form-check suppdoc">' +
						'{{ Form::checkbox('documentsupport', 1, @$value, ['class' => 'form-check-input bg-warning rounded', 'id' => 'suppdoc']) }}' +
						'<label for="suppdoc" class="form-check-label p-3 mb-2 bg-warning text-danger rounded">Sila Pastikan anda menghantar <strong>Surat Sokongan</strong> dalam tempoh <strong>3 Hari</strong> selepas tarikh cuti.</label>' +
					'</div>' +
				'</div>' +

			'</div>'
		);
		/////////////////////////////////////////////////////////////////////////////////////////
		// more option
		//add bootstrapvalidator
		$('#form').bootstrapValidator('addField', $('.datetime').find('[name="date_time_start"]'));
		$('#form').bootstrapValidator('addField', $('.time').find('[name="time_start"]'));
		$('#form').bootstrapValidator('addField', $('.time').find('[name="time_end"]'));
		$('#form').bootstrapValidator('addField', $('.backup').find('[name="staff_id"]'));
		$('#form').bootstrapValidator('addField', $('.supportdoc').find('[name="document"]'));
		$('#form').bootstrapValidator('addField', $('.suppdoc').find('[name="documentsupport"]'));

		/////////////////////////////////////////////////////////////////////////////////////////
		//enable select 2 for backup
		$('#backupperson').select2({ placeholder: 'Please Choose', width: '100%' });

		/////////////////////////////////////////////////////////////////////////////////////////
		// enable datetime for the 1st one
		$('#from').datetimepicker({
			format:'YYYY-MM-DD',
			daysOfWeekDisabled: [0],
			disabledDates:[
<?php
// block holiday tgk dlm disable date in datetimepicker
foreach ($nodate as $nda) {
	$period = \Carbon\CarbonPeriod::create($nda->date_start, '1 days', $nda->date_end);
	foreach ($period as $key) {
		echo 'moment("'.$key->format('Y-m-d').'"),';
	}
}
// block cuti sendiri
foreach ($nodate1 as $key) {
		// echo $key->date_time_start.' datetime start';
		// echo $key->date_time_end.' datetime end';
		$period1 = \Carbon\CarbonPeriod::create($key->date_time_start, '1 days', $key->date_time_end);
		foreach ($period1 as $key1) {
			echo 'moment("'.$key1->format('Y-m-d').'"),';
		}
	}
?>
							],
		})
		.on('dp.change dp.show dp.update', function(e) {
			$('#form').bootstrapValidator('revalidateField', 'date_time_start');
		});

		/////////////////////////////////////////////////////////////////////////////////////////
		// time start
		$('#start').datetimepicker({
			format: 'h:mm A',
			enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
		})
		.on('dp.change dp.show dp.update', function(e){
			$('#form').bootstrapValidator('revalidateField', 'time_start');
		});

		$('#end').datetimepicker({
			format: 'h:mm A',
			enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
		})
		.on('dp.change dp.show dp.update', function(e){
			$('#form').bootstrapValidator('revalidateField', 'time_end');
		});

		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////
	}

	if ($selection.val() == '11') {

		$('#form').bootstrapValidator('removeField', $('.datetime').find('[name="date_time_start"]'));
		$('#form').bootstrapValidator('removeField', $('.datetime').find('[name="date_time_end"]'));
		$('#form').bootstrapValidator('removeField', $('.time').find('[name="time_start"]'));
		$('#form').bootstrapValidator('removeField', $('.time').find('[name="time_end"]'));
		$('#form').bootstrapValidator('removeField', $('.backup').find('[name="staff_id"]'));
		$('#form').bootstrapValidator('removeField', $('.supportdoc').find('[name="document"]'));
		$('#form').bootstrapValidator('removeField', $('.suppdoc').find('[name="documentsupport"]'));

		$('#remove').remove();
		$('#wrapper').append(
			'<div id="remove">' +
				<!-- mc leave -->
				'<div class="form-group row {{ $errors->has('date_time_start') ? 'has-error' : '' }}">' +
					'{{ Form::label('from', 'From : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10 datetime">' +
						'{{ Form::text('date_time_start', @$value, ['class' => 'form-control', 'id' => 'from', 'placeholder' => 'From : ', 'autocomplete' => 'off']) }}' +
					'</div>' +
				'</div>' +

				'<div class="form-group row {{ $errors->has('date_time_end') ? 'has-error' : '' }}">' +
					'{{ Form::label('to', 'To : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10 datetime">' +
						'{{ Form::text('date_time_end', @$value, ['class' => 'form-control', 'id' => 'to', 'placeholder' => 'To : ', 'autocomplete' => 'off']) }}' +
					'</div>' +
				'</div>' +


				'<div class="form-group row {{ $errors->has('document') ? 'has-error' : '' }}">' +
					'{{ Form::label( 'doc', 'Supporting Document : ', ['class' => 'col-sm-2 col-form-label'] ) }}' +
					'<div class="col-sm-10 supportdoc">' +
						'{{ Form::file( 'document', ['class' => 'form-control form-control-file', 'id' => 'doc', 'placeholder' => 'Supporting Document']) }}' +
					'</div>' +
				'</div>' +

				'<div class="form-group row {{ $errors->has('akuan') ? 'has-error' : '' }}">' +
					'{{ Form::label('suppdoc', 'Surat Sokongan : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10 form-check suppdoc">' +
						'{{ Form::checkbox('documentsupport', 1, @$value, ['class' => 'form-check-input bg-warning rounded', 'id' => 'suppdoc']) }}' +
						'<label for="suppdoc" class="form-check-label p-3 mb-2 bg-warning text-danger rounded">Sila Pastikan anda menghantar <strong>Surat Sokongan</strong> dalam tempoh <strong>3 Hari</strong> selepas tarikh cuti.</label>' +
					'</div>' +
				'</div>' +

			'</div>'
		);

		//add bootstrapvalidator
		$('#form').bootstrapValidator('addField', $('.datetime').find('[name="date_time_start"]'));
		$('#form').bootstrapValidator('addField', $('.datetime').find('[name="date_time_end"]'));
		$('#form').bootstrapValidator('addField', $('.supportdoc').find('[name="document"]'));
		$('#form').bootstrapValidator('addField', $('.suppdoc').find('[name="documentsupport"]'));

		/////////////////////////////////////////////////////////////////////////////////////////
		// enable datetime for the 1st one
		$('#from').datetimepicker({
			format:'YYYY-MM-DD',
			useCurrent: false,
			daysOfWeekDisabled: [0],
			disabledDates:[
<?php
// block holiday tgk dlm disable date in datetimepicker
foreach ($nodate as $nda) {
	$period = \Carbon\CarbonPeriod::create($nda->date_start, '1 days', $nda->date_end);
	foreach ($period as $key) {
		echo 'moment("'.$key->format('Y-m-d').'"),';
	}
}
// block cuti sendiri
foreach ($nodate1 as $key) {
		// echo $key->date_time_start.' datetime start';
		// echo $key->date_time_end.' datetime end';
		$period1 = \Carbon\CarbonPeriod::create($key->date_time_start, '1 days', $key->date_time_end);
		foreach ($period1 as $key1) {
			echo 'moment("'.$key1->format('Y-m-d').'"),';
		}
	}
?>
							],
		})
		.on('dp.change dp.show dp.update', function(e) {
			$('#form').bootstrapValidator('revalidateField', 'date_time_start');
			var minDate = $('#from').val();
			$('#to').datetimepicker('minDate', minDate);
		});
		
		$('#to').datetimepicker({
			useCurrent: false,
			format:'YYYY-MM-DD',
			useCurrent: false,
			daysOfWeekDisabled: [0],
			disabledDates:[
<?php
// block holiday tgk dlm disable date in datetimepicker
foreach ($nodate as $nda) {
	$period = \Carbon\CarbonPeriod::create($nda->date_start, '1 days', $nda->date_end);
	foreach ($period as $key) {
		echo 'moment("'.$key->format('Y-m-d').'"),';
	}
}
// block cuti sendiri
foreach ($nodate1 as $key) {
		// echo $key->date_time_start.' datetime start';
		// echo $key->date_time_end.' datetime end';
		$period1 = \Carbon\CarbonPeriod::create($key->date_time_start, '1 days', $key->date_time_end);
		foreach ($period1 as $key1) {
			echo 'moment("'.$key1->format('Y-m-d').'"),';
		}
	}
?>
							],
		})
		.on('dp.change dp.show dp.update', function(e) {
			$('#form').bootstrapValidator('revalidateField', 'date_time_end');
			var maxDate = $('#to').val();
			$('#from').datetimepicker('maxDate', maxDate);
		});

		/////////////////////////////////////////////////////////////////////////////////////////

	}

});
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$(document).on('keyup', '#reason', function () {
	tch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
//select2
$('#leave_id').select2({
	placeholder: 'Please choose',
	ajax: {
		url: '{{ route('workinghour.leaveType') }}',
		data: { '_token': '{!! csrf_token() !!}' },
		type: 'POST',
		dataType: 'json',
	},
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

/////////////////////////////////////////////////////////////////////////////////////////
//enable ckeditor
// its working, i just disable it
// $(document).ready(function() {
// 	var editor = CKEDITOR.replace( 'reason', {});
// 	// editor is object of your CKEDITOR
// 	editor.on('change',function(){
// 	     // console.log();
// 	    $('#form').bootstrapValidator('revalidateField', 'reason');
// 	});
// });
// with jquery adapter
// $('textarea#reason').ckeditor();

/////////////////////////////////////////////////////////////////////////////////////////
// validator
$(document).ready(function() {
	$('#form').bootstrapValidator({
		feedbackIcons: {
			valid: '',
			invalid: '',
			validating: ''
		},
		fields: {
			leave_id: {
				validators: {
					notEmpty: {
						message: 'Please choose'
					},
				}
			},
			date_time_start: {
				validators: {
					notEmpty : {
						message: 'Please insert date start'
					},
					date: {
						format: 'YYYY-MM-DD',
						message: 'The value is not a valid date. '
					},
				}
			},
			date_time_end: {
				validators: {
					notEmpty : {
						message: 'Please insert date end'
					},
					date: {
						format: 'YYYY-MM-DD',
						message: 'The value is not a valid date. '
					},
				}
			},
			reason: {
				validators: {
					notEmpty: {
						message: 'Please insert your reason'
					},
					callback: {
						message: 'The reason must be less than 200 characters long',
						callback: function(value, validator, $field) {
							var div  = $('<div/>').html(value).get(0),
							text = div.textContent || div.innerText;
							return text.length <= 200;
						},
					},
				}
			},
			staff_leave_replacement_id: {
			 	// group: '.nrl',
				validators: {
					notEmpty: {
						message: 'Please select 1 option',
					},
				}
			},
			staff_id: {
				validators: {
					notEmpty: {
						message: 'Please choose'
					}
				}
			},
			document: {
				validators: {
					file: {
						extension: 'jpeg,jpg,png,bmp,pdf,doc',											// no space
						type: 'image/jpeg,image/png,image/bmp,application/pdf,application/msword',		// no space
						maxSize: 2097152,	// 2048 * 1024,
						message: 'The selected file is not valid. Please use jpeg, jpg, png, bmp, pdf or doc and the file is below than 3MB. '
					},
				}
			},
			//container: '.suppdoc',
			documentsupport: {
				validators: {
					notEmpty: {
						message: 'Please click this as an aknowledgement.'
					},
				}
			},
			akuan: {
				validators: {
					notEmpty: {
						message: 'Please click this as an acknowledgement'
					}
				}
			},
			time_start: {
				validators: {
					notEmpty: {
						message: 'Please insert time',
					},
					regexp: {
						regexp: /^([1-5]|[8-9]|1[0-2]):([0-5][0-9])\s([A|P]M|[a|p]m)$/i,
						message: 'The value is not a valid time',
					}
				}
			},
			time_end: {
				validators: {
					notEmpty: {
						message: 'Please insert time',
					},
					regexp: {
						regexp: /^([1-5]|[8-9]|1[0-2]):([0-5][0-9])\s([A|P]M|[a|p]m)$/i,
						message: 'The value is not a valid time',
					}
				}
			},
		}
	})
	.find('[name="reason"]')
	// .ckeditor()
	// .editor
		.on('change', function() {
			// Revalidate the bio field
		$('#form').bootstrapValidator('revalidateField', 'reason');
		// console.log($('#reason').val());
	})
	;
});

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

