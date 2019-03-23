			'<div class="attrib_row">' +
				'<div class="row col-9 offset-1">' +
					'<div class="col-1 text-danger attrib_remove" id="attrib_remove_' + xs + '_' + xi + '_' + xia + '" data-id="' + xia + '">' +
						'<i class="fas fa-trash" aria-hidden="true"></i>' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.qsitem.*.attribute_id') ? 'has-error' : '' }}">' +
						'<select name="qs[' + xs + '][qssection][' + xi + '][qsitem][' + xia + '][attribute_id]" id="attrib_id_' + xs + '_' + xi + '_' + xia + '" class="form-control form-control-sm" autocomplete="off" placeholder="Please choose">' +
							'<option value="">Please choose</option>' +
@foreach(\App\Model\QuotItemAttribute::all() as $attrib)
							'<option value="{!! $attrib->id !!}" >{!! $attrib->attribute !!}</option>' +
@endforeach
						'</select>' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.qsitem.*.description_attribute') ? 'has-error' : '' }}">' +
						'<input type="text" name="qs[' + xs + '][qssection][' + xi + '][qsitem][' + xia + '][description_attribute]" id="description_attribute_' + xs + '_' + xi + '_' + xia + '" class="form-control form-control-sm" placeholder="Description">' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.qsitem.*.remarks') ? 'has-error' : '' }}">' +
						'<input type="text" name="qs[' + xs + '][qssection][' + xi + '][qsitem][' + xia + '][remarks]" id="remarks_' + xs + '_' + xi + '_' + xia + '" class="form-control form-control-sm" placeholder="Remarks">' +
					'</div>' +
				'</div>' +
			'</div>' +



	if(xia < max_items_attrib){
		xia++;
		$(item_attrib_wrapper).append(

'<p>test</p>'

		);		// add input box

		// select 2
		$( '' ).select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});

		//bootstrap validate
		// $('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][attribute_id]"]'));
		// $('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][description_attribute]"]'));
		// $('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + section_id + '][qssection][' + item_id + '][qsitem][' + xia + '][remarks]"]'));
	}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// add more rows on item
var max_items	= 50; //maximum input boxes allowed
var xi = 0;

$(".item_add").click(function(){
	var item_wrapper = $(this).parent().children().children().children('.item_wrap');		// .css('border', 'solid 1px red');

	if(xi < max_items){
		xi++;
		$(item_wrapper).append(

			'<div class="item_row">' +
				'<div class="form-row col-12">' +
					'<div class="col-1 text-danger item_remove" id="item_remove_' + xs + '_' + xi + '" data-itemid="' + xi + '">' +
							'<i class="fas fa-trash" aria-hidden="true"></i>' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.item_id') ? 'has-error' : '' }}">' +
						'<select name="qs[' + xs + '][qssection][' + xi + '][item_id]" id="item_' + xs + '_' + xi + '" class="form-control form-control-sm" autocomplete="off" placeholder="Please choose">' +
							'<option value="">Please choose</option>' +
@foreach(\App\Model\QuotItem::where('active', 1)->get() as $item)
							'<option value="{!! $item->id !!}" data-price="{!! $item->price !!}">{!! $item->item !!}</option>' +
@endforeach
						'</select>' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.price_unit') ? 'has-error' : '' }}">' +
						'<input type="text" name="qs[' + xs + '][qssection][' + xi + '][price_unit]" id="price_unit_' + xs + '_' + xi + '" class="form-control form-control-sm" placeholder="Price/Unit">' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.description') ? 'has-error' : '' }}">' +
						'<textarea name="qs[' + xs + '][qssection][' + xi + '][description]" id="remarks_' + xs + '_' + xi + '" class="form-control form-control-sm" placeholder="Remarks"></textarea>' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.tax_id') ? 'has-error' : '' }}">' +
						'<select type="text" name="qs[' + xs + '][qssection][' + xi + '][tax_id]" value="" id="tax_id_' + xs + '_' + xi + '" class="form-control form-control-sm" autocomplete="off" placeholder="Please choose" >' +
							'<option value="">Please choose</option>' +
@foreach(\App\Model\Tax::all() as $tax)
							'<option value="{!! $tax->id !!}" data-value="">{!! $tax->tax !!}</option>' +
@endforeach
						'</select>' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.tax_value') ? 'has-error' : '' }}">' +
						'<input type="text" name="qs[' + xs + '][qssection][' + xi + '][tax_value]" value="" id="tax_value_' + xs + '_' + xi + '" class="form-control form-control-sm" autocomplete="off" placeholder="Text Value" />' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.quantity') ? 'has-error' : '' }}">' +
						'<input type="text" name="qs[' + xs + '][qssection][' + xi + '][quantity]" value="" id="quantity_' + xs + '_' + xi + '" class="form-control form-control-sm" autocomplete="off" placeholder="Quantity" />' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.uom_id') ? 'has-error' : '' }}">' +
						'<select name="qs[' + xs + '][qssection][' + xi + '][uom_id]" id="uom_id_' + xs + '_' + xi + '" class="form-control form-control-sm" autocomplete="off" placeholder="Please choose">' +
							'<option value="">Please choose</option>' +
@foreach(\App\Model\QuotUOM::all() as $uom)
							'<option value="{!! $uom->id !!}" >{!! $uom->uom !!}</option>' +
@endforeach
						'</select>' +
					'</div>' +
					'<div class="form-group col">' +
						'<p><span class="total_price">0.00</span></p>' +
					'</div>' +
				'</div>' +
				'<div class="col attrib_wrap">' +




				'</div>' +
				'<div class="row col-2 attrib_add">' +
					'<p class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Item Attribute</p>' +
				'</div>' +
			'</div>'

		);		// add input box

		//bootstrap validate
		// $('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + xs + '][qssection][' + xi + '][item_id]"]'));
	}
});

