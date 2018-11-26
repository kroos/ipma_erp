<?php
// load model
use \App\Model\Customer;
use \App\Model\ICSCharge;
use \App\Model\Staff;


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

				<div class="container-fluid jobdetail_wrap">
<?php

?>
@foreach( $serviceReport->hasmanyjob()->get() as $srj )
					<div class="rowjobdetail">
						<div class="row col-sm-12 form-inline">

							<div class="col-sm-1 text-danger">
								<i class="fas fa-trash delete_job" aria-hidden="true" id="delete_job_" data-id=""></i>
							</div>
							<div class="form-group {{ $errors->has('srj.*.date') ? 'has-error' : '' }}">
								<input type="text" name="srj[{{ $r++ }}][date]" value="{!! (!empty($srj->date))?$srj->date:@$value !!}" id="part_accessory_{{ $rr++ }}" class="form-control" autocomplete="off" placeholder="Date" />
							</div>

							<div class="form-group {{ $errors->has('srj.*.labour') ? 'has-error' : '' }}">
								<input type="text" name="srj[{{ $r++ }}][labour]" value="{!! (!empty($srj->labour))?$srj->labour:@$value !!}" id="part_accessory_{{ $rr++ }}" class="form-control" autocomplete="off" placeholder="Labour Count" />
							</div>

							<div class="form-group {{ $errors->has('srj.*.job_perform') ? 'has-error' : '' }}">
								<input type="textarea" name="srj[{{ $r++ }}][job_perform]" value="{!! (!empty($srj->job_perform))?$srj->job_perform:@$value !!}" id="part_accessory_{{ $rr++ }}" class="form-control" autocomplete="off" placeholder="Job Perform" />
							</div>

							<div class="form-group {{ $errors->has('srj.*.working_time_start') ? 'has-error' : '' }}">
								<input type="text" name="srj[{{ $r++ }}][working_time_start]" value="{!! (!empty($srj->working_time_start))?$srj->working_time_start:@$value !!}" id="part_accessory_{{ $rr++ }}" class="form-control" autocomplete="off" placeholder="Working Time Start" />
							</div>

							<div class="form-group {{ $errors->has('srj.*.working_time_end') ? 'has-error' : '' }}">
								<input type="text" name="srj[{{ $r++ }}][working_time_end]" value="{!! (!empty($srj->working_time_end))?$srj->working_time_end:@$value !!}" id="part_accessory_{{ $rr++ }}" class="form-control" autocomplete="off" placeholder="Working Time End" />
							</div>
						</div>

@foreach( $srj->hasmanysrjobdetail()->where('return', '<>', 1)->get() as $srjd )
						<div class="row col-sm-12 form-inline">
							<div class="col-sm-1 text-primary">Trip<br />=></div>
							<div class="form-group {{ $errors->has('srjd.*.date') ? 'has-error' : '' }}">
								<input type="text" name="srjd[{{ $r++ }}][date]" value="{!! (!empty($srjd->date))?$srjd->date:@$value !!}" id="part_accessory_{{ $rr++ }}" class="form-control" autocomplete="off" placeholder="Date" />
							</div>

							<div class="form-group {{ $errors->has('srjd.*.labour') ? 'has-error' : '' }}">
								<input type="text" name="srjd[{{ $r++ }}][labour]" value="{!! (!empty($srjd->labour))?$srjd->labour:@$value !!}" id="part_accessory_{{ $rr++ }}" class="form-control" autocomplete="off" placeholder="Labour Count" />
							</div>

							<div class="form-group {{ $errors->has('srjd.*.job_perform') ? 'has-error' : '' }}">
								<input type="textarea" name="srjd[{{ $r++ }}][job_perform]" value="{!! (!empty($srjd->job_perform))?$srjd->job_perform:@$value !!}" id="part_accessory_{{ $rr++ }}" class="form-control" autocomplete="off" placeholder="Job Perform" />
							</div>

							<div class="form-group {{ $errors->has('srjd.*.working_time_start') ? 'has-error' : '' }}">
								<input type="text" name="srjd[{{ $r++ }}][working_time_start]" value="{!! (!empty($srjd->working_time_start))?$srjd->working_time_start:@$value !!}" id="part_accessory_{{ $rr++ }}" class="form-control" autocomplete="off" placeholder="Working Time Start" />
							</div>

							<div class="form-group {{ $errors->has('srjd.*.working_time_end') ? 'has-error' : '' }}">
								<input type="text" name="srjd[{{ $r++ }}][working_time_end]" value="{!! (!empty($srjd->working_time_end))?$srjd->working_time_end:@$value !!}" id="part_accessory_{{ $rr++ }}" class="form-control" autocomplete="off" placeholder="Working Time End" />
							</div>
						</div>
@endforeach
@foreach( $srj->hasmanysrjobdetail()->where('return', 1)->get() as $srjd )
						<div class="row col-sm-12 form-inline">
							<div class="col-sm-1 text-primary">Return<br /><=</div>
							<div class="form-group {{ $errors->has('srjd.*.date') ? 'has-error' : '' }}">
								<input type="text" name="srjd[{{ $r++ }}][date]" value="{!! (!empty($srjd->date))?$srjd->date:@$value !!}" id="part_accessory_{{ $rr++ }}" class="form-control" autocomplete="off" placeholder="Date" />
							</div>

							<div class="form-group {{ $errors->has('srjd.*.labour') ? 'has-error' : '' }}">
								<input type="text" name="srjd[{{ $r++ }}][labour]" value="{!! (!empty($srjd->labour))?$srjd->labour:@$value !!}" id="part_accessory_{{ $rr++ }}" class="form-control" autocomplete="off" placeholder="Labour Count" />
							</div>

							<div class="form-group {{ $errors->has('srjd.*.job_perform') ? 'has-error' : '' }}">
								<input type="textarea" name="srjd[{{ $r++ }}][job_perform]" value="{!! (!empty($srjd->job_perform))?$srjd->job_perform:@$value !!}" id="part_accessory_{{ $rr++ }}" class="form-control" autocomplete="off" placeholder="Job Perform" />
							</div>

							<div class="form-group {{ $errors->has('srjd.*.working_time_start') ? 'has-error' : '' }}">
								<input type="text" name="srjd[{{ $r++ }}][working_time_start]" value="{!! (!empty($srjd->working_time_start))?$srjd->working_time_start:@$value !!}" id="part_accessory_{{ $rr++ }}" class="form-control" autocomplete="off" placeholder="Working Time Start" />
							</div>

							<div class="form-group {{ $errors->has('srjd.*.working_time_end') ? 'has-error' : '' }}">
								<input type="text" name="srjd[{{ $r++ }}][working_time_end]" value="{!! (!empty($srjd->working_time_end))?$srjd->working_time_end:@$value !!}" id="part_accessory_{{ $rr++ }}" class="form-control" autocomplete="off" placeholder="Working Time End" />
							</div>
						</div>
@endforeach
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