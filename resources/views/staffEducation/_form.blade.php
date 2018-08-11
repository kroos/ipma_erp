<div class="card">
	<div class="card-header">
		<h2 class="card-title">Rekod Pengajian</h2>
	</div>
	<div class="card-body">

		<div class="form-group row {{ $errors->has('institution') ? 'has-error' : '' }}">
			{{ Form::label( 'npasa', 'Pusat Pengajian (Sekolah/Maktab/Universiti) : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('institution', @$value, ['class' => 'form-control', 'id' => 'npasa', 'placeholder' => 'Pusat Pengajian (Sekolah/Maktab/Universiti)', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('from') ? 'has-error' : '' }}">
			{{ Form::label( 'from', 'Dari (From) : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('from', @$value, ['class' => 'form-control', 'id' => 'from', 'placeholder' => 'Dari (From)', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('to') ? 'has-error' : '' }}">
			{{ Form::label( 'to', 'Hingga (To) : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('to', @$value, ['class' => 'form-control', 'id' => 'to', 'placeholder' => 'Hingga (To)', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('qualification') ? 'has-error' : '' }}">
			{{ Form::label( 'qua', 'Kelulusan Tertinggi : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('qualification', @$value, ['class' => 'form-control', 'id' => 'qua', 'placeholder' => 'Kelulusan Tertinggi', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>

	</div>

</div>
