@extends('layouts.app')

@section('content')
<?php
if($quot->hasmanyrevision()->get()->count()) {
	switch ( $quot->hasmanyrevision()->get()->count('id') ) {
		case 1:
			$rev = '-A';
			break;

		case 2:
			$rev = '-B';
			break;

		case 3:
			$rev = '-C';
			break;

		case 4:
			$rev = '-D';
			break;

		case 5:
			$rev = '-E';
			break;

		case 6:
			$rev = '-F';
			break;

		case 7:
			$rev = '-G';
			break;

		case 8:
			$rev = '-H';
			break;

		case 9:
			$rev = '-I';
			break;

		case 10:
			$rev = '-J';
			break;

		case 11:
			$rev = '-K';
			break;

		case 12:
			$rev = '-L';
			break;

		case 13:
			$rev = '-M';
			break;

		case 14:
			$rev = '-N';
			break;

		case 15:
			$rev = '-O';
			break;

		case 16:
			$rev = '-P';
			break;

		case 17:
			$rev = '-Q';
			break;

		case 18:
			$rev = '-R';
			break;

		case 19:
			$rev = '-S';
			break;

		case 20:
			$rev = '-T';
			break;

		case 21:
			$rev = '-U';
			break;

		case 22:
			$rev = '-V';
			break;

		case 23:
			$rev = '-W';
			break;

		case 24:
			$rev = '-X';
			break;

		case 25:
			$rev = '-Y';
			break;

		case 26:
			$rev = '-Z';
			break;

		default:
			$rev = $quot->hasmanyrevision()->get()->count('id');
			break;
	}
} else {
	$rev = NULL;
}
?>
<div class="card">
	<div class="card-header"><h1>Costing Department</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

		<ul class="nav nav-tabs">
@foreach( App\Model\Division::find(3)->hasmanydepartment()->whereNotIn('id', [22, 23, 24])->get() as $key)
			<li class="nav-item">
				<a class="nav-link {{ ($key->id == 7)? 'active' : 'disabled' }}" href="{{ route("$key->route.index") }}">{{ $key->department }}</a>
			</li>
@endforeach
		</ul>

		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link active" href="{{ route('quot.index') }}">Quotation</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('ics.costing') }}">Intelligence Customer Service</a>
			</li>
		</ul>

		<div class="card">
			<div class="card-header">
				Quotation
			</div>
			<div class="card-body">

				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('customer.index') }}">Customer</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('machine_model.index') }}">Model</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('quotdd.index') }}">UOM Delivery Date Period</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('quotItem.index') }}">Product / Item</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('quotItemAttrib.index') }}">Product / Item Attribute</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('quotUOM.index') }}">Unit Of Measurement</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('quotRem.index') }}">Remarks</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('quotExcl.index') }}">Exclusion</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('quotDeal.index') }}">Dealer</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('quotWarr.index') }}">Warranty</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('quotBank.index') }}">Bank</a>
					</li>
				</ul>

		<div class="card">
			<div class="card-header">
<?php
$dts = \Carbon\Carbon::parse($quot->date);
$arr = str_split( $dts->format('Y'), 2 );
// $rev = $quot->hasmanyrevision()->get()->count('id');
?>
				Edit Quotation QT-{!! $quot->id !!}/{!! $arr[1] !!}
@if($quot->hasmanyrevision()->get()->count())
{!! $rev !!}
@endif
			</div>
			<div class="card-body">
{!! Form::model($quot, ['route' => ['quot.update', $quot->id], 'method' => 'PATCH', 'id' => 'form', 'files' => true]) !!}
	@include('marketingAndBusinessDevelopment.costing.quotation._edit')
{!! Form::close() !!}
			</div>
		</div>

	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
// popover
$('.name1').popover({ 
	trigger: "hover",
	html: true,
});

$("input:radio").on("click",function (e) {
	var inp=$(this);
	if (inp.is(".theone")) {
		inp.prop("checked",false).removeClass("theone");
	} else {
		$("input:radio[name='"+inp.prop("name")+"'].theone").removeClass("theone");
		inp.addClass("theone");
	}
});

/////////////////////////////////////////////////////////////////////////////////////////
// date
$('#dat').datetimepicker({
	format:'YYYY-MM-DD',
	useCurrent: true,
})
.on('dp.change dp.show dp.update', function() {
	$('#form').bootstrapValidator('revalidateField', 'date');
});

/////////////////////////////////////////////////////////////////////////////////////////
// select2
$('#curr, #cust, #tax_id, #ddp, #exclusion_1, #remark_1').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

// exclusion
@if($quot->hasmanyexclusions()->get()->count())
<?php $n1 = 1 ?>
	@foreach($quot->hasmanyexclusions()->get() as $nj)
		$('#exclusion_{{ $n1++ }}').select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});
	@endforeach
@endif

// remarks
@if($quot->hasmanyremarks()->get()->count())
<?php $n2 = 1 ?>
	@foreach($quot->hasmanyremarks()->get() as $nb)
		$('#remark_{!! $n2++ !!}').select2({
					placeholder: 'Please choose',
					allowClear: true,
					closeOnSelect: true,
					width: '100%',
				});
	@endforeach
@endif

// dealer
@if($quot->hasmanydealer()->get()->count())
<?php $n3 = 1 ?>
	@foreach($quot->hasmanydealer()->get() as $nb)
		$('#dealer_{!! $n3++ !!}').select2({
					placeholder: 'Please choose',
					allowClear: true,
					closeOnSelect: true,
					width: '100%',
				});
	@endforeach
@endif

// warranty
@if($quot->hasmanywarranty()->get()->count())
<?php $n4 = 1 ?>
	@foreach($quot->hasmanywarranty()->get() as $nb)
		$('#warranty_{!! $n4++ !!}').select2({
					placeholder: 'Please choose',
					allowClear: true,
					closeOnSelect: true,
					width: '100%',
				});
	@endforeach
@endif

// section, item, attrib
<?php
// section
$w1 = 1;	// main

// item
$w2 = 1;	// main
$w3 = 1;
$w4 = 1;

// attribute
$w5 = 1;	// main

