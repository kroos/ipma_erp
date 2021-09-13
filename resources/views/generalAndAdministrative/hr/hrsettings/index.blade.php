@extends('layouts.app')

@section('content')
<?php
// load model
use App\Model\HumanResource\HRSettings\WorkingHour;
use App\Model\HolidayCalendar;

// penting sgt nihhh.. carbon niiii..
use \Carbon\Carbon;

$yp = WorkingHour::groupBy('year')->select('year')->get();
$yhc = HolidayCalendar::groupBy('yaer')->selectRaw('YEAR(date_start) as yaer')->get();
// echo $yhc.' year<br />';
?>
<div class="card">
	<div class="card-header"><h1>Human Resource Department</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

		<ul class="nav nav-tabs">
@foreach( App\Model\Division::find(1)->hasmanydepartment()->whereNotIn('id', [22, 23, 24])->get() as $key)
			<li class="nav-item">
				<a class="nav-link {{ ($key->id == 3)? 'active' : 'disabled' }}" href="{{ route("$key->route.index") }}">{{ $key->department }}</a>
			</li>
@endforeach
		</ul>

		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link active" href="{{ route('hrSettings.index') }}">Settings</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('staffManagement.index') }}">Staff Management</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('leaveEditing.index') }}">Leave</a>
			</li>
			<li class="nav-item">
				<a class="nav-link " href="{{ route('tcms.index') }}">TCMS</a>
			</li>
		</ul>

<div class="card">
	<div class="card-header">Human Resource Settings</div>
	<div class="card-body">

		<div class="card">
			<div class="card-header">Settings</div>
			<div class="card-body">
				<div class="row">
					<div class="col-6">
						<h5>Double Date Checking</h5>
@foreach(\App\Model\HRSettingsDoubleDate::all() as $r)
						<dl class="row">
							<dt class="col-10">Yes - User will be block from taking a leave within same date<br />No - User can apply a leave within the same date</dt>
							<dd class="col-2">

								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
									{!! $r->belongtoyesno->label !!}
								</button>
								<!-- Modal -->
{{ Form::model($r, ['route' => ['settingDoubleDate.update', $r->id], 'method' => 'PATCH', 'id' => 'form', 'class' => 'form-horizontal', 'autocomplete' => 'off', 'files' => true]) }}
								<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalCenterTitle">Change Double Date Setting</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<div class="form-group row {!! $errors->has('double_date_setting') ? ' has-error' : '' !!}">
													<label for="ddc" class="col-sm-8 col-form-label">Enable Double Date Checking ?</label>
													<div class="col-sm-4">
@foreach(\App\Model\YesNoLabel::all() as $t)
														<div class="pretty p-icon p-curve">
															<input type="radio" name="double_date_setting" value="{!! $t->value !!}" {!! ($r->double_date_setting == $t->value)?'checked':NULL !!}>
															<div class="state p-success">
																<i class="icon mdi mdi-check"></i>
																<label> {!! $t->label !!}</label>
															</div>
														</div>
@endforeach
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
												<button type="submit" class="btn btn-primary">Save Changes</button>
											</div>
										</div>
									</div>
								</div>
{!! Form::close() !!}

							</dd>
						</dl>
@endforeach
					</div>
					<div class="col-6">
						<h5>3 Days Submit Checking</h5>

@foreach(\App\Model\HRSettings3Days::all() as $r1)
						<dl class="row">
							<dt class="col-10">
								Yes - System will block users upon taking a leave if leave is submitted less than 3 days.
									<br />
								No - System will pass users upon taking a leave regardless of days.
							</dt>
							<dd class="col-2">

								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter1">
									{!! $r1->belongtoyesno->label !!}
								</button>
								<!-- Modal -->
{{ Form::model($r1, ['route' => ['setting3DaysChecking.update', $r1->id], 'method' => 'PATCH', 'id' => 'form', 'class' => 'form-horizontal', 'autocomplete' => 'off', 'files' => true]) }}
								<div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalCenterTitle">Change 3 Days Checking Setting</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<div class="form-group row {!! $errors->has('3_days_checking') ? ' has-error' : '' !!}">
													<label for="ddc" class="col-sm-8 col-form-label">Enable 3 Days Checking ?</label>
													<div class="col-sm-4">
@foreach(\App\Model\YesNoLabel::all() as $t1)
														<div class="pretty p-icon p-curve">
															<input type="radio" name="t3_days_checking" value="{!! $t1->value !!}" {!! ($r1->{'t3_days_checking'} == $t1->value)?'checked':NULL !!}>
															<div class="state p-success">
																<i class="icon mdi mdi-check"></i>
																<label> {!! $t1->label !!}</label>
															</div>
														</div>
@endforeach
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
												<button type="submit" class="btn btn-primary">Save Changes</button>
											</div>
										</div>
									</div>
								</div>
{!! Form::close() !!}

							</dd>
						</dl>
@endforeach

					</div>
				</div>
			</div>
		</div>

	<br />

	<div class="card">
		<div class="card-header">Working Hours</div>
		<div class="card-body table-responsive">
			<table class="table table-hover table-sm" style="font-size:12px">
