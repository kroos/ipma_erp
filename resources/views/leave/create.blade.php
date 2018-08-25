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
<script src="https://cdn.ckeditor.com/4.10.0/standard/ckeditor.js"></script>
@endsection

@section('js')
<!-- console.log(moment().add(3, 'days').format('YYYY-MM-DD')); -->
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$("#username").keyup(function() {
	uch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
//select2
$('#leave_id').select2({
	placeholder: 'Leave Type'
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
CKEDITOR.replace( 'reason' );

/////////////////////////////////////////////////////////////////////////////////////////
// radio
$('#appendleavehalf :radio').change(function() {
	if (this.checked) {
		$('#wrappertest').append(
			'<div class="pretty p-default p-curve form-check removetest">' +
				'{{ Form::radio('leave_half', '1', true, ['id' => 'am']) }}' +
				'<div class="state p-primary">' +
					'{{ Form::label('am', 'Pagi time', ['class' => 'form-check-label']) }}' +
				'</div>' +
			'</div>' +
			'<div class="pretty p-default p-curve form-check removetest">' +
				'{{ Form::radio('leave_half', '0', NULL, ['id' => 'pm']) }}' +
				'<div class="state p-primary">' +
					'{{ Form::label('pm', 'Petang time', ['class' => 'form-check-label']) }}' +
				'</div>' +
			'</div>'
		);
	}
});

$('#removeleavehalf :radio').change(function() {
	if (this.checked) {
		$('.removetest').remove();
	}
});

/////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

