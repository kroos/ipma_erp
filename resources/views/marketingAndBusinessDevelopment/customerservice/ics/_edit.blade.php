<?php
// load model
use \App\Model\Customer;
use \App\Model\ICSCharge;
use \App\Model\Staff;
use \App\Model\ICSFoodRate;
use \App\Model\ICSWorkingType;
use \App\Model\ICSAccommodationRate;


$cust = Customer::all();
$ch = ICSCharge::all();
$staff = Staff::where('active', 1)->get();
?>
<div class="row">
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header">Service Report</div>
			<div class="card-body">
	
				<div class="row">
					<div class="col form-group {{ $errors->has('date')?'has-error':'' }}">
						{!! Form::text('date', @$value, ['class' => 'form-control', 'id' => 'date', 'placeholder' => 'Date', 'autocomplete' => 'off']) !!}
					</div>
				</div>
	
				<div class="form-group">
					<div class="form-check form-check-inline">
						<label class="form-check-label" for="inlineRadio1">Charge : </label>
					</div>

@foreach($ch as $ci)
					<div class="form-check form-check-inline">
						<div class="pretty p-icon p-round p-smooth">
							{{ Form::radio('charge_id', $ci->id, @$value, ['class' => 'form-control']) }}
							<div class="state p-success">
								<i class="icon mdi mdi-check"></i>
								<label>{{ $ci->charge }}</label>
							</div>
						</div>
					</div>
@endforeach
				</div>
	
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header">Service Report Serial</div>
			<div class="card-body">


				<div class="container-fluid serial_wrap">
<?php $i = 1; $r = 1; ?>
@foreach($serviceReport->hasmanyserial()->get() as $srs)
					<div class="rowserial">
						<div class="row col-sm-12">

							<div class="col-sm-1 text-danger delete_serial"  id="button_delete_{!! $srs->id !!}" data-id="{!! $srs->id !!}">
									<i class="fas fa-trash" aria-hidden="true"></i>
							</div>

							<div class="col-sm-11">
								<div class="form-group {{ $errors->has('sr.*.serial') ? 'has-error' : '' }}">
									{!! Form::text('srs['.$i++.'][serial]', (is_null(@$value))?$srs->serial:@$value, ['class' => 'form-control', 'id' => 'serial_'.$r++, 'placeholder' => 'Service Report No.', 'autocomplete' => 'off']) !!}
								</div>
							</div>

						</div>
					</div>
@endforeach
				</div>
				<div class="row col-lg-12 add_serial">
					<p class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Service Report No</p>
				</div>


			</div>
		</div>
	</div>
</div>

<br />
<div class="row">
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header">Customer</div>
			<div class="card-body">

				<div class="form-group row {{ $errors->has('customer_id')?'has-error':'' }}">
					{{ Form::label( 'cust', 'Customer : ', ['class' => 'col-sm-3 col-form-label'] ) }}
					<div class="col-sm-9">
						<select name="customer_id" id="cust" class="form-control col-sm-12" autocomplete="off">
							<option value="" data-pc="" data-phone="">Please choose</option>
@foreach($cust as $cu)
							<option value="{!! $cu->id !!}" data-pc="{!! $cu->pc !!}" data-phone="{!! $cu->phone !!}" {!! ($serviceReport->customer_id == $cu->id)?'selected':NULL !!}>{!! $cu->customer !!}</option>
@endforeach
						</select>
					</div>
				</div>


				<dl class="row">
					<dt class="col-sm-5">Attention To :</dt>
					<dd class="col-sm-7" id="attn"></dd>

					<dt class="col-sm-5">Phone :</dt>
					<dd class="col-sm-7" id="phone"></dd>
				</dl>

			</div>
			<div class="card-footer"><a href="" class="btn btn-primary float-right">Add Customer</a></div>
		</div>
	</div>

	<div class="col-sm-6">
		<div class="card">
			<div class="card-header">Attended By</div>
			<div class="card-body">

				<div class="container-fluid position_wrap">
