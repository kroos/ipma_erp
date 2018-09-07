<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;

// load model
use App\Model\StaffLeave;

use Illuminate\Http\Request;

// load validation
use App\Http\Requests\StaffLeaveRequest;

// for manipulating image
// http://image.intervention.io/
// use Intervention\Image\Facades\Image as Image;       <-- ajaran sesat depa... hareeyyyyy!!
use Intervention\Image\ImageManagerStatic as Image;

use Session;


class StaffLeaveController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
		$this->middleware('leaveaccess', ['only' => ['show', 'edit', 'update']]);
	}

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index()
	{
		return view('leave.index');
		// SELECT leave_no, leave_created_date from `leave` WHERE YEAR(leave_created_date)='2019' ORDER BY leave_id DESC LIMIT 1
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('leave.create');
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(StaffLeaveRequest $request)
	{
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// initialization phase

		// dd( $request->all() );

		// 		$request->leave_id
		// 		$request->reason
		// 		$request->date_time_start
		// 		$request->date_time_end
		// 		$request->leave_type
		// 		$request->leave_half
		// 		$request->staff_id
		// 		$request->time_start
		// 		$request->time_end
		// 		$request->file('document')
		// 		$request->documentsupport
		// 		$request->akuan

		// yg ni yg pertama : (kalau bertindih, tendang dulu.) walau apa cuti sekalipon, mai kita check cuti bertindih dulu..
		$period = \Carbon\CarbonPeriod::create($request->date_time_start, '1 days', $request->date_time_end);
		foreach ($period as $key) {
			// echo $key->format('Y-m-d');
			$kik = StaffLeave:: where( 'staff_id', \Auth::user()->belongtostaff->id )->where('active', 1)->whereRaw('? BETWEEN DATE(date_time_start) AND DATE(staff_leaves.date_time_end)', [$key->format('Y-m-d')])->get();
			if( $kik->count() > 0 ) {
				// block kalau ada bertindih cuti yg dah sedia ada
				Session::flash('flash_message', 'Tarikh permohonan cuti ('.\Carbon\Carbon::parse($request->date_time_start)->format('D, j F Y').' hingga '.\Carbon\Carbon::parse($request->date_time_end)->format('D, j F Y').') sudah diisi. Sila ambil tarikh yang lain.');
				return redirect()->back()->withInput();
			}
		}

		/////////////////////////////////////////////////////////////////////////////////////////////////////////
		// in time off, there only date_time_start so...
		if( empty( $request->date_time_end ) ) {
			$request->date_time_end = $request->date_time_start;
		}

		/////////////////////////////////////////////////////////////////////////////////////////////////////////
		// we must check $request->leave_type. if $request->leave_type == 1? full day(1) : half day(2)
		// leave_type = 1 means no leave_half
		// in mc, there is no $request->leave_type
		if( $request->leave_type == 1 || empty($request->leave_type) ) {
			$time_start = ' 00:00:00';
			$time_end = ' 23:59:59';

			$date_time_start = $request->date_time_start.' '.$time_start;
			$date_time_end = $request->date_time_end.' '.$time_end;

		} else {
			if($request->leave_type == 2) {
				// leave_type = 2, means half day leave
				$time = explode( '/', $request->leave_half );
				$time_start = $time[0];
				$time_end = $time[1];

				$date_time_start = $request->date_time_start.' '.$time_start;
				$date_time_end = $request->date_time_end.' '.$time_end;
			}
		}

		/////////////////////////////////////////////////////////////////////////////////////////////////////////
		// must check date range if there is any, got few case i.e 
		// 1. oldyear -> currentYear
		// 2. currentYear -> currentYear
		// 3. curretnYear -> newYear

		$date1 = \Carbon\Carbon::parse($request->date_time_start)->format('Y-m-d');
		$date2 = \Carbon\Carbon::parse($request->date_time_end)->format('Y-m-d');

		// dd($date2);

		// debug
		// $date1 = '2017-12-29';
		// $date2 = '2019-01-02';

		// cari tahun dulu
		$gtotal = 0;

		function split_date($start_date, $end_date){
			while($start_date <= $end_date){
				$end = date("Y-m-d", strtotime("Last day of December", strtotime($start_date)));
				if($end_date<=$end){
					$end = $end_date;
				}
				$dates[] = array('start'=>$start_date, 'end'=>$end);
				$start_date = date("Y-m-d", strtotime("+1 day", strtotime($end)));
			}
			return $dates;
		}

		$dates = split_date($date1, $date2);
		// print_r($dates);

		foreach ($dates as $key => $val) {
			$period = \Carbon\CarbonPeriod::create($val['start'], '1 days', $val['end']);

			// count all date
			echo $period->count().' total hari<br />';

			// kira cuti ahad
			$cuti = [];
			$nodays = \App\Model\HolidayCalendar::where('date_start', '>=', $val['start'] )->where( 'date_end', '<=', $val['end'] )->get();
			// echo $nodays.' json for the whole year<br />';
			foreach ($nodays as $uy) {
				// take cuti date from database
				$perC = \Carbon\CarbonPeriod::create($uy->date_start, '1 days', $uy->date_end);
				// echo $perC->count().' hari cuti dari '.$val['start'].' <=> '.$val['end'].'<br />';
				foreach ($perC as $aha) {
					$adaahaddlmni = \Carbon\Carbon::parse( $aha, 'Y-m-d' )->dayOfWeek;
					if($adaahaddlmni != 0) {
						// echo $aha.' no ahad in cuti<br />';
						$cuti[] = $aha;
					}
				}
			}
			echo count($cuti).' bilangan hari cuti ahad<br />';

			// substract all sundays
			$sundi = [];
			foreach ($period as $op) {
				$sund = \Carbon\Carbon::parse( $op )->dayOfWeek;
				if($sund != 0) {
					// echo $op.' bukan hari ahad<br />';
					$sundi[] = $op;
				}
			}
			echo count($sundi).' bilangan hari bukan hari ahad dalam range<br />';

			if($request->leave_type == 2) {
				$haricuti = 0.5;
			} else {
				$haricuti = count($sundi) - count($cuti);
			}

			echo $haricuti.' applied leave for this year<br />';
			$gtotal += $haricuti;

			// must check 2 things. 1. annual leave 2. mc leave
			$dt = \Carbon\Carbon::parse($val['start']);
			echo $dt->year.' year<br />';

			// dont use create cos it will insert data even there is a data
			// firstOrNew will create only if there is no data..
			$almc = \Auth::user()->belongtostaff->hasmanystaffannualmcleave()->where('year', $dt->year)->firstOrNew(
				// 1st part for where
				['year' => $dt->year],
				// 2nd part for insert parameter
				[
					'annual_leave_balance' => 0,
					'remarks' => 'auto insert data due to no data at all'
				]
			);
			// must call save() in this method
			$almc->save();
			echo $almc->annual_leave_balance.' cuti al<br />';
			echo $almc->medical_leave_balance.' cuti mc<br />';
			echo $almc->maternity_leave_balance.' cuti maternity<br />';

			echo '///////////////////////////////////////////////////////////////<br>';

			$leave_no = \App\Model\StaffLeave::whereYear('created_at', $dt->year)->first();
			if(empty($leave_no)) {
				$leave_no = 0;
			} else {
				$leave_no = $leave_no->max('leave_no');
			}
			echo $leave_no.' leave_no<br />';
			// before insert, check leave no.
			$leave_no = $leave_no + 1;
			echo $leave_no.' after add 1<br />';


			/////////////////////////////////////////////////////////////////////////////////////////////////////////////
			// find supervisor or HOD (group 2, 3 & 4)
			$usergroup = \Auth::user()->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
			$userloc = \Auth::user()->belongtostaff->location_id;
			echo $userloc.' <-- location_id<br />';

			// justify for those who doesnt have department
			// perjalanan naik keatas.. :-P

			echo $usergroup->id.' <--- id position<br />';
			echo $usergroup->position.' <--- position<br />';
			echo $usergroup->category_id.' <--- category<br />';
			echo $usergroup->division_id.' <--- division<br />';
			echo $usergroup->department_id.' <--- department<br />';
			echo $usergroup->group_id.' <--- group<br />';

			// all geng production will be approved by supervisor based on location.
			// production member will approved by their supervisor.
			if( $usergroup->group_id >= 5 && $usergroup->category_id == 2 ) {
				$pos = \App\Model\Position::find( 36 )->hasmanystaffposition()->get();
				// dd ( $pos );
				foreach($pos as $po) {
					if( ( $userloc == $po->belongtostaff->location_id ) && $po->belongtostaff->active == 1 ) {
						echo $po->belongtostaff->name.' supervisor name<br />';
						echo $po->belongtostaff->id.' supervisor staff id<br />';
						$HOD = $po->belongtostaff->id;
					}
				}
			}

			// special for PA, no HOD n HOD him/herself also directors
			if ( ($usergroup->id >= 4 && $usergroup->id <= 6) || $usergroup->group_id == 2 || $usergroup->group_id == 1 ) {
				echo ' directors, HOD, PA<br />';
				$HOD = NULL;
			}

			// and now, normal user that belongs to office category, supervisor and assistant HOD
			// we got a lot of user that we skipped from HOD
			if (
				( $usergroup->group_id == 7 && $usergroup->category_id == 1 && ( $usergroup->id < 4 || $usergroup->id > 6 ) && $usergroup->id != 13 && $usergroup->id != 16 && $usergroup->id != 73 && $usergroup->id != 77 ) ||
				( $usergroup->group_id == 3 && $usergroup->category_id == 1 ) ||
				( $usergroup->group_id == 4 && $usergroup->category_id == 1 ) 
			) {
				// find department HOD
				// dd( \App\Model\Position::where( [[ 'department_id', $usergroup->department_id ],[ 'group_id', 2 ]] )->get() );
				$hood = \App\Model\Position::where( [[ 'department_id', $usergroup->department_id ],[ 'group_id', 2 ]] )->get();
				foreach ($hood as $meek) {
					$hee = $meek->hasmanystaffposition()->get();
					foreach($hee as $moo) {
						echo $moo->belongtostaff->name.' this is your HOD<br />';
						$HOD = $moo->belongtostaff->id;
					}
				}
			}

			//insert data for HR executives
			$HR = \App\Model\Position::find( 12 )->hasmanystaffposition()->get();
			foreach($HR as $HRE) {
				if( $HRE->belongtostaff->active == 1 ) {
					echo $HRE->belongtostaff->name.' hr name<br />';
					echo $HRE->belongtostaff->id.' hr id<br />';
					$hret = $HRE->belongtostaff->id;
				}
			}

			// store supporting document if any
			if($request->hasFile('document')) {
				$filename = $request->file('document')->store('public/images/profiles');

				$ass1 = explode('/', $filename);
				$ass2 = array_except($ass1, ['0']);
				$image = implode('/', $ass2);
				// dd($image);

				// jpeg,jpg,png,bmp,pdf,doc
				if( $request->document->extension() == 'jpeg' || $request->document->extension() == 'jpg' || $request->document->extension() == 'png' || $request->document->extension() == 'bmp' ) {
					$imag = Image::make(storage_path('app/'.$filename));
					// resize the image to a height of 400 and constrain aspect ratio (auto width)
					$imag->resize(null, 400, function ($constraint) {
					    $constraint->aspectRatio();
					});
					$imag->save();
				}
			} else {
				$image = NULL;
			}

			/////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

			if ( $request->leave_id == 1 ) {
				// annual Leave

				// check al for that particular year
				$annual = $almc->annual_leave_balance;

				$albal1 = $annual - $haricuti;
				echo $albal1.' = al - total cuti<br />';
				if( $albal1 < 0 ) {
					// negative value, so blocked
					Session::flash('flash_message', 'Sorry, we cant process your leave. You doesn\'t have anymore Annual Leave from the date '.\Carbon\Carbon::parse($val['start'])->format('D, j F Y').' to '.\Carbon\Carbon::parse($val['end'])->format('D, j F Y').'. Please change your leave type. If you think its happen by mistake, please reach Human Resource Department.' );
					return redirect()->back()->withInput();
				}

				// insert into staff_leaves table
				$takeLeave = \Auth::user()->belongtostaff->hasmanystaffleave()->create([
					'leave_no' => $leave_no,
					'leave_id' => $request->leave_id,
					'half_day' => $request->leave_type,
					'reason' => $request->reason,
					'date_time_start' => $date_time_start,
					'date_time_end' => $date_time_end,
					'period' => $haricuti,
					'document' => $image,
					'al_balance' => $almc->annual_leave_balance,
					'active' => 1,
				]);

				// update at StaffAnnualMCLeave for al balance
				$updal = \Auth::user()->belongtostaff->hasmanystaffannualmcleave()->updateOrCreate(
						// where part
						['year' => $dt->year],
						// insert or update parameter
						['annual_leave_balance' => $albal1]
				);

				// insert backup if there is any
				if($request->staff_id) {
					$takeLeave->hasonestaffleavebackup()->create(
						['staff_id' => $request->staff_id]
					);
				}
				// insert data for HOD if there is any..
				if(!empty($HOD)) {
					$takeLeave->hasmanystaffapproval()->create([
						'staff_id' => $HOD,
					]);
				}
				// insert hr approve
				if( !empty($hret) ) {
					$takeLeave->hasmanystaffapproval()->create([
						'staff_id' => $hret,
						'hr' => 1,
					]);
				}
			}

			if ( $request->leave_id == 2 ) {
				// mc leave

				// check al for that particular year
				$medical = $almc->medical_leave_balance;

				$albal1 = $medical - $haricuti;
				echo $albal1.' = mc - total cuti<br />';
				if( $albal1 < 0 ) {
					// negative value, so blocked
					Session::flash('flash_message', 'Sorry, we cant process your leave. You doesn\'t have anymore Medical Leave from the date '.\Carbon\Carbon::parse($val['start'])->format('D, j F Y').' to '.\Carbon\Carbon::parse($val['end'])->format('D, j F Y').'. Please change your leave type. If you think its happen by mistake, please reach Human Resource Department.' );
					return redirect()->back()->withInput();
				}

				// insert into staff_leaves table
				$takeLeave = \Auth::user()->belongtostaff->hasmanystaffleave()->create([
					'leave_no' => $leave_no,
					'leave_id' => $request->leave_id,
					'half_day' => $request->leave_type,
					'reason' => $request->reason,
					'date_time_start' => $date_time_start,
					'date_time_end' => $date_time_end,
					'period' => $haricuti,
					'document' => $image,
					'mc_balance' => $almc->medical_leave_balance,
					'active' => 1,
				]);

				// update at StaffAnnualMCLeave for al balance
				$updal = \Auth::user()->belongtostaff->hasmanystaffannualmcleave()->updateOrCreate(
						// where part
						['year' => $dt->year],
						// insert or update parameter
						['medical_leave_balance' => $s]
				);

				// insert data for HOD if there is any..
				if(!empty($HOD)) {
					$takeLeave->hasmanystaffapproval()->create([
						'staff_id' => $HOD,
					]);
				}
				// insert hr approve
				if( !empty($hret) ) {
					$takeLeave->hasmanystaffapproval()->create([
						'staff_id' => $hret,
						'hr' => 1,
					]);
				}
			}

			if( $request->leave_id == 3 ) {
				// 	UPL leave

				// insert into staff_leaves table
				$takeLeave = \Auth::user()->belongtostaff->hasmanystaffleave()->create([
					'leave_no' => $leave_no,
					'leave_id' => $request->leave_id,
					'half_day' => $request->leave_type,
					'reason' => $request->reason,
					'date_time_start' => $date_time_start,
					'date_time_end' => $date_time_end,
					'period' => $haricuti,
					'document' => $image,
					'active' => 1,
				]);

				// insert backup if there is any
				if($request->staff_id) {
					$takeLeave->hasonestaffleavebackup()->create(
						['staff_id' => $request->staff_id]
					);
				}
				// insert data for HOD if there is any..
				if(!empty($HOD)) {
					$takeLeave->hasmanystaffapproval()->create([
						'staff_id' => $HOD,
					]);
				}
				// insert hr approve
				if( !empty($hret) ) {
					$takeLeave->hasmanystaffapproval()->create([
						'staff_id' => $hret,
						'hr' => 1,
					]);
				}
			}

			if ( $request->leave_id == 4 ) {
				// NRL leave

				// upacara tolak cuti ganti.
				$gant = \App\Model\StaffLeaveReplacement::find($request->staff_leave_replacement_id)->leave_balance;
				echo $gant.' balance replacement<br />';

				$balancegant = $gant - $haricuti;
				echo $balancegant.' balance<br />';
				// insert into staff_leaves table

				$takeLeave = \Auth::user()->belongtostaff->hasmanystaffleave()->create([
					'leave_no' => $leave_no,
					'leave_id' => $request->leave_id,
					'half_day' => $request->leave_type,
					'reason' => $request->reason,
					'date_time_start' => $date_time_start,
					'date_time_end' => $date_time_end,
					'period' => $haricuti,
					'document' => $image,
					'active' => 1,
				]);

				echo $request->staff_leave_replacement_id.' id staff_leave_replacement<br />';
				echo $takeLeave->id.' insert id from $takeleave<br />';
				// update staff leave replacement => somehow this method doesnt work
				// $upl = $takeLeave->hasmanystaffleavereplacement()->where('id', $request->staff_leave_replacement_id)->update( [
				// 	'leave_utilize' => $haricuti,
				// 	'leave_balance' => $balancegant
				// 	] );

				$upl = \App\Model\StaffLeaveReplacement::where('id', $request->staff_leave_replacement_id)->update([
					'staff_leave_id' => $takeLeave->id,
					'leave_utilize' => $haricuti,
					'leave_balance' => $balancegant,
				]);

				// insert backup if there is any
				if($request->staff_id) {
					$takeLeave->hasonestaffleavebackup()->create(
						['staff_id' => $request->staff_id]
					);
				}
				// insert data for HOD if there is any..
				if(!empty($HOD)) {
					$takeLeave->hasmanystaffapproval()->create([
						'staff_id' => $HOD,
					]);
				}
				// insert hr approve
				if( !empty($hret) ) {
					$takeLeave->hasmanystaffapproval()->create([
						'staff_id' => $hret,
						'hr' => 1,
					]);
				}

			}

			if ( $request->leave_id == 7 ) {
				// ML leave (maternity) check ml for that particular year
				$mlbal = $period->count() - $almc->maternity_leave_balance;
				// insert into staff_leaves table
				$takeLeave = \Auth::user()->belongtostaff->hasmanystaffleave()->create([
					'leave_no' => $leave_no,
					'leave_id' => $request->leave_id,
					'half_day' => $request->leave_type,
					'reason' => $request->reason,
					'date_time_start' => $date_time_start,
					'date_time_end' => $date_time_end,
					'period' => $period->count(),
					'document' => $image,
					'active' => 1,
				]);

				// update at StaffAnnualMCLeave for al balance
				$updal = \Auth::user()->belongtostaff->hasmanystaffannualmcleave()->updateOrCreate(
						// where part
						['year' => $dt->year],
						// insert or update parameter
						['maternity_leave_balance' => $mlbal]
				);

				// insert backup if there is any
				if($request->staff_id) {
					$takeLeave->hasonestaffleavebackup()->create(
						['staff_id' => $request->staff_id]
					);
				}

				// insert data for HOD if there is any..
				if(!empty($HOD)) {
					$takeLeave->hasmanystaffapproval()->create([
						'staff_id' => $HOD,
					]);
				}
				// insert hr approve
				if( !empty($hret) ) {
					$takeLeave->hasmanystaffapproval()->create([
						'staff_id' => $hret,
						'hr' => 1,
					]);
				}
			}

			if ( $request->leave_id == 8 ) { // EL leave = cari al dulu kalau lebih 3 hari, reject

				// check al for that particular year
				$annual = $almc->annual_leave_balance;
				$albal1 = $annual - $haricuti;

				echo $date_time_start.' from<br />';
				$now = \Carbon\Carbon::now();

				if ( $now->gte($date_time_start) ) { // date before today
					print 'tarikh yg dipilih dah lepas<br />';
					if ($annual > 0) { // checking annual leave
						if( $albal1 < 0 ) { // negative value, so blocked
							Session::flash('flash_message', 'Sorry, we cant process your leave. Your Annual Leave ('.$annual.' days) is not enough to cover your emergency leave from '.\Carbon\Carbon::parse($val['start'])->format('D, j F Y').' to '.\Carbon\Carbon::parse($val['end'])->format('D, j F Y').' ('.$haricuti.' days).' );
							return redirect()->back()->withInput();
						} else { // annual leave enough, so EL-AL
							$takeLeave = \Auth::user()->belongtostaff->hasmanystaffleave()->create([
								'leave_no' => $leave_no,
								'leave_id' => 5,
								'half_day' => $request->leave_type,
								'reason' => $request->reason,
								'date_time_start' => $date_time_start,
								'date_time_end' => $date_time_end,
								'period' => $haricuti,
								'document' => $image,
								'al_balance' => $almc->annual_leave_balance,
								'active' => 1,
							]);

							$updal = \Auth::user()->belongtostaff->hasmanystaffannualmcleave()->updateOrCreate( // update at StaffAnnualMCLeave for al balance
									// where part
									['year' => $dt->year],
									// insert or update parameter
									['annual_leave_balance' => $albal1]
							);
							
							if(!empty($HOD)) { // insert data for HOD if there is any..
								$takeLeave->hasmanystaffapproval()->create([
									'staff_id' => $HOD,
								]);
							}

							if( !empty($hret) ) { // insert hr approve
								$takeLeave->hasmanystaffapproval()->create([
									'staff_id' => $hret,
									'hr' => 1,
								]);
							}
						}
					} else { // pakai EL-UPL

						$takeLeave = \Auth::user()->belongtostaff->hasmanystaffleave()->create([ // insert into staff_leaves table
							'leave_no' => $leave_no,
							'leave_id' => 6,
							'half_day' => $request->leave_type,
							'reason' => $request->reason,
							'date_time_start' => $date_time_start,
							'date_time_end' => $date_time_end,
							'period' => $haricuti,
							'document' => $image,
							'active' => 1,
						]);

						if($request->staff_id) { // insert backup if there is any
							$takeLeave->hasonestaffleavebackup()->create(
								['staff_id' => $request->staff_id]
							);
						}

						if(!empty($HOD)) { // insert data for HOD if there is any..
							$takeLeave->hasmanystaffapproval()->create([
								'staff_id' => $HOD,
							]);
						}

						if( !empty($hret) ) { // insert hr approve

							$takeLeave->hasmanystaffapproval()->create([
								'staff_id' => $hret,
								'hr' => 1,
							]);
						}
					}
				} else { // date after today, gotta check if its 3 days after.
					print 'tarikh yg dipilih adalah tarikh akan datang<br />';
					echo $now->diffInDays($date_time_start).' diff in days<br />';
 					if ( $now->diffInDays($date_time_start) < 3 ) { // dalam masa 3 hari

						if ($annual > 0) { // checking annual leave
							if( $albal1 < 0 ) { // negative value, so blocked
								Session::flash('flash_message', 'Sorry, we cant process your leave. Your Annual Leave ('.$annual.' days) is not enough to cover your emergency leave from '.\Carbon\Carbon::parse($val['start'])->format('D, j F Y').' to '.\Carbon\Carbon::parse($val['end'])->format('D, j F Y').' ('.$haricuti.' days).' );
								return redirect()->back()->withInput();
							} else { // annual leave enough, so EL-AL
								$takeLeave = \Auth::user()->belongtostaff->hasmanystaffleave()->create([
									'leave_no' => $leave_no,
									'leave_id' => 5,
									'half_day' => $request->leave_type,
									'reason' => $request->reason,
									'date_time_start' => $date_time_start,
									'date_time_end' => $date_time_end,
									'period' => $haricuti,
									'document' => $image,
									'al_balance' => $almc->annual_leave_balance,
									'active' => 1,
								]);

								$updal = \Auth::user()->belongtostaff->hasmanystaffannualmcleave()->updateOrCreate( // update at StaffAnnualMCLeave for al balance
										// where part
										['year' => $dt->year],
										// insert or update parameter
										['annual_leave_balance' => $albal1]
								);
								
								if(!empty($HOD)) { // insert data for HOD if there is any..
									$takeLeave->hasmanystaffapproval()->create([
										'staff_id' => $HOD,
									]);
								}

								if( !empty($hret) ) { // insert hr approve
									$takeLeave->hasmanystaffapproval()->create([
										'staff_id' => $hret,
										'hr' => 1,
									]);
								}
							}
						} else { // pakai EL-UPL

							$takeLeave = \Auth::user()->belongtostaff->hasmanystaffleave()->create([ // insert into staff_leaves table
								'leave_no' => $leave_no,
								'leave_id' => 6,
								'half_day' => $request->leave_type,
								'reason' => $request->reason,
								'date_time_start' => $date_time_start,
								'date_time_end' => $date_time_end,
								'period' => $haricuti,
								'document' => $image,
								'active' => 1,
							]);

							if($request->staff_id) { // insert backup if there is any
								$takeLeave->hasonestaffleavebackup()->create(
									['staff_id' => $request->staff_id]
								);
							}

							if(!empty($HOD)) { // insert data for HOD if there is any..
								$takeLeave->hasmanystaffapproval()->create([
									'staff_id' => $HOD,
								]);
							}

							if( !empty($hret) ) { // insert hr approve

								$takeLeave->hasmanystaffapproval()->create([
									'staff_id' => $hret,
									'hr' => 1,
								]);
							}
						}

 					} else { // greater than or equal 3 days.
						Session::flash('flash_message', 'Sorry, we cant process your leave. Your Leave Application date ( from '.\Carbon\Carbon::parse($val['start'])->format('D, j F Y').' to '.\Carbon\Carbon::parse($val['end'])->format('D, j F Y').' ) is '.$now->diffInDays($date_time_start).' days  from today. Please use Annual or Unpaid Leave option which is appropriate.' );
						return redirect()->back()->withInput();
 					}
				}
			}

			// if ( $request->leave_id == 9 ) {
					// TL
			// }
			echo '///////////////////////////////////////////////////////////////';
			echo 'bawah sekali dah ni...<br />';
		}
		echo $gtotal.' grandtotal all leave day<br />';
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		Session::flash('flash_message', 'Data successfully inserted.');
		return redirect()->route('staffLeave.index');
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show(StaffLeave $staffLeave)
	{
		//
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(StaffLeave $staffLeave)
	{
		//
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, StaffLeave $staffLeave)
	{
		//
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy(StaffLeave $staffLeave)
	{
		//
	}
}
