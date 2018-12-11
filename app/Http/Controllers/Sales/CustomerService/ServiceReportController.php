<?php

namespace App\Http\Controllers\Sales\CustomerService;

use App\Http\Controllers\Controller;

// load model
use App\Model\ICSServiceReport;
use App\Model\ICSFloatthConstant;

use Illuminate\Http\Request;

use Session;
use \Carbon\Carbon;
use \Carbon\CarbonPeriod;

class ServiceReportController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('marketingAndBusinessDevelopment.customerservice.ics.index');
	}

	public function create()
	{
		return view('marketingAndBusinessDevelopment.customerservice.ics.create');
	}

	public function store(Request $request)
	{
		print_r($request->all());
		$sr = \Auth::user()->belongtostaff->hasmanyservicereport()->create(
			array_add($request->only(['date', 'charge_id', 'customer_id', 'inform_by', 'remarks']), 'active', 1)
		);

		$sr->hasmanycomplaint()->create( $request->only(['complaint', 'complaint_by']) );

		if ($request->has('serial')) {
			$sr->hasmanyserial()->create( $request->only(['serial']) );
		}
		// $sr->hasmanyattendees()->create( $request->only('sr') );

		// attendees
		if ($request->has('sr')) {
			foreach( $request->sr as $key => $val ) {
				$sr->hasmanyattendees()->create([
					'attended_by' => $val['attended_by']
				]);
			}
		}
		Session::flash('flash_message', 'Data successfully stored!');
		return redirect( route('serviceReport.index') );
	}

	public function show(ICSServiceReport $serviceReport)
	{
		return view('marketingAndBusinessDevelopment.customerservice.ics.show', compact(['serviceReport']));
	}

	public function edit(ICSServiceReport $serviceReport)
	{
		return view('marketingAndBusinessDevelopment.customerservice.ics.edit', compact(['serviceReport']));
	}

	public function update(Request $request, ICSServiceReport $serviceReport)
	{
		// print_r($request->all());
		// echo '<br />';

		$serviceReport->update( array_add($request->only(['date', 'charge_id', 'customer_id', 'proceed_id', 'reamrks']), 'updated_by', \Auth::user()->belongtostaff->id) );

		// serial
		if ($request->has('srs')) {
			$serviceReport->hasmanyserial()->delete();
			foreach( $request->srs as $key => $val ) {
				$serviceReport->hasmanyserial()->create([
					'serial' => $val['serial']
				]);
			}
		}

		// attendees
		if ($request->has('sr')) {
			$serviceReport->hasmanyattendees()->delete();
			foreach( $request->sr as $key => $val ) {
				$serviceReport->hasmanyattendees()->create([
					'attended_by' => $val['attended_by']
				]);
			}
		}

		// complaints
		if ($request->has(['complaint', 'complaint_by'])) {
			$serviceReport->hasmanycomplaint()->delete();
				$serviceReport->hasmanycomplaint()->create($request->only(['complaint', 'complaint_by']));
		}

		// model
		if ($request->has('srmo')) {
			$serviceReport->hasmanymodel()->delete();
			foreach( $request->srmo as $key => $val ) {
				$serviceReport->hasmanymodel()->create([
					'model_id' => $val['model_id'],
					'test_run_machine' => $val['test_run_machine'],
					'serial_no' => $val['serial_no'],
					'test_capacity' => $val['test_capacity'],
					'duration' => $val['duration'],
				]);
			}
		}

		// part accessory
		if ($request->has('srp')) {
			$serviceReport->hasmanypart()->delete();
			foreach( $request->srp as $key => $val ) {
				$serviceReport->hasmanypart()->create([
					'part_accessory' => $val['part_accessory'],
					'qty' => $val['qty'],
				]);
			}
		}

		// job performed
		if ($request->has('srj')) {
			$floatth = ICSFloatthConstant::where('active', 1)->first();
			foreach ($serviceReport->hasmanyjob()->get() as $key) {
				$key->hasmanysrjobdetail()->delete();
			}
			$serviceReport->hasmanyjob()->delete();
			foreach( $request->srj as $key => $val ) {
				if ( is_null($val['working_time_start']) ) {
					$wts = NULL;
				} else {
					$wts = Carbon::parse($val['working_time_start'])->format('H:i:s');
				}
				if ( is_null($val['working_time_end']) ) {
					$wte = NULL;
				} else {
					$wte = Carbon::parse($val['working_time_end'])->format('H:i:s');
				}
				$srjnull = $serviceReport->hasmanyjob()->create([
					'date' => $val['date'],
					'labour' => $val['labour'],
					'job_perform' => $val['job_perform'],
					'working_time_start' => $wts,
					'working_time_end' => $wte,
					'food_rate' => $val['food_rate'],
					'labour_leader' => $val['labour_leader'],
					'labour_non_leader' => $val['labour_non_leader'],
					'working_type_value' => $val['working_type_value'],
					'overtime_hour' => $val['overtime_hour'],
					'accommodation_rate' => $val['accommodation_rate'],
					'accommodation' => $val['accommodation'],
					'travel_hour' => $val['travel_hour'],
					'overtime_constant_1' => $floatth->overtime_constant_1,
					'overtime_constant_2' => $floatth->overtime_constant_2,
					'travel_meter_rate' => $floatth->travel_meter_rate,
					'travel_hour_constant' => $floatth->travel_hour_constant,
				]);
					foreach($val['srjde'] as $k => $v) {
						if( is_null($v['time_start']) ) {		// checking for NULL time
							$ts = NULL;
						} else {
							$ts = Carbon::parse($v['time_start'])->format('H:i:s');
						}
						if(is_null($v['time_end'])) {
							$te = NULL;
						} else {
							$te = Carbon::parse($v['time_end'])->format('H:i:s');
						}
						echo $v['destination_start'].' '.$v['destination_end'].' '.$v['meter_start'].' '.$v['meter_end'].' '.$ts.' '.$te.' '.$v['return'].' srjde<br />';

						$srjnull->hasmanysrjobdetail()->create([
							'destination_start' => $v['destination_start'],
							'destination_end' => $v['destination_end'],
							'meter_start' => $v['meter_start'],
							'meter_end' => $v['meter_end'],
							'time_start' => $ts,
							'time_end' => $te,
							'return' => $v['return'],
						]);
					}
			}
		}

		// logistic
		if ($request->has('srL')) {
			$serviceReport->hasmanylogistic()->delete();
			foreach($request->srL as $L => $kl) {
				$serviceReport->hasmanylogistic()->create([
					'vehicle_id' => $kl['vehicle_id'],
					'description' => $kl['description'],
					'charge' => $kl['charge'],
				]);
			}
		}

		// additional charges
		if ($request->has('srAC')) {
			$serviceReport->hasmanyadditionalcharge()->delete();
			foreach($request->srAC as $ac => $kac) {
				$serviceReport->hasmanyadditionalcharge()->create([
					'amount_id' => $kac['amount_id'],
					'description' => $kac['description'],
					'value' => $kac['value'],
				]);
			}
		}

		// discount
		if ($request->has('srDisc')) {
			$serviceReport->hasonediscount()->delete();
			foreach($request->srDisc as $di => $kdi) {
				$serviceReport->hasonediscount()->create([
					'discount_id' => $kdi['discount_id'],
					'value' => $kdi['value'],
				]);
			}
		}

		// feedback problem
		if ($request->has('srfP')) {
			$serviceReport->hasmanyfeedproblem()->delete();
			foreach($request->srfP as $fp => $kfP) {
				$serviceReport->hasmanyfeedproblem()->create([
					'problem' => $kfP['problem'],
					'solution' => $kfP['solution'],
				]);
			}
		}

		// feedback request
		if ($request->has('srfR')) {
			$serviceReport->hasmanyfeedrequest()->delete();
			foreach($request->srfR as $fr => $kfR) {
				$serviceReport->hasmanyfeedrequest()->create([
					'request' => $kfR['request'],
					'action' => $kfR['action'],
				]);
			}
		}

		// feedback item
		if ($request->has('srfI')) {
			$serviceReport->hasmanyfeeditem()->delete();
			foreach($request->srfI as $fi => $kfI) {
				$serviceReport->hasmanyfeeditem()->create([
					'item' => $kfI['item'],
					'quantity' => $kfI['quantity'],
					'item_action' => $kfI['item_action'],
				]);
			}
		}

		// feedback
		if ($request->has(['new_machine', 'building_expansion', 'problem_at_client_site'])) {
			$serviceReport->hasmanyfeedback()->delete();
			$serviceReport->hasmanyfeedback()->create( $request->only(['new_machine', 'building_expansion', 'problem_at_client_site']) );
		}

		Session::flash('flash_message', 'Data successfully edited!');
		return redirect( route('serviceReport.index') );
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////
	// addition
	// update approval
	public function updateApproveSR(Request $request, ICSServiceReport $serviceReport) {
		// \Auth::user()->belongtostaff->hasmanysrapproval()->update(['id' => $serviceReport->id], []);
		$serviceReport->update(['approved_by' => \Auth::user()->belongtostaff->id]);

		return response()->json([
			'message' => 'Service Report Approve',
			'status' => 'success'
		]);
	}

	// update approval
	public function updatecheckSR(Request $request, ICSServiceReport $serviceReport) {
		// \Auth::user()->belongtostaff->hasmanysrapproval()->update(['id' => $serviceReport->id], []);
		$serviceReport->update(['approved_by' => \Auth::user()->belongtostaff->id]);

		return response()->json([
			'message' => 'Service Report Approve',
			'status' => 'success'
		]);
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////
	public function destroy(ICSServiceReport $serviceReport)
	{
	//
	}
}
