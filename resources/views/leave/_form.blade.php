<div class="col-12">
	<div class="card">
		<div class="card-header">
			<h2 class="card-title">Leave Application</h2>
		</div>
		<div class="card-body">

			<div class="form-group row {{ $errors->has('leave_id') ? 'has-error' : '' }}">
				{{ Form::label( 'leave_id', 'Pilih Cuti : ', ['class' => 'col-sm-2 col-form-label'] ) }}
				<div class="col-sm-10">
					<select name="leave_id" id="leave_id" class="form-control"></select>
				</div>
			</div>

			<div class="form-group row {{ $errors->has('reason') ? 'has-error' : '' }}">
				{{ Form::label( 'reason', 'Sebab Cuti : ', ['class' => 'col-sm-2 col-form-label'] ) }}
				<div class="col-sm-10">
					{{ Form::textarea('reason', @$value, ['class' => 'form-control', 'id' => 'reason', 'placeholder' => 'Sebab Cuti', 'autocomplete' => 'off']) }}
				</div>
			</div>

			<div id="wrapper"></div>

			<div class="form-group row {{ $errors->has('akuan') ? 'has-error' : '' }}">
				{{ Form::label('akuan2', 'Pengesahan : ', ['class' => 'col-sm-2 col-form-label']) }}
				<div class="col-sm-10 form-check ">
					{{ Form::checkbox('akuan', 1, @$value, ['class' => 'form-check-input bg-warning rounded', 'id' => 'akuan1']) }}
					<label for="akuan1" class="form-check-label p-3 mb-2 bg-warning text-danger rounded">Dengan ini saya mengesahkan bahawa segala butiran dan maklumat yang diisi adalah <strong>BETUL</strong> dan <strong>DISEMAK</strong> terdahulu sebelum hantar.</label>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-sm-10 offset-sm-2">
					{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
				</div>
			</div>
		</div>
	</div>
</div>
