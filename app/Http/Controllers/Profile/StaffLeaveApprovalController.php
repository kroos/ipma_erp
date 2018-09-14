<?php

namespace App\Http\Controllers\Profile;

// to link back from controller original
use App\Http\Controllers\Controller;

// load model
use App\Model\StaffLeaveApproval;

use Illuminate\Http\Request;

use \Carbon\Carbon;

// load validation
// use App\Http\Requests\StaffLeaveApprovalRequest;

// for manipulating image
// http://image.intervention.io/
// use Intervention\Image\Facades\Image as Image;       <-- ajaran sesat depa... hareeyyyyy!!
// use Intervention\Image\ImageManagerStatic as Image;

use Session;

class StaffLeaveApprovalController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
		// $this->middleware('userown', ['only' => ['show', 'edit', 'update']]);
	}
	
	public function index()
	{
		return view('staffLeaveApproval.index');
	}

	public function create()
	{
	}

	public function store(Request $request)
	{
	}

	public function show(StaffLeaveApproval $staffLeaveApproval)
	{
	}

	public function edit(StaffLeaveApproval $staffLeaveApproval)
	{
	}

	public function update(Request $request, StaffLeaveApproval $staffLeaveApproval)
	{
		// for HOD at the moment
		echo $staffLeaveApproval.' request all<br />';
		print_r( $request->all() );
		echo '<br />';

		// lets check who submit this form
		echo $staffLeaveApproval->hr.' hr is null if submitter is HOD<br />';

		if ( is_null($staffLeaveApproval->hr) ) { //definitely HOD

			// 2 conditions, 1. approve -> proceed with the process. 2. reject, got 2 condition a) check date leave for user cos HOD cant deduct the leave b) if date leave is in the future, deduct the leave

			if ( $request->approval == 1 ) { // approval approve
				$updHOD = \Auth::user()->belongtostaff->hasmanystaffleaveapproval()->where('id', $staffLeaveApproval->id)->update( $request->except(['_method', '_token']) );
			} else { // approval reject

				//kena check date cuti, bukan date cuti apply. check sebelum atau selepas.
				$n = \Auth::user()->belongtostaff->hasmanystaffleaveapproval()->where('id', $staffLeaveApproval->id )->first()->belongtostaffleave;

				echo $n.' date time start<br />'; // StaffLeave Model

				$dts = Carbon::parse( $n->date_time_start );
				$now = Carbon::now();
				 // date dah lepas atau belum?
				if( $now->lte( $dts ) ) { // date BELUM lepas

					echo ' belum lps<br />';

					// jom cari leave type, jenis yg boleh tolak shj : al, mc, el-al, el-mc, nrl, ml
					echo $n->leave_id.' leave type<br />';
					// if (  ) { // leave deduct from 
					// }

die();
				} else { // date dah LEPAS.. HOD hanya approve atau reject tapi tak boleh deduct leave

					echo ' dah lepas<br />';
					// jom reject walau dah cuti w/o deduct leave
					$updHOD = \Auth::user()->belongtostaff->hasmanystaffleaveapproval()->where('id', $staffLeaveApproval->id)->update( $request->except(['_method', '_token']) );
				}
				Session::flash('flash_message', 'Data successfully edited!');
				return redirect( route('staffLeaveApproval.index') );
			}
		} else { // this is hr cos its 1
		}
	}

	public function destroy(StaffLeaveApproval $staffLeaveApproval)
	{
	}
}
