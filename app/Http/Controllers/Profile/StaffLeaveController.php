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

		// in time off, there only date_time_start so...
		if( empty( $request->date_time_end ) ) {
			$request->date_time_end = $request->date_time_start;
		}

		/////////////////////////////////////////////////////////////////////////////////////////////////////////
		// must check date range if there is any, got few case i.e 
		// 1. oldyear -> currentYear
		// 2. currentYear -> currentYear
		// 3. curretnYear -> newYear

		// $date1 = $request->date_time_start;
		// $date2 = $request->date_time_end;

		$date1 = '2017-12-29';
		$date2 = '2019-01-02';
		// cari tahun dulu
		function split_date($start_date,$end_date){
		
		    while($start_date < $end_date){
		        $end = date("Y-m-d", strtotime("Last day of December", strtotime($start_date)));
		        if($end_date<$end){
		            $end = $end_date;
		        }
		        $dates[] =array('start'=>$start_date,'end'=>$end);
		
		        $start_date =date("Y-m-d", strtotime("+1 day", strtotime($end)));
		
		    }
		    return $dates; 
		}
		$dates = split_date($date1, $date2);
		// print_r($dates);

		foreach ($dates as $key => $val) {
			$period = \Carbon\CarbonPeriod::create($val['start'], '1 days', $val['end']);

			// buat projek kat sini? fuck dot man..
			echo $period->count().' coutn<br />';

			$nodays = \App\Model\HolidayCalendar::where('date_start', '>=', $val['start'] )->where( 'date_end', '<=', $val['end'] )->get();
			// echo $nodays.' json for the whole year<br />';
			foreach ($nodays as $uy) {
				$perC = \Carbon\CarbonPeriod::create($uy->date_start, '1 days', $uy->date_end);
				echo $perC->count().' hari cuti dari '.$val['start'].' <=> '.$val['end'].'<br />';
			}

			$ahad = \Carbon\Carbon::parse(  )->dayOfWeek;






		}












		// buang cuti umum dulu, take note : public holiday got sunday
//		$sun = [];
//		$nodays = \App\Model\HolidayCalendar::where('date_start', '>=', $request->date_time_start )->where( 'date_end', '<=', $request->date_time_end )->get();
//		foreach ($nodays as $keycuti) {
//			$periodC = \Carbon\CarbonPeriod::create($keycuti->date_start, '1 days', $keycuti->date_end);
//			foreach ($periodC as $val) {
//				$ahad = \Carbon\Carbon::parse( $val->format('Y-m-d') )->dayOfWeek;
//				if($ahad != 0 ) {
//					echo $val->format('Y-m-d').' cuti<br />';
//					$sun[] = $val->format('Y-m-d');
//				}
//			}
//		}
//		echo count($sun).' cuti umum tanpa ahad<br />';

//		// berapa hari cuti
//		$periodY = \Carbon\CarbonPeriod::create($request->date_time_start, '1 days', $request->date_time_end);
//		echo count($periodY).' = bilangan hari cuti<br />';
//		$cuti = [];
//		foreach ($periodY as $key) {
//			// sunday is working
//			$rty = \Carbon\Carbon::parse( $key->format('Y-m-d') )->dayOfWeek;
//			if( $rty != 0 ) {
//				echo $key->format('Y-m-d').' slps tolak ahad<br />';
//				$cuti[] = $key->format('Y-m-d');
//			}
//		}

//		echo count($cuti).' bilangan cuti slps ditolak ahad.<br />';



//		$date1 = '22-12-2013';
//		$date2 = "04-01-2014";
//		function split_date($d1, $d2)
//		{
//			$start_year = substr($d1, -4);
//			$end_year = substr($d2, -4);

//			if($end_year > $start_year)
//			{
//				$d1 .= ' ['.date('d-m-Y',strtotime("31-12-".$start_year)).'] <br />';
//				$d2 = '['.date('d-m-Y',strtotime("01-01-".$start_year."+1 years")).'] ' . $d2;
//			}
//			return $d1 . $d2;
//		}

//		echo split_date($date1, $date2);

		// // buang cuti umum
		// $cuti = [];
		// $nodate5 = \App\Model\HolidayCalendar::where('date_start', '>=', $request->date_time_start)->where( 'date_end', '<=', $request->date_time_end )->get();
		// foreach ($nodate5 as $nda) {
		// 	$periodH = \Carbon\CarbonPeriod::create($nda->date_start, '1 days', $nda->date_end);
		// 	foreach ($periodH as $key) {
		// 		// echo $key->format('Y-m-d').' tarikh cuti umum<br />';

		// 		// cari dan buang hari ahad
		// 		$rty = \Carbon\Carbon::parse( $key->format('Y-m-d') )->dayOfWeek;
		// 		if( $rty != 0 ){
		// 			$cuti[] = $key->format('Y-m-d');
		// 			echo $key->format('Y-m-d').' ambil tarih ni dari cuti umum<br />';
		// 		}
		// 	}
		// }
		// echo count($cuti).' bilangan cuti umum exclude hari ahad<br />';

		// $hari = count($periodY) - count($sunday) - count($cuti);
		// echo 'bilangan cuti sebenar hanyalah = '.$hari.'<br />';


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

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		if ( $request->leave_id == 1 || $request->leave_id == 3 ) {
			// insert semua apa yg ada
			// StaffLeave::create( array_add( $request->except(['_method', '_token']), 'staff_id', auth()->user()->belongtostaff->id) );
			// $takeLeave = \Auth::user()->belongtostaff->hasmanystaffleave()->create([
			// 	'leave_id' => $request->leave_id,
			// 	'reason' => $request->reason,
			// 	'date_time_start' => $date_time_start,
			// 	'date_time_end' => $date_time_end,
			// 	'al_balance' => 1,
			// 	'active' => 1,
			// ]);

			// Session::flash('flash_message', 'Data successfully inserted!');
			// return redirect()->back();
		}

		// if ( $request->leave_id == 2 ) {
		// }

		// if ( $request->leave_id == 4 ) {
		// }

		// if ( $request->leave_id == 7 ) {
		// }

		// if ( $request->leave_id == 8 ) {
		// }

		// if ( $request->leave_id == 9 ) {
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
