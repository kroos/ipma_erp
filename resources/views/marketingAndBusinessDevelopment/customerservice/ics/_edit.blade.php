<?php
// load model
use \App\Model\Customer;
use \App\Model\ICSCharge;
use \App\Model\ICSCategory;
use \App\Model\Staff;
use \App\Model\ICSFoodRate;
use \App\Model\ICSWorkingType;
use \App\Model\ICSAccommodationRate;
use \App\Model\ICSProceed;
use \App\Model\ICSStatus;
use \App\Model\YesNoLabel;


$cust = Customer::all();
$ch = ICSCharge::all();
$cate = ICSCategory::all();
$staff = Staff::where('active', 1)->get();
?>
<div class="row">
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header">Service Report</div>
			<div class="card-body">
	
					<div class="form-group row {{ $errors->has('date')?'has-error':'' }}">
						{{ Form::label( 'cust', 'Date : ', ['class' => 'col-sm-4 col-form-label'] ) }}
						<div class="col-sm-8">
							{!! Form::text('date', @$value, ['class' => 'form-control col', 'id' => 'date', 'placeholder' => 'Date', 'autocomplete' => 'off']) !!}
						</div>
					</div>
	
				<div class="form-group {{ $errors->has('charge_id')?'has-error':'' }}">
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

				<div class="form-group row {{ $errors->has('category_id')?'has-error':'' }}">
					{{ Form::label( 'cat', 'Service Report Category :', ['class' => 'col-2 col-form-label'] ) }}
					<div class="col">
@foreach($cate as $ca)
						<div class="form-check form-check-inline">
							<div class="pretty p-icon p-round p-smooth">
								{{ Form::radio('category_id', $ca->id, @$value, ['class' => 'form-control']) }}
								<div class="state p-success">
									<i class="icon mdi mdi-check"></i>
									<label>{{ $ca->sr_category }}</label>
								</div>
							</div>
						</div>
@endforeach
					</div>
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
			<div class="card-footer"><a href="{{ route('customer.create', 'id='.$serviceReport->id) }}" class="btn btn-primary float-right">Add Customer</a></div>
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

				<div class="container-fluid phoneattendees_wrap">
@if($serviceReport->hasmanyattendeesphone()->get()->count() > 0)
@foreach( $serviceReport->hasmanyattendeesphone()->get() as $sra )
					<div class="rowphoneattendees">
						<div class="form-row col-sm-12">

							<div class="col-sm-1 text-danger">
									<i class="fas fa-trash remove_phoneattendees" aria-hidden="true" id="button_delete_"></i>
							</div>

							<div class="col-sm-11">
								<div class="form-group {{ $errors->has('srpn.*.phone_number') ? 'has-error' : '' }}">
									<input type="text" name="srpn[1][phone_number]" id="phoen" value="{{ $sra->phone_number }}" class="form-control" placeholder="Attendees Phone Number">
								</div>
							</div>

						</div>
					</div>
@endforeach
@else
					<div class="rowphoneattendees">
						<div class="form-row col-sm-12">

							<div class="col-sm-1 text-danger">
									<i class="fas fa-trash remove_phoneattendees" aria-hidden="true" id="button_delete_"></i>
							</div>

							<div class="col-sm-11">
								<div class="form-group {{ $errors->has('srpn.*.phone_number') ? 'has-error' : '' }}">
									<input type="text" name="srpn[1][phone_number]" id="phoen" value="{{ $sra->phone_number }}" class="form-control" placeholder="Attendees Phone Number">
								</div>
							</div>

						</div>
					</div>
@endif
				</div>
				<div class="row col-lg-12 add_phoneattendees">
					<p class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add phone</p>
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
	<div class="col-sm-12 form-row">
		<div class="col-1 text-danger">&nbsp;</div>
		<div class="col-3"><input type="text" name="" placeholder="Select Model" class="form-control" disabled></div>
		<div class="col-2"><input type="text" name="" placeholder="Test Run Machine" class="form-control" disabled></div>
		<div class="col-2"><input type="text" name="" placeholder="Serial No." class="form-control" disabled></div>
		<div class="col-2"><input type="text" name="" placeholder="Test Capacity" class="form-control" disabled></div>
		<div class="col-2"><input type="text" name="" placeholder="Duration" class="form-control" disabled></div>
	</div>
<?php
$model = \App\Model\ICSMachineModel::all();
$e1 = 1;
$e2 = 1;
$e3 = 1;
$e4 = 1;
$e5 = 1;
$e6 = 1;
$e7 = 1;
$e8 = 1;
$e9 = 1;
$e10 = 1;
?>
@foreach( $serviceReport->hasmanymodel()->get() as $srmo )
					<div class="rowmodel">
						<div class="form-row col-sm-12">
							<div class="col-sm-1 text-danger">
									<i class="fas fa-trash delete_model" aria-hidden="true" id="delete_model_{!! $srmo->id !!}" data-id="{!! $srmo->id !!}"></i>
							</div>
							<div class="form-group col {{ $errors->has('srmo.*.model_id') ? 'has-error' : '' }}">
								<select name="srmo[{{ $e2++ }}][model_id]" id="model_{{ $e1++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Please choose">
									<option value="">Please choose</option>
@foreach( $model as $mod )
									<option value="{!! $mod->id !!}" {!! ($srmo->model_id == $mod->id)?'selected':NULL !!}>{!! $mod->model !!}</option>
