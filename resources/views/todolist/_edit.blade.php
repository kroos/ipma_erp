<div class="card">
	<div class="card-header"><h3>Update Task {!! $todoList->belongtoschedule->task !!}</h3></div>
	<div class="card-body">

		<dl class="row">
			<dt class="col-sm-2">Category</dt>
			<dd class="col-sm-10">{!! $todoList->belongtoschedule->belongtocategory->category !!}</dd>

			<dt class="col-sm-2">Task From</dt>
			<dd class="col-sm-10">{!! $todoList->belongtoschedule->belongtocreator->name !!}</dd>

			<dt class="col-sm-2">Description</dt>
			<dd class="col-sm-10">{!! $todoList->belongtoschedule->description !!}</dd>

			<dt class="col-sm-2">Dateline</dt>
			<dd class="col-sm-10">{!! \Carbon\Carbon::parse($todoList->dateline)->format('D, j F Y') !!}</dd>

			<dt class="col-sm-2">Priority</dt>
			<dd class="col-sm-10">{!! $todoList->belongtoschedule->belongtopriority->priority !!}</dd>
		</dl>

		<div class="form-group row">
			{!! Form::label('rem', 'Remarks :', ['class' => 'col-sm-2 col-form-label']) !!}
			<div class="col-sm-10">
				{!! Form::textarea('description', @$value, ['class' => 'form-control form-control-sm', 'id' => 'rem', 'placeholder' => 'Remarks', 'required' => 'required']) !!}
			</div>
		</div>
		<div class="form-group row">
			{!! Form::label('rem', 'Accomplished :', ['class' => 'col-sm-2 col-form-label']) !!}
			<div class="col-sm-10">
				<div class="pretty p-switch p-fill form-check">
					{!! Form::checkbox('completed', 1, false, ['class' => 'form-check-input', 'id' => 'yes']) !!}
					<div class="state p-success">
						{!! Form::label('yes', 'Yes', ['class' => 'form-check-label']) !!}
					</div>
				</div>
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>

	</div>
</div>
