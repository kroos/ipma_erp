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

			//	$qt1 = $qt->hasmanyquotsection()->create([
			//		'section' => $v1['section'],
			//	]);

				// dd($v1['qssection']);

				foreach($v1['qssection'] as $k2 => $v2){
				//	$qt2 = $qt1->hasmanyquotsectionitem()->create([
				//		'item_id' => $v2['item_id'],
				//		'price_unit' => $v2['price_unit'],
				//		'description' => $v2['description'],
				//		'quantity' => $v2['quantity'],
				//		'uom_id' => $v2['uom_id'],
				//		'tax_id' => $v2['tax_id'],
				//		'tax_value' => $v2['tax_value'],
				//	]);

					foreach ($v2['qsitem'] as $k3 => $v3) {

						// $request->qs[1]['qssection'][2]['qsitem'][2]['image']->store('public/images/quot');
						// $request->qs[$k1]['qssection'][$k2]['qsitem'][$k3]['image']->store('public/images/quot');
						// dd($request->file($v3['image']));
						// var_dump( $request->qs[$k1]['qssection'][$k2]['qsitem'][$k3] );
						// $request->qs[$k1]['qssection'][$k2]['qsitem'][$k3]['image']->store('public/images/quot');
						// dd($request->hasFile());
						// dd($request->file());
						// print_r($v3);
						// echo '<br />';
						// var_dump( file($v3[$k3]['image']) );
						// var_dump( $request->file("qs[".$k1."][qssection][".$k2."][qsitem][".$k3."]") );
						// if( !is_null($v3['image']) ) {
							// $request->qs[$k1]['qssection'][$k2]['qsitem'][$k3]->store('public/images/quot');
							// var_dump($request->qs[$k1]['qssection'][$k2]['qsitem'][$k3]->store('public/images/quot') );
							echo '<br />';
						// }
						echo '<br />';
						echo '<br />';

						var_dump($v3);

						// if( !is_null($v3['image']) ) {
						// var_dump($v3['image']).'after if<br/>';
						// }

				//		if($request->file()) {
				//			$filename = $v3->file('image')->store('public/images/quot');

				//			$ass1 = explode('/', $filename);
				//			$ass2 = array_except($ass1, ['0']);
				//			$image = implode('/', $ass2);

				//			// dd($image);

				//			$imag = Image::make(storage_path('app/'.$filename));

				//			// resize the image to a height of 400 and constrain aspect ratio (auto width)
				//			$imag->resize(NULL, 400, function ($constraint) {
				//				$constraint->aspectRatio();
				//			});

				//			$imag->save();
				//			// dd( array_add($request->except(['image']), 'image', $filename) );

				//			// $u->update(['image' => $image]);
				//		}

					//	$qt3 = $qt2->hasmanyquotsectionitemattrib()->create([
					//		'attribute_id' => $v3['attribute_id'],
					//		'description_attribute' => $v3['description_attribute'],
					//		'remarks' => $v3['remarks'],
					//		// 'image' => $image,
					//	]);

					}
				}
			}
		}

	//	if($request->has('qstop')) {
	//		foreach ($request->qstop as $k4 => $v4) {
	//			$qt->hasmanytermofpayment()->create([
	//				'term_of_payment' => $v4['term_of_payment'],
	//			]);
	//		}
	//	}

	//	if($request->has('qsexclusions')) {
	//		foreach ($request->qsexclusions as $k5 => $v5) {
	//			$qt->hasmanyexclusions()->create([
	//				'exclusion_id' => $v5['exclusion_id'],
	//			]);
	//		}
	//	}

	//	if($request->has('qsremark')) {
	//		foreach ($request->qsremark as $k6 => $v6) {
	//			$qt->hasmanyremarks()->create([
	//				'remark_id' => $v6['remark_id'],
	//			]);
	//		}
	//	}

		// Session::flash('flash_message', 'Data successfully stored!');
		// return redirect(route('quot.index'));
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