<?php
$staff = \App\Model\Staff::where('active', 1)->get();
$ii = 1;
$iii = 1;
?>
@foreach( $serviceReport->hasmanyattendees()->get() as $sra )
					<div class="rowposition">
						<div class="row col-sm-12">

							<div class="col-sm-1 text-danger">
									<i class="fas fa-trash delete_attendees" aria-hidden="true" id="delete_attendees_{!! $sra->id !!}" data-id="{!! $sra->id !!}"></i>
							</div>

							<div class="col-sm-11">
								<div class="form-group {{ $errors->has('sr.*.attended_by') ? 'has-error' : '' }}">
									<select name="sr[{!! $iii++ !!}][attended_by]" id="staff_id_{!! $ii++ !!}" class="form-control">
										<option value="">Please choose</option>
@foreach($staff as $st)
										<option value="{!! $st->id !!}" {!! ($st->id == $sra->attended_by)?'selected':NULL !!} >{!! $st->hasmanylogin()->where('active', 1)->first()->username !!} {!! $st->name !!}</option>
@endforeach
									</select>
								</div>
							</div>
						</div>
					</div>
@endforeach
				</div>
				<div class="row col-lg-12 add_position">
					<span class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Staff</span>
				</div>

			</div>
		</div>
	</div>
</div>

<br />

<div class="row">
	<div class="col-sm-6">
		<div class="card">
			<div class="div card-header">Nature Of Complaints</div>
			<div class="card-body">

				<div class="form-group row {{ $errors->has('complaints')?'has-error':'' }}">
					{{ Form::label( 'compl', 'Complaints :', ['class' => 'col-sm-3 col-form-label'] ) }}
					<div class="col-sm-9">
						{!! Form::textarea('complaint', (is_null(@$value))?$serviceReport->hasmanycomplaint()->first()->complaint:@$value, ['class' => 'form-control', 'id' => 'compl', 'placeholder' => 'Complaints', 'autocomplete' => 'off']) !!}
					</div>
				</div>

				<div class="form-group row {{ $errors->has('status_id')?'has-error':'' }}">
					{{ Form::label( 'compby', 'Requested By :', ['class' => 'col-sm-3 col-form-label'] ) }}
					<div class="col-sm-9">
						{!! Form::text('complaint_by', (is_null(@$value))?$serviceReport->hasmanycomplaint()->first()->complaint:@$value, ['class' => 'form-control', 'id' => 'compby', 'placeholder' => 'Complaint By', 'autocomplete' => 'off']) !!}
					</div>
				</div>

			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header">Model</div>
			<div class="card-body">

				<div class="container-fluid model_wrap">
					<div class="row col-sm-12 form-inline">
						<div class="col-sm-1 text-danger">&nbsp;</div>
						<div class=""><input type="text" name="" placeholder="Select Model" class="form-control" disabled></div>
						<div class=""><input type="text" name="" placeholder="Test Run Machine" class="form-control" disabled></div>
						<div class=""><input type="text" name="" placeholder="Serial No." class="form-control" disabled></div>
						<div class=""><input type="text" name="" placeholder="Test Capacity" class="form-control" disabled></div>
						<div class=""><input type="text" name="" placeholder="Duration" class="form-control" disabled></div>
					</div>
<?php
$model = \App\Model\ICSMachineModel::all();
$e = 1;
$ee = 1;
$eee = 1;
$eeee = 1;
$eeeee = 1;
$eeeeee = 1;
$eeeeeee = 1;
$eeeeeeee = 1;
$eeeeeeeee = 1;
$eeeeeeeeee = 1;
?>
@foreach( $serviceReport->hasmanymodel()->get() as $srmo )
					<div class="rowmodel">
						<div class="row col-sm-12 form-inline">

							<div class="col-sm-1 text-danger">
									<i class="fas fa-trash delete_model" aria-hidden="true" id="delete_model_{!! $srmo->id !!}" data-id="{!! $srmo->id !!}"></i>
							</div>
							<div class="">
								<div class="form-group {{ $errors->has('srmo.*.model_id') ? 'has-error' : '' }}">
									<select name="srmo[{{ $ee++ }}][model_id]" id="model_{{ $e++ }}" class="form-control" autocomplete="off" placeholder="Please choose">
										<option value="">Please choose</option>
