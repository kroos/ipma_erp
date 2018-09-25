<?php
use App\Model\Staff;
use App\Model\Category;
use App\Model\Division;
use App\Model\Department;

use Carbon\Carbon;

$h = Staff::where('active', 1)->get();
?>
<div class="card">
	<div class="card-header">Staff List</div>
	<div class="card-body">
		<table class="table table-hover" style="font-size:12px" id="staff">
			<thead>
				<tr>
					<th>ID</th>
					<th>Staff</th>
					<th>Location</th>
					<th>Category</th>
					<th>Division</th>
					<th>Department</th>
					<th>Position</th>
					<th>Calendar</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
@foreach($h as $b)
<?php
$c = $b->hasmanylogin()->where('active', 1)->first();
if (!is_null($c)) {
	$user = $c->username;
} else {
	$user = NULL;
}
if (!is_null($b->belongtolocation->location)) {
	$a = $b->belongtolocation->location;
} else {
	$a = NULL;
}
if (!is_null($b->belongtomanyposition()->wherePivot('main', 1)->first() )) {
	$d = $b->belongtomanyposition()->wherePivot('main', 1)->first()->belongtocategory->category;
} else {
	$d = NULL;
}
if (!is_null($b->belongtomanyposition()->wherePivot('main', 1)->first() )) {
	$e = $b->belongtomanyposition()->wherePivot('main', 1)->first()->belongtodivision->division;
} else {
	$e = NULL;
}
if (!is_null($b->belongtomanyposition()->wherePivot('main', 1)->first() ) && !is_null($b->belongtomanyposition()->wherePivot('main', 1)->first()->belongtodepartment) ) {
	$f = $b->belongtomanyposition()->wherePivot('main', 1)->first()->belongtodepartment->department;
} else {
	$f = NULL;
}
if (!is_null($b->belongtomanyposition()->wherePivot('main', 1)->first() )) {
	$g = $b->belongtomanyposition()->wherePivot('main', 1)->first()->position;
} else {
	$g = NULL;
}
// echo $b->belongtomanyposition()->wherePivot('main', 1)->first()->belongtocategory->category;
?>
				<tr>
					<td>{{ $user }}</td>
					<td>{{ $b->name }}</td>
					<td>{{ $a }}</td>
					<td>{{ $d }}</td>
					<td>{{ $e }}</td>
					<td>{{ $f }}</td>
					<td>{{ $g }}</td>
					<td><i class="far fa-calendar-alt"></i></td>
					<td></td>
				</tr>
@endforeach
			</tbody>
		</table>
	</div>
	<div class="card-footer">
		<a href="{{ route('staffHR.create') }}" class="btn btn-primary float-right">Add Staff</a>
	</div>
</div>