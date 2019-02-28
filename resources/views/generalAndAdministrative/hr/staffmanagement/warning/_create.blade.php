<?php
$staff = \App\Model\Staff::find(request()->staff_id)->name;
$memocat = \App\Model\MemoCategory::pluck('memo_category', 'id')->toArray();
$point = \App\Model\MemoCategory::all();
?>
<div class="card">
	<div class="card-header">Creating Warning/Verbal Warning To {!! $staff !!}</div>
	<div class="card-body">

		<div class="form-group row {{ $errors->has('date') ? 'has-error' : '' }}">
			{{ Form::label( 'date', 'Date : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('date', @$value, ['class' => 'form-control form-control-sm', 'id' => 'date', 'placeholder' => 'Date', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('memo_category') ? 'has-error' : '' }}">
			{{ Form::label( 'm_cat', 'Category : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::select('memo_category', $memocat, @$value, ['class' => 'form-control form-control-sm', 'id' => 'm_cat', 'placeholder' => 'Please choose']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('merit_point') ? 'has-error' : '' }}">
			{{ Form::label( 'm_pnt', 'Point : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('merit_point', @$value, ['class' => 'form-control form-control-sm', 'id' => 'm_pnt', 'placeholder' => 'Merit Point']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('reason') ? 'has-error' : '' }}">
			{{ Form::label( 'reason', 'Reason : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::textarea('reason', @$value, ['class' => 'form-control form-control-sm', 'id' => 'reason', 'placeholder' => 'Reason', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>

	</div>
</div>