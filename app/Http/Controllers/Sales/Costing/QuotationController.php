<?php

namespace App\Http\Controllers\Sales\Costing;

// load model
use \App\Model\QuotQuotation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// load image library
use Intervention\Image\ImageManagerStatic as Image;

class QuotationController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('marketingAndBusinessDevelopment.costing.quotation.index');
	}

	public function create()
	{
		return view('marketingAndBusinessDevelopment.costing.quotation.create');
	}

	public function store(Request $request)
	{
		// dd($request->all());
		$qt = \Auth::user()->belongtostaff->hasmanyquotation()->create( array_add($request->only(['date', 'currency_id', 'customer_id', 'attn', 'subject', 'description', 'grandamount', 'tax_id', 'tax_value', 'from', 'to', 'period_id', 'validity']), 'active', 1) );

		if ($request->has('qs')) {
			foreach ($request->qs as $k1 => $v1) {

				$qt1 = $qt->hasmanyquotsection()->create([
					'section' => $v1['section'],
				]);

				// dd($v1['qssection']);

				foreach($v1['qssection'] as $k2 => $v2){
					$qt2 = $qt1->hasmanyquotsectionitem()->create([
						'item_id' => $v2['item_id'],
						'price_unit' => $v2['price_unit'],
						'description' => $v2['description'],
						'quantity' => $v2['quantity'],
						'uom_id' => $v2['uom_id'],
						'tax_id' => $v2['tax_id'],
						'tax_value' => $v2['tax_value'],
					]);

					foreach ($v2['qsitem'] as $k3 => $v3) {

						// if(!empty($request->file('image'))) {
							$filename = $v3['image']->file('image')->store('public/images/quot');

							$ass1 = explode('/', $filename);
							$ass2 = array_except($ass1, ['0']);
							$image = implode('/', $ass2);

							// dd($image);

							$imag = Image::make(storage_path('app/'.$filename));

							// resize the image to a height of 400 and constrain aspect ratio (auto width)
							$imag->resize(NULL, 400, function ($constraint) {
								$constraint->aspectRatio();
							});

							$imag->save();
							// dd( array_add($request->except(['image']), 'image', $filename) );

							// $u->update(['image' => $image]);

						$qt3 = $qt2->hasmanyquotsectionitemattrib()->create([
							'attribute_id' => $v3['attribute_id'],
							'description_attribute' => $v3['description_attribute'],
							'remarks' => $v3['remarks'],
							'image' => $image,
						]);

					}
				}
			}
		}

		if($request->has('qstop')) {
			foreach ($request->qstop as $k4 => $v4) {
				$qt->hasmanytermofpayment()->create([
					'term_of_payment' => $v4['term_of_payment'],
				]);
			}
		}

		if($request->has('qsexclusions')) {
			foreach ($request->qstop as $k4 => $v4) {
				$qt->hasmanytermofpayment()->create([
					'exclusion_id' => $v4['exclusion_id'],
				]);
			}
		}

		if($request->has('qsremark')) {
			foreach ($request->qstop as $k4 => $v4) {
				$qt->hasmanytermofpayment()->create([
					'remark_id' => $v4['remark_id'],
				]);
			}
		}

		Session::flash('flash_message', 'Data successfully stored!');
		return redirect(route('quot.index'));
	}

	public function show(QuotQuotation $quot)
	{
		//
	}

	public function edit(QuotQuotation $quot)
	{
		//
	}

	public function update(Request $request, QuotQuotation $quot)
	{
		//
	}

	public function destroy(QuotQuotation $quot)
	{
		//
	}
}
