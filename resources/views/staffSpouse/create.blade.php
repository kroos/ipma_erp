@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Pasangan</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

{!! Form::open(['route' => ['staffSpouse.store'], 'id' => 'form', 'class' => 'form-horizontal', 'autocomplete' => 'off', 'files' => true]) !!}
	@include('staffSpouse._form')
{{ Form::close() }}
		
	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$(document).on('keyup', 'input', function () {
	tch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
// datetime for the 1st one

$('#dob_1').datetimepicker({
	format:'YYYY-MM-DD',
	viewMode: 'years',
})
.on('dp.change dp.show dp.update', function(e) {
	$('#form').bootstrapValidator('revalidateField', 'staff[1][dob]');
});

/////////////////////////////////////////////////////////////////////////////////////////
// add spouse : add and remove row

var max_fields      = 4; //maximum input boxes allowed
var add_buttons	= $(".add_spouse");
var wrappers	= $(".spouse_wrap");

var xs = 1;
$(add_buttons).click(function(){
	// e.preventDefault();

//max input box allowed
if(xs < max_fields){
	xs++;
	wrappers.append(

		'<div class="rowspouse">' +
			'<div class="row col-sm-12">' +
				'<div class="col-sm-1">' +
					'<button class="btn btn-danger remove_spouse" type="button">' +
						'<i class="fas fa-trash" aria-hidden="true"></i>' +
					'</button>' +
				'</div>' +
				'<div class="col-sm-3">' +
					'<div class="form-group {{ $errors->has('staff.*.spouse') ? 'has-error' : '' }}">' +
						'<input type="text" name="staff[' + xs + '][spouse]" id="npasa" class="form-control" placeholder="Nama Pasangan" autocomplete="off" value="{{ @$value }}">' +
					'</div>' +
				'</div>' +
				'<div class="col-sm-2">' +
					'<div class="form-group {{ $errors->has('staff.*.id_card_passport') ? 'has-error' : '' }}">' +
						'<input type="text" name="staff[' + xs + '][id_card_passport]" id="iccard" class="form-control" placeholder="ID Kad" autocomplete="off" value="{{ @$value }}">' +
					'</div>' +
				'</div>' +
				'<div class="col-sm-2">' +
					'<div class="form-group {{ $errors->has('staff.*.phone') ? 'has-error' : '' }}">' +
						'<input type="text" name="staff[' + xs + '][phone]" id="fon" class="form-control" placeholder="Telefon" autocomplete="off" value="{{ @$value }}">' +
					'</div>' +
				'</div>' +
				'<div class="col-sm-2">' +
					'<div class="form-group {{ $errors->has('staff.*.dob') ? 'has-error' : '' }}">' +
						'<input type="text" name="staff[' + xs + '][dob]" id="dob_' + xs + '" class="form-control" placeholder="Tarikh Lahir" autocomplete="off" value="{{ @$value }}">' +
					'</div>' +
				'</div>' +
				'<div class="col-sm-2">' +
					'<div class="form-group {{ $errors->has('staff.*.profession') ? 'has-error' : '' }}">' +
						'<input type="text" name="staff[' + xs + '][profession]" id="profession" class="form-control" placeholder="Pekerjaan" autocomplete="off" value="{{ @$value }}">' +
					'</div>' +
				'</div>' +
			'</div>' +
		'</div>'

	); //add input box

	$('#dob_' + xs).datetimepicker({
		format:'YYYY-MM-DD',
		viewMode: 'years',
	})
	.on('dp.change dp.show dp.update', function(e) {
		$('#form').bootstrapValidator('revalidateField', 'staff[' + xs + '][dob]');
	});

	//bootstrap validate
	$('#form').bootstrapValidator('addField',	$('.rowspouse')	.find('[name="staff['+ xs +'][spouse]"]'));
	$('#form').bootstrapValidator('addField',	$('.rowspouse')	.find('[name="staff['+ xs +'][id_card_passport]"]'));
	$('#form').bootstrapValidator('addField',	$('.rowspouse')	.find('[name="staff['+ xs +'][dob]"]'));
	$('#form').bootstrapValidator('addField',	$('.rowspouse')	.find('[name="staff['+ xs +'][profession]"]'));
	$('#form').bootstrapValidator('addField',	$('.rowspouse')	.find('[name="staff['+ xs +'][phone]"]'));
}
//  else {
//  	$('#enough').append('<p>4 cukup dah laa.. :)</p>');
//  }
})

$(wrappers).on("click",".remove_spouse", function(e){
	//user click on remove text
	e.preventDefault();
	//var $row = $(this).parent('.rowspouse');
	var $row = $(this).parent().parent();
	var $option1 = $row.find('[name="staff[' + xs + '][spouse]"]');
	var $option2 = $row.find('[name="staff[' + xs + '][id_card_passport]"]');
	var $option3 = $row.find('[name="staff[' + xs + '][phone]"]');
	var $option4 = $row.find('[name="staff[' + xs + '][dob]"]');
	var $option5 = $row.find('[name="staff[' + xs + '][profession]"]');
	$row.remove();

	$('#form').bootstrapValidator('removeField', $option1);
	$('#form').bootstrapValidator('removeField', $option2);
	$('#form').bootstrapValidator('removeField', $option3);
	$('#form').bootstrapValidator('removeField', $option4);
	$('#form').bootstrapValidator('removeField', $option5);
	console.log();
    xs--;
})

/////////////////////////////////////////////////////////////////////////////////////////
// bootstrap validator

$('#form').bootstrapValidator({
	feedbackIcons: {
		valid: '',
		invalid: '',
		validating: ''
	},
	fields: {

@for ($ie = 1; $ie < 5; $ie++)
		'staff[{{ $ie }}][spouse]': {
			validators: {
				notEmpty: {
					message: 'Sila masukkan nama pasangan. '
				},
				regexp: {
					regexp: /^[a-z\s\'\@]+$/i,
					message: 'The full name can consist of alphabetical characters, \', @ and spaces only'
				},
			}
		},
		'staff[{{ $ie }}][id_card_passport]': {
			validators: {
				numeric: {
					message: 'Sila masukkan no kad pengenalan atau no passport. '
				},
			}
		},
		'staff[{{ $ie }}][phone]': {
			validators: {
				notEmpty: {
					message: 'Sila masukkan no telefon bimbit. '
				},
				numeric: {
					message: 'Hanya angka sahaja. '
				},
			}
		},
		'staff[{{ $ie }}][dob]': {
			validators: {
				date: {
					format: 'YYYY-MM-DD',
					message: 'The value is not a valid date. '
				},
			}
		},
		'staff[{{ $ie }}][profession]': {
			validators: {
				notEmpty: {
					message: 'Sila masukkan pekerjaan pasangan anda. '
				},
			}
		},
@endfor
	}
});


/////////////////////////////////////////////////////////////////////////////////////////
//add more row


/////////////////////////////////////////////////////////////////////////////////////////
//add more row


/////////////////////////////////////////////////////////////////////////////////////////
//add more row


/////////////////////////////////////////////////////////////////////////////////////////
@endsection