@foreach( $model as $mod )
										<option value="{!! $mod->id !!}" {!! ($srmo->model_id == $mod->id)?'selected':NULL !!}>{!! $mod->model !!}</option>
@endforeach
									</select>
								</div>
							</div>
							<div class="">
								<div class="form-group {{ $errors->has('srmo.*.test_run_machine') ? 'has-error' : '' }}">
									{!! Form::text('srmo['. $eee++ .'][test_run_machine]', (!is_null($srmo->test_run_machine))?$srmo->test_run_machine:@$value,['id'=>'test_run_machine_'.$eeee++, 'class' => "form-control", 'autocomplete' => "off", 'placeholder' => "Test Run Machine"] ) !!}
								</div>
							</div>
							<div class="">
								<div class="form-group {{ $errors->has('srmo.*.serial_no') ? 'has-error' : '' }}">
									<input type="text" name="srmo[{{ $eeeee++ }}][serial_no]" value="{!! (!empty($srmo->serial_no))?$srmo->serial_no:@$value !!}" id="serial_no_{{ $eeeeee++ }}" class="form-control" autocomplete="off" placeholder="Serial No." />
								</div>
							</div>
							<div class="">
								<div class="form-group {{ $errors->has('srmo.*.test_capacity') ? 'has-error' : '' }}">
									<input type="text" name="srmo[{{ $eeeeeee++ }}][test_capacity]" value="{!! (!empty($srmo->test_capacity))?$srmo->test_capacity:@$value !!}" id="test_capacity_{{ $eeeeeeee++ }}" class="form-control" autocomplete="off" placeholder="Test Capacity" />
								</div>
							</div>
							<div class="">
								<div class="form-group {{ $errors->has('srmo.*.duration') ? 'has-error' : '' }}">
									<input type="text" name="srmo[{{ $eeeeeeee++ }}][duration]" value="{!! (!empty($srmo->duration))?$srmo->duration:@$value !!}" id="duration_{{ $eeeeeeeee++ }}" class="form-control" autocomplete="off" placeholder="Duration" />
								</div>
							</div>
						</div>

					</div>
@endforeach
				</div>
				<div class="row col-lg-12 add_model">
					<span class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Model</span>
				</div>

			</div>
			<div class="card-footer">
				<a href="" class="btn btn-primary float-right">Add Model</a>
			</div>
		</div>
	</div>
</div>

<br />


<div class="row">
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header">Parts & Accessories</div>
			<div class="card-body">

				<div class="container-fluid part_wrap">
<?php
$r = 1;
$rr = 1;
$rrr = 1;
$rrrr = 1;
?>
@foreach($serviceReport->hasmanypart()->get() as $srp)
					<div class="rowpart">
						<div class="row col-sm-12 form-inline">

							<div class="col-sm-1 text-danger">
									<i class="fas fa-trash delete_part" aria-hidden="true" id="delete_part_{!! $srp->id !!}" data-id="{!! $srp->id !!}"></i>
							</div>
							<div class="form-group {{ $errors->has('srp.*.part_accessory') ? 'has-error' : '' }}">
								<input type="text" name="srp[{{ $r++ }}][part_accessory]" value="{!! (!empty($srp->part_accessory))?$srp->part_accessory:@$value !!}" id="part_accessory_{{ $rr++ }}" class="form-control" autocomplete="off" placeholder="Parts & Accessories" />
							</div>
							<div class="form-group {{ $errors->has('srp.*.qty') ? 'has-error' : '' }}">
								<input type="text" name="srp[{{ $rrr++ }}][qty]" value="{!! (!empty($srp->qty))?$srp->qty:@$value !!}" id="qty_{{ $rrrr++ }}" class="form-control" autocomplete="off" placeholder="Quantity" />
							</div>
						</div>
					</div>
@endforeach
				</div>
				<div class="row col-lg-12 add_part">
					<span class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Parts & Accessories</span>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
<!-- 		<div class="card">
			<div class="card-header"></div>
			<div class="card-body"></div>
		</div> -->
	</div>
</div>


<br />

<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">Job Performed</div>
			<div class="card-body">

				<div class="container-fluid job_wrap">
