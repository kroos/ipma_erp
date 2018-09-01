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
// checking for annual leave, mc, nrl and maternity

// hati-hati dgn yg ni sbb melibatkan masa
$leaveALMC = \Auth::user()->belongtostaff->hasmanystaffannualmcleave()->where('year', date('Y'))->first();

$oi = \Auth::user()->belongtostaff->hasmanystaffleavereplacement()->where('leave_balance', '<>', 0)->whereYear('working_date', date('Y'))->get();

$ty = \Auth::user()->belongtostaff;
if($ty->gender_id == 1) {
	if($oi->sum('leave_balance') < 0 ) {
		$er = App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 4)->where('id', '<>', 7)->get();
	 } // else {
		// $er = App\Model\Leave::where()->where()
	// }
} else {
	if($ty->gender_id == 2) {
		if($oi->sum('leave_balance') < 0 ) {
			$er = App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 4)->get();
		 } // else {
			// $er = App\Model\Leave::where()->where()
		// }
	}
}

// dd($oi->sum('leave_balance'));
?>
					<select name="leave_id" id="leave_id" class="form-control" autocomplete="off">
						<option value="">Leave Type</option>

@foreach($er as $lev)
<?php
	// geng pempuan, ada maternity leave
	if( $ty->gender_id == 2 ) {
		// kalau ada annual balance
		if($leaveALMC->annual_leave_balance > 0 && $lev->id != 3) {
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
					if($oi->count() > 0 ) {
						echo '<option value="'.$lev->id.'">'.$lev->leave.'</option>';
					} else {
						if($oi->count() < 1 && $lev->id != 4 ) {
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

			// ada annual abalance so ada annual leave buang UPL (3)
			if( $leaveALMC->annual_leave_balance > 0 && $lev->id != 3) {

				// bila medical balance ada, jgn exclude MC leave
				if( $leaveALMC->medical_leave_balance > 0 ) {

					// ada cuti ganti
					if( $oi->sum('leave_balance') > 0 ) {
						echo '<option value="'.$lev->id.'">'.$lev->leave.'</option>';
					} else {
						if($oi->count() < 1 && $lev->id != 4 ) {
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
							if( $oi->sum('leave_balance') < 1 && $lev->id != 4 ) {
								echo '<option value="'.$lev->id.'">'.$lev->leave.'</option>';
							} else {
								if( $oi->sum('leave_balance') > 0 ) {
									echo '<option value="'.$lev->id.'">'.$lev->leave.'</option>';
								}
							}
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
