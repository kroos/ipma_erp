<?php

// https://github.com/Maatwebsite/Laravel-Excel

namespace App\Imports;

// load model
use App\Model\StaffTCMS;
use App\Model\Login;
use App\Model\Staff;
use App\Model\StaffTCMSODBC;

// load EXCEL Maatwebsite
use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use Maatwebsite\Excel\Imports\HeadingRowFormatter;

// this will NOT convert any "space" to "_"
// HeadingRowFormatter::default('none');

class StaffTCMSImport implements ToCollection, WithHeadingRow
{
	public function collection(Collection $rows)
	{
		foreach ($rows as $row) {

			$id = Login::where('username', $row['empno']);
			if( !is_null($id->where('active', 1)) ) {
				$sid = $id->where('active', 1)->first();
			} else {
				$sid = NULL;
			}

			if( $sid->belongtostaff->active == 1 ) {

				// run query updateOrCreate
				$tc = StaffTCMS::where('username', $row['empno'])->where('date', Carbon::parse($row['Date'])->format('Y-m-d'))->first();

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

				echo $tcname.' name<br />'.$tcdate.' date<br />'.$tcin.' in<br />'.$tcbreak.' break<br />'.$tcresume.' resume<br />'.$tcout.' out<br /><br />';

				if( is_null($tc) ) {
					StaffTCMS::create([
											'username' => $row['empno'],
											'date' => Carbon::parse($row['Date'])->format('Y-m-d'),
											'staff_id' => $sid->staff_id,
											'name' => $row['Name'],
											'daytype' => $row['Day_Type'],
											'in' => (!empty($row['in_']))?$row['in_']:'00:00:00',
											'break' => (!empty($row['break_']))?$row['break_']:'00:00:00',
											'resume' => (!empty($row['resume_']))?$row['resume_']:'00:00:00',
											'out' => (!empty($row['out_']))?$row['out_']:'00:00:00',
											'work_hour' => $row['Work'],
											'short_hour' => $row['Short_Minutes'],
											'leave_taken' => $row['leavetype'],
											'remark' => $row['Remark'],
					]);

				// update all column
				} elseif ( $tcin == '00:00:00' && $tcbreak == '00:00:00' && $tcresume == '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::parse($row['Date'])->format('Y-m-d'))->update([
						'in' => (!empty($row['in_']))?$row['in_']:'00:00:00',
						'break' => (!empty($row['break_']))?$row['break_']:'00:00:00',
						'resume' => (!empty($row['resume_']))?$row['resume_']:'00:00:00',
						'out' => (!empty($row['out_']))?$row['out_']:'00:00:00',
						'work_hour' => $row['Work'],
						'short_hour' => $row['Short_Minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['Remark'],
					]);

				// update 1 column only
				} elseif ( $tcin != '00:00:00' && $tcbreak == '00:00:00' && $tcresume == '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::parse($row['Date'])->format('Y-m-d'))->update([
						// 'in' => (!empty($row['in_']))?$row['in_']:'00:00:00',
						'break' => (!empty($row['break_']))?$row['break_']:'00:00:00',
						'resume' => (!empty($row['resume_']))?$row['resume_']:'00:00:00',
						'out' => (!empty($row['out_']))?$row['out_']:'00:00:00',
						'work_hour' => $row['Work'],
						'short_hour' => $row['Short_Minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['Remark'],
					]);
				} elseif ( $tcin == '00:00:00' && $tcbreak != '00:00:00' && $tcresume == '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::parse($row['Date'])->format('Y-m-d'))->update([
						'in' => (!empty($row['in_']))?$row['in_']:'00:00:00',
						// 'break' => (!empty($row['break_']))?$row['break_']:'00:00:00',
						'resume' => (!empty($row['resume_']))?$row['resume_']:'00:00:00',
						'out' => (!empty($row['out_']))?$row['out_']:'00:00:00',
						'work_hour' => $row['Work'],
						'short_hour' => $row['Short_Minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['Remark'],
					]);
				} elseif ( $tcin == '00:00:00' && $tcbreak == '00:00:00' && $tcresume != '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::parse($row['Date'])->format('Y-m-d'))->update([
						'in' => (!empty($row['in_']))?$row['in_']:'00:00:00',
						'break' => (!empty($row['break_']))?$row['break_']:'00:00:00',
						// 'resume' => (!empty($row['resume_']))?$row['resume_']:'00:00:00',
						'out' => (!empty($row['out_']))?$row['out_']:'00:00:00',
						'work_hour' => $row['Work'],
						'short_hour' => $row['Short_Minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['Remark'],
					]);
				} elseif ( $tcin == '00:00:00' && $tcbreak == '00:00:00' && $tcresume == '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::parse($row['Date'])->format('Y-m-d'))->update([
						'in' => (!empty($row['in_']))?$row['in_']:'00:00:00',
						'break' => (!empty($row['break_']))?$row['break_']:'00:00:00',
						'resume' => (!empty($row['resume_']))?$row['resume_']:'00:00:00',
						// 'out' => (!empty($row['out_']))?$row['out_']:'00:00:00',
						'work_hour' => $row['Work'],
						'short_hour' => $row['Short_Minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['Remark'],
					]);

				// update 2 column only
				} elseif ( $tcin != '00:00:00' && $tcbreak != '00:00:00' && $tcresume == '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::parse($row['Date'])->format('Y-m-d'))->update([
						// 'in' => (!empty($row['in_']))?$row['in_']:'00:00:00',
						// 'break' => (!empty($row['break_']))?$row['break_']:'00:00:00',
						'resume' => (!empty($row['resume_']))?$row['resume_']:'00:00:00',
						'out' => (!empty($row['out_']))?$row['out_']:'00:00:00',
						'work_hour' => $row['Work'],
						'short_hour' => $row['Short_Minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['Remark'],
					]);
				} elseif ( $tcin != '00:00:00' && $tcbreak == '00:00:00' && $tcresume != '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::parse($row['Date'])->format('Y-m-d'))->update([
						// 'in' => (!empty($row['in_']))?$row['in_']:'00:00:00',
						'break' => (!empty($row['break_']))?$row['break_']:'00:00:00',
						// 'resume' => (!empty($row['resume_']))?$row['resume_']:'00:00:00',
						'out' => (!empty($row['out_']))?$row['out_']:'00:00:00',
						'work_hour' => $row['Work'],
						'short_hour' => $row['Short_Minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['Remark'],
					]);
				} elseif ( $tcin != '00:00:00' && $tcbreak == '00:00:00' && $tcresume == '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::parse($row['Date'])->format('Y-m-d'))->update([
						// 'in' => (!empty($row['in_']))?$row['in_']:'00:00:00',
						'break' => (!empty($row['break_']))?$row['break_']:'00:00:00',
						'resume' => (!empty($row['resume_']))?$row['resume_']:'00:00:00',
						// 'out' => (!empty($row['out_']))?$row['out_']:'00:00:00',
						'work_hour' => $row['Work'],
						'short_hour' => $row['Short_Minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['Remark'],
					]);
				} elseif ( $tcin == '00:00:00' && $tcbreak != '00:00:00' && $tcresume != '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::parse($row['Date'])->format('Y-m-d'))->update([
						'in' => (!empty($row['in_']))?$row['in_']:'00:00:00',
						// 'break' => (!empty($row['break_']))?$row['break_']:'00:00:00',
						// 'resume' => (!empty($row['resume_']))?$row['resume_']:'00:00:00',
						'out' => (!empty($row['out_']))?$row['out_']:'00:00:00',
						'work_hour' => $row['Work'],
						'short_hour' => $row['Short_Minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['Remark'],
					]);
				} elseif ( $tcin == '00:00:00' && $tcbreak != '00:00:00' && $tcresume == '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::parse($row['Date'])->format('Y-m-d'))->update([
						'in' => (!empty($row['in_']))?$row['in_']:'00:00:00',
						// 'break' => (!empty($row['break_']))?$row['break_']:'00:00:00',
						'resume' => (!empty($row['resume_']))?$row['resume_']:'00:00:00',
						// 'out' => (!empty($row['out_']))?$row['out_']:'00:00:00',
						'work_hour' => $row['Work'],
						'short_hour' => $row['Short_Minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['Remark'],
					]);
				} elseif ( $tcin == '00:00:00' && $tcbreak == '00:00:00' && $tcresume != '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::parse($row['Date'])->format('Y-m-d'))->update([
						'in' => (!empty($row['in_']))?$row['in_']:'00:00:00',
						'break' => (!empty($row['break_']))?$row['break_']:'00:00:00',
						// 'resume' => (!empty($row['resume_']))?$row['resume_']:'00:00:00',
						// 'out' => (!empty($row['out_']))?$row['out_']:'00:00:00',
						'work_hour' => $row['Work'],
						'short_hour' => $row['Short_Minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['Remark'],
					]);

				// update 3 column
				} elseif ( $tcin != '00:00:00' && $tcbreak != '00:00:00' && $tcresume != '00:00:00' && $tcout == '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::parse($row['Date'])->format('Y-m-d'))->update([
						// 'in' => (!empty($row['in_']))?$row['in_']:'00:00:00',
						// 'break' => (!empty($row['break_']))?$row['break_']:'00:00:00',
						// 'resume' => (!empty($row['resume_']))?$row['resume_']:'00:00:00',
						'out' => (!empty($row['out_']))?$row['out_']:'00:00:00',
						'work_hour' => $row['Work'],
						'short_hour' => $row['Short_Minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['Remark'],
					]);
				} elseif ( $tcin == '00:00:00' && $tcbreak != '00:00:00' && $tcresume != '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::parse($row['Date'])->format('Y-m-d'))->update([
						'in' => (!empty($row['in_']))?$row['in_']:'00:00:00',
						// 'break' => (!empty($row['break_']))?$row['break_']:'00:00:00',
						// 'resume' => (!empty($row['resume_']))?$row['resume_']:'00:00:00',
						// 'out' => (!empty($row['out_']))?$row['out_']:'00:00:00',
						'work_hour' => $row['Work'],
						'short_hour' => $row['Short_Minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['Remark'],
					]);
				} elseif ( $tcin != '00:00:00' && $tcbreak == '00:00:00' && $tcresume != '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::parse($row['Date'])->format('Y-m-d'))->update([
						// 'in' => (!empty($row['in_']))?$row['in_']:'00:00:00',
						'break' => (!empty($row['break_']))?$row['break_']:'00:00:00',
						// 'resume' => (!empty($row['resume_']))?$row['resume_']:'00:00:00',
						// 'out' => (!empty($row['out_']))?$row['out_']:'00:00:00',
						'work_hour' => $row['Work'],
						'short_hour' => $row['Short_Minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['Remark'],
					]);
				} elseif ( $tcin != '00:00:00' && $tcbreak != '00:00:00' && $tcresume == '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::parse($row['Date'])->format('Y-m-d'))->update([
						// 'in' => (!empty($row['in_']))?$row['in_']:'00:00:00',
						// 'break' => (!empty($row['break_']))?$row['break_']:'00:00:00',
						'resume' => (!empty($row['resume_']))?$row['resume_']:'00:00:00',
						// 'out' => (!empty($row['out_']))?$row['out_']:'00:00:00',
						'work_hour' => $row['Work'],
						'short_hour' => $row['Short_Minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['Remark'],
					]);
				// not updating any column
				} elseif ( $tcin != '00:00:00' && $tcbreak != '00:00:00' && $tcresume != '00:00:00' && $tcout != '00:00:00' ) {
					StaffTCMS::where('username', $row['empno'])->where('date', Carbon::parse($row['Date'])->format('Y-m-d'))->update([
						// 'in' => (!empty($row['in_']))?$row['in_']:'00:00:00',
						// 'break' => (!empty($row['break_']))?$row['break_']:'00:00:00',
						// 'resume' => (!empty($row['resume_']))?$row['resume_']:'00:00:00',
						// 'out' => (!empty($row['out_']))?$row['out_']:'00:00:00',
						'work_hour' => $row['Work'],
						'short_hour' => $row['Short_Minutes'],
						'leave_taken' => $row['leavetype'],
						'remark' => $row['Remark'],
					]);
				}
			}
		}
	}
}
