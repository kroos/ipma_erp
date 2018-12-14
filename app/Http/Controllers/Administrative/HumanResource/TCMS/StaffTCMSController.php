<?php

namespace App\Http\Controllers\Administrative\HumanResource\TCMS;

use App\Http\Controllers\Controller;

// load excel/csv/xls import/upload
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StaffTCMSImport;

// load model
use App\Model\StaffTCMS;
use App\Model\Login;
use App\Model\Staff;
use App\Model\StaffTCMSODBC;

use Illuminate\Http\Request;

use App\Http\Requests\StaffTCMSUpdateRequest;

use \Carbon\Carbon;
use Session;
use Storage;

class StaffTCMSController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		// return view('generalAndAdministrative.hr.tcms.index');
	}

	public function create()
	{
		return view('generalAndAdministrative.hr.tcms.create');
	}

	public function storeODBC(Request $request)
	{
		ini_set('max_execution_time', 3000);

		$odbc = StaffTCMSODBC::all();
		foreach($odbc as $od) {
			$id = Login::where('username', $od->EMPNO);
			if( !is_null($id->where('active', 1)) ) {
				$sid = $id->where('active', 1)->first();
			} else {
				$sid = NULL;
			}

			if( !is_null($sid) ) {
				$sid1 = $sid->belongtostaff->active;
			} else {
				$sid1 = 0;
			}

			if( $sid1 == 1 ) {

				// run query updateOrCreate
				$tc = StaffTCMS::where('username', $od->EMPNO)->where('date', Carbon::parse($od->DATE)->format('Y-m-d'))->first();

				// echo $tc.'<br />';

				if( is_null($tc) ) {
					$tcname = NULL;
					$tcdate = NULL;
					$tcin = NULL;
					$tcbreak = NULL;
					$tcresume = NULL;
					$tcout = NULL;
				} else {
					$tcname = $tc->name;
					$tcdate = $tc->date;
					$tcin = $tc->in;
					$tcbreak = $tc->break;
					$tcresume = $tc->resume;
					$tcout = $tc->out;
				}

				// echo $tcname.' name<br />'.$tcdate.' date<br />'.$tcin.' in<br />'.$tcbreak.' break<br />'.$tcresume.' resume<br />'.$tcout.' out<br /><br />';

				if( is_null($tc) ) {
					StaffTCMS::create([
											'username' => $od->EMPNO,
											'date' => Carbon::parse($od->DATE)->format('Y-m-d'),
											'staff_id' => $sid->staff_id,
											'name' => $od->BADGENAME,
											'daytype' => $od->DAYTYPE,
											'in' => (!empty($od->IN_))?$od->IN_:'00:00:00',
											'break' => (!empty($od->BREAK_))?$od->BREAK_:'00:00:00',
											'resume' => (!empty($od->RESUME_))?$od->RESUME_:'00:00:00',
											'out' => (!empty($od->OUT_))?$od->OUT_:'00:00:00',
											'work_hour' => $od->WORK,
											'short_hour' => $od->SHORT,
											'leave_taken' => $od->LEAVETYPE,
											'remark' => $od->REMARK,
					]);

				// update all column
				} elseif ( $tcin == '00:00:00' && $tcbreak == '00:00:00' && $tcresume == '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $od->EMPNO)->where('date', Carbon::parse($od->DATE)->format('Y-m-d'))->update([
						'in' => (!empty($od->IN_))?$od->IN_:'00:00:00',
						'break' => (!empty($od->BREAK_))?$od->BREAK_:'00:00:00',
						'resume' => (!empty($od->RESUME_))?$od->RESUME_:'00:00:00',
						'out' => (!empty($od->OUT_))?$od->OUT_:'00:00:00',
						'work_hour' => $od->WORK,
						'short_hour' => $od->SHORT,
						'leave_taken' => $od->LEAVETYPE,
						'remark' => $od->REMARK,
					]);

				// update 1 column only
				} elseif ( $tcin != '00:00:00' && $tcbreak == '00:00:00' && $tcresume == '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $od->EMPNO)->where('date', Carbon::parse($od->DATE)->format('Y-m-d'))->update([
						// 'in' => (!empty($od->IN_))?$od->IN_:'00:00:00',
						'break' => (!empty($od->BREAK_))?$od->BREAK_:'00:00:00',
						'resume' => (!empty($od->RESUME_))?$od->RESUME_:'00:00:00',
						'out' => (!empty($od->OUT_))?$od->OUT_:'00:00:00',
						'work_hour' => $od->WORK,
						'short_hour' => $od->SHORT,
						'leave_taken' => $od->LEAVETYPE,
						'remark' => $od->REMARK,
					]);
				} elseif ( $tcin == '00:00:00' && $tcbreak != '00:00:00' && $tcresume == '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $od->EMPNO)->where('date', Carbon::parse($od->DATE)->format('Y-m-d'))->update([
						'in' => (!empty($od->IN_))?$od->IN_:'00:00:00',
						// 'break' => (!empty($od->BREAK_))?$od->BREAK_:'00:00:00',
						'resume' => (!empty($od->RESUME_))?$od->RESUME_:'00:00:00',
						'out' => (!empty($od->OUT_))?$od->OUT_:'00:00:00',
						'work_hour' => $od->WORK,
						'short_hour' => $od->SHORT,
						'leave_taken' => $od->LEAVETYPE,
						'remark' => $od->REMARK,
					]);
				} elseif ( $tcin == '00:00:00' && $tcbreak == '00:00:00' && $tcresume != '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $od->EMPNO)->where('date', Carbon::parse($od->DATE)->format('Y-m-d'))->update([
						'in' => (!empty($od->IN_))?$od->IN_:'00:00:00',
						'break' => (!empty($od->BREAK_))?$od->BREAK_:'00:00:00',
						// 'resume' => (!empty($od->RESUME_))?$od->RESUME_:'00:00:00',
						'out' => (!empty($od->OUT_))?$od->OUT_:'00:00:00',
						'work_hour' => $od->WORK,
						'short_hour' => $od->SHORT,
						'leave_taken' => $od->LEAVETYPE,
						'remark' => $od->REMARK,
					]);
				} elseif ( $tcin == '00:00:00' && $tcbreak == '00:00:00' && $tcresume == '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $od->EMPNO)->where('date', Carbon::parse($od->DATE)->format('Y-m-d'))->update([
						'in' => (!empty($od->IN_))?$od->IN_:'00:00:00',
						'break' => (!empty($od->BREAK_))?$od->BREAK_:'00:00:00',
						'resume' => (!empty($od->RESUME_))?$od->RESUME_:'00:00:00',
						// 'out' => (!empty($od->OUT_))?$od->OUT_:'00:00:00',
						'work_hour' => $od->WORK,
						'short_hour' => $od->SHORT,
						'leave_taken' => $od->LEAVETYPE,
						'remark' => $od->REMARK,
					]);

				// update 2 column only
				} elseif ( $tcin != '00:00:00' && $tcbreak != '00:00:00' && $tcresume == '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $od->EMPNO)->where('date', Carbon::parse($od->DATE)->format('Y-m-d'))->update([
						// 'in' => (!empty($od->IN_))?$od->IN_:'00:00:00',
						// 'break' => (!empty($od->BREAK_))?$od->BREAK_:'00:00:00',
						'resume' => (!empty($od->RESUME_))?$od->RESUME_:'00:00:00',
						'out' => (!empty($od->OUT_))?$od->OUT_:'00:00:00',
						'work_hour' => $od->WORK,
						'short_hour' => $od->SHORT,
						'leave_taken' => $od->LEAVETYPE,
						'remark' => $od->REMARK,
					]);
				} elseif ( $tcin != '00:00:00' && $tcbreak == '00:00:00' && $tcresume != '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $od->EMPNO)->where('date', Carbon::parse($od->DATE)->format('Y-m-d'))->update([
						// 'in' => (!empty($od->IN_))?$od->IN_:'00:00:00',
						'break' => (!empty($od->BREAK_))?$od->BREAK_:'00:00:00',
						// 'resume' => (!empty($od->RESUME_))?$od->RESUME_:'00:00:00',
						'out' => (!empty($od->OUT_))?$od->OUT_:'00:00:00',
						'work_hour' => $od->WORK,
						'short_hour' => $od->SHORT,
						'leave_taken' => $od->LEAVETYPE,
						'remark' => $od->REMARK,
					]);
				} elseif ( $tcin != '00:00:00' && $tcbreak == '00:00:00' && $tcresume == '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $od->EMPNO)->where('date', Carbon::parse($od->DATE)->format('Y-m-d'))->update([
						// 'in' => (!empty($od->IN_))?$od->IN_:'00:00:00',
						'break' => (!empty($od->BREAK_))?$od->BREAK_:'00:00:00',
						'resume' => (!empty($od->RESUME_))?$od->RESUME_:'00:00:00',
						// 'out' => (!empty($od->OUT_))?$od->OUT_:'00:00:00',
						'work_hour' => $od->WORK,
						'short_hour' => $od->SHORT,
						'leave_taken' => $od->LEAVETYPE,
						'remark' => $od->REMARK,
					]);
				} elseif ( $tcin == '00:00:00' && $tcbreak != '00:00:00' && $tcresume != '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $od->EMPNO)->where('date', Carbon::parse($od->DATE)->format('Y-m-d'))->update([
						'in' => (!empty($od->IN_))?$od->IN_:'00:00:00',
						// 'break' => (!empty($od->BREAK_))?$od->BREAK_:'00:00:00',
						// 'resume' => (!empty($od->RESUME_))?$od->RESUME_:'00:00:00',
						'out' => (!empty($od->OUT_))?$od->OUT_:'00:00:00',
						'work_hour' => $od->WORK,
						'short_hour' => $od->SHORT,
						'leave_taken' => $od->LEAVETYPE,
						'remark' => $od->REMARK,
					]);
				} elseif ( $tcin == '00:00:00' && $tcbreak != '00:00:00' && $tcresume == '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $od->EMPNO)->where('date', Carbon::parse($od->DATE)->format('Y-m-d'))->update([
						'in' => (!empty($od->IN_))?$od->IN_:'00:00:00',
						// 'break' => (!empty($od->BREAK_))?$od->BREAK_:'00:00:00',
						'resume' => (!empty($od->RESUME_))?$od->RESUME_:'00:00:00',
						// 'out' => (!empty($od->OUT_))?$od->OUT_:'00:00:00',
						'work_hour' => $od->WORK,
						'short_hour' => $od->SHORT,
						'leave_taken' => $od->LEAVETYPE,
						'remark' => $od->REMARK,
					]);
				} elseif ( $tcin == '00:00:00' && $tcbreak == '00:00:00' && $tcresume != '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $od->EMPNO)->where('date', Carbon::parse($od->DATE)->format('Y-m-d'))->update([
						'in' => (!empty($od->IN_))?$od->IN_:'00:00:00',
						'break' => (!empty($od->BREAK_))?$od->BREAK_:'00:00:00',
						// 'resume' => (!empty($od->RESUME_))?$od->RESUME_:'00:00:00',
						// 'out' => (!empty($od->OUT_))?$od->OUT_:'00:00:00',
						'work_hour' => $od->WORK,
						'short_hour' => $od->SHORT,
						'leave_taken' => $od->LEAVETYPE,
						'remark' => $od->REMARK,
					]);

				// update 3 column
				} elseif ( $tcin != '00:00:00' && $tcbreak != '00:00:00' && $tcresume != '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $od->EMPNO)->where('date', Carbon::parse($od->DATE)->format('Y-m-d'))->update([
						// 'in' => (!empty($od->IN_))?$od->IN_:'00:00:00',
						// 'break' => (!empty($od->BREAK_))?$od->BREAK_:'00:00:00',
						// 'resume' => (!empty($od->RESUME_))?$od->RESUME_:'00:00:00',
						'out' => (!empty($od->OUT_))?$od->OUT_:'00:00:00',
						'work_hour' => $od->WORK,
						'short_hour' => $od->SHORT,
						'leave_taken' => $od->LEAVETYPE,
						'remark' => $od->REMARK,
					]);
				} elseif ( $tcin == '00:00:00' && $tcbreak != '00:00:00' && $tcresume != '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $od->EMPNO)->where('date', Carbon::parse($od->DATE)->format('Y-m-d'))->update([
						'in' => (!empty($od->IN_))?$od->IN_:'00:00:00',
						// 'break' => (!empty($od->BREAK_))?$od->BREAK_:'00:00:00',
						// 'resume' => (!empty($od->RESUME_))?$od->RESUME_:'00:00:00',
						// 'out' => (!empty($od->OUT_))?$od->OUT_:'00:00:00',
						'work_hour' => $od->WORK,
						'short_hour' => $od->SHORT,
						'leave_taken' => $od->LEAVETYPE,
						'remark' => $od->REMARK,
					]);
				} elseif ( $tcin != '00:00:00' && $tcbreak == '00:00:00' && $tcresume != '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $od->EMPNO)->where('date', Carbon::parse($od->DATE)->format('Y-m-d'))->update([
						// 'in' => (!empty($od->IN_))?$od->IN_:'00:00:00',
						'break' => (!empty($od->BREAK_))?$od->BREAK_:'00:00:00',
						// 'resume' => (!empty($od->RESUME_))?$od->RESUME_:'00:00:00',
						// 'out' => (!empty($od->OUT_))?$od->OUT_:'00:00:00',
						'work_hour' => $od->WORK,
						'short_hour' => $od->SHORT,
						'leave_taken' => $od->LEAVETYPE,
						'remark' => $od->REMARK,
					]);
				} elseif ( $tcin != '00:00:00' && $tcbreak != '00:00:00' && $tcresume == '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $od->EMPNO)->where('date', Carbon::parse($od->DATE)->format('Y-m-d'))->update([
						// 'in' => (!empty($od->IN_))?$od->IN_:'00:00:00',
						// 'break' => (!empty($od->BREAK_))?$od->BREAK_:'00:00:00',
						'resume' => (!empty($od->RESUME_))?$od->RESUME_:'00:00:00',
						// 'out' => (!empty($od->OUT_))?$od->OUT_:'00:00:00',
						'work_hour' => $od->WORK,
						'short_hour' => $od->SHORT,
						'leave_taken' => $od->LEAVETYPE,
						'remark' => $od->REMARK,
					]);
				// not updating any column
				} elseif ( $tcin != '00:00:00' && $tcbreak != '00:00:00' && $tcresume != '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $od->EMPNO)->where('date', Carbon::parse($od->DATE)->format('Y-m-d'))->update([
						// 'in' => (!empty($od->IN_))?$od->IN_:'00:00:00',
						// 'break' => (!empty($od->BREAK_))?$od->BREAK_:'00:00:00',
						// 'resume' => (!empty($od->RESUME_))?$od->RESUME_:'00:00:00',
						// 'out' => (!empty($od->OUT_))?$od->OUT_:'00:00:00',
						'work_hour' => $od->WORK,
						'short_hour' => $od->SHORT,
						'leave_taken' => $od->LEAVETYPE,
						'remark' => $od->REMARK,
					]);
				}
			}
		}
		Session::flash('flash_message', 'Data successfully update!');
		return redirect( route('tcms.index') );
	}

	public function storeCSV(StaffTCMSUpdateRequest $request)
	{
		ini_set('max_execution_time', 3000);

		$filename = Storage::putFile('csv', $request->file('csv'));

		// this onw only to import direct to model
		// Excel::import(new StaffTCMSImport, request()->file('csv'));

		// import to collection
		$collection = Excel::toCollection(new StaffTCMSImport, $request->file('csv'));
		// $collection = (new UsersImport)->toCollection('users.xlsx');

		// echo $collection;

		foreach ($collection->first() as $row) {

			$id = Login::where('username', $row['empno']);

			if( !is_null($id->where('active', 1)) ) {
				$sid = $id->where('active', 1)->first();
			} else {
				$sid = NULL;
			}

			if( !is_null($sid) ) {
				$sid1 = $sid->belongtostaff->active;
			} else {
				$sid1 = 0;
			}

			if( $sid1 == 1 ) {

// echo $sid1.' sid<br />';
// echo $row['empno'].' empno<br />';
// echo Carbon::createFromFormat('d/m/Y', $row['date'])->format('Y-m-d').' date<br />';
				// run query updateOrCreate
				$tc = StaffTCMS::where('username', $row['empno'])->where('date', Carbon::createFromFormat('d/m/Y', $row['date'])->format('Y-m-d') )->first();

				if( is_null($tc) ) {
					$tcname = NULL;
					$tcdate = NULL;
					$tcin = NULL;
					$tcbreak = NULL;
					$tcresume = NULL;
					$tcout = NULL;
				} else {
					$tcname = $tc->name;
					$tcdate = $tc->date;
					$tcin = $tc->in;
					$tcbreak = $tc->break;
					$tcresume = $tc->resume;
					$tcout = $tc->out;
				}

				// echo $tcname.' name<br />'.$tcdate.' date<br />'.$tcin.' in<br />'.$tcbreak.' break<br />'.$tcresume.' resume<br />'.$tcout.' out<br /><br />';

				if( is_null($tc) ) {
					StaffTCMS::create([
											'username' => $row['empno'],
											'date' => Carbon::createFromFormat('d/m/Y', $row['date'])->format('Y-m-d') ,
											'staff_id' => $sid->staff_id,
											'name' => $row['name'],
											'daytype' => $row['day_type'],
											'in' => (!empty($row['in']))?$row['in']:'00:00:00',
											'break' => (!empty($row['break']))?$row['break']:'00:00:00',
											'resume' => (!empty($row['resume']))?$row['resume']:'00:00:00',
											'out' => (!empty($row['out']))?$row['out']:'00:00:00',
											'work_hour' => $row['work'],
											'short_hour' => $row['short_minutes'],
											'leave_taken' => $row['leavetype'],
											'remark' => $row['remark'],
					]);

				// update all column
				} elseif ( $tcin == '00:00:00' && $tcbreak == '00:00:00' && $tcresume == '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::createFromFormat('d/m/Y', $row['date'])->format('Y-m-d') )->update([
						'in' => (!empty($row['in']))?$row['in']:'00:00:00',
						'break' => (!empty($row['break']))?$row['break']:'00:00:00',
						'resume' => (!empty($row['resume']))?$row['resume']:'00:00:00',
						'out' => (!empty($row['out']))?$row['out']:'00:00:00',
						'work_hour' => $row['work'],
						'short_hour' => $row['short_minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['remark'],
					]);

				// update 1 column only
				} elseif ( $tcin != '00:00:00' && $tcbreak == '00:00:00' && $tcresume == '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::createFromFormat('d/m/Y', $row['date'])->format('Y-m-d') )->update([
						// 'in' => (!empty($row['in']))?$row['in']:'00:00:00',
						'break' => (!empty($row['break']))?$row['break']:'00:00:00',
						'resume' => (!empty($row['resume']))?$row['resume']:'00:00:00',
						'out' => (!empty($row['out']))?$row['out']:'00:00:00',
						'work_hour' => $row['work'],
						'short_hour' => $row['short_minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['remark'],
					]);
				} elseif ( $tcin == '00:00:00' && $tcbreak != '00:00:00' && $tcresume == '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::createFromFormat('d/m/Y', $row['date'])->format('Y-m-d') )->update([
						'in' => (!empty($row['in']))?$row['in']:'00:00:00',
						// 'break' => (!empty($row['break']))?$row['break']:'00:00:00',
						'resume' => (!empty($row['resume']))?$row['resume']:'00:00:00',
						'out' => (!empty($row['out']))?$row['out']:'00:00:00',
						'work_hour' => $row['work'],
						'short_hour' => $row['short_minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['remark'],
					]);
				} elseif ( $tcin == '00:00:00' && $tcbreak == '00:00:00' && $tcresume != '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::createFromFormat('d/m/Y', $row['date'])->format('Y-m-d') )->update([
						'in' => (!empty($row['in']))?$row['in']:'00:00:00',
						'break' => (!empty($row['break']))?$row['break']:'00:00:00',
						// 'resume' => (!empty($row['resume']))?$row['resume']:'00:00:00',
						'out' => (!empty($row['out']))?$row['out']:'00:00:00',
						'work_hour' => $row['work'],
						'short_hour' => $row['short_minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['remark'],
					]);
				} elseif ( $tcin == '00:00:00' && $tcbreak == '00:00:00' && $tcresume == '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::createFromFormat('d/m/Y', $row['date'])->format('Y-m-d') )->update([
						'in' => (!empty($row['in']))?$row['in']:'00:00:00',
						'break' => (!empty($row['break']))?$row['break']:'00:00:00',
						'resume' => (!empty($row['resume']))?$row['resume']:'00:00:00',
						// 'out' => (!empty($row['out']))?$row['out']:'00:00:00',
						'work_hour' => $row['work'],
						'short_hour' => $row['short_minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['remark'],
					]);

				// update 2 column only
				} elseif ( $tcin != '00:00:00' && $tcbreak != '00:00:00' && $tcresume == '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::createFromFormat('d/m/Y', $row['date'])->format('Y-m-d') )->update([
						// 'in' => (!empty($row['in']))?$row['in']:'00:00:00',
						// 'break' => (!empty($row['break']))?$row['break']:'00:00:00',
						'resume' => (!empty($row['resume']))?$row['resume']:'00:00:00',
						'out' => (!empty($row['out']))?$row['out']:'00:00:00',
						'work_hour' => $row['work'],
						'short_hour' => $row['short_minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['remark'],
					]);
				} elseif ( $tcin != '00:00:00' && $tcbreak == '00:00:00' && $tcresume != '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::createFromFormat('d/m/Y', $row['date'])->format('Y-m-d') )->update([
						// 'in' => (!empty($row['in']))?$row['in']:'00:00:00',
						'break' => (!empty($row['break']))?$row['break']:'00:00:00',
						// 'resume' => (!empty($row['resume']))?$row['resume']:'00:00:00',
						'out' => (!empty($row['out']))?$row['out']:'00:00:00',
						'work_hour' => $row['work'],
						'short_hour' => $row['short_minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['remark'],
					]);
				} elseif ( $tcin != '00:00:00' && $tcbreak == '00:00:00' && $tcresume == '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::createFromFormat('d/m/Y', $row['date'])->format('Y-m-d') )->update([
						// 'in' => (!empty($row['in']))?$row['in']:'00:00:00',
						'break' => (!empty($row['break']))?$row['break']:'00:00:00',
						'resume' => (!empty($row['resume']))?$row['resume']:'00:00:00',
						// 'out' => (!empty($row['out']))?$row['out']:'00:00:00',
						'work_hour' => $row['work'],
						'short_hour' => $row['short_minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['remark'],
					]);
				} elseif ( $tcin == '00:00:00' && $tcbreak != '00:00:00' && $tcresume != '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::createFromFormat('d/m/Y', $row['date'])->format('Y-m-d') )->update([
						'in' => (!empty($row['in']))?$row['in']:'00:00:00',
						// 'break' => (!empty($row['break']))?$row['break']:'00:00:00',
						// 'resume' => (!empty($row['resume']))?$row['resume']:'00:00:00',
						'out' => (!empty($row['out']))?$row['out']:'00:00:00',
						'work_hour' => $row['work'],
						'short_hour' => $row['short_minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['remark'],
					]);
				} elseif ( $tcin == '00:00:00' && $tcbreak != '00:00:00' && $tcresume == '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::createFromFormat('d/m/Y', $row['date'])->format('Y-m-d') )->update([
						'in' => (!empty($row['in']))?$row['in']:'00:00:00',
						// 'break' => (!empty($row['break']))?$row['break']:'00:00:00',
						'resume' => (!empty($row['resume']))?$row['resume']:'00:00:00',
						// 'out' => (!empty($row['out']))?$row['out']:'00:00:00',
						'work_hour' => $row['work'],
						'short_hour' => $row['short_minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['remark'],
					]);
				} elseif ( $tcin == '00:00:00' && $tcbreak == '00:00:00' && $tcresume != '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::createFromFormat('d/m/Y', $row['date'])->format('Y-m-d') )->update([
						'in' => (!empty($row['in']))?$row['in']:'00:00:00',
						'break' => (!empty($row['break']))?$row['break']:'00:00:00',
						// 'resume' => (!empty($row['resume']))?$row['resume']:'00:00:00',
						// 'out' => (!empty($row['out']))?$row['out']:'00:00:00',
						'work_hour' => $row['work'],
						'short_hour' => $row['short_minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['remark'],
					]);

				// update 3 column
				} elseif ( $tcin != '00:00:00' && $tcbreak != '00:00:00' && $tcresume != '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::createFromFormat('d/m/Y', $row['date'])->format('Y-m-d') )->update([
						// 'in' => (!empty($row['in']))?$row['in']:'00:00:00',
						// 'break' => (!empty($row['break']))?$row['break']:'00:00:00',
						// 'resume' => (!empty($row['resume']))?$row['resume']:'00:00:00',
						'out' => (!empty($row['out']))?$row['out']:'00:00:00',
						'work_hour' => $row['work'],
						'short_hour' => $row['short_minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['remark'],
					]);
				} elseif ( $tcin == '00:00:00' && $tcbreak != '00:00:00' && $tcresume != '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::createFromFormat('d/m/Y', $row['date'])->format('Y-m-d') )->update([
						'in' => (!empty($row['in']))?$row['in']:'00:00:00',
						// 'break' => (!empty($row['break']))?$row['break']:'00:00:00',
						// 'resume' => (!empty($row['resume']))?$row['resume']:'00:00:00',
						// 'out' => (!empty($row['out']))?$row['out']:'00:00:00',
						'work_hour' => $row['work'],
						'short_hour' => $row['short_minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['remark'],
					]);
				} elseif ( $tcin != '00:00:00' && $tcbreak == '00:00:00' && $tcresume != '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::createFromFormat('d/m/Y', $row['date'])->format('Y-m-d') )->update([
						// 'in' => (!empty($row['in']))?$row['in']:'00:00:00',
						'break' => (!empty($row['break']))?$row['break']:'00:00:00',
						// 'resume' => (!empty($row['resume']))?$row['resume']:'00:00:00',
						// 'out' => (!empty($row['out']))?$row['out']:'00:00:00',
						'work_hour' => $row['work'],
						'short_hour' => $row['short_minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['remark'],
					]);
				} elseif ( $tcin != '00:00:00' && $tcbreak != '00:00:00' && $tcresume == '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::createFromFormat('d/m/Y', $row['date'])->format('Y-m-d') )->update([
						// 'in' => (!empty($row['in']))?$row['in']:'00:00:00',
						// 'break' => (!empty($row['break']))?$row['break']:'00:00:00',
						'resume' => (!empty($row['resume']))?$row['resume']:'00:00:00',
						// 'out' => (!empty($row['out']))?$row['out']:'00:00:00',
						'work_hour' => $row['work'],
						'short_hour' => $row['short_minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['remark'],
					]);
				// not updating any column
				} elseif ( $tcin != '00:00:00' && $tcbreak != '00:00:00' && $tcresume != '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::createFromFormat('d/m/Y', $row['date'])->format('Y-m-d') )->update([
						// 'in' => (!empty($row['in']))?$row['in']:'00:00:00',
						// 'break' => (!empty($row['break']))?$row['break']:'00:00:00',
						// 'resume' => (!empty($row['resume']))?$row['resume']:'00:00:00',
						// 'out' => (!empty($row['out']))?$row['out']:'00:00:00',
						'work_hour' => $row['work'],
						'short_hour' => $row['short_minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['remark'],
					]);
				}
			}
		}
		Session::flash('flash_message', 'Data successfully update!');
		return redirect( route('tcms.index') );
	}

	public function store(Request $request)
	{
	
	}

	public function show(StaffTCMS $staffTCMS)
	{
	//
	}

	public function edit(Request $request, StaffTCMS $staffTCMS)
	{
		$date = $request->date;
		// print_r( $request->segments(1) );
		// echo $request->segment(2);
		$staff_id = $request->segment(2);
		return view('generalAndAdministrative.hr.tcms.edit', compact(['staffTCMS', 'date', 'staff_id']));
	}

	public function update(Request $request, StaffTCMS $staffTCMS)
	{
		// echo $request->date.' <br />';
		// echo $request->segment(2);
		// print_r( $request->all() );

		$in = Carbon::parse($request->in)->format('H:i:s');
		$break = Carbon::parse($request->break)->format('H:i:s');
		$resume = Carbon::parse($request->resume)->format('H:i:s');
		$out = Carbon::parse($request->out)->format('H:i:s');

		// echo $in;

		$staffTCMS = StaffTCMS::where([ ['staff_id', $request->segment(2)],	['date', $request->date] ]);

		$staffTCMS->update([
								'in' => $in,
								'break' => $break,
								'resume' => $resume,
								'out' => $out,
								'leave_taken' => $request->leave_taken,
								'remark' => $request->remark,
								'exception' => $request->exception,
		]);

		Session::flash('flash_message', 'Data successfully edited!');
		return redirect( route('tcms.index') );
	}

	public function destroy(StaffTCMS $staffTCMS)
	{
	//
	}
}