if ( $quot->hasmanyquotsection()->get()->count() ) {
	foreach( $quot->hasmanyquotsection()->get() as $sect1 ) {
		$w1++;
		if( $sect1->hasmanyquotsectionitem()->get()->count() ) {
			foreach( $sect1->hasmanyquotsectionitem()->get() as $it1 ) {
?>
				$('#item_{!! $w1-1 !!}_{!! $w2++ !!}, #uom_id_{!! $w1-1 !!}_{!! $w3++ !!}, #tax_id_{!! $w1-1 !!}_{!! $w4++ !!}').select2({
					placeholder: 'Please choose',
					allowClear: true,
					closeOnSelect: true,
					width: '100%',
				});
<?php
				if( $it1->hasmanyquotsectionitemattrib()->get()->count() ) {
					foreach( $it1->hasmanyquotsectionitemattrib()->get() as $att ) {
?>
						$('#attrib_id_{!! $w1-1 !!}_{!! $w2-1 !!}_{!! $w5++ !!}').select2({
							placeholder: 'Please choose',
							allowClear: true,
							closeOnSelect: true,
							width: '100%',
						});
<?php
					}
				}
			}
		}
	}
}
?>

/////////////////////////////////////////////////////////////////////////////////////////
// calculate Xs, xi & xia
// 
<?php
$q1 = $quot->hasmanyquotsection()->get();
$d1 = 0;
$d2 = 0;
$d3 = 0;
if( $q1->count() ) {
	// add numerous section
	$d1 += $q1->count();
	foreach($q1 as $z1 => $x1){
		$q2 = $x1->hasmanyquotsectionitem()->get();
		if ( $q2->count() ) {
			$d2 += $q2->count();
			foreach ($q2 as $z2 => $x2) {
				$q3 = $x2->hasmanyquotsectionitemattrib()->get();
				$d3 += $q3->count();
			}

		}
	}
}
echo '// '.$d1.'=>'.$d2.'=>'.$d3.'=';
?>

/////////////////////////////////////////////////////////////////////////////////////////
// add section : add and remove row section

var max_fields	= 50; //maximum input boxes allowed
var add_buttons	= $(".section_add");
var wrappers	= $(".section_wrapper");

var xs = {!! $d1 !!};
$(add_buttons).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(xs < max_fields){
		xs++;
		wrappers.append(

			'<div class="section_row">' +
				'<div class="card">' +
					'<div class="card-header">Section</div>' +
					'<div class="card-body">' +
						'<div class="row">' +
							'<div class="col-1 text-danger section_remove"  id="section_remove_' + xs + '" data-sectionid="' + xs + '">' +
								'<i class="fas fa-trash" aria-hidden="true"></i>' +
							'</div>' +

							'<input type="hidden" name="qs[' + xs + '][id]" value="">' +

							'<div class="form-group col-11 {{ $errors->has('qs.*.section') ? 'has-error' : '' }}">' +
								'<input type="text" name="qs[' + xs + '][section]" value="" id="section_' + xs + '" class="form-control form-control-sm" autocomplete="off" placeholder="Section Title" />' +
							'</div>' +
							'<div class="col-12">' +
								'<div class="card">' +
									'<div class="card-header">Item</div>' +
									'<div class="card-body">' +
										'<div class="col item_wrap">' +

										'</div>' +
									'</div>' +
								'</div>' +
								'<div class="row col-2 item_add" data-sectionid="' + xs + '">' +
									'<p class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Item</p>' +
								'</div>' +
							'</div>' +
						'</div>' +

						'<div class="form-row row col-12">' +
							'<div class="form-group col-3 offset-8">' +
								'<label for="grandtotal" class="col col-form-label">Total :</label>' +
							'</div>' +
							'<div class="form-group col-1">' +
								'<input type="text" value="0.00" class="form-control form-control-sm totalprice" disabled="disabled">' +
							'</div>' +
						'</div>' +

					'</div>' +
				'</div>' +
			'</div>' +
			'<br />'

		);		// add input box


		//bootstrap validate
		$('#form').bootstrapValidator('addField', $('.section_row').find('[name="qs[' + xs + '][section]"]'));
	}
});

$(wrappers).on("click",".section_remove", function(e){
	var section_id = $(this).data('sectionid');
	e.preventDefault();
	var $row1 = $(this).parent().parent().parent().parent();
	var $option1 = $row1.find('[name="qs[' + section_id + '][section]"]');
	$('#form').bootstrapValidator('removeField', $option1);
	$row1.remove();
	// $option1.css('border', 'solid 1px red');

	xs--;
})

/////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// add more rows on item
var max_items	= max_fields * 50;		//maximum input boxes allowed
var xi = {!! $d2 !!};

