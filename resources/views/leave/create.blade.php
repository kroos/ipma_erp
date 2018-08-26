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
				<p class="lead">Permohonan Cuti Mestilah Sekurang-kurangnya <span class="font-weight-bold">TIGA (3)</span> Hari Lebih Awal dari Tarikh Bercuti.</p>
			</dd>
		</dl>

{!! Form::open(['route' => ['staffLeave.store'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) !!}
	@include('leave._form')
{{ Form::close() }}


		
	</div>
</div>
<!-- <script src="https://cdn.ckeditor.com/4.10.0/standard/ckeditor.js"></script> -->
@endsection

@section('js')
<!-- console.log(moment().add(3, 'days').format('YYYY-MM-DD')); -->
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$("#reason").keyup(function() {
	tch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
//select2
$('#leave_id, #backupperson').select2({
	placeholder: 'Please Choose'
});
/////////////////////////////////////////////////////////////////////////////////////////
// datetime for the 1st one
$('#from').datetimepicker({
	format:'YYYY-MM-DD',
	// format:'LT',
	// viewMode: 'years',
	// useCurrent: true,
	daysOfWeekDisabled: [0],
	minDate: moment().add(3, 'days').format('YYYY-MM-DD'),
})
.on('dp.change dp.show dp.update', function(e) {
	// $('#form').bootstrapValidator('revalidateField', 'from');
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
	// format:'LT',
	// viewMode: 'years',
	// useCurrent: true,
	daysOfWeekDisabled: [0],
	minDate: moment().add(3, 'days').format('YYYY-MM-DD'),
})
.on('dp.change dp.show dp.update', function(e) {
	// $('#form').bootstrapValidator('revalidateField', 'to');
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
$('#leave_id').on('change', function() {
	$selection = $(this).find(':selected');
	// $('#opt_value').val($selection.val());
	// $('#opt_price').val($selection.data('price'));

	if ($selection.val() == '9') {
		$('#remove').remove();
		$('#wrapper').append(
				'<p class="text-danger text-justify" id="remove">Price 3</p>'
			);
	}
});

/////////////////////////////////////////////////////////////////////////////////////////
// ckeditor
// CKEDITOR.replace( 'reason' );

/////////////////////////////////////////////////////////////////////////////////////////
// radio
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

var obj = jQuery.parseJSON( data1 );

		$('#wrappertest').append(
			'<div class="pretty p-default p-curve form-check removetest">' +
				'<input type="radio" name="leave_half" value="1" id="am" checked="checked">' +
				'<div class="state p-primary">' +
					'<label for="am" class="form-check-label">Pagi ' + obj.start_am + ' -> ' + obj.end_am + '</label> ' +
				'</div>' +
			'</div>' +
			'<div class="pretty p-default p-curve form-check removetest">' +
				'<input type="radio" name="leave_half" value="0" id="pm">' +
				'<div class="state p-primary">' +
					'<label for="pm" class="form-check-label">Petang ' + obj.start_pm + ' -> ' + obj.end_pm + '</label> ' +
				'</div>' +
			'</div>'
		);
	}
});

$(document).on('change', '#removeleavehalf :radio', function () {
//$('#removeleavehalf :radio').change(function() {
	if (this.checked) {
		$('.removetest').remove();
	}
});

/////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

