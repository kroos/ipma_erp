<?php
$divs = \App\Model\Division::pluck('division', 'id')->sortKeys()->toArray();
$depts = \App\Model\Department::all();
$poss = \App\Model\Position::all();
?>
<div class="card">
	<div class="card-header">Edit {{ $staffHR->name }} Position Setting</div>
	<div class="card-body">

		<div class="container-fluid position_wrap">
			<div class="rowposition">
				<div class="row col-sm-12">

					<div class="col-sm-1">
						<button class="btn btn-danger remove_position" type="button">
							<i class="fas fa-trash" aria-hidden="true"></i>
						</button>
					</div>

					<div class="col-sm-2">
						<label for="pos" class="col-form-label">Position</label>
					</div>

					<div class="col-sm-1">
						<div class="form-group {{ $errors->has('staff.*.main') ? 'has-error' : '' }}">
							<input class="form-check-input" type="radio" name="staff[][main]" id="main_1" value="1" required="required"><label for="main_1">Main Position</label>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="form-group {{ $errors->has('staff.*.division_id') ? 'has-error' : '' }}">
							{{ Form::select('staff[1][division_id]', $divs, @$value, ['class' => 'form-control', 'id' => 'division_id_1', 'placeholder' => 'Please choose division', 'autocomplete' => 'off']) }}
						</div>
					</div>

					<div class="col-sm-2">
						<div class="form-group {{ $errors->has('staff.*.department_id') ? 'has-error' : '' }}">
							<select name="staff[1][department_id]" id="department_id_1" class="form-control">
@foreach($depts as $de)
								<option value="{{ $de->id }}" data-chained="{{ $de->division_id }}">{{ $de->department }}</option>
@endforeach
							</select>
						</div>
					</div>

					<div class="col-sm-3">
						<div class="form-group {{ $errors->has('staff.*.position_id') ? 'has-error' : '' }}">
							<select name="staff[1][position_id]" id="position_id_1" class="form-control">
@foreach($poss as $po)
								<option value="{{ $po->id }}" data-chained="{{ $po->department_id }}">{{ $po->position }}</option>
@endforeach
							</select>
						</div>
					</div>

				</div>
			</div>
		</div>
		<div class="row col-lg-12">
			<p>
				<button class="btn btn-primary add_position" type="button">
					<i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add More Position
				</button>
			</p>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>

	</div>
</div>