@endforeach
								</select>
							</div>
							<div class="form-group col {{ $errors->has('srmo.*.test_run_machine') ? 'has-error' : '' }}">
								{!! Form::text('srmo['. $e3++ .'][test_run_machine]', (!is_null($srmo->test_run_machine))?$srmo->test_run_machine:@$value,['id'=>'test_run_machine_'.$e4++, 'class' => "form-control form-control-sm", 'autocomplete' => "off", 'placeholder' => "Test Run Machine"] ) !!}
							</div>
							<div class="form-group col {{ $errors->has('srmo.*.serial_no') ? 'has-error' : '' }}">
								<input type="text" name="srmo[{{ $e5++ }}][serial_no]" value="{!! (!empty($srmo->serial_no))?$srmo->serial_no:@$value !!}" id="serial_no_{{ $e6++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Serial No." />
							</div>
							<div class="form-group col {{ $errors->has('srmo.*.test_capacity') ? 'has-error' : '' }}">
								<input type="text" name="srmo[{{ $e7++ }}][test_capacity]" value="{!! (!empty($srmo->test_capacity))?$srmo->test_capacity:@$value !!}" id="test_capacity_{{ $e8++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Test Capacity" />
							</div>
							<div class="form-group col {{ $errors->has('srmo.*.duration') ? 'has-error' : '' }}">
								<input type="text" name="srmo[{{ $e9++ }}][duration]" value="{!! (!empty($srmo->duration))?$srmo->duration:@$value !!}" id="duration_{{ $e10++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Duration" />
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
				<a href="{{ route('machine_model.create', 'id='.$serviceReport->id) }}" class="btn btn-primary float-right">Add Model</a>
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
						<div class="col-sm-12 form-row ">

							<div class="col-sm-1 text-danger">
									<i class="fas fa-trash delete_part" aria-hidden="true" id="delete_part_{!! $srp->id !!}" data-id="{!! $srp->id !!}"></i>
							</div>
							<div class="form-group col {{ $errors->has('srp.*.part_accessory') ? 'has-error' : '' }}">
								<input type="text" name="srp[{{ $r++ }}][part_accessory]" value="{!! (!empty($srp->part_accessory))?$srp->part_accessory:@$value !!}" id="part_accessory_{{ $rr++ }}" class="form-control" autocomplete="off" placeholder="Parts & Accessories" />
							</div>
							<div class="form-group col {{ $errors->has('srp.*.qty') ? 'has-error' : '' }}">
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
		<div class="card">
			<div class="card-header">Remarks</div>
			<div class="card-body">
				<div class="form-group row {{ $errors->has('remarks') ? 'has-error' : '' }}">
					{!! Form::label('remarks', 'Remarks : ', ['class' => 'col-form-label col-3']) !!}
					<div class="col-9">
						{!! Form::textarea('remarks', @$value, ['id' => 'remarks', 'class' => 'form-control form-control-sm', 'placeholder' => 'Remarks']) !!}
					</div>
				</div>
			</div>
		</div>
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

$r71 = 1;
$r72 = 1;

$gt = 0;
?>
@foreach( $serviceReport->hasmanyjob()->get() as $srj )
					<div class="rowjob">
						<div class="col-sm-12 form-row ">

							<div class="col-1 text-danger">
								<i class="fas fa-trash delete_job" aria-hidden="true" id="delete_job_{!! $srj->id !!}" data-id="{!! $srj->id !!}"></i>
							</div>
							<div class="form-group col-2 {{ $errors->has('srj.*.date') ? 'has-error' : '' }}">
								<input type="text" name="srj[{{ $r1++ }}][date]" value="{!! (!empty($srj->date))?$srj->date:@$value !!}" id="date_{{ $r2++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Date" />
							</div>

							<div class="form-group col-1 {{ $errors->has('srj.*.labour') ? 'has-error' : '' }}">
								<input type="text" name="srj[{{ $r3++ }}][labour]" value="{!! (!empty($srj->labour))?$srj->labour:@$value !!}" id="labour_{{ $r4++ }}" class="form-control form-control-sm labour_" autocomplete="off" placeholder="Labour Count" />
							</div>

							<div class="form-group col-4 {{ $errors->has('srj.*.job_perform') ? 'has-error' : '' }}">
								<textarea type="textarea" name="srj[{{ $r5++ }}][job_perform]" value="{!! (!empty($srj->job_perform))?$srj->job_perform:@$value !!}" id="job_perform_{{ $r6++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Job Perform" />{{ $srj->job_perform }}</textarea>
							</div>

							<div class="form-group col-2 {{ $errors->has('srj.*.working_time_start') ? 'has-error' : '' }}">
								<input type="text" name="srj[{{ $r7++ }}][working_time_start]" value="{!! (!empty($srj->working_time_start))?$srj->working_time_start:@$value !!}" id="wts_{{ $r8++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Working Time Start" />
							</div>

							<div class="form-group col-2 {{ $errors->has('srj.*.working_time_end') ? 'has-error' : '' }}">
								<input type="text" name="srj[{{ $r9++ }}][working_time_end]" value="{!! (!empty($srj->working_time_end))?$srj->working_time_end:@$value !!}" id="wte_{{ $r10++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Working Time End" />
							</div>
						</div>
						<br />
