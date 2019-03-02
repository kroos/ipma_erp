<?php
use \App\Model\Staff;
use \App\Model\StaffDisciplinaryAction;

use \Carbon\Carbon;
use \Carbon\CarbonPeriod;

?>
<div class="card">
	<div class="card-header">Staff Disciplinary Action List</div>
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
							<th>Disciplinary Action</th>
						</tr>
					</thead>
					<tbody>
@foreach(Staff::where('active', 1)->whereNotIn('id', ['191', '192'])->get() AS $st)
						<tr>
							<td><a href="{!! route('staffDisciplinaryAct.create', 'staff_id='.$st->id) !!}"><i class="fas fa-chalkboard-teacher"></i>&nbsp;{!! $st->hasmanylogin()->where('active', 1)->first()->username !!}</a></td>
							<td>{!! $st->name !!}</td>
							<td>{!! $st->belongtolocation->location !!}</td>
							<td>{!! $st->belongtomanyposition()->wherePivot('main', 1)->first()->belongtodepartment->department !!}</td>
							<td>
@if(StaffDisciplinaryAction::where('staff_id', $st->id)->get()->count() > 0)
								<table class="table table-hover table-sm" style="font-size:12px" id="staff">
									<thead>
										<tr>
											<th>ID</th>
											<th>Date</th>
											<th>Disciplinary Action</th>
											<th>Description</th>
											<th>&nbsp;</th>
										</tr>
									</thead>
									<tbody>
@foreach(StaffDisciplinaryAction::where('staff_id', $st->id)->get() as $da)
										<tr>
											<td align="center"><a href="{!! route('staffDisciplinaryAct.edit', $da->id) !!}" title="Edit">{!! $da->id !!}</a></td>
											<td>{!! Carbon::parse($da->date)->format('j M Y') !!}</td>
											<td>{!! $da->belongtodisciplinaryaction->disciplinary_action !!}</td>
											<td>{!! $da->description !!}</td>
											<td>
										<span title="Delete" class="text-danger remove_staffDiscAct" data-id="{!! $da->id !!}">
											<i class="far fa-trash-alt"></i>
										</span>
											</td>
										</tr>
@endforeach
									</tbody>
								</table>
@endif
							</td>
						</tr>
@endforeach
					</tbody>
				</table>
			</div>
		</div>

		<br />

		<div class="card">
			<div class="card-header">Inactive Staff List</div>
			<div class="card-body">
				<table class="table table-hover table-sm" style="font-size:12px" id="staff1">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Loc</th>
							<th>Department</th>
							<th>Disciplinary Action</th>
						</tr>
					</thead>
					<tbody>
@foreach(Staff::where('active', 0)->whereNotIn('id', ['191', '192'])->get() AS $st)
						<tr>
							<td>
@foreach($st->hasmanylogin()->get() as $sty)
	{!! $sty->username !!} <br />
@endforeach
							</td>
							<td>{!! $st->name !!}</td>
							<td>
								{!! $st->belongtolocation->location !!}
							</td>
							<td>
@if($st->belongtomanyposition()->get()->count() > 0)
								{!! $st->belongtomanyposition()->wherePivot('main', 1)->first()->belongtodepartment->department !!}
@endif
							</td>
							<td>
@if(StaffDisciplinaryAction::where('staff_id', $st->id)->get()->count() > 0)
								<table class="table table-hover table-sm" style="font-size:12px" id="staff">
									<thead>
										<tr>
											<th>ID</th>
											<th>Date</th>
											<th>Disciplinary Action</th>
											<th>Description</th>
										</tr>
									</thead>
									<tbody>
@foreach(StaffDisciplinaryAction::where('staff_id', $st->id)->get() as $da)
										<tr>
											<td align="center">{!! $da->id !!}</td>
											<td>{!! Carbon::parse($da->date)->format('j M Y') !!}</td>
											<td>{!! $da->belongtodisciplinaryaction->disciplinary_action !!}</td>
											<td>{!! $da->description !!}</td>
										</tr>
@endforeach
									</tbody>
								</table>
@endif
							</td>
						</tr>
@endforeach
					</tbody>
				</table>
			</div>
		</div>

	</div>
</div>