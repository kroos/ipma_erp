@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Leave Form</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

		<dl class="row">
			<dt class="col-sm-3"><h5 class="text-danger">Perhatian :</h5></dt>
			<dd class="col-sm-9">
				<p class="lead">Permohonan Cuti Mestilah Sekurang-kurangnya <span class="font-weight-bold">TIGA (3)</span> Hari Lebih Awal dari Tarikh Bercuti Bagi "Annual Leave (Cuti Tahunan)" dan juga "Cuti Tanpa Gaji (Unpaid Leave)".</p>
			</dd>
		</dl>

{!! Form::open(['route' => ['staffLeave.store'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) !!}
	@include('leave._form')
{{ Form::close() }}
		
	</div>
</div>
@endsection

@section('js')
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$('#leave_id').on('change', function() {
	$selection = $(this).find(':selected');
	// $('#opt_value').val($selection.val());
	// $('#opt_price').val($selection.data('price'));

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// annnual leave
	if ($selection.val() == '1' || $selection.val() == '3') {
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
<?php
$usergroup = \Auth::user()->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
$userloc = \Auth::user()->belongtostaff->location_id;
// echo $userloc.'<-- location_id<br />';

$userneedbackup = \Auth::user()->belongtostaff->leave_need_backup;

// justify for those who doesnt have department
if( empty($usergroup->department_id) && $usergroup->category_id == 1 ) {
	$rt = \App\Model\Position::where('division_id', $usergroup->division_id)->Where('group_id', '<>', 1)->where('category_id', $usergroup->category_id);
} else {
	$rt = \App\Model\Position::where('department_id', $usergroup->department_id)->Where('group_id', '<>', 1)->where('category_id', $usergroup->category_id);
}

foreach ($rt->get() as $key) {
	// echo $key->position.' <-- position id<br />';
	$ft = \App\Model\StaffPosition::where('position_id', $key->id)->get();
	foreach($ft as $val) {
		//must checking on same location, active user, almost same level.
		if (\Auth::user()->belongtostaff->id != $val->belongtostaff->id && \Auth::user()->belongtostaff->location_id == $val->belongtostaff->location_id && $val->belongtostaff->active == 1 ) {
			// echo $val->belongtostaff->name.' <-- name staff<br />';
			$sel[$val->belongtostaff->id] = $val->belongtostaff->name;
		}
	}
}
?>
@if( ($usergroup->category_id == 1 || $usergroup->group_id == 5 || $usergroup->group_id == 6) || $userneedbackup == 1 )
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
		// add more option
		//add bootstrapvalidator
		$('#form').bootstrapValidator('addField', $('.datetime').find('[name="date_time_start"]'));
		$('#form').bootstrapValidator('addField', $('.datetime').find('[name="date_time_end"]'));
@if( ($usergroup->category_id == 1 || $usergroup->group_id == 5 || $usergroup->group_id == 6) || $userneedbackup == 1 )
		$('#form').bootstrapValidator('addField', $('.backup').find('[name="staff_id"]'));
@endif

		/////////////////////////////////////////////////////////////////////////////////////////
		//enable select 2 for backup
		$('#backupperson').select2({
			placeholder: 'Please Choose'
		});

		/////////////////////////////////////////////////////////////////////////////////////////
		// enable datetime for the 1st one
		$('#from').datetimepicker({
			format:'YYYY-MM-DD',
			// format:'LT',
			// viewMode: 'years',
			// useCurrent: true,
			daysOfWeekDisabled: [0],
			minDate: moment().add(3, 'days').format('YYYY-MM-DD'),
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
			format:'YYYY-MM-DD',
			daysOfWeekDisabled: [0],
			minDate: moment().add(3, 'days').format('YYYY-MM-DD'),
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
							'<input type="radio" name="leave_half" value="1" id="am" checked="checked">' +
							'<div class="state p-primary">' +
								'<label for="am" class="form-check-label">' + moment(obj.start_am, 'HH:mm:ss').format('h:mm a') + ' to ' + moment(obj.end_am, 'HH:mm:ss').format('h:mm a') + '</label> ' +
							'</div>' +
						'</div>' +
						'<div class="pretty p-default p-curve form-check removetest">' +
							'<input type="radio" name="leave_half" value="0" id="pm">' +
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

			'</div>'
		);

		//add bootstrapvalidator
		$('#form').bootstrapValidator('addField', $('.datetime').find('[name="date_time_start"]'));
		$('#form').bootstrapValidator('addField', $('.datetime').find('[name="date_time_end"]'));
		$('#form').bootstrapValidator('addField', $('.supportdoc').find('[name="document"]'));

		/////////////////////////////////////////////////////////////////////////////////////////
		// enable datetime for the 1st one
		$('#from').datetimepicker({
			format:'YYYY-MM-DD',
			useCurrent: true,
			daysOfWeekDisabled: [0],
		})
		.on('dp.change dp.show dp.update', function(e) {
			$('#form').bootstrapValidator('revalidateField', 'date_time_start');
			var minDate = $('#from').val();
			$('#to').datetimepicker('minDate', minDate);
		});
		
		$('#to').datetimepicker({
			format:'YYYY-MM-DD',
			useCurrent: true,
			daysOfWeekDisabled: [0],
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
		$('#remove').remove();
		$('#wrapper').append(
			'<div id="remove">' +
				<!-- replacement leave -->
<?php
$oi = \Auth::user()->belongtostaff->hasmanystaffleavereplacement()->where('leave_balance', '<>', 0)->get();
?>
				'<div class="form-group row {{ $errors->has('staff_leave_replacement_id') ? 'has-error' : '' }}">' +
					'{{ Form::label('replacement_id', 'Please Choose Your Replacement Leave : ', ['class' => 'col-sm-2 col-form-label']) }}' +
					'<div class="col-sm-10 srli">' +
						'<p>Total Non Replacement Leave = {{ $oi->sum('leave_balance') }} days</p>' +
<?php
$i=0;
function my($string) {
	if (empty($string))	{
		$string = '1900-01-01';		
	}
	$rt = \Carbon\Carbon::createFromFormat('Y-m-d', $string);
	return date('D, d F Y', mktime(0, 0, 0, $rt->month, $rt->day, $rt->year));
}
?>
@foreach( $oi as $po )
<?php $i++; ?>
						'<div class="form-check nrl">' +
							'<input type="radio" name="staff_leave_replacement_id" value="{{ $po->id }}" id="{{ 'idslri'.$i }}" class="form-check-input" data-nrlbalance="{{ $po->leave_balance }}">' +
							'<label class="form-check-label" for="{{ 'idslri'.$i }}">{{ 'On '.my($po->date_leave).', your leave balance = '.$po->leave_balance }} day</label>' +
						'</div>' +
@endforeach
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
		// enable datetime for the 1st one
		$('#from').datetimepicker({
			format:'YYYY-MM-DD',
			// useCurrent: true,
			daysOfWeekDisabled: [0],
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
			format:'YYYY-MM-DD',
			daysOfWeekDisabled: [0],
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
		// checking for half day click but select for 1 full day
		$('input[type=radio][name=staff_leave_replacement_id]').change(function() {
			// console.log( $('input[type=radio][name=staff_leave_replacement_id]:checked').data('nrlbalance') );
			var nrlbal = $('input[type=radio][name=staff_leave_replacement_id]:checked').data('nrlbalance');

			if (nrlbal == 0.5) {
				$('#radio2').prop('checked', true);
				// checking so there is no double
				if( $('.removetest').length == 0 ) {
					$('#wrappertest').append(
						'<div class="pretty p-default p-curve form-check removetest">' +
							'<input type="radio" name="leave_half" value="1" id="am" checked="checked">' +
							'<div class="state p-primary">' +
								'<label for="am" class="form-check-label">' + moment(obj.start_am, 'HH:mm:ss').format('h:mm a') + ' to ' + moment(obj.end_am, 'HH:mm:ss').format('h:mm a') + '</label> ' +
							'</div>' +
						'</div>' +
						'<div class="pretty p-default p-curve form-check removetest">' +
							'<input type="radio" name="leave_half" value="0" id="pm">' +
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
							'<input type="radio" name="leave_half" value="1" id="am" checked="checked">' +
							'<div class="state p-primary">' +
								'<label for="am" class="form-check-label">' + moment(obj.start_am, 'HH:mm:ss').format('h:mm a') + ' to ' + moment(obj.end_am, 'HH:mm:ss').format('h:mm a') + '</label> ' +
							'</div>' +
						'</div>' +
						'<div class="pretty p-default p-curve form-check removetest">' +
							'<input type="radio" name="leave_half" value="0" id="pm">' +
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
				$('.removetest').remove();
			}
		});

		/////////////////////////////////////////////////////////////////////////////////////////
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($selection.val() == '7') {
		$('#remove').remove();
		$('#wrapper').append(
			'<div id="remove">' +
				<!-- maternity leave -->

			'</div>'
		);
		/////////////////////////////////////////////////////////////////////////////////////////
		// more option
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($selection.val() == '8') {
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
<?php
$usergroup = \Auth::user()->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
$userloc = \Auth::user()->belongtostaff->location_id;
// echo $userloc.'<-- location_id<br />';

$userneedbackup = \Auth::user()->belongtostaff->leave_need_backup;

// justify for those who doesnt have department
if( empty($usergroup->department_id) && $usergroup->category_id == 1 ) {
	$rt = \App\Model\Position::where('division_id', $usergroup->division_id)->Where('group_id', '<>', 1)->where('category_id', $usergroup->category_id);
} else {
	$rt = \App\Model\Position::where('department_id', $usergroup->department_id)->Where('group_id', '<>', 1)->where('category_id', $usergroup->category_id);
}

foreach ($rt->get() as $key) {
	// echo $key->position.' <-- position id<br />';
	$ft = \App\Model\StaffPosition::where('position_id', $key->id)->get();
	foreach($ft as $val) {
		//must checking on same location, active user, almost same level.
		if (\Auth::user()->belongtostaff->id != $val->belongtostaff->id && \Auth::user()->belongtostaff->location_id == $val->belongtostaff->location_id && $val->belongtostaff->active == 1 ) {
			// echo $val->belongtostaff->name.' <-- name staff<br />';
			$sel[$val->belongtostaff->id] = $val->belongtostaff->name;
		}
	}
}
?>
@if( ($usergroup->category_id == 1 || $usergroup->group_id == 5 || $usergroup->group_id == 6) || $userneedbackup == 1 )
				'<div id="rembackup">' +
				'</div>' +
@endif
			'</div>'
		);
		/////////////////////////////////////////////////////////////////////////////////////////
		// more option

		//add bootstrapvalidator
		$('#form').bootstrapValidator('addField', $('.datetime').find('[name="date_time_start"]'));
		$('#form').bootstrapValidator('addField', $('.datetime').find('[name="date_time_end"]'));

		/////////////////////////////////////////////////////////////////////////////////////////
		//enable select 2 for backup
		$('#backupperson').select2({
			placeholder: 'Please Choose'
		});

		/////////////////////////////////////////////////////////////////////////////////////////
		// enable datetime for the 1st one
		$('#from').datetimepicker({
			format:'YYYY-MM-DD',
			daysOfWeekDisabled: [0],
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
			console.log( moment().add(1, 'days').format('YYYY-MM-DD') );
				//if( $('#rembackup').length == 0 ) {
					$('#rembackup').append(
						'<div class="form-group row {{ $errors->has('staff_id') ? 'has-error' : '' }}">' +
							'{{ Form::label('backupperson', 'Backup Person : ', ['class' => 'col-sm-2 col-form-label']) }}' +
							'<div class="col-sm-10 backup">' +
								'{{ Form::select('staff_id', $sel, NULL, ['class' => 'form-control', 'id' => 'backupperson', 'placeholder' => 'Please Choose', 'autocomplete' => 'off']) }}' +
							'</div>' +
						'</div>'
					);
				//}
@if( ($usergroup->category_id == 1 || $usergroup->group_id == 5 || $usergroup->group_id == 6) || $userneedbackup == 1 )
		$('#form').bootstrapValidator('addField', $('.backup').find('[name="staff_id"]'));
@endif
				$('#backupperson').select2({
					placeholder: 'Please Choose'
				});
			} else {
				$('#rembackup').children().remove();
			}
		});
		
		$('#to').datetimepicker({
			format:'YYYY-MM-DD',
			daysOfWeekDisabled: [0],
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
							'<input type="radio" name="leave_half" value="1" id="am" checked="checked">' +
							'<div class="state p-primary">' +
								'<label for="am" class="form-check-label">' + moment(obj.start_am, 'HH:mm:ss').format('h:mm a') + ' to ' + moment(obj.end_am, 'HH:mm:ss').format('h:mm a') + '</label> ' +
							'</div>' +
						'</div>' +
						'<div class="pretty p-default p-curve form-check removetest">' +
							'<input type="radio" name="leave_half" value="0" id="pm">' +
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
	if ($selection.val() == '9') {
		$('#remove').remove();
		$('#wrapper').append(
			'<div id="remove">' +
				<!-- time off -->
			'</div>'
		);
		/////////////////////////////////////////////////////////////////////////////////////////
		// more option
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
	placeholder: 'Please Choose'
});

/////////////////////////////////////////////////////////////////////////////////////////
//enable ckeditor
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
				validators: {
					notEmpty: {
						message: 'Please select 1 option'
					},
				}
			},
			staff_id: {
				validators: {
					notEmpty: {
						message: 'Please Choose'
					}
				}
			},
			document: {
				validators: {
					file: {
						extension: 'jpeg,jpg,png,bmp,pdf,doc',
						type: 'image/jpeg,image/png,image/bmp,application/pdf,application/msword',
						maxSize: 2097152,	// 2048 * 1024,
						message: 'The selected file is not valid. Please use jpeg, jpg, png, bmp, pdf or doc and the file is below than 3MB. '
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
		}
	})
	.find('[name="reason"]')
	// .ckeditor()
	// .editor
		.on('change', function() {
			// Revalidate the bio field
		$('#form').bootstrapValidator('revalidateField', 'reason');
		//console.log($('#reason').val());
	})
	;
});

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