$(".item_remove").click(function(e){
	var item_id = $(this).data('id');
	//user click on remove item
	e.preventDefault();
	var $row = $(this).parent().parent();
	var $option1 = $row.find('[name="qs[' + xs + '][qssection][' + item_id + '][item_id]"]');
	// $row.remove();
	$row.css('border', 'solid 1px red');

	// $('#form').bootstrapValidator('removeField', $option1);
	// console.log(xi);
	xi--;
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







	if(xi < max_items){
		xi++;
		$(item_wrapper).append(

			'<div class="item_row">' +
				'<div class="form-row col-12">' +
					'<div class="col-1 text-danger item_remove" id="item_remove_' + xs + '_' + xi + '" data-itemid="' + xi + '">' +
							'<i class="fas fa-trash" aria-hidden="true"></i>' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.item_id') ? 'has-error' : '' }}">' +
						'<select name="qs[' + xs + '][qssection][' + xi + '][item_id]" id="item_' + xs + '_' + xi + '" class="form-control form-control-sm" autocomplete="off" placeholder="Please choose">' +
							'<option value="">Please choose</option>' +
@foreach(\App\Model\QuotItem::where('active', 1)->get() as $item)
							'<option value="{!! $item->id !!}" data-price="{!! $item->price !!}">{!! $item->item !!}</option>' +
@endforeach
						'</select>' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.price_unit') ? 'has-error' : '' }}">' +
						'<input type="text" name="qs[' + xs + '][qssection][' + xi + '][price_unit]" id="price_unit_' + xs + '_' + xi + '" class="form-control form-control-sm" placeholder="Price/Unit">' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.description') ? 'has-error' : '' }}">' +
						'<textarea name="qs[' + xs + '][qssection][' + xi + '][description]" id="remarks_' + xs + '_' + xi + '" class="form-control form-control-sm" placeholder="Remarks"></textarea>' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.tax_id') ? 'has-error' : '' }}">' +
						'<select type="text" name="qs[' + xs + '][qssection][' + xi + '][tax_id]" value="" id="tax_id_' + xs + '_' + xi + '" class="form-control form-control-sm" autocomplete="off" placeholder="Please choose" >' +
							'<option value="">Please choose</option>' +
@foreach(\App\Model\Tax::all() as $tax)
							'<option value="{!! $tax->id !!}" data-value="">{!! $tax->tax !!}</option>' +
@endforeach
						'</select>' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.tax_value') ? 'has-error' : '' }}">' +
						'<input type="text" name="qs[' + xs + '][qssection][' + xi + '][tax_value]" value="" id="tax_value_' + xs + '_' + xi + '" class="form-control form-control-sm" autocomplete="off" placeholder="Text Value" />' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.quantity') ? 'has-error' : '' }}">' +
						'<input type="text" name="qs[' + xs + '][qssection][' + xi + '][quantity]" value="" id="quantity_' + xs + '_' + xi + '" class="form-control form-control-sm" autocomplete="off" placeholder="Quantity" />' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('qs.*.qssection.*.uom_id') ? 'has-error' : '' }}">' +
						'<select name="qs[' + xs + '][qssection][' + xi + '][uom_id]" id="uom_id_' + xs + '_' + xi + '" class="form-control form-control-sm" autocomplete="off" placeholder="Please choose">' +
							'<option value="">Please choose</option>' +
@foreach(\App\Model\QuotUOM::all() as $uom)
							'<option value="{!! $uom->id !!}" >{!! $uom->uom !!}</option>' +
@endforeach
						'</select>' +
					'</div>' +
					'<div class="form-group col">' +
						'<p><span class="total_price">0.00</span></p>' +
					'</div>' +
				'</div>' +
				'<div class="col attrib_wrap">' +




				'</div>' +
				'<div class="row col-2 attrib_add">' +
					'<p class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Item Attribute</p>' +
				'</div>' +
			'</div>'

		);		// add input box

		//bootstrap validate
		// $('#form').bootstrapValidator('addField',$('.item_row').find('[name="qs[' + xs + '][qssection][' + xi + '][item_id]"]'));
	}