<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;

// load model
use App\Model\StaffLeave;

use Illuminate\Http\Request;

// load validation
use App\Http\Requests\StaffLeaveRequest;

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
				return redirect()->back();
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

			$date_time_start = $request->date_time_start.$time_start;
			$date_time_end = $request->date_time_end.$time_end;

		} else {
			if($request->leave_type == 2) {
				// leave_type = 2, means half day leave
				$time = explode( '/', $request->leave_half );
				$time_start = $time[0];
				$time_end = $time[1];

				$date_time_start = $request->date_time_start.$time_start;
				$date_time_end = $request->date_time_end.$time_end;
			}
		}

		/////////////////////////////////////////////////////////////////////////////////////////////////////////
		// must check date range if there is any, got few case i.e 
		// 1. oldyear -> currentYear
		// 2. currentYear -> currentYear
		// 3. curretnYear -> newYear

		$date1 = $request->date_time_start;
		$date2 = $request->date_time_end;

		// debug
		// $date1 = '2017-12-29';
		// $date2 = '2019-01-02';

		// cari tahun dulu
		$gtotal = 0;
		function split_date($start_date, $end_date){
		
		    while($start_date < $end_date){
		        $end = date("Y-m-d", strtotime("Last day of December", strtotime($start_date)));
		        if($end_date<$end){
		            $end = $end_date;
		        }
		        $dates[] =array('start'=>$start_date, 'end'=>$end);
		
		        $start_date =date("Y-m-d", strtotime("+1 day", strtotime($end)));
		
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

			$haricuti = count($sundi) - count($cuti);

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



			// find supervisor or HOD (group 2, 3 & 4)
			$usergroup = \Auth::user()->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
			$userloc = \Auth::user()->belongtostaff->location_id;
			echo $userloc.' <-- location_id<br />';

			// justify for those who doesnt have department
			// perjalanan naik keatas.. :-P

			echo $usergroup->position.' <--- position<br />';
			echo $usergroup->category_id.' <--- category<br />';
			echo $usergroup->division_id.' <--- division<br />';
			echo $usergroup->department_id.' <--- department<br />';
			echo $usergroup->group_id.' <--- group<br />';

			// all geng production will be approved by supervisor based on location.
			// https://stackoverflow.com/questions/30704908/laravel-saving-a-belongstomany-relationship
			if( $usergroup->group_id >= 5 && $usergroup->category_id == 2 ) {
				$pos = \App\Model\Position::find( 36 )->hasmanystaffposition()->get();
				// dd ( $pos );
				foreach($pos as $po) {
					echo $po->belongtostaff->name.' supervisor name<br />';
					echo $po->belongtostaff->id.' supervisor staff id<br />';
				}
			}







			if ( $request->leave_id == 1 ) {
				// annual Leave

				// check al for that particular year
				$annual = $almc->annual_leave_balance;

				$albal1 = $annual - $haricuti;
				echo $albal1.' = al - total cuti<br />';
				if( $albal1 < 0 ) {
					// negative value, so blocked
					// Session::flash('flash_message', 'Sorry, we cant process your leave. You doesn\'t have anymore Annual Leave from the date '.\Carbon\Carbon::parse($val['start'])->format('D, j F Y').' to '.\Carbon\Carbon::parse($val['end'])->format('D, j F Y').'. Please change your leave type. If you think its happen by mistake, please reach Human Resource Department.' );
					// return redirect()->back();
				}

				// $takeLeave = \Auth::user()->belongtostaff->hasmanystaffleave()->create([
				// 	'leave_no' => $leave_no,
				// 	'leave_id' => $request->leave_id,
				// 	'reason' => $request->reason,
				// 	'date_time_start' => $date_time_start,
				// 	'date_time_end' => $date_time_end,
				// 	'al_balance' => $almc->annual_leave_balance,
				// 	'active' => 1,
				// ]);

				// update at StaffAnnualMCLeave for al balance
				// $updal = \Auth::user()->belongtostaff->hasmanystaffannualmcleave()->updateOrCreate(
				// 		// where part
				// 		['year' => $dt->year],
				// 		// insert or update parameter
				// 		['annual_leave_balance' => $albal1]
				// );

				// insert backup if there is any
				// if($request->staff_id) {
				// 	$takeLeave->hasonestaffleavebackup()->create(
				// 		['staff_id' => $request->staff_id]
				// 	);
				// }

				// insert data for HOD dgn HR..



				// Session::flash('flash_message', 'Data successfully inserted!');
				// return redirect()->back();
			}
			echo '///////////////////////////////////////////////////////////////';
			echo 'bawah sekali dah ni...<br />';
		}
		echo $gtotal.' grandtotal all leave day<br />';

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		// if ( $request->leave_id == 2 ) {
				// mc leave
		// }

		// if( $request->leave_id == 3 ) {
		// 	UPL leave
		// }

		// if ( $request->leave_id == 4 ) {
				// NRL leave
		// }

		// if ( $request->leave_id == 7 ) {
				// ML leave
		// }

		// if ( $request->leave_id == 8 ) {
				// EL leave
		// }

		// if ( $request->leave_id == 9 ) {
				// TL
		// }
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