@foreach($yp as $tp)
				<thead>
					<tr>
						<th class="text-center" colspan="8">Normal Working Hours ({{ $tp->year }})</th>
					</tr>
					<tr>
						<th>Year</th>
						<th>Time Start AM</th>
						<th>Time End AM</th>
						<th>Time Start PM</th>
						<th>Time End PM</th>
						<th>Effective Date From</th>
						<th>Effective Date To</th>
						<th>Remarks</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
@foreach(WorkingHour::where('maintenance', 0)->where('year', $tp->year)->orderBy('year')->orderBy('effective_date_start')->get() as $t)
					<tr>
						<td>{{ $t->year }}</td>
						<td>{{ Carbon::parse($t->time_start_am)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->time_end_am)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->time_start_pm)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->time_end_pm)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->effective_date_start)->format('D, j M Y') }}</td>
						<td>{{ Carbon::parse($t->effective_date_end)->format('D, j M Y') }}</td>
						<td>{{ $t->remarks }}</td>
						<td> <a class="" href="{{ route('workingHour.edit', $t->id) }}"><i class="far fa-edit"></i></a> </td>
					</tr>
@endforeach
				</tbody>
				<thead>
					<tr>
						<th class="text-center" colspan="8">Maintenance Working Hours {{ $tp->year }}</th>
					</tr>
					<tr>
						<th>Year</th>
						<th>Time Start AM</th>
						<th>Time End AM</th>
						<th>Time Start PM</th>
						<th>Time End PM</th>
						<th>Effective Date From</th>
						<th>Effective Date To</th>
						<th>Remarks</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
@foreach(WorkingHour::where('maintenance', 1)->where('year', $tp->year)->orderBy('year')->orderBy('effective_date_start')->get() as $t)
					<tr>
						<td>{{ $t->year }}</td>
						<td>{{ Carbon::parse($t->time_start_am)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->time_end_am)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->time_start_pm)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->time_end_pm)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->effective_date_start)->format('D, j M Y') }}</td>
						<td>{{ Carbon::parse($t->effective_date_end)->format('D, j M Y') }}</td>
						<td>{{ $t->remarks }}</td>
						<td> <a class="" href="{{ route('workingHour.edit', $t->id) }}"><i class="far fa-edit"></i></a> </td>
					</tr>
@endforeach
				</tbody>
@endforeach
			</table>
		</div>
		<div class="card-footer">
			 <a href="{{ route('workingHour.create') }}" class="btn btn-primary float-right">Add Working Hour</a>
		</div>
	</div>
		<br />
		<div class="card">
			<div class="card-header">Public Holiday For {{ config('app.name') }}</div>
			<div class="card-body table-responsive">
				<table class="table table-hover table-sm" style="font-size:12px">
@foreach($yhc as $hi)
@if($hi->yaer >= date('Y'))
					<thead>
						<tr>
							<th class="text-center" colspan="4">Public Holiday ({{ $hi->yaer }})</th>
						</tr>
						<tr>
							<th>From</th>
							<th>To</th>
							<th>Holiday</th>
							<th>Period</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
<?php
$kj = HolidayCalendar::whereYear('date_start', $hi->yaer)->orderBy('date_start')->get();
// echo $kj.' date based year<br />';
?>
@foreach( $kj as $ui )
						<tr>
							<td>{{ Carbon::parse($ui->date_start)->copy()->format('D, j F Y') }}</td>
							<td>{{ Carbon::parse($ui->date_end)->copy()->format('D, j F Y') }}</td>
							<td>{{ ucwords(strtolower($ui->holiday)) }}</td>
							<td>{{ \Carbon\CarbonPeriod::create($ui->date_start, '1 day', $ui->date_end)->count().__(' Day/s') }}</td>
							<td>
								<a class="" href="{{ route('holidayCalendar.edit', $ui->id) }}"><i class="far fa-edit"></i></a>
								<span class="text-danger delete_button" href="{{ route('holidayCalendar.destroy', $ui->id) }}" id="delete_product_{{ $ui->id }}" data-id="{{ $ui->id }}"><i class="far fa-trash-alt"></i></span>
							</td>
						</tr>
@endforeach
					</tbody>
@endif
@endforeach
				</table>
			</div>
			<div class="card-footer">
				<a href="{{ route('holidayCalendar.create') }}" class="btn btn-primary float-right">Add Public Holiday</a>
			</div>
		</div>

	</div>
</div>

	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$("#username").keyup(function() {
	uch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
// ajax post delete row
$(document).on('click', '.delete_button', function(e){
	
	var productId = $(this).data('id');
	SwalDelete(productId);
	e.preventDefault();
});

function SwalDelete(productId){
	swal.fire({
		title: 'Are you sure?',
		text: "It will be deleted permanently!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					url: '{{ url('holidayCalendar') }}' + '/' + productId,
					type: 'DELETE',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: productId,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal.fire('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_product_' + productId).parent().parent().remove();
				})
				.fail(function(){
					swal.fire('Oops...', 'Something went wrong with ajax !', 'error');
				})
			});
		},
		allowOutsideClick: false			  
	})
	.then((result) => {
		if (result.dismiss === swal.DismissReason.cancel) {
			swal.fire('Cancelled', 'Your data is safe from delete', 'info')
		}
	});
}

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

