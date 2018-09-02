<div class="col-12">
	<div class="card">
		<div class="card-header">
			<h2 class="card-title">Leave Application</h2>
		</div>
		<div class="card-body">

			<div class="form-group row {{ $errors->has('leave_id') ? 'has-error' : '' }}">
				{{ Form::label( 'leave_id', 'Pilih Cuti : ', ['class' => 'col-sm-2 col-form-label'] ) }}
				<div class="col-sm-10">
					<input type="text" id="date">
<?php
// // checking for annual leave, mc, nrl and maternity
// // hati-hati dgn yg ni sbb melibatkan masa
// $leaveALMC = \Auth::user()->belongtostaff->hasmanystaffannualmcleave()->where('year', date('Y'))->first();
// $oi = \Auth::user()->belongtostaff->hasmanystaffleavereplacement()->where('leave_balance', '<>', 0)->whereYear('working_date', date('Y'))->get();
// $ty = \Auth::user()->belongtostaff;
// // dd($oi->sum('leave_balance'));
// 
// // geng laki
// if($ty->gender_id == 1) {
// 	// geng laki | no nrl
// 	if($oi->sum('leave_balance') < 1 ) {
// 		// geng laki | no nrl | no al 
// 		if( $leaveALMC->annual_leave_balance < 1 ) {
// 			if ($leaveALMC->medical_leave_balance < 1) {
// 	
// 				// laki | no nrl | no al | no mc
// 				$er = App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 7)->where('id', '<>', 4)->where('id', '<>', 1)->where('id', '<>', 2)->get();
// 			} else {
// 
// 				// laki | no nrl | no al | with mc
// 				$er = App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 7)->where('id', '<>', 4)->where('id', '<>', 1)->get();
// 			}
// 		} else {
// 			if ($leaveALMC->medical_leave_balance < 1) {
// 
// 				// laki | no nrl | with al | no mc
// 				$er = App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 7)->where('id', '<>', 3)->where('id', '<>', 2)->get();
// 			} else {
// 
// 				// laki | no nrl | with al | with mc
// 				$er = App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 7)->where('id', '<>', 3)->get();
// 			}
// 		}
// 	} else {
// 		if( $leaveALMC->annual_leave_balance < 1 ) {
// 			if ($leaveALMC->medical_leave_balance < 1) {
// 
// 				// laki | with nrl | no al | no mc
// 				$er = App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 7)->where('id', '<>', 1)->where('id', '<>', 2)->get();
// 			} else {
// 
// 				// laki | with nrl | no al | no mc
// 				$er = App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 7)->where('id', '<>', 1)->get();
// 			}
// 		} else {
// 			if ($leaveALMC->medical_leave_balance < 1) {
// 
// 				// laki | with nrl | with al | no mc
// 				$er = App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 7)->where('id', '<>', 3)->where('id', '<>', 2)->get();
// 			} else {
// 
// 				// laki | with nrl | with al | with mc
// 				$er = App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 7)->where('id', '<>', 3)->get();
// 			}
// 		}
// 	}
// } else {
// 
// 	// geng pempuan
// 	if($ty->gender_id == 2) {
// 		// pempuan | no nrl
// 		if($oi->sum('leave_balance') < 1 ) {
// 			if( $leaveALMC->annual_leave_balance < 1 ) {
// 				if ($leaveALMC->medical_leave_balance < 1) {
// 
// 					// pempuan | no nrl | no al | no mc
// 					$er = App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 4)->where('id', '<>', 1)->where('id', '<>', 2)->get();
// 				} else {
// 
// 					// pempuan | no nrl | no al | with mc
// 					$er = App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 4)->where('id', '<>', 1)->get();
// 				}
// 			} else {
// 				if ($leaveALMC->medical_leave_balance < 1) {
// 
// 					// pempuan | no nrl | with al | no mc
// 					$er = App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 4)->where('id', '<>', 3)->where('id', '<>', 2)->get();
// 				} else {
// 
// 					// pempuan | no nrl | with al | with mc
// 					$er = App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 4)->where('id', '<>', 3)->get();
// 				}
// 			}
// 		} else {
// 		// pempuan | with nrl
// 			if( $leaveALMC->annual_leave_balance < 1 ) {
// 				if ($leaveALMC->medical_leave_balance < 1) {
// 
// 					// pempuan | with nrl | no al | no mc
// 					$er = App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 1)->where('id', '<>', 2)->get();
// 				} else {
// 
// 					// pempuan | with nrl | no al | with mc
// 					$er = App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 1)->get();
// 				}
// 			} else {
// 				if ($leaveALMC->medical_leave_balance < 1) {
// 
// 					// pempuan | with nrl | with al | no mc
// 					$er = App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 3)->where('id', '<>', 2)->get();
// 				} else {
// 
// 					// pempuan | with nrl | with al | with mc
// 					$er = App\Model\Leave::where('id', '<>', 5)->where('id', '<>', 6)->where('id', '<>', 3)->get();
// 				}
// 			}
// 		}
// 	}
// }
?>
					<!-- <select name="leave_id" id="leave_id" class="form-control" autocomplete="off"> -->
						<!-- <option value="">Leave Type</option> -->

@//foreach($er as $lev)
						<!-- <option value="{{ '$lev->id' }}">{{ '$lev->leave' }}</option> -->
@//endforeach
					<!-- </select> -->
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