$(document).on('click', '.item_add', function() {
// $('.item_add').click(function(e){
	var item_wrapper = $(this).parent().children().children().children('.item_wrap');
	// item_wrapper.css('border', 'solid 1px red');
	var section_id = $(this).data('sectionid');

	if(xi < max_items){
		xi++;
		$(item_wrapper).append(

			'<div class="item_row">' +
				'<div class="form-row col-12">' +
					'<div class="col-1 text-danger item_remove" data-sectionid="' + section_id + '" data-itemid="' + xi + '">' +
							'<i class="fas fa-trash" aria-hidden="true"></i>' +
					'</div>' +

					'<input type="hidden" name="qs[' + section_id + '][qssection][' + xi + '][id]" value="">' +

					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.item_id') ? 'has-error' : '' }}">' +
						'<select name="qs[' + section_id + '][qssection][' + xi + '][item_id]" id="item_' + section_id + '_' + xi + '" class="form-control form-control-sm itemprice" autocomplete="off" placeholder="Please choose">' +
							'<option value="">Please choose</option>' +
@foreach(\App\Model\QuotItem::where('active', 1)->get() as $item)
							'<option value="{!! $item->id !!}" data-price="{!! $item->price !!}">{!! $item->item !!}</option>' +
@endforeach
						'</select>' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.price_unit') ? 'has-error' : '' }}">' +
						'<input type="text" name="qs[' + section_id + '][qssection][' + xi + '][price_unit]" id="price_unit_' + section_id + '_' + xi + '" class="form-control form-control-sm priceunit" placeholder="Price/Unit">' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.description') ? 'has-error' : '' }}">' +
						'<input type="text" name="qs[' + section_id + '][qssection][' + xi + '][description]" id="remarks_' + section_id + '_' + xi + '" class="form-control form-control-sm" placeholder="Remarks" />' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.quantity') ? 'has-error' : '' }}">' +
						'<input type="text" name="qs[' + section_id + '][qssection][' + xi + '][quantity]" value="" id="quantity_' + section_id + '_' + xi + '" class="form-control form-control-sm quan" autocomplete="off" placeholder="Quantity" />' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.uom_id') ? 'has-error' : '' }}">' +
						'<select name="qs[' + section_id + '][qssection][' + xi + '][uom_id]" id="uom_id_' + section_id + '_' + xi + '" class="form-control form-control-sm" autocomplete="off" placeholder="Please choose">' +
							'<option value="">Please choose</option>' +
@foreach(\App\Model\QuotUOM::all() as $uom)
							'<option value="{!! $uom->id !!}" >{!! $uom->uom !!}</option>' +
@endforeach
						'</select>' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.tax_id') ? 'has-error' : '' }}">' +
						'<select type="text" name="qs[' + section_id + '][qssection][' + xi + '][tax_id]" value="" id="tax_id_' + section_id + '_' + xi + '" class="form-control form-control-sm tax" autocomplete="off" placeholder="Please choose" >' +
							'<option value="">Please choose</option>' +
@foreach(\App\Model\Tax::all() as $tax)
							'<option value="{!! $tax->id !!}" data-taxvalue="{!! $tax->value !!}">{!! $tax->tax !!}</option>' +
@endforeach
						'</select>' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.tax_value') ? 'has-error' : '' }}">' +
						'<input type="text" name="qs[' + section_id + '][qssection][' + xi + '][tax_value]" value="" id="tax_value_' + section_id + '_' + xi + '" class="form-control form-control-sm taxvalue" autocomplete="off" placeholder="Tax Value (%)" />' +
					'</div>' +
					'<div class="form col">' +
						'<input type="text" value="0.00" class="form-control form-control-sm price" disabled="disabled">' +
					'</div>' +
				'</div>' +
				'<div class="col attrib_wrap">' +

				'</div>' +
				'<div class="row col-2 attrib_add"  data-sectionid="' + section_id + '" data-itemid="' + xi + '">' +
					'<p class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Item Attribute</p>' +
				'</div>' +
			'</div>'

		);		// add input box

		// select 2
		$( '#item_' + section_id + '_' + xi + ', #tax_id_' + section_id + '_' + xi + ', #uom_id_' + section_id + '_' + xi ).select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});

		//bootstrap validate
		$('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + xi + '][item_id]"]'));
		$('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + xi + '][price_unit]"]'));
		$('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + xi + '][description]"]'));
		$('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + xi + '][tax_id]"]'));
		$('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + xi + '][tax_value]"]'));
		$('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + xi + '][quantity]"]'));
		$('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + xi + '][uom_id]"]'));
	}

});

$(document).on('click', '.item_remove', function(e) {

	var section_id = $(this).data('sectionid');
	var item_id = $(this).data('itemid');

	e.preventDefault();
	var $row2 = $(this).parent().parent();

	var $option2 = $row2.find('[name="qs[' + section_id + '][qssection][' + item_id + '][item_id] "]');
	var $option3 = $row2.find('[name="qs[' + section_id + '][qssection][' + item_id + '][price_unit]"]');
	var $option4 = $row2.find('[name="qs[' + section_id + '][qssection][' + item_id + '][description]"]');
	var $option5 = $row2.find('[name="qs[' + section_id + '][qssection][' + item_id + '][tax_id]"]');
	var $option6 = $row2.find('[name="qs[' + section_id + '][qssection][' + item_id + '][tax_value]"]');
	var $option7 = $row2.find('[name="qs[' + section_id + '][qssection][' + item_id + '][quantity]"]');
	var $option8 = $row2.find('[name="qs[' + section_id + '][qssection][' + item_id + '][uom_id]"]');


	$('#form').bootstrapValidator('removeField', $option2);
	$('#form').bootstrapValidator('removeField', $option3);
	$('#form').bootstrapValidator('removeField', $option4);
	$('#form').bootstrapValidator('removeField', $option5);
	$('#form').bootstrapValidator('removeField', $option6);
	$('#form').bootstrapValidator('removeField', $option7);
	$('#form').bootstrapValidator('removeField', $option8);

	$row2.remove();
	// $option3.css('border', 'solid 2px red');

	xi--;
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// add more rows on item attrib
var max_items_attrib	= max_items * 50;		//maximum input boxes allowed
var xia = {!! $d3 !!};

$(document).on('click', '.attrib_add', function() {
	var item_attrib_wrapper = $(this).parent().children('.attrib_wrap');
	// item_attrib_wrapper.css('border', 'solid 1px red');
	var section_id = $(this).data('sectionid');
	var item_id = $(this).data('itemid');

	if(xia < max_items_attrib){
		xia++;
		$(item_attrib_wrapper).append(

			'<div class="attrib_row">' +
				'<div class="row col-9 offset-1">' +
					'<div class="col-1 text-danger attrib_remove" data-sectionid="' + section_id + '" data-itemid="' + item_id + '" data-id="' + xia + '">' +
						'<i class="fas fa-trash" aria-hidden="true"></i>' +
					'</div>' +

					'<input type="hidden" name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][id]" value="">' +

					'<div class="form-group col-2 {{ $errors->has('qs.*.qssection.*.qsitem.*.attribute_id') ? 'has-error' : '' }}">' +
						'<select name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][attribute_id]" id="attrib_id_' + section_id + '_' + item_id + '_' + xia + '" class="form-control form-control-sm attrib" autocomplete="off" placeholder="Please choose">' +
							'<option value="">Please choose</option>' +
@foreach(\App\Model\QuotItemAttribute::all() as $attrib)
							'<option value="{!! $attrib->id !!}" >{!! $attrib->attribute !!}</option>' +
@endforeach
						'</select>' +
					'</div>' +
					'<div class="form-group col-2 image {{ $errors->has('qs.*.qssection.*.qsitem.*.description_attribute') ? 'has-error' : '' }}">' +
						'<input type="text" name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][description_attribute]" id="description_attribute_' + section_id + '_' + item_id + '_' + xia + '" class="form-control form-control-sm inputattrib" placeholder="Description">' +
					'</div>' +
					'<div class="form-group col-2 {{ $errors->has('qs.*.qssection.*.qsitem.*.image') ? 'has-error' : '' }}">' +
						'<input type="file" name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][image]" id="image_' + section_id + '_' + item_id + '_' + xia + '" class="form-control form-control-file form-control-sm" placeholder="Image">' +
					'</div>' +
					'<div class="form-group col-3 {{ $errors->has('qs.*.qssection.*.qsitem.*.remarks') ? 'has-error' : '' }}">' +
						'<input type="text" name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][remarks]" id="remarks_' + section_id + '_' + item_id + '_' + xia + '" class="form-control form-control-sm" placeholder="Remarks">' +
					'</div>' +
				'</div>' +
			'</div>'
		);		// add input box

		// select 2
		$( '#attrib_id_' + section_id + '_' + item_id + '_' + xia ).select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});

		//bootstrap validate
		$('#form').bootstrapValidator('addField',$('.attrib_row').find('[name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][attribute_id]"]'));
		$('#form').bootstrapValidator('addField',$('.attrib_row').find('[name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][description_attribute]"]'));
		$('#form').bootstrapValidator('addField',$('.attrib_row').find('[name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][remarks]"]'));
	}

});