@foreach( $srj->hasmanysrjobdetail()->where('return', '<>', 1)->get() as $srjd )
						<div class="col-sm-12 form-row ">
							<div class="col-sm-1 text-primary"><small>To <i class="fas fa-arrow-right"></i> <i class="fas fa-map-marker-alt"></i></small></div>

							<div class="form-group {{ $errors->has('srj.*.srjde.*.date') ? 'has-error' : '' }}">
								<input type="text" name="srj[{!! $r56++ !!}][srjde][1][destination_start]" value="{!! (!empty($srjd->destination_start))?$srjd->destination_start:@$value !!}" id="ds_1_{{ $r11++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Destination Start" />
							</div>

							<div class="form-group col {{ $errors->has('srj.*.srjde.*.destination_end') ? 'has-error' : '' }}">
								<input type="text" name="srj[{!! $r57++ !!}][srjde][1][destination_end]" value="{!! (!empty($srjd->destination_end))?$srjd->destination_end:@$value !!}" id="de_1_{{ $r12++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Destination End" />
							</div>

							<div class="form-group col {{ $errors->has('srj.*.srjde.*.meter_start') ? 'has-error' : '' }}">
								<input type="textarea" name="srj[{!! $r58++ !!}][srjde][1][meter_start]" value="{!! (!empty($srjd->meter_start))?$srjd->meter_start:@$value !!}" id="ms_1_{{ $r13++ }}" class="form-control form-control-sm meterstart1" autocomplete="off" placeholder="Meter Start" />
							</div>

							<div class="form-group col {{ $errors->has('srj.*.srjde.*.meter_end') ? 'has-error' : '' }}">
								<input type="text" name="srj[{!! $r59++ !!}][srjde][1][meter_end]" value="{!! (!empty($srjd->meter_end))?$srjd->meter_end:@$value !!}" id="me_1_{{ $r14++ }}" class="form-control form-control-sm meterend1" autocomplete="off" placeholder="Meter End" />
							</div>

							<div class="form-group col {{ $errors->has('srj.*.srjde.*.time_start') ? 'has-error' : '' }}">
								<input type="text" name="srj[{!! $r60++ !!}][srjde][1][time_start]" value="{!! (!empty($srjd->time_start))?$srjd->time_start:@$value !!}" id="ts_1_{{ $r15++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Travel Time Start" />
							</div>

							<div class="form-group col {{ $errors->has('srj.*.srjde.*.time_end') ? 'has-error' : '' }}">
								<input type="text" name="srj[{!! $r61++ !!}][srjde][1][time_end]" value="{!! (!empty($srjd->time_end))?$srjd->time_end:@$value !!}" id="te_1_{{ $r16++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Travel Time End" />
							</div>
							<input type="hidden" name="srj[{!! $r62++ !!}][srjde][1][return]" value="0">
						</div>
@endforeach
@foreach( $srj->hasmanysrjobdetail()->where('return', 1)->get() as $srjd )
						<div class="col-sm-12 form-row ">
							<div class="col-sm-1 text-primary"><small>Return <i class="fas fa-map-marker-alt"></i> <i class="fas fa-undo"></i></small></div>

							<div class="form-group col {{ $errors->has('srj.*.srjde.*.date') ? 'has-error' : '' }}">
								<input type="text" name="srj[{!! $r63++ !!}][srjde][2][destination_start]" value="{!! (!empty($srjd->destination_start))?$srjd->destination_start:@$value !!}" id="ds_2_{{ $r17++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Destination Start" />
							</div>

							<div class="form-group col {{ $errors->has('srj.*.srjde.*.destination_end') ? 'has-error' : '' }}">
								<input type="text" name="srj[{!! $r64++ !!}][srjde][2][destination_end]" value="{!! (!empty($srjd->destination_end))?$srjd->destination_end:@$value !!}" id="de_2_{{ $r18++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Destination End" />
							</div>

							<div class="form-group col {{ $errors->has('srj.*.srjde.*.meter_start') ? 'has-error' : '' }}">
								<input type="textarea" name="srj[{!! $r65++ !!}][srjde][2][meter_start]" value="{!! (!empty($srjd->meter_start))?$srjd->meter_start:@$value !!}" id="ms_2_{{ $r19++ }}" class="form-control form-control-sm meterstart2" autocomplete="off" placeholder="Meter Start" />
							</div>

							<div class="form-group col {{ $errors->has('srj.*.srjde.*.meter_end') ? 'has-error' : '' }}">
								<input type="text" name="srj[{!! $r66++ !!}][srjde][2][meter_end]" value="{!! (!empty($srjd->meter_end))?$srjd->meter_end:@$value !!}" id="me_2_{{ $r20++ }}" class="form-control form-control-sm meterend2" autocomplete="off" placeholder="Meter End" />
							</div>

							<div class="form-group col {{ $errors->has('srj.*.srjde.*.time_start') ? 'has-error' : '' }}">
								<input type="text" name="srj[{!! $r67++ !!}][srjde][2][time_start]" value="{!! (!empty($srjd->time_start))?$srjd->time_start:@$value !!}" id="ts_2_{{ $r21++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Travel Time Start" />
							</div>

							<div class="form-group col {{ $errors->has('srj.*.srjde.*.time_end') ? 'has-error' : '' }}">
								<input type="text" name="srj[{!! $r68++ !!}][srjde][2][time_end]" value="{!! (!empty($srjd->time_end))?$srjd->time_end:@$value !!}" id="te_2_{{ $r22++ }}" class="form-control form-control-sm" autocomplete="off" placeholder="Travel Time End" />
							</div>
							<input type="hidden" name="srj[{!! $r69++ !!}][srjde][2][return]" value="1">
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
												<select name="srj[{{ $r72++ }}][food_rate]" id="fr_{!! $r23++ !!}" class="form-control form-control-sm fr_" placeholder="Please choose">
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
											<td><span class="allowancenonleader" id="non_leader_count{{ $r30++ }}">{{ $srj->labour - 1 }}</span> Person</td>
											<td>)</td>
											<td>/</td>
											<td class="form-group {{ $errors->has('srj.*.working_type_value') ? ' has-error' : '' }}">
												<select name="srj[{{ $r31++ }}][working_type_value]" id="wtv_{!! $r70++ !!}" class="form-control form-control-sm workingtypevalue">
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
												RM <span class="totallabourallowance1" id="total_labour_{!! $r33++ !!}">{{ $srj->labour_leader + (($srj->labour_non_leader)*($srj->labour - 1)) / ($srj->working_type_value) }}</span>
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
												<input type="text" name="srj[{{ $r37++ }}][accommodation_rate]" value="{{ (!is_null($srj->accommodation_rate))?$srj->accommodation_rate:\App\Model\ICSFloatthConstant::where('active', 1)->first()->accommodation_rate }}" class="form-control form-control-sm accommodationrate" id="accommodation_rate_{!! $r38++ !!}" placeholder="Accommodation Rate (RM)">
											</td>
											<td>X</td>
											<td>
												<select name="srj[{!! $r71++ !!}][accommodation]" id="accommodation_{!! $r39++ !!}" class="form-control form-control-sm accommodation" placeholder="Please choose">
													<option value="">Please choose</option>
