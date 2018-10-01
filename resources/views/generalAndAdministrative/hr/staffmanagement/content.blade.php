<?php
use App\Model\Staff;
use App\Model\Category;
use App\Model\Division;
use App\Model\Department;

use Carbon\Carbon;

$h = Staff::where('active', 1)->get();
$m = Staff::where('active', 0)->get();
?>
<div class="card">
	<div class="card-header">Active Staff List</div>
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
					<td>
						<a href="" title="Calendar" class="btn btn-primary"><i class="far fa-calendar-alt"></i></a>
						<a href="{{ route('staffHR.show', $b->id) }}" title="Show" class="btn btn-primary"><i class="far fa-eye"></i></a>
						<a href="{{ route('staffHR.editHR', $b->id) }}" title="Edit" class="btn btn-primary"><i class="far fa-edit"></i></a>

@if($b->status_id == 2)
						<a href="{{ route('staffHR.promoteHR', $b->id) }}" title="Promote" class="btn btn-primary"><i class="far fa-arrow-alt-circle-up"></i></a>
@endif
						<button title="Disable" class="btn btn-primary disable_user" id="disable_user_{{ $b->id }}" data-id="{{ $b->id }}"><i class="far fa-times-circle"></i></button>
					</td>
				</tr>
@endforeach
			</tbody>
		</table>
	</div>
	<div class="card-footer">
		<a href="{{ route('staffHR.create') }}" class="btn btn-primary float-right">Add Staff</a>
	</div>
</div>
<br />

<div class="card">
	<div class="card-header">Inactive Staff List</div>
	<div class="card-body">
		<table class="table table-hover" style="font-size:12px" id="staffinactive">
			<thead>
				<tr>
					<th>ID</th>
					<th>Staff</th>
					<th>Location</th>
					<th>Category</th>
					<th>Division</th>
					<th>Department</th>
					<th>Position</th>
				</tr>
			</thead>
			<tbody>
@foreach($m as $z)
<?php
$y = $z->hasmanylogin()->where('active', 0)->get();
?>
				<tr>
					<td>
						<table>
							<tbody>
@foreach($y as $x)
<?php
if (!is_null($x)) {
	$user1 = $x->username;
} else {
	$user1 = NULL;
}
?>
								<tr>
									<td>
										{{ $user1 }}
									</td>
								</tr>
@endforeach
							</tbody>
						</table>
					</td>
<?php
if (!is_null($z->belongtolocation)) {
	$a1 = $z->belongtolocation->location;
} else {
	$a1 = NULL;
}
if (!is_null( $z->belongtomanyposition()->wherePivot('main', 1)->first() )) {
	$d1 = $z->belongtomanyposition()->wherePivot('main', 1)->first()->belongtocategory->category;
} else {
	$d1 = NULL;
}
if (!is_null($z->belongtomanyposition()->wherePivot('main', 1)->first() )) {
	$e1 = $z->belongtomanyposition()->wherePivot('main', 1)->first()->belongtodivision->division;
} else {
	$e1 = NULL;
}
if (!is_null($z->belongtomanyposition()->wherePivot('main', 1)->first() ) && !is_null($z->belongtomanyposition()->wherePivot('main', 1)->first()->belongtodepartment) ) {
	$f1 = $z->belongtomanyposition()->wherePivot('main', 1)->first()->belongtodepartment->department;
} else {
	$f1 = NULL;
}
if (!is_null($z->belongtomanyposition()->wherePivot('main', 1)->first() )) {
	$g1 = $z->belongtomanyposition()->wherePivot('main', 1)->first()->position;
} else {
	$g1 = NULL;
}
?>
					<td>{{ $z->name }}</td>
					<td>{{ $a1 }}</td>
					<td>{{ $d1 }}</td>
					<td>{{ $e1 }}</td>
					<td>{{ $f1 }}</td>
					<td>{{ $g1 }}</td>
				</tr>
@endforeach
			</tbody>
		</table>
	</div>
	<div class="card-footer">
		<p>Link yet to be done</p>
	</div>
</div>