$(document).on('click', '.attrib_remove', function(e) {
	var section_id = $(this).data('sectionid');
	var item_id = $(this).data('itemid');
	var attrib_id = $(this).data('itemid');

	e.preventDefault();
	var $row3 = $(this).parent().parent();

	var $option9 = $row3.find('[name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + attrib_id + '][attribute_id]"]');
	var $option10 = $row3.find('[name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + attrib_id + '][description_attribute]"]');
	var $option11 = $row3.find('[name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + attrib_id + '][remarks]"]');

	$('#form').bootstrapValidator('removeField', $option9);
	$('#form').bootstrapValidator('removeField', $option10);
	$('#form').bootstrapValidator('removeField', $option11);

	$row3.remove();

	// $option10.css('border', 'solid 1px red');

	xia--;
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// add more rows on term of payment
var top	= 10;		//maximum input boxes allowed
var xt = {!! ($quot->hasmanytermofpayment()->get()->count())?$quot->hasmanytermofpayment()->get()->count():0 !!};

$(document).on('click', '.top_add', function() {
	var top_wrapper = $(this).parent().children('.top_wrapper');
	// top_wrapper.css('border', 'solid 1px red');

	if(xt < top){
		xt++;
		$(top_wrapper).append(

			'<div class="row top_row">' +
				'<div class="col-1 text-danger top_remove" data-id="' + xt + '">' +
					'<i class="fas fa-trash" aria-hidden="true"></i>' +
				'</div>' +
				'<input type="hidden" name="qstop[' + xt + '][id]" value="">' +
				'<input type="hidden" name="qstop[' + xt + '][quot_id]" value="{!! $quot->id !!}">' +
				'<div class="form-group col {{ $errors->has('qstop.*.term_of_payment') ? 'has-error' : '' }}">' +
					'<input type="text" name="qstop[' + xt + '][term_of_payment]" id="top_' + xt + '" class="form-control form-control-sm" placeholder="Term Of Payment">' +
				'</div>' +
			'</div>'

		);		// add input box

		//bootstrap validate
		$('#form').bootstrapValidator('addField',$('.top_row').find('[name="qstop[' + xt + '][term_of_payment]"]'));
	}

});

$(document).on('click', '.top_remove', function(e) {
	var top_id = $(this).data('id');

	e.preventDefault();
	var $row4 = $(this).parent('.top_row');
	// $row4.css('border', 'solid 1px red');

	var $option12 = $row4.find('[name="qstop[' + top_id + '][term_of_payment]"]');

	$('#form').bootstrapValidator('removeField', $option12);

	$row4.remove();

	// $option12.css('border', 'solid 1px red');

	xt--;
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// add more rows on exclusions
var max_exc	= 20;		//maximum input boxes allowed
var xexc = {!! ($quot->hasmanyexclusions()->get()->count())?$quot->hasmanyexclusions()->get()->count():0 !!};

$(document).on('click', '.exc_add', function() {
	var exc_wrapper = $(this).parent().children('.exc_wrapper');
	// exc_wrapper.css('border', 'solid 1px red');

	if(xexc < max_exc){
		xexc++;
		$(exc_wrapper).append(

			'<div class="row exc_row">' +
				'<div class="col-1 text-danger exc_remove" data-id="' + xexc + '">' +
					'<i class="fas fa-trash" aria-hidden="true"></i>' +
				'</div>' +
				'<input type="hidden" name="qsexclusions[' + xexc + '][id]" value="">' +
				'<input type="hidden" name="qsexclusions[' + xexc + '][quot_id]" value="{!! $quot->id !!}">' +
				'<div class="form-group col {{ $errors->has('qsexclusions.*.exclusion_id') ? 'has-error' : '' }}">' +
					'<select name="qsexclusions[' + xexc + '][exclusion_id]" class="form-control form-control-sm" id="exclusion_' + xexc + '" placeholder="Please choose">' +
						'<option value="">Please choose</option>' +
@foreach(\App\Model\QuotExclusion::all() as $exc)
						'<option value="{!! $exc->id !!}">{!! $exc->exclusion !!}</option>' +
@endforeach
					'</select>' +
				'</div>' +
			'</div>'

		);		// add input box

		// select2
		$( '#exclusion_' + xexc ).select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});

		//bootstrap validate
		$('#form').bootstrapValidator('addField',$('.exc_row').find('[name="qsexclusions[' + xexc + '][exclusion_id]"]'));
	}

});

$(document).on('click', '.exc_remove', function(e) {
	var exc_id = $(this).data('id');

	e.preventDefault();
	var $row5 = $(this).parent('.exc_row');
	// $row5.css('border', 'solid 1px red');

	var $option13 = $row5.find('[name="qsexclusions[' + exc_id + '][exclusion_id]"]');

	$('#form').bootstrapValidator('removeField', $option13);
	$row5.remove();

	// $option13.css('border', 'solid 1px red');

	xexc--;
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// add more rows on remark
var max_rem	= 20;		//maximum input boxes allowed
var xrem = {!! ($quot->hasmanyremarks()->get()->count())?$quot->hasmanyremarks()->get()->count():0 !!};

$(document).on('click', '.rem_add', function() {
	var rem_wrapper = $(this).parent().children('.rem_wrapper');
	// rem_wrapper.css('border', 'solid 1px red');

	if(xrem < max_rem){
		xrem++;
		$(rem_wrapper).append(

			'<div class="row rem_row">' +
				'<div class="col-1 text-danger rem_remove" data-id="' + xrem + '">' +
					'<i class="fas fa-trash" aria-hidden="true"></i>' +
				'</div>' +
				'<input type="hidden" name="qsremark[' + xrem + '][id]" value="">' +
				'<input type="hidden" name="qsremark[' + xrem + '][quot_id]" value="{!! $quot->id !!}">' +
				'<div class="form-group col {{ $errors->has('qsremark.*.remark_id') ? 'has-error' : '' }}">' +
					'<select name="qsremark[' + xrem + '][remark_id]" class="form-control form-control-sm" id="remark_' + xrem + '" placeholder="Please choose">' +
						'<option value="">Please choose</option>' +
@foreach(\App\Model\QuotRemark::all() as $rem)
						'<option value="{!! $rem->id !!}">{!! $rem->quot_remarks !!}</option>' +
@endforeach
					'</select>' +
				'</div>' +
			'</div>'

		);		// add input box

		// select2
		$( '#remark_' + xrem ).select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});

		//bootstrap validate
		$('#form').bootstrapValidator('addField',$('.rem_row').find('[name="qsremark[' + xrem + '][remark_id]"]'));
	}

});

$(document).on('click', '.rem_remove', function(e) {
	var rem_id = $(this).data('id');

	e.preventDefault();
	var $row6 = $(this).parent('.rem_row');
	// $row6.css('border', 'solid 1px red');

	var $option14 = $row6.find('[name="qsremark[' + rem_id + '][remark_id]"]');

	$('#form').bootstrapValidator('removeField', $option14);
	$row6.remove();

	// $option14.css('border', 'solid 1px red');

	xrem--;
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// add more rows on dealer
var max_dealer	= 20;		//maximum input boxes allowed
var xdeal = {!! ($quot->hasmanydealer()->get()->count())?$quot->hasmanydealer()->get()->count():0 !!};

$(document).on('click', '.dealer_add', function() {
	var dea_wrapper = $(this).parent().children('.dealer_wrapper');
	// dea_wrapper.css('border', 'solid 1px red');

	if(xdeal < max_dealer){
		xdeal++;
		$(dea_wrapper).append(

			'<div class="row dealer_row">' +
				'<div class="col-1 text-danger dea_remove" data-id="' + xdeal + '">' +
					'<i class="fas fa-trash" aria-hidden="true"></i>' +
				'</div>' +
				'<input type="hidden" name="qsdealer[' + xdeal + '][id]" value="">' +
				'<div class="form-group col {{ $errors->has('qsdealer.*.dealer_id') ? 'has-error' : '' }}">' +
					'<select name="qsdealer[' + xdeal + '][dealer_id]" class="form-control form-control-sm" id="dealer_' + xdeal + '" placeholder="Please choose">' +
						'<option value="">Please choose</option>' +
					@foreach(\App\Model\QuotDealer::all() as $dea)
						'<option value="{!! $dea->id !!}" >{!! $dea->dealer !!}</option>' +
					@endforeach
					'</select>' +
				'</div>' +
			'</div>'

		);		// add input box

		// select2
		$( '#dealer_' + xdeal ).select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});

		//bootstrap validate
		$('#form').bootstrapValidator('addField',$('.dealer_row').find('[name="qsdealer[' + xdeal + '][dealer_id]"]'));
	}

});

$(document).on('click', '.dea_remove', function(e) {
	var dea_id = $(this).data('id');

	e.preventDefault();
	var $row7 = $(this).parent('.dealer_row');
	// $row7.css('border', 'solid 1px red');

	var $option15 = $row7.find('[name="qsdealer[' + dea_id + '][dealer_id]"]');

	$('#form').bootstrapValidator('removeField', $option15);
	$row7.remove();

	// $option15.css('border', 'solid 1px red');

	xdeal--;
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// add more rows on warranty
var max_warr	= 20;		//maximum input boxes allowed
var xwarr = {!! ($quot->hasmanywarranty()->get()->count())?$quot->hasmanywarranty()->get()->count():0 !!};

$(document).on('click', '.warranty_add', function() {
	var warranty_wrapper = $(this).parent().children('.warranty_wrapper');
	// warranty_wrapper.css('border', 'solid 1px red');

	if(xwarr < max_warr){
		xwarr++;
		$(warranty_wrapper).append(

			'<div class="row warranty_row">' +
				'<div class="col-1 text-danger warranty_remove" data-id="' + xwarr + '">' +
					'<i class="fas fa-trash" aria-hidden="true"></i>' +
				'</div>' +
				'<input type="hidden" name="qswarranty[' + xwarr + '][id]" value="">' +
				'<div class="form-group col {{ $errors->has('qswarranty.*.warranty_id') ? 'has-error' : '' }}">' +
					'<select name="qswarranty[' + xwarr + '][warranty_id]" class="form-control form-control-sm" id="warranty_' + xwarr + '" placeholder="Please choose">' +
						'<option value="">Please choose</option>' +
					@foreach(\App\Model\QuotWarranty::all() as $dea)
						'<option value="{!! $dea->id !!}" >{!! $dea->warranty !!}</option>' +
					@endforeach
					'</select>' +
				'</div>' +
			'</div>'

		);		// add input box

		// select2
		$( '#warranty_' + xwarr ).select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});

		//bootstrap validate
		$('#form').bootstrapValidator('addField',$('.warranty_row').find('[name="qswarranty[' + xwarr + '][warranty_id]"]'));
	}

});

$(document).on('click', '.warranty_remove', function(e) {
	var warranty_id = $(this).data('id');

	e.preventDefault();
	var $row8 = $(this).parent('.warranty_row');
	// $row8.css('border', 'solid 1px red');

	var $option16 = $row8.find('[name="qswarranty[' + warranty_id + '][warranty_id]"]');

	$('#form').bootstrapValidator('removeField', $option16);
	$row8.remove();

	// $option16.css('border', 'solid 1px red');

	xwarr--;
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ajax post delete row section
$(document).on('click', '.section_delete', function(e){
	var section_id = $(this).data('sectionid');
	SwalDeleteSection(section_id);
	e.preventDefault();
});

function SwalDeleteSection(section_id){
	swal({
		title: 'Are you sure?',
		text: "It will be deleted permanently!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					url: '{{ url('quotSection') }}' + '/' + section_id,
					type: 'DELETE',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: section_id,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_product_' + section_id).parent().parent().remove();
				})
				.fail(function(){
					swal('Oops...', 'Something went wrong with ajax !', 'error');
				})
			});
		},
		allowOutsideClick: false			  
	})
	.then((result) => {
		if (result.dismiss === swal.DismissReason.cancel) {
			swal('Cancelled', 'Your data is safe from delete', 'info')
		}
	});
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ajax post delete row item
$(document).on('click', '.item_delete', function(e){
	var item_id = $(this).data('itemid');
	SwalDeleteItem(item_id);
	e.preventDefault();
});

