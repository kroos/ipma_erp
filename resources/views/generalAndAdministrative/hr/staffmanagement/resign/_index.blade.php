<?php
use \App\Model\Staff;

use \Carbon\Carbon;
use \Carbon\CarbonPeriod;

?>
<div class="card">
	<div class="card-header">Staff Resignation List</div>
	<div class="card-body">

		<div class="card">
			<div class="card-header">Active Staff List</div>
			<div class="card-body">
				<table class="table table-hover table-sm" style="font-size:12px" id="staff1">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Loc</th>
							<th>Department</th>
							<th>Letter Resignation Date</th>
							<th>Resignation Date</th>
						</tr>
					</thead>
					<tbody>
@foreach(Staff::where('active', 1)->whereNotIn('id', ['191', '192'])->get() AS $st)
						<tr>
							<td><a href="{!! route('staffResign.edit', $st->id) !!}" title="Staff Resign"><i class="far fa-envelope"></i>&nbsp;{!! $st->hasmanylogin()->where('active', 1)->first()->username !!}</a></td>
							<td>{!! $st->name !!}</td>
							<td>{!! $st->belongtolocation->location !!}</td>
							<td>{!! $st->belongtomanyposition()->wherePivot('main', 1)->first()->belongtodepartment->department !!}</td>
							<td>
								{!! (!is_null($st->resignation_letter_at))?\Carbon\Carbon::parse($st->resignation_letter_at)->format('D, j F Y'):NULL !!}
							</td>
							<td>
								{!! (!is_null($st->resign_at))?\Carbon\Carbon::parse($st->resign_at)->format('D, j F Y'):NULL !!}
							</td>
						</tr>
@endforeach
					</tbody>
				</table>
			</div>
		</div>

	</div>
</div>