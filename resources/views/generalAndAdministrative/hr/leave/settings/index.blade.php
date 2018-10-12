@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Human Resource Department</h1></div>
	<div class="card-body">

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
				<a class="nav-link active" href="{{ route('leaveEditing.index') }}">Leave</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('tcms.index') }}">TCMS</a>
			</li>
		</ul>

		<div class="card">
			<div class="card-header">Leaves Management</div>
			<div class="card-body">
				@include('generalAndAdministrative.hr.leave.settings.content')
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
// datatables
$.fn.dataTable.moment( 'ddd, D MMM YYYY' );
$.fn.dataTable.moment( 'ddd, D MMM YYYY h:mm a' );
$('#almcml1').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	// "order": [[5, "desc" ]],	// sorting the 4th column descending
	// responsive: true
	// "ordering": false
});

$('#almcml2').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	// "order": [[5, "desc" ]],	// sorting the 4th column descending
	// responsive: true
	// "ordering": false
});

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