function SwalDeleteItem(item_id){
	swal({
		title: 'Are you sure?',
		text: "It will be deleted permanently!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					url: '{{ url('quotSectionItem') }}' + '/' + item_id,
					type: 'DELETE',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: item_id,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_product_' + item_id).parent().parent().remove();
				})
				.fail(function(){
					swal('Oops...', 'Something went wrong with ajax !', 'error');
				})
			});
		},
		allowOutsideClick: false			  
	})
	.then((result) => {
		if (result.dismiss === swal.DismissReason.cancel) {
			swal('Cancelled', 'Your data is safe from delete', 'info')
		}
	});
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ajax post delete row attrib
$(document).on('click', '.attrib_delete', function(e){
	var attrib_id = $(this).data('id');
	SwalDeleteAttrib(attrib_id);
	e.preventDefault();
});

function SwalDeleteAttrib(attrib_id){
	swal({
		title: 'Are you sure?',
		text: "It will be deleted permanently!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					url: '{{ url('quotSectionItemAttrib') }}' + '/' + attrib_id,
					type: 'DELETE',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: attrib_id,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_product_' + attrib_id).parent().parent().remove();
				})
				.fail(function(){
					swal('Oops...', 'Something went wrong with ajax !', 'error');
				})
			});
		},
		allowOutsideClick: false			  
	})
	.then((result) => {
		if (result.dismiss === swal.DismissReason.cancel) {
			swal('Cancelled', 'Your data is safe from delete', 'info')
		}
	});
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ajax post delete row top
$(document).on('click', '.top_delete', function(e){
	var top_id = $(this).data('id');
	SwalDeleteTOP(top_id);
	e.preventDefault();
});