<?php
$r1 = 1;
$r2 = 1;
$r3 = 1;
$r4 = 1;
$r5 = 1;
$r6 = 1;
$r7 = 1;
$r8 = 1;
$r9 = 1;
$r10 = 1;
$r11 = 1;
$r12 = 1;
$r13 = 1;
$r14 = 1;
$r15 = 1;
$r16 = 1;
$r17 = 1;
$r18 = 1;
$r19 = 1;
$r20 = 1;
$r21 = 1;
$r22 = 1;
$r23 = 1;
$r24 = 1;
$r25 = 1;
$r26 = 1;
$r27 = 1;
$r28 = 1;
$r29 = 1;
$r30 = 1;
$r31 = 1;
$r32 = 1;
$r33 = 1;
$r34 = 1;
$r35 = 1;
$r36 = 1;
$r37 = 1;
$r38 = 1;
$r39 = 1;
$r40 = 1;
$r41 = 1;
$r42 = 1;
$r43 = 1;
$r44 = 1;
$r45 = 1;
$r46 = 1;
$r47 = 1;
$r48 = 1;
$r49 = 1;
$r50 = 1;
$r51 = 1;
$r52 = 1;
$r53 = 1;
$r54 = 1;
$r55 = 1;

// for trip and return
// trip
$r56 = 1;
$r57 = 1;
$r58 = 1;
$r59 = 1;
$r60 = 1;
$r61 = 1;
$r62 = 1;
// return
$r63 = 1;
$r64 = 1;
$r65 = 1;
$r66 = 1;
$r67 = 1;
$r68 = 1;
$r69 = 1;
$r70 = 1;
?>
@foreach( $serviceReport->hasmanyjob()->get() as $srj )
					<div class="rowjob">
						<div class="row col-sm-12 form-inline">

							<div class="col-sm-1 text-danger">
								<i class="fas fa-trash delete_job" aria-hidden="true" id="delete_job_{!! $srj->id !!}" data-id="{!! $srj->id !!}"></i>
							</div>
							<div class="form-group {{ $errors->has('srj.*.date') ? 'has-error' : '' }}">
								<input type="text" name="srj[{{ $r1++ }}][date]" value="{!! (!empty($srj->date))?$srj->date:@$value !!}" id="date_{{ $r2++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Date" />
							</div>

							<div class="form-group {{ $errors->has('srj.*.labour') ? 'has-error' : '' }}">
								<input type="text" name="srj[{{ $r3++ }}][labour]" value="{!! (!empty($srj->labour))?$srj->labour:@$value !!}" id="labour_{{ $r4++ }}" class="form-control form-control-sm labour_" autocomplete="off" placeholder="Labour Count" />
							</div>

							<div class="form-group {{ $errors->has('srj.*.job_perform') ? 'has-error' : '' }}">
								<input type="textarea" name="srj[{{ $r5++ }}][job_perform]" value="{!! (!empty($srj->job_perform))?$srj->job_perform:@$value !!}" id="job_perform_{{ $r6++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Job Perform" />
							</div>

							<div class="form-group {{ $errors->has('srj.*.working_time_start') ? 'has-error' : '' }}">
								<input type="text" name="srj[{{ $r7++ }}][working_time_start]" value="{!! (!empty($srj->working_time_start))?$srj->working_time_start:@$value !!}" id="wts_{{ $r8++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Working Time Start" />
							</div>

							<div class="form-group {{ $errors->has('srj.*.working_time_end') ? 'has-error' : '' }}">
								<input type="text" name="srj[{{ $r9++ }}][working_time_end]" value="{!! (!empty($srj->working_time_end))?$srj->working_time_end:@$value !!}" id="wte_{{ $r10++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Working Time End" />
							</div>
						</div>
						<br />
