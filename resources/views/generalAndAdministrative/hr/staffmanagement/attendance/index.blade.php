@extends('layouts.app')

@section('content')
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
				<a class="nav-link " href="{{ route('hrSettings.index') }}">Settings</a>
			</li>
			<li class="nav-item">
				<a class="nav-link active" href="{{ route('staffManagement.index') }}">Staff Management</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('leaveEditing.index') }}">Leave</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('tcms.index') }}">TCMS</a>
			</li>
		</ul>

		<div class="card">
			<div class="card-header">Staff Management</div>
			<div class="card-body table-responsive">

				<ul class="nav nav-pills">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('staffOvertime.index') }}">Overtime</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('staffAvailability.index') }}">Staff Availability Report</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="{!! route('staffDis.index') !!}">Staff Attendance & Discipline</a>
					</li>
				</ul>

				@include('generalAndAdministrative.hr.staffmanagement.attendance._index')

			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
// table
// $.fn.dataTable.moment( 'ddd, D MMM YYYY' );
$("#staffdiscoff, #staffdiscprod").DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	// "order": [[3, "asc" ]],	// sorting the 4th column descending
	// responsive: true
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
@endsection