function SwalDeleteTOP(top_id){
	swal({
		title: 'Are you sure?',
		text: "It will be deleted permanently!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					url: '{{ url('quotTerm') }}' + '/' + top_id,
					type: 'DELETE',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							// id: top_id,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_product_' + top_id).parent().parent().remove();
				})
				.fail(function(){
					swal('Oops...', 'Something went wrong with ajax !', 'error');
				})
			});
		},
		allowOutsideClick: false			  
	})
	.then((result) => {
		if (result.dismiss === swal.DismissReason.cancel) {
			swal('Cancelled', 'Your data is safe from delete', 'info')
		}
	});
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ajax post delete row exclusion
$(document).on('click', '.exc_delete', function(e){
	var exc_id = $(this).data('id');
	SwalDeleteExclusion(exc_id);
	e.preventDefault();
});

function SwalDeleteExclusion(exc_id){
	swal({
		title: 'Are you sure?',
		text: "It will be deleted permanently!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					url: '{{ url('quotExclusion') }}' + '/' + exc_id,
					type: 'DELETE',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							// id: exc_id,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_product_' + exc_id).parent().parent().remove();
				})
				.fail(function(){
					swal('Oops...', 'Something went wrong with ajax !', 'error');
				})
			});
		},
		allowOutsideClick: false			  
	})
	.then((result) => {
		if (result.dismiss === swal.DismissReason.cancel) {
			swal('Cancelled', 'Your data is safe from delete', 'info')
		}
	});
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ajax post delete row remarks
$(document).on('click', '.rem_delete', function(e){
	var rem_id = $(this).data('id');
	SwalDeleteRemark(rem_id);
	e.preventDefault();
});

function SwalDeleteRemark(rem_id){
	swal({
		title: 'Are you sure?',
		text: "It will be deleted permanently!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					url: '{{ url('quotRemark') }}' + '/' + rem_id,
					type: 'DELETE',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							// id: rem_id,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_product_' + rem_id).parent().parent().remove();
				})
				.fail(function(){
					swal('Oops...', 'Something went wrong with ajax !', 'error');
				})
			});
		},
		allowOutsideClick: false			  
	})
	.then((result) => {
		if (result.dismiss === swal.DismissReason.cancel) {
			swal('Cancelled', 'Your data is safe from delete', 'info')
		}
	});
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ajax post delete row dealer
$(document).on('click', '.dealer_delete', function(e){
	var deal_id = $(this).data('id');
	SwalDeleteDealer(deal_id);
	e.preventDefault();
});

function SwalDeleteDealer(deal_id){
	swal({
		title: 'Are you sure?',
		text: "It will be deleted permanently!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					url: '{{ url('quotDealer') }}' + '/' + deal_id,
					type: 'DELETE',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							// id: deal_id,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_product_' + deal_id).parent().parent().remove();
				})
				.fail(function(){
					swal('Oops...', 'Something went wrong with ajax !', 'error');
				})
			});
		},
		allowOutsideClick: false			  
	})
	.then((result) => {
		if (result.dismiss === swal.DismissReason.cancel) {
			swal('Cancelled', 'Your data is safe from delete', 'info')
		}
	});
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ajax post delete row warranty
$(document).on('click', '.warranty_delete', function(e){
	var warranty_id = $(this).data('id');
	SwalDeleteWarranty(warranty_id);
	e.preventDefault();
});

