<?php

// https://github.com/Maatwebsite/Laravel-Excel

namespace App\Imports;

// load model
use App\StaffTCMS;
use App\StaffTCMS;

use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

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

			StaffTCMS::updateOrCreate([
				[
					'username' => $row['empno'],
					'date' => Carbon::parse($row['Date'])->format('Y-m-d')
				],
				[
					'staff_id' => $sid->staff_id,
					'name' => $row['name'],
					'daytype' => $row['DayType'],
					'in' => (!empty($row['in_']))?$row['in_']:'00:00:00',
					'break' => (!empty($row['break_']))?$row['break_']:'00:00:00',
					'resume' => (!empty($row['resume_']))?$row['resume_']:'00:00:00',
					'out' => (!empty($row['out_']))?$row['out_']:'00:00:00',
					'work_hour' => $row['Work'],
					'short_hour' => $row['ShortMinutes'],
					'leave_taken' => $row['leavetype'],
					'remark' => $row['Remark'],
					// 'exception' => $od->,
					// 'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
					// 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
					// 'deleted_at' => NULL
			]);
		}
	}
}