@foreach( $srj->hasmanysrjobdetail()->where('return', '<>', 1)->get() as $srjd )
						<div class="row col-sm-12 form-inline">
							<div class="col-sm-1 text-primary"><small>Trip <i class="fas fa-arrow-right"></i> <i class="fas fa-map-marker-alt"></i></small></div>

							<div class="form-group {{ $errors->has('srj.*.*.date') ? 'has-error' : '' }}">
								<input type="text" name="srj[{!! $r56++ !!}][1][destination_start]" value="{!! (!empty($srjd->destination_start))?$srjd->destination_start:@$value !!}" id="ds_1_{{ $r11++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Destination Start" />
							</div>

							<div class="form-group {{ $errors->has('srj.*.*.destination_end') ? 'has-error' : '' }}">
								<input type="text" name="srj[{!! $r57++ !!}][1][destination_end]" value="{!! (!empty($srjd->destination_end))?$srjd->destination_end:@$value !!}" id="de_1_{{ $r12++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Destination End" />
							</div>

							<div class="form-group {{ $errors->has('srj.*.*.meter_start') ? 'has-error' : '' }}">
								<input type="textarea" name="srj[{!! $r58++ !!}][1][meter_start]" value="{!! (!empty($srjd->meter_start))?$srjd->meter_start:@$value !!}" id="ms_1_{{ $r13++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Meter Start" />
							</div>

							<div class="form-group {{ $errors->has('srj.*.*.meter_end') ? 'has-error' : '' }}">
								<input type="text" name="srj[{!! $r59++ !!}][1][meter_end]" value="{!! (!empty($srjd->meter_end))?$srjd->meter_end:@$value !!}" id="me_1_{{ $r14++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Meter End" />
							</div>

							<div class="form-group {{ $errors->has('srj.*.*.time_start') ? 'has-error' : '' }}">
								<input type="text" name="srj[{!! $r60++ !!}][1][time_start]" value="{!! (!empty($srjd->time_start))?$srjd->time_start:@$value !!}" id="ts_1_{{ $r15++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Time Start" />
							</div>

							<div class="form-group {{ $errors->has('srj.*.*.time_end') ? 'has-error' : '' }}">
								<input type="text" name="srj[{!! $r61++ !!}][1][time_end]" value="{!! (!empty($srjd->time_end))?$srjd->time_end:@$value !!}" id="te_{{ $r16++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Time End" />
							</div>
							<input type="hidden" name="srj[{!! $r62++ !!}][1][return]" value="0">
						</div>
@endforeach
@foreach( $srj->hasmanysrjobdetail()->where('return', 1)->get() as $srjd )
						<div class="row col-sm-12 form-inline">
							<div class="col-sm-1 text-primary"><small>Return <i class="fas fa-map-marker-alt"></i> <i class="fas fa-undo"></i></small></div>

							<div class="form-group {{ $errors->has('srjd.*.date') ? 'has-error' : '' }}">
								<input type="text" name="srj[{!! $r63++ !!}][2][destination_start]" value="{!! (!empty($srjd->destination_start))?$srjd->destination_start:@$value !!}" id="ds_2_{{ $r17++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Destination Start" />
							</div>

							<div class="form-group {{ $errors->has('srjd.*.destination_end') ? 'has-error' : '' }}">
								<input type="text" name="srj[{!! $r64++ !!}][2][destination_end]" value="{!! (!empty($srjd->destination_end))?$srjd->destination_end:@$value !!}" id="de_2_{{ $r18++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Destination End" />
							</div>

							<div class="form-group {{ $errors->has('srjd.*.meter_start') ? 'has-error' : '' }}">
								<input type="textarea" name="srj[{!! $r65++ !!}][2][meter_start]" value="{!! (!empty($srjd->meter_start))?$srjd->meter_start:@$value !!}" id="ms_2_{{ $r19++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Meter Start" />
							</div>

							<div class="form-group {{ $errors->has('srjd.*.meter_end') ? 'has-error' : '' }}">
								<input type="text" name="srj[{!! $r66++ !!}][2][meter_end]" value="{!! (!empty($srjd->meter_end))?$srjd->meter_end:@$value !!}" id="me_2_{{ $r20++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Meter End" />
							</div>

							<div class="form-group {{ $errors->has('srjd.*.time_start') ? 'has-error' : '' }}">
								<input type="text" name="srj[{!! $r67++ !!}][2][time_start]" value="{!! (!empty($srjd->time_start))?$srjd->time_start:@$value !!}" id="ts_2_{{ $r21++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Time Start" />
							</div>

							<div class="form-group {{ $errors->has('srjd.*.time_end') ? 'has-error' : '' }}">
								<input type="text" name="srj[{!! $r68++ !!}][2][time_end]" value="{!! (!empty($srjd->time_end))?$srjd->time_end:@$value !!}" id="te_2_{{ $r22++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Time End" />
							</div>
							<input type="hidden" name="srj[{!! $r69++ !!}][2][return]" value="1">
						</div>
						<br />