@foreach( ICSAccommodationRate::all() as $acr )
													<option value="{!! $acr->value !!}" {!! ($acr->value == $srj->accommodation)?'selected':NULL !!} data-value="{!! $acr->value !!}">{!! $acr->accommodation_rate !!}</option>
@endforeach
												</select>
											</td>
											<td colspan="6">&nbsp;</td>
											<td>=</td>
											<td class="font-weight-bold">RM <span class="totalaccommodation" id="total_accommodation_{{ $r40++ }}">{!! $srj->accommodation * $srj->accommodation_rate !!}</span></td>
										</tr>
										<tr>
											<td>Travel :</td>
											<td colspan="2">
												Meter Calculator:<br />
												Trip : <span class="meterend11" id="ms_1_{{ $r41++ }}">{{ $srj->hasmanysrjobdetail()->where('return', '<>', 1)->first()->meter_end }}</span> - <span class="meterstart11" id="me_1_{{ $r42++ }}">{{ $srj->hasmanysrjobdetail()->where('return', '<>', 1)->first()->meter_start }}</span> = <span class="km1" id="total_go_1_{!! $r43++ !!}">{{ $srj->hasmanysrjobdetail()->where('return', '<>', 1)->first()->meter_end - $srj->hasmanysrjobdetail()->where('return', '<>', 1)->first()->meter_start }}</span> KM<br />
												Return : <span class="meterend22" id="ms_2_{{ $r44++ }}">{{ $srj->hasmanysrjobdetail()->where('return', 1)->first()->meter_end }}</span> - <span class="meterstart22" id="me_2_{{ $r45++ }}">{{ $srj->hasmanysrjobdetail()->where('return', 1)->first()->meter_start }}</span> = <span class="km2" id="total_go_2_{!! $r46++ !!}">{{ $srj->hasmanysrjobdetail()->where('return', 1)->first()->meter_end - $srj->hasmanysrjobdetail()->where('return', 1)->first()->meter_start }}</span> KM<br />
												Total = <span class="totalkm" id="total_km_1_{!! $r47++ !!}">
													{!! 
															($srj->hasmanysrjobdetail()->where('return', '<>', 1)->first()->meter_end - $srj->hasmanysrjobdetail()->where('return', '<>', 1)->first()->meter_start) + 
															($srj->hasmanysrjobdetail()->where('return', 1)->first()->meter_end - $srj->hasmanysrjobdetail()->where('return', 1)->first()->meter_start)
													 !!}
												</span> KM
											</td>
											<td>X</td>
											<td><span class="travelmeterrate" id="tmr_{!! $r48++ !!}">{!! $srj->travel_meter_rate !!}</span></td>
											<td colspan="5"></td>
											<td>=</td>
											<td class="font-weight-bold">
												RM <span class="totaltravel" id="total_meter_{!! $r49 !!}">{!!
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
												 <span class="totallabourallowance2" id="total_labour_th_{!! $r50++ !!}">{{ $srj->labour_leader + (($srj->labour_non_leader)*($srj->labour - 1)) / ($srj->working_type_value) }}</span>
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
<?php
$gt += ($srj->labour * $srj->food_rate)
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
(($srj->labour_leader + (($srj->labour_non_leader)*($srj->labour - 1)) / ($srj->working_type_value)) * $srj->travel_hour_constant * $srj->travel_hour);

?>
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
				</div>
				<div class="col-sm-12">Grand Total <span class="float-right font-weight-bold text-primary">RM <span id="grandtotal">{{ $gt }}</span></span></div>
				<div class="row col-lg-12 add_job">
					<span class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Job</span>
				</div>
			</div>
		</div>
	</div>
</div>

<br />

<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">Logistic</div>
			<div class="card-body">
				<div class="container-fluid logistic_wrap">
<?php
$l1 = 1;
$l2 = 1;
$l3 = 1;
$l4 = 1;
$l5 = 1;
$l6 = 1;
$l7 = 1;
$l8 = 1;
$tl = 0;
?>
@if( $serviceReport->hasmanylogistic()->get()->count() > 0 )
@foreach($serviceReport->hasmanylogistic()->get() as $srL)
					<div class="rowsrlogistic">
						<div class="form-row col-sm-12">

							<div class="col-sm-1 text-danger">
									<i class="fas fa-trash delete_logistic" aria-hidden="true" id="delete_logistic_{!! $srL->id !!}" data-id="{!! $srL->id !!}"></i>
							</div>
							<div class="form-group col-3 {{ $errors->has('srL.*.vehicle_category') ? 'has-error' : '' }}">
								<select name="srL[{{ $l1++ }}][vehicle_category]" id="vc_{{ $l2++ }}" class="form-control form-control-sm" placeholder="Please choose">
									<option value="">Please choose</option>
@foreach( \App\Model\VehicleCategory::all() as $vc )
									<option value="{{ $vc->id }}" {{ ($vc->id == $srL->belongtovehicle->belongtovehiclecategory->id)?'selected':NULL }} >{{ $vc->category }}</option>
@endforeach
								</select>
							</div>
							<div class="form-group col-3 {{ $errors->has('srL.*.vehicle_id') ? 'has-error' : '' }}">
								<select name="srL[{{ $l3++ }}][vehicle_id]" id="v_{{ $l4++ }}" class="form-control form-control-sm" placeholder="Please choose">
									<option value="" data-chained="">Please choose</option>
@foreach( \App\Model\Vehicle::all() as $v )
									<option value="{{ $v->id }}"  data-chained="{{ $v->vehicle_category_id }}" {{ ($v->id == $srL->vehicle_id)?'selected':NULL }} >{{ $v->vehicle }}</option>
@endforeach
								</select>
							</div>
							<div class="form-group col-3 {{ $errors->has('srL.*.description') ? 'has-error' : '' }}">
								<input type="text" name="srL[{{ $l5++ }}][description]" value="{{ ( !is_null($srL->description) )?$srL->description:@$value }}" id="description_{{ $l6++ }}" class="form-control form-control-sm" placeholder="Description">
							</div>
							<div class="form-group col-2 {{ $errors->has('srL.*.charge') ? 'has-error' : '' }}">
								<input type="text" name="srL[{{ $l7++ }}][charge]" value="{{ ( !is_null($srL->charge) )?$srL->charge:@$value }}" id="charge_{{ $l8++ }}" class="form-control form-control-sm logistic_charge" placeholder="Charge (MYR)">
							</div>
						</div>
					</div>
<?php $tl += $srL->charge; ?>
@endforeach
@else
					<div class="rowsrlogistic">
						<div class="form-row col-sm-12">
							<div class="col-sm-1 text-danger">
									<i class="fas fa-trash" aria-hidden="true" id="delete_feedProb_1" data-id="1"></i>
							</div>
							<div class="form-group col-3 {{ $errors->has('srL.*.vehicle_category') ? 'has-error' : '' }}">
								<select name="srL[1]vehicle_category" id="vc_1" class="form-control form-control-sm" placeholder="Please choose">
									<option value="">Please choose</option>
@foreach( \App\Model\VehicleCategory::all() as $vc )
									<option value="{{ $vc->id }}" >{{ $vc->category }}</option>
@endforeach
								</select>
							</div>
							<div class="form-group col-3 {{ $errors->has('srL.*.solution') ? 'has-error' : '' }}">
								<select name="srL[1][vehicle_id]" id="v_1" class="form-control form-control-sm" placeholder="Please choose">
									<option value="" data-chained="">Please choose</option>
@foreach( \App\Model\Vehicle::all() as $v )
									<option value="{{ $v->id }}"  data-chained="{{ $v->vehicle_category_id }}" >{{ $v->vehicle }}</option>
@endforeach
								</select>
							</div>
							<div class="form-group col-3 {{ $errors->has('srL.*.description') ? 'has-error' : '' }}">
								<input type="text" name="srL[1][description]" value="{{ @$value }}" id="description_1" class="form-control form-control-sm" placeholder="Description">
							</div>
							<div class="form-group col-2 {{ $errors->has('srL.*.charge') ? 'has-error' : '' }}">
								<input type="text" name="srL[1][charge]" value="{{ @$value }}" id="charge_1" class="form-control form-control-sm logistic_charge" placeholder="Charge (MYR)">
							</div>
						</div>
					</div>
@endif
				</div>
				<div class="col-sm-12">Grand Total Logistic<span class="float-right font-weight-bold text-primary">RM <span id="grandtotallogistic">{{ $tl }}</span></span></div>
				<div class="row col-lg-12 add_logistic">
					<span class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add More Transport</span>
				</div>
			</div>
		</div>
	</div>
</div>

<br />

<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">Additional Charges</div>
			<div class="card-body">

				<div class="container-fluid addcharges_wrap">
<?php
$ac1 = 1;
$ac2 = 1;
$ac3 = 1;
$ac4 = 1;
$ac5 = 1;
$ac6 = 1;
$tac = 0;
?>
@if( $serviceReport->hasmanyadditionalcharge()->get()->count() > 0 )
@foreach($serviceReport->hasmanyadditionalcharge()->get() as $srAC)
					<div class="rowsraddcharges">
						<div class="form-row col-sm-12">

							<div class="col-sm-1 text-danger">
									<i class="fas fa-trash delete_addcharge" aria-hidden="true" id="delete_addcharge_{!! $srAC->id !!}" data-id="{!! $srAC->id !!}"></i>
							</div>
							<div class="form-group col-3 {{ $errors->has('srAC.*.amount_id') ? 'has-error' : '' }}">
								<select name="srAC[{{ $ac1++ }}][amount_id]" id="aid_{{ $ac2++ }}" class="form-control form-control-sm" placeholder="Please choose">
									<option value="">Please choose</option>
@foreach( \App\Model\Amount::all() as $am )
									<option value="{{ $am->id }}" {{ ($am->id == $srAC->amount_id)?'selected':NULL }} >{{ $am->amount }}</option>
@endforeach
								</select>
							</div>
							<div class="form-group col-6 {{ $errors->has('srAC.*.description') ? 'has-error' : '' }}">
								<input type="text" name="srAC[{{ $ac3++ }}][description]" value="{!! (!is_null($srAC->description))?$srAC->description:@$value !!}" class="form-control form-control-sm" id="description_amount_{{ $ac4++ }}" placeholder="Description" >
							</div>
							<div class="form-group col-2 {{ $errors->has('srAC.*.value') ? 'has-error' : '' }}">
								<input type="text" name="srAC[{{ $ac5++ }}][value]" value="{{ ( !is_null($srAC->value) )?$srAC->value:@$value }}" id="value_{{ $ac6++ }}" class="form-control form-control-sm value" placeholder="Amount (MYR)">
							</div>
						</div>
					</div>
<?php $tac += $srAC->value; ?>
@endforeach
@endif
				</div>
				<div class="col-sm-12">Grand Total Additional Charges<span class="float-right font-weight-bold text-primary">RM <span id="grandtotaladdcharges">{{ @$tac }}</span></span></div>
				<div class="row col-lg-12 add_addchrages">
					<span class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Additional Charges</span>
				</div>

			</div>
		</div>
	</div>
</div>

<br />

<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">Discount</div>
			<div class="card-body">

				<div class="container-fluid discount_wrap">
<?php
$dis1 = 1;
$dis2 = 1;
$dis3 = 1;
$dis4 = 1;
$tdisx = 0;
?>
@if( $serviceReport->hasonediscount()->get()->count() > 0 )
@foreach($serviceReport->hasonediscount()->get() as $srDisc)
					<div class="rowsrdiscount">
						<div class="form-row col-sm-12">

							<div class="col-sm-1 text-danger">
									<i class="fas fa-trash delete_discount" aria-hidden="true" id="delete_discount_{!! $srDisc->id !!}" data-id="{!! $srDisc->id !!}"></i>
							</div>
							<div class="form-group col-3 {{ $errors->has('srDisc.*.discount_id') ? 'has-error' : '' }}">
								<select name="srDisc[{{ $dis1++ }}][discount_id]" id="srdisc_{{ $dis2++ }}" class="form-control form-control-sm discount_id" placeholder="Please choose">
									<option value="">Please choose</option>
@foreach( \App\Model\Discount::all() as $disc )
									<option value="{{ $disc->id }}" {{ ($disc->id == $srDisc->discount_id)?'selected':NULL }} >{{ $disc->discount_type }}</option>
@endforeach
								</select>
							</div>
							<div class="form-group col-2 {{ $errors->has('srDisc.*.value') ? 'has-error' : '' }}">
								<input type="text" name="srDisc[{{ $dis3++ }}][value]" value="{{ ( !is_null($srDisc->value) )?$srDisc->value:@$value }}" id="value_{{ $dis4++ }}" class="form-control form-control-sm value_disc" placeholder="Value">
							</div>
							<div class="col-3">
							&nbsp;
							</div>
							<div class="col-1">
							=
							</div>
							<div class="col-2">
							RM <span id="discount_value">{{ $tdisx }}</span>
							</div>
						</div>
					</div>
<?php $tdisx += $srDisc->value; ?>
@endforeach
@endif
				</div>
				<div class="col-sm-12">Grand Total Service Report<span class="float-right font-weight-bold text-primary">RM <span id="grandtotaldiscount">{{ @$tac }}</span></span></div>
				<div class="row col-lg-12 add_discount">
					<span class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Discount</span>
				</div>

			</div>
		</div>
	</div>
</div>

<br />

<div class="row">
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header">Problem Detect On Site</div>
			<div class="card-body">

				<div class="container-fluid feedProb_wrap">
<?php
$p1 = 1;
$p2 = 1;
$p3 = 1;
$p4 = 1;
?>
@if( $serviceReport->hasmanyfeedproblem()->get()->count() > 0 )
@foreach($serviceReport->hasmanyfeedproblem()->get() as $srfP)
					<div class="rowfeedProb">
						<div class="col-sm-12 form-row ">

							<div class="col-sm-1 text-danger">
									<i class="fas fa-trash delete_feedProb" aria-hidden="true" id="delete_feedProb_{!! $srfP->id !!}" data-id="{!! $srfP->id !!}"></i>
							</div>
							<div class="form-group col {{ $errors->has('srfP.*.problem') ? 'has-error' : '' }}">
								<textarea name="srfP[{{ $p1++ }}][problem]" value="{!! (!empty($srfP->problem))?$srfP->problem:@$value !!}" id="problem_{{ $p2++ }}" class="form-control" autocomplete="off" placeholder="Problem" />{{ $srfP->problem }}</textarea>
							</div>
							<div class="form-group col {{ $errors->has('srfP.*.solution') ? 'has-error' : '' }}">
								<textarea name="srfP[{{ $p3++ }}][solution]" value="{!! (!empty($srfP->solution))?$srfP->solution:@$value !!}" id="solution_{{ $p4++ }}" class="form-control" autocomplete="off" placeholder="Solution" />{{ $srfP->solution }}</textarea>
							</div>
						</div>
					</div>
@endforeach
@else
					<div class="rowfeedProb">
						<div class="col-sm-12 form-row ">

							<div class="col-sm-1 text-danger">
									<i class="fas fa-trash remove_feedProb" aria-hidden="true" id="delete_feedProb_1" data-id="1"></i>
							</div>
							<div class="form-group col {{ $errors->has('srfP.*.problem') ? 'has-error' : '' }}">
								<textarea name="srfP[1][problem]" value="{!! @$value !!}" id="problem_1" class="form-control" autocomplete="off" placeholder="Problem" /></textarea>
							</div>
							<div class="form-group col {{ $errors->has('srfP.*.solution') ? 'has-error' : '' }}">
								<textarea name="srfP[1][solution]" value="{!! @$value !!}" id="solution_1" class="form-control" autocomplete="off" placeholder="Solution" /></textarea>
							</div>
						</div>
					</div>
@endif
				</div>
				<div class="row col-lg-12 add_feedProb">
					<span class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add More Columns</span>
				</div>


			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header">Additional Request (Order Part, Request For Next Service)</div>
			<div class="card-body">

				<div class="container-fluid feedReq_wrap">
<?php
$p1 = 1;
$p2 = 1;
$p3 = 1;
$p4 = 1;
?>
@if( $serviceReport->hasmanyfeedrequest()->get()->count() > 0 )
@foreach($serviceReport->hasmanyfeedrequest()->get() as $srfR)
					<div class="rowfeedReq">
						<div class="col-sm-12 form-row ">
							<div class="col-sm-1 text-danger">
									<i class="fas fa-trash delete_feedReq" aria-hidden="true" id="delete_feedReq_{!! $srfR->id !!}" data-id="{!! $srfR->id !!}"></i>
							</div>
							<div class="form-group col {{ $errors->has('srfR.*.request') ? 'has-error' : '' }}">
								<input type="text" name="srfR[{{ $p1++ }}][request]" value="{!! (!empty($srfR->request))?$srfR->request:@$value !!}" id="request_{{ $p2++ }}" class="form-control" autocomplete="off" placeholder="Additional Request" />
							</div>
							<div class="form-group col {{ $errors->has('srfR.*.action') ? 'has-error' : '' }}">
								<input type="text" name="srfR[{{ $p3++ }}][action]" value="{!! (!empty($srfR->action))?$srfR->action:@$value !!}" id="action_{{ $p4++ }}" class="form-control" autocomplete="off" placeholder="Action (Fill By Management)" />
							</div>
						</div>
					</div>
@endforeach
@else
					<div class="rowfeedReq">
						<div class="col-sm-12 form-row ">
							<div class="col-sm-1 text-danger">
									<i class="fas fa-trash remove_feedReq" aria-hidden="true" id="delete_feedReq" data-id="1"></i>
							</div>
							<div class="form-group col {{ $errors->has('srfR.*.request') ? 'has-error' : '' }}">
								<input type="text" name="srfR[1][request]" value="{!! @$value !!}" id="request_1" class="form-control" autocomplete="off" placeholder="Additional Request" />
							</div>
							<div class="form-group col {{ $errors->has('srfR.*.action') ? 'has-error' : '' }}">
								<input type="text" name="srfR[1][action]" value="{!! @$value !!}" id="action_1" class="form-control" autocomplete="off" placeholder="Action (Fill By Management)" />
							</div>
						</div>
					</div>
@endif
				</div>
				<div class="row col-lg-12 add_feedReq">
					<span class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add More Request</span>
				</div>

			</div>
		</div>
	</div>
</div>

<br />

<div class="row">
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header">Item Brought Back To IPMA</div>
			<div class="card-body">

				<div class="container-fluid feedItem_wrap">
<?php
$item1 = 1;
$item2 = 1;
$item3 = 1;
$item4 = 1;
$item5 = 1;
$item6 = 1;
?>
@if( $serviceReport->hasmanyfeeditem()->get()->count() > 0 )
@foreach($serviceReport->hasmanyfeeditem()->get() as $srfI)
					<div class="rowfeedItem">
						<div class="form-row col-sm-12">
							<div class="col-sm-1 text-danger">
									<i class="fas fa-trash delete_feedItem" aria-hidden="true" id="delete_feedItem_{!! $srfI->id !!}" data-id="{!! $srfI->id !!}"></i>
							</div>
							<div class="form-group col-3 {{ $errors->has('srfI.*.item') ? 'has-error' : '' }}">
								<input type="text" name="srfI[{{ $item1++ }}][item]" value="{!! (!empty($srfI->item))?$srfI->item:@$value !!}" id="item_{{ $item2++ }}" class="form-control" autocomplete="off" placeholder="Item" />
							</div>
							<div class="form-group col-3 {{ $errors->has('srfI.*.quantity') ? 'has-error' : '' }}">
								<input type="text" name="srfI[{{ $item3++ }}][quantity]" value="{!! (!empty($srfI->quantity))?$srfI->quantity:@$value !!}" id="quantity_{{ $item4++ }}" class="form-control" autocomplete="off" placeholder="Quantity" />
							</div>
							<div class="form-group col-3 {{ $errors->has('srfI.*.item_action') ? 'has-error' : '' }}">
								<input type="text" name="srfI[{{ $item5++ }}][item_action]" value="{!! (!empty($srfI->item_action))?$srfI->item_action:@$value !!}" id="item_action_{{ $item6++ }}" class="form-control" autocomplete="off" placeholder="Action (Fill By Management)" />
							</div>
						</div>
					</div>
@endforeach
@else
					<div class="rowfeedItem">
						<div class="form-row col-sm-12">
							<div class="col-sm-1 text-danger">
									<i class="fas fa-trash remove_feedItem" aria-hidden="true" id="delete_feedReq"></i>
							</div>
							<div class="form-group col-3 {{ $errors->has('srfI.*.item') ? 'has-error' : '' }}">
								<input type="text" name="srfI[1][item]" value="{!! @$value !!}" id="item_1" class="form-control" autocomplete="off" placeholder="Item" />
							</div>
							<div class="form-group col-3 {{ $errors->has('srfI.*.quantity') ? 'has-error' : '' }}">
								<input type="text" name="srfI[1][quantity]" value="{!! @$value !!}" id="quantity_1" class="form-control" autocomplete="off" placeholder="Quantity" />
							</div>
							<div class="form-group col-3 {{ $errors->has('srfI.*.item_action') ? 'has-error' : '' }}">
								<input type="text" name="srfI[1][item_action]" value="{!! @$value !!}" id="item_action_1" class="form-control" autocomplete="off" placeholder="Action (Fill By Management)" />
							</div>
						</div>
					</div>
@endif
				</div>
				<div class="row col-lg-12 add_feedItem">
					<span class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add More Request</span>
				</div>

			</div>	
		</div>
	</div>
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header">Customer Site Survey</div>
			<div class="card-body">
<?php
if (!is_null($serviceReport->hasmanyfeedback()->first())) {
	$nm = $serviceReport->hasmanyfeedback()->first()->new_machine;
	$be = $serviceReport->hasmanyfeedback()->first()->building_expansion;
	$pacs = $serviceReport->hasmanyfeedback()->first()->problem_at_client_site;
} else {
	$nm = NULL;
	$be = NULL;
	$pacs = NULL;
}
?>
				<div class="form-group {{ $errors->has('new_machine') ? 'has-error' : '' }}">
					{{ Form::label( 'feed_new_machine', 'New Machine Found On Site : ', ['class' => 'col-sm-6 col-form-label'] ) }}
@foreach( YesNoLabel::all() as $ynl )
					<div class="form-check form-check-inline">
						<div class="pretty p-icon p-round p-smooth">
							{{ Form::radio('new_machine', $ynl->value, ($ynl->value == $nm)?true:@$value, ['class' => 'form-control']) }}
							<div class="state p-success">
								<i class="icon mdi mdi-check"></i>
								<label>{{ $ynl->label }}</label>
							</div>
						</div>
					</div>
@endforeach
				</div>

				<div class="form-group {{ $errors->has('building_expansion') ? 'has-error' : '' }}">
					{{ Form::label( 'feed_building_machine', 'Building Expansion : ', ['class' => 'col-sm-6 col-form-label'] ) }}
@foreach( YesNoLabel::all() as $ynl )
					<div class="form-check form-check-inline">
						<div class="pretty p-icon p-round p-smooth">
							{{ Form::radio('building_expansion', $ynl->value, ($ynl->value == $be)?true:@$value, ['class' => 'form-control']) }}
							<div class="state p-success">
								<i class="icon mdi mdi-check"></i>
								<label>{{ $ynl->label }}</label>
							</div>
						</div>
					</div>
@endforeach
				</div>

				<div class="form-group {{ $errors->has('problem_at_client_site') ? 'has-error' : '' }}">
					{{ Form::label( 'feed_problem_customer_site', 'Problem At Customer Site : ', ['class' => 'col-sm-6 col-form-label'] ) }}
@foreach( YesNoLabel::all() as $ynl )
					<div class="form-check form-check-inline">
						<div class="pretty p-icon p-round p-smooth">
							{{ Form::radio('problem_at_client_site', $ynl->value, ($ynl->value == $pacs)?true:@$value, ['class' => 'form-control']) }}
							<div class="state p-success">
								<i class="icon mdi mdi-check"></i>
								<label>{{ $ynl->label }}</label>
							</div>
						</div>
					</div>
@endforeach
				</div>

			</div>	
		</div>
	</div>
</div>

<br />

<div class="row">
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header">Service Report Proceed With :</div>
			<div class="card-body">
<?php
if(!is_null($serviceReport->hasmanyfeedback()->first())) {
	$pid = $serviceReport->hasmanyfeedback()->first()->proceed_id;
} else {
	$pid = NULL;
}
?>
				<div class="form-group row {{ $errors->has('proceed_id') ? 'has-error' : '' }}">
					{{ Form::label( 'proceed', 'Proceed With : ', ['class' => 'col-sm-4 col-form-label'] ) }}
@foreach( ICSProceed::all() as $pro )
					<div class="form-check form-check-inline">
						<div class="pretty p-icon p-round p-smooth">
							{{ Form::radio('proceed_id', $pro->id, @$value, ['class' => 'form-control']) }}
							<div class="state p-success">
								<i class="icon mdi mdi-check"></i>
								<label>{{ $pro->proceed }}</label>
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
			<div class="card-header">Status</div>
			<div class="card-body">
				<div class="form-group row {{ $errors->has('status_id') ? 'has-error' : '' }}">
					{{ Form::label( 'status', 'Status : ', ['class' => 'col-sm-4 col-form-label'] ) }}
@foreach(ICSStatus::all() as $st1)
					<div class="form-check form-check-inline">
						<div class="pretty p-icon p-round p-smooth">
							{{ Form::radio('status_id', $st1->id, @$value, ['class' => 'form-control']) }}
							<div class="state p-success">
								<i class="icon mdi mdi-check"></i>
								<label>{{ $st1->sr_status }}</label>
							</div>
						</div>
					</div>
@endforeach
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