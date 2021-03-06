<?php
// load model
use \App\Model\Customer;
use \App\Model\ICSCharge;
use \App\Model\Staff;


$cust = Customer::all();
$ch = ICSCharge::all();
$staff = Staff::where('active', 1)->get();
?>
<div class="col-sm-12">
	<div class="card">
		<div class="card-header" {!! (\Auth::user()->belongtostaff->id == 82)?'style="background-color: #dfe98d"':NULL !!}>Service Report</div>
		<div class="card-body" {!! (\Auth::user()->belongtostaff->id == 82)?'style="background-color: #faffd2"':NULL !!}>

			<div class="row">
				<div class="col form-group {{ $errors->has('date')?'has-error':'' }}">
					{!! Form::text('date', @$value, ['class' => 'form-control', 'id' => 'date', 'placeholder' => 'Date', 'autocomplete' => 'off']) !!}
				</div>
				<div class="col form-group {{ $errors->has('serial')?'has-error':'' }}">
					{!! Form::text('serial', @$value, ['class' => 'form-control', 'id' => 'serial', 'placeholder' => 'Service Report No.', 'autocomplete' => 'off']) !!}
				</div>
			</div>

			<div class="row">
				<div class="col-6">
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

				<div class="col-6">
					<div class="row form-group">
						<label class="col-4" for="inlineRadio2">Informed by : </label>
						<div class="col-8">
							<select name="inform_by" id="inlineRadio2" class="form-control" placeholder="Please choose">
								<option value="">Please choose</option>
@foreach($staff as $st)
								<option value="{!! $st->id !!}">{!! $st->name !!}</option>
@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<br />
<div class="row">
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header" {!! (\Auth::user()->belongtostaff->id == 82)?'style="background-color: #e2baea"':NULL !!}>Customer</div>
			<div class="card-body" {!! (\Auth::user()->belongtostaff->id == 82)?'style="background-color: #fadfff"':NULL !!}>

				<div class="form-group row {{ $errors->has('customer_id')?'has-error':'' }}">
					{{ Form::label( 'cust', 'Customer : ', ['class' => 'col-sm-3 col-form-label'] ) }}
					<div class="col-sm-9">
						<select name="customer_id" id="cust" class="form-control col-sm-12" autocomplete="off">
							<option value="" data-pc="" data-phone="">Please choose</option>
@foreach($cust as $cu)
							<option value="{!! $cu->id !!}" data-pc="{!! $cu->pc !!}" data-phone="{!! $cu->phone !!}">{!! $cu->customer !!}</option>
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
<!-- 			<div class="card-footer">
				<a href="{{ route('customer.create', 'id=0') }}" class="btn btn-primary float-right">Add Customer</a>
			</div> -->
		</div>
	</div>

	<div class="col-sm-6">
		<div class="card">
			<div class="card-header" {!! (\Auth::user()->belongtostaff->id == 82)?'style="background-color: #fcc27e"':NULL !!}>Attended By</div>
			<div class="card-body" {!! (\Auth::user()->belongtostaff->id == 82)?'style="background-color: #ffe6c8"':NULL !!}>

				<div class="container-fluid position_wrap">
				</div>
				<div class="row col-lg-12 add_position">
					<p class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Staff</p>
				</div>

				<div class="container-fluid phoneattendees_wrap">
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
			<div class="div card-header" {!! (\Auth::user()->belongtostaff->id == 82)?'style="background-color: #ffe042"':NULL !!}>Nature Of Complaints</div>
			<div class="card-body" {!! (\Auth::user()->belongtostaff->id == 82)?'style="background-color: #fff5c3"':NULL !!}>

				<div class="form-group row {{ $errors->has('model')?'has-error':'' }}">
					{{ Form::label( 'model', 'Model :', ['class' => 'col-sm-3 col-form-label'] ) }}
					<div class="col-sm-9">
						{!! Form::text('model', @$value, ['class' => 'form-control', 'id' => 'model', 'placeholder' => 'Model', 'autocomplete' => 'off']) !!}
					</div>
				</div>

				<div class="form-group row {{ $errors->has('complaints')?'has-error':'' }}">
					{{ Form::label( 'compl', 'Complaints :', ['class' => 'col-sm-3 col-form-label'] ) }}
					<div class="col-sm-9">
						{!! Form::textarea('complaint', @$value, ['class' => 'form-control', 'id' => 'compl', 'placeholder' => 'Complaints', 'autocomplete' => 'off']) !!}
					</div>
				</div>

				<div class="form-group row {{ $errors->has('status_id')?'has-error':'' }}">
					{{ Form::label( 'compby', 'Requested By :', ['class' => 'col-sm-3 col-form-label'] ) }}
					<div class="col-sm-9">
						{!! Form::text('complaint_by', @$value, ['class' => 'form-control', 'id' => 'compby', 'placeholder' => 'Requested By', 'autocomplete' => 'off']) !!}
					</div>
				</div>

			</div>
		</div>
	</div>

	<div class="col-sm-6">
		<div class="card">
			<div class="div card-header" {!! (\Auth::user()->belongtostaff->id == 82)?'style="background-color: #a2e1fa"':NULL !!}>Remarks</div>
			<div class="card-body" {!! (\Auth::user()->belongtostaff->id == 82)?'style="background-color: #ddf5ff"':NULL !!}>

				<div class="form-group row {{ $errors->has('remarks')?'has-error':'' }}">
					{{ Form::label( 'rem', 'Remarks :', ['class' => 'col-sm-3 col-form-label'] ) }}
					<div class="col-sm-9">
						{!! Form::textarea('remarks', @$value, ['class' => 'form-control', 'id' => 'rem', 'placeholder' => 'Remarks', 'autocomplete' => 'off']) !!}
					</div>
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