@endforeach
<!-- inserting FLOAT TH -->
						<div class="col-sm-12">
						<!-- <div class="col-sm-12 border border-primary"> -->
							<small>
								<!-- insert food -->
								<table class="table table-hover" style="font-size:12px">
									<tbody>
										<tr>
											<td>Food : </td>
											<td class="form-group {{ $errors->has('srj.*.food_rate') ? ' has-error' : '' }}">
												<select name="srj[{{ $r++ }}][food_rate]" id="fr_{!! $r23++ !!}" class="form-control form-control-sm fr_" placeholder="Please choose">
													<option value="">Please choose</option>
@foreach( ICSFoodRate::all() as $fr )
													<option value="{!! $fr->value !!}" {!! ($srj->food_rate == $fr->value)?'selected':NULL !!} data-value="{{ $fr->value }}">{!! $fr->food_rate !!}</option>
@endforeach
												</select>
											</td>
											<td>X</td>
											<td><span class="labourfr" id="lab_{!! $r24++ !!}">{!! $srj->labour !!}</span> Person</td>
											<td colspan="6">&nbsp;</td>
											<td>=</td>
											<td class="font-weight-bold">RM <span class="tlabourf" id="total_food_{!! $r25++ !!}">{!! $srj->labour * $srj->food_rate !!}</span></td>
										</tr>
										<tr>
											<td>Labour :</td>
											<td class="form-group {{ $errors->has('srj.*.labour_leader') ? ' has-error' : '' }}">
												<input type="text" name="srj[{{ $r26++ }}][labour_leader]" value="{{ (!is_null($srj->labour_leader))?$srj->labour_leader:@$value }}" class="form-control form-control-sm allowanceleaderlabour" id="leadership_{{ $r27++ }}" placeholder="Leader Rate (MYR)">
											</td>
											<td>+</td>
											<td>(</td>
											<td class="form-group {{ $errors->has('srj.*.labour_non_leader') ? ' has-error' : '' }}">
												<input type="text" name="srj[{{ $r28++ }}][labour_non_leader]" value="{{ (!is_null($srj->labour_non_leader))?$srj->labour_non_leader:@$value }}" class="form-control form-control-sm allowancenonleaderlabour" id="non_leadership_{{ $r29++ }}" placeholder="Non Leader Rate (RM)">
											</td>
											<td>X</td>
											<td><span class="allowancenonleader" id="non_leader_count{{ $r30++ }}">{{ $srj->labour - 1 }} Person</span></td>
											<td>)</td>
											<td>/</td>
											<td class="form-group {{ $errors->has('srj.*.working_type_value') ? ' has-error' : '' }}">
												<select name="srj[$r31++][working_type_value]" id="wtv_{!! $r70++ !!}" class="form-control form-control-sm workingtypevalue">
													<option value="">Please choose</option>
@foreach( ICSWorkingType::all() as $wt )
													<option value="{!! $wt->value !!}" {!! ($wt->value == $srj->working_type_value)?'selected':NULL !!} data-value="{!! $wt->value !!}">{!! $wt->working_type !!}</option>
