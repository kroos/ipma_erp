<div class="card">
	<div class="card-header">Staff Availability Report</div>
	<div class="card-body table-responsive">

	{!! Form::open( ['route' => ['printpdfavailability.store'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) !!}
<?php
$cate = App\Model\Category::all();
?>
		<div class="form-group row {{ $errors->has('category') ? ' has-error' : '' }}">
			{{ Form::label('cat', 'Category : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::select('category', $cate->pluck('category', 'id')->toArray(), @$value, ['class' => 'form-control', 'id' => 'cat', 'placeholder' => 'Please choose', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Print', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>

	{!! Form::close() !!}

	</div>
	<div class="card-footer">&nbsp;</div>
</div>