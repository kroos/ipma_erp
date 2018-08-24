<div class="col-12">
	<div class="card">
		<div class="card-header">
			<h2 class="card-title">Leave Application</h2>
		</div>
		<div class="card-body">

			<div class="form-group row {{ $errors->has('leave_id') ? 'has-error' : '' }}">
				{{ Form::label( 'leave_id', 'Pilih Cuti : ', ['class' => 'col-sm-2 col-form-label'] ) }}
				<div class="col-sm-10">
<?php
$er = App\Model\Leave::all();

// checking for annual leave, mc, nrl and maternity
$ty = \Auth::user()->belongtostaff;

// hati-hati dgn yg ni sbb melibatkan masa
$leaveALMC = \Auth::user()->belongtostaff->hasmanystaffannualmcleave()->where('year', date('Y'))->first();

$oi = \Auth::user()->belongtostaff->hasmanystaffleavereplacement()->where('leave_balance', '<>', 0)->get();
?>

					<select name="leave_id" id="leave_id" class="form-control" autocomplete="off">
						<option value="">Leave Type</option>

@foreach($er as $lev)
<?php
if($lev->id != 5 && $lev->id != 6) {
	// geng pempuan, ada maternity leave
	if( $ty->gender_id == 2 ) {
		// kalau ada annual balance
		if($leaveALMC->annual_leave_balance > 0) {
			if($leaveALMC->medical_leave_balance > 0) {
				if($oi->sum('leave_balance') > 0 ) {
					echo '<option value="'.$lev->id.'">'.$lev->leave.'</option>';
				} else {
					if($oi->sum('leave_balance') < 1 && $lev->id != 4 ) {
						echo '<option value="'.$lev->id.'">'.$lev->leave.'</option>';
					}
				}
			} else {
				if($leaveALMC->medical_leave_balance < 1 && $lev->id != 2 ) {
					echo '<option value="'.$lev->id.'">'.$lev->leave.'</option>';
				}
			}
		} else {

			// annual balance dah habis dan remove annual leave
			if( $leaveALMC->annual_leave_balance < 1 && $lev->id != 1 ) {
				if($leaveALMC->medical_leave_balance > 0) {
					if($oi->sum('leave_balance') > 0 ) {
						echo '<option value="'.$lev->id.'">'.$lev->leave.'</option>';
					} else {
						if($oi->sum('leave_balance') < 1 && $lev->id != 4 ) {
							echo '<option value="'.$lev->id.'">'.$lev->leave.'</option>';
						}
					}
				} else {
					if($leaveALMC->medical_leave_balance < 1 && $lev->id != 2 ) {
						if($oi->sum('leave_balance') > 0 ) {
							echo '<option value="'.$lev->id.'">'.$lev->leave.'</option>';
						} else {
							if($oi->sum('leave_balance') < 1 && $lev->id != 4 ) {
								echo '<option value="'.$lev->id.'">'.$lev->leave.'</option>';
							}
						}
					}
				}
			}
		}

	} else {

		// geng laki, takdak maternity leave
		if($ty->gender_id == 1 && $lev->id != 7) {

			// ada annual abalance so ada annual leave
			if( $leaveALMC->annual_leave_balance > 0 ) {

				// bila medical balance ada, jgn exclude MC leave
				if( $leaveALMC->medical_leave_balance > 0 ) {

					// ada cuti ganti
					if( $oi->sum('leave_balance') > 0 ) {
						echo '<option value="'.$lev->id.'">'.$lev->leave.'</option>';
					} else {
						if($oi->sum('leave_balance') < 1 && $lev->id != 4 ) {
							echo '<option value="'.$lev->id.'">'.$lev->leave.'</option>';
						}
					}
				} else {
					if( $leaveALMC->medical_leave_balance < 1 && $lev->id != 2 ) {
						echo '<option value="'.$lev->id.'">'.$lev->leave.'</option>';
					}
				}
			} else {

				//exclude annual leave bila anuual balance habis
				if($leaveALMC->annual_leave_balance < 1 && $lev->id != 1) {

					// bila medical balance ada, jgn exclude MC leave
					if( $leaveALMC->medical_leave_balance > 0 ) {
						echo '<option value="'.$lev->id.'">'.$lev->leave.'</option>';
					} else {
						if( $leaveALMC->medical_leave_balance < 1 && $lev->id != 2 ) {
						// ada cuti ganti
						if( $oi->sum('leave_balance') > 0 ) {
							echo '<option value="'.$lev->id.'">'.$lev->leave.'</option>';
						} else {
							if($oi->sum('leave_balance') < 1 && $lev->id != 4 ) {
								echo '<option value="'.$lev->id.'">'.$lev->leave.'</option>';
							}
						}						}
					}
				}
			}
		}
	}
}
?>
@endforeach
					</select>
				</div>
			</div>



			<div id="wrapper">

				<!-- annual leave -->
				<div class="form-group row {{ $errors->has('reason') ? 'has-error' : '' }}">
					{{ Form::label( 'reason', 'Sebab Cuti : ', ['class' => 'col-sm-2 col-form-label'] ) }}
					<div class="col-sm-10">
						{{ Form::textarea('reason', @$value, ['class' => 'form-control', 'id' => 'reason', 'placeholder' => 'Sebab Cuti', 'autocomplete' => 'off']) }}
					</div>
				</div>

				<div class="form-group row {{ $errors->has('date_time_start') ? 'has-error' : '' }}">
					{{ Form::label('from', 'From : ', ['class' => 'col-sm-2 col-form-label']) }}
					<div class="col-sm-10">
						{{ Form::text('date_time_start', @$value, ['class' => 'form-control', 'id' => 'from', 'placeholder' => 'From : ', 'autocomplete' => 'off']) }}
					</div>
				</div>

				<div class="form-group row {{ $errors->has('date_time_end') ? 'has-error' : '' }}">
					{{ Form::label('to', 'To : ', ['class' => 'col-sm-2 col-form-label']) }}
					<div class="col-sm-10">
						{{ Form::text('date_time_end', @$value, ['class' => 'form-control', 'id' => 'to', 'placeholder' => 'To : ', 'autocomplete' => 'off']) }}
					</div>
				</div>

				<div class="form-group row {{ $errors->has('date_time_end') ? 'has-error' : '' }}">
					{{ Form::label('leave_type', 'Jenis Cuti : ', ['class' => 'col-sm-2 col-form-label']) }}
					<div class="col-sm-10">
						<div class="pretty p-default p-curve form-check">
							{{ Form::radio('leave_type', '1', true, ['id' => 'radio1']) }}
							<div class="state p-success">
								{{ Form::label('radio1', 'Cuti Penuh', ['class' => 'form-check-label']) }}
							</div>
						</div>
						<div class="pretty p-default p-curve form-check">
							{{ Form::radio('leave_type', '0', NULL, ['id' => 'radio2']) }}
							<div class="state p-success">
								{{ Form::label('radio2', 'Cuti Separuh', ['class' => 'form-check-label']) }}
							</div>
						</div>
					</div>

					<div class="row col-sm-10 offset-sm-2"  id="leave_period">
						<div class="pretty p-default p-curve form-check">
							{{ Form::radio('leave_half', '1', true, ['id' => 'am']) }}
							<div class="state p-primary">
								{{ Form::label('am', 'Pagi time', ['class' => 'form-check-label']) }}
							</div>
						</div>
						<div class="pretty p-default p-curve form-check">
							{{ Form::radio('leave_half', '0', true, ['id' => 'pm']) }}
							<div class="state p-primary">
								{{ Form::label('pm', 'Petang time', ['class' => 'form-check-label']) }}
							</div>
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
</div>