@endforeach
												</select>
											</td>
											<td>=</td>
											<td class="font-weight-bold">
												RM <span class="totallabourallowance" id="total_labour_{!! $r32++ !!}">{{ $srj->labour_leader + (($srj->labour_non_leader)*($srj->labour - 1)) / ($srj->working_type_value) }}</span>
											</td>
										</tr>
										<tr>
											<td>Overtime :</td>
											<td>
												RM <span class="totallabourallowance" id="total_labour_{!! $r33++ !!}">{{ $srj->labour_leader + (($srj->labour_non_leader)*($srj->labour - 1)) / ($srj->working_type_value) }}</span>
											</td>
											<td>X</td>
											<td><span class="overtimeconstant1">{{ $srj->overtime_constant_1 }}</span> X <span class="overtimeconstant2">{{ $srj->overtime_constant_2 }}</span></td>
											<td>X</td>
											<td class="form-group {{ $errors->has('srj.*.overtime_hour') ? ' has-error' : '' }}">
												<input type="text" name="srj[{{ $r34++ }}][overtime_hour]" value="{{ (!is_null($srj->overtime_hour))?$srj->overtime_hour:NULL }}" class="form-control form-control-sm overtimehour" id="overtime_hour_{!! $r35++ !!}" placeholder="Hour">
											</td>
											<td>hour</td>
											<td colspan="3">&nbsp;</td>
											<td>=</td>
											<td class="font-weight-bold">
												RM <span class="totalovertime" id="total_overtime_{!! $r36++ !!}">{{ ($srj->labour_leader + (($srj->labour_non_leader)*($srj->labour - 1)) / ($srj->working_type_value)) * $srj->overtime_constant_1 * $srj->overtime_constant_2 * $srj->overtime_hour }}</span>
											</td>
										</tr>
										<tr>
											<td>Accommodation :</td>
											<td class="form-group {{ $errors->has('srj.*.accommodation_rate') ? ' has-error' : '' }}">
												<input type="text" name="srj[{{ $r37++ }}][accommodation_rate]" value="{{ (!is_null($srj->accommodation_rate))?$srj->accommodation_rate:NULL }}" class="form-control form-control-sm" id="accommodation_rate_{!! $r38++ !!}" placeholder="Accommodation Rate (RM)">
											</td>
											<td>X</td>
											<td>
												<select name="srj[][accommodation]" id="accommodation_{!! $r39++ !!}" class="form-control form-control-sm" placeholder="Please choose">
													<option value="">Please choose</option>
@foreach( ICSAccommodationRate::all() as $acr )
													<option value="{!! $acr->value !!}" {!! ($acr->value == $srj->accommodation)?'selected':NULL !!} data-value="{!! $acr->value !!}">{!! $acr->accommodation_rate !!}</option>
