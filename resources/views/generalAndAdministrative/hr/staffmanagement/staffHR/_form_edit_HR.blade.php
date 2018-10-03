<?php
$divs = \App\Model\Division::all();
$depts = \App\Model\Department::all();
$poss = \App\Model\Position::all();
?>
<div class="card">
	<div class="card-header">Edit {{ $staffHR->name }} Position Setting</div>
	<div class="card-body">

		<div class="container-fluid position_wrap">
<?php
$i=0;
$a=0;
$b=0;
$c=0;
$d=0;
$e=0;
$f=0;
$g=0;
?>
@if($staffHR->belongtomanyposition()->orderBy('staff_positions.main', 'desc')->get()->count() > 0)
@foreach($staffHR->belongtomanyposition()->orderBy('staff_positions.main', 'desc')->get() as $val)
			<div class="rowposition">
				<div class="row col-sm-12">

					<div class="col-sm-1">
						<button class="btn btn-danger delete_position" type="button" id="button_delete_{{ $val->pivot->id }}" data-id="{{ $val->pivot->id }}">
							<i class="fas fa-trash" aria-hidden="true"></i>
						</button>
					</div>

					<div class="col-sm-2">
						<label for="pos" class="col-form-label">Position</label>
					</div>

					<div class="col-sm-1">
						<div class="form-group {{ $errors->has('staff.*.main') ? 'has-error' : '' }}">
							<input class="form-check-input" type="radio" name="staff[][main]" id="main_{{ $i++ }}" value="1" {{ ($val->pivot->main == 1)?'checked':'' }} required="required"><label for="main_{{ $a++ }}">Main Position</label>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="form-group {{ $errors->has('staff.*.division_id') ? 'has-error' : '' }}">
							<select name="staff[{{ $b++ }}][division_id]" id="division_id_{{ $c++ }}" class="form-control">
@foreach( $divs as $l )
								<option value="{{ $l->id }}" {{ ($l->id == $val->belongtodivision->id)?'selected':'' }}>{{ $l->division }}</option>
@endforeach
							</select>
						</div>
					</div>

					<div class="col-sm-2">
						<div class="form-group {{ $errors->has('staff.*.department_id') ? 'has-error' : '' }}">
							<select name="staff[{{ $d++ }}][department_id]" id="department_id_{{ $e++ }}" class="form-control">
@foreach($depts as $de)
								<option value="{{ $de->id }}" data-chained="{{ $de->division_id }}" {{ ($de->id == $val->belongtodepartment->id)?'selected':'' }}>{{ $de->department }}</option>
@endforeach
							</select>
						</div>
					</div>

					<div class="col-sm-3">
						<div class="form-group {{ $errors->has('staff.*.position_id') ? 'has-error' : '' }}">
							<select name="staff[{{ $f++ }}][position_id]" id="position_id_{{ $g++ }}" class="form-control">
@foreach($poss as $po)
								<option value="{{ $po->id }}" data-chained="{{ $po->department_id }}" {{ ($po->id == $val->id)?'selected':'' }}>{{ $po->position }}</option>
@endforeach
							</select>
						</div>
					</div>

				</div>
			</div>
@endforeach
@else
		<p>Please click on "Add More Position" to begin</p>
@endif
		</div>
		<div class="row col-lg-12">
			<p>
				<button class="btn btn-primary add_position" type="button">
					<i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add More Position
				</button>
			</p>
		</div>
<?php
// echo $staffHR->belongtomanyposition()->wherePivot('main', 1)->first();
$d = $staffHR->belongtomanyposition()->wherePivot('main', 1)->first();
?>
@if( !is_null($d) )
@if( ($d->group_id == 7 && $d->category_id != 1) || $d->group_id == 5 || $d->group_id == 6)
		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">

				<div class="pretty p-icon p-round p-smooth">
					<input type="checkbox" />
					<input type='hidden' value='0' name='leave_need_backup'>
					{{ Form::checkbox('leave_need_backup', 1, @$value) }}
					<div class="state p-success">
						<i class="icon mdi mdi-check"></i>
						<label>This User Need Backup?</label>
					</div>
				</div>

			</div>
		</div>
@endif
@endif

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>

	</div>
</div>