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

				echo $n.' StaffLeave Model<br />'; // StaffLeave Model
				echo $n->date_time_start.' date time start<br />';
// die();

				$dts = Carbon::parse( $n->date_time_start );
				$now = Carbon::now();
				 // date dah lepas atau belum?
				if( $now->lte( $dts ) ) { // date BELUM lepas

					echo ' belum lps<br />';

					// jom cari leave type, jenis yg boleh tolak shj : al, mc, el-al, el-mc, nrl, ml
					echo $n->leave_id.' leave type<br />';


					if ( $n->leave_id == 1 || $n->leave_id == 5 ) { // leave deduct from AL or EL-AL
						echo 'leave deduct from AL<br />';

						// cari al dari staffleave dan tambah balik masuk dalam staffanualmcmaternityleave

						// cari period cuti
						echo $n->period.' period cuti<br />';

						// cari al dari applicant, year yg sama dgn date apply cuti.
						echo $n->belongtostaff->hasmanystaffannualmcleave()->where('year', $dts->format('Y'))->first()->annual_leave_balance.' applicant annual leave balance<br />';

						$addl = $n->period + $n->belongtostaff->hasmanystaffannualmcleave()->where('year', $dts->format('Y'))->first()->annual_leave_balance;
						echo $addl.' masukkan dalam annual balance<br />';

						// find all approval
						echo $n->hasmanystaffapproval()->get().'find all approval<br />';

						echo \Auth::user()->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first()->position.' position <br />';
						echo \Auth::user()->belongtostaff->name.' position <br />';

						// update the al balance
						$n->belongtostaff->hasmanystaffannualmcleave()->where('year', $dts->format('Y'))->update([
							'annual_leave_balance' => $addl,
							'remarks' => 'Rejected By '.\Auth::user()->belongtostaff->name
						]);
						// update period, status leave of the applicant. status close by HOD/supervisor
						$n->update(['period' => 0, 'active' => 4, 'remarks' => 'Rejected By '.\Auth::user()->belongtostaff->name]);
						// update status for all approval
						$n->hasmanystaffapproval()->where('id', $staffLeaveApproval->id)->update( $request->except(['_method', '_token']) );
						// HR part.. x payah kot nak update kat sini..
						// $n->hasmanystaffapproval()->where('id', '<>',  $staffLeaveApproval->id)->update( $request->except(['_method', '_token', 'approval']) );
					}

					if( $n->leave_id == 2 || $n->leave_id == 11 ) { // leave deduct from MC or MC-UPL
						echo 'leave deduct from MC<br />';

						// sama lebih kurang AL mcm kat atas. so....
						$addl = $n->period + $n->belongtostaff->hasmanystaffannualmcleave()->where('year', $dts->format('Y'))->first()->medical_leave_balance;

						// update the al balance
						$n->belongtostaff->hasmanystaffannualmcleave()->where('year', $dts->format('Y'))->update([
							'medical_leave_balance' => $addl,
							'remarks' => 'Rejected By '.\Auth::user()->belongtostaff->name
						]);
						// update period, status leave of the applicant. status close by HOD/supervisor
						$n->update(['period' => 0, 'active' => 4, 'remarks' => 'Rejected By '.\Auth::user()->belongtostaff->name]);
						// update status for all approval
						$n->hasmanystaffapproval()->where('id', $staffLeaveApproval->id)->update( $request->except(['_method', '_token']) );
						// HR part.. x payah kot nak update kat sini..
						// $n->hasmanystaffapproval()->where('id', '<>',  $staffLeaveApproval->id)->update( $request->except(['_method', '_token', 'approval']) );
					}

					if( $n->leave_id == 3 || $n->leave_id == 6 ) { // leave deduct from UPL or EL-UPL
						echo 'leave deduct from UPL<br />';

						// process a bit different from al and mc
						// we can ignore all the data in staffannualmcmaternity mode. just take care all the things in staff leaves only.
						// make period 0 again, regardsless of the ttotal period and then update as al and mc.
						// update period, status leave of the applicant. status close by HOD/supervisor
						$n->update(['period' => 0, 'active' => 4, 'remarks' => 'Rejected By '.\Auth::user()->belongtostaff->name]);
						// update status for all approval
						$n->hasmanystaffapproval()->where('id', $staffLeaveApproval->id)->update( $request->except(['_method', '_token']) );
						// HR part.. x payah kot nak update kat sini..
						// $n->hasmanystaffapproval()->where('id', '<>',  $staffLeaveApproval->id)->update( $request->except(['_method', '_token', 'approval']) );
					}

					if( $n->leave_id == 4 ) { // leave deduct from NRL
						echo 'leave deduct from NRL<br />';

						// cari period cuti
						echo $n->period.' period cuti<br />';

						echo $n->hasmanystaffleavereplacement()->first().' staffleavereplacement model<br />';
						// hati2 pasai ada 2 kes dgn period, full and half day
						// kena update balik di staffleavereplacement model utk return back period.
						// period campur balik dgn leave utilize (2 table berbeza)
						echo $n->hasmanystaffleavereplacement()->first()->leave_utilize.' leave utilize<br />';
						echo $n->hasmanystaffleavereplacement()->first()->leave_total.' leave total<br />';

						// untuk update di column leave_balance
						$addr = $n->hasmanystaffleavereplacement()->first()->leave_total - $n->period;
						echo $addr.' untuk update kat column staff_leave_replacement.leave_utilize<br />';

						// update di table staffleavereplcaement. remarks kata sapa reject
						$n->hasmanystaffleavereplacement()->update([
							'staff_leave_id' => NULL,
							'leave_balance' => $n->period,
							'leave_utilize' => $addr,
							'remarks' => 'Rejected by '.\Auth::user()->belongtostaff->name
						]);
						// update di table staff leave pulokk staffleave
						$n->update(['period' => 0, 'active' => 4, 'remarks' => 'Rejected By '.\Auth::user()->belongtostaff->name]);
						// update status for all approval
						$n->hasmanystaffapproval()->where('id', $staffLeaveApproval->id)->update( $request->except(['_method', '_token']) );
						// HR part.. x payah kot nak update kat sini..
						// $n->hasmanystaffapproval()->where('id', '<>',  $staffLeaveApproval->id)->update( $request->except(['_method', '_token', 'approval']) );
					}

					if( $n->leave_id == 7 ) { // leave deduct from ML
						echo 'leave deduct from ML<br />';

						// lebih kurang sama dengan al atau mc, maka..... :) copy paste
						// cari period cuti
						echo $n->period.' period cuti<br />';

						// cari al dari applicant, year yg sama dgn date apply cuti.
						echo $n->belongtostaff->hasmanystaffannualmcleave()->where('year', $dts->format('Y'))->first()->maternity_leave_balance.' applicant maternity leave balance<br />';

						$addl = $n->period + $n->belongtostaff->hasmanystaffannualmcleave()->where('year', $dts->format('Y'))->first()->maternity_leave_balance;
						echo $addl.' masukkan dalam annual balance<br />';

						// find all approval
						echo $n->hasmanystaffapproval()->get().'find all approval<br />';

						echo \Auth::user()->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first()->position.' position <br />';
						echo \Auth::user()->belongtostaff->name.' position <br />';

						// update the al balance
						$n->belongtostaff->hasmanystaffannualmcleave()->where('year', $dts->format('Y'))->update([
							'maternity_leave_balance' => $addl,
							'remarks' => 'Rejected By '.\Auth::user()->belongtostaff->name
						]);
						// update period, status leave of the applicant. status close by HOD/supervisor
						$n->update(['period' => 0, 'active' => 4, 'remarks' => 'Rejected By '.\Auth::user()->belongtostaff->name]);
						// update status for all approval
						$n->hasmanystaffapproval()->where('id', $staffLeaveApproval->id)->update( $request->except(['_method', '_token']) );
						// HR part.. x payah kot nak update kat sini..
						// $n->hasmanystaffapproval()->where('id', '<>',  $staffLeaveApproval->id)->update( $request->except(['_method', '_token', 'approval']) );
					}

					if( $n->leave_id == 9 ) { // leave deduct from TF
						echo 'leave deduct from TF<br />';

						// dekat dekat nak sama dgn UPL, maka... :P copy paste

						// process a bit different from al and mc
						// we can ignore all the data in staffannualmcmaternity mode. just take care all the things in staff leaves only.
						// make period 0 again, regardsless of the ttotal period and then update as al and mc.
						// update period, status leave of the applicant. status close by HOD/supervisor
						$n->update(['period' => 0, 'active' => 4, 'remarks' => 'Rejected By '.\Auth::user()->belongtostaff->name]);
						// update status for all approval
						$n->hasmanystaffapproval()->where('id', $staffLeaveApproval->id)->update( $request->except(['_method', '_token']) );
						// HR part.. x payah kot nak update kat sini..
						// $n->hasmanystaffapproval()->where('id', '<>',  $staffLeaveApproval->id)->update( $request->except(['_method', '_token', 'approval']) );
					}
				} else { // date dah LEPAS.. HOD hanya approve atau reject tapi tak boleh deduct leave

					echo ' dah lepas<br />';
					// jom reject walau dah cuti w/o deduct leave
					$updHOD = \Auth::user()->belongtostaff->hasmanystaffleaveapproval()->where('id', $staffLeaveApproval->id)->update( $request->except(['_method', '_token']) );
				}
			}
		} else { // this is hr cos its 1
			
die();
		}
		Session::flash('flash_message', 'Data successfully edited!');
		return redirect( route('staffLeaveApproval.index') );
	}

	public function destroy(StaffLeaveApproval $staffLeaveApproval)
	{
	}
}
