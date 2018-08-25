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
			if( $leaveALMC->annual_leave_balance > 0 && $lev->id != 3) {

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

				<div class="form-group row {{ $errors->has('leave_type') ? 'has-error' : '' }}" id="wrapperday">
					{{ Form::label('leave_type', 'Jenis Cuti : ', ['class' => 'col-sm-2 col-form-label removehalfleave']) }}
					<div class="col-sm-10 removehalfleave" id="halfleave">
						<div class="pretty p-default p-curve form-check removehalfleave" id="removeleavehalf">
							{{ Form::radio('leave_type', '1', true, ['id' => 'radio1', 'class' => ' removehalfleave']) }}
							<div class="state p-success removehalfleave">
								{{ Form::label('radio1', 'Cuti Penuh', ['class' => 'form-check-label removehalfleave']) }}
							</div>
						</div>
						<div class="pretty p-default p-curve form-check removehalfleave" id="appendleavehalf">
							{{ Form::radio('leave_type', '0', NULL, ['id' => 'radio2', 'class' => ' removehalfleave']) }}
							<div class="state p-success removehalfleave">
								{{ Form::label('radio2', 'Cuti Separuh', ['class' => 'form-check-label removehalfleave']) }}
							</div>
						</div>
					</div>
					<div class="form-group row col-sm-10 offset-sm-2 {{ $errors->has('leave_half') ? 'has-error' : '' }} removehalfleave"  id="wrappertest">
					</div>
				</div>








<?php
$usergroup = \Auth::user()->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();

$userloc = \Auth::user()->belongtostaff->location_id;
// echo $userloc.'<-- location_id<br />';

$userneedbackup = \Auth::user()->belongtostaff->leave_need_backup;

if( empty($usergroup->department_id) && $usergroup->category_id == 1 ) {
	$rt = \App\Model\Position::where('division_id', $usergroup->division_id)->Where('group_id', '<>', 1)->where('category_id', $usergroup->category_id);
} else {
	$rt = \App\Model\Position::where('department_id', $usergroup->department_id)->Where('group_id', '<>', 1)->where('category_id', $usergroup->category_id);
}




foreach ($rt->get() as $key) {
	// echo $key->position.' <-- position id<br />';
	$ft = \App\Model\StaffPosition::where('position_id', $key->id)->get();
	foreach($ft as $val) {
		//must checking on same location, active user, almost same level.
		if (\Auth::user()->belongtostaff->id != $val->belongtostaff->id && \Auth::user()->belongtostaff->location_id == $val->belongtostaff->location_id && $val->belongtostaff->active == 1 ) {
			// echo $val->belongtostaff->name.' <-- name staff<br />';
			$sel[$val->belongtostaff->id] = $val->belongtostaff->name;
		}
	}
}
?>
@if( ($usergroup->category_id == 1 || $usergroup->group_id == 5 || $usergroup->group_id == 6) || $userneedbackup == 1 )
				<div class="form-group row {{ $errors->has('staff_id') ? 'has-error' : '' }}">
					{{ Form::label('backupperson', 'Backup Person : ', ['class' => 'col-sm-2 col-form-label']) }}
					<div class="col-sm-10">
						{{ Form::select('staff_id', $sel, NULL, ['class' => 'form-control', 'id' => 'backupperson', 'placeholder' => 'Please Choose', 'autocomplete' => 'off']) }}
					</div>
				</div>
@endif

				<div class="form-group row {{ $errors->has('akuan') ? 'has-error' : '' }}">
					{{ Form::label('akuan2', 'Pengesahan : ', ['class' => 'col-sm-2 col-form-label']) }}
					<div class="col-sm-10 form-check">
						{{ Form::checkbox('akuan', 1, @$value, ['class' => 'form-check-input', 'id' => 'akuan1']) }}
						<label for="akuan1" class="form-check-label lead p-3 mb-2 bg-warning text-dark rounded">Dengan ini saya mengesahkan bahawa segala butiran dan maklumat yang diisi adalah <strong>BETUL</strong> dan <strong>DISEMAK</strong> terdahulu sebelum hantar.</label>
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