function SwalDeleteWarranty(warranty_id){
	swal({
		title: 'Are you sure?',
		text: "It will be deleted permanently!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					url: '{{ url('quotWarranty') }}' + '/' + warranty_id,
					type: 'DELETE',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							// id: warranty_id,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_product_' + warranty_id).parent().parent().remove();
				})
				.fail(function(){
					swal('Oops...', 'Something went wrong with ajax !', 'error');
				})
			});
		},
		allowOutsideClick: false			  
	})
	.then((result) => {
		if (result.dismiss === swal.DismissReason.cancel) {
			swal('Cancelled', 'Your data is safe from delete', 'info')
		}
	});
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// auto populate price/unit and change the price and the total price
$(document).on('change', '.itemprice', function () {
	selectedOption = $('option:selected', this);
	var retail = $(this).parent().parent().children().children('.priceunit');

	$(retail).val( selectedOption.data('price') );

	// calculate for total price of a section and grand total
	var quan = $(this).parent().parent().children().children('.quan');
	var price = $(this).parent().parent().children().children('.price');

	$(price).val( ( ( ($(quan).val() * 10) * ($(retail).val() * 10) )/100 ).toFixed(2) );

	// directly update totalprice
	var pri = $(this).parent().parent().parent().parent().parent().find('.price');
	var tp = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().children().children().children().children('.totalprice');

	// $(pri).css('border', 'solid 1px red');

	var myNodelistp1 = $(pri);
	var psum1 = 0;
	for (var ip1 = myNodelistp1.length - 1; ip1 >= 0; ip1--) {
		// myNodelistp1[ip1].style.backgroundColor = "red";

		psum1 = ((psum1 * 10000) + (myNodelistp1[ip1].value * 10000)) / 10000;
	}

	$(tp ).val( psum1.toFixed(2) );

	// update grand total
	update_grandtotal();
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// auto populate tax and change the tax value
$(document).on('change', '.tax', function () {
	selectedOption = $('option:selected', this);
	var tvalue = $(this).parent().parent().children().children('.taxvalue');

	$(tvalue).val( selectedOption.data('taxvalue') );
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// auto populate tax and change the tax value
$(document).on('change', '.gst', function () {
	selectedOption = $('option:selected', this);
	var gstval = $(this).parent().parent().children().children('.gstvalue');

	$(gstval).val( selectedOption.data('taxvalue') );

	// calculate the tax
	// update grand total
	update_grandtotal();
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// javascript calculation

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// calculating every row for a price
$(document).on('keyup', '.quan', function () {
	var unitprice = $(this).parent().parent().children().children('.priceunit');
	var price = $(this).parent().parent().children().children('.price');

	$(price).val( ( ( ($(this).val() * 10) * ($(unitprice).val() * 10) ) / 100).toFixed(2) );

	// directly update totalprice
	var pri = $(this).parent().parent().parent().parent().parent().find('.price');
	var tp = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().children().children().children().children('.totalprice');

	// $(pri).css('border', 'solid 1px red');

	var myNodelistp1 = $(pri);
	var psum1 = 0;
	for (var ip1 = myNodelistp1.length - 1; ip1 >= 0; ip1--) {
		// myNodelistp1[ip1].style.backgroundColor = "red";

		psum1 = ((psum1 * 10000) + (myNodelistp1[ip1].value * 10000)) / 10000;
	}

	$(tp ).val( psum1.toFixed(2) );

	// update grand total
	update_grandtotal();
});

$(document).on('keyup', '.priceunit', function () {
	var quan = $(this).parent().parent().children().children('.quan');
	var price = $(this).parent().parent().children().children('.price');

	$(price).val( ( ( ($(this).val() * 10) * ($(quan).val() * 10) ) / 100).toFixed(2) );

	// directly update totalprice
	var pri = $(this).parent().parent().parent().parent().parent().find('.price');
	var tp = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().children().children().children().children('.totalprice');

	// $(pri).css('border', 'solid 1px red');

	var myNodelistp1 = $(pri);
	var psum1 = 0;
	for (var ip1 = myNodelistp1.length - 1; ip1 >= 0; ip1--) {
		// myNodelistp1[ip1].style.backgroundColor = "red";

		psum1 = ((psum1 * 10000) + (myNodelistp1[ip1].value * 10000)) / 10000;
	}

	$(tp ).val( psum1.toFixed(2) );

	// update grand total
	update_grandtotal();
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// update discount
$(document).on('keyup', '#discount', function() {
	var dis = $('#discount').val();
	var gtt = $('#grandtotal' ).val();
	var disn = ((dis * 100) / 100) + ((gtt * 100) / 100);

	$('#netttotal').val( disn.toFixed(2) );
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// update tax
$(document).on('keyup', '#tax_value', function() {
	// update grand total
	update_grandtotal();
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// total price for each section
function update_grandtotal() {
	var myNodelistp = $(".totalprice");
	var psum = 0;
	for (var ip = myNodelistp.length - 1; ip >= 0; ip--) {
		// myNodelistp[ip].style.backgroundColor = "red";

		psum = ((psum * 10000) + (myNodelistp[ip].value * 10000)) / 10000;
	}

	var gstval = $('#tax_value').val();
	var ttg = ((gstval / 100) * psum) + psum;

	// $('#grandtotal' ).val( psum.toFixed(2) );
	$('#grandtotal' ).val( ttg.toFixed(2) );

	update_netttotal();
};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// nett price
function update_netttotal() {
	var dis = $('#discount').val();
	var gtt = $('#grandtotal' ).val();
	var disn = ((dis * 100) / 100) + ((gtt * 100) / 100);

	$('#netttotal').val( disn.toFixed(2) );
};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
// form validation
$('#form').bootstrapValidator({
	feedbackIcons: {
		valid: '',
		invalid: '',
		validating: ''
	},
	fields: {
		'date': {
			validators : {
				notEmpty: {
					message: 'Please insert date. '
				},
				date: {
					format: 'YYYY-MM-DD',
					message: 'The value is not a valid date. '
				},
			}
		},
		currency_id: {
			validators: {
				notEmpty: {
					message : 'Please choose. '
				}
			}
		},
		customer_id: {
			validators: {
				notEmpty: {
					message : 'Please choose. '
				}
			}
		},
		attn: {
			validators: {
				notEmpty: {
					message : 'Please insert Attention To. '
				}
			}
		},
		subject: {
			validators: {
				notEmpty: {
					message : 'Please insert Quotation Subject. '
				}
			}
		},
		description: {
			validators: {
				// notEmpty: {
				// 	message : 'Please insert Remarks. '
				// }
			}
		},
		tax_id: {
			validators: {
				// notEmpty: {
				// 	message: 'Please choose. '
				// },
			}
		},
		tax_value: {
			validators: {
				// notEmpty: {
				// 	message: 'Please choose. '
				// },
				numeric: {
					separator: '.',
					message: 'The value is not in decimal. ',
				},
			}
		},
		revision: {
			validators: {
				// notEmpty: {
				// 	message: 'Please choose. '
				// },
			}
		},
		revision_file: {
			validators: {
				notEmpty: {
					message: 'Please upload file. ',
				},
				file: {
					extension: 'pdf',
					type: 'application/pdf',
					maxSize: 7990272,   // 3264 * 2448
					message: 'The selected file is not valid'
				},
			}
		},
// section
@for($i1 = 1; $i1 <= 10; $i1++)
		'qs[{!! $i1 !!}][section]': {
			validators: {
				// notEmpty: {
				// 	message: 'Please insert Section Title. ',
				// },
			}
		},
	// item
	@for($i2 =1; $i2 <= 30; $i2++)
			'qs[{!! $i1 !!}][qssection][{!! $i2 !!}][item_id]' : {
				validators: {
					notEmpty: {
						message: 'Please insert value. ',
					},
				}
			},
			'qs[{!! $i1 !!}][qssection][{!! $i2 !!}][price_unit]' : {
				validators: {
					notEmpty: {
						message: 'Please insert value. ',
					},
					numeric: {
						separator: '.',
						message: 'The value is not in decimal. ',
					},
				}
			},
			'qs[{!! $i1 !!}][qssection][{!! $i2 !!}][description]' : {
				validators: {
					// notEmpty: {
					// 	message: 'Please insert value. ',
					// },
				}
			},
			'qs[{!! $i1 !!}][qssection][{!! $i2 !!}][tax_id]' : {
				validators: {
					// notEmpty: {
					// 	message: 'Please insert value. ',
					// },
				}
			},
			'qs[{!! $i1 !!}][qssection][{!! $i2 !!}][tax_value]' : {
				validators: {
					// notEmpty: {
					// 	message: 'Please insert value. ',
					// },
					numeric: {
						separator: '.',
						message: 'The value is not in decimal. ',
					},
				}
			},
			'qs[{!! $i1 !!}][qssection][{!! $i2 !!}][quantity]' : {
				validators: {
					notEmpty: {
						message: 'Please insert value. ',
					},
					numeric: {
						separator: '.',
						message: 'The value is not in decimal. ',
					},
				}
			},
			'qs[{!! $i1 !!}][qssection][{!! $i2 !!}][uom_id]' : {
				validators: {
					notEmpty: {
						message: 'Please choose. ',
					},
				}
			},
		// attribute
		@for($i3 =1; $i3 <= 10; $i3++)
				'qs[{!! $i1 !!}][qssection][{!! $i2 !!}][qsitem][{!! $i3 !!}][attribute_id]': {
					validators: {
						notEmpty: {
							message: 'Please choose. ',
						},
					}
				},
				'qs[{!! $i1 !!}][qssection][{!! $i2 !!}][qsitem][{!! $i3 !!}][description_attribute]': {
					validators: {
						// notEmpty: {
						// 	message: 'Please insert value. ',
						// },
					}
				},
				'qs[{!! $i1 !!}][qssection][{!! $i2 !!}][qsitem][{!! $i3 !!}][image]': {
					validators: {
						// notEmpty: {
						// 	message: 'Please insert value. ',
						// },
						file: {
							extension: 'jpeg,jpg,png,bmp',
							type: 'image/jpeg,image/png,image/bmp',
							maxSize: 7990272,   // 3264 * 2448
							message: 'The selected file is not valid'
						},
					}
				},
				'qs[{!! $i1 !!}][qssection][{!! $i2 !!}][qsitem][{!! $i3 !!}][remarks]': {
					validators: {
						// notEmpty: {
						// 	message: 'Please insert value. ',
						// },
					}
				},
		@endfor
	@endfor
@endfor

		'mutual': {
			// selecttor: 'mutual',
			container: '.mutu',		//container where to put the error message
			validators: {
				notEmpty: {
					message: 'Please choose. '
				},
			}
		},
		from: {
			validators: {
				notEmpty: {
					message: 'Please insert value. '
				},
				digits: {
					message: 'Invalid value, it must be a digit. '
				},
			}
		},
		to: {
			validators: {
				notEmpty: {
					message: 'Please insert value. '
				},
				digits: {
					message: 'Invalid value, it must be a digit. '
				},
			}
		},
		period_id: {
			validators: {
				notEmpty: {
					message: 'Please choose. '
				}
			}
		},
		validity: {
			validators: {
				notEmpty: {
					message: 'Please insert value. '
				},
				digits: {
					message: 'Invalid value, it must be a digit. '
				},
			}
		},
@for($i4=1; $i4<=10; $i4++)
		'qstop[{!! $i4 !!}][term_of_payment]': {
			validators: {
				notEmpty: {
					message: 'Please insert Terms Of Payment. '
				},
			}
		},
@endfor
@for($i5=1; $i5<=20; $i5++)
		'qsexclusions[{!! $i5 !!}][exclusion_id]': {
			validators: {
				notEmpty: {
					message: 'Please choose ',
				},
			}
		},
@endfor
@for($i6=1; $i6<=20; $i6++)
		'qsremark[{!! $i6 !!}][remark_id]': {
			validators: {
				notEmpty: {
					message: 'Please choose ',
				},
			}
		},
@endfor
@for($i7=1; $i7<=20; $i7++)
		'qsdealer[{!! $i7 !!}][dealer_id]': {
			validators: {
				notEmpty: {
					message: 'Please choose ',
				},
			}
		},
@endfor
		grandamount: {
			validators: {
				notEmpty: {
					message: 'Please insert Grand Amount. '
				}
			}
		},
		dealer_price: {
			validators: {
				numeric: {
					separator: '.',
					message: 'The value is in numeric with 2 decimal point. '
				}
			}
		},
		budget_quot: {
			validators: {
				// numeric: {
				// 	separator: '.',
				// 	message: 'The value is in numeric with 2 decimal point. '
				// }
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
});
/////////////////////////////////////////////////////////////////////////////////////////
@endsection

