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
				<p class="lead"></p>
			</dd>
		</dl>

{!! Form::open(['route' => ['staffLeave.store'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) !!}
	@include('leave._form')
{{ Form::close() }}


		
	</div>
</div>
@endsection

@section('js')
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
	useCurrent: true,
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
	useCurrent: true,
})
.on('dp.change dp.show dp.update', function(e) {
	// $('#form').bootstrapValidator('revalidateField', 'to');
	var maxDate = $('#to').val();
	$('#from').datetimepicker('maxDate', maxDate);
});

/////////////////////////////////////////////////////////////////////////////////////////

@endsection