@endforeach
												</select>
											</td>
											<td colspan="6">&nbsp;</td>
											<td>=</td>
											<td class="font-weight-bold">RM <span id="total_accommodation_{{ $r40++ }}">{!! $srj->accommodation * $srj->accommodation_rate !!}</span></td>
										</tr>
										<tr>
											<td>Travel :</td>
											<td colspan="2">
												Meter Calculator:<br />
												Trip : <span id="ms_1_{{ $r41++ }}">{{ $srj->hasmanysrjobdetail()->where('return', '<>', 1)->first()->meter_end }}</span> - <span id="me_1_{{ $r42++ }}">{{ $srj->hasmanysrjobdetail()->where('return', '<>', 1)->first()->meter_start }}</span> = <span id="total_go_1_{!! $r43++ !!}">{{ $srj->hasmanysrjobdetail()->where('return', '<>', 1)->first()->meter_end - $srj->hasmanysrjobdetail()->where('return', '<>', 1)->first()->meter_start }}</span>KM<br />
												Return : <span id="ms_2_{{ $r44++ }}">{{ $srj->hasmanysrjobdetail()->where('return', 1)->first()->meter_end }}</span> - <span id="me_2_{{ $r45++ }}">{{ $srj->hasmanysrjobdetail()->where('return', 1)->first()->meter_start }}</span> = <span id="total_go_2_{!! $r46++ !!}">{{ $srj->hasmanysrjobdetail()->where('return', 1)->first()->meter_end - $srj->hasmanysrjobdetail()->where('return', 1)->first()->meter_start }} KM</span><br />
												Total = <span id="total_km_1_{!! $r47++ !!}">
													{!! 
															($srj->hasmanysrjobdetail()->where('return', '<>', 1)->first()->meter_end - $srj->hasmanysrjobdetail()->where('return', '<>', 1)->first()->meter_start) + 
															($srj->hasmanysrjobdetail()->where('return', 1)->first()->meter_end - $srj->hasmanysrjobdetail()->where('return', 1)->first()->meter_start)
													 !!} KM
												</span>
											</td>
											<td>X</td>
											<td><span id="tmr_{!! $r48++ !!}">{!! $srj->travel_meter_rate !!}</span></td>
											<td colspan="5"></td>
											<td>=</td>
											<td class="font-weight-bold">
												RM <span id="total_meter_{!! $r49 !!}">{!!
														(
															($srj->hasmanysrjobdetail()->where('return', '<>', 1)->first()->meter_end - $srj->hasmanysrjobdetail()->where('return', '<>', 1)->first()->meter_start) + 
															($srj->hasmanysrjobdetail()->where('return', 1)->first()->meter_end - $srj->hasmanysrjobdetail()->where('return', 1)->first()->meter_start)
														) * $srj->travel_meter_rate
												!!}</span>
											</td>
										</tr>
										<tr>
											<td>Travel Hour :</td>
											<td>RM
												 <span class="totallabourallowance" id="total_labour_th_{!! $r50++ !!}">{{ $srj->labour_leader + (($srj->labour_non_leader)*($srj->labour - 1)) / ($srj->working_type_value) }}</span>
											</td>
											<td>X</td>
											<td>
												<span class="travelhourconstant" id="th_constant_{{ $r51++ }}">{{ $srj->travel_hour_constant }}</span>
											</td>
											<td>X</td>
											<td class="form-group {{ $errors->has('srj.*.travel_hour') ? ' has-error' : '' }}">
												<input type="text" name="srj[{!! $r52++ !!}][travel_hour]" value="{!! ( !is_null($srj->travel_hour) )?$srj->travel_hour:@$value !!}" id="travel_hour_{!! $r53++ !!}" class="form-control form-control-sm travelhour" placeholder="Travel Hour">
											</td>
											<td>hour</td>
											<td colspan="3">&nbsp;</td>
											<td>=</td>
											<td class="font-weight-bold">RM 
												<span class="totaltravelhour" id="total_th_{!! $r54++ !!}">
													{{
														($srj->labour_leader + (($srj->labour_non_leader)*($srj->labour - 1)) / ($srj->working_type_value)) * $srj->travel_hour_constant * $srj->travel_hour
													}}
												</span>
											</td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="10">Total Per Day :</td>
											<td>=</td>
											<td>RM 
												<span class="text-primary font-weight-bold totalperday" id="total_per_day_{!! $r55++ !!}">
													{!!
($srj->labour * $srj->food_rate)
+
($srj->labour_leader + (($srj->labour_non_leader)*($srj->labour - 1)) / ($srj->working_type_value))
+
(($srj->labour_leader + (($srj->labour_non_leader)*($srj->labour - 1)) / ($srj->working_type_value)) * $srj->overtime_constant_1 * $srj->overtime_constant_2 * $srj->overtime_hour)
+
($srj->accommodation * $srj->accommodation_rate)
+
(
	(
		($srj->hasmanysrjobdetail()->where('return', '<>', 1)->first()->meter_end - $srj->hasmanysrjobdetail()->where('return', '<>', 1)->first()->meter_start) + 
		($srj->hasmanysrjobdetail()->where('return', 1)->first()->meter_end - $srj->hasmanysrjobdetail()->where('return', 1)->first()->meter_start)
		) * $srj->travel_meter_rate
)
+
(($srj->labour_leader + (($srj->labour_non_leader)*($srj->labour - 1)) / ($srj->working_type_value)) * $srj->travel_hour_constant * $srj->travel_hour)
													!!}
												</span>
											</td>
										</tr>
									</tfoot>
								</table>


							</small>
						</div>
						<hr />
					</div>
@endforeach
				<div class="col-sm-12">Grand Total <span class="float-right font-weight-bold">RM <span id="grandtotal"></span></span></div>
				</div>
				<div class="row col-lg-12 add_job">
					<span class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Job</span>
				</div>
			</div>
		</div>
	</div>
</div>

<br />
<div class="form-group row">
	<div class="col-sm-10 offset-sm-2">
		{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
	</div>
</div>